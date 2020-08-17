<?php
namespace App\Repositories\Product;

use App\Product;
use Carbon\Carbon;

class ProductRepository implements IProductRepository {

    /**
     * {@inheritdoc}
     */
    public function find($id) {
        return Product::find($id);
    }

     /**
     * {@inheritdoc}
     */
    public function list($data, $paginate = false) {
        $query = Product::buildQuery($data);

        if ($paginate)
            return $query->paginate(10);

        return $query->get();
    }

     /**
     * {@inheritdoc}
     */
    public function create($data) {
        return Product::create($data);
    }

     /**
     * {@inheritdoc}
     */
    public function update(Product $product, $data) {
        $product->fill($data);
        $product->save();
        return $product;
    }

     /**
     * {@inheritdoc}
     */
    public function delete(Product $product, $forceDelete = false) {
        $product->delete();
        // if ($forceDelete) {
        //     $product->forceDelete();
        // } else {
        //     $data['updated_by'] = auth()->id();
        //     $data['deleted_at'] = Carbon::now()->format('Y-m-d H:i:s');
        //     $product->fill($data);
        //     $product->save();
        // }
    }
}