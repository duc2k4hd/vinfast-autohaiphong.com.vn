<?php

namespace App\Services\Shared;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class SeoService
{
    /**
     * Tự động sinh slug duy nhất, chuẩn tiếng Việt không dấu.
     */
    public static function generateUniqueSlug(string $title, string $table, ?int $ignoreId = null, string $column = 'slug'): string
    {
        $baseSlug = Str::slug($title);
        if (empty($baseSlug)) {
            $baseSlug = 'bai-viet-'.time();
        }

        $slug = $baseSlug;
        $counter = 1;

        while (true) {
            $query = DB::table($table)->where($column, $slug);
            if ($ignoreId !== null) {
                $query->where('id', '!=', $ignoreId);
            }

            if (! $query->exists()) {
                break;
            }

            $slug = $baseSlug.'-'.$counter;
            $counter++;
        }

        return $slug;
    }

    /**
     * Trích xuất tóm tắt ngắn từ nội dung HTML sạch.
     */
    public static function generateExcerpt(string $content, int $limit = 160): string
    {
        $plainText = strip_tags($content);
        $cleanText = preg_replace('/\s+/', ' ', trim($plainText));

        return Str::limit($cleanText, $limit, '...');
    }

    /**
     * Đếm số từ thực tế của nội dung văn bản.
     */
    public static function countWords(string $content): int
    {
        $plainText = strip_tags($content);
        $cleanText = trim(preg_replace('/\s+/', ' ', $plainText));

        if (empty($cleanText)) {
            return 0;
        }

        // Tách từ hỗ trợ tiếng Việt có dấu
        $words = preg_split('/[^\p{L}\p{N}]+/u', $cleanText, -1, PREG_SPLIT_NO_EMPTY);

        return is_array($words) ? count($words) : 0;
    }

    /**
     * Ước tính thời gian đọc (phút) dựa trên tốc độ đọc trung bình 250 từ/phút.
     */
    public static function calculateReadingTime(string $content, int $wordsPerMinute = 250): int
    {
        $words = self::countWords($content);

        return max(1, (int) ceil($words / max(1, $wordsPerMinute)));
    }

