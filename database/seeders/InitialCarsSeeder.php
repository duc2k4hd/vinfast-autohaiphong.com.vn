<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class InitialCarsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $now = now();

        // 1. Tạo 2 danh mục chính
        $catPassengerId = DB::table('product_categories')->updateOrInsert(
            ['slug' => 'o-to-dien-du-lich'],
            [
                'name' => 'Ô Tô Điện Du Lịch',
                'description' => 'Các dòng xe ô tô điện cá nhân và gia đình thông minh của VinFast',
                'status' => 'active',
                'sort_order' => 1,
                'created_at' => $now,
                'updated_at' => $now,
            ]
        );
        $catPassengerId = DB::table('product_categories')->where('slug', 'o-to-dien-du-lich')->value('id');

        $catCommercialId = DB::table('product_categories')->updateOrInsert(
            ['slug' => 'xe-dich-vu-xanh'],
            [
                'name' => 'Xe Dịch Vụ & Vận Tải Xanh',
                'description' => 'Giải pháp phương tiện thuần điện tối ưu chi phí vận hành cho doanh nghiệp và dịch vụ',
                'status' => 'active',
                'sort_order' => 2,
                'created_at' => $now,
                'updated_at' => $now,
            ]
        );
        $catCommercialId = DB::table('product_categories')->where('slug', 'xe-dich-vu-xanh')->value('id');

        // 2. Danh sách 15 mẫu xe theo kiểm kê
        $cars = [
            [
                'category_id' => $catPassengerId,
                'name' => 'VinFast VF 2',
                'slug' => 'vinfast-vf-2',
                'sku' => 'VF2-STD',
                'regular_price' => 188000000,
                'sale_price' => 188000000,
                'price_on_request' => false,
                'short_description' => 'Mẫu xe đô thị cỡ nhỏ thông minh, phong cách trẻ trung và linh hoạt.',
                'description_html' => $this->getVf2DescriptionHtml(),
                'sort_order' => 1,
                'featured' => false,
            ],
            [
                'category_id' => $catPassengerId,
                'name' => 'VinFast VF 3',
                'slug' => 'vinfast-vf-3',
                'sku' => 'VF3-STD',
                'regular_price' => 285000000,
                'sale_price' => 285000000,
                'price_on_request' => false,
                'short_description' => 'Mẫu mini-eSUV quốc dân phá cách, mạnh mẽ và tiện nghi cho mọi hành trình.',
                'sort_order' => 2,
                'featured' => true,
            ],
            [
                'category_id' => $catPassengerId,
                'name' => 'VinFast VF 5 Plus',
                'slug' => 'vinfast-vf-5',
                'sku' => 'VF5-PLS',
                'regular_price' => 468000000,
                'sale_price' => 468000000,
                'price_on_request' => false,
                'short_description' => 'Mẫu SUV hạng A thông minh, tối ưu cho gia đình trẻ tại Hải Phòng.',
                'sort_order' => 3,
                'featured' => true,
            ],
            [
                'category_id' => $catPassengerId,
                'name' => 'VinFast VF 6',
                'slug' => 'vinfast-vf-6',
                'sku' => 'VF6-STD',
                'regular_price' => 675000000,
                'sale_price' => 675000000,
                'price_on_request' => false,
                'short_description' => 'Tuyệt tác SUV điện hạng B với thiết kế châu Âu thanh lịch và công nghệ vượt trội.',
                'sort_order' => 4,
                'featured' => true,
            ],
            [
                'category_id' => $catPassengerId,
                'name' => 'VinFast VF 7',
                'slug' => 'vinfast-vf-7',
                'sku' => 'VF7-STD',
                'regular_price' => 850000000,
                'sale_price' => 850000000,
                'price_on_request' => false,
                'short_description' => 'Mẫu SUV điện hạng C phong cách phi thuyền tương lai, cảm giác lái đỉnh cao.',
                'sort_order' => 5,
                'featured' => true,
            ],
            [
                'category_id' => $catPassengerId,
                'name' => 'VinFast VF 8',
                'slug' => 'vinfast-vf-8',
                'sku' => 'VF8-STD',
                'regular_price' => 1079000000,
                'sale_price' => 1079000000,
                'price_on_request' => false,
                'short_description' => 'Mẫu SUV điện cỡ trung chuẩn toàn cầu với công nghệ trợ lái thông minh ADAS.',
                'sort_order' => 6,
                'featured' => true,
            ],
            [
                'category_id' => $catPassengerId,
                'name' => 'VinFast VF 8 All New',
                'slug' => 'vinfast-vf8-all-new',
                'sku' => 'VF8-NEW',
                'regular_price' => 1129000000,
                'sale_price' => 1129000000,
                'price_on_request' => false,
                'short_description' => 'Phiên bản cải tiến toàn diện của mẫu SUV D-class sang trọng, êm ái hàng đầu.',
                'sort_order' => 7,
                'featured' => true,
            ],
            [
                'category_id' => $catPassengerId,
                'name' => 'VinFast VF 9',
                'slug' => 'vinfast-vf-9',
                'sku' => 'VF9-STD',
                'regular_price' => 1566000000,
                'sale_price' => 1566000000,
                'price_on_request' => false,
                'short_description' => 'Mẫu SUV điện hạng E đầu bảng 7 chỗ hoặc ghế cơ trưởng VIP sang trọng đẳng cấp.',
                'sort_order' => 8,
                'featured' => true,
            ],
            [
                'category_id' => $catPassengerId,
                'name' => 'VinFast VF Wild',
                'slug' => 'vinfast-vf-wild',
                'sku' => 'WILD-PUP',
                'regular_price' => 0,
                'sale_price' => 0,
                'price_on_request' => true,
                'short_description' => 'Mẫu bán tải điện thông minh thế hệ mới, mở lối phong cách sống tự do.',
                'sort_order' => 9,
                'featured' => true,
            ],
            [
                'category_id' => $catPassengerId,
                'name' => 'VinFast VF MPV 7',
                'slug' => 'vinfast-vf-mpv-7',
                'sku' => 'MPV7-ELEC',
                'regular_price' => 790000000,
                'sale_price' => 790000000,
                'price_on_request' => false,
                'short_description' => 'Xe đa dụng 7 chỗ thuần điện rộng rãi, tiết kiệm chi phí tối đa cho gia đình.',
                'sort_order' => 10,
                'featured' => false,
            ],
            [
                'category_id' => $catCommercialId,
                'name' => 'VinFast Minio Green',
                'slug' => 'vinfast-minio-green',
                'sku' => 'MINIO-GRN',
                'regular_price' => 239000000,
                'sale_price' => 239000000,
                'price_on_request' => false,
                'short_description' => 'Dòng xe siêu nhỏ gọn chuyên phục vụ giao hàng và dịch vụ đô thị không phát thải.',
                'sort_order' => 11,
                'featured' => false,
            ],
            [
                'category_id' => $catCommercialId,
                'name' => 'VinFast Herio Green',
                'slug' => 'vinfast-herio-green',
                'sku' => 'HERIO-GRN',
                'regular_price' => 450000000,
                'sale_price' => 450000000,
                'price_on_request' => false,
                'short_description' => 'Dòng xe kinh doanh dịch vụ bền bỉ, chi phí bảo dưỡng gần như bằng 0.',
                'sort_order' => 12,
                'featured' => false,
            ],
            [
                'category_id' => $catCommercialId,
                'name' => 'VinFast Nerio Green',
                'slug' => 'vinfast-nerio-green',
                'sku' => 'NERIO-GRN',
                'regular_price' => 628000000,
                'sale_price' => 628000000,
                'price_on_request' => false,
                'short_description' => 'Dòng sedan xanh chuyên nghiệp cho đội xe dịch vụ công nghệ và đưa đón cao cấp.',
                'sort_order' => 13,
                'featured' => false,
            ],
            [
                'category_id' => $catCommercialId,
                'name' => 'VinFast Limo Green',
                'slug' => 'vinfast-limo-green',
                'sku' => 'LIMO-GRN',
                'regular_price' => 699000000,
                'sale_price' => 699000000,
                'price_on_request' => false,
                'short_description' => 'Giải pháp vận tải hành khách VIP cao cấp thuần điện tiêu chuẩn 5 sao.',
                'sort_order' => 14,
                'featured' => false,
            ],
            [
                'category_id' => $catCommercialId,
                'name' => 'VinFast EC Van',
                'slug' => 'vinfast-ec-van',
                'sku' => 'EC-VAN',
                'regular_price' => 268000000,
                'sale_price' => 268000000,
                'price_on_request' => false,
                'short_description' => 'Xe van tải hàng thuần điện đô thị không lo cấm giờ, thể tích thùng hàng lớn.',
                'sort_order' => 15,
                'featured' => false,
            ],
        ];

        foreach ($cars as $car) {
            $relPath = 'clients/assets/images/products/'.$car['slug'].'.webp';

            // Tìm hoặc tạo media record cho xe
            $mediaId = DB::table('media')->where('path', $relPath)->value('id');
            if (! $mediaId) {
                $mediaId = DB::table('media')->insertGetId([
                    'uuid' => (string) Str::uuid(),
                    'folder_id' => null,
                    'disk' => 'public',
                    'filename' => $car['slug'].'.webp',
                    'original_filename' => $car['slug'].'.webp',
                    'extension' => 'webp',
                    'path' => $relPath,
                    'mime_type' => 'image/webp',
                    'file_size' => 25000,
                    'alt_text' => $car['name'].' tại VinFast Hải Phòng',
                    'created_at' => $now,
                    'updated_at' => $now,
                ]);
            }

            $relPath = 'clients/assets/images/products/'.$car['slug'].'.webp';

            // Tìm hoặc tạo media record cho xe
            $mediaId = DB::table('media')->where('path', $relPath)->value('id');
            if (! $mediaId) {
                $mediaId = DB::table('media')->insertGetId([
                    'uuid' => (string) Str::uuid(),
                    'folder_id' => null,
                    'disk' => 'public',
                    'filename' => $car['slug'].'.webp',
                    'original_filename' => $car['slug'].'.webp',
                    'extension' => 'webp',
                    'path' => $relPath,
                    'mime_type' => 'image/webp',
                    'file_size' => 25000,
                    'alt_text' => $car['name'].' tại VinFast Hải Phòng',
                    'created_at' => $now,
                    'updated_at' => $now,
                ]);
            }

            DB::table('products')->updateOrInsert(
                ['slug' => $car['slug']],
                array_merge($car, [
                    'thumbnail_media_id' => $mediaId,
                    'status' => 'published',
                    'published_at' => $now,
                    'created_at' => $now,
                    'updated_at' => $now,
                ])
            );
        }
    }

    /**
     * Nội dung bài viết chi tiết xe VinFast VF 2.
     */
    private function getVf2DescriptionHtml(): string
    {
        return <<<'HTML'
<section id="vf2-gioi-thieu">
    <h2>VinFast VF 2 tại Hải Phòng: ô tô điện nhỏ gọn, vừa nhu cầu đi phố</h2>
    <p>Buổi sáng đi làm, chiều đón con, cuối tuần ghé siêu thị: nếu phần lớn thời gian dùng xe của bạn là những chuyến đi như vậy, <strong>VinFast VF 2</strong> là mẫu ô tô điện đáng tìm hiểu. Xe có hai cửa bên hông, bốn chỗ ngồi và chiều dài chỉ 3,09 m. Thân xe gọn giúp người mới lái dễ hình dung khoảng không gian khi đi vào phố nhỏ hay tìm chỗ đỗ.</p>
    <p>VF 2 không cố trở thành chiếc xe có thật nhiều trang bị. Điều hãng tập trung là những thứ dùng hằng ngày: điều hòa, khoang ngồi bốn chỗ, hệ truyền động điện, màn hình thông tin lái và các hệ thống phanh hỗ trợ cơ bản. Nhưng trước khi chọn, có bốn điều nên xem kỹ: <strong>giá lăn bánh, cách ra vào ghế sau, quãng đường thực tế và điều kiện sạc pin</strong>.</p>
    <figure class="vf2-photo">
      <img src="/storage/clients/assets/images/products/vf2/hinh-anh-vinfast-vf2-hero-banner-new-desktop.webp" width="1000" height="417" alt="VinFast VF 2 màu be đi trên đường ven hồ, góc nhìn trước ba phần tư" fetchpriority="high" decoding="async">
      <figcaption>VF 2 màu be trong hình ảnh giới thiệu chính thức. Ảnh: VinFast.</figcaption>
    </figure>
    <p class="vf2-facts"><strong>Thông tin nhanh:</strong> Giá niêm yết 188 triệu đồng (gồm pin) · 4 chỗ ngồi · pin khả dụng 18,3 kWh · 210 km/lần sạc theo NEDC · sạc nhanh 10–70% khoảng 34 phút · dẫn động cầu sau.</p>
</section>

<section id="vf2-gia-ban">
    <h2>Giá VinFast VF 2: 188 triệu đồng đã bao gồm pin</h2>
    <p>VinFast công bố <strong>giá niêm yết VF 2 là 188.000.000 đồng, đã gồm pin</strong>. Đây là giá xe, không phải số tiền lăn bánh cuối cùng tại Hải Phòng. Khi làm thủ tục đăng ký, số tiền thực trả còn phụ thuộc các khoản thuế, phí, bảo hiểm bạn lựa chọn và chương trình ưu đãi đang còn hiệu lực.</p>
    <p>Trên một số trang của hãng có thể xuất hiện giá ưu đãi khác giá niêm yết kèm điều kiện áp dụng. Vì vậy, khi nhận báo giá, hãy hỏi rõ <strong>giá xe sau ưu đãi, các khoản phí đăng ký, phụ kiện đi kèm và thời gian giao xe</strong>. Đừng lấy một mức giá quảng cáo để mặc định đó là tổng số tiền phải trả.</p>
    <figure class="vf2-photo">
      <img src="/storage/clients/assets/images/products/vf2/vinfast-vf2-ngoai-that-mau-vang-be-goc-truoc-3-4-desktop.webp" width="1000" height="750" alt="VinFast VF 2 màu be chụp cận cảnh từ góc ba phần tư trước" loading="lazy" decoding="async">
      <figcaption>Đầu xe VF 2 có cụm đèn tròn và mảng cản tối màu. Ảnh: VinFast.</figcaption>
    </figure>
    <p><strong>Lời khuyên từ VinFast Hải Phòng:</strong> hãy xin bảng dự toán lăn bánh bằng văn bản theo thời điểm mua và thông tin đăng ký của bạn. Nếu mua trả góp, cần xem riêng tiền trả trước, lãi suất thực tế, phí bảo hiểm theo yêu cầu ngân hàng và lịch thanh toán.</p>
</section>

<section id="vf2-thiet-ke">
    <h2>Ngoại thất VF 2: hai cửa, dáng cao, đèn trước LED</h2>
    <p>VF 2 dài <strong>3.090 mm</strong>, rộng <strong>1.496 mm</strong> và cao <strong>1.663,2 mm</strong>. Trục cơ sở 2.065 mm, khoảng sáng gầm không tải 166,3 mm. Tỷ lệ thân xe ngắn nhưng dáng mui cao tạo nên một kiểu xe rất dễ nhận ra. Đầu xe có cụm đèn trước dạng tròn với công nghệ LED, còn đèn hậu là loại halogen theo brochure.</p>
    <p>Xe dùng la-zăng 13 inch và gương chiếu hậu ngoài chỉnh cơ. Những chi tiết này cho thấy VF 2 ưu tiên tính cơ bản và mức giá tiếp cận, thay vì nhiều trang bị điện tử. Người mua nên kiểm tra tận mắt thao tác chỉnh gương, đèn, gạt mưa và tầm quan sát khi ngồi ghế lái.</p>
    <figure class="vf2-photo">
      <img src="/storage/clients/assets/images/products/vf2/hinh-anh-vinfast-vf2-exterior-slider-2-desktop.webp" width="1000" height="563" alt="VinFast VF 2 màu đỏ trên đường phố, nhìn chếch phía trước" loading="lazy" decoding="async">
      <figcaption>Đầu xe bo tròn với đèn LED phía trước. Ảnh: VinFast.</figcaption>
    </figure>
    <figure class="vf2-photo">
      <img src="/storage/clients/assets/images/products/vf2/hinh-anh-vinfast-vf2-exterior-slider-3-desktop.webp" width="1000" height="563" alt="VinFast VF 2 màu trắng trên đường nội đô" loading="lazy" decoding="async">
      <figcaption>Thân xe ngắn và chiều rộng gần 1,5 m là nét đặc trưng của VF 2. Ảnh: VinFast.</figcaption>
    </figure>
    <h3>Hai cửa bên hông có bất tiện không?</h3>
    <p>Điểm này phụ thuộc cách bạn dùng xe. Nếu chủ yếu một hoặc hai người di chuyển, thiết kế hai cửa rất dễ chấp nhận. Nhưng khi cần đưa đón người lớn tuổi, đặt ghế trẻ em hoặc thường xuyên có người ngồi sau, việc lên xuống sẽ phải qua khu vực ghế trước. Hãy thử đúng tình huống của gia đình mình thay vì chỉ nhìn ảnh nội thất.</p>
    <figure class="vf2-photo">
      <img src="/storage/clients/assets/images/products/vf2/hinh-anh-vinfast-vf2-ngoai-that-mau-hong-hai-cua-desktop.webp" width="1000" height="750" alt="Hình chụp ngang VinFast VF 2 màu hồng, thân xe hai cửa" loading="lazy" decoding="async">
      <figcaption>Góc ngang thể hiện rõ hai cửa bên hông và hai hàng ghế. Ảnh: VinFast.</figcaption>
    </figure>
    <p>Bánh xe nhỏ và kích thước gọn không có nghĩa xe phù hợp đi qua mọi chỗ ngập hay mặt đường xấu. Tại Hải Phòng, hãy ưu tiên tuyến đường phù hợp, theo dõi tình trạng ngập và không suy đoán khả năng lội nước chỉ từ khoảng sáng gầm.</p>
    <figure class="vf2-photo">
      <img src="/storage/clients/assets/images/products/vf2/vinfast-vf2-ngoai-that-mau-xanh-mint-den-pha-canh-truoc-desktop.webp" width="1000" height="750" alt="Cận cảnh bánh xe 13 inch và đèn trước VinFast VF 2 màu xanh Urban Mint" loading="lazy" decoding="async">
      <figcaption>Đèn trước LED, bánh xe cỡ 13 inch; gương ngoài chỉnh cơ theo brochure. Ảnh: VinFast.</figcaption>
    </figure>
</section>

<section id="vf2-noi-that">
    <h2>Nội thất VinFast VF 2: trang bị vừa đủ, không rườm rà</h2>
    <p>Bên trong VF 2 là bố cục tối giản. Xe có <strong>màn hình thông tin lái 7 inch nằm phía sau vô lăng</strong>, điều hòa chỉnh cơ, ghế nỉ và ghế lái chỉnh cơ bốn hướng. Hệ thống âm thanh gồm hai loa với radio FM. Nên phân biệt rõ: màn hình 7 inch này là <strong>màn hình thông tin lái</strong>, không phải màn hình cảm ứng giải trí lớn ở giữa táp-lô.</p>
    <p>Khi xem xe, hãy thử các việc đơn giản: chỉnh khoảng cách ghế tới vô lăng, quan sát thông tin pin, chỉnh hướng gió, bật điều hòa và kiểm tra chỗ đặt đồ cá nhân. Đây là những thao tác lặp lại mỗi ngày, quan trọng hơn một danh sách tính năng dài nhưng ít sử dụng.</p>
    <figure class="vf2-photo">
      <img src="/storage/clients/assets/images/products/vf2/vinfast-vf2-noi-that-buong-lai-vo-lang-bang-dieu-khien-desktop.webp" width="1000" height="563" alt="Toàn cảnh cabin VinFast VF 2 với vô lăng, bảng táp-lô và hai ghế trước" loading="lazy" decoding="async">
      <figcaption>Nội thất VF 2 được bố trí đơn giản, các núm điều hòa nằm bên dưới bảng táp-lô. Ảnh: VinFast.</figcaption>
    </figure>
    <figure class="vf2-photo">
      <img src="/storage/clients/assets/images/products/vf2/hinh-anh-vinfast-vf2-interior-slider-detail-1-desktop.webp" width="1000" height="1000" alt="Cận cảnh vô lăng và màn hình thông tin 7 inch phía sau vô lăng VinFast VF 2" loading="lazy" decoding="async">
      <figcaption>Màn hình 7 inch là màn hình thông tin lái sau vô lăng, không phải màn hình giải trí trung tâm. Ảnh: VinFast.</figcaption>
    </figure>
    <h3>VF 2 có thực sự ngồi được bốn người?</h3>
    <p>Xe có <strong>bốn vị trí ngồi</strong>, gồm hai phía trước và hai phía sau. Bản thân số chỗ không nói lên việc bốn người lớn sẽ thoải mái trong mọi hành trình. Nếu gia đình thường đi đủ người, nên cho cả người ngồi sau thử chỗ để chân, khoảng trống đầu và thao tác ra vào xe.</p>
    <figure class="vf2-photo">
      <img src="/storage/clients/assets/images/products/vf2/vinfast-vf2-noi-that-khoan-cabin-4-ghe-nhin-tu-tren-2-desktop.webp" width="600" height="1000" alt="Bố trí bốn chỗ ngồi VinFast VF 2 nhìn từ trên xuống" loading="lazy" decoding="async">
      <figcaption>Sơ đồ cabin cho thấy rõ hai ghế trước và hai vị trí ngồi phía sau. Ảnh: VinFast.</figcaption>
    </figure>
    <figure class="vf2-photo">
      <img src="/storage/clients/assets/images/products/vf2/vinfast-vf2-noi-that-ghe-sau-vai-xam-phoi-vang-5-desktop.webp" width="1000" height="563" alt="Hàng ghế sau VinFast VF 2 bọc nỉ xám phối vàng" loading="lazy" decoding="async">
      <figcaption>Hàng ghế sau dành cho hai người; nên trải nghiệm trực tiếp cách ra vào. Ảnh: VinFast.</figcaption>
    </figure>
    <p>Brochure ghi nhận <strong>móc cố định ghế trẻ em ISOFIX</strong>. Gia đình có con nhỏ nên kiểm tra vị trí lắp thực tế và thử đúng mẫu ghế trẻ em đang sử dụng. Khoang hành lý cũng nên xem trực tiếp khi tới showroom trải nghiệm xe thực tế.</p>
    <figure class="vf2-photo">
      <img src="/storage/clients/assets/images/products/vf2/hinh-anh-vinfast-vf2-interior-slider-detail-3-desktop.webp" width="1000" height="563" alt="Chi tiết hộc để cốc và dây đai an toàn hàng ghế sau VF 2" loading="lazy" decoding="async">
      <figcaption>Ảnh cận cho thấy vật liệu ghế và khu vực để đồ cạnh hàng ghế sau. Ảnh: VinFast.</figcaption>
    </figure>
</section>

<section id="vf2-pin-sac">
    <h2>VF 2 đi được bao xa? Hiểu đúng pin 18,3 kWh và mốc 210 km</h2>
    <p>VinFast công bố VF 2 sử dụng bộ pin có <strong>dung lượng khả dụng 18,3 kWh</strong>, cho quãng đường <strong>tối đa 210 km theo chu trình NEDC</strong>. Đây là con số đo theo quy trình tiêu chuẩn, không phải lời đảm bảo xe sẽ đi đủ 210 km trong mọi hoàn cảnh.</p>
    <p>Quãng đường sử dụng thực tế sẽ thay đổi theo tốc độ, điều hòa, số người ngồi, địa hình, áp suất lốp, nhiệt độ và cách tăng giảm tốc. Trước khi chọn xe, bạn nên tính quãng đường đi làm trong ngày, vị trí điểm sạc dễ tiếp cận và nhu cầu đi xa mỗi tháng. Với người chủ yếu đi nội đô, cách tính này hữu ích hơn việc chỉ nhìn mốc 210 km.</p>
    <h3>Sạc nhanh khoảng 34 phút là từ 10% lên 70%, không phải sạc đầy</h3>
    <p>VF 2 hỗ trợ sạc nhanh DC với công suất tối đa được công bố <strong>24 kW</strong>. Trong điều kiện phù hợp, xe cần khoảng <strong>34 phút để nạp từ 10% lên 70%</strong>. Nếu sạc tiếp tới 100%, thời gian sẽ dài hơn; công suất thực nhận còn phụ thuộc trụ sạc, nhiệt độ và tình trạng pin.</p>
    <p>Đối với sạc tại nhà, cần làm rõ thiết bị sạc tương thích, nguồn điện, vị trí đỗ và chi phí lắp đặt. Không nên mặc định dây sạc hoặc bộ sạc tại nhà luôn được tặng kèm. Hãy yêu cầu tư vấn danh mục phụ kiện có trong báo giá và chỉ dùng giải pháp sạc phù hợp theo khuyến cáo của VinFast.</p>
    <figure class="vf2-photo">
      <img src="/storage/clients/assets/images/products/vf2/hinh-anh-vinfast-vf2-exterior-highlight-banner-desktop.webp" width="1000" height="563" alt="VinFast VF 2 màu trắng đi trên đường ven hồ" loading="lazy" decoding="async">
      <figcaption>Hình minh họa ngoại thất VF 2 màu trắng. Ảnh: VinFast.</figcaption>
    </figure>
</section>

<section id="vf2-van-hanh">
    <h2>Động cơ 30 kW, tốc độ tối đa 80 km/h: VF 2 sinh ra cho đường đô thị</h2>
    <p>VF 2 dùng một mô-tơ điện <strong>30 kW</strong>, mô-men xoắn cực đại <strong>65 Nm</strong>, dẫn động cầu sau, hai chế độ lái Eco và Normal. Tốc độ tối đa VinFast công bố là <strong>80 km/h</strong>. Đây là thông số cần cân nhắc nếu bạn thường xuyên đi những tuyến đường có lưu lượng nhanh hoặc cần di chuyển đường dài.</p>
    <p>Xe được công bố dùng hệ thống treo MacPherson ở cả trước và sau; phanh đĩa phía trước và phanh tang trống phía sau. Tuy vậy, chỉ từ thông số không thể kết luận xe êm hay cách âm tốt tới đâu. Muốn biết có hợp với bạn hay không, hãy đề nghị lái thử trên cả đoạn đường bằng và đoạn đường có gờ giảm tốc.</p>
    <figure class="vf2-photo">
      <img src="/storage/clients/assets/images/products/vf2/hinh-anh-vinfast-vf2-exterior-slider-5-desktop.webp" width="1000" height="563" alt="VinFast VF 2 màu xanh nhạt trước ngôi nhà ven biển" loading="lazy" decoding="async">
      <figcaption>Ảnh toàn xe giúp quan sát tỷ lệ thiết kế và dáng mui cao của VF 2. Ảnh: VinFast.</figcaption>
    </figure>
</section>

<section id="vf2-an-toan">
    <h2>Trang bị an toàn VF 2: cần đọc đủ, không suy diễn thêm</h2>
    <p>Danh mục an toàn được công bố gồm <strong>phanh ABS, phân phối lực phanh điện tử EBD, kiểm soát lực kéo TCS và một túi khí cho người lái</strong>. Một túi khí nghĩa là không nên hiểu nhầm xe có túi khí phía ghế phụ. Hãy đọc đúng cấu hình khi đối chiếu nhu cầu bảo vệ người ngồi trên xe.</p>
    <p>Các hệ thống phanh và kiểm soát lực kéo có thể hỗ trợ người lái trong những tình huống nhất định, nhưng không thay thế việc giữ tốc độ phù hợp, đeo dây an toàn, giữ khoảng cách và quan sát đường. Tài liệu được đối chiếu không đủ cơ sở để quảng cáo VF 2 có camera 360, hỗ trợ giữ làn hoặc các tính năng lái tự động, vì vậy bài này không gán thêm những trang bị đó.</p>
</section>

<section id="vf2-mau-sac">
    <h2>VF 2 có những màu gì?</h2>
    <p>VinFast công bố tám lựa chọn màu ngoại thất: <strong>trắng Infinity Blanc, đỏ Solar Ruby, bạc Desat Silver, xanh Urban Mint, vàng Summer Yellow, xanh Sky Blue, hồng Rose Pink và be Pebble Beige</strong>. Đây là bảng màu theo thông tin giới thiệu VF 2; lịch giao từng màu có thể khác nhau.</p>
    <p>Nếu phân vân giữa hai màu, hãy xem xe thật ở cả nơi có mái che lẫn ngoài trời. Màu sắc trên màn hình hoặc ảnh chỉnh sáng có thể khác lớp sơn thực tế. Với màu bạn yêu thích nhưng chưa có xe tại điểm bán, nên hỏi rõ thời điểm dự kiến giao trước khi đặt cọc.</p>
    <figure class="vf2-photo">
      <img src="/storage/clients/assets/images/products/vf2/vinfast-vf2-ngoai-that-mau-xanh-mint-canh-bien-logo-desktop.webp" width="1000" height="563" alt="Hình chụp ngang VinFast VF 2 màu xanh Urban Mint" loading="lazy" decoding="async">
      <figcaption>Urban Mint là một trong tám màu ngoại thất hãng công bố cho VF 2. Ảnh: VinFast.</figcaption>
    </figure>
    <figure class="vf2-photo">
      <img src="/storage/clients/assets/images/products/vf2/vinfast-vf2-ngoai-that-mau-xanh-mint-canh-bien-desktop.webp" width="1000" height="563" alt="VinFast VF 2 màu xanh nhạt nhìn ngang trên tuyến đường sát biển" loading="lazy" decoding="async">
      <figcaption>Hình minh họa VF 2 trong bối cảnh đi lại hằng ngày. Ảnh: VinFast.</figcaption>
    </figure>
</section>

<section id="vf2-thong-so">
    <h2>Bảng thông số kỹ thuật VinFast VF 2</h2>
    <div class="vf2-table-wrap">
      <table>
        <caption>Thông số VF 2 đối chiếu nguồn VinFast</caption>
        <tbody>
          <tr><th scope="row">Phân khúc / cấu hình</th><td>Ô tô điện đô thị cỡ nhỏ, 2 cửa bên hông, 4 chỗ</td></tr>
          <tr><th scope="row">Dài × rộng × cao</th><td>3.090 × 1.496 × 1.663,2 mm</td></tr>
          <tr><th scope="row">Chiều dài cơ sở</th><td>2.065 mm</td></tr>
          <tr><th scope="row">Khoảng sáng gầm không tải</th><td>166,3 mm</td></tr>
          <tr><th scope="row">La-zăng</th><td>13 inch</td></tr>
          <tr><th scope="row">Động cơ</th><td>01 mô-tơ điện, dẫn động cầu sau (RWD)</td></tr>
          <tr><th scope="row">Công suất / mô-men xoắn tối đa</th><td>30 kW / 65 Nm</td></tr>
          <tr><th scope="row">Tốc độ tối đa công bố</th><td>80 km/h</td></tr>
          <tr><th scope="row">Chế độ lái</th><td>Eco và Normal</td></tr>
          <tr><th scope="row">Dung lượng pin khả dụng</th><td>18,3 kWh</td></tr>
          <tr><th scope="row">Quãng đường công bố</th><td>210 km/lần sạc (NEDC)</td></tr>
          <tr><th scope="row">Sạc nhanh DC</th><td>Tối đa khoảng 24 kW; 10–70% khoảng 34 phút</td></tr>
          <tr><th scope="row">Đèn chiếu sáng trước / đèn hậu</th><td>LED / Halogen</td></tr>
          <tr><th scope="row">Gương chiếu hậu ngoài</th><td>Chỉnh cơ</td></tr>
          <tr><th scope="row">Điều hòa</th><td>Chỉnh cơ</td></tr>
          <tr><th scope="row">Màn hình</th><td>Màn hình thông tin lái 7 inch</td></tr>
          <tr><th scope="row">Âm thanh</th><td>2 loa, radio FM</td></tr>
          <tr><th scope="row">Ghế</th><td>Bọc nỉ; ghế lái chỉnh cơ 4 hướng</td></tr>
          <tr><th scope="row">An toàn chủ động</th><td>ABS, EBD, TCS</td></tr>
          <tr><th scope="row">Túi khí</th><td>01 túi khí phía người lái</td></tr>
          <tr><th scope="row">Ghế trẻ em</th><td>Có móc cố định ISOFIX</td></tr>
          <tr><th scope="row">Bảo hành xe</th><td>5 năm hoặc 130.000 km, tùy điều kiện nào đến trước</td></tr>
          <tr><th scope="row">Bảo hành pin cao áp</th><td>7 năm hoặc 160.000 km, tùy điều kiện nào đến trước</td></tr>
        </tbody>
      </table>
    </div>
    <p><small>Lưu ý: NEDC là quy trình kiểm định, quãng đường thực tế có thể thấp hơn. Các thông tin có thể được điều chỉnh theo tài liệu và chính sách của hãng tại thời điểm bàn giao.</small></p>
</section>

<section id="vf2-phu-hop">
    <h2>Ai nên mua VF 2? Ai nên cân nhắc thêm?</h2>
    <p><strong>VF 2 hợp với người mua ô tô đầu tiên</strong>, có nhu cầu đi lại chủ yếu trong thành phố, thường đi một hoặc hai người, muốn một chiếc ô tô điện gọn và có kế hoạch sạc thuận tiện. Xe cũng đáng xem với gia đình cần thêm một phương tiện che mưa nắng, đưa đón người thân ở quãng đường không quá dài.</p>
    <p><strong>Nên cân nhắc kỹ</strong> nếu bạn thường chở đủ bốn người lớn, có người lớn tuổi lên xuống ghế sau mỗi ngày, phải mang theo nhiều vali hoặc thường di chuyển nhanh, xa. Hai cửa bên hông, mức tốc độ tối đa 80 km/h và quãng đường 210 km theo NEDC là những giới hạn cần hiểu trước khi mua; không nên bỏ qua vì giá xe dễ tiếp cận.</p>
</section>

<section id="vf2-faq">
    <h2>Câu hỏi thường gặp về VinFast VF 2 tại Hải Phòng</h2>
    <h3>Giá 188 triệu của VF 2 đã bao gồm pin chưa?</h3>
    <p>Có. Giá niêm yết 188 triệu đồng được VinFast công bố đã gồm pin. Đây chưa phải giá lăn bánh cuối cùng và có thể có ưu đãi theo từng thời điểm.</p>
    <h3>VF 2 có bao nhiêu cửa và bao nhiêu chỗ?</h3>
    <p>VF 2 có hai cửa bên hông và bốn chỗ ngồi, chia thành hai hàng ghế. Người vào hàng ghế sau phải thao tác qua khu vực ghế trước.</p>
    <h3>210 km có phải quãng đường chạy thực tế?</h3>
    <p>Không nhất thiết. Đây là quãng đường công bố theo NEDC. Vận hành ngoài thực tế có thể ít hơn tùy đường đi, tốc độ, điều hòa và tải trọng.</p>
    <h3>Sạc nhanh VF 2 mất bao lâu?</h3>
    <p>Khoảng 34 phút cho mức pin từ 10% lên 70% trong điều kiện phù hợp với sạc nhanh DC. Đây không phải thời gian sạc từ 0% lên 100%.</p>
    <h3>VF 2 có màn hình giải trí 7 inch không?</h3>
    <p>Thông số chính thức nêu màn hình thông tin lái 7 inch phía sau vô lăng, cùng hai loa và radio FM. Không nên nhầm màn hình thông tin lái với một màn hình giải trí trung tâm.</p>
    <h3>Xe VF 2 được bảo hành bao lâu?</h3>
    <p>Theo công bố của VinFast khi nhận cọc, xe được bảo hành 5 năm hoặc 130.000 km; pin cao áp 7 năm hoặc 160.000 km, tùy điều kiện nào đến trước. Cần kiểm tra điều kiện bảo hành áp dụng cho chiếc xe được bàn giao.</p>
    <h3>Mua VF 2 tại Hải Phòng nên kiểm tra điều gì?</h3>
    <p>Ít nhất hãy kiểm tra giá lăn bánh thực tế, tình trạng màu xe và lịch giao, chỗ để xe và phương án sạc, thao tác lên xuống hàng ghế sau, danh mục phụ kiện sạc và điều kiện bảo hành. Nếu có thể, hãy lái thử trước khi quyết định.</p>
</section>

<section id="vf2-tu-van">
    <h2>Xem xe, hỏi giá lăn bánh VF 2 tại VinFast Hải Phòng</h2>
    <p>Mua ô tô đầu đời không cần vội quyết định chỉ vì một tấm ảnh đẹp. Hãy thử ngồi đủ bốn vị trí, quan sát cốp, làm quen màn hình và điều hòa, kiểm tra đường ra vào hàng ghế sau và xác định điểm sạc gần nhà. <strong>VinFast Hải Phòng</strong> có thể hỗ trợ bạn đối chiếu cấu hình, cập nhật giá xe, chi phí đăng ký và phương án sử dụng phù hợp với lịch đi lại hằng ngày.</p>
    <p>Trước khi đặt cọc, hãy yêu cầu báo giá theo đúng màu và cấu hình thực tế, ghi rõ ưu đãi và điều kiện áp dụng, các khoản phí, phụ kiện sạc, chính sách bảo hành và thời điểm dự kiến bàn giao.</p>
    <div style="background: #f8fafc; border: 1px solid #e2e8f0; border-radius: 6px; padding: 18px; margin: 16px 0; display: flex; flex-wrap: wrap; justify-content: space-between; align-items: center; gap: 14px;">
      <div>
        <div style="font-weight: 600; color: #1e293b; font-size: 16px; margin-bottom: 4px;">Đăng ký nhận báo giá &amp; lái thử VinFast VF 2 tại Hải Phòng</div>
        <div style="font-size: 14px; color: #64748b;">Showroom: Thửa 05, Lô 26A, Đường Lê Hồng Phong, phường Gia Viên, Thành phố Hải Phòng</div>
      </div>
      <div style="display: flex; gap: 10px; align-items: center; flex-wrap: wrap;">
        <a href="tel:0988302882" class="vinfast-autohaiphong_product_btn" style="display: inline-flex; align-items: center; gap: 6px; background: #0051ff; color: #fff; padding: 9px 18px; border-radius: 4px; text-decoration: none; font-size: 14px; font-weight: 500;">
          📞 Hotline: 0988 302 882
        </a>
        <a href="/lien-he" class="vinfast-autohaiphong_product_btn" style="display: inline-flex; align-items: center; gap: 6px; background: #fff; color: #0051ff; border: 1px solid #0051ff; padding: 9px 18px; border-radius: 4px; text-decoration: none; font-size: 14px; font-weight: 500;">
          Nhận bảng dự toán lăn bánh
        </a>
      </div>
    </div>
    <p class="vf2-source-note"><small>Nguồn đối chiếu: Trang thông tin chính thức và thông báo bán hàng của VinFast. Thông tin sản phẩm có thể thay đổi; hình ảnh minh họa thuộc nguồn VinFast.</small></p>
</section>
HTML;
    }
}
