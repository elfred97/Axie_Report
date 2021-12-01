<?php

namespace App\Imports;

use App\Models\Report;
use App\Models\Player;
use App\Models\Scholar;
use App\Models\Notification;
use App\Models\NotificationSettings;

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
        $batch = (count(Report::GET()) > 0) ? Report::max('batch') : 0;

        $notification_settings = auth()->user()->notification_settings;
        $mmr = 800;
        $minimum_slp = 75;

        if($notification_settings) {
            $mmr = $notification_settings->options['mmr'] ?? 800;
            $minimum_slp = $notification_settings->options['minimum_slp'] ?? 75;
        }

        foreach ($rows as $row)
        {
            if($counter > 0){
                $report = Report::WHERE('name', $row[2])->latest('created_at')->first();
                $player = Player::WHERE('account_name', $row[2])->first();

                $thirty_percent = 0;
                $forty_percent = 0;
                
                if(!empty($report)){
                    $gained_slp_today = ($report->total_slp >= $row[6]) ? $row[6] : $row[6] - $report->total_slp;
                    
                    if(!empty($player)){
                        // Check shcolar share
                        $date_started = Carbon::parse($player->date_started);
                        $interval = $date_started->diff(Carbon::now())->days;
                        // Check interval
                        if($interval <= 30){
                            $manager_share  = $gained_slp_today * 0.7;
                            $scholar_share  = $gained_slp_today * 0.3;
                            $thirty_percent = $scholar_share + $report->thirty_percent;
                        }
                        else{
                            $manager_share = $gained_slp_today * 0.6;
                            $scholar_share = $gained_slp_today * 0.4;
                            $forty_percent = $scholar_share + $report->forty_percent;
                        }
                        // Check SLP Penalty                        
                        $penalty = $player->penalty;
                        if($gained_slp_today < $minimum_slp){
                            $penalty = $penalty + 1;
                            Notification::CREATE([
                                'account_name' => $row[2],
                                'category'     => 1,
                                'status'       => 1,
                            ]);
                        }

                        // Check MMR Penalty
                        if($row[14] < $mmr){
                            $penalty = $penalty + 1;
                            Notification::CREATE([
                                'account_name' => $row[2],
                                'category'     => 2,
                                'status'       => 1,
                            ]);
                        }

                        // Update Scholar Status
                        if($penalty > 3)
                        {
                            Scholar::LEFTJOIN('player_scholar_histories as history', 'history.scholar_id', '=', 'scholars.id')
                            ->LEFTJOIN('players', 'players.id', '=', 'history.player_id')
                            ->WHERE('players.account_name', '=', $row[2])
                            ->UPDATE(
                                [
                                    'scholars.status' => 'Terminated'
                                ]
                            );
                            Notification::CREATE([
                                'account_name' => $row[2],
                                'category'     => 3, // Scholar Terminated
                                'status'       => 1,
                            ]);
                        }
                        // Update Player
                        Player::WHERE('account_name', $row[2])->update(
                            [
                                'penalty'       => $penalty,
                                'scholar_share' => $player->scholar_share + $scholar_share,
                                'manager_share' => $player->manager_share + $manager_share,
                            ]
                        );
                    }
                }
                else{
                    $gained_slp_today = $row[6];
                    $thirty_percent   = $gained_slp_today * 0.3;
                }

                Report::create([
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
                    'manager_slp'      => is_string($row[12]) ? 0 : $row[12],
                    'scholar_slp'      => is_string($row[13]) ? 0 : $row[13],
                    'mmr'              => $row[14],
                    'rank'             => $row[15],
                ]);
            }
            $counter++;
        }
    }
}
