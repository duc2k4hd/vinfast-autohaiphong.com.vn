<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Services\Client\CatalogService;
use App\Services\Shared\SettingsService;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

class CatalogController extends Controller
{
    public function __construct(
        protected CatalogService $catalogService,
        protected SettingsService $settingsService
    ) {}

    /**
     * Hiển thị danh mục toàn bộ các dòng xe VinFast.
     */
    public function index(Request $request): View
    {
        $filters = [
            'category' => is_string($request->query('category')) ? $request->query('category') : null,
            'sort' => in_array($request->query('sort'), ['default', 'price_asc', 'price_desc', 'latest'], true) ? $request->query('sort') : 'default',
            'per_page' => 9,
            'page' => $request->route('page') ? (int) $request->route('page') : null,
        ];

        $cars = $this->catalogService->getPaginatedProducts($filters);
        if ($cars->currentPage() > $cars->lastPage()) {
            abort(404);
        }
        $categories = $this->catalogService->getCategories();

        return view('clients.pages.catalog.index', [
            'cars' => $cars,
            'catalogIntroImage' => $this->settingsService->getPublicSettings()['catalog_intro_image'] ?? null,
            'categories' => $categories,
            'currentCategory' => $filters['category'],
            'currentSort' => $filters['sort'],
        ]);
    }
}
