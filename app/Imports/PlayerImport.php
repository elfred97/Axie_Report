<?php

namespace App\Imports;

use App\Models\Player;

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
                Player::create([
                    'account_name'       => $row[0],
                    'ronin_address'      => $row[1],
                    'market_place_email' => $row[2],
                    'password'           => $row[3],
                    'penalty'            => 0,
                    'scholar_share'      => 0,
                    'manager_share'      => 0,
                ]);
            }
            $counter++;
        }
    }
}
