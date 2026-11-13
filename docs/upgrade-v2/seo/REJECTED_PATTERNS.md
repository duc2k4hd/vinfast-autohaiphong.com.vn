# CÁC MẪU SEO BỊ TỪ CHỐI (REJECTED PATTERNS)

Qua quá trình rà soát mã nguồn `nobifashion.vn`, một số mẫu triển khai KHÔNG phù hợp với website VinFast Hải Phòng và bị từ chối áp dụng:

1. **Từ Chối Đổi Schema Sang Thương Mại Điện Tử Thông Thường (`Product` Quần Áo):**
   - *Lý do:* Nobi Fashion là website bán lẻ thời trang với các thuộc tính size, màu vải, giỏ hàng online. Trong khi VinFast Hải Phòng là **Đại lý ủy quyền phân phối xe ô tô 3S**. Schema bắt buộc phải là `AutoDealer` cho Showroom và `Car` cho từng mẫu xe ô tô điện (với thuộc tính `brand: VinFast`, `priceCurrency: VND`, `availability`).
2. **Từ Chối Các Thẻ Meta Tracking/Mã Nhúng Không Cần Thiết:**
   - Trong `nobifashion.vn` có các mã nhúng như `dmca-site-verification` cụ thể của bên họ hoặc các script chat bên thứ ba. Tuyệt đối không sao chép những mã nhúng riêng tư này.
3. **Từ Chối Fake Review / Rating Schema:**
   - Không khai báo dữ liệu đánh giá sao giả mạo (`aggregateRating`) nếu website chưa có hệ thống đánh giá thực tế từ khách hàng thật, tuân thủ nguyên tắc chống gian lận dữ liệu có cấu trúc của Google Search Central.

