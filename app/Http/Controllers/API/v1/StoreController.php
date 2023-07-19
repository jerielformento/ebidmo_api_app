<?php

namespace App\Http\Controllers\API\v1;

use App\Http\Requests\v1\StoreRequest;
use App\Http\Requests\v1\StoreUpdateRequest;
use App\Models\Stores;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Products;
use App\Http\Helper\Helper;
use App\Models\Bids;
use Illuminate\Support\Carbon;
use Illuminate\Support\Str;
use Throwable;

class StoreController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Stores::all();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreRequest $request)
    {
        $customer_id = auth()->user()->id;
        
        try {
            Stores::create([
                'customer_id' => $customer_id,
                'name' => $request->name,
                'slug' => Helper::createSlug('stores', $request->name),
                'verified' => 0
            ]);
        } catch (Throwable $e) {
            return response()->json([
                'message' => 'Open store failed.',
                'code' => $e->getCode()
            ], 500);
        }   

        return response()->json([
            'message' => 'Store has been created.'
        ], 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($slug)
    {
        return Stores::where('slug', $slug)->first();
    }

    public function products(Request $request, $store)
    {
        if($request->only('search') && !empty($request->search)) {
            return Products::with('brand','condition','thumbnail','store','currency')
                ->where('name','LIKE','%'.$request->search.'%')
                ->whereRelation('store', 'slug', $store)
                ->limit(20)->get();
        } else {
            return Products::with('brand','condition','thumbnail','store','currency')
                ->whereRelation('store', 'slug', $store)
                ->limit(20)->get();
        }
    }

    public function auctions(Request $request, $store)
    {
        if($request->only('search') && !empty($request->search)) {
            return Bids::with('product','product.thumbnail','product.brand','product.condition','product.currency','highest','product.store')
            ->where('ended_at','>',Carbon::now())
            ->whereRelation('product','name','LIKE','%'.$request->search.'%')
            ->whereRelation('product.store','slug', $store)
            ->limit(20)->get();
        } else {
            return Bids::with('product','product.thumbnail','product.brand','product.condition','product.currency','highest','product.store')
                ->where('ended_at','>',Carbon::now())
                ->whereRelation('product.store','slug', $store)
                ->limit(20)->get();
        }
    }


    public function dashboardReport()
    {
        $customer_id = auth()->user()->id;
        $store = Stores::where('customer_id', $customer_id)->firstOrFail(['id']);

        $products = Products::withCount('auctions')->where('store_id', $store->id)->get();
        $count_bids = 0;
        $count_products = 0;
        $aprod = collect($products);
        foreach($aprod as $prod) {
            $count_bids += $prod['auctions_count'];
        }

        $stores = Stores::withCount('products')->where('id', $store->id)->get();
        $astore = collect($stores);
        foreach($astore as $store) {
            $count_products += $store['products_count'];
        }

        return response()->json([
            'products_count' => $count_products,
            'auctions_count' => $count_bids,
            'transactions_count' => 0
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(StoreUpdateRequest $request, $id)
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