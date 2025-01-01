<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Cart;
use App\Models\Order;
use App\Models\Payment;
use App\Models\CartItem;
use Stripe\StripeClient;
use App\Models\OrderItem;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;

class StripePaymentController extends Controller
{
    public function checkoutSuccess(Request $request)
    {

        // dd($request->all());
        try {
            // Set the Stripe API key
            $stripe = new StripeClient(config('services.stripe.secret'));
            $user = auth()->user();

            // Retrieve the session from Stripe
            $session = $stripe->checkout->sessions->retrieve($request->session_id);

            // Check if the payment is successful
            if ($session->payment_status == 'paid') {
                DB::beginTransaction();
                $payment = Payment::where('id', $request->order)->first();
                $payment->status = 'succeeded';
                $payment->save();


                $cartItems = Cart::where('user_id', $payment->user_id)->with('cartItems')->first();

                // Ensure that there are items in the cart before proceeding
                if ($cartItems && $cartItems->cartItems->count() > 0) {
                    // Create the order
                    $order = Order::create([
                        'user_id' => $payment->user_id,  // Use the correct user_id
                        'payment_id' => $payment->id,
                        'order_number' => Order::generateOrderNumber(),  // Generate unique order number
                        'status' => 'pending',
                        'total_amount' => $payment->amount,
                        // 'receiver_name' => $payment->user->name,  // Use the correct user's name
                        'receiver_name' => $payment->name,


                    ]);

                    // Add OrderItems for each product in the cart items
                    foreach ($cartItems->cartItems as $cartItem) {
                        OrderItem::create([
                            'order_id' => $order->id,
                            'product_id' => $cartItem->product_id,
                            'variant_id' => $cartItem->variant_id,
                            'color' => $cartItem->color,
                            'color_code' => $cartItem->color_code,
                            'quantity' => $cartItem->quantity,  // Assuming quantity is stored in CartItem table
                            'price' => $cartItem->price,  // Price at the time of purchase


                        ]);
                        $cartItem->delete();
                    }

                    // Delete the user's cart items and the cart itself after successful payment
                    Cart::where('user_id', $payment->user_id)->delete();
                }
                DB::commit();

                // Redirect to frontend after successful payment
                $FRONTEND_SUCCESS_URL = env('FRONTEND_SUCCESS_URL', route('login'));
                return redirect($FRONTEND_SUCCESS_URL)->with('t-success', 'Purchase completed');
            } else {
                // Log and redirect on failure
                Log::error('Payment failed for session ID: ' . $request->session_id);
                $FRONTEND_FAILED_URL  = env('FRONTEND_FAILED_URL ', route('login'));
                return redirect($FRONTEND_FAILED_URL )->with('t-error', 'Transaction Failed...');
            }
        } catch (\Exception $e) {
            dd($e->getMessage());
            DB::rollBack();
            Log::error('Order completion failed: ' . $e->getMessage());
            $FRONTEND_FAILED_URL  = env('FRONTEND_FAILED_URL ', route('login'));
            return redirect($FRONTEND_FAILED_URL )->with('t-error', 'Order completion failed: ' . $e->getMessage());
        }
    }


    public function checkoutCancel()
    {
        $FRONTEND_FAILED_URL  = env('FRONTEND_FAILED_URL ', route('home'));
        return redirect($FRONTEND_FAILED_URL )->with('t-error', 'Transaction Failed...');
    }
}
