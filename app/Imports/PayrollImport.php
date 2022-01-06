<?php

namespace App\Imports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use App\Models\Payroll;
use App\Models\Scholar;
use App\Models\Player;
class PayrollImport implements ToCollection,WithHeadingRow
{
    /**
    * @param Collection $collection
    */
    public function collection(Collection $rows)
    {        
        foreach ($rows as $row)
        {
            $player = Player::WHERE('account_name', preg_replace('/\s+/', '', $row['account_name']))->first();
            $scholar = Scholar::WHERE('username', $row['username'])->first();

            Payroll::create([
                'scholar_id'       => $scholar->id,
                'player_id'      => $player->id,
                'total_slp' => $row['total_slp'],
                'txn_id'           => $row['txn_id'],
                'status'            => $row['status'] == 'Paid' ? 1 : 0
            ]);
        }
    }
}
