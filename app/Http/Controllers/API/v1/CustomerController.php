<?php

namespace App\Http\Controllers\API\v1;

use App\Models\Customers;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\v1\CustomerBidRequest;
use App\Http\Requests\v1\CustomerStoreRequest;
use App\Http\Requests\v1\CustomerUpdateRequest;
use App\Models\Bids;
use App\Models\CustomerBids;
use Illuminate\Support\Carbon;
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
        $customer_id = auth()->user()->id;
        return Customers::with(
            'profile:customer_id,email,first_name,middle_name,last_name,phone',
            'store:customer_id,name'
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
        $customer_id = auth()->user()->id;

        $bid = Bids::findOrFail($request->bid_id);
        $bid_exist = CustomerBids::where([
            'bid_id' => $bid->id,
            'customer_id' => $customer_id
        ])->first();

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

        return response()->json([
            'message' => 'Bid has been placed.'
        ], 201);
    }

    public function history($id)
    {
        $customer_id = auth()->user()->id;
        return CustomerBids::where('customer_id', $customer_id)
        ->where('bid_id', $id)
        ->orderByDesc('id')->limit(5)->get(['bidded_at as time', 'price']);
    }

}