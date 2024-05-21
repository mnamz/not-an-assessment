<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Cookie;
use Srmklive\PayPal\Services\PayPal;

class PaypalController extends Controller
{
    public function success(Request $request)
    {
        $provider = new PayPal();
        $provider->setApiCredentials(config('paypal'));
        $provider->getAccessToken();
        $response = $provider->capturePaymentOrder($request->token);
        // dd($response);
        if(isset($response['status']) && $response['status'] == 'COMPLETED'){
            $order_id = Cache::pull('order_id'); 
            $payment = new Payment();
            $payment->payment_id = $response['id'];
            $payment->order_id = $order_id;
            $payment->amount = $response['purchase_units'][0]['payments']['captures'][0]['amount']['value'];
            $payment->currency = $response['purchase_units'][0]['payments']['captures'][0]['amount']['currency_code'];
            $payment->payer_name = $response['payer']['name']['given_name'];
            $payment->payer_email = $response['payer']['email_address'];
            $payment->payment_status = $response['status'];
            $payment->payment_method = 'Paypal';
            $payment->save();
            
            return 'Payment successful, your order ID:' . $order_id;

        }
    }

    public function cancel()
    {
        return 'Payment cancelled';
    }
}
