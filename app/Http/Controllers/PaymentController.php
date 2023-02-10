<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Stripe\Charge;
use Stripe\Stripe;
use Stripe\StripeClient;

class PaymentController extends Controller
{
    public function createPaymentIntent(Product $product)
    {
        $stripe = new StripeClient(env('STRIPE_SECRET'));
        // $res = $stripe->tokens->create([
        //     'card' => [
        //     'number' => $request->number,
        //     'exp_month' => $request->exp_month,
        //     'exp_year' => $request->exp_year,
        //     'cvc' => $request->cvc,
        //     ],
        //     ]);

        // Stripe::setApiKey(env('STRIPE_SECRET'));
        $paymentIntent =  $stripe->paymentIntents->create([
            "amount" => $product->price,
            "currency" => 'usd',
            "payment_method_types" => ['card'],
        ]);
        return response()->json(['kk'=>$stripe]);

        Payment::query()->create([
            'product_id' => $product->id,
            'amount' => $paymentIntent->amount,
            'method' => 'stripe',
            'user_id' => $product->owner_id,
            'currency' => $paymentIntent->currency,
            'status' => 'pending',
            'transaction_id' => $paymentIntent->id,
            'transaction_data' => json_encode($paymentIntent)
        ]);

        return response()->json([
            'clientSecret' =>  $paymentIntent->client_secret
        ]);
    }

    public function confirm(Request $request, Product $product)
    {
        $stripe = new StripeClient(env('STRIPE_SECRET'));
        $paymentIntent = $stripe->paymentIntents->retrieve(
            $request->query('payment_intent'),
            []
        );
        return $paymentIntent;

        if ($paymentIntent->status == 'succeded') {
            Payment::query()
                ->where('product_id', $product->id)
                ->update([
                    'status' => 'completed',
                    'transaction_data' => json_encode($paymentIntent)
                ]);
        }

        return "success";
    }
}
