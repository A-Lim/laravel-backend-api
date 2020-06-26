<?php

namespace App\Http\Controllers\API\v1\Product;

use App\Http\Controllers\ApiController;
use Illuminate\Http\Request;

use App\Product;
use App\Repositories\Product\IProductRepository;

use App\Http\Requests\Product\CreateRequest;
use App\Http\Requests\Product\UpdateRequest;

class ProductController extends ApiController {

    private $productRepository;

    public function __construct(IProductRepository $iProductRepository) {
        $this->middleware('auth:api');
        $this->productRepository = $iProductRepository;
    }
    
    public function list(Request $request) {
        // $this->authorize('viewAny', Product::class);
        $paginate = $request->has('paginate') ? $request->paginate : true;
        $products = $this->productRepository->list($request->all(), $paginate);
        return $this->responseWithData(200, $products);
    }

    public function create(CreateRequest $request) {
        // $this->authorize('create', Product::class);
        $product = $this->productRepository->create($request->all());
        return $this->responseWithMessageAndData(201, $product, 'Product created.');
    }

    public function details(Product $product) {
        // $this->authorize('view', $product);
        return $this->responseWithData(200, $product); 
    }

    public function update(UpdateRequest $request, Product $product) {
        // $this->authorize('update', $product);
        $product = $this->productRepository->update($product, $request->all());
        return $this->responseWithMessageAndData(200, $product, 'Product updated.'); 
    }

    public function delete(Product $product) {
        // $this->authorize('delete', $product);
        $this->productRepository->delete($product);
        return $this->responseWithMessage(200, 'Product deleted.');
    }
}
