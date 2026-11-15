<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Services\Shared\SettingsService;
use Illuminate\View\View;

class PageController extends Controller
{
    public function __construct(
        protected SettingsService $settingsService
    ) {}

    /**
     * Cổng Thông Tin Chính Sách & Quyền Lợi Khách Hàng (Policy Hub).
     */
    public function policyHub(): View
    {
        return view('clients.pages.custom.policy-hub', [
            'settings' => $this->settingsService->getPublicSettings(),
            'vehicles' => $this->getWarrantyVehicles(),
            'activeTab' => 'hub',
        ]);
    }

    /**
     * Trang Pin & Trạm Sạc VinFast.
     */
    public function chargingStations(): View
    {
        return view('clients.pages.custom.charging-stations', [
            'settings' => $this->settingsService->getPublicSettings(),
        ]);
    }

    /**
     * Trang Trải Nghiệm Khách Hàng.
     */
    public function customerExperience(): View
    {
        return view('clients.pages.custom.customer-experience');
    }

    /**
     * Trang Chính Sách Thanh Toán (Quy trình nhận xe & thanh toán tiền mặt tại showroom).
     */
    public function paymentPolicy(): View
    {
        return view('clients.pages.custom.payment-policy', [
            'settings' => $this->settingsService->getPublicSettings(),
            'vehicles' => $this->getWarrantyVehicles(),
            'activeTab' => 'thanh-toan',
        ]);
    }

    /**
     * Trang Chính Sách Bảo Mật.
     */
    public function privacyPolicy(): View
    {
        return view('clients.pages.custom.privacy-policy', [
            'settings' => $this->settingsService->getPublicSettings(),
            'activeTab' => 'bao-mat',
        ]);
    }

    /**
     * Trang Chính Sách Bảo Hành.
     */
    public function warrantyPolicy(): View
    {
        return view('clients.pages.custom.warranty-policy', [
            'settings' => $this->settingsService->getPublicSettings(),
            'vehicles' => $this->getWarrantyVehicles(),
            'activeTab' => 'bao-hanh',
        ]);
    }

    /**
     * Trang Điều Khoản Sử Dụng.
     */
    public function terms(): View
    {
        return view('clients.pages.custom.terms', [
            'settings' => $this->settingsService->getPublicSettings(),
            'activeTab' => 'dieu-khoan',
        ]);
    }

