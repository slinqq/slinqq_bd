<?php

namespace Database\Seeders;

use App\Models\Company;
use App\Models\Section;
use App\Models\Member;
use Faker\Factory as FakerFactory;
use Illuminate\Database\Seeder;

class CompanyAndMemberSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = FakerFactory::create();

        // write 20 building names
        $companyNames = [
            'Building 1',
            'Building 2',
            'Building 3',
            'Building 4',
            'Building 5',
            'Building 6',
            'Building 7',
            'Building 8',
            'Building 9',
            'Building 10',
            'Building 11',
            'Building 12',
            'Building 13',
            'Building 14',
            'Building 15',
            'Building 16',
            'Building 17',
            'Building 18',
            'Building 19',
            'Building 20',
        ];

        foreach ($companyNames as $index => $name) {
            // Create the company
            $company = Company::create([
                'name' => $name,
                'contact_no' => $faker->phoneNumber(), // Replace with actual contact numbers
                'address' => "Address $index, Dhaka",
                'city' => 'Dhaka',
                'country' => 'Bangladesh',
                'user_id' => 2, // Replace with actual user id
            ]);

            // Create 5 sections for each company with creative names
            $sectionNames = ["Floor 1", "Floor 2", "Floor 3", "Floor 4", "Floor 5"];

            foreach ($sectionNames as $sectionName) {
                $section = Section::create([
                    'title' => $sectionName,
                    'company_id' => $company->id,
                ]);

                for ($i = 1; $i < 5; $i++) {
                    Member::create([
                        'name' => $faker->name,
                        'email' => $faker->email,
                        'contact_no' =>  $faker->phoneNumber(),
                        'join_date' => $faker->date('Y-m-d'),
                        'monthly_fee' => $faker->randomFloat(2, 5000, 10000),
                        'status' => 'active',
                        'address' => $faker->address,
                        'occupation' => $faker->jobTitle,
                        'company_id' => $company->id,
                        'section_id' => $section->id,
                        'member_id' => $faker->randomNumber(6),
                        'advance_amount' => $faker->randomFloat(2, 0, 1000000),
                    ]);
                }
            }
        }
    }
}
