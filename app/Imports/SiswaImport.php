<?php

namespace App\Imports;

use App\Models\User;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Illuminate\Support\Facades\Hash;

class SiswaImport implements ToModel, WithHeadingRow
{
    public function model(array $row)
    {
        // Check if mandatory fields are present
        if (empty($row['name']) || empty($row['email']) || empty($row['password']) || empty($row['role_id']) || empty($row['nomor_induk']) || empty($row['tahun_masuk'])) {
            return null; // Skip the row if required fields are missing
        }

        return new User([
            'name' => $row['name'],
            'email' => $row['email'],
            'password' => Hash::make($row['password']),
            'role_id' => $row['role_id'],
            'nomor_induk' => $row['nomor_induk'],
            'tahun_masuk' => $row['tahun_masuk'],
        ]);
    }
}
