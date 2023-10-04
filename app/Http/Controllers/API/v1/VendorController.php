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

    public function shipments()
    {
        $customer_id = Auth::id();
        $store = Stores::where('customer_id', $customer_id)->firstOrFail();
        return AuctionWinnerAcknowledgement::with([
            'customer',
            'auction',
            'shipment',
            'shipment.courier',
            'auction.product',
            'auction.product.thumbnail',
            'auction.product.store',
            'auction.product.category',
            'auction.product.brand',
            'auction.highest',
            'auction.currency'
        ])
        ->whereHas('shipment')
        ->whereRelation('shipment','status','=',1)
        ->orderByDesc('id')->paginate(10);
    }

    public function completeShipments()
    {
        $customer_id = Auth::id();
        $store = Stores::where('customer_id', $customer_id)->firstOrFail();
        return AuctionWinnerAcknowledgement::with([
            'customer',
            'auction',
            'shipment',
            'shipment.courier',
            'auction.product',
            'auction.product.thumbnail',
            'auction.product.store',
            'auction.product.category',
            'auction.product.brand',
            'auction.highest',
            'auction.currency'
        ])
        ->whereHas('shipment')
        ->whereRelation('shipment','status','=',2)
        ->orderByDesc('id')->paginate(10);
    }

    public function transactionInfo($token)
    {
        $customer_id = Auth::id();
        $store = Stores::where('customer_id', $customer_id)->firstOrFail();
        
        return AuctionWinnerAcknowledgement::with([
            'customer',
            'auction',
            'payment',
            'billing',
            'auction.product',
            'auction.product.thumbnail',
            'auction.product.store',
            'auction.product.category',
            'auction.product.brand',
            'auction.highest',
            'auction.currency'
        ])
        ->whereRelation('auction.product.store', 'slug', '=', $store->slug)
        ->where([
            'url_token' => $token
        ])->firstOrFail();
    }
    
    public function transactionReport()
    {
        $customer_id = Auth::id();
        $store = Stores::where('customer_id', $customer_id)->firstOrFail(['id']);

        $auctions = AuctionWinnerAcknowledgement::with('payment')
        ->whereIn('status', [1,2,3])->get();

        //return $payments;
        $total_payout = 0;
        $total_shipped = 0;
        $total_completed = 0;

        $transactions = collect($auctions);
        foreach($transactions as $transaction) {
            $total_payout += $this->deductTransactionCharge($transaction['payment']['amount']);
            $total_shipped += ($transaction['status'] === 2) ? 1 : 0;
            $total_completed += ($transaction['status'] === 3) ? 1 : 0;
        }

        /* $stores = Stores::withCount('products')->where('id', $store->id)->get();
        $astore = collect($stores);
        foreach($astore as $store) {
            $count_products += $store['products_count'];
        }

        $transactions = AuctionWinnerAcknowledgement::with('auction', 'auction.product')
        ->whereRelation('auction.product', 'store_id', '=', $store->id)->count(); */

        return response()->json([
            'total_payout' => '₱'.number_format($total_payout),
            'total_shipped' => $total_shipped,
            'total_completed' => $total_completed
        ]);
    }

    private function deductTransactionCharge($amount)
    {
        return $amount - ($amount / 100 * 5);
    }
}
