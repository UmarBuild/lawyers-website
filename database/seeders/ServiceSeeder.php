<?php

namespace Database\Seeders;

use App\Models\Service;
use Illuminate\Database\Seeder;

class ServiceSeeder extends Seeder
{
    public function run(): void
    {
        $services = [
            'Criminal Law',
            'Family Law',
            'Corporate Law',
            'Civil Law',
            'Property Law',
            'Tax Law',
            'Labour Law',
            'Constitutional Law',
            'Cyber Law',
            'Immigration Law',
        ];

        foreach ($services as $name) {
            Service::create(['name' => $name]);
        }
    }
}