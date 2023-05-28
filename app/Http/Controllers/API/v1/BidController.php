<?php

namespace App\Http\Controllers\API\v1;

use App\Models\Bids;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\v1\BidStoreRequest;
use App\Models\CustomerBids;
use App\Models\Products;
use App\Models\Stores;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Arr;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Throwable;

class BidController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $bids = DB::table('bids')
            ->join('products', 'products.id', '=', 'bids.product_id')
            ->join('stores', 'stores.id', '=', 'products.store_id')
            ->join('product_images', function($img) {
                $img->on('product_images.product_id', '=', 'products.id')->latest()->take(1);
            })
            ->join('currencies', 'currencies.id', '=', 'bids.currency')
            ->where('bids.ended_at','>',date("Y-m-d H:i:s"))
            ->groupBy('bids.id')
            ->orderByDesc('bids.id')
            ->limit(16)
            ->get([
                'bids.id as bid_id',
                'products.id as prod_id',
                'products.name as item',
                'stores.name as store',
                'products.slug',
                'bids.min_price',
                'bids.buy_now_price',
                'bids.started_at',
                'bids.ended_at',
                'product_images.url as img',
                'currencies.prefix as currency_prefix',
                'currencies.code as currency_code',
                ]);

            /*  */

        $abids = collect($bids);
        $append_bids = [];
        foreach($abids as $bid) {
            $abid = collect($bid);
            $abid->put('store_slug', Str::slug($abid['store']));
            $append_bids[] = $abid;
        }

        return $append_bids;

        //return Products::with('images:id,product_id,url','store:id,name','bid')->get();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(BidStoreRequest $request)
    {
        $product = Products::where('slug', $request->slug)->firstOrFail(['id']);
        $bid = Bids::where('product_id', $product->id)->get();
        if($bid->count() === 0) {
            try {
                Bids::create([
                    'product_id' => $product->id,
                    'min_price' => $request->min_price,
                    'buy_now_price' => $request->buy_now_price,
                    //'currency' => $request->currency,
                    'currency' => 1,
                    'increment_by' => $request->increment_price,
                    'started_at' => Carbon::now()->toDateTime(),
                    'ended_at' => $request->expiration,
                    'status' => 1
                ]);
            } catch(Throwable $e) {
                return response()->json([
                    'message' => $e->getMessage()
                ], 401);
            }
        } else {
            return response()->json([
                'message' => 'This product is currently active in auctioned.'
            ], 401);
        }

        return response()->json([
            'message' => 'Product has been published and ready for bidding.'
        ], 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //return DB::table('bids')->join('products', 'products.id', '=', 'bids.product_id')->where('bids.id', $id)->firstOrFail();
        /* return DB::table('bids')
            ->join('products', 'products.id', '=', 'bids.product_id')
            ->join('stores', 'stores.id', '=', 'products.store_id')
            ->leftJoin('product_images', 'product_images.product_id', '=', 'products.id')
            ->get([
                'bids.id as bid_id',
                'products.id as prod_id',
                'products.name as item',
                'stores.name as store',
                'products.slug',
                'bids.min_price',
                'bids.buy_now_price',
                'bids.started_at',
                'product_images.url as img'
                ]); */

        $products = Products::with('images', 'bid', 'store', 'bid.highest', 'bid.currency', 'brand', 'condition')
            ->where('slug', $id)
            ->first();
            $customer_id = auth()->user()->id;
        
        $aproducts = collect($products);
        if($aproducts['store']['customer_id'] === $customer_id) {
            $aproducts->put('owner', true);
        } else {
            $aproducts->put('owner', false);
        }
        $aproducts->put('store_slug', Str::slug($aproducts['store']['name']));
        return $aproducts;
    }

    /**
     * Display the specified to auction item.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function showAuction($id)
    {
        //return DB::table('bids')->join('products', 'products.id', '=', 'bids.product_id')->where('bids.id', $id)->firstOrFail();
        /* return DB::table('bids')
            ->join('products', 'products.id', '=', 'bids.product_id')
            ->join('stores', 'stores.id', '=', 'products.store_id')
            ->leftJoin('product_images', 'product_images.product_id', '=', 'products.id')
            ->get([
                'bids.id as bid_id',
                'products.id as prod_id',
                'products.name as item',
                'stores.name as store',
                'products.slug',
                'bids.min_price',
                'bids.buy_now_price',
                'bids.started_at',
                'product_images.url as img'
                ]); */
        $customer_id = auth()->user()->id;
        $store = Stores::where('customer_id', $customer_id)->firstOrFail();

        return Products::with('images', 'store', 'bid', 'condition', 'brand', 'bid.currency')->where('slug', $id)->first();
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
