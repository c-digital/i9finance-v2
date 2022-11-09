<?php

namespace App\Http\Controllers;

use App\Models\Ecommerce;
use App\Models\ProductService;
use App\Models\ProductServiceCategory;
use Illuminate\Http\Request;

class ShopController extends Controller
{
    public function index($slug, Request $request)
    {
        $ecommerce = Ecommerce::where('slug', $slug)->first();

        $products = ProductService::where('created_by', $ecommerce->id_user)->get();

        if ($request->search) {
            $products = ProductService::where('created_by', $ecommerce->id_user)
                ->where('name', 'LIKE', '%' . $request->search . '%')
                ->get();
        }

        $categories = ProductServiceCategory::get();

        return view('shops.index', compact('ecommerce', 'products', 'request', 'categories'));
    }
}

