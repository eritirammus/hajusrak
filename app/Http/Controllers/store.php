<?php

namespace App\Http\Controllers;

use App\Mail\Paymentcomplete;
use App\Models\Products;
use Illuminate\Http\Request;
use Stripe\PaymentIntent;
use Stripe\Stripe;

class store extends Controller
{
    public function index()
    {
        return view('welcome', [
            'products' => Products::all(),
            'cart' => session('cart', [])
        ]);
    }

    public function cart()
    {
        return view('cart', [
            'cart' => session('cart')
        ]);
    }

    public function addtocart(Request $request)
    {
        $cart = $request->session()->get('cart');

        $quantity = 0;
        if ($request->qty <= 0) {
            $quantity = 1;
        } else {
            $quantity = $request->quantity;
        }

        $product = Products::find($request->id);
        $productitem = [
            'id' => $product->id,
            'name' => $product->name,
            'description' => $product->description,
            'price' => $product->price,
            'image' => $product->image,
            'quantity' => $quantity
        ];
        if (!$cart) {
            $cart = [
                $product->id => $productitem
            ];
            $request->session()->put('cart', $cart);
            return redirect()->back();
        }
        if (isset($cart[$product->id])) {
            $cart[$product->id]['quantity']++;
            $request->session()->put('cart', $cart);
            return redirect()->back();
        }
        $cart[$product->id] = $productitem;
        $request->session()->put('cart', $cart);
        return redirect()->back();
    }

    public function updatecart(Request $request)
    {
        $quantity = 0;
        if ($request->quantity <= 0) {
            $quantity = 1;
        } else {
            $quantity = $request->quantity;
        }
        $cart = session('cart');
        $cart[$request->id]['quantity'] = $quantity;
        $request->session()->put('cart', $cart);
        return redirect()->back();
    }

    public function deleteitem(Request $request)
    {
        $cart = session('cart');
        unset($cart[$request->id]);
        $request->session()->put('cart', $cart);
        return redirect()->back();
    }

    public function subscribe()
    {
        $cart = collect(session('cart'));
        $total = $cart->map(function ($item) {
            return intval(($item['price'] * 100) * $item['quantity']);
        });

        Stripe::setApiKey('sk_test_51KH6hGLzawazuwmcJ147JDLzKnOyBKQiO2NxGnUWP0XgaPmQK7HyD3oM6JmfqtFPlQ5JGoRpXfNOPmjnH4yfZf7000NOUZaFJI');
        $paymentIntent = PaymentIntent::create([
            'amount' => $total->sum(),
            'currency' => 'eur',
            'payment_method_types' => [
                "card"
            ],
        ]);
        $output = [
            'paymentIntent' => $paymentIntent,
            'stripePublicKey' => "pk_test_51KH6hGLzawazuwmcDdNYHNw1EcAztsFxkpvRp1uOpmoSbdvsma4PbV8jaarX32KvM6zviLCnjWgFqkMvlJq5wRlb00jyONllwb"
        ];
        return $output;
    }

    public function success()
    {
        $cart = session('cart');

        session()->forget('cart');
    }
}
