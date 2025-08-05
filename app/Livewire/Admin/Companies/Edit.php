<?php

namespace App\Livewire\Admin\Companies;

use App\Models\Company;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use Livewire\Features\SupportFileUploads\WithFileUploads;

class Edit extends Component
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

    public function mount($id)
    {
        $this->company = Company::find($id);
    }

    public function save()
    {
        $this->validation();
        if ($this->logo) {
            if ($this->company->logo) Storage::disk('public')->delete($this->company->logo);

            $this->company->logo = $this->logo->store('logos', 'public');
        }
        $this->company->save();
        session()->flash('success', 'Company edited successfully.');
        return $this->redirectIntended(route('companies.index'));
    }

    public function render()
    {
        return view('livewire.admin.companies.edit');
    }
}
