<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\like;
use App\Models\Product;
use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use function Sodium\increment;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $productsForDelete = Product::query()->get();
        foreach ($productsForDelete as $product) {
            if ($product->expired_date <= now()) {
                Comment::query()->where('product_id', $product->id)->delete();
                like::query()->where('product_id', $product->id)->delete();
            }
        }
        $order_by_DESC = $request->input('DESC');
        $order_by = $request->input('order_by');
        $searchByName = $request->input('searchByName');
        $searchByDateFrom = $request->input('searchByDateFrom');
        $searchByDateTo = $request->input('searchByDateTo');
        $productq = Product::query();
        // start search
        if ($searchByName !== null) {
            $productq->where('name', 'LIKE', '%'. $searchByName . '%');
        } if ($searchByDateFrom !== null && $searchByDateTo == null) {
        $productq->whereDate('expired_date', '>=', $searchByDateFrom);
            } if ($searchByDateFrom == null && $searchByDateTo !== null) {
        $productq->whereDate('expired_date', '<=', $searchByDateTo);
        }if ($searchByDateFrom !== null && $searchByDateTo !== null) {
        $productq->whereBetween('expired_date', [$searchByDateFrom, $searchByDateTo]);
        }
        // end search
        // start sorting
        if ($order_by_DESC !== null && $order_by !== null) {
            if ($order_by == 'count_views') {
                $productq->orderBy('count_views', 'DESC');
            } else if ($order_by == 'price') {
                $productq->orderBy('price', 'DESC');
            } else if ($order_by == 'name') {
                $productq->orderBy('name', 'DESC');
            } else if ($order_by == 'quantity') {
                $productq->orderBy('quantity', 'DESC');
            }
        }
        if ($order_by !== null) {
            if ($order_by == 'count_views') {
                $productq->orderBy('count_views');
            }else if ($order_by == 'price') {
                $productq->orderBy('price');
            }else if ($order_by == 'name') {
                $productq->orderBy('name');
            }else if ($order_by == 'quantity') {
                $productq->orderBy('quantity');
            }
        }


        // end sorting
        $products = $productq
            ->whereDate('expired_date', '>=', now())
            ->with('category')
            ->get();

        return response()->json(["key"=>$products], 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @pزaram  \App\Http\Requests\StoreProductRequest  $request
     * @return \Illuminate\Http\Response
     */

    public  function user_Products(User $user_id){
//        $user_Products = $user_id->products()->whereDate('expired_date', '>=', now())
//            ->with('comments','likes')->get();
        $user_Products = $user_id->load('products', 'comments', 'likes');
        return response()->json($user_Products, 200);
    }
    public function store(StoreProductRequest $request)
    {
        $product = Product::query()->create([
            'name' => $request->name,
            'price' => $request->price,
            'image_url' => $request->image_url,
//            'facebook_url' => $request->facebook_url,
//            'whatsapp_url' => $request->whatsapp_url,
            'expired_date' => $request->expired_date,
            'quantity' => $request->quantity,
            'owner_id' => Auth::id(),
            'category_id' => $request->category_id,

        ]);

        foreach ($request->list_discounts as $discount){
            $product->disscounts()->create([
                'discount_precentage' => $discount['d_v'],
                'date' => $discount['date'],
            ]);
        }
        return response()->json(["key"=>$product], 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function show(Product $product)
    {
        Product::find($product->increment('count_views'));
        $product->load('user', 'category', 'comments','likes');
        $discounts = $product->disscounts()->get();
        $maxDiscount = null;
        foreach ($discounts as $discount) {
            if (Carbon::parse($discount['date']) <= now()){
                $maxDiscount = $discount;
            }
        }
        if (!is_null($maxDiscount)){
            $dis_val = ($product->price*$maxDiscount['discount_precentage'])/100;
            $product['new_price'] = $product->price - $dis_val;
        }else{
            $product['new_price'] =  $product->price;
        }
        return $product;
    }
    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateProductRequest  $request
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateProductRequest $request, Product $product)
    {
        if($product->owner_id == Auth::id()){
            $product->update([
                'name'=>$request->name,
                'price'=>$request->price,
                'image_url'=>$request->image_url,
                'quantity'=>$request->quantity,
                'owner_id'=>Auth::id(),
                'category_id'=>$request->category_id,
            ]);
        }else {
            return response()->json(["key"=>null], 403);

        }
        return response()->json(["key"=>$product], 200);
    }
    public function updateQuantity(UpdateProductRequest $request, Product $product) {
        if($product->owner_id == Auth::id()){
            $product->update([
                'quantity'=>$request->quantity,
            ]);
        }
        else {
            return response()->json(null, 403);
        }
        return $product;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product $product)
    {
        if ($product->owner_id == Auth::id()) {
            $product->delete();
        }else {
            return response()->json(null, 403);
        }
    }
}
