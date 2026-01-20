<?php

namespace Database\Seeders;

use App\Models\Restaurant;
use Carbon\CarbonImmutable;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
	/**
	 * Run the database seeds.
	 */
	public function run(): void
	{
        DB::table('users')->insert([
            [
                'id' => 1,
                'name' => 'Bob Bobber',
                'email' => 'bob.bobber@va.com',
                'email_verified_at' => CarbonImmutable::now(),
                'password' => Hash::make('password123'),
                'remember_token' => 'a@fdsdas34234dfsf345',
                'created_at' => CarbonImmutable::now(),
            ],
        ]);
	}
}
