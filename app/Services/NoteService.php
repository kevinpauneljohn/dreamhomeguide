<?php

namespace App\Services;

use App\Models\Leads;
use App\Models\Note;
use Yajra\DataTables\Facades\DataTables;

class NoteService
{
    public function noteTypes(): array
    {
        return [

            /* ------------------------------
            |  COMMUNICATION – BLUE
            ------------------------------ */
            'Communication' => [
                ['note_type' => 'Successful Call', 'icon' => 'fa-solid fa-phone', 'icon_color' => '#0d6efd'],
                ['note_type' => 'Follow-Up Call', 'icon' => 'fa-solid fa-phone-volume', 'icon_color' => '#0d6efd'],
                ['note_type' => 'Missed Call', 'icon' => 'fa-solid fa-phone-slash', 'icon_color' => '#0d6efd'],

                ['note_type' => 'Follow-Up Message Sent', 'icon' => 'fa-solid fa-message', 'icon_color' => '#0d6efd'],
                ['note_type' => 'Lead Responded', 'icon' => 'fa-solid fa-comment-dots', 'icon_color' => '#0d6efd'],
                ['note_type' => 'Lead Seen Message But No Reply', 'icon' => 'fa-regular fa-eye', 'icon_color' => '#0d6efd'],

                ['note_type' => 'Email Sent', 'icon' => 'fa-solid fa-envelope', 'icon_color' => '#0d6efd'],
                ['note_type' => 'Email Follow-Up', 'icon' => 'fa-regular fa-envelope-open', 'icon_color' => '#0d6efd'],

                ['note_type' => 'Viber/Messenger Conversation Logged', 'icon' => 'fa-brands fa-facebook-messenger', 'icon_color' => '#0d6efd'],
                ['note_type' => 'WhatsApp Update', 'icon' => 'fa-brands fa-whatsapp', 'icon_color' => '#25D366'],

                ['note_type' => 'SMS Sent', 'icon' => 'fa-regular fa-comment', 'icon_color' => '#0d6efd'],
                ['note_type' => 'SMS Follow-Up', 'icon' => 'fa-regular fa-comment-dots', 'icon_color' => '#0d6efd'],
            ],

            /* ------------------------------
            |  LEAD PROGRESS – PURPLE
            ------------------------------ */
            'Lead Progress' => [
                ['note_type' => 'Initial Interest Note', 'icon' => 'fa-solid fa-star', 'icon_color' => '#6f42c1'],
                ['note_type' => 'Qualification Update', 'icon' => 'fa-solid fa-check-circle', 'icon_color' => '#6f42c1'],
                ['note_type' => 'Budget Clarification', 'icon' => 'fa-solid fa-wallet', 'icon_color' => '#6f42c1'],
                ['note_type' => 'Location Preference Update', 'icon' => 'fa-solid fa-map-pin', 'icon_color' => '#6f42c1'],
                ['note_type' => 'Timeline Update', 'icon' => 'fa-solid fa-clock', 'icon_color' => '#6f42c1'],
                ['note_type' => 'Lead Needs More Time', 'icon' => 'fa-regular fa-hourglass', 'icon_color' => '#6f42c1'],
                ['note_type' => 'Lead Not Qualified', 'icon' => 'fa-solid fa-circle-xmark', 'icon_color' => '#6f42c1'],
                ['note_type' => 'Re-Engagement Attempt', 'icon' => 'fa-solid fa-rotate', 'icon_color' => '#6f42c1'],
                ['note_type' => 'Lead Reconnected (Dormant Lead Contacted Again)', 'icon' => 'fa-solid fa-handshake-simple', 'icon_color' => '#6f42c1'],
                ['note_type' => 'Switching Project Recommendation', 'icon' => 'fa-solid fa-arrow-right-arrow-left', 'icon_color' => '#6f42c1'],
            ],

            /* ------------------------------
            |  PROPERTY VIEWING – GREEN
            ------------------------------ */
            'Property Viewing & Tripping' => [
                ['note_type' => 'Site Viewing Scheduled', 'icon' => 'fa-solid fa-calendar-check', 'icon_color' => '#198754'],
                ['note_type' => 'Site Viewing Rescheduled', 'icon' => 'fa-solid fa-calendar-day', 'icon_color' => '#198754'],
                ['note_type' => 'Site Viewing Completed', 'icon' => 'fa-solid fa-calendar-circle-check', 'icon_color' => '#198754'],
                ['note_type' => 'Client No-Show on Viewing', 'icon' => 'fa-solid fa-person-walking-arrow-loop-left', 'icon_color' => '#198754'],
                ['note_type' => 'Client Feedback After Viewing', 'icon' => 'fa-solid fa-comments', 'icon_color' => '#198754'],
                ['note_type' => 'Second Viewing Scheduled', 'icon' => 'fa-solid fa-calendar-plus', 'icon_color' => '#198754'],
                ['note_type' => 'Neighborhood Tour Completed', 'icon' => 'fa-solid fa-location-dot', 'icon_color' => '#198754'],
            ],

            /* ------------------------------
            |  DOCUMENTS – ORANGE
            ------------------------------ */
            'Document & Requirements' => [
                ['note_type' => 'Requirements Requested', 'icon' => 'fa-regular fa-file', 'icon_color' => '#fd7e14'],
                ['note_type' => 'Requirements Submitted', 'icon' => 'fa-solid fa-file-upload', 'icon_color' => '#fd7e14'],
                ['note_type' => 'Requirements Incomplete', 'icon' => 'fa-solid fa-file-circle-exclamation', 'icon_color' => '#fd7e14'],
                ['note_type' => 'COE / Payslips Needed', 'icon' => 'fa-solid fa-file-invoice', 'icon_color' => '#fd7e14'],
                ['note_type' => 'ID / Proof of Billing Submitted', 'icon' => 'fa-solid fa-id-card', 'icon_color' => '#fd7e14'],
                ['note_type' => 'Document Verification Completed', 'icon' => 'fa-solid fa-file-circle-check', 'icon_color' => '#fd7e14'],
            ],

            /* ------------------------------
            |  LOAN & FINANCING – TEAL
            ------------------------------ */
            'Loan & Financing' => [
                ['note_type' => 'Pag-IBIG Loan Process Started', 'icon' => 'fa-solid fa-building-columns', 'icon_color' => '#20c997'],
                ['note_type' => 'Bank Loan Process Started', 'icon' => 'fa-solid fa-landmark', 'icon_color' => '#20c997'],
                ['note_type' => 'Loan Requirements Follow-Up', 'icon' => 'fa-solid fa-file-signature', 'icon_color' => '#20c997'],
                ['note_type' => 'Loan Evaluation Update', 'icon' => 'fa-solid fa-clipboard-check', 'icon_color' => '#20c997'],
                ['note_type' => 'Loan Approved', 'icon' => 'fa-solid fa-circle-check', 'icon_color' => '#20c997'],
                ['note_type' => 'Loan Declined', 'icon' => 'fa-solid fa-circle-xmark', 'icon_color' => '#20c997'],
                ['note_type' => 'Loan Reconsideration Requested', 'icon' => 'fa-solid fa-rotate-left', 'icon_color' => '#20c997'],
            ],

            /* ------------------------------
            |  RESERVATION – GOLD
            ------------------------------ */
            'Reservation' => [
                ['note_type' => 'Reservation Discussion', 'icon' => 'fa-solid fa-comments-dollar', 'icon_color' => '#ffc107'],
                ['note_type' => 'Reservation Pending', 'icon' => 'fa-solid fa-hourglass-half', 'icon_color' => '#ffc107'],
                ['note_type' => 'Client Preparing Reservation Fee', 'icon' => 'fa-solid fa-money-bill-wave', 'icon_color' => '#ffc107'],
                ['note_type' => 'Reservation Fee Paid', 'icon' => 'fa-solid fa-money-check-dollar', 'icon_color' => '#ffc107'],
                ['note_type' => 'Unit Reserved', 'icon' => 'fa-solid fa-bookmark', 'icon_color' => '#ffc107'],
                ['note_type' => 'Reservation Cancelled / Forfeited', 'icon' => 'fa-solid fa-ban', 'icon_color' => '#ffc107'],
            ],

            /* ------------------------------
            |  INTERNAL – SLATE GRAY
            ------------------------------ */
            'Broker / Internal' => [
                ['note_type' => 'Agent Assignment Change', 'icon' => 'fa-solid fa-user-check', 'icon_color' => '#6c757d'],
                ['note_type' => 'Lead Transferred to Another Agent', 'icon' => 'fa-solid fa-user-arrows', 'icon_color' => '#6c757d'],
                ['note_type' => 'Manager Follow-Up Required', 'icon' => 'fa-solid fa-user-tie', 'icon_color' => '#6c757d'],
                ['note_type' => 'Sensitive Client Concern Logged', 'icon' => 'fa-solid fa-circle-exclamation', 'icon_color' => '#6c757d'],
                ['note_type' => 'Internal Issue / Note (Private)', 'icon' => 'fa-solid fa-lock', 'icon_color' => '#6c757d'],
            ],

            /* ------------------------------
            |  POST-SALE – SUCCESS GREEN
            ------------------------------ */
            'Post-sale' => [
                ['note_type' => 'Move-In Orientation Scheduled', 'icon' => 'fa-solid fa-house-circle-check', 'icon_color' => '#28a745'],
                ['note_type' => 'Turnover Date Update', 'icon' => 'fa-solid fa-key', 'icon_color' => '#28a745'],
                ['note_type' => 'Punch list Concerns Logged', 'icon' => 'fa-solid fa-list-check', 'icon_color' => '#28a745'],
                ['note_type' => 'Buyer Requested After-Sales Support', 'icon' => 'fa-solid fa-headset', 'icon_color' => '#28a745'],
            ],

            /* ------------------------------
            |  OBJECTION – RED
            ------------------------------ */
            'Objection & Concern' => [
                ['note_type' => 'Pricing Objection', 'icon' => 'fa-solid fa-tag', 'icon_color' => '#dc3545'],
                ['note_type' => 'Location Objection', 'icon' => 'fa-solid fa-map-location-dot', 'icon_color' => '#dc3545'],
                ['note_type' => 'Unit Size Objection', 'icon' => 'fa-solid fa-ruler-combined', 'icon_color' => '#dc3545'],
                ['note_type' => 'Client Exploring Competitor Property', 'icon' => 'fa-solid fa-compass', 'icon_color' => '#dc3545'],
                ['note_type' => 'Client Not Ready', 'icon' => 'fa-solid fa-hourglass-end', 'icon_color' => '#dc3545'],
                ['note_type' => 'Client Paused Search (Personal Reason)', 'icon' => 'fa-solid fa-circle-pause', 'icon_color' => '#dc3545'],
            ],

            /* ------------------------------
            |  COLD LEAD – DARK BLUE
            ------------------------------ */
            'Cold / Lost Lead' => [
                ['note_type' => 'Lead Went Cold', 'icon' => 'fa-solid fa-snowflake', 'icon_color' => '#0a58ca'],
                ['note_type' => 'Wrong Number / Dummy Account', 'icon' => 'fa-solid fa-triangle-exclamation', 'icon_color' => '#0a58ca'],
                ['note_type' => 'Duplicate Lead', 'icon' => 'fa-solid fa-copy', 'icon_color' => '#0a58ca'],
                ['note_type' => 'Lead Bought Another Property', 'icon' => 'fa-solid fa-house-circle-xmark', 'icon_color' => '#0a58ca'],
                ['note_type' => 'Not Interested Anymore', 'icon' => 'fa-regular fa-circle-stop', 'icon_color' => '#0a58ca'],
                ['note_type' => 'Lead Unreachable', 'icon' => 'fa-solid fa-person-circle-question', 'icon_color' => '#0a58ca'],
            ],

            /* ------------------------------
            |  Connection / Network – Orange
            ------------------------------ */
            'Connection / Network' => [
                ['note_type' => 'Referral', 'icon' => 'bi bi-gift-fill', 'icon_color' => '#fd7e14'],
            ],

        ];
    }


