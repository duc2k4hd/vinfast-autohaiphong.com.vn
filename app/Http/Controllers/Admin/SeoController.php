<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\Shared\SeoService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class SeoController extends Controller
{
    /**
     * Phân tích thời gian thực điểm SEO và mật độ từ khóa cho nội dung.
     */
    public function analyze(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'title' => ['nullable', 'string', 'max:255'],
            'meta_title' => ['nullable', 'string', 'max:255'],
            'meta_description' => ['nullable', 'string', 'max:1000'],
            'content' => ['nullable', 'string'],
            'focus_keyword' => ['nullable', 'string', 'max:100'],
        ]);

        $title = $validated['title'] ?? '';
        $metaTitle = $validated['meta_title'] ?? null;
        $metaDescription = $validated['meta_description'] ?? null;
        $content = $validated['content'] ?? '';
        $focusKeyword = $validated['focus_keyword'] ?? null;

        $analysis = SeoService::evaluateSeoScore(
            title: $title,
            metaTitle: $metaTitle,
            metaDescription: $metaDescription,
            content: $content,
            focusKeyword: $focusKeyword
        );

        return response()->json([
            'success' => true,
            'data' => $analysis,
        ]);
    }
}

