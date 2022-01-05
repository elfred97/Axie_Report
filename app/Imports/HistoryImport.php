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
            $roninAddress = $row['ronin_address'];
            $scholarEmail = preg_replace('/\s+/', '',filter_var($row['email'],FILTER_SANITIZE_EMAIL));

            $player = Player::WHERE('ronin_address',$roninAddress)->first();
            $scholar = Scholar::WHERE('email',$scholarEmail)->first();

            $ifExist = PlayerScholarHistory::WHERE('scholar_id',$scholar->id)->count();
            $scholarObj = $ifExist > 0 ? Scholar::WHERE('email',$scholarEmail)->skip(1)->first() : Scholar::WHERE('email',$scholarEmail)->first();

            PlayerScholarHistory::CREATE([
                'scholar_id'   => $scholarObj->id,
                'player_id'   => $player->id
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
