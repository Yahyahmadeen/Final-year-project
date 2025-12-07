<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\Product;
use Carbon\Carbon;

class AnalyticsController extends Controller
{
    public function index()
    {
        $vendor = auth()->user()->vendor;
        
        // Get sales data for the last 30 days
        $endDate = Carbon::now();
        $startDate = $endDate->copy()->subDays(30);
        
        $orders = $vendor->orders()
            ->whereBetween('created_at', [$startDate, $endDate])
            ->get();
            
        $totalSales = $orders->sum('total_amount');
        $totalOrders = $orders->count();
        $totalProducts = $vendor->products()->count();
        
        // Simple analytics data (you can expand this with more metrics)
        $analytics = [
            'total_sales' => $totalSales,
            'total_orders' => $totalOrders,
            'total_products' => $totalProducts,
            'average_order_value' => $totalOrders > 0 ? $totalSales / $totalOrders : 0,
            'sales_data' => $this->getSalesData($vendor, $startDate, $endDate),
        ];
        
        return view('vendors.analytics.index', compact('analytics'));
    }
    
    protected function getSalesData($vendor, $startDate, $endDate)
    {
        $salesData = [];
        $currentDate = $startDate->copy();
        
        while ($currentDate <= $endDate) {
            $date = $currentDate->format('Y-m-d');
            $salesData[$date] = [
                'date' => $date,
                'sales' => 0,
                'orders' => 0,
            ];
            $currentDate->addDay();
        }
        
        // Get actual sales data
        $orders = $vendor->orders()
            ->selectRaw('DATE(created_at) as date, COUNT(*) as order_count, SUM(total_amount) as total_sales')
            ->whereBetween('created_at', [$startDate, $endDate])
            ->groupBy('date')
            ->get();
            
        // Merge the actual data with the initialized array
        foreach ($orders as $order) {
            if (isset($salesData[$order->date])) {
                $salesData[$order->date]['sales'] = (float) $order->total_sales;
                $salesData[$order->date]['orders'] = (int) $order->order_count;
            }
        }
        
        return array_values($salesData);
    }
}
