<?php

namespace App\Imports;

use App\Models\GuruPelajaran;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class GuruPelajaranImport implements ToModel, WithHeadingRow
{
    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {
        return new GuruPelajaran([
            'user_id' => $row['user_id'],
            'mata_pelajaran_id' => $row['mata_pelajaran_id'],
        ]);
    }
}
