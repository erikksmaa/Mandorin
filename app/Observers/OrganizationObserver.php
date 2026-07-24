<?php

namespace App\Observers;

use App\Models\Organization;
use Illuminate\Support\Str;

class OrganizationObserver
{
    /**
     * Auto-generate organization_code and slug before Organization is created.
     * Format Code: ORG-YYYYMM-NNN (e.g. ORG-202607-001)
     */
    public function creating(Organization $organization): void
    {
        if (empty($organization->organization_code)) {
            $prefix = 'ORG-' . now()->format('Ym') . '-';

            $count = Organization::withTrashed()
                ->where('organization_code', 'like', $prefix . '%')
                ->count();

            $nextNumber = $count + 1;

            do {
                $code = $prefix . str_pad($nextNumber, 3, '0', STR_PAD_LEFT);
                $exists = Organization::withTrashed()->where('organization_code', $code)->exists();
                if ($exists) {
                    $nextNumber++;
                }
            } while ($exists);

            $organization->organization_code = $code;
        }

        if (empty($organization->slug)) {
            $baseSlug = Str::slug($organization->name);
            $slug = $baseSlug;
            $count = 1;

            while (Organization::withTrashed()->where('slug', $slug)->exists()) {
                $slug = "{$baseSlug}-{$count}";
                $count++;
            }

            $organization->slug = $slug;
        }
    }

    public function updating(Organization $organization): void
    {
        if ($organization->isDirty('name') && empty($organization->slug)) {
            $baseSlug = Str::slug($organization->name);
            $slug = $baseSlug;
            $count = 1;

            while (Organization::withTrashed()->where('slug', $slug)->where('id', '!=', $organization->id)->exists()) {
                $slug = "{$baseSlug}-{$count}";
                $count++;
            }

            $organization->slug = $slug;
        }
    }
}
