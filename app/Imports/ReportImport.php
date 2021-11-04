<?php

namespace App\Imports;

use App\reportModel;
use App\PlayerModel;
use App\NotificationModel;

use Carbon\Carbon;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;

class ReportImport implements ToCollection
{
    /**
    * @param Collection $collection
    */
    public function collection(Collection $rows)
    {
        //
        $counter = 0;
        $batch = (count(reportModel::GET()) > 0) ? reportModel::max('batch') : 0;
        foreach ($rows as $row) 
        {
            if($counter > 0){
                $report = reportModel::WHERE('name', $row[2])->latest('created_at')->first();
                $player = PlayerModel::WHERE('account_name', $row[2])->first();

                $thirty_percent = 0;
                $forty_percent = 0;
                
                if(!empty($report)){
                    $gained_slp_today = $row[6] - $report->total_slp;
                    
                    if(!empty($player)){
                        $today = Carbon::now();
                        $date_started = Carbon::parse($player->date_started);
                        $interval = $date_started->diff($today)->days;

                        if($interval <= 30){
                            $manager_share = $gained_slp_today * 0.7;
                            $scholar_share = $gained_slp_today * 0.3;
                            $thirty_percent = $scholar_share + $report->thirty_percent;
                        }
                        else{
                            $manager_share = $gained_slp_today * 0.6;
                            $scholar_share = $gained_slp_today * 0.4;
                            $forty_percent = $scholar_share + $report->forty_percent;
                        }
                        if($gained_slp_today < 75){
                            $penalty = $player->penalty + 1;
                            NotificationModel::CREATE([
                                'account_name' => $row[2],
                                'gained_slp_today' => $gained_slp_today,
                                'penalty' => $penalty,
                            ]);
                        }
                        else{
                            $penalty = $player->penalty;
                        }
                        

                        PlayerModel::WHERE('account_name', $row[2])->update(
                            [ 
                                'penalty'       => $penalty,
                                'scholar_share' => $player->scholar_share + $scholar_share,
                                'manager_share' => $player->manager_share + $manager_share,
                            ]
                        );
                    }
                }
                else{
                    // $penalty = ($row[6] > 75) ? 0 : 1;
                    $gained_slp_today = $row[6];
                    $thirty_percent = $gained_slp_today * 0.3;
                    // PlayerModel::WHERE('account_name', $row[2])->update(
                    //     [ 
                    //         'penalty'       => $player->penalty + $penalty,
                    //         'scholar_share' => $player->scholar_share + $scholar_share,
                    //         'manager_share' => $player->manager_share + $manager_share,
                    //     ]
                    // );
                }
                reportModel::create([
                    'ronin_address'    => $row[0],
                    'name'             => $row[2],
                    'batch'            => $batch + 1,
                    'average_per_day'  => $row[3],
                    'gained_slp_today' => $gained_slp_today,
                    'unclaimed'        => $row[4],
                    'claimed'          => $row[5],
                    'total_slp'        => $row[6],
                    'last_claim_days'  => $row[7],
                    'last_claim_date'  => date('Y-m-d H:i:s' , strtotime($row[8])),
                    'claimable_on'     => date('Y-m-d H:i:s' , strtotime($row[9])),
                    'thirty_percent'   => $thirty_percent,
                    'forty_percent'    => $forty_percent,
                    'manager_share'    => $row[10],
                    'scholar_share'    => $row[11],
                    'manager_slp'      => $row[12],
                    'scholar_slp'      => $row[13],
                    'mmr'              => $row[14],
                    'rank'             => $row[15],
                ]);
            }
            $counter++;
        }
    }
}
