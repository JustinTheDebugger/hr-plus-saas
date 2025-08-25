<?php

namespace App\Livewire\Admin\Contracts;

use App\Models\Department;
use Livewire\Component;
use Livewire\WithoutUrlPagination;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination, WithoutUrlPagination;

    public function delete($id)
    {
        Department::find($id)->delete();
        session()->flash('success', 'Department deleted successfully.');
    }

    public function render()
    {
        return view('livewire.admin.contracts.index', [
            'departments' => Department::inCompany()->paginate(5)
        ]);
    }
}
