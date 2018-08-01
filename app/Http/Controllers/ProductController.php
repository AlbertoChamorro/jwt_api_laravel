<?php

namespace App\Http\Controllers;

use App\Product;
use Illuminate\Http\Request;

/**
 * @resource Product
 *
 * This endpoints allow operations on products
 */

class ProductController extends Controller
{
    // php artisan api:gen --routePrefix="api/*" --noResponseCalls

    /**
     * GET: List
     *
     * @param  int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return response()->json([
            'data' => Product::all()
        ], 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * GET: Detail
     *
     * @param  int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function show(int $id)
    {
        $product = Product::findOrFail($id);
        
        return response()->json([
            'data' => $product
        ], 200);
    }

    /**
     * PUT: Update
     */
    public function update(Request $request, Product $product)
    {
        //
    }

    /**
     * DELETE: Remove
     */
    public function destroy(int $id)
    {
        //
    }
}
