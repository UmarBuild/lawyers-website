<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Service;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Services
        $services = [
            'Criminal Law', 'Divorce & Family Law', 'Civil Law',
            'Affidavit & Documentation', 'Property & Real Estate',
            'Corporate & Business Law', 'Immigration Law', 'Tax Law'
        ];
        foreach ($services as $name) {
            Service::create(['name' => $name]);
        }

        // Admin
        User::create([
            'name' => 'Admin',
            'email' => 'admin@lawyers.com',
            'password' => bcrypt('admin123'),
            'role' => 'admin',
            'is_approved' => true,
        ]);

        // Sample Lawyers
        $lawyers = [
            ['Advocate Ahmed Khan', 'ahmed@lawyer.com', 'Karachi', 'Criminal Law', 'LLB, LLM', '12 years', '5000', 'SC-1234', 4.5, 'Monday,Tuesday,Wednesday,Thursday,Friday', '09:00', '17:00'],
            ['Advocate Sara Malik', 'sara@lawyer.com', 'Lahore', 'Divorce & Family Law', 'LLB', '8 years', '3000', 'SC-5678', 4.2, 'Monday,Wednesday,Friday', '10:00', '16:00'],
            ['Advocate Bilal Hussain', 'bilal@lawyer.com', 'Islamabad', 'Civil Law', 'LLB, LLM', '15 years', '6000', 'SC-9012', 4.8, 'Monday,Tuesday,Wednesday,Thursday', '09:00', '18:00'],
            ['Advocate Fatima Noor', 'fatima@lawyer.com', 'Karachi', 'Affidavit & Documentation', 'LLB', '5 years', '2000', 'SC-3456', 4.0, 'Monday,Tuesday,Thursday,Friday', '10:00', '15:00'],
            ['Advocate Usman Tariq', 'usman@lawyer.com', 'Rawalpindi', 'Property & Real Estate', 'LLB, LLM', '10 years', '4000', 'SC-7890', 4.3, 'Monday,Wednesday,Thursday,Friday', '09:00', '17:00'],
            ['Advocate Ayesha Sheikh', 'ayesha@lawyer.com', 'Karachi', 'Corporate & Business Law', 'LLB, MBA', '7 years', '7000', 'SC-2345', 4.6, 'Tuesday,Wednesday,Thursday,Friday', '10:00', '18:00'],
        ];

        foreach ($lawyers as $l) {
            User::create([
                'name' => $l[0],
                'email' => $l[1],
                'password' => bcrypt('lawyer123'),
                'role' => 'lawyer',
                'city' => $l[2],
                'specialization' => $l[3],
                'qualification' => $l[4],
                'experience_years' => $l[5],
                'consultation_fee' => $l[6],
                'bar_council_number' => $l[7],
                'rating' => $l[8],
                'is_approved' => true,
                'available_days' => $l[9],
                'available_time_start' => $l[10],
                'available_time_end' => $l[11],
                'bio' => "Experienced lawyer specializing in {$l[3]}.",
            ]);
        }

        // Sample Customer
        User::create([
            'name' => 'Muhammad Ali',
            'email' => 'ali@gmail.com',
            'password' => bcrypt('customer123'),
            'role' => 'customer',
            'phone' => '0312-3456789',
            'city' => 'Karachi',
        ]);
    }
}