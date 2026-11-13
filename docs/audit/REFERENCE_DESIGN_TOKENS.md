# Hệ Thống Thiết Kế & Tokens Giao Diện (Reference Design Tokens) — vinfast-haiphong.com

## 1. Màu Sắc (Color Palette)

```css
:root {
    /* Họ Font duy nhất toàn hệ thống */
    --client-font-family: "Open Sans", -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif;

    /* Màu thương hiệu VinFast */
    --client-color-primary: #1464f4;       /* Xanh dương VinFast chủ đạo */
    --client-color-primary-hover: #0c4ec5; /* Hover xanh đậm */
    --client-color-secondary: #2196f3;     /* Xanh dương tươi */
    --client-color-accent: #dd3333;        /* Đỏ ưu đãi / Giá sốc / Badge */
    --client-color-accent-hover: #c31d1d;
    --client-color-success: #36a834;       /* Xanh lá biểu tượng sạc / dịch vụ xanh */

    /* Màu văn bản & nền */
    --client-color-text: #32373c;          /* Văn bản chính */
    --client-color-heading: #1e293b;       /* Tiêu đề H1-H6 */
    --client-color-muted: #64748b;         /* Văn bản phụ, ngày tháng, chú thích */
    --client-color-border: #e2e8f0;        /* Đường kẻ phân cách */
    --client-color-background: #ffffff;    /* Nền trắng */
    --client-color-surface: #f8fafc;       /* Nền khối xám nhẹ */

    /* Kích thước bố cục */
    --client-container-width: 1240px;      /* Chiều rộng container chính */
    --client-header-height: 80px;          /* Chiều cao header desktop */
    --client-header-mobile-height: 60px;   /* Chiều cao header mobile */

    /* Bo góc (Border Radius) */
    --client-radius-xs: 4px;
    --client-radius-sm: 6px;
    --client-radius-md: 8px;
    --client-radius-lg: 12px;
    --client-radius-full: 9999px;

    /* Bóng đổ (Box Shadow) */
    --client-shadow-sm: 0 1px 2px 0 rgba(0, 0, 0, 0.05);
    --client-shadow-md: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -2px rgba(0, 0, 0, 0.1);
    --client-shadow-lg: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -4px rgba(0, 0, 0, 0.1);

    /* Khoảng cách (Spacing) */
    --client-space-1: 4px;
    --client-space-2: 8px;
    --client-space-3: 12px;
    --client-space-4: 16px;
    --client-space-6: 24px;
    --client-space-8: 32px;
    --client-space-12: 48px;
    --client-space-16: 64px;
}
```

## 2. Typography Cốt Lõi (Open Sans)
- **Display / Hero Headline:** 36px - 44px (Desktop) / 28px - 32px (Mobile), Font weight: 700 - 800.
- **H1:** 30px - 34px (Desktop) / 24px - 26px (Mobile), Font weight: 700.
- **H2:** 24px - 28px (Desktop) / 20px - 22px (Mobile), Font weight: 600 - 700.
- **H3:** 20px - 22px (Desktop) / 18px (Mobile), Font weight: 600.
- **Body Large:** 18px, Line-height: 1.6, Font weight: 400.
- **Body Normal:** 15px - 16px, Line-height: 1.6, Font weight: 400.
- **Price Large:** 20px - 24px, Font weight: 700, Color: `--client-color-accent` (#dd3333).
- **CTA Button:** 14px - 15px, Font weight: 600, Text transform: Uppercase, Letter-spacing: 0.5px.

## 3. Responsive Breakpoints
```text
xs: 360px - 480px (Điện thoại nhỏ)
sm: 640px (Điện thoại lớn / Tablet đứng nhỏ)
md: 768px (Tablet đứng)
lg: 1024px (Tablet ngang / Laptop nhỏ)
xl: 1280px (Màn hình Desktop chuẩn)
2xl: 1440px - 1920px (Desktop lớn)
```
