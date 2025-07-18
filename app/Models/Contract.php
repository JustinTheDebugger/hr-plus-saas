<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Contract extends Model
{
    // Define relationship: Contract belongs to an Employee
    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }

    // Define relationship: Contract belongs to a Designation
    public function designation()
    {
        return $this->belongsTo(Designation::class);
    }

    // Scope: Filter contracts by the current company session
    public function scopeInCompany($query)
    {
        return $query->whereHas('designation', function ($q) {
            $q->inCompany(); // assumes Designation model has scopeInCompany()
        });
    }

    // Accessor: Calculate duration from start to end date in human-readable form
    public function getDurationAttribute()
    {
        return Carbon::parse($this->start_date)->diffForHumans($this->end_date);
    }

    // Scope: Search contracts by employee name (supports partial match)
    public function scopeSearchByEmployee($query, $name)
    {
        return $query->whereHas('employee', function ($q) use ($name) {
            $q->where('name', 'like', "%{$name}%");
        });
    }

    // Calculate total earnings based on rate type
    public function getTotalEarnings($monthYear)
    {
        return $this->rate_type == 'monthly' ? $this->rate : $this->rate * Carbon::parse($monthYear)->daysInMonth;

        // For hourly rate
        // if ($this->rate_type === 'monthly') {
        //     return $this->rate;
        // }

        // if ($this->rate_type === 'daily') {
        //     return $this->working_days($monthYear);
        // }

        // if ($this->rate_type === 'hourly') {
        //     return $this->working_hours($monthYear);
        // }

        // return 0;
    }
}
