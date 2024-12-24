<?php
namespace App\Models;

class Cart{
    public $items = [];
    public $totalPrice = 0;
    public $totalQuantity = 0;

    public function __construct(){
        $this->items = session('cart') ? session('cart') : [];

        $this->totalQuantity = $this->getTotalQuantity();
        $this->totalPrice = $this->getTotalPrice();
    }

    public function add($product){
        if(isset($this->items[$product->id])){
            $this->items[$product->id]->quantity += 1;
        }else{
            $cartItem = (object)[
                'id' => $product->id,
                'name' => $product->name,
                'image' => $product->image,
                'price' => $product->sale_price ? $product->sale_price : $product->price,
                'quantity' => 1,
            ];
            $this->items[$product->id] = $cartItem;
        }       

        session(['cart'=>$this->items]);
    }

    public function update($id, $qty){
        if(isset($this->items[$id])){
            $this->items[$id]->quantity = $qty;
        }
    }

    public function delete($id){
        if(isset($this->items[$id])){
            unset($this->items[$id]);
            session(['cart'=>$this->items]);
        } 

    }

    public function clear()
{
    $this->items = [];
    $this->totalPrice = 0;
    $this->totalQuantity = 0;

    session()->forget('cart'); // Xóa giỏ hàng khỏi session
}


    private function getTotalPrice(){
        $total = 0;
        foreach($this->items as $item){
            $total += $item->quantity * $item->price;
        }

        return $total;
    }

    private function getTotalQuantity(){
        $total = 0;
        foreach($this->items as $item){
            $total += $item->quantity;
        }

        return $total;
    }
}