<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Person extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'persons';

    protected $appends = [
        'workload'
    ];

    public function resolveRouteBinding($value, $field = null)
    {
        return $this->where($field ?? 'id', $value)->withTrashed()->firstOrFail();
    }

    public function ressortWorkShifts()
    {
        return $this->belongsToMany(RessortWorkShift::class, 'ressort_work_shift_person', 'person_id', 'ressort_work_shift_id')
            ->orderByRaw("CASE
                        WHEN day = 'MO' THEN 'Z'
                        ELSE day
                        END asc")
            ->orderBy('time_start');
    }

    public function ressort()
    {
        return $this->belongsTo(Ressort::class);
    }

    public function ressortCategories()
    {
        return $this->belongsTo(RessortCategory::class);
    }

    public function getWorkloadAttribute()
    {
        $workload = 0;

        $workshifts = $this->ressortWorkShifts;

        foreach ($workshifts as $workshift) {
            $workload += $workshift->time_end - $workshift->time_start;
        }

        return $workload;
    }

    public function scopeFilter($query, array $filters)
    {
        $query->when($filters['search'] ?? null, function ($query, $search) {
            $query->where(function ($query) use ($search) {
                $query
                    ->where($this->table . '.name', 'like', '%' . $search . '%')
                    ->orWhere('phone', 'like', '%' . $search . '%')
                    ->orWhere('email', 'like', '%' . $search . '%')
                    ->orWhere('year', 'like', '%' . $search . '%')
                    ->orWhere('ressort_categories.name', 'like', '%' . $search . '%')
                    ->orWhere('food', 'like', '%' . $search . '%')
                    ->orWhere('allergies', 'like', '%' . $search . '%')
                    ->orWhere('other', 'like', '%' . $search . '%')
                    ->orWhere('note', 'like', '%' . $search . '%');
            });
        })->when($filters['year'] ?? null, function ($query, $value) {
            if ($value == 'none') {
                $query->whereNull('year');
            } else {
                $query->where('year', '=', $value);
            }
        })->when($filters['registered'] ?? null, function ($query, $value) {
            if ($value == 'none') {
                $query->whereNull('registered');
            }
            if ($value == 'yes') {
                $query->where('registered', '=', 1);
            }
            if ($value == 'no') {
                $query->where('registered', '=', 0);
            }
        })->when($filters['friday'] ?? null, function ($query, $value) {
            if ($value == 'none') {
                $query->whereNull('friday');
            }
            if ($value == 'yes') {
                $query->where('friday', '=', 1);
            }
            if ($value == 'no') {
                $query->where('friday', '=', 0);
            }
        })->when($filters['saturday'] ?? null, function ($query, $value) {
            if ($value == 'none') {
                $query->whereNull('saturday');
            }
            if ($value == 'yes') {
                $query->where('saturday', '=', 1);
            }
            if ($value == 'no') {
                $query->where('saturday', '=', 0);
            }
        })->when($filters['sunday'] ?? null, function ($query, $value) {
            if ($value == 'none') {
                $query->whereNull('sunday');
            }
            if ($value == 'yes') {
                $query->where('sunday', '=', 1);
            }
            if ($value == 'no') {
                $query->where('sunday', '=', 0);
            }
        })->when($filters['t_shirt_picked_up'] ?? null, function ($query, $value) {
            if ($value == 'none') {
                $query->whereNull('t_shirt_picked_up');
            }
            if ($value == 'yes') {
                $query->where('t_shirt_picked_up', '=', 1);
            }
            if ($value == 'no') {
                $query->where('t_shirt_picked_up', '=', 0);
            }
        })->when($filters['t_shirt_size'] ?? null, function ($query, $value) {
            if ($value == 'none') {
                $query->whereNull('t_shirt_size');
            } else {
                $query->where('t_shirt_size', '=', $value);
            }
        })->when($filters['food'] ?? null, function ($query, $value) {
            if ($value == 'none') {
                $query->whereNull('food');
            } else {
                $query->where('food', '=', $value);
            }
        })->when($filters['allergies'] ?? null, function ($query, $value) {
            if ($value == 'true') {
                $query->whereNotNull('allergies');
            }
            if ($value == 'false') {
                $query->whereNull('allergies');
            }
        })->when($filters['note'] ?? null, function ($query, $value) {
            if ($value == 'true') {
                $query->whereNotNull('note');
            }
            if ($value == 'false') {
                $query->whereNull('note');
            }
        })->when($filters['other'] ?? null, function ($query, $value) {
            if ($value == 'true') {
                $query->whereNotNull('other');
            }
            if ($value == 'false') {
                $query->whereNull('other');
            }
        })->when($filters['ressort_category_name'] ?? null, function ($query, $value) {
            if ($value == 'none') {
                $query->whereNull('ressort_category_id');
            } else {
                if (is_string($value)) {
                    $value = substr($value, 1);
                    $query->where('ressort_category_id', '=', $value);
                }
            }
        });
    }
}
