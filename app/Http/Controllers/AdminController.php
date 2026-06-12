<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use App\Models\User;
use App\Models\Tag;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function dashboard()
    {
        // ── Cards de resumo ──
        $totalProducts = Product::count();
        $totalUsers = User::count();
        $totalPendingOrders = Order::where('status', 'pending')->count();
        $totalRevenue = Order::where('status', 'approved')->sum('total');

        // ── Pedidos recentes ──
        $recentOrders = Order::with('user')
            ->latest()
            ->take(10)
            ->get();

        // ── Gráfico: pedidos por mês (últimos 6 meses) ──
        $ordersByMonth = Order::selectRaw("DATE_FORMAT(created_at, '%m/%Y') as month, COUNT(*) as total")
            ->where('created_at', '>=', now()->subMonths(6))
            ->groupByRaw("DATE_FORMAT(created_at, '%m/%Y')")
            ->orderByRaw("MIN(created_at)")
            ->get();

        // ── Gráfico: produtos mais vendidos (top 5) ──
        $topProducts = OrderItem::selectRaw('product_id, SUM(units) as total_vendido')
            ->with('product:id,name')
            ->groupBy('product_id')
            ->orderByDesc('total_vendido')
            ->take(5)
            ->get()
            ->map(fn($item) => [
                'name' => $item->product->name ?? '—',
                'total_vendido' => $item->total_vendido,
            ]);

        // ── Gráfico: usuários por mês (últimos 6 meses) ──
        $usersByMonth = User::selectRaw("strftime('%m/%Y', created_at) as month, COUNT(*) as total")
            ->where('created_at', '>=', now()->subMonths(6))
            ->groupByRaw("strftime('%m/%Y', created_at)")
            ->orderByRaw("strftime('%Y%m', created_at)")
            ->get();

        // ── Sidebar ──
        $categories = Category::withCount('products')->get();

        return view('admin.dashboard', compact(
            'totalProducts',
            'totalUsers',
            'totalPendingOrders',
            'totalRevenue',
            'recentOrders',
            'ordersByMonth',
            'topProducts',
            'usersByMonth',
            'categories',
        ));
    }

    // Aprovar pedido
    public function approveOrder(Order $order)
    {
        $order->update(['status' => 'approved']);
        return redirect()->back()->with('success', 'Pedido #' . $order->id . ' aprovado!');
    }

    // Cancelar pedido
    public function cancelOrder(Order $order)
    {
        $order->update(['status' => 'cancelled']);
        return redirect()->back()->with('success', 'Pedido #' . $order->id . ' cancelado.');
    }
    public function orders(Request $request)
    {
        $orders = Order::with('user')
            ->when($request->status, fn($q) => $q->where('status', $request->status))
            ->orderBy('created_at', 'desc')
            ->paginate(20);

        $categories = Category::withCount('products')->get();

        $recentOrders = Order::with('user')
            ->latest()
            ->take(10)
            ->get();

        return view('admin.order.index', compact(
            'orders',
            'categories'
        ));
    }


}