<?php

namespace Database\Seeders;

use App\Program;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class ProgramsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            [
                'name' => 'Program 1',
                'start_date' => '2024-01-01',
                'expiry_date' => '2024-12-31',
                'tier' => 'Bronze',
                'amount' => 100.00,
                'points' => 10,
                'status' => 'active',
                'minimum_amount' => 50.00,
                'conversion_factor' => 1.00,
                'comment' => 'No special benefits.',
            ],
            [
                'name' => 'Program 2',
                'start_date' => '2024-01-01',
                'expiry_date' => '2024-12-31',
                'tier' => 'Silver',
                'amount' => 200.00,
                'points' => 20,
                'status' => 'active',
                'minimum_amount' => 100.00,
                'conversion_factor' => 1.10,
                'comment' => 'Special benefits for premium members.',
            ],
            [
                'name' => 'Program 3',
                'start_date' => '2024-01-01',
                'expiry_date' => '2024-12-31',
                'tier' => 'Gold',
                'amount' => 200.00,
                'points' => 20,
                'status' => 'active',
                'minimum_amount' => 100.00,
                'conversion_factor' => 1.10,
                'comment' => 'Special benefits for premium members.',
            ],
        ];

        foreach ($data as $item) {
            Program::create($item);
        }
    }
}
