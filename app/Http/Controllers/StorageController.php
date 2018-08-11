<?php

namespace App\Http\Controllers;

use App\Resource;
use App\Storagebox;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class StorageController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (Auth::check()) {
            $user = \App\User::where('id', '=', Auth::user()->id)->get();
        }

        $charectes = isset($user[0]->account->characters) ? $user[0]->account->characters : null;

        $where[] = ["act_id", "=", Auth::user()->act_id];
        $where[] = ["assigned", "=", 0];
        $storages = \App\StorageBox::where($where)->get();

        return view('storage', get_defined_vars());
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
        if (Auth::check()) {
            $users = User::where('id', '=', Auth::user()->id)->get();
        }


        $cha_id = $request->has('cha_id') ? $request->get('cha_id') : 0;
        $user_act_id = (int)(User::where('id', '=', Auth::user()->id)->get()->toArray())[0]['act_id'];
        if (Resource::CheckValidCharacter($cha_id, $user_act_id)) {

            if (!Resource::CheckValidItem($request->get('storage_id'), $user_act_id)) {
                return response()->json(['errors' => 'item selected is Invalid!']);
            }

            $where_storage[] = ["storage_id", "=", $request->get('storage_id')];
            $item = Storagebox::where($where_storage)->get();
            $AssignItem = addslashes(trim($item[0]->item_id));
            $TargetCharacter = addslashes(trim($request->get('cha_id')));
            $Quantity = addslashes(trim($item[0]->quantity));

            if (!ctype_digit($AssignItem)) {
                return \response('Unable to process your action');
            }


            $QuantityToAssign = $Quantity;
            $ItemToAssign = $AssignItem;
            $DurabilityToAssign = 20000;
            $itemsToAdd[] = array('ID' => $ItemToAssign,
                'QUANTITY' => $QuantityToAssign,
                'DURABILITY' => $DurabilityToAssign);

            $InventoryType = Resource::DefineInventoryType('Inventory');
            $where_resource[] = ["type_id", "=", $InventoryType];
            $where_resource[] = ["cha_id", "=", $TargetCharacter];
            $resource = Resource::where($where_resource)->pluck('content')->toArray();
            $InventoryValue = $resource[0];


            $resource_class = new Resource();

            $Inventory = $resource_class->loadEncodedInventory($InventoryValue, Resource::CRYPT_KEY);
            $Inventory = $resource_class->addItemsToInventory($Inventory, $itemsToAdd, $QuantityToAssign);

            if (!$Inventory) {
                return response()->json(['errors' => 'Unable to assign: Inventory Full!']);
            } else {
                $FinalInventory = Resource::getEncodedInventory($Inventory, Resource::CRYPT_KEY);
                $resource_final = Resource::where($where_resource)
                    ->update(['content' => $FinalInventory]);

                if ($resource_final) {
                    $update['assigned'] = 1;
                    $update['assigned_char'] = $cha_id;
                    $update['assigned_date'] = Carbon::now();
                    $where_box['storage_id'] = $request->get('storage_id');
                    $where_box['assigned'] = 0;
                    $update_storage = Storagebox::where($where_box)
                        ->update($update);

                    if ($update_storage) {

                        return response()->json(['success' => 'check your character game #ACT548']);

                    }

                    return response()->json(['success' => 'check your character game #ACT6895']);


                } else {

                    return response()->json(['errors' => 'error to update']);
                }

            }
        } else {

            return response()->json(['errors' => 'No Character Selectd, Character is Online or Character Invalid!']);

        }

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
}
