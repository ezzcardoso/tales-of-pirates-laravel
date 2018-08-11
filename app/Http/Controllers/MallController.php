<?php

namespace App\Http\Controllers;

use App\Mall;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MallController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (\Auth::check()) {
            $user = \App\User::where('id', '=', \Auth::user()->id)->get();
        }

        $malls = \App\Mall::paginate(50);
        return view('mall', get_defined_vars());
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function buy(Request $request)
    {


        $item = \App\Mall::find($request->MallID);
        if ($item->Quota > 0) {

            $price = (int)$item->ItemPrice;
            $user = User::find(Auth::user()->id);
            $user->account->mall_points = Mall::subtract_value($user->account->mall_points, $price);


            $storage = new \App\StorageBox();
            $storage->act_id = Auth::user()->act_id;
            $storage->item_id = trim($item->MallID);
            $storage->assigned = 0;
            $storage->assigned_char = null;
            $storage->assigned_date = null;
            $storage->Icon = trim($item->Icon);
            $storage->ItemMall = trim($item->ItemName);
            $storage->quantity = trim($item->quantity);

            $item->Quota = $item->Quota - 1;

            if ($storage->save() and $item->save()) {
                $user->account->save();
                return response()->json(['success' => 'Record is successfully added to Storage']);
            } else {
                return response()->json(['errors' => 'Record is not successfully added']);
            }
        } else {

            return response()->json(['errors' => 'Item is finished']);
        }


    }
}
