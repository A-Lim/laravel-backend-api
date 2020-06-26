<?php
namespace App\Repositories\Product;

use App\Product;

interface IProductRepository {
    /**
     * Find a product by id
     * 
     * @param integer $id
     * @return Product
     */
    public function find($id);

     /**
     * List products
     * 
     * @param array $query
     * @param boolean $paginate = false
     * @return array [Product] / LengthAwarePaginator
     */
    public function list($data, $paginate = false);

    /**
     * Create a product
     * 
     * @param array $data
     * @return Product
     */
    public function create($data);

     /**
     * Update a product
     * 
     * @param Product $product
     * @param array $data
     * @return void
     */
    public function update(Product $product, $data);
}