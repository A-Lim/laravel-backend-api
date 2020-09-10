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

        if ($paginate) {
            $limit = isset($data['limit']) ? $data['limit'] : 10;
            return $query->paginate($limit);
        }

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