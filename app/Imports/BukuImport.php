<?php

namespace App\Imports;

use App\Models\Buku;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class BukuImport implements ToModel, WithHeadingRow
{
    public function model(array $row)
    {
        return new Buku([
            'judul' => $row['judul'],  // Assuming the column name is 'judul' in your Excel file
            'kategori_buku_id' => $row['kategori_buku_id'],  // Assuming the column name in Excel matches this
        ]);
    }
}
