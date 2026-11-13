<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Services\Client\CatalogService;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

class CatalogController extends Controller
{
    public function __construct(
        protected CatalogService $catalogService
    ) {}

    /**
     * Hiển thị danh mục toàn bộ các dòng xe VinFast.
     */
    public function index(Request $request): View
    {
        $filters = [
            'category' => $request->query('category'),
            'sort' => $request->query('sort', 'default'),
            'per_page' => 9,
        ];

        $cars = $this->catalogService->getPaginatedProducts($filters);
        $categories = $this->catalogService->getCategories();

        return view('clients.pages.catalog.index', [
            'cars' => $cars,
            'categories' => $categories,
            'currentCategory' => $filters['category'],
            'currentSort' => $filters['sort'],
        ]);
    }
}
