<?php

namespace App\Console\Commands;

use App\Models\BattleLogs;
use App\Models\Player;
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

        $players = Player::select('ronin_address', 'account_name')->get();


        foreach($players as $player){
            $roninAddress = str_replace("ronin:","0x",$player['ronin_address']);
            $response = Http::get('https://game-api.axie.technology/api/v1/'.$roninAddress);

            if ($response->failed()) {
                $this->error('Error: Can not access game-api.axie');
                $this->line('SLP Update End: ' . Carbon::now()->format('Y-m-d H:i:s'));
                return 1;
            }

            $json_response = $response->json();

            BattleLogs::create([
                'ronin_address' => $player['ronin_address'],
                'account_name' => $player['account_name'],
                'last_claim_date' => Carbon::parse($json_response['last_claim']),
                'claimable_on' => Carbon::parse($json_response['next_claim']),
                'draw_total' => $json_response['draw_total'],
                'lose_total' => $json_response['lose_total'],
                'win_total' => $json_response['win_total'],
                'total_matches' => $json_response['total_matches'],
                'win_rate' => $json_response['win_rate'],
                'ronin_slp' => $json_response['ronin_slp'],
                'raw_total' => $json_response['raw_total'],
                'in_game_slp' => $json_response['in_game_slp'],
                'lifetime_slp' => $json_response['lifetime_slp'],
                'total_slp' => $json_response['total_slp'],
                'mmr' => $json_response['mmr'],
                'rank' => $json_response['rank']
            ]);

        }

        $this->line('Fetching Battle Logs API End: ' . Carbon::now()->format('Y-m-d H:i:s'));
    }
}
