<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Guest extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $casts = [
        'days' => 'array',
    ];

    public function resolveRouteBinding($value, $field = null)
    {
        return $this->where($field ?? 'id', $value)->withTrashed()->firstOrFail();
    }


    public function scopeFilter($query, array $filters)
    {
        $query->when($filters['search'] ?? null, function ($query, $search) {
            $query->where('name', 'like', '%' . $search . '%')
                ->orWhere('days', 'like', '%' . $search . '%')
                ->orWhere('number_of_person', 'like', '%' . $search . '%')
                ->orWhere('note', 'like', '%' . $search . '%');


        })->when($filters['day'] ?? null, function ($query, $day) {
            $query->where('days', 'like', '%' . $day . '%');
        });
    }
}
