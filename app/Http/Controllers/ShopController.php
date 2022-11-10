<?php

namespace App\Http\Controllers;

use App\Models\Ecommerce;
use App\Models\ProductService;
use App\Models\ProductServiceCategory;
use App\Models\Purchase;
use App\Models\PurchaseProduct;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Utility;
use App\Models\Customer;
use App\Models\Pos;
use App\Models\PosProduct;
use App\Models\Tax;
use App\Models\PosPayment;
use App\Models\User;
use Illuminate\Support\Facades\Storage;


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

        return view('shops.index', compact('slug', 'ecommerce', 'products', 'request', 'categories'));
    }

    public function order(Request $request)
    {
        session_start();
        $order = $_SESSION['order'];
        $order[$request->id_product] = $request->quantity;
        $_SESSION['order'] = $order;

        return view('shops.order', compact('order'));
    }

    public function sale(Request $request)
    {        
        session_start();

        $user_id = Ecommerce::where('slug', $request->slug)->first()->id_user;

        $customer = Customer::updateOrCreate(
            ['email' => $request->email],
            [
                'customer_id' => $this->customerNumber($request->slug),
                'name' => $request->name,
                'contact' => $request->phone,
                'created_by' => $user_id
            ]
        );

        $customer_id = $customer->id;


        $pos_id       = $this->invoicePosNumber($request->slug);
        $sales            = $_SESSION['order'];

        $pos = new Pos();
        $pos->pos_id       = $pos_id;
        $pos->customer_id      = $customer_id;
        $pos->created_by       = $user_id;
        $pos->pos_date = date('Y-m-d h:i:s');
        $pos->online = 1;
        $pos->save();

        foreach ($sales as $key => $value) {
            $product_id = $key;

            $product = ProductService::whereId($product_id)->where('created_by', $user_id)->first();

            $original_quantity = ($product == null) ? 0 : (int)$product->quantity;

            $product_quantity = $original_quantity - $value;


            if ($product != null && !empty($product)) {
                ProductService::where('id', $product_id)->update(['quantity' => $product_quantity]);
            }

            $tax_id = ProductService::tax_id($product_id, $user_id);


            $positems = new PosProduct();
            $positems->pos_id    = $pos->id;
            $positems->product_id = $product_id;
            $positems->price      = $product->sale_price;
            $positems->quantity   = $value;
            $positems->tax     = $tax_id;
            $positems->save();
        }

        $posPayment                 = new PosPayment();
        $posPayment->pos_id          =$pos->id;
        $posPayment->date           = date('Y-m-d h:i:s');
        $posPayment->created_by     = $user_id;

        $mainsubtotal = 0;
        $sales        = [];

        $user = User::find($user_id);

        $sess = $_SESSION['order'];
        foreach ($sess as $key => $value) {

            $product_id = $key;
            $product = ProductService::whereId($product_id)->where('created_by', $user_id)->first();

            $tax = Tax::whereId($product->tax_id);

            $subtotal = $product->sale_price * $value;
            $tax      = isset($tax->rate) ? ($subtotal * $tax->rate) / 100 : 0;
            $sales['data'][$key]['price']      = $user->priceFormat($product->sale_price);
            $sales['data'][$key]['tax']        = (isset($tax->rate)) ? $tax->rate . '%' : null;
            $sales['data'][$key]['tax_amount'] = $user->priceFormat($tax);
            $sales['data'][$key]['subtotal']   = $user->priceFormat($subtotal);
            $mainsubtotal                      += $subtotal;
        }
        $amount = $user->priceFormat($mainsubtotal);
        $posPayment->amount         = $amount;
        $posPayment->save();

        $message = Storage::get('whatsapp-message.txt');

        $ecommerce = Ecommerce::where('slug', $slug)->first();

        $message = str_replace('{{customerName}}', $customer->name, $message);
        $message = str_replace('{{customerPhone}}', $customer->phone, $message);
        $message = str_replace('{{amount}}', $amount, $message);
        $message = str_replace('{{fecha}}', date('Y-m-d'), $message);
        $message = str_replace('{{hora}}', date('h:i:s'), $message);
        $message = str_replace('{{telefono}}', $ecommerce->phone, $message);

        return view('shops.success', compact('message'));
    }

    function customerNumber($slug)
    {
        $ecommerce = Ecommerce::where('slug', $slug)->first();

        $latest = Customer::where('created_by', '=', $ecommerce->id_user)->latest()->first();
        if(!$latest)
        {
            return 1;
        }

        return $latest->customer_id + 1;
    }

    function invoicePosNumber($slug)
    {
        $ecommerce = Ecommerce::where('slug', $slug)->first();
        $latest = Pos::where('created_by', '=', $ecommerce->id_user)->latest()->first();
        return $latest ? $latest->pos_id + 1 : 1;
    }
}

