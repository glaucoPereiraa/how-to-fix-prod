<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\LazyCollection;

class UserSeeder extends Seeder
{

    public function run(): void
    {
        User::factory(100)->unverified()->create();

        LazyCollection::range(1, 2000)->each(function ($count) {
            User::factory()->unverified()->create([
                'employee_id' => rand(1, 100),
                'collaborator_id' => rand(1, 100),
            ]);
        });
    }
}
