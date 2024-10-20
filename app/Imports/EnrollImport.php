<?php

namespace App\Imports;

use App\Models\Enroll;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class EnrollImport implements ToModel, WithHeadingRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new Enroll([
            //
            'guru_pelajaran_id' => $row['guru_pelajaran_id'], // Map the appropriate column
            'code_enroll' => $row['code_enroll'], // Map the appropriate column
        ]);
    }
}
