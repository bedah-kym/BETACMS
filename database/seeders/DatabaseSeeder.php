<?php

namespace Database\Seeders;

use Database\Seeders\CaseTypesTableSeeder;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Schema;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        Schema::disableForeignKeyConstraints();

        $this->call(CaseTypesTableSeeder::class);

        Schema::enableForeignKeyConstraints();
    }
}
