<?php

namespace Database\Seeders;

use App\Models\JobSpecialization;
use Illuminate\Database\Seeder;

class JobSpecializationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $specializations = [
            'Accountancy, banking and finance',
            'Business, consulting and management',
            'Charity and voluntary work',
            'Creative arts and design',
            'Energy and utilities',
            'Engineering and manufacturing',
            'Environment and agriculture',
            'Healthcare',
            'Hospitality and events management',
            'Information and Technology',
            'Law',
            'Law enforcement and security',
            'Leisure, sports and tourism',
            'Marketing, advertising and PR',
            'Media and internet',
            'Property and construction',
            'Public services and administration',
            'Recruitment and HR',
            'Retail',
            'Sales',
            'Science and pharmaceuticals',
            'Social care',
            'Teacher training and education',
            'Transport and logisctics',
            'Entertainment',
            'Education/Training'
        ];

        foreach ($specializations as $spec) {
            JobSpecialization::create([
                'specialization' => $spec
            ]);
        }
    }
}
