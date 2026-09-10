<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Service;
use App\Models\SiteSetting;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $services = [
            'Criminal Law',
            'Divorce & Family Law',
            'Civil Law',
            'Affidavit & Documentation',
            'Property & Real Estate',
            'Corporate & Business Law',
            'Immigration Law',
            'Tax Law',
        ];

        foreach ($services as $name) {
            Service::create(['name' => $name]);
        }

        User::create([
            'name'        => 'Admin',
            'email'       => 'admin@lawyers.com',
            'password'    => bcrypt('admin123'),
            'role'        => 'admin',
            'is_approved' => true,
        ]);
        $lawyers = [
            [
                'name'                  => 'Advocate Ahmed Khan',
                'email'                 => 'ahmed@lawyer.com',
                'city'                  => 'Karachi',
                'specialization'        => 'Criminal Law',
                'qualification'         => 'LLB, LLM',
                'experience_years'      => 12,
                'consultation_fee'      => 5000,
                'bar_council_number'    => 'SC-1234',
                'rating'                => 4.5,
                'available_days'        => ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday'],
                'available_time_start'  => '09:00',
                'available_time_end'    => '17:00',
            ],
            [
                'name'                  => 'Advocate Sara Malik',
                'email'                 => 'sara@lawyer.com',
                'city'                  => 'Lahore',
                'specialization'        => 'Divorce & Family Law',
                'qualification'         => 'LLB',
                'experience_years'      => 8,
                'consultation_fee'      => 3000,
                'bar_council_number'    => 'SC-5678',
                'rating'                => 4.2,
                'available_days'        => ['Monday', 'Wednesday', 'Friday'],
                'available_time_start'  => '10:00',
                'available_time_end'    => '16:00',
            ],
            [
                'name'                  => 'Advocate Bilal Hussain',
                'email'                 => 'bilal@lawyer.com',
                'city'                  => 'Islamabad',
                'specialization'        => 'Civil Law',
                'qualification'         => 'LLB, LLM',
                'experience_years'      => 15,
                'consultation_fee'      => 6000,
                'bar_council_number'    => 'SC-9012',
                'rating'                => 4.8,
                'available_days'        => ['Monday', 'Tuesday', 'Wednesday', 'Thursday'],
                'available_time_start'  => '09:00',
                'available_time_end'    => '18:00',
            ],
            [
                'name'                  => 'Advocate Fatima Noor',
                'email'                 => 'fatima@lawyer.com',
                'city'                  => 'Karachi',
                'specialization'        => 'Affidavit & Documentation',
                'qualification'         => 'LLB',
                'experience_years'      => 5,
                'consultation_fee'      => 2000,
                'bar_council_number'    => 'SC-3456',
                'rating'                => 4.0,
                'available_days'        => ['Monday', 'Tuesday', 'Thursday', 'Friday'],
                'available_time_start'  => '10:00',
                'available_time_end'    => '15:00',
            ],
            [
                'name'                  => 'Advocate Usman Tariq',
                'email'                 => 'usman@lawyer.com',
                'city'                  => 'Rawalpindi',
                'specialization'        => 'Property & Real Estate',
                'qualification'         => 'LLB, LLM',
                'experience_years'      => 10,
                'consultation_fee'      => 4000,
                'bar_council_number'    => 'SC-7890',
                'rating'                => 4.3,
                'available_days'        => ['Monday', 'Wednesday', 'Thursday', 'Friday'],
                'available_time_start'  => '09:00',
                'available_time_end'    => '17:00',
            ],
            [
                'name'                  => 'Advocate Ayesha Sheikh',
                'email'                 => 'ayesha@lawyer.com',
                'city'                  => 'Karachi',
                'specialization'        => 'Corporate & Business Law',
                'qualification'         => 'LLB, MBA',
                'experience_years'      => 7,
                'consultation_fee'      => 7000,
                'bar_council_number'    => 'SC-2345',
                'rating'                => 4.6,
                'available_days'        => ['Tuesday', 'Wednesday', 'Thursday', 'Friday'],
                'available_time_start'  => '10:00',
                'available_time_end'    => '18:00',
            ],
        ];

        foreach ($lawyers as $l) {
            User::create([
                'name'                  => $l['name'],
                'email'                 => $l['email'],
                'password'              => bcrypt('lawyer123'),
                'role'                  => 'lawyer',
                'city'                  => $l['city'],
                'specialization'        => $l['specialization'],
                'qualification'         => $l['qualification'],
                'experience_years'      => $l['experience_years'],
                'consultation_fee'      => $l['consultation_fee'],
                'bar_council_number'    => $l['bar_council_number'],
                'rating'                => $l['rating'],
                'is_approved'           => true,
                'available_days'        => json_encode($l['available_days']),
                'available_time_start'  => $l['available_time_start'],
                'available_time_end'    => $l['available_time_end'],
            ]);
        }
        User::create([
            'name'     => 'Muhammad Ali',
            'email'    => 'ali@gmail.com',
            'password' => bcrypt('customer123'),
            'role'     => 'customer',
            'phone'    => '0312-3456789',
            'city'     => 'Karachi',
        ]);
        foreach (SiteSetting::DEFAULTS as $key => $value) {
            SiteSetting::updateOrCreate(['key' => $key], ['value' => $value]);
        }
    }
}
