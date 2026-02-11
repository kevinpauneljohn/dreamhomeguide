<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Carbon;
use App\Models\Leads;
use Symfony\Component\Console\Command\Command as CommandAlias;

class UpdateLeadStatus extends Command
{
    protected $signature = 'leads:update-statuses';

    protected $description = 'Update lead statuses based on inactivity without re-updating already processed leads';

    public function handle(): int
    {
        $now = Carbon::now();

        $this->info('Running lead status automation...');

        Leads::whereNull('deleted_at')
            ->chunkById(200, function ($leads) use ($now) {

                foreach ($leads as $lead) {

                    $currentStatus = $lead->status;
                    $targetStatus  = null;

                    /* -------------------------------------------------
                     | PRIORITY 0: FOLLOW-UP → COLD (7 days inactivity)
                     ------------------------------------------------- */
                    if (
                        $currentStatus === 'follow-up' &&
                        $lead->updated_at->lte($now->copy()->subDays(7))
                    ) {
                        $targetStatus = 'cold';
                    }

                    /* -------------------------------------------------
                     | PRIORITY 1: COLD (7+ days from created_at)
                     ------------------------------------------------- */
                    elseif (
                        in_array($currentStatus, ['new', 'hot', 'warm'], true) &&
                        $lead->created_at->lte($now->copy()->subDays(7))
                    ) {
                        $targetStatus = 'cold';
                    }

                    /* -------------------------------------------------
                     | PRIORITY 2: WARM (3 days from created_at)
                     ------------------------------------------------- */
                    elseif (
                        in_array($currentStatus, ['new', 'hot'], true) &&
                        $lead->created_at->lte($now->copy()->subDays(3))
                    ) {
                        $targetStatus = 'warm';
                    }

                    /* -------------------------------------------------
                     | PRIORITY 3: FOLLOW-UP (2 days from updated_at)
                     ------------------------------------------------- */
                    elseif (
                        in_array($currentStatus, [
                            'for-tripping',
                            'tripping-done',
                            'for-reservation'
                        ], true) &&
                        $lead->updated_at->lte($now->copy()->subDays(2))
                    ) {
                        $targetStatus = 'follow-up';
                    }

                    /* -------------------------------------------------
                     | SAFETY: Skip if no change
                     ------------------------------------------------- */
                    if (!$targetStatus || $currentStatus === $targetStatus) {
                        continue;
                    }

                    $lead->update([
                        'status' => $targetStatus,
                    ]);

                    $this->line("Lead {$lead->id}: {$currentStatus} → {$targetStatus}");
                }
            });

        $this->info('Lead status update completed.');

        return CommandAlias::SUCCESS;
    }
}
