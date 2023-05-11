<?php

namespace App\Http\Controllers;

use App\Http\Requests\CustomerBidRequest;
use App\Models\Bids;
use App\Models\CustomerBids;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Throwable;

class CustomerController extends Controller
{
    /**
     * Bid to a specific product.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function bid(CustomerBidRequest $request)
    {   
        $customer_id = auth()->user()->id;

        $bid = Bids::findOrFail($request->bid_id);
        $bid_exist = CustomerBids::where([
            'bid_id' => $bid->id,
            'customer_id' => $customer_id
        ])->first();

        if(!$bid_exist) {
            try {
                CustomerBids::create([
                    'bid_id' => $request->bid_id,
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
        } else {
            return response()->json([
                'message' => 'You already placed your bid.'
            ], 201);    
        }

        return response()->json([
            'message' => 'Bid has been placed.'
        ], 201);
    }
}
