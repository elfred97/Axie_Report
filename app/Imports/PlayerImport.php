<?php

namespace App\Imports;

use App\Models\Player;

use Carbon\Carbon;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\SkipsErrors;
use Maatwebsite\Excel\Concerns\SkipsFailures;
use Maatwebsite\Excel\Concerns\SkipsOnError;
use Maatwebsite\Excel\Concerns\SkipsOnFailure;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;

class PlayerImport implements ToCollection,WithHeadingRow,WithValidation,SkipsOnError,SkipsOnFailure
{
    use SkipsErrors,SkipsFailures;
    /**
    * @param Collection $collection
    */
    public function collection(Collection $rows)
    {
        foreach ($rows as $row)
        {
            Player::create([
                'account_name'       => filter_var(preg_replace('/\s+/', '', $row['account_name']),FILTER_SANITIZE_STRING),
                'ronin_address'      => filter_var($row['ronin_address'],FILTER_SANITIZE_STRING),
                'market_place_email' => filter_var($row['market_place_email'],FILTER_SANITIZE_EMAIL),
                'password'           => filter_var($row['password'],FILTER_SANITIZE_STRING),
                'penalty'            => $row['penalty'],
                'scholar_share'      => $row['scholar_share'],
                'manager_share'      => $row['manager_share'],
            ]);
        }
    }

    public function rules(): array
    {
        return [
            '*.account_name' => ['unique:players,account_name'],
            '*.ronin_address' => ['starts_with:ronin'],
            '*.market_place_email' => ['email']
        ];
    }
}
