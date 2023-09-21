<?php

namespace App\Http\Controllers\API\v1;

use App\Models\AuctionWinnerAcknowledgement;
use App\Http\Controllers\Controller;
use App\Models\CustomersProfile;
use App\Models\PaymentTransactions;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;
use Throwable;

class PaymentController extends Controller
{
    public function oldcheckout($token)
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
            //'redirect_url' => env('FRONTEND_URL').'/me/profile/transactions',
            //'webhook' => 'https://staging-api.ebidmo.net/payment-webhook'
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

    public function checkout($token)
    {
        
        $customer_id = Auth::id();
        $checkout = AuctionWinnerAcknowledgement::with([
            'customer',
            'billing',
            'customer.profile:customer_id,email',
            'auction',
            'auction.highest',
            'auction.currency',
            'auction.product.thumbnail'
        ])
        ->whereRelation('auction.highest', 'customer_id', '=', $customer_id)
        ->where([
            'customer_id' => $customer_id,
            'url_token' => $token,
            'status' => 0
        ])->firstOrFail();

        $item = collect($checkout);
        $curl = curl_init();

        $amount = (int)number_format((float)$item['auction']['highest']['price']*100, 0, '.', '');
        //$charge = 1500; //
        $total_amount = $amount;
        //return json_encode($total_amount);

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
                            'amount' => $total_amount,
                            'currency' => $item['auction']['currency']['code'],
                            'images' => [$item['auction']['product']['thumbnail']['url']],
                            'name' => $item['auction']['product']['name'],
                            'description' => $item['auction']['product']['details'],
                            'quantity' => 1
                        ]
                    ],
                    'billing' => [
                        'address' => [
                            'line1' => $item['billing']['address']
                        ],
                        'email' => $item['customer']['profile']['email'],
                        'name' => $item['billing']['full_name'],
                        'phone' => $item['billing']['mobile_number']
                    ],
                    'customer_email' => $item['customer']['profile']['email'],
                    'payment_method_types' => ['gcash','paymaya'],
                    'success_url' => env('APP_URL').'/payment-webhook',
                    'cancel_url' => env('FRONTEND_URL').'/me/profile/transactions/checkout/'.$token,
                ]
            ],
            'description' => 'text'
        ]),
        CURLOPT_HTTPAUTH => CURLAUTH_BASIC,
        CURLOPT_USERPWD => env('PAYMENT_AUTH').':',
        CURLOPT_HTTPHEADER => [
            "accept: application/json",
            "content-type: application/json"
        ],
        ]);

        $response = json_decode(curl_exec($curl), true);
        $err = curl_error($curl);

        curl_close($curl);

        if ($err) {
            echo "Error #:" . $err;
        } else {
            Session::put('acknowledgement_token', $token);
            Session::put('payment_transaction_id', $response['data']['id']);
            echo json_encode($response);
        } 
    }

    public function success()
    {
        if(Session::has(['acknowledgement_token','payment_transaction_id'])) {
            $transactionId = Session::get('payment_transaction_id');
            $tokenId = Session::get('acknowledgement_token');
        
            /* try {
                PaymentTransactions::create([
                    'payment_id' => $sessionId,
                    'payment_request_id' => '2',
                    'phone' => '3333',
                    'amount' => '10',
                    'currency' => 'PHP',
                    'status' => 'OKAY',
                    'reference_number' => '12312312',
                    'hmac' => 'asdasda-asdasd'
                ]);
            } catch(Throwable $e) {
                return response()->json([
                    'message' => $e->getMessage()
                ], 301);
            }
            
            return response()->json([
                'message' => 'Success'
            ], 201); */
        
            $curl = curl_init();
        
            curl_setopt_array($curl, [
            CURLOPT_URL => "https://api.paymongo.com/v1/checkout_sessions/".$transactionId,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "GET",
            CURLOPT_HTTPAUTH => CURLAUTH_BASIC,
                CURLOPT_USERPWD => env('PAYMENT_AUTH').':',
                CURLOPT_HTTPHEADER => [
                    "accept: application/json",
                    "content-type: application/json"
                ],
            ]);
    
            $response = json_decode(curl_exec($curl), true);
            //$response = curl_exec($curl);
            $err = curl_error($curl);
    
            curl_close($curl);
    
            if ($err) {
                echo "Error #:" . $err;
            } else {
               try {
                    $transaction = $response['data']['attributes'];
                    $total_amount = number_format((float)$transaction['payments'][0]['attributes']['amount']/100, 2, '.', '');

                    $payment_transaction = PaymentTransactions::create([
                        'acknowledgement_token' => $tokenId,
                        'checkout_id' => $transactionId,
                        'payment_id' => $transaction['payments'][0]['id'],
                        'payment_method_used' => $transaction['payment_method_used'],
                        'amount' => $total_amount,
                        'currency' => $transaction['payments'][0]['attributes']['currency'],
                        'status' => $transaction['payments'][0]['attributes']['status']
                    ]);

                    if($payment_transaction && $transaction['payments'][0]['attributes']['status'] === 'paid') {
                        AuctionWinnerAcknowledgement::where('url_token', $tokenId)->update([
                            'status' => 1
                        ]);
                    }
                } catch(Throwable $e) {
                    return response()->json([
                        'message' => $e->getMessage()
                    ], 301);
                }

                return redirect()->away(env('FRONTEND_URL').'/me/profile/transactions/checkout/'.$tokenId.'/success');
                //echo $response;
            }
    
            Session::forget([
                'acknowledgement_token',
                'payment_transaction_id'
            ]);
        } else {
            return response()->json([
                'message' => 'Session expired!'
            ], 301);
        }
    }
}
