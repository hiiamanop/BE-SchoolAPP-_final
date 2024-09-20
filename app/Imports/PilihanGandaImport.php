<?php

namespace App\Imports;

use App\Models\PilihanGanda;
use Maatwebsite\Excel\Concerns\ToModel;

class PilihanGandaImport implements ToModel
{
    public function model(array $row)
    {
        return new PilihanGanda([
            'soal_id' => $row[0], // Map the columns to your PilihanGanda model fields
            'jawaban' => $row[1],
            'value'   => $row[2],  // Assuming the value column in the Excel is a boolean (true/false)
        ]);
    }
}
