<?php

namespace Database\Seeders;

use App\CarteFidelite;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class CarteFidelitesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            [
                'commercial_ID' => 'CARD-2024-00001',
                'points_sum' => 100,
                'tier' => 'Bronze',
                'holder_name' => 'John Doe',
                'fidelity_program' => 'Program 1',
                'holder_id' => 1, // Assuming you have a client with ID 1
                'program_id' => 1, // Assuming you have a program with ID 1
            ],
            [
                'commercial_ID' => 'CARD-2024-00002',
                'points_sum' => 200,
                'tier' => 'Silver',
                'holder_name' => 'Jane Smith',
                'fidelity_program' => 'Program 2',
                'holder_id' => 2, // Assuming you have another client with ID 2
                'program_id' => 2, // Assuming you have another program with ID 2
            ],
            [
                'commercial_ID' => 'CARD-2024-00003',
                'points_sum' => 200,
                'tier' => 'Gold',
                'holder_name' => 'Jack Sarrow',
                'fidelity_program' => 'Program 3',
                'holder_id' => 3, // Assuming you have another client with ID 2
                'program_id' => 3, // Assuming you have another program with ID 2
            ],
        ];

        foreach ($data as $item) {
            CarteFidelite::create($item);
        }
    }
}
