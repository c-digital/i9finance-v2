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

    public function sale(Request $request)
    {        
        $user_id = Auth::user()->creatorId();
        $customer_id      = Customer::customer_id($request->vc_name);

        $warehouse_id      = warehouse::warehouse_id($request->warehouse_name);


        $pos_id       = $this->invoicePosNumber();
        $sales            = session()->get('pos');

        if (isset($sales) && !empty($sales) && count($sales) > 0) {
            $result = DB::table('pos')->where('pos_id', $pos_id)->where('created_by', $user_id)->get();
            if (count($result) > 0) {
                return response()->json(
                    [
                        'code' => 200,
                        'success' => __('Payment is already completed!'),
                    ]
                );
            } else {
                $pos = new Pos();
                $pos->pos_id       = $pos_id;
                $pos->customer_id      = $customer_id;
                $pos->warehouse_id      = $request->warehouse_name;
                $pos->created_by       = $user_id;
                $pos->save();

                foreach ($sales as $key => $value) {
                    $product_id = $value['id'];

                    $product = ProductService::whereId($product_id)->where('created_by', $user_id)->first();

                    $original_quantity = ($product == null) ? 0 : (int)$product->quantity;

                    $product_quantity = $original_quantity - $value['quantity'];


                    if ($product != null && !empty($product)) {
                        ProductService::where('id', $product_id)->update(['quantity' => $product_quantity]);
                    }

                    $tax_id = ProductService::tax_id($product_id);


                    $positems = new PosProduct();
                    $positems->pos_id    = $pos->id;
                    $positems->product_id = $product_id;
                    $positems->price      = $value['price'];
                    $positems->quantity   = $value['quantity'];
                    $positems->tax     = $tax_id;
                    $positems->tax        = $value['tax'];
                    $positems->save();
                }

                $posPayment                 = new PosPayment();
                $posPayment->pos_id          =$pos->id;
                $posPayment->date           = $request->date;

                $mainsubtotal = 0;
                $sales        = [];

                $sess = session()->get('pos');
                foreach ($sess as $key => $value) {
                    $subtotal = $value['price'] * $value['quantity'];
                    $tax      = ($subtotal * $value['tax']) / 100;
                    $sales['data'][$key]['price']      = Auth::user()->priceFormat($value['price']);
                    $sales['data'][$key]['tax']        = $value['tax'] . '%';
                    $sales['data'][$key]['tax_amount'] = Auth::user()->priceFormat($tax);
                    $sales['data'][$key]['subtotal']   = Auth::user()->priceFormat($value['subtotal']);
                    $mainsubtotal                      += $value['subtotal'];
                }
                $amount = Auth::user()->priceFormat($mainsubtotal);
                $posPayment->amount         = $amount;
                $posPayment->save();

                session()->forget('pos');

                return response()->json(
                    [
                        'code' => 200,
                        'success' => __('Payment completed successfully!'),
                    ]
                );
            }
        } else {
            return response()->json(
                [
                    'code' => 404,
                    'success' => __('Items not found!'),
                ]
            );
        }
    }
}

