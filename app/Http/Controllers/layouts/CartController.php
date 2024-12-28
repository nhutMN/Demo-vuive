<?php

namespace App\Http\Controllers\layouts;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Cart;
use App\Models\Product;
use App\Models\Category;
use App\Models\Order;
use App\Models\OrderItem;

class CartController extends Controller
{


    public function addToCart(Product $product, Cart $cart){
        $cart->add($product);
        // dd(session('cart'));
        return redirect()->route('cart.view');
    }

    public function view(Cart $cart){
        $cate = Category::orderBy('id', 'DESC')->get();
        return view('layouts.cart',compact('cart', 'cate'));
    }

    public function deleteCart($id, Cart $cart){
        $cart->delete($id);
        return redirect()->route('cart.view');
    } 

    public function updateCart($id, Cart $cart){
        $quantity = request('quantity', 1);
        $cart->update($id, $quantity);
        return redirect()->route('cart.view');
    } 

    public function checkout(Request $request, Cart $cart)
{
    if (empty($cart->items)) {
        return redirect()->route('cart.view')->with('error', 'Giỏ hàng của bạn đang rỗng.');
    }

    $validated = $request->validate([
        'name' => 'required|string|max:255',
        'email' => 'required|email|max:255',
        'phone' => 'required|string|max:15',
        'address' => 'required|string|max:500',
    ]);

    $order = Order::create([
        'user_id' => auth()->id() ?? null,
        'name' => $validated['name'],
        'email' => $validated['email'],
        'phone' => $validated['phone'],
        'address' => $validated['address'],
        'total_price' => $cart->totalPrice,
        'total_quantity' => $cart->totalQuantity,
        'status' => 'pending',
    ]);

    foreach ($cart->items as $item) {
        OrderItem::create([
            'order_id' => $order->id,
            'product_id' => $item->id,
            'price' => $item->price,
            'quantity' => $item->quantity,
        ]);

        $product = Product::find($item->id);
        if ($product) {
            if ($product->quantity >= $item->quantity) {
                $product->quantity -= $item->quantity;
                $product->save();
            } else {
                return redirect()->route('cart.view')->with('error', "Sản phẩm {$product->name} không đủ hàng trong kho.");
            }
        }
    }

    $cart->clear();

    return redirect()->route('cart.view')->with('success', 'Thanh toán thành công! Đơn hàng của bạn đã được lưu.');
}



}
