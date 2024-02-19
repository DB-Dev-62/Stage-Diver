<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Account extends Model
{
    public function users()
    {
        return $this->hasMany(User::class);
    }

    public function organizations()
    {
        return $this->hasMany(Organization::class);
    }

    public function guests()
    {
        return $this->hasMany(Guest::class);
    }

    public function persons()
    {
        return $this->hasMany(Person::class);
    }

    public function ressorts()
    {
        return $this->hasMany(Ressort::class);
    }

    public function ressortCategories()
    {
        return $this->hasMany(RessortCategory::class);
    }

    public function ressortWorkShifts()
    {
        return $this->hasMany(RessortWorkShift::class);
    }

    public function contacts()
    {
        return $this->hasMany(Contact::class);
    }

}
