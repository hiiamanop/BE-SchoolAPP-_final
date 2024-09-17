<?php

namespace App\Imports;

use App\Models\Kelas;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class KelasImport implements ToModel, WithHeadingRow
{
    public function model(array $row)
    {
        return new Kelas([
            'name' => $row['name'],  // Assuming the column name is 'judul' in your Excel file
        ]);
    }
}
