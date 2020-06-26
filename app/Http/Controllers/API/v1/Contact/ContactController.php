<?php

namespace App\Http\Controllers\API\v1\Contact;

use App\Http\Controllers\ApiController;
use Illuminate\Http\Request;

use App\Contact;
use App\Repositories\Contact\IContactRepository;

class ContactController extends ApiController {

    private $contactRepository;

    public function __construct(IContactRepository $iContactRepository) {
        $this->middleware('auth:api');
        $this->contactRepository = $iContactRepository;
    }
    
    public function list(Request $request) {
        // $this->authorize('viewAny', Product::class);
        $paginate = $request->has('paginate') ? $request->paginate : true;
        $contacts = $this->contactRepository->list($request->all(), $paginate);
        return $this->responseWithData(200, $contacts);
    }

    public function details(Contact $contact) {
        // $this->authorize('view', $contact);
        $contact->markAsRead();
        return $this->responseWithData(200, $contact); 
    }
}
