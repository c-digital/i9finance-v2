<?php

namespace App\Http\Controllers;

use App\Models\Ecommerce;
use App\Models\ProductService;
use App\Models\ProductServiceCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ShopController extends Controller
{
    public function index($slug, Request $request)
    {
        session_start();

        $_SESSION['order'] = [];

        $ecommerce = Ecommerce::where('slug', $slug)->first();

        $products = ProductService::where('created_by', $ecommerce->id_user)->get();

        if ($request->search) {
            $products = ProductService::where('created_by', $ecommerce->id_user)
                ->where('name', 'LIKE', '%' . $request->search . '%')
                ->get();
        }

        $categories = DB::table('product_service_categories')
            ->select('product_service_categories.*')
            ->leftJoin('product_services', 'product_service_categories.id', '=', 'product_services.category_id')
            ->where('product_services.created_by', $ecommerce->id_user)
            ->groupBy('product_service_categories.id')
            ->get();

        return view('shops.index', compact('ecommerce', 'products', 'request', 'categories'));
    }

    public function order(Request $request)
    {
        session_start();
        $order = $_SESSION['order'];
        $order[$request->id_product] = $request->quantity;
        $_SESSION['order'] = $order;

        return view('shops.order', compact('order'));
    }
}

