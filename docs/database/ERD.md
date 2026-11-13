# Entity-Relationship Diagram (ERD) — VinFast Hải Phòng

## Sơ đồ quan hệ tổng quan

```mermaid
erDiagram
    users ||--o{ role_user : has
    roles ||--o{ role_user : belongs_to
    
    product_categories ||--o{ products : contains
    product_categories ||--o{ product_categories : parent_of
    
    products ||--o{ product_variants : has
    products ||--o{ product_specifications : has
    product_specification_groups ||--o{ product_specifications : groups
    
    media ||--o{ media_usages : references
    media_folders ||--o{ media : categorizes
    media_folders ||--o{ media_folders : parent_of
    
    post_categories ||--o{ post_category_relations : belongs_to
    posts ||--o{ post_category_relations : has
    tags ||--o{ post_tags : belongs_to
    posts ||--o{ post_tags : has
    
    menus ||--o{ menu_items : contains
    menu_items ||--o{ menu_items : parent_of
    
    carts ||--o{ cart_items : contains
    products ||--o{ cart_items : added_to
    product_variants ||--o{ cart_items : chosen_for
    
    orders ||--o{ order_items : contains
    orders ||--o{ order_status_histories : tracks
    orders ||--o{ payment_records : logs
    
    consent_records ||--o{ leads : authorizes
    products ||--o{ leads : interested_in
    leads ||--o{ lead_status_histories : tracks
    
    import_batches ||--o{ import_items : contains
```

## Các quan hệ chính
1. **Catalog:**
   - `product_categories` 1 - N `products`
   - `products` 1 - N `product_variants`
   - `products` 1 - N `product_specifications`
   - `product_specification_groups` 1 - N `product_specifications`
2. **Media:**
   - `media` 1 - N `media_usages` (quan hệ đa hình polymorphic theo `usable_type` và `usable_id`)
   - `media_folders` 1 - N `media`
3. **Content & Blog:**
   - `posts` N - N `post_categories` (qua `post_category_relations`)
   - `posts` N - N `tags` (qua `post_tags`)
4. **Commerce:**
   - `orders` 1 - N `order_items` (snapshot tên, giá, phiên bản tại thời điểm đặt hàng)
   - `orders` 1 - N `order_status_histories`
   - `orders` 1 - N `payment_records` (chỉ ghi nhận dòng tiền mặt trực tiếp)
5. **CRM & Leads:**
   - `leads` N - 1 `products`
   - `leads` N - 1 `consent_records`
   - `leads` 1 - N `lead_status_histories`

