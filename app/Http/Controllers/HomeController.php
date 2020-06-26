<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Contact;
use App\Product;
use App\Http\Traits\ApiResponse;
use App\Http\Requests\ContactUs\ContactUsRequest;

use App\Repositories\Contact\IContactRepository;

class HomeController extends Controller
{
    use ApiResponse;

    private $contactRepository;

    public function __construct(IContactRepository $iContactRepository) {
        $this->middleware(['web', 'guest']);
        $this->contactRepository = $iContactRepository;
    }

    public function index(Request $request) {
        return view('home');
    }

    public function contact_us(ContactUsRequest $request) {
        $this->contactRepository->create($request->all());
        return $this->responseWithMessage(200, 'Thank you for contacting us. We will get back to your shortly!');
    }

    public function privacy_policy() {
        return view('privacypolicy');
    }
}
