<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Product;

class ProductController extends Controller
{
    public function allData(){
        return view('inc\product_list', ['data' => Product::all()]);
    }
}
