<?php

namespace App\Http\Controllers\API\v1;

use App\Http\Requests\v1\StoreRequest;
use App\Http\Requests\v1\StoreUpdateRequest;
use App\Models\Stores;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Products;
use App\Http\Helper\Helper;
use App\Models\Auctions;
use App\Models\AuctionWinnerAcknowledgement;
use App\Models\StoreVerification;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
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
        $customer_id = Auth::id();
        
        try {
            $store = Stores::create([
                'customer_id' => $customer_id,
                'name' => $request->name,
                'slug' => Helper::createSlug('stores', $request->name),
                'verified' => 0
            ]);

            $file = [];

            if($request->hasFile('image')) {
                $image = $request->file('image');
                $storage_path = Storage::putFile('public/product_images', $image);
                $filename = Str::of($storage_path)->explode('/');
                $file['name'] = $filename[2];
                $file['url'] = Storage::url($filename[2]);
                $file['mime_type'] = $image->getMimeType();
                $file['size'] = $image->getSize();
            } else {
                return response()->json([
                    'message' => 'Image required.'
                ], 401);
            }

            StoreVerification::create([
                'store_id' => $store->id,
                'social_store_link' => $request->social_store_link,
                'ownership_proof_image' => $file['url']
            ]);
        } catch (Throwable $e) {
            return response()->json([
                'message' => $e->getMessage(),
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
            return Auctions::with('product','product.thumbnail','product.brand','product.condition','product.currency','highest','product.store')
            ->withCount('participants')
            ->whereIn('status', [1,2])
            ->whereRelation('product','name','LIKE','%'.$request->search.'%')
            ->whereRelation('product.store','slug', $store)
            ->limit(20)->get();
        } else {
            return Auctions::with('product','product.thumbnail','product.brand','product.condition','product.currency','highest','product.store')
                ->withCount('participants')
                ->whereIn('status', [1,2])
                ->whereRelation('product.store','slug', $store)
                ->limit(20)->get();
        }
    }

    public function search($key)
    {
        $customer_id = Auth::id();
        $store = Stores::where('customer_id', $customer_id)->first();

        return Products::with('thumbnail','brand','condition','category','currency','bid','store')->where('name','LIKE','%'.$key.'%')->where('store_id', $store->id)->paginate(10);
    }

    public function searchAuction($key)
    {
        $customer_id = Auth::id();
        $store = Stores::where('customer_id', $customer_id)->first();
        return Auctions::with('product','product.thumbnail','product.brand','product.condition','product.category','product.currency','highest','product.store')
                    ->whereRelation('product','store_id', $store->id)
                    ->whereRelation('product', 'name', 'LIKE', '%'.$key.'%')
                    ->orderByDesc('id')->paginate(10);
    }

    public function dashboardReport()
    {
        $customer_id = Auth::id();
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

        $transactions = AuctionWinnerAcknowledgement::with('auction', 'auction.product')
        ->whereRelation('auction.product', 'store_id', '=', $store->id)->count();

        return response()->json([
            'products_count' => $count_products,
            'auctions_count' => $count_bids,
            'transactions_count' => $transactions
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
        try {
            $customer_id = Auth::id();
            $slug = Helper::createSlug('stores', $request->name);
            Stores::where('customer_id', $customer_id)->update([
                'name' => $request->name,
                'slug' => $slug
            ]);
        } catch(Throwable $e) {
            return response()->json([
                'message' => $e->getMessage(),
                'code' => $e->getCode()
            ], 301);
        }

        return response()->json([
            'message' => 'Setting updated!',
        ], 200);
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