    /**
     * Đánh giá điểm SEO toàn diện và đưa ra các gợi ý tối ưu.
     *
     * @return array{score: int, status: string, word_count: int, reading_time: int, keyword_density: float, issues: array<string>, good_points: array<string>}
     */
    public static function evaluateSeoScore(
        string $title,
        ?string $metaTitle,
        ?string $metaDescription,
        string $content,
        ?string $focusKeyword = null
    ): array {
        $score = 0;
        $issues = [];
        $goodPoints = [];

        $titleLen = mb_strlen(trim($title));
        $metaTitleLen = mb_strlen(trim($metaTitle ?? ''));
        $metaDescLen = mb_strlen(trim($metaDescription ?? ''));
        $wordCount = self::countWords($content);
        $readingTime = self::calculateReadingTime($content);

        // 1. Kiểm tra Tiêu đề chính
        if ($titleLen >= 30 && $titleLen <= 70) {
            $score += 20;
            $goodPoints[] = "Tiêu đề chính có độ dài chuẩn ($titleLen ký tự).";
        } elseif ($titleLen > 70) {
            $score += 10;
            $issues[] = "Tiêu đề hơi dài ($titleLen ký tự), nên rút ngắn dưới 70 ký tự.";
        } else {
            $issues[] = "Tiêu đề quá ngắn ($titleLen ký tự), nên đặt từ 30 - 70 ký tự.";
        }

        // 2. Kiểm tra Meta Title
        if ($metaTitleLen >= 40 && $metaTitleLen <= 65) {
            $score += 15;
            $goodPoints[] = "Thẻ Meta Title tối ưu hiển thị Google ($metaTitleLen ký tự).";
        } elseif ($metaTitleLen === 0) {
            $issues[] = 'Chưa thiết lập Meta Title riêng cho SEO.';
        } else {
            $score += 8;
            $issues[] = "Meta Title ($metaTitleLen ký tự) nên điều chỉnh trong khoảng 40 - 65 ký tự.";
        }

        // 3. Kiểm tra Meta Description
        if ($metaDescLen >= 120 && $metaDescLen <= 165) {
            $score += 20;
            $goodPoints[] = "Thẻ Meta Description tối ưu chuẩn SEO ($metaDescLen ký tự).";
        } elseif ($metaDescLen === 0) {
            $issues[] = 'Chưa nhập mô tả Meta Description.';
        } elseif ($metaDescLen < 120) {
            $score += 8;
            $issues[] = "Meta Description còn ngắn ($metaDescLen ký tự), nên bổ sung lên 120 - 160 ký tự.";
        } else {
            $score += 10;
            $issues[] = "Meta Description hơi dài ($metaDescLen ký tự), Google có thể cắt bớt khi hiển thị.";
        }

        // 4. Kiểm tra độ dài nội dung
        if ($wordCount >= 600) {
            $score += 20;
            $goodPoints[] = "Nội dung bài viết phong phú ($wordCount từ, đọc khoảng $readingTime phút).";
        } elseif ($wordCount >= 300) {
            $score += 12;
            $goodPoints[] = "Độ dài nội dung đạt mức tiêu chuẩn ($wordCount từ).";
        } else {
            $issues[] = "Nội dung khá ngắn ($wordCount từ), khuyến nghị viết tối thiểu 300 - 600 từ.";
        }

        // 5. Kiểm tra từ khóa trọng tâm (Focus Keyword)
        $cleanKeyword = trim($focusKeyword ?? '');
        $density = 0.0;

        if (! empty($cleanKeyword)) {
            $kwLower = mb_strtolower($cleanKeyword);
            $titleLower = mb_strtolower($title);
            $descLower = mb_strtolower($metaDescription ?? '');
            $plainTextLower = mb_strtolower(strip_tags($content));

            // Xuất hiện trong tiêu đề
            if (str_contains($titleLower, $kwLower)) {
                $score += 10;
                $goodPoints[] = "Từ khóa chính '$cleanKeyword' đã xuất hiện trong tiêu đề bài viết.";
            } else {
                $issues[] = "Nên đưa từ khóa chính '$cleanKeyword' vào tiêu đề bài viết.";
            }

            // Xuất hiện trong mô tả
            if (str_contains($descLower, $kwLower)) {
                $score += 5;
                $goodPoints[] = 'Từ khóa chính xuất hiện trong đoạn mô tả Meta Description.';
            } else {
                $issues[] = 'Từ khóa chính chưa có trong thẻ Meta Description.';
            }

            // Tính mật độ từ khóa
            if ($wordCount > 0) {
                $occurrences = mb_substr_count($plainTextLower, $kwLower);
                $kwWords = count(explode(' ', $cleanKeyword));
                $density = round(($occurrences * $kwWords / $wordCount) * 100, 2);

                if ($density >= 0.8 && $density <= 2.5) {
                    $score += 10;
                    $goodPoints[] = "Mật độ từ khóa đạt chuẩn tự nhiên ({$density}%).";
                } elseif ($density > 2.5) {
                    $score += 5;
                    $issues[] = "Mật độ từ khóa hơi cao ({$density}%), tránh nhồi nhét từ khóa quá mức.";
                } elseif ($occurrences > 0) {
                    $score += 5;
                    $issues[] = "Mật độ từ khóa còn thấp ({$density}%), có thể nhắc lại từ khóa một cách tự nhiên.";
                } else {
                    $issues[] = 'Từ khóa chính chưa xuất hiện trong thân bài viết.';
                }
            }
        } else {
            // Nếu không nhập focus keyword, phân bổ lại điểm cơ bản
            $score = (int) round(($score / 75) * 100);
        }

        $finalScore = min(100, max(0, $score));

        $status = match (true) {
            $finalScore >= 80 => 'tốt',
            $finalScore >= 50 => 'cần_cải_thiện',
            default => 'kém',
        };

        return [
            'score' => $finalScore,
            'status' => $status,
            'word_count' => $wordCount,
            'reading_time' => $readingTime,
            'keyword_density' => $density,
            'issues' => $issues,
            'good_points' => $goodPoints,
        ];
    }
}
