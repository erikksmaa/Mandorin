<?php

namespace App\Enums;

enum CommunityReportReason: string
{
    case Spam = 'spam';
    case Hoax = 'hoax';
    case HateSpeech = 'hate_speech';
    case Violence = 'violence';
    case Pornography = 'pornography';
    case Other = 'other';

    public function label(): string
    {
        return match ($this) {
            self::Spam => 'Spam',
            self::Hoax => 'Hoaks',
            self::HateSpeech => 'Ujaran Kebencian',
            self::Violence => 'Kekerasan',
            self::Pornography => 'Pornografi',
            self::Other => 'Lainnya',
        };
    }

    public static function options(): array
    {
        return collect(self::cases())
            ->mapWithKeys(fn ($item) => [
                $item->value => $item->label(),
            ])
            ->toArray();
    }
}