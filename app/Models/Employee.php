<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    protected $fillable = [
        'name',
        'email',
        'phone',
        'designation_id',
        'address',
    ];

    public function designation()
    {
        return $this->belongsTo(Designation::class);
    }

    public function department()
    {
        return $this->designation->department;
    }

    public function scopeSearchByName($query, $name)
    {
        return $query->where('name', 'like', '%' . $name . '%');
    }

    public function salaries()
    {
        return $this->hasMany(Salary::class);
    }

    public function payments()
    {
        return $this->hasMany(Payment::class);
    }

    public function contracts()
    {
        return $this->hasMany(Contract::class);
    }

    public function getActiveContract($start_date = null, $end_date = null)
    {
        $start_date = $start_date ?? now();
        $end_date = $end_date ?? now();
        // return $this->contracts()->where('start_date', '<=', $start_date)->where('end_date', '>=', $end_date)->first();

        return $this->contracts()
            ->where('start_date', '<=', $start_date)
            ->where(function ($query) use ($end_date) {
                $query->whereNull('end_date')
                    ->orWhere('end_date', '>=', $end_date);
            })
            ->orderByDesc('start_date')
            ->first();
    }
}
