<?php

namespace App\Imports;

use App\Models\KelasSiswa;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class KelasSiswaImport implements ToModel, WithHeadingRow
{
    public function model(array $row)
    {
        // Insert a new record into kelas_siswas using siswa_id and kelas_id
        return new KelasSiswa([
            'user_id' => $row['user_id'],
            'kelas_id' => $row['kelas_id'],
        ]);
    }
}
