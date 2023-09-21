<?php

namespace App\Http\Controllers\API\v1;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\v1\StoreShipmentRequest;
use App\Models\AuctionWinnerAcknowledgement;
use App\Models\ShipmentTransactions;
use App\Models\Stores;
use Illuminate\Support\Facades\Auth;
use Throwable;

class ShipmentTransactionsController extends Controller
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
    public function store(StoreShipmentRequest $request)
    {
        try {
            $customer_id = Auth::id();
            $store = Stores::where('customer_id', $customer_id)->first(['slug']);
    
            $checkout = AuctionWinnerAcknowledgement::with([
                'customer',
                'billing',
                'customer.profile:customer_id,email',
                'auction',
                'auction.product.store',
                'auction.highest',
                'auction.currency',
                'auction.product.thumbnail'
            ])
            ->whereRelation('auction.product.store','slug','=',$store->slug)
            ->where([
                'url_token' => $request->transaction
            ])->firstOrFail();
            
            $item = collect($checkout);

            $shipment = ShipmentTransactions::create([
                'acknowledgement_token' => $request->transaction,
                'full_name' => $item['billing']['full_name'],
                'address' => $item['billing']['address'],
                'contact' => $item['billing']['mobile_number'],
                'courier' => $request->courier,
                'status' => 1
            ]);

            if($shipment) {
                AuctionWinnerAcknowledgement::where('url_token', $request->transaction)->update([
                    'status' => 2
                ]);
            }
        } catch(Throwable $e) {
            return response()->json([
                'message' => $e->getMessage()
            ], 301);
        }
        
        return response()->json([
            'message' => 'Item has been shipped.'
        ], 200);
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
        try {
            $customer_id = Auth::id();
            $transaction = AuctionWinnerAcknowledgement::where('url_token', $id)->update([
                'status' => 3
            ]);

            if($transaction) {
                ShipmentTransactions::where('acknowledgement_token', $id)->update([
                    'status' => 2
                ]);
            }
        } catch(Throwable $e) {
            return response()->json([
                'message' => $e->getMessage()
            ], 301);
        }

        return response()->json([
            'message' => 'Transaction completed!'
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
