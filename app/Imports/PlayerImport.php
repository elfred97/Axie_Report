<?php

namespace App\Imports;

use App\PlayerModel;

use Carbon\Carbon;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;

class PlayerImport implements ToCollection
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
                PlayerModel::create([
                    'first_name'         => $row[0],
                    'middle_name'        => $row[1],
                    'last_name'          => $row[2],
                    'account_name'       => $row[3],
                    'ronin_address'      => $row[4],
                    'scholar_email'      => $row[5],
                    'market_place_email' => $row[6],
                    'email_password'     => $row[7],
                    'date_started'       => date('Y-m-d H:i:s' , strtotime($row[8])),
                    'penalty'            => 0,
                    'scholar_share'      => 0,
                    'manager_share'      => 0,
                    'type'               => $row[9],
                    'status'             => $row[10],                    
                ]);
            }
            $counter++;
        }
    }
}
