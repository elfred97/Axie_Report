<?php

namespace App\Imports;

use App\Models\Report;
use App\Models\Player;
use App\Models\Scholar;
use App\Models\Notification;
use App\Models\NotificationScholars;
use App\Models\NotificationSettings;
use App\Models\User;
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
                $report = Report::WHERE('name', $row[1])->latest('created_at')->first();
                $player = Player::WHERE('account_name', $row[1])->first();

                $thirty_percent = 0;
                $forty_percent = 0;
                $managerShare = 0;
                $scholarShare = 0;
                
                if(!empty($report)){
                    $gained_slp_today = ($row[5] >= $report->total_slp) ? $row[5] - $report->total_slp : $row[5];
                    
                    if(!empty($player)){
                        // Check shcolar share
                        $scholarDateStarted = Scholar::LEFTJOIN('player_scholar_histories as history', 'history.scholar_id', '=', 'scholars.id')
                                ->LEFTJOIN('players', 'history.player_id','=', 'players.id')
                                ->SELECT('scholars.date_started')
                                ->WHERE([['players.account_name', $player['account_name']]])
                                ->FIRST()->date_started;

                        $date_started = Carbon::parse($scholarDateStarted);
                        $interval = $date_started->diff(Carbon::now())->days;
                        // Check interval
                        if($interval <= 30){
                            $manager_share  = $gained_slp_today * 0.7;
                            $scholar_share  = $gained_slp_today * 0.3;
                            $thirty_percent = $scholar_share + $report->thirty_percent;
                            $managerShare = 70;
                            $scholarShare = 30;
                        }
                        else{
                            $manager_share = $gained_slp_today * 0.6;
                            $scholar_share = $gained_slp_today * 0.4;
                            $forty_percent = $scholar_share + $report->forty_percent;
                            $managerShare = 60;
                            $scholarShare = 40;
                        }
                        //Get All Active Admin
                        $admins = User::select('id')->where('status',1)->get();
                        
                        // Check SLP Penalty                        
                        $penalty = $player->penalty;
                        if($gained_slp_today < $minimum_slp){
                            $penalty = $penalty + 1;

                            $newScholarNotification = NotificationScholars::CREATE([
                                'player_id' => $player['id'],
                                'account_name' => $player['account_name'],
                                'category' => 1,
                                'status' => 1
                            ]);
    
                            for($j=0; $j<count($admins);$j++){
    
                                Notification::CREATE([
                                    'admin_id' => $admins[$j]->id,
                                    'category'     => 1,
                                    'notification_reminder_id' => $newScholarNotification->id,
                                    'status' => 1
                                ]);
                            }
                        }

                        // Check MMR Penalty
                        if($row[13] < $mmr){
                            $penalty = $penalty + 1;

                            $newScholarNotification = NotificationScholars::CREATE([
                                'player_id' => $player['id'],
                                'account_name' => $player['account_name'],
                                'category' => 2,
                                'status' => 1
                            ]);

                            for($j=0; $j<count($admins);$j++){
                                Notification::CREATE([
                                    'admin_id' => $admins[$j]->id,
                                    'category'     => 1,
                                    'notification_reminder_id' => $newScholarNotification->id,
                                    'status' => 1
                                ]);
                            }
                        }

                        // Update Scholar Status
                        // if($penalty > 3)
                        // {
                        //     Scholar::LEFTJOIN('player_scholar_histories as history', 'history.scholar_id', '=', 'scholars.id')
                        //     ->LEFTJOIN('players', 'players.id', '=', 'history.player_id')
                        //     ->WHERE('players.account_name', '=', $row[2])
                        //     ->UPDATE(
                        //         [
                        //             'scholars.status' => 'Terminated'
                        //         ]
                        //     );
                        //     Notification::CREATE([
                        //         'account_name' => $row[2],
                        //         'category'     => 3, // Scholar Terminated
                        //         'status'       => 1,
                        //         'status_scholar' => 1,
                        //     ]);
                        // }
                        // Update Player
                        Player::WHERE('account_name', $row[1])->update(
                            [
                                'penalty'       => $penalty,
                                'scholar_share' => $player->scholar_share + $scholar_share,
                                'manager_share' => $player->manager_share + $manager_share,
                            ]
                        );
                    }
                }
                else{
                    $gained_slp_today = $row[5];
                    $thirty_percent   = $gained_slp_today * 0.3;
                    $managerShare = 70;
                    $scholarShare = 30;
                }

                Report::create([
                    'ronin_address'    => $row[0],
                    'name'             => preg_replace('/\s+/', '', $row[1]),
                    'batch'            => $batch + 1,
                    'average_per_day'  => $row[2],
                    'gained_slp_today' => $gained_slp_today,
                    'unclaimed'        => $row[3],
                    'claimed'          => $row[4],
                    'total_slp'        => $row[5],
                    'last_claim_days'  => $row[6],
                    'last_claim_date'  => date('Y-m-d H:i:s' , strtotime($row[7])),
                    'claimable_on'     => date('Y-m-d H:i:s' , strtotime($row[8])),
                    'thirty_percent'   => $thirty_percent,
                    'forty_percent'    => $forty_percent,
                    'manager_share'    => $managerShare,
                    'scholar_share'    => $scholarShare,
                    'manager_slp'      => is_string($row[11]) ? 0 : $row[11],
                    'scholar_slp'      => is_string($row[12]) ? 0 : $row[12],
                    'mmr'              => $row[13],
                    'rank'             => $row[14],
                    'created_at'       => $row[15] == '' ? Carbon::now() : date('Y-m-d' , strtotime($row[15])),
                    'updated_at'       => $row[15] == '' ? Carbon::now() : date('Y-m-d' , strtotime($row[15])),
                ]);
            }
            $counter++;
        }
    }
}
