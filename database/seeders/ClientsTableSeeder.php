<?php

namespace Database\Seeders;

use App\Client;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class ClientsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            [
                'name' => 'John Doe',
                'phone' => '1234567890',
                'email' => 'john.doe@example.com',
            ],
            [
                'name' => 'Jane Smith',
                'phone' => '0987654321',
                'email' => 'jane.smith@example.com',
            ],
            [
                'name' => 'Jack Sarrow',
                'phone' => '0987654321',
                'email' => 'jane.smith@example.com',
            ],
        ];

        foreach ($data as $item) {
            Client::create($item);
        }
    }
}
