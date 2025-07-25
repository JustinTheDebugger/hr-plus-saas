<?php

namespace Database\Seeders;

use App\Models\Company;
use App\Models\Department;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DepartmentsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Retrieve companies after creation
        $companies = Company::all();

        foreach ($companies as $company) {
            $company->departments()->createMany(records: [
                [
                    'name' => 'Engineering',
                ],
                [
                    'name' => 'Human Resources',
                ],
                [
                    'name' => 'Finance',
                ],
                [
                    'name' => 'Marketing',
                ],
            ]);
        }

        // Retrieve departments after creation
        $departments = Department::all();

        foreach ($departments as $department) {
            switch ($department->name) {
                case 'Engineering':
                    $designations = [
                        'Software Engineer',
                        'Senior Software Engineer',
                        'Engineering Manager',
                        'Director of Engineering',
                    ];
                    break;

                case 'Human Resources':
                    $designations = [
                        'HR Coordinator',
                        'HR Manager',
                        'HR Director',
                        'VP of HR',
                    ];
                    break;

                case 'Finance':
                    $designations = [
                        'Accountant',
                        'Senior Accountant',
                        'Finance Manager',
                        'Chief Financial Officer',
                    ];
                    break;

                case 'Marketing':
                    $designations = [
                        'Marketing Specialist',
                        'Marketing Manager',
                        'Director of Marketing',
                        'VP of Marketing',
                    ];
                    break;

                default:
                    $designations = [];
                    break;
            }

            foreach ($designations as $designation) {
                $department->designations()->create([
                    'name' => $designation,
                ]);
            }
        }
    }
}
