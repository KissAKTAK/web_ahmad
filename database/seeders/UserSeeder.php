
<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class UserSeeder extends Seeder
{
    public function run()
    {
        User::create([
            'name' => 'مدير النظام',
            'email' => 'admin@prosecution.gov.ye',
            'password' => Hash::make('admin123456'),
            'email_verified_at' => now(),
        ]);
    }
}
