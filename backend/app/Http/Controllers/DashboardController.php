<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $userCount = User::count();
        $productCount = Product::count();
        $orderCount = Order::count();
        $monthlyRevenue = $this->calculateMonthlyRevenue();
        $totalRevenue = Order::sum('total_price');

        return response()->json([
            'user' => $userCount,
            'product' => $productCount,
            'order' => $orderCount,
            'monthly_revenue' => $monthlyRevenue,
            'total_revenue' => $totalRevenue,
        ]);
    }

    private function calculateMonthlyRevenue()
    {
        $monthlyRevenue = [];

        for ($month = 1; $month <= 12; $month++) {
            $revenue = Order::whereMonth('created_at', $month)->sum('total_price');
            $monthlyRevenue[] = $revenue;
        }

        return $monthlyRevenue;
    }
}
