<?php

namespace App\Imports;

use App\Models\Scholar;

use Carbon\Carbon;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithValidation;
use Maatwebsite\Excel\Concerns\SkipsErrors;
use Maatwebsite\Excel\Concerns\SkipsFailures;
use Maatwebsite\Excel\Concerns\SkipsOnError;
use Maatwebsite\Excel\Concerns\SkipsOnFailure;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class ScholarImport implements ToCollection,WithHeadingRow,WithValidation,SkipsOnError,SkipsOnFailure
{
    use SkipsErrors,SkipsFailures;
    /**
    * @param Collection $collection
    */
    public function collection(Collection $rows)
    {
        foreach ($rows as $row)
        {
            Scholar::create([
                'first_name'   => $row['first_name'],
                'middle_name'  => $row['middle_name'],
                'last_name'    => $row['last_name'],
                'email'        => $row['email'],
                'username'     => $row['username'],
                'password'     => bcrypt($row['password']),
                'date_started' => date('Y-m-d H:i:s' , strtotime($row['date_started'])),
                'type'      => $row['type'],
                'status'       => $row['status'],
            ]);
        }
    }
    public function rules(): array
    {
        return [
            '*.email' => ['unique:scholars,email'],
            '*.username' => ['unique:scholars,username']
        ];
    }
    
}
