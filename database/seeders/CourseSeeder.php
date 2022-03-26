<?php

namespace Database\Seeders;

use App\Models\Course;
use Illuminate\Database\Seeder;

class CourseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //

        $bachelors = [
            'Bachelor of Science in Accountancy',
            'Bachelor of Science in Management Accounting',
            'Bachelor of Science in Business Administration Major in Financial Management',
            'Bachelor of Science in Architecture',
            'Bachelor of Science and Interior Design',
            'Bachelor of Arts in English Language Studies',
            'Bachelor of Arts in Filipino',
            'Bachelor of Arts Literary and Cultural Studies',
            'Bachelor of Arts in Philosophy',
            'Bachelor of Performing Arts Major in Theater Arts',
            'Bachelor of Science and Business Administration Major in Human Resource Management',
            'Bachelor of Science in Business Administration Major in Marketing Management',
            'Bachelor of Enterpreneurship',
            'Bachelor of Science Office Administration',
            'Bachelor in Advertising and Public Relations',
            'Bachelor of Arts in Broadcasting',
            'Bachelor of Arts in Communication Research',
            'Bachelor of Arts in Journalism',
            'Bachelor of Science in Computer Science',
            'Bachelor of Science in Information Technology',
            'Bachelor in Elementary Education',
            'Bachelor in Library and Information Science',
            'Bachelor of Secondary Education Major in English',
            'Bachelor of Secondary Education Major in Filipino',
            'Bachelor of Secondary Education Major in Mathematics',
            'Bachelor of Secondary Education Major in Science',
            'Bachelor of Secondary Education Major in Social Studies',
            'Bachelor of Science in Civil Engineering',
            'Bachelor of Science in Computer Engineering',
            'Bachelor of Science in Electrical Engineering',
            'Bachelor of Science in Electronics Engineering',
            'Bachelor of Science in Industrial Engineering',
            'Bachelor of Science in Mechanical Engineering',
            'Bachelor of Physcial Education',
            'Bachelor of Science in Exercises and Sports',
            'Bachelor of Public Administration',
            'Bachelor of Arts in International Studies',
            'Bachelor of Arts in Political Economy',
            'Bachelor of Arts in Political Science',
            'Bachelor of Science in Economics',
            'Bachelor of Science in Psychology',
            'Bachelor of Science Food Technology',
            'Bachelor of Science in Applied Mathematics',
            'Bachelor of Science in Biology',
            'Bachelor of Science in Chemistry',
            'Bachelor of Science in Mathematics',
            'Bachelor of Science in Nutrition and Dietetics',
            'Bachelor of Science in Physics',
            'Bachelor of Science in Statistics',
            'Bachelor of Science in Hospitality Management',
            'Bachelor of Science in Tourism Management',
            'Bachelor of Science in Transportation Management',
        ];

        $masters = [
            'Master of Arts',
            'Master of Science',
            'Master of Research',
            'Master of Studies',
            'Master of Business Administration',
            'Master of Library Science',
            'Master of Public Administration',
            'Master of Public Health',
            'Master of Social Work',
            'Master of Arts in Liberal Studies',
            'Master of Fine Arts',
            'Master of Music',
            'Master of Education',
            'Master of Engineering',
            'Master of Architecture',
        ];

        $doctors = [
            'PhD in Educational Administration',
            'PhD in Education',
            'PhD in Philosophy',
            'PhD in Pscychology',
            'PhD in Science Education',
            'PhD in Science Education',
            'PhD in Biology',
            'PhD in Computer Science',
            'PhD in Mathematics',
            'PhD in Electronics Engineering',
            'PhD in Chemistry',
            'PhD in Chemical Engineering',
            'PhD in Business Management',
            'PhD in Development Administration',
            'PhD in Agricultural Sciences',
            'PhD in Communication',
        ];

        foreach ($bachelors as $course) {
            Course::create([
                "course" => $course,
                "course_type" => "bachelor"
            ]);
        }
        foreach ($masters as $course) {
            Course::create([
                "course" => $course,
                "course_type" => "master"
            ]);
        }
        foreach ($doctors as $course) {
            Course::create([
                "course" => $course,
                "course_type" => "doctor"
            ]);
        }

    }
}
