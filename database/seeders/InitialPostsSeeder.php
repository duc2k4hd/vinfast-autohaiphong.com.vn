<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class InitialPostsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $now = now();

        $posts = [
            [
                'title' => 'Chính Sách Miễn Phí Sạc Pin Xe Điện VinFast Toàn Quốc Đến Năm 2026',
                'slug' => 'chinh-sach-mien-phi-sac-pin-xe-dien-vinfast-toan-quoc',
                'excerpt' => 'VinFast công bố chính sách đột phá miễn phí sạc pin tại toàn bộ trạm sạc V-GREEN trên toàn quốc, giúp chủ sở hữu xe điện tối ưu chi phí vận hành ở mức thấp nhất.',
                'content_html' => '<p>Nhằm thúc đẩy quá trình chuyển đổi xanh và tri ân khách hàng đã tiên phong đồng hành, VinFast cùng mạng lưới trạm sạc V-GREEN chính thức áp dụng chương trình ưu đãi đặc quyền sạc pin miễn phí trên toàn hệ thống trạm sạc công cộng.</p><h3>1. Đối Tượng & Thời Gian Áp Dụng</h3><p>Chương trình áp dụng cho tất cả các dòng ô tô điện VinFast (từ VF 3, VF 5 Plus, VF 6, VF 7, VF 8 đến VF 9) đăng ký chính chủ tại các tỉnh thành trên cả nước, bao gồm thành phố Hải Phòng.</p><h3>2. Lợi Ích Vượt Trội Cho Khách Hàng Hải Phòng</h3><p>Với hệ thống trạm sạc dày đặc tại các siêu thị Vincom Plaza Imperia, Vincom Lê Thánh Tông, các cửa hàng xăng dầu PVOIL trên địa bàn Hồng Bàng, Ngô Quyền, Lê Chân, Kiến An, chủ xe hoàn toàn yên tâm nạp đầy năng lượng cho xe mà không tốn bất kỳ chi phí nào.</p>',
                'status' => 'published',
                'featured' => true,
                'published_at' => $now,
                'meta_title' => 'Chính Sách Miễn Phí Sạc Pin VinFast Đến 2026 | VinFast Hải Phòng',
                'meta_description' => 'Tìm hiểu chính sách miễn phí sạc pin cho xe ô tô điện VinFast tại Hải Phòng và toàn quốc. Hướng dẫn sử dụng trạm sạc V-GREEN.',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'title' => 'VinFast VF 3 — Mẫu Xe Điện Đô Thị Gây Sốt Tại Thị Trường Hải Phòng',
                'slug' => 'vinfast-vf-3-xe-dien-do-thi-hai-phong',
                'excerpt' => 'Với thiết kế mini SUV cá tính, gầm cao 191mm và quãng đường di chuyển hơn 210 km, VinFast VF 3 nhanh chóng trở thành mẫu xe bán chạy số một tại Hải Phòng.',
                'content_html' => '<p>VinFast VF 3 đã tạo nên một làn sóng mạnh mẽ trong phân khúc xe đô thị cỡ nhỏ. Sở hữu kích thước nhỏ gọn nhưng không gian bên trong lại vô cùng tối ưu cho 4 người lớn ngồi thoải mái, VF 3 là sự lựa chọn số một cho gia đình trẻ và người mới mua xe lần đầu.</p><h3>Khả Năng Xoay Xở Linh Hoạt Trong Phố Cảng</h3><p>Đường phố Hải Phòng với nhiều ngõ phố đặc thù đòi hỏi một mẫu xe có bán kính quay vòng nhỏ và khoảng sáng gầm xe cao. VF 3 với gầm cao tới 191 mm dễ dàng vượt qua các đoạn đường ngập nước nhẹ vào mùa mưa hay leo vỉa hè khi đỗ xe.</p>',
                'status' => 'published',
                'featured' => true,
                'published_at' => $now,
                'meta_title' => 'Đánh Giá VinFast VF 3 Tại Hải Phòng | Đại Lý VinFast Minh Đạo',
                'meta_description' => 'Khám phá chi tiết VinFast VF 3: Thiết kế mini SUV, giá bán lăn bánh Hải Phòng, thông số kỹ thuật và hỗ trợ thủ tục mua xe trả góp.',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'title' => 'Cẩm Nang Hướng Dẫn Sử Dụng Trạm Sạc Xe Điện VinFast Tại Hải Phòng',
                'slug' => 'huong-dan-su-dung-tram-sac-vinfast-hai-phong',
                'excerpt' => 'Tổng hợp danh sách các điểm trạm sạc nhanh VinFast tại Hải Phòng và các bước cắm sạc, thanh toán tiện lợi qua ứng dụng VinFast Club.',
                'content_html' => '<p>Hải Phòng là một trong những địa phương có mật độ trạm sạc VinFast cao nhất cả nước. Các trạm sạc được phân bổ từ khu vực nội đô đến các trục đường huyết mạch như cao tốc Hà Nội - Hải Phòng, quốc lộ 5, quốc lộ 10.</p><h3>Các Bước Sạc Xe Cực Kỳ Đơn Giản:</h3><ul><li>Bước 1: Di chuyển xe vào đúng vị trí đỗ tại trụ sạc còn trống.</li><li>Bước 2: Mở nắp cổng sạc trên xe và rút súng sạc cắm chặt vào cổng sạc.</li><li>Bước 3: Mở ứng dụng VinFast trên điện thoại, quét mã QR trên trụ sạc để bắt đầu nạp điện.</li><li>Bước 4: Theo dõi phần trăm pin trực tiếp trên màn hình xe hoặc qua điện thoại. Khi hoàn tất, bấm dừng và rút súng sạc.</li></ul>',
                'status' => 'published',
                'featured' => false,
                'published_at' => $now,
                'meta_title' => 'Hướng Dẫn Sử Dụng Trạm Sạc VinFast Hải Phòng Chi Tiết Nhất',
                'meta_description' => 'Vị trí trạm sạc VinFast tại Hải Phòng và quy trình sạc pin nhanh chóng, an toàn cho mọi dòng xe ô tô điện.',
                'created_at' => $now,
                'updated_at' => $now,
            ],
        ];

        Schema::disableForeignKeyConstraints();
        DB::table('posts')->truncate();
        Schema::enableForeignKeyConstraints();
        DB::table('posts')->insert($posts);
    }
}
