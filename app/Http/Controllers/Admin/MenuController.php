<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Menu;
use App\Models\MenuItem;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class MenuController extends Controller
{
    /**
     * Giao diện quản lý Menu và Ảnh hiển thị.
     */
    public function index(Request $request): View
    {
        // 1. Toàn bộ xe trong hệ thống kèm ảnh hiển thị và danh mục
        $vehicles = DB::table('products')
            ->leftJoin('media', 'products.thumbnail_media_id', '=', 'media.id')
            ->leftJoin('product_categories', 'products.category_id', '=', 'product_categories.id')
            ->whereNull('products.deleted_at')
            ->select([
                'products.id',
                'products.name',
                'products.slug',
                'products.status',
                'products.sort_order',
                'products.show_in_menu',
                'products.thumbnail_media_id',
                'product_categories.name as category_name',
                'media.path as thumbnail_path',
                'media.filename as thumbnail_filename',
            ])
            ->orderBy('products.sort_order', 'asc')
            ->orderBy('products.id', 'asc')
            ->get();

        // 2. Danh sách Menu & Menu Items của Header và Footer
        $headerMenu = Menu::where('slug', 'header')->first();
        if (! $headerMenu) {
            $headerMenu = Menu::create([
                'name' => 'Menu Đầu Trang (Header)',
                'slug' => 'header',
                'is_active' => true,
            ]);
        }

        $headerItems = MenuItem::where('menu_id', $headerMenu->id)
            ->leftJoin('media', 'menu_items.image_media_id', '=', 'media.id')
            ->select([
                'menu_items.*',
                'media.path as image_path',
            ])
            ->orderBy('menu_items.sort_order', 'asc')
            ->get();

        return view('admin.menus.index', compact('vehicles', 'headerMenu', 'headerItems'));
    }

    /**
     * Cập nhật nhanh một dòng xe (ảnh hiển thị, trạng thái menu, thứ tự sắp xếp).
     */
    public function updateVehicleSingle(Request $request, int $id): JsonResponse
    {
        $validated = $request->validate([
            'thumbnail_media_id' => 'nullable|integer',
            'show_in_menu' => 'nullable|boolean',
            'sort_order' => 'nullable|integer',
        ]);

        $updateData = [];

        if ($request->has('thumbnail_media_id')) {
            $updateData['thumbnail_media_id'] = $validated['thumbnail_media_id'] ?: null;
        }

        if ($request->has('show_in_menu')) {
            $updateData['show_in_menu'] = (bool) $validated['show_in_menu'];
        }

        if ($request->has('sort_order')) {
            $updateData['sort_order'] = (int) $validated['sort_order'];
        }

        if (! empty($updateData)) {
            $updateData['updated_at'] = now();
            DB::table('products')->where('id', $id)->update($updateData);
            $this->clearMenuCache();
        }

        $product = DB::table('products')
            ->leftJoin('media', 'products.thumbnail_media_id', '=', 'media.id')
            ->where('products.id', $id)
            ->select('products.*', 'media.path as thumbnail_path')
            ->first();

        return response()->json([
            'success' => true,
            'message' => 'Đã cập nhật cấu hình xe hiển thị trên menu!',
            'product' => $product,
        ]);
    }

    /**
     * Cập nhật hàng loạt danh sách xe hiển thị và thứ tự sắp xếp trên Menu.
     */
    public function updateVehicleMenu(Request $request): RedirectResponse
    {
        $vehicles = $request->input('vehicles', []);

        foreach ($vehicles as $id => $data) {
            $update = [
                'sort_order' => isset($data['sort_order']) ? (int) $data['sort_order'] : 0,
                'show_in_menu' => isset($data['show_in_menu']) ? 1 : 0,
                'updated_at' => now(),
            ];

            if (! empty($data['thumbnail_media_id'])) {
                $update['thumbnail_media_id'] = (int) $data['thumbnail_media_id'];
            }

            DB::table('products')->where('id', (int) $id)->update($update);
        }

        $this->clearMenuCache();

        return redirect()->route('admin.menus.index')
            ->with('success', 'Đã lưu cấu hình Menu Xe và Ảnh hiển thị thành công!');
    }

    /**
     * Thêm một mục menu điều hướng mới.
     */
    public function storeMenuItem(Request $request): JsonResponse|RedirectResponse
    {
        $validated = $request->validate([
            'menu_id' => 'required|integer|exists:menus,id',
            'label' => 'required|string|max:150',
            'url' => 'nullable|string|max:2000',
            'route_name' => 'nullable|string|max:150',
            'badge' => 'nullable|string|max:100',
            'description' => 'nullable|string|max:255',
            'image_media_id' => 'nullable|integer',
            'target' => 'required|in:_self,_blank',
            'is_active' => 'nullable|boolean',
            'sort_order' => 'nullable|integer',
        ]);

        $validated['is_active'] = $request->boolean('is_active', true);
        $validated['sort_order'] = (int) ($validated['sort_order'] ?? 0);

        MenuItem::create($validated);
        $this->clearMenuCache();

        if ($request->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Thêm mục menu thành công!',
            ]);
        }

        return redirect()->route('admin.menus.index', ['tab' => 'navigation'])
            ->with('success', 'Đã thêm mục menu mới!');
    }

    /**
     * Cập nhật một mục menu điều hướng.
     */
    public function updateMenuItem(Request $request, int $id): JsonResponse|RedirectResponse
    {
        $item = MenuItem::findOrFail($id);

        $validated = $request->validate([
            'label' => 'required|string|max:150',
            'url' => 'nullable|string|max:2000',
            'route_name' => 'nullable|string|max:150',
            'badge' => 'nullable|string|max:100',
            'description' => 'nullable|string|max:255',
            'image_media_id' => 'nullable|integer',
            'target' => 'required|in:_self,_blank',
            'is_active' => 'nullable|boolean',
            'sort_order' => 'nullable|integer',
        ]);

        $validated['is_active'] = $request->boolean('is_active', false);
        $validated['sort_order'] = (int) ($validated['sort_order'] ?? 0);

        $item->update($validated);
        $this->clearMenuCache();

        if ($request->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Cập nhật mục menu thành công!',
            ]);
        }

        return redirect()->route('admin.menus.index', ['tab' => 'navigation'])
            ->with('success', 'Đã cập nhật mục menu thành công!');
    }

    /**
     * Xóa một mục menu điều hướng.
     */
    public function destroyMenuItem(int $id): JsonResponse|RedirectResponse
    {
        $item = MenuItem::findOrFail($id);
        $item->delete();

        $this->clearMenuCache();

        if (request()->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Đã xóa mục menu thành công!',
            ]);
        }

        return redirect()->route('admin.menus.index', ['tab' => 'navigation'])
            ->with('success', 'Đã xóa mục menu thành công!');
    }

    /**
     * Xóa cache menu để frontend cập nhật tức thì.
     */
    protected function clearMenuCache(): void
    {
        Cache::forget('header_menu_cars');
        Cache::forget('header_menu_items');
        Artisan::call('view:clear');
    }
}
