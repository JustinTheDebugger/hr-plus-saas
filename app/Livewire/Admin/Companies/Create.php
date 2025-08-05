<?php

namespace App\Livewire\Admin\Companies;

use App\Models\Company;
use Livewire\Component;
use Livewire\Features\SupportFileUploads\WithFileUploads;

class Create extends Component
{
    use WithFileUploads;

    // define variables
    public $company;
    public $logo;

    public function rules()
    {
        return [
            'company.name' => 'required|string|max:255',
            'company.email' => 'required|email|max:255',
            'company.website' => 'nullable|url|max:255',
            'logo' => 'nullable|image|mimes:jpeg,png,jpg|max"2048',
        ];
    }

    public function mount()
    {
        // this company is equal to a new company
        $this->company = new Company();
    }

    public function save()
    {
        $this->validation();
        if ($this->logo) {
            $this->company->logo = $this->logo->store('logos', 'public');
        }
        $this->company->save();
        session()->flash('success', 'Company created successfully.');
        return $this->redirectIntended(route('companies.index'));
    }

    public function render()
    {
        return view('livewire.admin.companies.create');
    }
}
