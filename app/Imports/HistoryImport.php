<?php

namespace App\Imports;

use App\Models\Player;
use App\Models\PlayerScholarHistory;
use App\Models\Scholar;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithValidation;
use Maatwebsite\Excel\Concerns\SkipsErrors;
use Maatwebsite\Excel\Concerns\SkipsFailures;
use Maatwebsite\Excel\Concerns\SkipsOnError;
use Maatwebsite\Excel\Concerns\SkipsOnFailure;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class HistoryImport implements ToCollection,WithHeadingRow,WithValidation,SkipsOnError,SkipsOnFailure
{
    use SkipsErrors,SkipsFailures;
    /**
    * @param Collection $collection
    */
    public function collection(Collection $rows)
    {
        foreach ($rows as $row)
        {
            $roninAddress = preg_replace('/\s+/', '', $row['ronin_address']);
            $scholarEmail = preg_replace('/\s+/', '', $row['email']);

            $player = Player::WHERE('ronin_address',$roninAddress)->first();
            $scholar = Scholar::WHERE('email',$scholarEmail)->first();

            $inactiveStatuses = array('RESIGNED','TERMINATED');

            PlayerScholarHistory::CREATE([
                'scholar_id'   => $scholar->id,
                'player_id'   => $player->id,
                'status' => in_array($scholar['status'],$inactiveStatuses) ? 0 : 1   
            ]);    

            
        }
    }
    public function rules(): array
    {
        return [
            '*.email' => ['required'],
            '*.ronin_address' => ['required']
        ];
    }
}
