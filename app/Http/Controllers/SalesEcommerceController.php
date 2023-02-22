<?php

namespace App\Http\Controllers;

use App\Models\ProductServiceCategory;
use App\Mail\SelledInvoice;
use App\Models\Customer;
use App\Models\Pos;
use App\Models\PosPayment;
use App\Models\PosProduct;
use App\Models\ProductService;
use App\Models\Utility;
use App\Models\warehouse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

class SalesEcommerceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $posPayments = Pos::where('created_by', '=', auth()->user()->creatorId())
            ->where('online', 1)
            ->get();

        return view('salesEcommerce.index',compact('posPayments'));
    }

    public function edit($id)
    {
        $pos = Pos::find($id);

        $customers      = Customer::where('created_by', auth()->user()->creatorId())->get()->pluck('name', 'id');
        $category       = ProductServiceCategory::where('created_by', auth()->user()->creatorId())->where('type', 1)->get()->pluck('name', 'id');
        $product_services = ProductService::where('created_by', auth()->user()->creatorId())->get()->pluck('name', 'id');

        return view('salesEcommerce.edit', compact('pos', 'customers', 'category', 'product_services'));
    }

    public function status(Request $request)
    {
        $pos = Pos::find($request->id);
        $pos->update(['order_status' => $request->order_status]);

        return redirect()->route('salesEcommerce.index');
    }

    public function update(Request $request)
    {
        PosProduct::where('pos_id', $request->pos_id)->delete();

        $i = 0;

        foreach ($request->item as $item) {            
            PosProduct::create([
                'product_id' => $item,
                'pos_id' => $request->pos_id,
                'quantity' => $request->quantity[$i],
                'description' => $request->description[$i],
                'price' => $request->price[$i],
            ]);

            $i++;
        }

        return redirect("/salesEcommerce/{$request->pos_id}/edit");
    }

    public function delete($id)
    {
        Pos::find($id)->delete();
        return redirect("/salesEcommerce");
    }

    public function pdf($id)
    {
        $pos = Pos::find($id);
        return view('pos.print', compact('pos'));
    }
}
