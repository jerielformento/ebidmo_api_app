<?php

namespace App\Http\Controllers\API\v1;

use App\Models\AuctionWinnerAcknowledgement;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PaymentController extends Controller
{
    public function checkout($token)
    {
        $customer_id = Auth::id();
        $checkout = AuctionWinnerAcknowledgement::with([
            'customer',
            'auction',
            'auction.highest',
            'auction.currency'
        ])
        ->whereRelation('auction.highest', 'customer_id', '=', $customer_id)
        ->where([
            'customer_id' => $customer_id,
            'url_token' => $token,
            'status' => 0
        ])->firstOrFail();

        //return $checkout;
        $item = collect($checkout);
        
        $postfields = [
            'amount' => $item['auction']['highest']['price'],
            'currency' => $item['auction']['currency']['code'],
            'email' => $item['customer']['username'],
            'payment_methods' => ['upay_gcash'],
            'redirect_url' => 'http://localhost/api-docs'
        ];
        

        $curl = curl_init();
        curl_setopt_array($curl, [
        CURLOPT_URL => "https://api.sandbox.hit-pay.com/v1/payment-requests",
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => "",
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 30,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => "POST",
        CURLOPT_POSTFIELDS => json_encode($postfields),
        CURLOPT_HTTPHEADER => [
            "Content-Type: application/json",
            "X-BUSINESS-API-KEY: da60790b3c460c9f04556ae969f2105c53555527ca83de9b9b5826c08f20b3d5"
        ],
        ]);

        $response = curl_exec($curl);
        $err = curl_error($curl);

        curl_close($curl);

        if ($err) {
        echo "cURL Error #:" . $err;
        } else {
        echo $response;
        }
    }

    public function oldcheckout()
    {
        /* $curl = curl_init();

            curl_setopt_array($curl, [
            CURLOPT_URL => "https://api.paymongo.com/v1/checkout_sessions",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_POSTFIELDS => json_encode([
                'data' => [
                    'attributes' => [
                        'line_items' => [
                            [
                                'amount' => $request->data['amount'],
                                'currency' => $request->data['currency'],
                                'name' => $request->data['name'],
                                'quantity' => $request->data['quantity']
                            ]
                        ],
                        'payment_method_types' => ['gcash'],
                    ]
                ],
                'success_url' => 'http://localhost:3000/me/profile',
                'cancel_url' => 'http://localhost:3000/me/profile/transactions',
                'description' => 'text'
            ]),
            CURLOPT_HTTPAUTH => CURLAUTH_BASIC,
            CURLOPT_USERPWD => 'sk_test_zj4YnEusNgZB4Gekifhh8sAM:',
            CURLOPT_HTTPHEADER => [
                "accept: application/json",
                "content-type: application/json"
            ],
            ]);

            $response = curl_exec($curl);
            $err = curl_error($curl);

            curl_close($curl);

            if ($err) {
            echo "cURL Error #:" . $err;
            } else {
            echo $response;
            } */

    }
}
