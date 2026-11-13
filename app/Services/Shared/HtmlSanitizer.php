<?php

namespace App\Services\Shared;

class HtmlSanitizer
{
    /**
     * Danh sách các thẻ cấm tuyệt đối.
     */
    protected static array $forbiddenTags = [
        'script',
        'iframe',
        'object',
        'embed',
        'applet',
        'meta',
        'form',
        'input',
        'button',
        'textarea',
        'select',
    ];

    /**
     * Làm sạch chuỗi HTML trước khi lưu vào database.
     */
    public static function clean(?string $html): string
    {
        if (empty($html)) {
            return '';
        }

        // 1. Loại bỏ các thẻ độc hại và nội dung bên trong của chúng
        foreach (self::$forbiddenTags as $tag) {
            $html = preg_replace('#<'.$tag.'\b[^>]*>(.*?)</'.$tag.'>#is', '', $html);
            $html = preg_replace('#<'.$tag.'\b[^>]*/>#is', '', $html);
            $html = preg_replace('#<'.$tag.'\b[^>]*>#is', '', $html);
        }

        // 2. Loại bỏ các thuộc tính bắt đầu bằng on* (event handlers như onclick, onerror, onload...)
        $html = preg_replace('/(\s+)on[a-z]+\s*=\s*(["\'][^"\']*["\']|[^\s>]+)/i', '', $html);

        // 3. Loại bỏ giao thức javascript: trong href hoặc src
        $html = preg_replace('/(href|src)\s*=\s*(["\'])\s*javascript:[^"\']*(\2)/i', '$1="#"', $html);

        // 4. Loại bỏ style chứa expression hoặc behavior
        $html = preg_replace('/style\s*=\s*(["\'])[^"\']*(expression|behavior)[^"\']*(\1)/i', '', $html);

        return trim($html);
    }
}
