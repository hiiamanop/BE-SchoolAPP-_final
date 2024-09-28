<?php

namespace App\Imports;

use App\Models\Guru;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class GuruImport implements ToModel, WithHeadingRow
{
    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {
        // Ensure required fields are set
        if (!isset($row['name']) || !isset($row['email'])) {
            return null;  // Skip invalid rows
        }

        return new Guru([
            'name' => $row['name'],
            'email' => $row['email'],
            'password' => Hash::make($row['password']), // Hash the password before saving
            'role_id' => $row['role_id'],
            'nomor_induk' => $row['nomor_induk'],
            'tahun_masuk' => $row['tahun_masuk'],
        ]);
    }
}
