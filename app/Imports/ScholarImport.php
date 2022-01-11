<?php

namespace App\Imports;

use App\Models\Scholar;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class ScholarImport implements ToCollection,WithHeadingRow
{
    /**
    * @param Collection $collection
    */
    public function collection(Collection $rows)
    {
        foreach ($rows as $row)
        {
            $scholar = Scholar::where('email',$row['email'])->count();
            if($scholar == 0)
                Scholar::create([
                    'first_name'   => $row['first_name'],
                    'middle_name'  => $row['middle_name'],
                    'last_name'    => $row['last_name'],
                    'email'        => preg_replace('/\s+/', '',$row['email']),
                    'username'     => preg_replace('/\s+/', '',$row['username']),
                    'password'     => bcrypt('!2E4p@$$w0rDD'),
                    'date_started' => date('Y-m-d H:i:s' , strtotime($row['date_started'])),
                    'type_id'      => $row['type'],
                    'status'       => str_word_count($row['status']) == 1 ? preg_replace('/\s+/', '',strtoupper($row['status'])) : strtoupper($row['status']),
                ]);
        }
    }
    
}
