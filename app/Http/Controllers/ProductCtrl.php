<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;

class ProductCtrl extends Controller
{
    public function index()
    {
        return view('products.dt');
    }

    public function dt()
    {
        return DataTables::of(Product::query())
            ->make(true);
    }

    public function create()
    {
        return view('products.create');
    }

    public function store(Request $req)
    {
        return DB::transaction(function() use($req) {
            try {
                $product = new Product();
                $product->name = $req->name;
                $product->description = $req->description;
                $product->price = str_replace(',', '', $req->price);
                $product->qty = $req->qty;
                $product->save();
                return redirect()->route('products.index')->with('success', 'Product added successfully.');
            } catch(Exception $e) {
                return back()->with('error', 'Error while saving data! ' . $e->getMessage())->withInput();
            }

        });
    }
}
