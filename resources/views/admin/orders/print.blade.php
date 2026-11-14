<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>In Phiếu Đặt Cọc - {{ $order->order_number }} | VinFast Hải Phòng</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@400;600;700;800&display=swap" rel="stylesheet">
    <style>
        * { box-sizing: border-box; margin: 0; padding: 0; }
        body {
            font-family: 'Open Sans', -apple-system, sans-serif;
            color: #1e293b;
            background-color: #f1f5f9;
            padding: 30px 20px;
            font-size: 14px;
            line-height: 1.5;
        }
        .print-container {
            max-width: 800px;
            margin: 0 auto;
            background: #ffffff;
            padding: 40px 48px;
            border-radius: 8px;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
        }
        .no-print {
            max-width: 800px;
            margin: 0 auto 20px auto;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .btn {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 8px 18px;
            border-radius: 6px;
            font-weight: 600;
            font-size: 14px;
            cursor: pointer;
            text-decoration: none;
            border: 1px solid transparent;
        }
        .btn-primary {
            background-color: #1464f4;
            color: #ffffff;
        }
        .btn-outline {
            background-color: #ffffff;
            border-color: #cbd5e1;
            color: #475569;
        }
        .header {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            border-bottom: 2px solid #0f172a;
            padding-bottom: 20px;
            margin-bottom: 24px;
        }
        .logo-box h2 {
            font-size: 18px;
            font-weight: 800;
            color: #1464f4;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        .logo-box p {
            font-size: 12px;
            color: #64748b;
            margin-top: 2px;
        }
        .doc-title {
            text-align: center;
            margin-bottom: 28px;
        }
        .doc-title h1 {
            font-size: 22px;
            font-weight: 800;
            color: #0f172a;
            letter-spacing: 0.5px;
            text-transform: uppercase;
        }
        .doc-title p {
            font-size: 13px;
            color: #64748b;
            margin-top: 4px;
        }
        .info-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 16px;
            margin-bottom: 24px;
            background: #f8fafc;
            padding: 16px 20px;
            border-radius: 6px;
            border: 1px solid #e2e8f0;
        }
        .info-row {
            display: flex;
            margin-bottom: 6px;
        }
        .info-label {
            width: 130px;
            font-weight: 600;
            color: #64748b;
            font-size: 13px;
        }
        .info-val {
            flex: 1;
            font-weight: 700;
            color: #0f172a;
            font-size: 13px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 24px;
        }
        th, td {
            border: 1px solid #cbd5e1;
            padding: 10px 14px;
            text-align: left;
        }
        th {
            background-color: #f1f5f9;
            font-weight: 700;
            font-size: 13px;
            color: #0f172a;
            text-transform: uppercase;
        }
        td {
            font-size: 13px;
        }
        .total-box {
            background: #f8fafc;
            border: 1px solid #e2e8f0;
            border-radius: 6px;
            padding: 16px 20px;
            margin-bottom: 30px;
        }
        .total-row {
            display: flex;
            justify-content: space-between;
            align-items: center;
            font-size: 15px;
            font-weight: 700;
            color: #0f172a;
        }
        .total-words {
            margin-top: 8px;
            font-size: 13px;
            font-style: italic;
            color: #475569;
        }
        .signatures {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            text-align: center;
            margin-top: 40px;
            page-break-inside: avoid;
        }
        .sig-col h4 {
            font-size: 13px;
            font-weight: 700;
            color: #0f172a;
            text-transform: uppercase;
        }
        .sig-col p {
            font-size: 12px;
            color: #64748b;
            font-style: italic;
            margin-top: 2px;
            margin-bottom: 60px;
        }
        .sig-name {
            font-weight: 700;
            color: #0f172a;
            font-size: 13px;
        }
        .footer-note {
            margin-top: 36px;
            border-top: 1px dashed #cbd5e1;
            padding-top: 12px;
            font-size: 11px;
            color: #94a3b8;
            text-align: center;
        }
        @media print {
            body { background: #ffffff; padding: 0; }
            .print-container { box-shadow: none; padding: 20px 0; border: none; }
            .no-print { display: none !important; }
        }
    </style>
</head>
<body>

<div class="no-print">
    <a href="{{ route('admin.orders.show', $order->id) }}" class="btn btn-outline">
        &larr; Quay Lại Đơn Hàng
    </a>
    <button type="button" onclick="window.print()" class="btn btn-primary">
        🖨 In Phiếu Đặt Cọc (Ctrl + P)
    </button>
</div>

<div class="print-container">
    {{-- Header Đại Lý --}}
    <div class="header">
        <div class="logo-box">
            <h2>VINFAST MINH ĐẠO HẢI PHÒNG</h2>
            <p>Đại lý ủy quyền chính thức của VinFast Việt Nam</p>
            <p>Địa chỉ: Số 1 Bạch Đằng, Phường Thượng Lý, Quận Hồng Bàng, TP. Hải Phòng</p>
            <p>Hotline Bán hàng: <strong>0988 302 882</strong> • Dịch vụ: 0915 286 506</p>
        </div>
        <div style="text-align: right;">
            <div style="font-size: 12px; color: #64748b;">Mẫu số: 01/VFHP-DC</div>
            <div style="font-weight: 800; font-size: 15px; color: #1464f4; margin-top: 4px;">{{ $order->order_number }}</div>
            <div style="font-size: 12px; color: #64748b; margin-top: 2px;">{{ date('d/m/Y H:i', strtotime($order->created_at)) }}</div>
        </div>
    </div>

    {{-- Tiêu đề phiếu --}}
    <div class="doc-title">
        <h1>PHIẾU ĐẶT CỌC XE & THU TIỀN MẶT</h1>
        <p>(Kèm theo đơn hàng số {{ $order->order_number }})</p>
    </div>

    {{-- Thông tin khách hàng & giao dịch --}}
    <div class="info-grid">
        <div>
            <div class="info-row">
                <span class="info-label">Họ tên khách hàng:</span>
                <span class="info-val">{{ $order->customer_name }}</span>
            </div>
            <div class="info-row">
                <span class="info-label">Số điện thoại:</span>
                <span class="info-val">{{ $order->customer_phone }}</span>
            </div>
            <div class="info-row">
                <span class="info-label">Email:</span>
                <span class="info-val">{{ $order->customer_email ?: 'Không cung cấp' }}</span>
            </div>
        </div>
        <div>
            <div class="info-row">
                <span class="info-label">Phương thức:</span>
                <span class="info-val">Tiền mặt tại Showroom</span>
            </div>
            <div class="info-row">
                <span class="info-label">Địa điểm thu:</span>
                <span class="info-val">Showroom Số 1 Bạch Đằng, Hải Phòng</span>
            </div>
            <div class="info-row">
                <span class="info-label">Trạng thái tiền:</span>
                <span class="info-val" style="color: {{ $order->payment_status === 'paid' ? '#16a34a' : '#d97706' }};">
                    {{ $order->payment_status === 'paid' ? 'ĐÃ THU ĐỦ TIỀN MẶT' : 'CHỜ NỘP TIỀN TẠI SHOWROOM' }}
                </span>
            </div>
        </div>
    </div>

    {{-- Bảng chi tiết dòng xe đặt cọc --}}
    <table>
        <thead>
            <tr>
                <th style="width: 50px; text-align: center;">STT</th>
                <th>Dòng Xe & Phiên Bản Đặt Cọc</th>
                <th style="width: 90px; text-align: center;">Số Lượng</th>
                <th style="width: 140px; text-align: right;">Đơn Giá</th>
                <th style="width: 150px; text-align: right;">Thành Tiền (VNĐ)</th>
            </tr>
        </thead>
        <tbody>
            @foreach($items as $idx => $item)
                <tr>
                    <td style="text-align: center;">{{ $idx + 1 }}</td>
                    <td>
                        <div style="font-weight: 700;">{{ $item->product_name }}</div>
                        @if($item->variant_name)
                            <div style="font-size: 12px; color: #64748b;">Phiên bản: {{ $item->variant_name }}</div>
                        @endif
                    </td>
                    <td style="text-align: center;">{{ $item->quantity }}</td>
                    <td style="text-align: right;">{{ number_format($item->unit_price, 0, ',', '.') }} đ</td>
                    <td style="text-align: right; font-weight: 700;">{{ number_format($item->line_total, 0, ',', '.') }} đ</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    {{-- Tổng tiền & số tiền bằng chữ --}}
    <div class="total-box">
        <div class="total-row">
            <span>TỔNG SỐ TIỀN THANH TOÁN (TIỀN MẶT):</span>
            <span style="font-size: 18px; color: #1464f4;">{{ number_format($order->total, 0, ',', '.') }} VNĐ</span>
        </div>
        <div class="total-words">
            Bằng chữ: <strong>{{ $totalInWords }}</strong>
        </div>
    </div>

    {{-- Chữ ký 3 bên --}}
    <div class="signatures">
        <div class="sig-col">
            <h4>Khách Hàng Đặt Cọc</h4>
            <p>(Ký và ghi rõ họ tên)</p>
            <div class="sig-name">{{ $order->customer_name }}</div>
        </div>
        <div class="sig-col">
            <h4>Nhân Viên Kinh Doanh</h4>
            <p>(Ký và ghi rõ họ tên)</p>
            <div class="sig-name">VinFast Minh Đạo</div>
        </div>
        <div class="sig-col">
            <h4>Thủ Quỹ Thu Tiền</h4>
            <p>(Ký và đóng dấu đã thu tiền)</p>
            <div class="sig-name">Showroom Hải Phòng</div>
        </div>
    </div>

    {{-- Chân trang ghi chú --}}
    <div class="footer-note">
        * Phiếu đặt cọc có hiệu lực xác nhận quyền ưu tiên nhận xe theo quy định của VinFast Việt Nam. Mọi thắc mắc xin vui lòng liên hệ Hotline CSKH 0988 302 882.
    </div>
</div>

</body>
</html>

