<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Department extends Model
{
    protected $fillable = [
        'name',
        'company_id',
    ];

    // A Department belongs to one company
    // A Department has many Designations
    // A Designation has many Employees

    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    public function designations()
    {
        return $this->hasMany(Designation::class);
    }

    // To get employees for this department, go through its designations
    public function employees()
    {
        return $this->hasManyThrough(Employee::class, Designation::class);
    }

    // Filters the departments to only those that belong to the currently active company
    public function scopeInCompany($query)
    {
        return $query->where('company_id', session('company_id'));
    }
}
