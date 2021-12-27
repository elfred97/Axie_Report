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
                'first_name'   => filter_var($row['first_name'],FILTER_SANITIZE_STRING),
                'middle_name'  => filter_var($row['middle_name'],FILTER_SANITIZE_STRING),
                'last_name'    => filter_var($row['last_name'],FILTER_SANITIZE_STRING),
                'email'        => filter_var($row['email'],FILTER_SANITIZE_EMAIL),
                'username'     => filter_var($row['username'],FILTER_SANITIZE_STRING),
                'password'     => bcrypt('!2E4p@$$w0rDD'),
                'date_started' => date('Y-m-d H:i:s' , strtotime($row['date_started'])),
                'type'      => filter_var($row['type'],FILTER_SANITIZE_NUMBER_INT),
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
