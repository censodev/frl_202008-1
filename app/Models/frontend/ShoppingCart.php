<?php

namespace App\Models\frontend;

use Illuminate\Database\Eloquent\Model;

class ShoppingCart extends Model
{
    public $items = null;
	public $totalQty = 0;
    public $totalPrice = 0;
    
    public function __construct($oldCart){
		if($oldCart){
			$this->items = $oldCart->items;
			$this->totalQty = $oldCart->totalQty;
			$this->totalPrice = $oldCart->totalPrice;
		}
	}

	public function add($item, $id, $qty){
		$giohang = ['qty'=>0, 'price' => !empty( $item->price_promotion ) ? $item->price_promotion : $item->price_product, 'item' => $item];
		if($this->items){
			if(array_key_exists($id, $this->items)){
				$giohang = $this->items[$id];
			}
		}
		$giohang['qty'] = $giohang['qty'] + $qty;
		$giohang['price'] = !empty( $item->price_promotion ) ? $item->price_promotion : $item->price_product * $giohang['qty'];
		$this->items[$id] = $giohang;
		$this->totalQty++;
		$this->totalPrice += !empty( $item->price_promotion ) ? $item->price_promotion : $item->price_product;
	}

	//xóa 1
	public function reduceByOne($id){
		$this->items[$id]['qty']--;
		$this->items[$id]['price'] -= $this->items[$id]['item']['price'];
		$this->totalQty--;
		$this->totalPrice -= $this->items[$id]['item']['price'];
		if($this->items[$id]['qty']<=0){
			unset($this->items[$id]);
		}
	}

	//xóa nhiều
	public function removeItem($id){
		$this->totalQty -= $this->items[$id]['qty'];
		$this->totalPrice -= $this->items[$id]['price'];
		unset($this->items[$id]);
	}
}
