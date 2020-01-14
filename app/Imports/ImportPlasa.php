<?php

namespace App\Imports;

use App\Plasa;
use Maatwebsite\Excel\Concerns\ToModel;

class ImportPlasa implements ToModel
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new Plasa([
            'nama_plasa'  => $row[0],
            'witel_plasa' => $row[1],
            'kota_plasa'  => $row[2],
            'delete_plasa'=> 0
        ]);
    }
}
