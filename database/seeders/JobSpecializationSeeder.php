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
            'Agribusiness',
            'Animal and Aquaculture Management',
            'Environmental Services',
            'Food Production',
            'Natural Resources',
            'Crops and Plants',
            'Power, Structural, and Technical Systems',
            'Construction',
            'Pre-Construction and Design',
            'Maintenance and Operations',
            'Audio and Visual Technology',
            'Journalism and Broadcasting',
            'Performing Arts',
            'Printing Technology',
            'Telecommunications',
            'Visual Art and Design',
            'Administrative Support',
            'Business Analysis',
            'Finance and Accounting',
            'Human Resources',
            'Management',
            'Advertising and Marketing',
            'Education Administration',
            'Professional Support Services',
            'Teaching and Training',
            'Banking',
            'Financial Analysis',
            'Financial and Investment Planning',
            'Insurance',
            'Public Planning',
            'Public Administration and Governance',
            'Public Regulation',
            'Revenue and Taxation',
            'Medical Science and Biotechnology',
            'Diagnosis and Treatment',
            'Medical Administratioin and Support Services',
            'Therapy and Natural Healing',
            'Lodging',
            'Recreation, Amusements, and Attractions',
            'Food and Beverage Services',
            'Travel and Tourism',
            'Counseling and Mental Health Services',
            'Early Childhood Development and Services',
            'Family and Community Services',
            'Personal Services',
            'Information Technology and Services',
            'Network Systems',
            'Programming and Software Development',
            'Corrections',
            'Fire and Emergency Services',
            'Law Enforcement Services',
            'Legal Services',
            'Security and Protective Services',
            'Maintenance, Installation, and Repair',
            'Production',
            'Quality Assurance, Inspection, and Testing',
            'Buying and Merchandising',
            'Sales Operations',
            'Marketing Operations',
            'Mechanical Engineering',
            'Civil Engineering',
            'Chemical and Material Engineering',
            'Electrical and Electronics Engineering',
            'Energy and Natural Resource Engineering',
            'Industrial Engineering',
            'Life and Environmental Sciences',
            'Mathematics and Social Sciences',
            'Physical Sciences',
            'Mobile Equipment Maintenance',
            'Distribution and Logistics',
            'Transportation Operations',
            'Warehousing and Distribution Center Operations'
        ];

        foreach ($specializations as $spec) {
            JobSpecialization::create([
                'specialization' => $spec
            ]);
        }
    }
}
