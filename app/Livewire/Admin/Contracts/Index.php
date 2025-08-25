<?php

namespace App\Livewire\Admin\Contracts;

use App\Models\Department;
use Livewire\Component;

class Index extends Component
{
    public function render()
    {
        return view('livewire.admin.contracts.index', [
            'departments' => Department::inCompany()->paginate(5)
        ]);
    }
}
