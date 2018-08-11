<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Resource extends Model
{
    const CRYPT_KEY = '19800216';
    protected $type;
    protected $size;
    protected $maxSize;
    protected $no;
    protected $crc;
    protected $items = array();


    public $table = 'Resource';
    protected $connection = 'DATABASE_GAME';
    public $timestamps = false;
    public $fillable = [
        'cha_id',
        'type_id',
        'content'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'cha_id' => 'integer',
        'content' => 'string'
    ];

    public function loadEncodedInventory($cryptedInv, $key)
    {
        list($maxSize, $no, $cryptedInv) = preg_split("/[@#]/", $cryptedInv, 3);

        $decypheredInv = self::decrypt($cryptedInv, $key);
        $inventory = self::loadInventory($maxSize, $no, $decypheredInv);
        return ($inventory);
    }

    static public function decrypt($input, $key)
    {
        $keyLen = strlen($key);
        $inputLen = strlen($input);
        $result = '';

        for ($i = 0; $i < $inputLen; $i++) {
            $result .= chr(ord($input[$i]) - ord($key[$i % $keyLen]));
        }

        return $result;
    }

    static public function loadInventory($maxSize, $no, $input)
    {
        $inventory = new \App\Resource();


        $inventory->rawData = $input;
        $data = explode(';', $input);
        $dataCount = count($data);

        $inventory->no = $no;
        $inventory->maxSize = $maxSize;
        $inventory->type = $data[0];
        $inventory->size = $data[1];
        $inventory->crc = $data[$dataCount - 1];


        for ($i = 0; $i < $inventory->maxSize; $i++) {
            $inventory->items[$i] = null;
        }

        for ($i = 2; $i < $dataCount - 1; $i++) {
            $item = explode(',', $data[$i]);
            $inventory->items[$item[0]] = $item;
        }

        $computedCrc = self::computeCrc($inventory);

        return $inventory;
    }


    static public function computeCrc($inventory)
    {

        $crc = $inventory->type;
        foreach ($inventory->items as $item) {
            $itemAttrCount = is_array($item) ? count($item) : 0;
            for ($i = 0; $i < $itemAttrCount; $i++) {
                if ($i != 0 && $i != 10) {
                    $crc += $item[$i];
                }
            }
        }

        return self::getSignedValue($crc);
    }

    static public function getSignedValue($value)
    {

        $unpacked = unpack('L', pack('l', $value));
        return ($unpacked[1]);
    }

    public function addItemsToInventory($inventory, $itemList, $Quantity)
    {

        // Iterate over the inventory to add the items in first encountered free slot.
        $itemAssigned = 0;
        for ($i = 0; (($i < $inventory->maxSize) && ($itemAssigned < count($itemList))); $i++) {
            if ($inventory->items[$i] == null) {
                // Assign item to that free slot.
                $inventory->items[$i] = array($i, $itemList[$itemAssigned]['ID'], $Quantity, $itemList[$itemAssigned]['DURABILITY'], $itemList[$itemAssigned]['DURABILITY'], 0, 0, 0, 0, 0, 0);
                $itemAssigned++;
            }
        }

        if ($itemAssigned == count($itemList)) {

        } else {
            // not enought space;
            return false;
        }
        // Update the inventory size
        $inventory->size += $itemAssigned;
        // Update the crc
        $inventory->crc = self::computeCrc($inventory);
        // Update the inventory raw data.
        $inventory->rawData = $inventory->type . ';' . $inventory->size . ';';
        $itemRawData = array();
        for ($i = 0; $i < $inventory->maxSize; $i++) {
            if ($inventory->items[$i] != null) {
                $itemRawData[] = implode(',', $inventory->items[$i]);
            }
        }
        $inventory->rawData .= implode(';', $itemRawData);
        $inventory->rawData .= ';' . $inventory->crc;
        return $inventory;
    }

    static public function encrypt($input, $key)
    {
        $keyLen = strlen($key);
        $inputLen = strlen($input);
        $result = '';

        for ($i = 0; $i < $inputLen; $i++) {
            $result .= chr(ord($input[$i]) + ord($key[$i % $keyLen]));
        }

        return $result;
    }

    static public function getEncodedInventory($inventory, $key)
    {
        $output = $inventory->maxSize .
            '@' . $inventory->no .
            '#' . Self::encrypt($inventory->rawData, $key);
        return $output;
    }

    static public function CheckValidCharacter(int $Character,int $account_id)
    {

        $where_resource[] = ["cha_id", "=", $Character];
        $oRow = (\App\Character::where($where_resource)->get()->toArray())[0];

        if ($oRow['act_id'] == $account_id && count($oRow) > 0 && !empty($Character) && $oRow['mem_addr'] == 0 && $oRow['delflag'] != 1) {
            return true;
        } else {
            return false;

        }
    }

    static public function DefineInventoryType($Inventory)
    {
        switch ($Inventory) {
            case 'Inventory':
                return 1;
                break;
            case 'Bank':
                return 2;
                break;
            case 'Temporary':
                return 3;
                break;
            default:
                return 1;
                break;
        }
    }

    static public function CheckValidItem(int $StorageItem, int $accout_id)
    {


        $oRow = (\App\Storagebox::where('storage_id', $StorageItem)->get()->toArray())[0];
        $Account = (int) trim($oRow['act_id']);
        $Item = (int) trim($oRow['item_id']);
        $Assigned =(int) trim($oRow['assigned']);

        if ($Account == $accout_id && $Item && $Assigned < 1 || $Assigned == 0) {
            return true;
        } else {
            return false;
        }
    }
}
