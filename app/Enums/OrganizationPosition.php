<?php

namespace App\Enums;

enum OrganizationPosition: string
{
    case Ketua = 'Ketua';
    case Sekretaris = 'Sekretaris';
    case Bendahara = 'Bendahara';
    case Koordinator = 'Koordinator';
    case Anggota = 'Anggota';

    public function label(): string
    {
        return $this->value;
    }
}