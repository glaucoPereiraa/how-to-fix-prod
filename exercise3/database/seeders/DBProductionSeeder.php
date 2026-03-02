<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\LazyCollection;

class DBProductionSeeder extends Seeder
{

    public function run(): void
    {
        User::factory(1000)->unverified()->create();

        LazyCollection::range(1, 200000)->each(function ($count) {
            User::factory()->unverified()->create([
                'employee_id' => rand(1, 1000),
                'collaborator_id' => rand(1, 1000),
            ]);
        });
    }
}
