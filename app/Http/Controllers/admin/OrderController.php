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
        $query = Order::query();

        if ($request->has('search') && $request->input('search') != '') {
            $query->where('name', 'like', '%' . $request->input('search') . '%');
        }

        $data = $query->orderBy('id', 'DESC')->get();
        $idCount = $data->count(); 
        return view('admin.order.index', compact('data', 'idCount'));
    }


    public function orderDetail($id) // Nhận id đơn hàng
    {
        $order = Order::with('items.product')->find($id); // Lấy đơn hàng cùng sản phẩm
        if (!$order) {
            return redirect()->route('admin.order')->with('error', 'Không tìm thấy đơn hàng.');
        }

        $data = $order->items;
        return view('admin.order.detail', compact('data', 'order'));
    }

    public function exportHtml($id)
    {
        $order = Order::with('items.product')->find($id);
        if (!$order) {
            return redirect()->route('admin.order')->with('error', 'Không tìm thấy đơn hàng.');
        }

        $data = $order->items;

        // Định dạng font Calibri và cỡ chữ, thêm mã hóa UTF-8 để hiển thị tiếng Việt
        $html = "
        <html xmlns:x='urn:schemas-microsoft-com:office:excel'>
            <head>
                <meta charset='UTF-8'>
                <style>
                    body {
                        font-family: Calibri, sans-serif;
                        margin: 0;
                        padding: 20px;
                        background-color: #f4f4f4;
                    }

                    .invoice-container {
                        background: #fff;
                        padding: 30px;
                        border-radius: 10px;
                        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
                        max-width: 800px;
                        margin: 0 auto;
                    }

                    .invoice-header {
                        text-align: center;
                        margin-bottom: 30px;
                    }

                    .invoice-header h2 {
                        margin: 0;
                        font-size: 24px;
                        color: #333;
                    }

                    .invoice-header p {
                        margin: 5px 0;
                        font-size: 16px;
                        color: #555;
                    }

                    .invoice-details {
                        margin-bottom: 30px;
                    }

                    .invoice-details p {
                        font-size: 16px;
                        margin: 8px 0;
                    }

                    table {
                        width: 100%;
                        border-collapse: collapse;
                        margin-top: 20px;
                    }

                    table th, table td {
                        border: 1px solid #ddd;
                        padding: 10px;
                        text-align: left;
                    }

                    table th {
                        background-color: #f7f7f7;
                        color: #333;
                        font-size: 16px;
                    }

                    table td {
                        font-size: 14px;
                        color: #555;
                    }

                    .total-price {
                        margin-top: 20px;
                        text-align: right;
                        font-size: 18px;
                        font-weight: bold;
                        color: #333;
                    }
                </style>
            </head>
            <body>
                <div class='invoice-container'>
                    <div class='invoice-header'>
                        <h2>Hóa Đơn Mua Hàng</h2>
                        <p><strong>Mã Đơn Hàng:</strong> #{$order->id}</p>
                    </div>

                    <div class='invoice-details'>
                        <p><strong>Tên người mua:</strong> {$order->name}</p>
                        <p><strong>Gmail:</strong> {$order->email}</p>
                        <p><strong>Số điện thoại:</strong> {$order->phone}</p>
                        <p><strong>Địa chỉ:</strong> {$order->address}</p>
                        <p><strong>Tổng giá:</strong> " . number_format($order->total_price, 0, ',', '.') . " VND</p>
                    </div>

                    <table>
                        <thead>
                            <tr>
                                <th>Tên sản phẩm</th>
                                <th>Giá</th>
                                <th>Số lượng</th>
                                <th>Tổng giá</th>
                            </tr>
                        </thead>
                        <tbody>";
            
        foreach ($data as $item) {
            $html .= "
                <tr>
                    <td>{$item->product->name}</td>
                    <td>" . number_format($item->price, 0, ',', '.') . " VND</td>
                    <td>{$item->quantity}</td>
                    <td>" . number_format($item->price * $item->quantity, 0, ',', '.') . " VND</td>
                </tr>";
        }

        $html .= "</tbody></table>
                <div class='total-price'>
                    <p><strong>Tổng cộng: " . number_format($order->total_price, 0, ',', '.') . " VND</strong></p>
                </div>
            </div>
        </body>
    </html>";

        // Đặt tên file là "order_{id}.xls" để Excel nhận diện đúng định dạng
        $fileName = 'order_' . $id . '.xls';
        header("Content-Type: application/vnd.ms-excel");
        header("Content-Disposition: attachment; filename=$fileName");

        echo $html;
        exit;
    }

    public function exportRevenueHtml()
    {
        // Calculate total revenue
        $totalRevenue = Order::sum('total_price');

        // Retrieve order data for exporting
        $data = Order::all();

        // Generate HTML for export
        $html = "
        <html xmlns:x='urn:schemas-microsoft-com:office:excel'>
            <head>
                <meta charset='UTF-8'>
                <style>
                    body {
                        font-family: 'Arial', sans-serif;
                        margin: 0;
                        padding: 20px;
                        background-color: #f4f4f9;
                    }

                    .revenue-container {
                        background: #fff;
                        padding: 40px;
                        border-radius: 12px;
                        box-shadow: 0 4px 16px rgba(0, 0, 0, 0.1);
                        max-width: 900px;
                        margin: 0 auto;
                        font-size: 16px;
                        line-height: 1.5;
                    }

                    .revenue-header {
                        text-align: center;
                        margin-bottom: 40px;
                    }

                    .revenue-header h2 {
                        margin: 0;
                        font-size: 30px;
                        color: #2C3E50;
                        font-weight: bold;
                    }

                    .revenue-details {
                        margin-bottom: 20px;
                    }

                    .revenue-details p {
                        font-size: 18px;
                        margin: 10px 0;
                        color: #34495E;
                    }

                    .revenue-details p strong {
                        font-weight: 600;
                        color: #2C3E50;
                    }

                    table {
                        width: 100%;
                        border-collapse: collapse;
                        margin-top: 30px;
                    }

                    table th, table td {
                        border: 1px solid #ddd;
                        padding: 12px 15px;
                        text-align: left;
                        color: #555;
                    }

                    table th {
                        background-color: #2980B9;
                        color: #fff;
                        font-size: 18px;
                    }

                    table td {
                        background-color: #ecf0f1;
                        font-size: 16px;
                    }

                    .total-revenue {
                        margin-top: 30px;
                        text-align: right;
                        font-size: 22px;
                        font-weight: bold;
                        color: #2980B9;
                    }

                    .total-revenue p {
                        margin: 10px 0;
                        color: #2C3E50;
                    }

                    .footer {
                        margin-top: 40px;
                        text-align: center;
                        font-size: 14px;
                        color: #7f8c8d;
                    }

                    .footer p {
                        margin: 5px 0;
                    }
                </style>
            </head>
            <body>
                <div class='revenue-container'>
                    <div class='revenue-header'>
                        <h2>Tổng Doanh Thu</h2>
                        <p>Thống kê tổng doanh thu từ các đơn hàng</p>
                    </div>

                    <div class='revenue-details'>
                        <p><strong>Tổng doanh thu:</strong> " . number_format($totalRevenue, 0, ',', '.') . " VND</p>
                    </div>
                    
                    <table>
                        <thead>
                            <tr>
                                <th>Mã đơn hàng</th>
                                <th>Tên người mua</th>
                                <th>Giá trị đơn hàng</th>
                                <th>Ngày tạo</th>
                            </tr>
                        </thead>
                        <tbody>";

                        // Loop through each order and display its details
                        foreach ($data as $item) {
                            $html .= "
                            <tr>
                                <td>#{$item->id}</td>
                                <td>{$item->name}</td>
                                <td>" . number_format($item->total_price, 0, ',', '.') . " VND</td>
                                <td>{$item->created_at->format('d/m/Y')}</td>
                            </tr>";
                        }

        $html .= "
                        </tbody>
                    </table>

                    <div class='total-revenue'>
                        <p><strong>Tổng cộng:</strong> " . number_format($totalRevenue, 0, ',', '.') . " VND</p>
                    </div>

                    <div class='footer'>
                        <p>Website: www.example.com</p>
                        <p>Liên hệ: support@example.com</p>
                    </div>

                    
                </div>
            </body>
        </html>";

        // Set the filename for the export
        $fileName = 'total_revenue.xls';

        // Export the HTML as an Excel file
        header("Content-Type: application/vnd.ms-excel");
        header("Content-Disposition: attachment; filename=$fileName");

        echo $html;
        exit;
    }

    public function exportRevenueHtmlMonth()
    {
        // Get the current year
        $currentYear = date('Y');
        
        // Calculate total revenue for the current year
        $totalRevenue = Order::whereYear('created_at', $currentYear)->sum('total_price');

        // Retrieve orders by month for the current year, including order details
        $monthlyRevenue = Order::whereYear('created_at', $currentYear)
                                ->selectRaw('MONTH(created_at) as month, SUM(total_price) as total_monthly_revenue')
                                ->groupBy('month')
                                ->orderBy('month')
                                ->get();

        // Generate HTML for export
        $html = "
        <html xmlns:x='urn:schemas-microsoft-com:office:excel'>
            <head>
                <meta charset='UTF-8'>
                <style>
                    body {
                        font-family: 'Arial', sans-serif;
                        margin: 0;
                        padding: 20px;
                        background-color: #f4f4f9;
                    }

                    .revenue-container {
                        background: #fff;
                        padding: 40px;
                        border-radius: 12px;
                        box-shadow: 0 4px 16px rgba(0, 0, 0, 0.1);
                        max-width: 900px;
                        margin: 0 auto;
                        font-size: 16px;
                        line-height: 1.5;
                    }

                    .revenue-header {
                        text-align: center;
                        margin-bottom: 40px;
                    }

                    .revenue-header h2 {
                        margin: 0;
                        font-size: 30px;
                        color: #2C3E50;
                        font-weight: bold;
                    }

                    .revenue-details {
                        margin-bottom: 20px;
                    }

                    .revenue-details p {
                        font-size: 18px;
                        margin: 10px 0;
                        color: #34495E;
                    }

                    .revenue-details p strong {
                        font-weight: 600;
                        color: #2C3E50;
                    }

                    table {
                        width: 100%;
                        border-collapse: collapse;
                        margin-top: 30px;
                    }

                    table th, table td {
                        border: 1px solid #ddd;
                        padding: 12px 15px;
                        text-align: left;
                        color: #555;
                    }

                    table th {
                        background-color: #2980B9;
                        color: #fff;
                        font-size: 18px;
                    }

                    table td {
                        background-color: #ecf0f1;
                        font-size: 16px;
                    }

                    .total-revenue {
                        margin-top: 30px;
                        text-align: right;
                        font-size: 22px;
                        font-weight: bold;
                        color: #2980B9;
                    }

                    .total-revenue p {
                        margin: 10px 0;
                        color: #2C3E50;
                    }

                    .footer {
                        margin-top: 40px;
                        text-align: center;
                        font-size: 14px;
                        color: #7f8c8d;
                    }

                    .footer p {
                        margin: 5px 0;
                    }
                </style>
            </head>
            <body>
                <div class='revenue-container'>
                    <div class='revenue-header'>
                        <h2>Tổng Doanh Thu - Năm $currentYear theo tháng</h2>
                        <p>Thống kê tổng doanh thu theo tháng</p>
                    </div>";

                    // Loop through each month and display its corresponding revenue and orders
                    foreach ($monthlyRevenue as $item) {
                        $monthName = date('F', mktime(0, 0, 0, $item->month, 10)); // Get month name
                        
                        // Retrieve the orders for the current month
                        $orders = Order::whereYear('created_at', $currentYear)
                                    ->whereMonth('created_at', $item->month)
                                    ->get();

                        $html .= "
                    <div class='monthly-revenue'>
                        <h3>Doanh thu tháng: {$monthName}</h3>
                        <p><strong>Tổng doanh thu trong tháng:</strong> " . number_format($item->total_monthly_revenue, 0, ',', '.') . " VND</p>

                        <table>
                            <thead>
                                <tr>
                                    <th>Mã đơn hàng</th>
                                    <th>Tên người mua</th>
                                    <th>Giá trị đơn hàng</th>
                                    <th>Ngày tạo</th>
                                </tr>
                            </thead>
                            <tbody>";

                            // Loop through orders for this month
                            foreach ($orders as $order) {
                                $html .= "
                                <tr>
                                    <td>#{$order->id}</td>
                                    <td>{$order->name}</td>
                                    <td>" . number_format($order->total_price, 0, ',', '.') . " VND</td>
                                    <td>{$order->created_at->format('d/m/Y')}</td>
                                </tr>";
                            }

                        $html .= "
                            </tbody>
                        </table>
                    </div>"; // End of monthly revenue section
                    }

        $html .= "
                    <div class='total-revenue'>
                        <p><strong>Tổng cộng:</strong> " . number_format($totalRevenue, 0, ',', '.') . " VND</p>
                    </div>

                    <div class='footer'>
                        <p>Website: www.example.com</p>
                        <p>Liên hệ: support@example.com</p>
                    </div>
                </div>
            </body>
        </html>";

        // Set the filename for the export
        $fileName = 'total_revenue_monthly_' . $currentYear . '.xls';

        // Export the HTML as an Excel file
        header("Content-Type: application/vnd.ms-excel");
        header("Content-Disposition: attachment; filename=$fileName");

        echo $html;
        exit;
    }
}
