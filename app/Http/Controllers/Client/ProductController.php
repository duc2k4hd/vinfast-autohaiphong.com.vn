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

        $galleryImages = $this->productService->getGalleryImages($car->id);

        if ($galleryImages->isEmpty() && $car->thumbnail_path) {
            $galleryImages = collect([(object) [
                'path' => $car->thumbnail_path,
                'alt_text' => $car->thumbnail_alt ?: $car->name,
            ]]);
        }

        $variants = $this->productService->getVariants($car->id);
        $colors = $this->productService->getColors($car->id);
        $specifications = $this->productService->getSpecifications($car->id);
        $relatedCars = $this->productService->getRelatedCars($car->category_id, $car->id, 3);

        return view('clients.pages.products.show', [
            'car' => $car,
            'galleryImages' => $galleryImages,
            'variants' => $variants,
            'colors' => $colors,
            'specifications' => $specifications,
            'relatedCars' => $relatedCars,
        ]);
    }
}
