<?php

namespace Database\Seeders;

use App\Models\Role;
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
        $roles = Role::all();

        foreach ($roles as $role) {
            $userCount = $role->role === 'admin' ? 1 : 5; // Create 1 admin, 5 guru, 5 siswa

            for ($i = 1; $i <= $userCount; $i++) {
                $user = User::create([
                    'name' => ucfirst($role->role) . " User $i",
                    'email' => $role->role . $i . '@example.com',
                    'password' => Hash::make('password'),
                    'role_id' => $role->id,
                    'nomor_induk' => $this->generateNomorInduk($role->role, $i),
                    'tahun_masuk' => date('Y'),
                ]);
            }
        }
    }

    private function generateNomorInduk($role, $index): string
    {
        $prefix = $role === 'guru' ? 'G' : 'S';
        return $prefix . str_pad($index, 4, '0', STR_PAD_LEFT) . date('Y');
    }
}
