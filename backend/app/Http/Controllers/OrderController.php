<?php

namespace App\Http\Controllers;

use App\Exports\OrdersExport;
use App\Http\Requests\CreateOrderRequest;
use App\Models\Order;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use PDF;

class OrderController extends Controller
{
    //

    use Exportable;

    public function exportExcel()
    {
        $orders = Order::with('user')->get();

        return Excel::download(new OrdersExport($orders), 'order_report.xlsx');
    }

    public function findByUserId($id)
    {
        $orders = Order::with('user')->whereHas('user', function ($query) use ($id) {
            $query->where('id', $id);
        })->get();

        return $orders;
    }

    public function createOrder(CreateOrderRequest $request)
    {
        $user = User::find($request->input('user_id'));
        if (!$user) {
            return response()->json(['error' => 'User not found'], 404);
        }

        $order = new Order();
        $order->email = $request->input('email');
        $order->postal_code = $request->input('postalCode');
        $order->country_code = $request->input('countryCode');
        $order->total_product = $request->input('totalProduct');
        $order->total_price = $request->input('totalPrice');
        $order->user()->associate($user);
        $order->save();

        return $order;
    }

    public function findAll()
    {
        $orders = Order::with('user')->get();
        return $orders;
    }

    public function deleteOrder($id)
    {
        $order = Order::find($id);
        if (!$order) {
            return response()->json(['error' => 'Order not found'], 404);
        }

        $order->delete();

        return response()->json(['message' => 'Order deleted successfully'], 200);
    }

    public function generatePdf()
    {
        $userId = Auth::id();
        $order = new Order();
        $data['order'] = $order->findByUserId($userId);

        $pdf = PDF::loadView('order/order_pdf', $data);

        return $pdf->download("bukti-order-$userId.pdf");
    }
}
