<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Services\Client\ProductService;
use Illuminate\Contracts\View\View;

class ProductController extends Controller
{
    public function __construct(
        protected ProductService $productService
    ) {}

    /**
     * Hiển thị chi tiết một dòng xe VinFast.
     */
    public function show(string $slug): View
    {
        $car = $this->productService->findBySlug($slug);

        if (! $car) {
            abort(404, 'Dòng xe bạn đang tìm kiếm không tồn tại hoặc đã ngừng kinh doanh.');
        }

        $variants = $this->productService->getVariants($car->id);
        $specifications = $this->productService->getSpecifications($car->id);
        $relatedCars = $this->productService->getRelatedCars($car->category_id, $car->id, 3);

        return view('clients.pages.products.show', [
            'car' => $car,
            'variants' => $variants,
            'specifications' => $specifications,
            'relatedCars' => $relatedCars,
        ]);
    }
}
