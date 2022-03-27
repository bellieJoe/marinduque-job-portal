<?php

namespace Database\Seeders;

use App\Models\Employer;
use App\Models\Seeker;
use App\Models\User;
use Faker\Factory;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $faker = Factory::create('en_PH');

        $usersData = [
            // all users are verified by email by default
            // admin
            [
                'email' => 'jobportaldummy@gmail.com',
                'password' => 'password',
                'role' => 'admin',
                'admin_role' => 'master'
            ],
            // employers
            [
                'email' => 'psamduque@pubh.site',
                'password' => 'password',
                'role' => 'employer',
                'company_name' => 'Philippines Statistics Authority - Marinduque',
                'description' => null,
                'mission' => null,
                'vision' => null,
                'address' => null,
                'contact_number' => $faker->mobileNumber(),
                'contact_person_name' => $faker->firstName.' '.$faker->lastName.' '.$faker->lastName,
                'verified' => '1',
            ],
            [
                'email' => 'mercurydrugs@pubh.site',
                'password' => 'password',
                'role' => 'employer',
                'company_name' => 'Mercury Drug Store - Sta. Cruz',
                'description' => null,
                'mission' => null,
                'vision' => null,
                'address' => null,
                'contact_number' => $faker->mobileNumber(),
                'contact_person_name' => $faker->firstName.' '.$faker->lastName.' '.$faker->lastName,
                'verified' => '1',
            ],
            [
                'email' => 'watsonsboac@pubh.site',
                'password' => 'password',
                'role' => 'employer',
                'company_name' => 'Watsons -Boac',
                'description' => null,
                'mission' => null,
                'vision' => null,
                'address' => null,
                'contact_number' => $faker->mobileNumber(),
                'contact_person_name' => $faker->firstName.' '.$faker->lastName.' '.$faker->lastName,
                'verified' => '1',
            ],
            [
                'email' => 'boacpuregold@pubh.site',
                'password' => 'password',
                'role' => 'employer',
                'company_name' => 'Puregold - Boac',
                'description' => null,
                'mission' => null,
                'vision' => null,
                'address' => null,
                'contact_number' => $faker->mobileNumber(),
                'contact_person_name' => $faker->firstName.' '.$faker->lastName.' '.$faker->lastName,
                'verified' => '1',
            ],
            // seekers
            [
                'email' => 'maricelpineda@pubh.site',
                'password' => 'password',
                'role' => 'seeker',
                'firstname' => 'Maricel',
                'middlename' => 'Par',
                'lastname' => 'Pineda',
                'birthdate' => '07/24/1973',
                'contact_number' => $faker->mobileNumber(),
            ],
            [
                'email' => 'terrencelopez@pubh.site',
                'password' => 'password',
                'role' => 'seeker',
                'firstname' => 'Terrence',
                'middlename' => 'Macam',
                'lastname' => 'Lopez',
                'birthdate' => '12/17/1997',
                'contact_number' => $faker->mobileNumber(),
            ],
            [
                'email' => 'jethrolandoy@pubh.site',
                'password' => 'password',
                'role' => 'seeker',
                'firstname' => 'Jethro',
                'middlename' => 'Landoy',
                'lastname' => 'Panganiban',
                'birthdate' => '1/4/1999',
                'contact_number' => $faker->mobileNumber(),
            ],
            [
                'email' => 'mabelperlas@pubh.site',
                'password' => 'password',
                'role' => 'seeker',
                'firstname' => 'Mabel',
                'middlename' => 'Motol',
                'lastname' => 'Perlas',
                'birthdate' => '01/27/1989',
                'contact_number' => $faker->mobileNumber(),
            ],
            [
                'email' => 'peterabad@pubh.site',
                'password' => 'password',
                'role' => 'seeker',
                'firstname' => 'Peter',
                'middlename' => 'Lazaro',
                'lastname' => 'Abad',
                'birthdate' => '1/10/1980',
                'contact_number' => $faker->mobileNumber(),
            ],
        ];

        foreach($usersData as $i){
            $user = User::create([
                'email' => $i['email'],
                'password' => Hash::make($i['password']),
                'role' => $i['role'],
                'verification_code' => '000000',
                'verified' => '1',
            ]);

            if ($i['role'] == 'admin') {



            }else if ($i['role'] == 'employer') {

                Employer::create([
                    'user_id' => $user->user_id,
                    'company_name' => $i['company_name'],
                    'description' => $i['description'],
                    'mission' => $i['mission'],
                    'vision' => $i['vision'],
                    'address' => $i['address'],
                    'contact_number' => $i['contact_number'],
                    'contact_person_name' => $i['contact_person_name'],
                    'verified' => $i['verified']
                ]);

            } else if ($i['role'] == 'seeker') {

                Seeker::create([
                    'user_id' => $user->user_id,
                    'firstname' => $i['firstname'],
                    'middlename' => $i['middlename'],
                    'lastname' => $i['lastname'],
                    'birthdate' => $i['birthdate'],
                    'contact_number' => $i['contact_number'],
                ]);
            }
        }
        
    }
}
