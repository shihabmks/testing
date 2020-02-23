<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Product;

class ProductsController extends Controller
{
    //
	public function index(Request $request){	
		$products = Product::filter($request)->get();  	
	return view('pages.products')->with('products', $products);
	}
	
	
}
