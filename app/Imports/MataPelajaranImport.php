<?php

namespace App\Imports;

use App\Models\MataPelajaran;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class MataPelajaranImport implements ToModel, WithHeadingRow
{
    /**
     * Define the model that will be populated with data from the Excel file.
     */
    public function model(array $row)
    {
        return new MataPelajaran([
            'name' => $row['name'], // Ensure that the Excel file has a column named 'name'
        ]);
    }
}