    public function findNoteType(string $type): ?array
    {
        foreach ($this->noteTypes() as $category => $items) {
            foreach ($items as $item) {
                if ($item['note_type'] === $type) {
                    return [
                        'category'   => $category,
                        'note_type'  => $item['note_type'],
                        'icon'       => $item['icon'],
                        'icon_color' => $item['icon_color'],
                    ];
                }
            }
        }

        return null;
    }

    public function saveNote(array $data): \Illuminate\Http\JsonResponse
    {
        return Note::create($data) ?
            response()->json(['success' => true, 'message' => 'Note saved successfully.']) :
            response()->json(['success' => false, 'message' => 'Note could not be saved.']);
    }
    public function getNotes($lead_id): \Illuminate\Http\JsonResponse
    {

        $query = Note::where('lead_id', $lead_id)->orderBy('created_at', 'desc');
        return DataTables::of($query)
            ->addColumn('icon', function ($note) {
                return $this->findNoteType($note->type);
            })
            ->addColumn('title', function ($note) {
                return [
                    'type' => $note->type,
                    'description' => $note->description,
                ];
            })
            ->editColumn('created_at', function ($note) {
                return $note->created_at->format('M d, Y • g:i A');
            })
            ->editColumn('user_id', content: function ($note) {
                return $note->user->full_name ?? 'N/A';
            })
            ->addColumn('action', content: function ($note) {
                return [
                    'edit' => (bool)auth()->user()->can('edit note'),
                    'delete' => (bool)auth()->user()->can('delete note'),
                    'id' => $note->id
                ];
            })
            ->make(true);
    }

    private function allowed_to_edit_or_delete_note(Note $note): bool
    {
        return $note->user_id == auth()->id();
    }
}
