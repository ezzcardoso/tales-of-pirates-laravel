<?php

namespace App\Http\Controllers;

use App\AccountServer;
use App\User;
use App\Guild;
use App\Character;
use App\Downloads;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {

    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        if (Auth::check()) {
            $user = User::where('id','=',Auth::user()->id)->get();
        }


        return view('home', get_defined_vars());
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function downloads()
    {
        if (Auth::check()) {
            $user = User::where('id','=',Auth::user()->id)->get();
        }
        // 10 downloads per page to be shown
        $downloads = array();//Downloads::paginate(10);
        return view('downloads',get_defined_vars());
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function ranking()
    {
        if (Auth::check()) {
            $user = User::where('id','=',Auth::user()->id)->get();
        }
        // 3 types of rankings
        // 1. By experience / level
        // 2. By gold
        // 3. By guild members
        // get all the unbanned accounts and store them in an array which is used later in the JOIN query
        $getUnbannedAccounts = AccountServer::where('ban',0)->select('id')->get();
        foreach($getUnbannedAccounts as $unbannedAccount)
        {
            $unbannedAccounts[] = $unbannedAccount->id;
        }
        // natural join character table with account table to find accounts that are not gms
        $getCharacters = Character::join('account',function($join) use ($unbannedAccounts)
        {
            $join->on('character.act_id','=','account.act_id')->where('gm',0);
        })->whereIn('account.act_id',$unbannedAccounts)->get(); // make sure they are not banned too
        // sort them according to need and take the top 30.
        $charactersbyLevel = $getCharacters->sortByDesc('degree')->take(30);
        $charactersByGold = $getCharacters->sortByDesc('gd')->take(30);
        $charactersByReputation = $getCharacters->sortByDesc('credit')->take(30);
        // join guild with the character table to check guilds having their leader id with the character ids to find the accounts
        $getGuilds = Guild::join('character',function($join)
        {
            $join->on('guild.leader_id','=','character.cha_id');
        })->join('account',function($join) use ($unbannedAccounts)
        {
            $join->on('character.act_id','=','account.act_id')->where('gm',0)->whereIn('account.act_id',$unbannedAccounts); // make sure they're not gms and they're not banned.
        })->get()->sortByDesc('member_total')->take(30);  // sort as needed and take top 30 results
        return view('ranking',get_defined_vars());

    }
}
