<?php
namespace App\Repositories\Contact;

use App\Contact;
use Carbon\Carbon;

class ContactRepository implements IContactRepository {

     /**
     * {@inheritdoc}
     */
    public function list($data, $paginate = false) {
        $query = Contact::buildQuery($data);

        if ($paginate)
            return $query->paginate(10);

        return $query->get();
    }

     /**
     * {@inheritdoc}
     */
    public function create($data) {
        return Contact::create($data);
    }

     /**
     * {@inheritdoc}
     */
    public function update(Contact $contact, $data) {
        $contact->update($data);
    }
}