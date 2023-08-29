<?php

namespace App\Http\Controllers\API\v1;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\v1\AuctionFutureStoreRequest;
use App\Http\Requests\v1\AuctionStoreRequest;
use App\Models\Auctions;
use App\Models\CustomerBids;
use App\Models\Products;
use App\Models\Stores;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Throwable;

class AuctionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $customer_id = Auth::id();
        $store = Stores::where('customer_id', $customer_id)->first();
        $product = [];
        
        if($store) {
            try {
                $product = Auctions::with('product','product.thumbnail','product.brand','product.condition','product.category','product.currency','highest','product.store')
                    ->withCount('participants')
                    ->whereRelation('product','store_id', $store->id)
                    ->orderByDesc('id')->paginate(10);
            } catch(Throwable $e) {
                return response()->json([
                    'message' => $e->getMessage()
                ], 401);
            }
        }

        return $product;
    }

    public function all(Request $request)
    {

        $brands = [];
        if($request->brand) {
            foreach($request->brand as $brand) {
                array_push($brands, $brand);
            }
        }
        
        //echo '('.implode(",",$brands).')'; die;
        if(!empty($request->category)) {
            if(!$request->brand) {
                $bids = Auctions::with('product','product.thumbnail','product.brand','product.condition','product.category','product.currency','highest','product.store')
                    ->withCount('participants')
                    ->whereIn('status', [1,2])
                    ->whereRelation('product','category', $request->category)
                    ->orderBy('status')
                    ->inRandomOrder()->limit(16)->get(); 
            } else {
                $bids = Auctions::with('product','product.thumbnail','product.brand','product.condition','product.category','product.currency','highest','product.store')
                    ->whereHas('product', function($query) use($brands) {
                        $query->whereIn('brand', $brands);
                    })
                    ->whereRelation('product','category', $request->category)
                    ->withCount('participants')
                    ->whereIn('status', [1,2])->orderBy('status')
                    ->inRandomOrder()->inRandomOrder()->limit(16)->get(); 
            }
        } else {
            if(!$request->brand) {
                $bids = Auctions::with('product','product.thumbnail','product.brand','product.condition','product.category','product.currency','highest','product.store')
                    ->withCount('participants')
                    ->whereIn('status', [1,2])->orderBy('status')
                    ->inRandomOrder()->limit(16)->get(); 
            } else {
                $bids = Auctions::with('product','product.thumbnail','product.brand','product.condition','product.category','product.currency','highest','product.store')
                    ->whereHas('product', function($query) use($brands) {
                        $query->whereIn('brand', $brands);
                    })
                    ->withCount('participants')
                    ->whereIn('status', [1,2])->orderBy('status')
                    ->inRandomOrder()->limit(16)->get(); 
            }
        }

        $abids = collect($bids);
        $append_bids = [];
        foreach($abids as $bid) {
            $abid = collect($bid);
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
    public function store(AuctionStoreRequest $request)
    {
        $product = Products::where('slug', $request->slug)->firstOrFail(['id']);
        $bid = Auctions::where('product_id', $product->id)->where('status', 1)->get();
        if($bid->count() === 0) {
            try {
                $buy_now_price = 0;

                if(!empty($request->buy_now_price) && $request->buy_now_price !== 0) {
                    if($request->buy_now_price > $request->min_price) {
                        $buy_now_price = $request->buy_now_price;
                    } else {
                        return response()->json([
                            'message' => 'Buy now price should be higher than starting bid.'
                        ], 201);
                    }
                }

                Auctions::create([
                    'product_id' => $product->id,
                    'min_price' => $request->min_price,
                    'buy_now_price' => $buy_now_price,
                    //'currency' => $request->currency,
                    'min_participants' => $request->min_participants,
                    'currency' => 1,
                    'increment_by' => $request->increment_price,
                    'started_at' => Carbon::now()->addDay()->toDateTime(),
                    'ended_at' => $request->end_date,
                    'status' => 2,
                    'type' => $request->type
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
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function storeFuture(AuctionFutureStoreRequest $request)
    {
        $product = Products::where('slug', $request->slug)->firstOrFail(['id']);
        $bid = Auctions::where('product_id', $product->id)->where('status', 1)->get();
        if($bid->count() === 0) {
            try {
                $buy_now_price = 0;

                if(!empty($request->buy_now_price) && $request->buy_now_price !== 0) {
                    if($request->buy_now_price > $request->min_price) {
                        $buy_now_price = $request->buy_now_price;
                    } else {
                        return response()->json([
                            'message' => 'Buy now price should be higher than starting bid.'
                        ], 201);
                    }
                }

                Auctions::create([
                    'product_id' => $product->id,
                    'min_price' => $request->min_price,
                    'buy_now_price' => $buy_now_price,
                    //'currency' => $request->currency,
                    'min_participants' => $request->min_participants,
                    'currency' => 1,
                    'increment_by' => $request->increment_price,
                    'started_at' => $request->start_date,
                    'ended_at' => $request->end_date,
                    'status' => 2,
                    'type' => $request->type
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
    public function show($slug)
    {
        $products = Products::with('images', 'bid', 'store', 'bid.highest', 'bid.currency', 'brand', 'condition', 'category')
            ->where('slug', $slug)
            ->first();

        $customer_id = Auth::id();
        
        if($products) {
            $aproducts = collect($products);
            
            //var_dump($aproducts['bid']['ended_at'], Carbon::now());
            if($aproducts['bid']['ended_at'] > Carbon::now()) {
                if($aproducts['store']['customer_id'] === $customer_id) {
                    $aproducts->put('owner', true);
                } else {
                    $aproducts->put('owner', false);
                }
            } else {
                return [];
            }
        } else {
            return response()->json([
                'message' => 'Product not found.'
            ], 401);
        }
        
        return $aproducts;
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function auctionDetails($store, $product)
    {
        $customer_id = (Auth::check()) ? Auth::id() : null;
        
        $products = Products::with(['images',
            'auction' => function($query) {
                $query->withCount('participants')->whereIn('status', [1,2]);
            }, 'auction.highest','store','auction.currency','brand','condition','category','item_location','auction.participants' => function($query) use($customer_id) {
                $query->where('customer_id', $customer_id);
            }])
            ->where('slug', $product)
            ->first();

        if($products) {
            $aproducts = collect($products)->map(function($prod, $key) {
                if($key === 'auction' && $prod['id'] !== null) {
                    $prod['id'] = encrypt($prod['id']);
                    $prod['joiner'] = (count($prod['participants']) > 0) ? true : false;
                    unset($prod['highest']['auction_id']);
                }

                return $prod;
            });

            try {
                if($aproducts['store']['slug'] === $store) {
                    $mystore = Stores::where('customer_id', $customer_id)->first(['slug']);
                
                    if($mystore) {
                        if($aproducts['store']['slug'] === $mystore->slug) {
                            $aproducts->put('owner', true);
                        } else {
                            $aproducts->put('owner', false);
                        }
                    } else {
                        $aproducts->put('owner', false);
                    }
                    
                } else {
                    return response()->json([
                        'message' => 'Product not found.'
                    ], 401);
                }
            } catch(Throwable $e) {
                $aproducts->put('joiner', false);
                $aproducts->put('owner', false);
            }
            
        } else {
            return response()->json([
                'message' => 'Product not found.'
            ], 201);
        }
        
        return $aproducts;
    }

    /**
     * Display the specified to auction item.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function auction($slug)
    {
        return Products::with('images', 'store', 'auction', 'condition', 'brand', 'category', 'item_location', 'auction.currency')->where('slug', $slug)->first();
    }

    /**
     * Display the specified to auction item.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function auctionBid($id)
    {
        return Auctions::with('product','winner:id,username','product.thumbnail','product.brand','product.condition','product.category','product.currency','highest','product.store','currency')
            ->where('id', $id)
            ->first();
    }

    public function activity($id)
    {
        return CustomerBids::with('customer:id,username')->where('auction_id', $id)
            ->orderByDesc('id')
            ->limit(5)
            ->get(['bidded_at as time', 'price', 'customer_id']);
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
