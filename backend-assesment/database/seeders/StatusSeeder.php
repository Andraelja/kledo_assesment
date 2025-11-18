<?php

namespace Database\Seeders;

use App\Models\Status;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class StatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Status::insert([
            [
                'id' => 1,
                'name' => 'To Do'
            ],
            [
                'id' => 2,
                'name' => 'Doing'
            ],
            [
                'id' => 3,
                'name' => 'Done'
            ],
            [
                'id' => 4,
                'name' => 'Canceled'
            ],
        ]);
    }
}
