<?php

namespace Database\Factories;

use App\Models\Leads;
use App\Models\Task;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Task>
 */
class TaskFactory extends Factory
{
    protected $model = Task::class;

    public function definition(): array
    {
        $statuses = ['pending', 'in progress', 'completed', 'overdue'];
        $status   = $this->faker->randomElement($statuses);

        // Due date logic based on status
        $dueDate = match ($status) {
            'completed' => $this->faker->dateTimeBetween('-7 days', '-1 day'),
            'overdue'   => $this->faker->dateTimeBetween('-5 days', '-1 hour'),
            default     => $this->faker->dateTimeBetween('now', '+7 days'),
        };

        return [
            'title' => $this->faker->randomElement([
                'Follow-up client inquiry',
                'Prepare site viewing documents',
                'Send sample computation',
                'Confirm site viewing schedule',
                'Financing follow-up',
                'Update lead details',
            ]),

            'description' => $this->faker->optional()->sentence(10),

            'due_date' => $dueDate,

            // Creator
            'user_id' => User::query()->inRandomOrder()->value('id'),

            // Optional lead
            'lead_id' => $this->faker->boolean(70)
                ? Leads::query()->inRandomOrder()->value('id')
                : null,

            // Assigned agent
            'assigned_to' => User::query()->inRandomOrder()->value('id'),

            'priority' => $this->faker->randomElement(['low', 'medium', 'high']),

            'is_public' => $this->faker->boolean(30),

            'status' => $status,
        ];
    }

    /* -----------------------------
     | STATES (Optional but Useful)
     |------------------------------*/

    public function highPriority(): self
    {
        return $this->state(fn () => [
            'priority' => 'high',
        ]);
    }

    public function overdue(): self
    {
        return $this->state(fn () => [
            'status'   => 'overdue',
            'due_date' => now()->subDays(rand(1, 5)),
        ]);
    }

    public function completed(): self
    {
        return $this->state(fn () => [
            'status'   => 'completed',
            'due_date' => now()->subDays(rand(1, 3)),
        ]);
    }

    public function public(): self
    {
        return $this->state(fn () => [
            'is_public' => true,
        ]);
    }

    public function private(): self
    {
        return $this->state(fn () => [
            'is_public' => false,
        ]);
    }

}
