<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            [
              'name'             => 'kishore',
              'email'            => 'kishore@gmail.com',
              'password'         => Hash::make('password'),
              'mobile_no'        => 9876543210,
            ],
        ];

        foreach ($data as $entry) {
            User::create($entry);
        }
    }
}
