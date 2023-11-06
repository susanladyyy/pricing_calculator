<?php

namespace Database\Seeders;

use App\Models\University;
use Illuminate\Database\Seeder;

class UniversitySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        University::create([
            'university_name' => 'Binus University Alam Sutera',
            'university_address' => 'Alam Sutera',
            'logo_path' => '/storage/asset/logo/Binus University.png'
        ]);

        University::create([
            'university_name' => 'Telkom University',
            'university_address' => 'Bandung',
            'logo_path' => '/storage/asset/logo/Telkom University.png'
        ]);
    }
}
