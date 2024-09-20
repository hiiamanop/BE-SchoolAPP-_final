<?php

namespace App\Imports;

use App\Models\KelasSiswa;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class KelasSiswaImport implements ToModel, WithHeadingRow
{
    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {
        return new KelasSiswa([
            'user_id'  => $row['user_id'],   // assuming you have user_id in your Excel file
            'kelas_id' => $row['kelas_id'],  // assuming you have kelas_id in your Excel file
        ]);
    }
}

