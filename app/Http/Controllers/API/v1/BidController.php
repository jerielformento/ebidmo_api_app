<?php

namespace App\Http\Controllers\API\v1;

use App\Models\Bids;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\v1\BidStoreRequest;
use Illuminate\Support\Arr;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
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
        return DB::table('bids')->join('products', 'products.id', '=', 'bids.product_id')->get();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(BidStoreRequest $request)
    {
        try {
            Bids::create([
                'product_id' => $request->product_id,
                'min_price' => $request->min_price,
                'buy_now_price' => $request->buy_now_price,
                'currency' => $request->currency,
                'started_at' => Carbon::now()->toDateTime(),
                'status' => 1
            ]);
        } catch(Throwable $e) {
            return response()->json([
                'message' => $e->getMessage()
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
        return DB::table('bids')->join('products', 'products.id', '=', 'bids.product_id')->where('bids.id', $id)->firstOrFail();
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
