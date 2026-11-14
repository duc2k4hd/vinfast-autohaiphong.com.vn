<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class Vf3SpecificationsSeeder extends Seeder
{
    /**
     * Seed full specifications for VinFast VF 3.
     */
    public function run(): void
    {
        DB::transaction(function () {
            // 1. Tạo các nhóm thông số
            $groups = [
                ['name' => 'Kích Thước', 'slug' => 'kich-thuoc', 'sort_order' => 1],
                ['name' => 'Tải Trọng', 'slug' => 'tai-trong', 'sort_order' => 2],
                ['name' => 'Động Cơ & Vận Hành', 'slug' => 'dong-co-van-hanh', 'sort_order' => 3],
                ['name' => 'Pin & Hệ Thống Sạc', 'slug' => 'pin-he-thong-sac', 'sort_order' => 4],
                ['name' => 'Hệ Thống Truyền Động', 'slug' => 'he-thong-truyen-dong', 'sort_order' => 5],
                ['name' => 'Khung Gầm & Treo - Phanh', 'slug' => 'khung-gam-treo-phanh', 'sort_order' => 6],
                ['name' => 'Ngoại Thất', 'slug' => 'ngoai-that', 'sort_order' => 7],
                ['name' => 'Nội Thất & Tiện Nghi', 'slug' => 'noi-that-tien-nghi', 'sort_order' => 8],
                ['name' => 'An Toàn & An Ninh', 'slug' => 'an-toan-an-ninh', 'sort_order' => 9],
                ['name' => 'Tính Năng Thông Minh', 'slug' => 'tinh-nang-thong-minh', 'sort_order' => 10],
            ];

            $groupIds = [];
            foreach ($groups as $g) {
                $existing = DB::table('product_specification_groups')->where('slug', $g['slug'])->first();
                if ($existing) {
                    $groupIds[$g['slug']] = $existing->id;
                } else {
                    $id = DB::table('product_specification_groups')->insertGetId([
                        'name' => $g['name'],
                        'slug' => $g['slug'],
                        'sort_order' => $g['sort_order'],
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]);
                    $groupIds[$g['slug']] = $id;
                }
            }

            // 2. Xóa các specs cũ của VF 3 (id = 2)
            DB::table('product_specifications')->where('product_id', 2)->delete();

            // 3. Chuẩn bị danh sách thông số chi tiết
            $specs = [
                // KÍCH THƯỚC
                ['kich-thuoc', 'Chiều dài cơ sở', '2.075 mm', null, 1],
                ['kich-thuoc', 'Dài x Rộng x Cao', '3.190 x 1.679 x 1.622 mm', null, 2],
                ['kich-thuoc', 'Khoảng sáng gầm xe không tải', '191 mm', null, 3],
                ['kich-thuoc', 'Dung tích khoang hành lý (Có hàng ghế cuối)', '36 L', null, 4],
                ['kich-thuoc', 'Dung tích khoang hành lý (Gập hàng ghế cuối)', '285 L', null, 5],
                ['kich-thuoc', 'Đường kính quay đầu tối thiểu', '8,1 m', null, 6],

                // TẢI TRỌNG
                ['tai-trong', 'Trọng lượng không tải', '857 kg', null, 1],
                ['tai-trong', 'Sức chứa', '300 kg', null, 2],
                ['tai-trong', 'Tải trọng hành lý nóc xe', '50 kg', null, 3],

                // ĐỘNG CƠ & VẬN HÀNH
                ['dong-co-van-hanh', 'Công suất tối đa', '32 kW (43 hp)', null, 1],
                ['dong-co-van-hanh', 'Mô-men xoắn cực đại', '110 Nm', null, 2],
                ['dong-co-van-hanh', 'Tốc độ tối đa duy trì 1 phút', '100 km/h (dung lượng pin >50%, mọi thời tiết)', null, 3],
                ['dong-co-van-hanh', 'Tăng tốc 0 – 50 km/h', '5,3 giây', null, 4],
                ['dong-co-van-hanh', 'Tăng tốc 0 – 100 km/h', '19,3 giây', null, 5],
                ['dong-co-van-hanh', 'Mức tiêu thụ năng lượng hỗn hợp', '9 kWh/100 km (NEDC)', null, 6],

                // PIN & HỆ THỐNG SẠC
                ['pin-he-thong-sac', 'Loại pin', 'LFP cao cấp', null, 1],
                ['pin-he-thong-sac', 'Dung lượng pin (khả dụng)', '18,64 kWh', null, 2],
                ['pin-he-thong-sac', 'Quãng đường chạy 1 lần sạc đầy (Chuẩn NEDC)', '210 km / lần sạc', null, 3],
                ['pin-he-thong-sac', 'Tính năng sạc nhanh', 'Có hỗ trợ', null, 4],
                ['pin-he-thong-sac', 'Thời gian nạp pin nhanh (10% - 70%)', '36 phút', null, 5],
                ['pin-he-thong-sac', 'Thời gian nạp pin bình thường (10% - 70%)', '5 giờ', null, 6],
                ['pin-he-thong-sac', 'Hệ thống phanh tái sinh', 'Có', null, 7],

                // HỆ THỐNG TRUYỀN ĐỘNG
                ['he-thong-truyen-dong', 'Cách chuyển số', 'Tích hợp vào cần gạt vô lăng', null, 1],
                ['he-thong-truyen-dong', 'Hệ dẫn động', 'Cầu sau (RWD)', null, 2],
                ['he-thong-truyen-dong', 'Chọn chế độ lái', 'Có (Eco / Normal)', null, 3],
                ['he-thong-truyen-dong', 'Chế độ thay đổi tốc độ đến dừng', 'Có (Lăn / Bò)', null, 4],

                // KHUNG GẦM & TREO - PHANH
                ['khung-gam-treo-phanh', 'Hệ thống treo trước', 'Độc lập, MacPherson', null, 1],
                ['khung-gam-treo-phanh', 'Hệ thống treo sau', 'Phụ thuộc, trục cứng với thanh xoắn Panhard', null, 2],
                ['khung-gam-treo-phanh', 'Hệ thống phanh trước', 'Phanh đĩa, calip nổi', null, 3],
                ['khung-gam-treo-phanh', 'Hệ thống phanh sau', 'Phanh tang trống', null, 4],
                ['khung-gam-treo-phanh', 'Kích thước lốp & La-zăng', '175/75R16', null, 5],
                ['khung-gam-treo-phanh', 'Bộ vá lốp khẩn cấp', 'Có', null, 6],
                ['khung-gam-treo-phanh', 'Trợ lực lái', 'Có trợ lực điện', null, 7],
                ['khung-gam-treo-phanh', 'Thanh cân bằng trước', 'Có', null, 8],

                // NGOẠI THẤT
                ['ngoai-that', 'Đèn pha chiếu sáng', 'Halogen sắc nét', null, 1],
                ['ngoai-that', 'Đèn hậu', 'Halogen', null, 2],
                ['ngoai-that', 'Đèn định vị ban ngày', 'Halogen', null, 3],
                ['ngoai-that', 'Thanh gia cường cửa xe', 'Có', null, 4],
                ['ngoai-that', 'Điều chỉnh cốp sau', 'Chỉnh cơ tiện lợi', null, 5],
                ['ngoai-that', 'Cánh hướng gió thể thao', 'Tích hợp liền khối vào cốp', null, 6],
                ['ngoai-that', 'Cơ chế đóng mở cổng sạc', 'Chỉnh cơ', null, 7],

                // NỘI THẤT & TIỆN NGHI
                ['noi-that-tien-nghi', 'Số chỗ ngồi', '4 chỗ', null, 1],
                ['noi-that-tien-nghi', 'Chất liệu bọc ghế', 'Nỉ cao cấp', null, 2],
                ['noi-that-tien-nghi', 'Ghế lái', 'Chỉnh cơ 4 hướng, tựa đầu tích hợp', null, 3],
                ['noi-that-tien-nghi', 'Ghế phụ', 'Chỉnh cơ 4 hướng, tựa đầu tích hợp', null, 4],
                ['noi-that-tien-nghi', 'Lên xuống dễ dàng hàng thứ 2', 'Có', null, 5],
                ['noi-that-tien-nghi', 'Hàng ghế thứ 2', 'Gập hoàn toàn, tựa đầu cố định', null, 6],
                ['noi-that-tien-nghi', 'Hệ thống điều hòa', 'Chỉnh cơ, 1 vùng độc lập', null, 7],
                ['noi-that-tien-nghi', 'Lọc không khí cabin', 'Lọc bụi mịn tiêu chuẩn', null, 8],
                ['noi-that-tien-nghi', 'Chức năng làm tan sương / tan băng', 'Có', null, 9],
                ['noi-that-tien-nghi', 'Màn hình giải trí cảm ứng', '10 inch trung tâm sắc nét', null, 10],
                ['noi-that-tien-nghi', 'Cổng sạc USB loại A hàng ghế 2', 'Có (1 cổng 1,5 A)', null, 11],
                ['noi-that-tien-nghi', 'Kết nối mạng Wi-Fi', 'Có (Hỗ trợ cập nhật phần mềm từ xa)', null, 12],
                ['noi-that-tien-nghi', 'Kết nối Bluetooth', 'Có', null, 13],
                ['noi-that-tien-nghi', 'Khởi động bằng bàn đạp phanh (BEV)', 'Có', null, 14],
                ['noi-that-tien-nghi', 'Ngôn ngữ giao diện hỗ trợ', 'Tiếng Việt / Tiếng Anh', null, 15],
                ['noi-that-tien-nghi', 'Hệ thống loa âm thanh', '2 loa sống động', null, 16],
                ['noi-that-tien-nghi', 'Đèn trần khoang trước', 'Dạng bóng chiếu sáng', null, 17],
                ['noi-that-tien-nghi', 'Tấm che nắng', 'Có (Loại không gương)', null, 18],
                ['noi-that-tien-nghi', 'Hộc đựng cốc giữa hàng ghế trước', '2 vị trí', null, 19],
                ['noi-that-tien-nghi', 'Phanh tay', 'Kích hoạt nút P ở cần gạt vô lăng', null, 20],
                ['noi-that-tien-nghi', 'Khay đựng dụng cụ sửa xe', 'Có (Túi vải chuyên dụng)', null, 21],
                ['noi-that-tien-nghi', 'Móc kéo tời', 'Có (Có thể tháo rời)', null, 22],
                ['noi-that-tien-nghi', 'Gương chiếu hậu trong xe', 'Chế độ ngày & đêm (loại thường)', null, 23],

                // AN TOÀN & AN NINH
                ['an-toan-an-ninh', 'Chống bó cứng phanh (ABS)', 'Có', null, 1],
                ['an-toan-an-ninh', 'Hỗ trợ phanh khẩn cấp (BA)', 'Có', null, 2],
                ['an-toan-an-ninh', 'Kiểm soát lực kéo (TCS)', 'Có', null, 3],
                ['an-toan-an-ninh', 'Hỗ trợ khởi hành ngang dốc (HSA)', 'Có', null, 4],
                ['an-toan-an-ninh', 'Khóa cửa tự động khi di chuyển', 'Có (Tự khóa khi đạt 5 km/h)', null, 5],
                ['an-toan-an-ninh', 'Căng đai khẩn cấp ghế trước', 'Có', null, 6],
                ['an-toan-an-ninh', 'Cảnh báo dây an toàn', 'Ghế phụ trước & hàng trước', null, 7],
                ['an-toan-an-ninh', 'Hệ thống túi khí', 'Túi khí trước cho người lái', null, 8],
                ['an-toan-an-ninh', 'Khóa động cơ chống trộm', 'Có', null, 9],
                ['an-toan-an-ninh', 'Cảm biến hỗ trợ đỗ xe phía sau', 'Có', null, 10],
                ['an-toan-an-ninh', 'Hệ thống camera lùi sau', 'Có (Chuẩn AFS)', null, 11],

                // TÍNH NĂNG THÔNG MINH
                ['tinh-nang-thong-minh', 'Điều khiển chức năng xe thông minh', 'Có (Thao tác trên màn hình cảm ứng)', null, 1],
                ['tinh-nang-thong-minh', 'Chế độ Cắm trại (Camping Mode)', 'Có', null, 2],
                ['tinh-nang-thong-minh', 'Đồng bộ & quản lý tài khoản người lái', 'Có (Màn hình & Ứng dụng VinFast)', null, 3],
                ['tinh-nang-thong-minh', 'Tìm kiếm địa điểm & dẫn đường thông minh', 'Có (Android Auto / Apple CarPlay - Cập nhật sau)', null, 4],
                ['tinh-nang-thong-minh', 'Định vị vị trí xe từ xa qua GPS', 'Có (Qua Ứng dụng VinFast)', null, 5],
                ['tinh-nang-thong-minh', 'Đề xuất lịch bảo dưỡng tự động', 'Có (Qua Ứng dụng VinFast)', null, 6],
                ['tinh-nang-thong-minh', 'Theo dõi tình trạng xe từ xa (Pin, nước làm mát...)', 'Có (Qua Ứng dụng VinFast)', null, 7],
                ['tinh-nang-thong-minh', 'Giải trí đồng bộ điện thoại', 'Có (Android Auto / Apple CarPlay)', null, 8],
                ['tinh-nang-thong-minh', 'Giải trí âm thanh & đa phương tiện', 'Có (Trên màn hình cảm ứng 10 inch)', null, 9],
                ['tinh-nang-thong-minh', 'Tra cứu & truy cập mạng Internet', 'Có', null, 10],
                ['tinh-nang-thong-minh', 'Đồng bộ danh bạ & lịch điện thoại', 'Có (Bluetooth & Kết nối dây)', null, 11],
                ['tinh-nang-thong-minh', 'Cập nhật phần mềm miễn phí FOTA', 'Có (Qua màn hình)', null, 12],
                ['tinh-nang-thong-minh', 'Cập nhật phần mềm thu phí SOTA', 'Có (Qua màn hình)', null, 13],
                ['tinh-nang-thong-minh', 'Thông báo & đặt lịch dịch vụ hậu mãi Showroom', 'Có (Qua Ứng dụng VinFast)', null, 14],
                ['tinh-nang-thong-minh', 'Quản lý gói cước thuê pin trực tuyến', 'Có (Qua Ứng dụng VinFast)', null, 15],
            ];

            $rows = [];
            foreach ($specs as $sp) {
                $gSlug = $sp[0];
                $rows[] = [
                    'product_id' => 2,
                    'group_id' => $groupIds[$gSlug] ?? null,
                    'label' => $sp[1],
                    'value' => $sp[2],
                    'unit' => $sp[3],
                    'sort_order' => $sp[4],
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
            }

            DB::table('product_specifications')->insert($rows);
        });
    }
}

