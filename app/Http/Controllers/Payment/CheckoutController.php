<?php

namespace App\Http\Controllers\Payment;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Repositories\Product\IProductRepository;
use App\Repositories\SystemSetting\SystemSettingRepositoryInterface;

class CheckoutController extends Controller
{
    // private $productRepository;
    // private $systemSettingRepository;
    
    // public function __construct(IProductRepository $iProductRepository,
    //     SystemSettingRepositoryInterface $systemSettingRepositoryInterface) {
    //     $this->middleware('guest');

    //     $this->productRepository = $iProductRepository;
    //     $this->systemSettingRepository = $systemSettingRepositoryInterface;
    // }

    // public function index(Request $request) {
    //     return view('orderdetails');
    // }
}
