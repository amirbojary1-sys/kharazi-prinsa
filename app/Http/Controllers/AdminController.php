<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Coupon;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Models\Setting;
use App\Models\Subcategory;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{
    /* ---------------- auth ---------------- */

    public function loginForm()
    {
        return view('admin.login');
    }

    public function login(Request $request)
    {
        $data = $request->validate([
            'email'    => 'required|email',
            'password' => 'required',
        ]);

        $user = User::where('email', $data['email'])->first();
        if ($user && Hash::check($data['password'], $user->password)) {
            session(['admin_id' => $user->id, 'admin_name' => $user->name]);
            return redirect()->route('admin.dashboard');
        }
        return back()->withErrors(['email' => __('messages.admin_wrong')]);
    }

    public function logout()
    {
        session()->forget(['admin_id', 'admin_name']);
        return redirect()->route('home');
    }

    /* ---------------- dashboard ---------------- */

    public function dashboard()
    {
        $days = collect(range(13, 0))->map(function ($i) {
            $day = now()->subDays($i)->startOfDay();
            $sum = Order::where('status', '!=', 'cancelled')
                ->whereBetween('created_at', [$day, $day->copy()->endOfDay()])
                ->sum('total');
            return ['label' => $day->format('m/d'), 'value' => (int) $sum];
        });

        $topProducts = OrderItem::query()
            ->select('product_id', 'name_fa', 'name_en', 'image', DB::raw('SUM(qty) as sold'), DB::raw('SUM(qty * price) as revenue'))
            ->groupBy('product_id', 'name_fa', 'name_en', 'image')
            ->orderByDesc('sold')
            ->take(6)
            ->get();

        return view('admin.dashboard', [
            'stats'  => [
                'products'  => Product::count(),
                'orders'    => Order::count(),
                'revenue'   => (int) Order::where('status', '!=', 'cancelled')->sum('total'),
                'customers' => Order::whereNotNull('user_id')->distinct()->count('user_id') + Order::whereNull('user_id')->distinct()->count('phone'),
                'today'     => (int) Order::where('status', '!=', 'cancelled')->whereDate('created_at', today())->sum('total'),
                'pending'   => Order::where('status', 'pending')->count(),
                'paid'      => Order::where('status', 'paid')->count(),
                'low_stock' => Product::where('stock', '<=', 3)->count(),
            ],
            'orders'      => Order::with('items')->latest()->take(8)->get(),
            'chart'       => $days,
            'chartMax'    => max(1, (int) $days->max('value')),
            'topProducts' => $topProducts,
        ]);
    }

    /* ---------------- products ---------------- */

    public function products(Request $request)
    {
        $q = trim((string) $request->input('q', ''));
        $products = Product::with('category')
            ->when($q !== '', function ($qq) use ($q) {
                $qq->where(fn ($w) => $w->where('name_fa', 'like', "%{$q}%")->orWhere('name_en', 'like', "%{$q}%"));
            })
            ->when($request->input('cat'), fn ($qq) => $qq->where('category_id', $request->input('cat')))
            ->latest()->get();

        return view('admin.products', [
            'products'   => $products,
            'categories' => Category::all(),
        ]);
    }

    public function createProduct()
    {
        return view('admin.product-form', [
            'product'       => null,
            'categories'    => Category::all(),
            'subcategories' => Subcategory::all(),
        ]);
    }

    public function storeProduct(Request $request)
    {
        $data = $this->validateProduct($request);
        Product::create($data);
        return redirect()->route('admin.products')->with('ok', '✓');
    }

    public function editProduct(int $id)
    {
        return view('admin.product-form', [
            'product'       => Product::findOrFail($id),
            'categories'    => Category::all(),
            'subcategories' => Subcategory::all(),
        ]);
    }

    public function updateProduct(Request $request, int $id)
    {
        $data = $this->validateProduct($request);
        Product::findOrFail($id)->update($data);
        return redirect()->route('admin.products')->with('ok', '✓');
    }

    public function destroyProduct(int $id)
    {
        Product::findOrFail($id)->delete();
        return back();
    }

    private function validateProduct(Request $request): array
    {
        $data = $request->validate([
            'name_fa'       => 'required|string|max:150',
            'name_en'       => 'required|string|max:150',
            'desc_fa'       => 'nullable|string',
            'desc_en'       => 'nullable|string',
            'price'         => 'required|integer|min:0',
            'stock'         => 'required|integer|min:0',
            'category_id'   => 'required|exists:categories,id',
            'subcategory_id'=> 'nullable|exists:subcategories,id',
            'image'         => 'nullable|string|max:255',
        ]);
        $data['featured'] = $request->boolean('featured');
        $data['image'] = ($data['image'] ?? '') ?: 'images/cat-buttons.jpg';
        $data['desc_fa'] = $data['desc_fa'] ?? null;
        $data['desc_en'] = $data['desc_en'] ?? null;
        return $data;
    }

    /* ---------------- orders ---------------- */

    public function orders(Request $request)
    {
        $status = (string) $request->input('status', '');
        $q      = trim((string) $request->input('q', ''));

        $orders = Order::with('items')
            ->when(in_array($status, ['pending', 'paid', 'shipped', 'delivered', 'cancelled'], true), fn ($qq) => $qq->where('status', $status))
            ->when($q !== '', fn ($qq) => $qq->where(fn ($w) => $w->where('code', 'like', "%{$q}%")
                ->orWhere('customer_name', 'like', "%{$q}%")
                ->orWhere('phone', 'like', "%{$q}%")))
            ->latest()->get();

        return view('admin.orders', compact('orders'));
    }

    public function orderShow(int $id)
    {
        $order = Order::with('items.product')->findOrFail($id);
        return view('admin.order-show', compact('order'));
    }

    public function updateStatus(Request $request, int $id)
    {
        $request->validate(['status' => 'required|in:pending,paid,shipped,delivered,cancelled']);
        Order::findOrFail($id)->update(['status' => $request->input('status')]);
        return back()->with('ok', '✓');
    }

    /* ---------------- customers ---------------- */

    public function customers()
    {
        $users = User::withCount('orders')->withSum('orders', 'total')->latest()->get();

        $guests = Order::whereNull('user_id')
            ->select('customer_name', 'phone', DB::raw('COUNT(*) as orders_count'), DB::raw('SUM(total) as total_sum'), DB::raw('MAX(created_at) as last_order'))
            ->groupBy('customer_name', 'phone')
            ->orderByDesc('orders_count')
            ->get();

        return view('admin.customers', compact('users', 'guests'));
    }

    public function customerShow(int $id)
    {
        $customer = User::findOrFail($id);
        $orders   = Order::where('user_id', $id)->with('items')->latest()->get();
        return view('admin.customer-show', compact('customer', 'orders'));
    }

    /* ---------------- coupons ---------------- */

    public function coupons()
    {
        return view('admin.coupons', ['coupons' => Coupon::latest()->get()]);
    }

    public function storeCoupon(Request $request)
    {
        $data = $request->validate([
            'code'       => 'required|string|max:40|unique:coupons,code',
            'type'       => 'required|in:percent,fixed',
            'value'      => 'required|integer|min:1',
            'min_amount' => 'nullable|integer|min:0',
            'max_uses'   => 'nullable|integer|min:1',
            'expires_at' => 'nullable|date',
        ]);
        $data['min_amount'] = $data['min_amount'] ?? 0;
        $data['active'] = true;
        Coupon::create($data);
        return back()->with('ok', '✓');
    }

    public function toggleCoupon(int $id)
    {
        $c = Coupon::findOrFail($id);
        $c->update(['active' => !$c->active]);
        return back()->with('ok', '✓');
    }

    public function destroyCoupon(int $id)
    {
        Coupon::findOrFail($id)->delete();
        return back()->with('ok', '✓');
    }

    /* ---------------- transactions ---------------- */

    public function transactions()
    {
        $orders = Order::where('pay_method', 'online')
            ->orWhereNotNull('ref_id')
            ->latest()->get();
        return view('admin.transactions', compact('orders'));
    }

    /* ---------------- settings ---------------- */

    public function settingsForm()
    {
        $keys = array_keys(Setting::DEFAULTS);
        $settings = [];
        foreach ($keys as $k) {
            $settings[$k] = Setting::get($k);
        }
        return view('admin.settings', compact('settings'));
    }

    public function settingsSave(Request $request)
    {
        $data = $request->validate([
            'store_name'       => 'required|string|max:120',
            'store_phone'      => 'nullable|string|max:40',
            'store_address'    => 'nullable|string|max:255',
            'shipping_cost'    => 'required|integer|min:0',
            'free_ship_min'    => 'required|integer|min:0',
            'gateway_mode'     => 'required|in:demo,zarinpal',
            'gateway_merchant' => 'nullable|string|max:64',
        ]);
        Setting::setMany($data);
        return back()->with('ok', '✓');
    }
}