    /**
     * Dữ liệu chính sách bảo hành & kỹ thuật chuẩn xác theo từng mẫu xe VinFast.
     */
    protected function getWarrantyVehicles(): array
    {
        return [
            [
                'id' => 'vf3',
                'name' => 'VinFast VF 3',
                'segment' => 'Mini SUV Đô Thị',
                'warranty_car' => '7 năm hoặc 160.000 km',
                'warranty_battery' => '8 năm không giới hạn km',
                'range' => '215 km',
                'battery_capacity' => '18.64 kWh',
                'service_interval' => '12.000 km / 12 tháng',
                'est_maintenance' => '250.000 – 400.000 đ',
                'deposit_amount' => '15.000.000 đ',
                'image' => asset('storage/clients/assets/images/products/xe-dien-vinfast-vf3-1794647910-p49C.webp'),
                'highlights' => [
                    'Bảo hành xe chính hãng 7 năm vượt trội phân khúc mini car',
                    'Pin LFP độ bền cao, bảo hành 8 năm không giới hạn số km lăn bánh',
                    'Thay thế pin mới miễn phí nếu dung lượng pin khả dụng (SoH) dưới 70%',
                    'Cứu hộ pin cơ động 24/7 tại Hải Phòng qua hotline 0915 286 506',
                ],
            ],
            [
                'id' => 'vf5',
                'name' => 'VinFast VF 5 Plus',
                'segment' => 'A-SUV Gia Đình & Đô Thị',
                'warranty_car' => '7 năm hoặc 160.000 km',
                'warranty_battery' => '8 năm không giới hạn km',
                'range' => '326 km',
                'battery_capacity' => '37.23 kWh',
                'service_interval' => '12.000 km / 12 tháng',
                'est_maintenance' => '300.000 – 500.000 đ',
                'deposit_amount' => '20.000.000 đ',
                'image' => asset('storage/clients/assets/images/products/vinfast-vf-5.webp'),
                'highlights' => [
                    'Chính sách bảo hành 7 năm giúp an tâm tối đa khi sử dụng gia đình hoặc kinh doanh',
                    'Chi phí bảo dưỡng định kỳ chỉ bằng 25% so với xe xăng hạng A',
                    'Phụ tùng thay thế sẵn có tại Xưởng dịch vụ 3S VinFast Hải Phòng',
                    'Cứu hộ miễn phí 24/7 trên toàn tuyến cao tốc Hải Phòng - Hà Nội',
                ],
            ],
            [
                'id' => 'vf6',
                'name' => 'VinFast VF 6',
                'segment' => 'B-SUV Sang Trọng & Hiện Đại',
                'warranty_car' => '7 năm hoặc 160.000 km',
                'warranty_battery' => '8 năm không giới hạn km',
                'range' => '399 km',
                'battery_capacity' => '59.6 kWh',
                'service_interval' => '12.000 km / 12 tháng',
                'est_maintenance' => '400.000 – 650.000 đ',
                'deposit_amount' => '30.000.000 đ',
                'image' => asset('storage/clients/assets/images/products/vinfast-vf-6.webp'),
                'highlights' => [
                    'Bảo hành 7 năm hoặc 160.000 km cho toàn bộ hệ thống động cơ và phần mềm điều khiển',
                    'Hệ thống trợ lái nâng cao ADAS được cập nhật phần mềm định kỳ hoàn toàn miễn phí',
                    'Bảo hành pin 8 năm không giới hạn quãng đường di chuyển',
                    'Ưu tiên dịch vụ sửa chữa lưu động Mobile Service đến tận cơ quan/nhà riêng tại Hải Phòng',
                ],
            ],
            [
                'id' => 'vf7',
                'name' => 'VinFast VF 7',
                'segment' => 'C-SUV Thể Thao & Đột Phá',
                'warranty_car' => '10 năm hoặc 200.000 km',
                'warranty_battery' => '10 năm không giới hạn km',
                'range' => '431 – 496 km',
                'battery_capacity' => '75.3 kWh',
                'service_interval' => '12.000 km / 12 tháng',
                'est_maintenance' => '500.000 – 800.000 đ',
                'deposit_amount' => '40.000.000 đ',
                'image' => asset('storage/clients/assets/images/products/vinfast-vf-7.webp'),
                'highlights' => [
                    'Thời hạn bảo hành 10 năm cao nhất trong phân khúc C-SUV tại Việt Nam',
                    'Bảo hành hệ thống dẫn động 4 bánh toàn thời gian AWD và khung gầm 10 năm',
                    'Bảo hành pin 10 năm không giới hạn km với cam kết dung lượng tiêu chuẩn',
                    'Đội ngũ chuyên viên kỹ thuật cao cấp 3S trực tiếp theo dõi lịch sử bảo dưỡng',
                ],
            ],
            [
                'id' => 'vf8',
                'name' => 'VinFast VF 8',
                'segment' => 'D-SUV Toàn Cầu & Công Nghệ',
                'warranty_car' => '10 năm hoặc 200.000 km',
                'warranty_battery' => '10 năm không giới hạn km',
                'range' => '471 km',
                'battery_capacity' => '87.7 kWh',
                'service_interval' => '12.000 km / 12 tháng',
                'est_maintenance' => '600.000 – 900.000 đ',
                'deposit_amount' => '50.000.000 đ',
                'image' => asset('storage/clients/assets/images/products/vinfast-vf-8.webp'),
                'highlights' => [
                    'Tiêu chuẩn bảo hành toàn cầu 10 năm hoặc 200.000 km',
                    'Pin cao áp bảo hành 10 năm không giới hạn số km vận hành',
                    'Dịch vụ cứu hộ khẩn cấp 24/7 và hỗ trợ xe thay thế theo chính sách đặc quyền',
                    'Xưởng 3S VinFast Hải Phòng trang bị cầu nâng chuyên dụng và máy chẩn đoán thông minh',
                ],
            ],
            [
                'id' => 'vf9',
                'name' => 'VinFast VF 9',
                'segment' => 'E-SUV Đầu Bảng Chủ Tịch',
                'warranty_car' => '10 năm hoặc 200.000 km',
                'warranty_battery' => '10 năm không giới hạn km',
                'range' => '626 km',
                'battery_capacity' => '123 kWh',
                'service_interval' => '12.000 km / 12 tháng',
                'est_maintenance' => '700.000 – 1.100.000 đ',
                'deposit_amount' => '50.000.000 đ',
                'image' => asset('storage/clients/assets/images/products/vinfast-vf-9.webp'),
                'highlights' => [
                    'Chính sách chăm sóc VIP Concierge độc quyền dành riêng cho chủ nhân VF 9',
                    'Bảo hành xe và pin 10 năm không giới hạn km, dài nhất ngành công nghiệp ô tô',
                    'Ưu tiên tiếp nhận và xử lý ngay khi vào xưởng dịch vụ tại Hải Phòng',
                    'Hỗ trợ xe cứu hộ cơ động và nhân viên kỹ thuật đồng hành 24/7',
                ],
            ],
        ];
    }
}
