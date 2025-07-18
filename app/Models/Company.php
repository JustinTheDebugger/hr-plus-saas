<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    protected $fillable = [
        'name',
        'email',
        'logo',
        'website',
    ];

    // A Company has many Departments
    // A Department has many Designations
    // A Designation has many Employees

    public function users()
    {
        return $this->belongsToMany(User::class, table: 'company_user');
    }

    public function departments()
    {
        return $this->hasMany(Department::class);
    }

    public function designations()
    {
        // Get all designations for a company, go through department
        return $this->hasManyThrough(
            Designation::class,
            Department::class
        );
    }

    public function getLogoUrlAttribute()
    {
        return $this->logo ? asset('storage/' . $this->logo) : asset('images/default-logo.png');
    }
}
