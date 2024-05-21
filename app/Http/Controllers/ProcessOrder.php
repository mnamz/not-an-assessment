<?php

namespace App\Http\Controllers;

use App\Enums\OrderPayment;
use App\Models\Order;
use App\Models\OrderDetails;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Log;
use Srmklive\PayPal\Services\PayPal;

class ProcessOrder extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        $items = $request->input('items');
        $customerName = $request->input('customerName');
        $customerAddress = $request->input('customerAddress');
        $deliveryOption = $request->input('deliveryOption');
        $paymentMethod = $request->input('paymentMethod');
        $restaurantIds = array_unique(array_column($items, 'restaurant_id'));

        Log::info('Restaurant IDs:', $restaurantIds);

        /**
         * Collecting user data 🥰🎀
         */
        Log::info('Request Details:', [
            'user_agent' => $request->userAgent(),
            'ip_address' => $request->ip(),
        ]);

        /**
         * Order created to respective restaurant
         */

        foreach ($restaurantIds as $restaurant) {
            $order = Order::create([
                'customer_name' => $customerName,
                'restaurant_id' => $restaurant,
                'method' => $deliveryOption,
                'payment' => $paymentMethod,
                'address' => $customerAddress,
                'total' => $request->amount,
            ]);
        }

        foreach ($items as $item) {
            OrderDetails::create([
                'order_id' => $order->id,
                'item_id' => $item['id'],
            ]);
        }

        /**
         * Time consuming bug, cannot use session on local machine.
         * Using cache as quick fix for local testing of payment gateway.
         * Not for concurrent usage.
         * 
         * Use case: store payment data, point to order ID created
         */

        Cache::put('order_id', $order->id, 3600);

        // TODO? not: I want to set email notification but mailtrap/SMTP takes time to setup 

        if ($paymentMethod === OrderPayment::Paypal->value) {
            session_start();
            $provider = new PayPal();
            $provider->setApiCredentials(config('paypal'));
            $provider->getAccessToken();
            $response = $provider->createOrder([
                "intent" => "CAPTURE",
                "application_context" => [
                    "return_url" => route('success'),
                    "cancel_url" => route('cancel')
                ],
                "purchase_units" => [
                    [
                        "amount" => [
                            "currency_code" => "MYR",
                            "value" => $request->amount,
                        ]
                    ]
                ]
            ]);
            // dd($response);
            if (isset($response['id']) && $response['id'] != null) {
                foreach ($response['links'] as $link) {
                    if ($link['rel'] === 'approve') {
                        Log::info('new sesh order id ' . $order->id);
                        return $link['href'];
                    }
                }
            } else {
                return redirect()->route('cancel');
            }
        } else {
            // If user wants to pay cash, send to COD page
            return 'cod';
        }
    }
}
