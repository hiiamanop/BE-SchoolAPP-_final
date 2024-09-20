<?php

namespace App\Imports;

use App\Models\Soal;
use Maatwebsite\Excel\Concerns\ToModel;

class SoalImport implements ToModel
{
    public function model(array $row)
    {
        return new Soal([
            'assignment_id' => $row[0], // Map the columns to your Soal model fields
            'soal' => $row[1],
            'type' => $row[2],
        ]);
    }
}

