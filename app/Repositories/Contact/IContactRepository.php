<?php
namespace App\Repositories\Contact;

use App\Contact;

interface IContactRepository {
     /**
     * List contacts for datatable
     * 
     * @param array $query
     * @param boolean $paginate = false
     * @return array [Contact] / LengthAwarePaginator
     */
    public function list($data, $paginate = false);

    /**
     * Create contact
     * 
     * @param array $data
     * @return Contact
     */
    public function create($data);

     /**
     * Update contact
     * 
     * @param Contact $contact
     * @param array $data
     * @return void
     */
    public function update(Contact $contact, $data);
}