<?php

namespace App\Services\Shared;

class CurrencyHelper
{
    /**
     * Chuyển đổi số tiền VNĐ thành văn bản chữ tiếng Việt chuẩn hóa.
     */
    public static function toVietnameseWords(int|float $number): string
    {
        $number = (int) $number;
        if ($number === 0) {
            return 'Không đồng';
        }

        $units = ['', ' nghìn', ' triệu', ' tỷ', ' nghìn tỷ', ' triệu tỷ'];
        $digits = ['không', 'một', 'hai', 'ba', 'bốn', 'năm', 'sáu', 'bảy', 'tám', 'chín'];

        $result = '';
        $i = 0;

        while ($number > 0) {
            $chunk = $number % 1000;
            if ($chunk > 0) {
                $chunkWords = self::readThreeDigits($chunk, $digits, $number >= 1000);
                $result = $chunkWords.$units[$i].($result ? ' '.$result : '');
            }
            $number = (int) ($number / 1000);
            $i++;
        }

        $result = trim($result).' đồng chẵn';

        return mb_strtoupper(mb_substr($result, 0, 1)).mb_substr($result, 1);
    }

    private static function readThreeDigits(int $num, array $digits, bool $hasHigher): string
    {
        $hundreds = (int) ($num / 100);
        $remainder = $num % 100;
        $tens = (int) ($remainder / 10);
        $ones = $remainder % 10;

        $words = [];

        if ($hundreds > 0 || $hasHigher) {
            $words[] = $digits[$hundreds].' trăm';
        }

        if ($tens > 1) {
            $words[] = $digits[$tens].' mươi';
            if ($ones === 1) {
                $words[] = 'mốt';
            } elseif ($ones === 5) {
                $words[] = 'lăm';
            } elseif ($ones > 0) {
                $words[] = $digits[$ones];
            }
        } elseif ($tens === 1) {
            $words[] = 'mười';
            if ($ones === 5) {
                $words[] = 'lăm';
            } elseif ($ones > 0) {
                $words[] = $digits[$ones];
            }
        } elseif ($tens === 0 && $ones > 0) {
            if ($hundreds > 0 || $hasHigher) {
                $words[] = 'lẻ';
            }
            $words[] = $digits[$ones];
        }

        return implode(' ', $words);
    }
}
