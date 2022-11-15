<?php

namespace App\Http\Controllers;

use App\Models\Ecommerce;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class EcommerceController extends Controller
{
    public function index()
    {
        $ecommerce = Ecommerce::where('id_user', auth()->user()->id)->first();
        return view('ecommerce.index', compact('ecommerce'));
    }

    public function store(Request $request)
    {

        $ecommerce = Ecommerce::where('id_user', auth()->user()->id)->first();

        if ($ecommerce->id) {
            $request->validate([
                'slug' => Rule::unique('ecommerces')->ignore($ecommerce->id)
            ]);
        } else {
            $request->validate([
                'slug' => 'unique:ecommerces'
            ]);
        }

        if (!isset($ecommerce->id)) {
            $ecommerce = new Ecommerce();
        }

        $ecommerce->id_user = auth()->user()->id;
        $ecommerce->slug = $request->slug;
        $ecommerce->name = $request->name;
        $ecommerce->phone = $request->phone;
        $ecommerce->address = $request->address;
        $ecommerce->description = $request->description;
        $ecommerce->type = $request->type;
        $ecommerce->type_company = $request->type_company;
        $ecommerce->nit = $request->nit;
        $ecommerce->email = $request->email;
        $ecommerce->title = $request->title;
        $ecommerce->minimum_order = $request->minimum_order;
        $ecommerce->facebook = $request->facebook;
        $ecommerce->instagram = $request->instagram;
        $ecommerce->google = $request->google;
        $ecommerce->youtube = $request->youtube;

        if ($request->file('logo')) {
            $ecommerce->logo = $ecommerce->id . '.' . $request->file('logo')->getClientOriginalExtension();

            $request->file('logo')->storeAs('shops/logos', $ecommerce->id . '.' . $request->file('logo')->getClientOriginalExtension());
        }

        if ($request->file('banner')) {
            $ecommerce->banner = $ecommerce->id . '.' . $request->file('banner')->getClientOriginalExtension();

            $request->file('banner')->storeAs('shops/banners', $ecommerce->id . '.' . $request->file('banner')->getClientOriginalExtension());
        }

        $ecommerce->save();

        return redirect()->route('ecommerce.index')->with('info', 'Información actualizada satisfactoriamente');
    }
}

