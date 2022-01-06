<?php

namespace App\Console\Commands;

use App\Models\BattleLogs;
use App\Models\Notification;
use App\Models\NotificationSettings;
use App\Models\Payroll;
use App\Models\Player;
use App\Models\PlayerScholarHistory;
use App\Models\Scholar;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;

class GetBattleLogs extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'battle.logs';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Fetch data from API to be save in battle logs table';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $this->line('Fetching Battle Logs API Start: ' . Carbon::now()->format('Y-m-d H:i:s'));

        $players = Player::select('ronin_address','account_name','penalty','players.id as p_id')->with('histories')->get();


        foreach($players as $player){
            $roninAddress = str_replace("ronin:","0x",$player['ronin_address']);
            $response = Http::get('https://game-api.axie.technology/api/v1/'.$roninAddress);

            do{
                $response = Http::get('https://game-api.axie.technology/api/v1/'.$roninAddress);
            }while($response->failed());

            $json_response = $response->json();

            $notification_settings = NotificationSettings::firstOrNew();
            $mmr = 800;
            $minimum_slp = 75;

            if($notification_settings) {
                $mmr = $notification_settings->options['mmr'] ?? 800;
                $minimum_slp = $notification_settings->options['minimum_slp'] ?? 75;
            }

            $report = BattleLogs::WHERE('account_name', $player['account_name'])->latest('created_at')->first();

            $thirty_percent = 0;
            $forty_percent = 0;
            $managerShare = 0;
            $scholarShare = 0;

            if(!empty($report)){
                $gained_slp_today = ($report->total_slp >= $json_response['total_slp']) ? $json_response['total_slp'] : $json_response['total_slp'] - $report->total_slp;
                
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
                    // Check SLP Penalty                        
                    $penalty = $player['penalty'];
                    if($gained_slp_today < $minimum_slp){
                        $penalty = $penalty + 1;
                        Notification::CREATE([
                            'account_name' => $player['account_name'],
                            'category'     => 1,
                            'status'       => 1,
                            'status_scholar' => 1
                        ]);
                    }

                    // Check MMR Penalty
                    if($json_response['mmr'] < $mmr){
                        $penalty = $penalty + 1;
                        Notification::CREATE([
                            'account_name' => $player['account_name'],
                            'category'     => 2,
                            'status'       => 1,
                            'status_scholar' => 1,
                        ]);
                    }

                    // Update Scholar Status
                    if($penalty > 3)
                    {
                        Scholar::LEFTJOIN('player_scholar_histories as history', 'history.scholar_id', '=', 'scholars.id')
                        ->LEFTJOIN('players', 'players.id', '=', 'history.player_id')
                        ->WHERE('players.account_name', '=', $player['account_name'])
                        ->UPDATE(
                            [
                                'scholars.status' => 'TERMINATED'
                            ]
                        );

                        Notification::CREATE([
                            'account_name' => $player['account_name'],
                            'category'     => 3, // Scholar Terminated
                            'status'       => 1,
                            'status_scholar' => 1,
                        ]);
                    }
                    // Update Player
                    Player::WHERE('account_name', $player['account_name'])->update(
                        [
                            'penalty'       => $penalty,
                            'scholar_share' => $player->scholar_share + $scholar_share,
                            'manager_share' => $player->manager_share + $manager_share,
                        ]
                    );
                }
            }
            else{
                $gained_slp_today = $json_response['total_slp'];
                $thirty_percent   = $gained_slp_today * 0.3;
                $managerShare = 70;
                $scholarShare = 30;
            }

            $lastClaimDate = Carbon::parse($json_response['last_claim']);
            $lastClaimDays = $lastClaimDate->diff(Carbon::now())->days;

            $managerSLP = round($json_response['in_game_slp'] * 0.7);

            BattleLogs::create([
                'ronin_address' => $player['ronin_address'],
                'account_name' => $player['account_name'],
                'average_per_day' => $json_response['in_game_slp'] == 0 ? 0 : ($lastClaimDays == 0 ? 0 : $json_response['in_game_slp'] / $lastClaimDays),
                'gained_slp_today' => $gained_slp_today,
                'unclaimed' => $json_response['in_game_slp'],
                'claimed' => $json_response['ronin_slp'],
                'total_slp' => $json_response['total_slp'],
                'last_claim_days'  => $lastClaimDays,
                'last_claim_date' => Carbon::parse($json_response['last_claim']),
                'claimable_on' => Carbon::parse($json_response['next_claim']),
                'thirty_percent'   => $thirty_percent,
                'forty_percent'    => $forty_percent,
                'draw_total' => $json_response['draw_total'],
                'lose_total' => $json_response['lose_total'],
                'win_total' => $json_response['win_total'],
                'total_matches' => $json_response['total_matches'],
                'win_rate' => $json_response['win_rate'],
                'raw_total' => $json_response['raw_total'],
                'manager_share'    => $managerShare,
                'scholar_share'    => $scholarShare,
                'manager_slp'      => $json_response['in_game_slp'] == 0 ? 0 : $managerSLP,
                'scholar_slp'      => $json_response['in_game_slp'] == 0 ? 0 : $json_response['in_game_slp'] - $managerSLP,
                'lifetime_slp' => $json_response['lifetime_slp'],
                'mmr' => $json_response['mmr'],
                'rank' => $json_response['rank']
            ]);

        }

        $this->line('API Ending: ' . Carbon::now()->format('Y-m-d H:i:s'));
    }
}
