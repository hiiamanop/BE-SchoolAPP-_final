<?php

namespace App\Imports;

use App\Models\Siswa;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Illuminate\Support\Facades\Hash;

class SiswaImport implements ToModel, WithHeadingRow
{
    public function model(array $row)
    {
        return new Siswa([
            'name' => $row['name'],
            'email' => $row['email'],
            'password' => Hash::make($row['password']),
            'role_id' => $row['role_id'],
            'nomor_induk' => $row['nomor_induk'],
            'tahun_masuk' => $row['tahun_masuk'],
        ]);
    }
}
