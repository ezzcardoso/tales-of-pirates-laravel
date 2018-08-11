<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

use App\AccountGamer;
use App\AccountServer;
use App\Character;
use App\Guild;
Use App\StatLog;
class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {

        $getGmAccounts = AccountGamer::where('gm', 99)->get();
        foreach ($getGmAccounts as $gmAccount) {
            $gmAccounts[] = $gmAccount->act_id;
        }
        $getOnlineGMChars = Character::whereIn('act_id', $gmAccounts)->where('delflag', 0)->get();
        $onlineGMChars = array();
        foreach ($getOnlineGMChars as $GMChar) {
            $onlineGMChars[] = ["name" => $GMChar->cha_name,
                "status" => ($GMChar->mem_addr > 0 ? "Online" : "Offline"),
                "type" => ($GMChar->mem_addr > 0 ? "success" : "danger")];
        }

        $statistics = [
            "accounts" => AccountGamer::count(),
            "characters" => Character::count(),
            "guild" => Guild::where('leader_id', '!=', 0)->count(),
            "online" => Character::where('mem_addr', '!=', 0)->count(),
            "max_online" => StatLog::max('play_num')
        ];
        \view()->share('onlineGMChars', $onlineGMChars);
        \view()->share('statistics', $statistics);

    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
