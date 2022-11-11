<?php

namespace App\Http\Controllers;

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
        $posPayments = Pos::where('created_by', '=', \Auth::user()->creatorId())
            ->where('online', 1)
            ->get();

        return view('salesEcommerce.index',compact('posPayments'));
    }

    public function status(Request $request)
    {
        $pos = Pos::find($request->id);
        $pos->update(['order_status' => $request->order_status]);

        return redirect()->route('salesEcommerce.index');
    }

}
