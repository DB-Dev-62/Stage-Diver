<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class RessortWorkShift extends Model
{
    use HasFactory;
    use SoftDeletes;

    // deleted_at

    public $timestamps = true; // created_at & updated_at


    public function resolveRouteBinding($value, $field = null)
    {
        return $this->where($field ?? 'id', $value)->withTrashed()->firstOrFail();
    }

    public function ressort()
    {
        return $this->belongsTo(Ressort::class);
    }

    public function persons()
    {
        return $this->belongsToMany(Person::class, 'ressort_work_shift_person', 'ressort_work_shift_id', 'person_id')
            ->select(['id', 'name', 'workload', 'is_optional'])
            ->orderBy('is_optional')
            ->withPivot(['is_optional']);
    }

    public function scopeFilter($query, array $filters)
    {
        $query->when($filters['search'] ?? null, function ($query, $search) {
            $query->where(function ($query) use ($search) {
                $query->where('ressort_id', 'like', '%' . $search . '%')
                    ->orWhere('day', 'like', '%' . $search . '%')
                    ->orWhere('time_start', 'like', '%' . $search . '%')
                    ->orWhere('time_end', 'like', '%' . $search . '%')
                    ->orWhere('supporter_min', 'like', '%' . $search . '%')
                    ->orWhere('supporter_max', 'like', '%' . $search . '%');
            });
        })->when($filters['trashed'] ?? null, function ($query, $trashed) {
            if ($trashed === 'with') {
                $query->withTrashed();
            } elseif ($trashed === 'only') {
                $query->onlyTrashed();
            }
        });
    }
}
