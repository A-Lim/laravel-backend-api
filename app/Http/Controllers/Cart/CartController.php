<?php

namespace App\Http\Controllers\Cart;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Product;
use App\Http\Traits\ApiResponse;

use App\Repositories\Product\IProductRepository;

class CartController extends Controller
{
    use ApiResponse;

    private $productRepository;

    public function __construct(IProductRepository $iProductRepository) {
        $this->middleware(['web', 'guest']);
        $this->productRepository = $iProductRepository;
    }

    public function add(Request $request) {
        $product = $this->productRepository->find($request->product_id);
        // currently just allow only 1 item in cart
        session()->forget('cart');

        $cart = session('cart');

        if ($cart == null) {
            $cart = [[
                'product' => $product,
                'quantity' => 1,
            ]];
        }
        // check if cart already has product
        // if yes, increment quantity
        else {
            $existInCart = false;
            foreach ($cart as $key => $cartitem) {
                if ($cartitem['product']->id == $product->id) {
                    $existInCart = true;
                    // $cart[$key]['quantity'] = $cartitem['quantity'] + 1;
                }
            }

            if (!$existInCart) {
                array_push($cart, [
                    'product' => $product,
                    'quantity' => 1
                ]);
            }
        }
        
        session()->put('cart', $cart);
        session()->save();
        
        return redirect('order/details');
    }

    public function details() {
        $cart = session('cart');
        if ($cart == null)
            $cart = [];
        return $this->responseWithData(200, $cart);
    }

    public function remove(Request $request) {
        $cart = session('cart');

        if ($request->has('product_id')) {
            foreach ($cart as $key => $cartitem) {
                if ($cartitem['product']->id == $request->product_id)
                    unset($cart[$key]);
            }
        }
        
        session()->put('cart', $cart);
        session()->save();
        return $this->responseWithData(200, $cart);
    }
}
