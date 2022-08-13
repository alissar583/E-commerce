<?php

namespace App\Http\Controllers;

use App\Models\like;
use App\Http\Requests\StorelikeRequest;
use App\Http\Requests\UpdatelikeRequest;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LikeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StorelikeRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StorelikeRequest $request)
    {
        $ex = like::query()
            ->where('owner_id', Auth::id())
            ->where('product_id', $request->product_id)
            ->exists();

        if (! $ex) {
            like::query()->create([
                'product_id'=>$request->product_id,
                'owner_id'=>Auth::id(),
            ]);
        }else {
            return response()->json(null, 403);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\like  $like
     * @return \Illuminate\Http\Response
     */
    public function show(like $like)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdatelikeRequest  $request
     * @param  \App\Models\like  $like
     * @return \Illuminate\Http\Response
     */
    public function update(UpdatelikeRequest $request, like $like)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\like  $like
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product $product)
    {
        $product->likes()->where('owner_id', Auth::id())->delete();
    }
}
