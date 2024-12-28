<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\OrderItem;

class OrderController extends Controller
{
    public function index(Request $request)
    {
        $query = Order::with('orderUser') 
                    ->orderBy('id', 'DESC');

        if ($request->has('search') && $request->input('search') != '') {
            $query->where('name', 'like', '%' . $request->input('search') . '%');
        }

        $data = $query->paginate(10);

        $idCount = $data->total(); 

        return view('admin.order.index', compact('data', 'idCount'));
    }




    public function orderDetail($id) 
    {
        $order = Order::with('items.product')->find($id); 
        if (!$order) {
            return redirect()->route('admin.order')->with('error', 'Không tìm thấy đơn hàng.');
        }

        $data = $order->items;
        return view('admin.order.detail', compact('data', 'order'));
    }

}
