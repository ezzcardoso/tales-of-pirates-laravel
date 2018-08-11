<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Resource extends Model
{
    protected $type;
    protected $size;
    protected $maxSize;
    protected $no;
    protected $crc;
    protected $items = array();


    public $table = 'Resource';
    protected $connection = 'DATABASE_GAME';
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
        $decypheredInv = $this->decrypt($cryptedInv, $key);
        $inventory = $this->loadInventory($maxSize, $no, $decypheredInv);
        return ($inventory);
    }

    public function decrypt($input, $key)
    {
        $keyLen = strlen($key);
        $inputLen = strlen($input);
        $result = '';

        for ($i = 0; $i < $inputLen; $i++) {
            $result .= chr(ord($input[$i]) - ord($key[$i % $keyLen]));
        }

        return $result;
    }

    public function loadInventory($maxSize, $no, $input)
    {
        $inventory = new self();

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

        $computedCrc = $this->computeCrc($inventory);

        return $inventory;
    }


    public function computeCrc($inventory)
    {
        $crc = $inventory->type;
        foreach ($inventory->items as $item) {
            $itemAttrCount = count($item);
            for ($i = 0; $i < $itemAttrCount; $i++) {
                if ($i != 0 && $i != 10) {
                    $crc += $item[$i];
                }
            }
        }
        return $this->getSignedValue($crc);
    }

    public function getSignedValue($value)
    {
        $unpacked = unpack('L', pack('l', $value));
        return ($unpacked[1]);
    }
}
