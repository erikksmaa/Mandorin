<?php

namespace App\Enums;

enum NotificationType: string
{
    case ProgramCreated = 'program_created';

    case ProposalSubmitted = 'proposal_submitted';
    case ProposalApproved = 'proposal_approved';
    case ProposalRevision = 'proposal_revision';
    case ProposalRejected = 'proposal_rejected';

    case ProgramStarted = 'program_started';
    case ProgramCompleted = 'program_completed';
    case ProgramCancelled = 'program_cancelled';

    case ActivitySubmitted = 'activity_submitted';
    case ActivityApproved = 'activity_approved';

    case FinancialSubmitted = 'financial_submitted';
    case FinancialApproved = 'financial_approved';
    case FinancialRevision = 'financial_revision';

    case Reminder = 'reminder';
    case System = 'system';

    public function label(): string
    {
        return match ($this) {
            self::ProgramCreated => 'Program Baru',
            self::ProposalSubmitted => 'Proposal Diajukan',
            self::ProposalApproved => 'Proposal Disetujui',
            self::ProposalRevision => 'Proposal Perlu Revisi',
            self::ProposalRejected => 'Proposal Ditolak',

            self::ProgramStarted => 'Program Dimulai',
            self::ProgramCompleted => 'Program Selesai',
            self::ProgramCancelled => 'Program Dibatalkan',

            self::ActivitySubmitted => 'Logbook Dikirim',
            self::ActivityApproved => 'Logbook Disetujui',

            self::FinancialSubmitted => 'LPJ Diajukan',
            self::FinancialApproved => 'LPJ Disetujui',
            self::FinancialRevision => 'LPJ Perlu Revisi',

            self::Reminder => 'Pengingat',
            self::System => 'Sistem',
        };
    }

    public static function options(): array
    {
        return array_map(fn(self $type) => [
            'value' => $type->value,
            'label' => $type->label(),
        ], self::cases());
    }
}