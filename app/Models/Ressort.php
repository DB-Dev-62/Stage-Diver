<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Ressort extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'ressorts';


    public function resolveRouteBinding($value, $field = null)
    {
        return $this->where($field ?? 'id', $value)->withTrashed()->firstOrFail();
    }


    public function ressortCategory()
    {
        return $this->belongsTo(RessortCategory::class);
    }

    public function ressortWorkShifts()
    {
        return $this->hasMany(RessortWorkShift::class);
    }

    public function scopeFilter($query, array $filters)
    {
        $query->when($filters['search'] ?? null, function ($query, $search) {
            $query->where(function ($query) use ($search) {
                $query
                    ->where($this->table . '.name', 'like', $search . '%')
                    ->orwhere('ressort_categories.name', 'like', '%' . $search . '%');
            });
        });
    }
}
