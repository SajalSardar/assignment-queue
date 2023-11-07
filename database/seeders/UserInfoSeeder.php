<?php

namespace Database\Seeders;

use App\Models\UserInfo;
use Illuminate\Database\Seeder;

class UserInfoSeeder extends Seeder {
    /**
     * Run the database seeds.
     */
    public function run(): void {
        UserInfo::factory(2000)->create();
    }
}
