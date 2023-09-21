<?php

namespace App\Http\Controllers\API\v1;

use App\Models\Customers;
use App\Http\Controllers\Controller;
use App\Http\Requests\v1\CustomerBidRequest;
use App\Http\Requests\v1\CustomerBuyAuctionRequest;
use App\Http\Requests\v1\CustomerJoinBidRequest;
use App\Http\Requests\v1\CustomerStoreRequest;
use App\Http\Requests\v1\CustomerUpdateRequest;
use App\Http\Requests\v1\StoreBillingInfoRequest;
use App\Models\AuctionParticipants;
use App\Models\Auctions;
use App\Models\AuctionWinnerAcknowledgement;
use App\Models\BillingInformation;
use App\Models\CustomerBids;
use App\Models\Notifications;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Throwable;

class CustomerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $customer_id = Auth::id();
        
        return Customers::with(
            'profile:customer_id,email,first_name,middle_name,last_name,phone',
            'store:customer_id,slug,name,verified'
        )->where('id', $customer_id)->firstOrFail([
            'id',
            'username',
            'is_verified'
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CustomerStoreRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return Customers::with('profile')->find($id)->firstOrFail();
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(CustomerUpdateRequest $request, $id)
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
        return Customers::destroy($id);
    }

    /**
     * Bid to a specific product.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function bid(CustomerBidRequest $request)
    {   
        $customer_id = Auth::id();
        $decrypted_id = decrypt($request->auction_id);
        $auction = Auctions::with('product.store','product.thumbnail')->whereIn('status',[1,2])->findOrFail($decrypted_id);
        $highest_bid = CustomerBids::where('auction_id', $auction->id)->orderByDesc('id')->first(['customer_id','price']);
        
        if($highest_bid) {
            if($highest_bid->customer_id === $customer_id) {
                return response()->json([
                    'message' => 'Please wait for new a bid before placing another.'
                ], 401);
            } else {
                $item = collect($auction);
                
                Notifications::create([
                    'customer_id' => $highest_bid->customer_id,
                    'title' => 'Auction',
                    'description' => "You've been outbided.",
                    'redirect_url' => env('FRONTEND_URL')."/auction/live/".$item['product']['store']['slug']."/".$item['product']['slug'],
                    'thumbnail_url' => $item['product']['thumbnail']['url']
                ]);
            }
        }

        if(!empty($highest_bid->price) && $highest_bid->price >= $request->price) {
            return response()->json([
                'message' => 'Highest bid changed. Try again'
            ], 401);
        }

        if($auction->ended_at < Carbon::now()) {
            return response()->json([
                'message' => 'Auction has been ended!'
            ], 401);
        } else {
            // Anti-sniping feature
            /* $ended_at = Carbon::parse($auction->ended_at);
            $now = Carbon::now();
            $diff = $ended_at->diffInMinutes($now);

            if($diff <= 2) {
                Auctions::where('id', $auction->id)->update([
                    'ended_at' => Carbon::parse($auction->ended_at)->addMinutes(2)->format('Y-m-d H:i:s')
                ]);
            } */
        }
        
        try {
            CustomerBids::create([
                'auction_id' => $decrypted_id,
                'customer_id' => $customer_id,
                'price' => $request->price,
                'bidded_at' => Carbon::now()->toDateTime()
            ]);
        } catch(Throwable $e) {
            return response()->json([
                'message' => 'Invalid request.',
                'error' => $e->getMessage()
            ], 401);
        }

        return response()->json([
            'message' => 'Bid has been placed.'
        ], 201);
    }

    /**
     * Bid to a specific product.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function joinBid(CustomerJoinBidRequest $request)
    {   
        $customer_id = Auth::id();
        $decrypted_id = decrypt($request->auction_id);

        try {
            $check_exist = AuctionParticipants::where([
                'auction_id' => $decrypted_id,
                'customer_id' => $customer_id
            ])->count();

            if($check_exist > 0) {
                return response()->json([
                    'message' => 'Already joined.'
                ], 401);
            }

            $bids = Auctions::where('id', $decrypted_id)->firstOrFail();
            $participants = AuctionParticipants::where('auction_id', $decrypted_id)->count();
            
            if($bids->min_participants > $participants) {
                AuctionParticipants::create([
                    'auction_id' => $decrypted_id,
                    'customer_id' => $customer_id
                ]);

                $count_participants = $participants+=1;

                
                if($bids->min_participants === $count_participants) {
                    Auctions::where('id', $decrypted_id)->update([
                        'status' => 1
                    ]);

                    return response()->json([
                        'message' => 'The auction has been started!',
                    ], 201);
                }
            } else {
                return response()->json([
                    'message' => 'The auction has been started!'
                ], 401);
            }
            
        } catch(Throwable $e) {
            return response()->json([
                'message' => 'Error',
                'error' => $e->getMessage()
            ], 401);
        }
        
        return response()->json([
            'message' => 'Thank you for joining!'
        ], 201);
    }

    /**
     * Buy an auction item
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function buy(CustomerBuyAuctionRequest $request)
    {
        $customer_id = Auth::id();
        $decrypted_id = decrypt($request->auction_id);

        try {
            Auctions::where('id', $decrypted_id)->update([
                'status' => 4,
                'bought_by' => $customer_id
            ]);
        } catch(Throwable $e) {
            return response()->json([
                'message' => 'Error',
                'error' => $e->getMessage()
            ], 401);
        }

        return response()->json([
            'message' => 'You have successfully bought an auction item!'
        ], 201);
    }

    public function history($id)
    {
        $customer_id = Auth::id();
        return CustomerBids::with('customer:id','customer.profile:customer_id,first_name,last_name')->where('auction_id', decrypt($id))
        ->orderByDesc('id')->limit(5)->get(['bidded_at as time', 'price', 'customer_id']);
    }

    public function activities()
    {
        $customer_id = Auth::id();
        return CustomerBids::with(
            'customer:id,username',
            'auction',
            'auction.product',
            'auction.product.thumbnail',
            'auction.product.category',
            'auction.product.brand',
            'auction.product.condition',
            'auction.product.store'
        )->where('customer_id', $customer_id)
        ->orderByDesc('id')->paginate(10);
    }

    public function transactions()
    {
        $customer_id = Auth::id();
        return AuctionWinnerAcknowledgement::with([
            'customer',
            'auction',
            'payment',
            'shipment',
            'auction.product',
            'auction.product.thumbnail',
            'auction.product.store',
            'auction.product.category',
            'auction.product.brand',
            'auction.highest',
            'auction.currency'
        ])
        ->whereRelation('auction.highest', 'customer_id', '=', $customer_id)
        ->where('customer_id', $customer_id)
        ->orderByDesc('id')->paginate(10);
    }

    public function notifications()
    {
        $customer_id = Auth::id();
        return Notifications::where('customer_id', $customer_id)
        ->orderByDesc('id')->limit(5)->get([
            'id',
            'title',
            'description',
            'redirect_url',
            'thumbnail_url',
            'created_at',
            'read'
        ]);
    }

    public function readNotification($id)
    {
        try {
            $customer_id = Auth::id();
            return Notifications::where([
                'customer_id' => $customer_id,
                'id' => $id
            ])
            ->update(['read' => 1]);
        } catch(Throwable $e) {
            return response()->json([
                'message' => $e->getMessage()
            ], 301);
        }

        return response()->json([
            'message' => 'read'
        ], 200);
    }

    public function checkout($token)
    {
        $customer_id = Auth::id();
        return AuctionWinnerAcknowledgement::with([
            'customer',
            'auction',
            'auction.product',
            'auction.product.images',
            'auction.product.store',
            'auction.product.category',
            'auction.product.brand',
            'auction.highest',
            'auction.currency'
        ])
        ->whereRelation('auction.highest', 'customer_id', '=', $customer_id)
        ->where([
            'customer_id' => $customer_id,
            'url_token' => $token,
            'status' => 0
        ])->firstOrFail();
    }

    public function checkoutSuccess($token)
    {
        $customer_id = Auth::id();
        return AuctionWinnerAcknowledgement::with([
            'auction',
            'auction.highest'
        ])
        ->whereRelation('auction.highest', 'customer_id', '=', $customer_id)
        ->where([
            'customer_id' => $customer_id,
            'url_token' => $token,
            'status' => 1
        ])->firstOrFail();
    }

    public function billingInfo()
    {
        $customer_id = Auth::id();
        return BillingInformation::where('customer_id', $customer_id)->first();
    }

    public function saveBillingInfo(StoreBillingInfoRequest $request)
    {
        try {
            $customer_id = Auth::id();
            $count_exist = BillingInformation::where('customer_id', $customer_id)->count();
            
            if($count_exist === 0) {
                BillingInformation::create([
                    'customer_id' => $customer_id,
                    'address' => $request->shipping_address,
                    'full_name' => $request->full_name,
                    'mobile_number' => $request->mobile_number
                ]);
            } else {
                BillingInformation::where('customer_id', $customer_id)->update([
                    'address' => $request->shipping_address,
                    'full_name' => $request->full_name,
                    'mobile_number' => $request->mobile_number
                ]);
            }
        } catch(Throwable $e) {
            return response()->json([
                'message' => 'Error',
                'error' => $e->getMessage()
            ], 401);
        }

        return response()->json([
            'message' => 'Information saved!'
        ], 201);
    }

}