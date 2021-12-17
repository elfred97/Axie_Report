<?php

namespace App\Imports;

use App\Models\Scholar;

use Carbon\Carbon;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;

class ScholarImport implements ToCollection
{
    /**
    * @param Collection $collection
    */
    public function collection(Collection $rows)
    {
        $counter = 0;
        foreach ($rows as $row)
        {

            if($counter > 0){
                Scholar::create([
                    'first_name'   => $row[0],
                    'middle_name'  => $row[1],
                    'last_name'    => $row[2],
                    'email'        => $row[3],
                    'username'     => $row[4],
                    'password'     => bcrypt($row[5]),
                    'date_started' => date('Y-m-d H:i:s' , strtotime($row[6])),
                    'type_id'      => $row[7],
                    'status'       => $row[8],
                ]);
            }
            $counter++;
        }
    }
}
