<?php

namespace App\Imports;

use App\Models\EnrollClass;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class EnrollClassImport implements ToModel, WithHeadingRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new EnrollClass([
            //
            'enroll_id' => $row['enroll_id'], // Map the appropriate column
            'class_id' => $row['class_id'],   // Map the appropriate column
        ]);
    }
}
