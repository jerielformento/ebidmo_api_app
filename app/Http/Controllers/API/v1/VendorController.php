<?php

namespace App\Http\Controllers\API\v1;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\AuctionWinnerAcknowledgement;
use App\Models\Stores;
use Illuminate\Support\Facades\Auth;

class VendorController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
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
        //
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

    public function transactions()
    {
        $customer_id = Auth::id();
        $store = Stores::where('customer_id', $customer_id)->firstOrFail();
        
        return AuctionWinnerAcknowledgement::with([
            'customer',
            'auction',
            'auction.product',
            'auction.product.thumbnail',
            'auction.product.store',
            'auction.product.category',
            'auction.product.brand',
            'auction.highest',
            'auction.currency'
        ])
        ->whereRelation('auction.product.store', 'slug', '=', $store->slug)
        ->orderByDesc('id')->paginate(10);
    }
}
