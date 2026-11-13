{{-- Modal Báo Giá Lăn Bánh --}}
<div id="vf-quote-modal" class="vinfast-autohaiphong_modal_wrapper" style="display: none; position: fixed; inset: 0; background-color: rgba(15,23,42,0.6); z-index: 999; align-items: center; justify-content: center; padding: 16px;">
    <div class="vinfast-autohaiphong_modal_box" style="background: #ffffff; border-radius: 8px; max-width: 480px; width: 100%; border: 1px solid var(--client-color-border); box-shadow: 0 10px 25px -5px rgba(0,0,0,0.15); overflow: hidden; position: relative;">
        {{-- Header Modal --}}
        <div class="vinfast-autohaiphong_modal_header" style="background-color: var(--client-color-primary); color: #ffffff; padding: 16px 20px; display: flex; justify-content: space-between; align-items: center;">
            <div>
                <h3 class="vinfast-autohaiphong_modal_title" style="font-size: 1.15rem; font-weight: 700; margin: 0; letter-spacing: -0.2px;">YÊU CẦU BÁO GIÁ LĂN BÁNH</h3>
                <p class="vinfast-autohaiphong_modal_subtitle" style="font-size: 0.825rem; margin-top: 2px; opacity: 0.9;" id="vf-modal-car-display">Dòng xe VinFast</p>
            </div>
            <button type="button" onclick="closeQuoteModal()" class="vinfast-autohaiphong_modal_close" style="background: none; border: none; color: #ffffff; font-size: 1.4rem; cursor: pointer; line-height: 1;">✕</button>
        </div>

        {{-- Form Body --}}
        <form action="{{ route('client.leads.store') }}" method="POST" class="vinfast-autohaiphong_modal_form" style="padding: 20px;" onsubmit="const btn = this.querySelector('button[type=submit]'); btn.disabled = true; btn.textContent = 'Đang gửi yêu cầu...';">
            @csrf
            <input type="hidden" name="type" value="quote">
            <input type="hidden" name="product_id" id="vf-quote-car-id" value="">
            <input type="hidden" name="message" id="vf-quote-car-name" value="">

            <div class="vinfast-autohaiphong_modal_form_group" style="margin-bottom: 14px;">
                <label class="vinfast-autohaiphong_modal_form_label" style="display: block; font-size: 0.85rem; font-weight: 600; margin-bottom: 4px; color: var(--client-color-heading);">Họ và tên của bạn <span style="color: #dc2626;">*</span></label>
                <input type="text" name="name" required placeholder="Nguyễn Văn A" class="vinfast-autohaiphong_modal_form_input" style="width: 100%; padding: 9px 12px; border: 1px solid var(--client-color-border); border-radius: 4px; font-size: 0.9rem; outline: none;">
            </div>

            <div class="vinfast-autohaiphong_modal_form_group" style="margin-bottom: 14px;">
                <label class="vinfast-autohaiphong_modal_form_label" style="display: block; font-size: 0.85rem; font-weight: 600; margin-bottom: 4px; color: var(--client-color-heading);">Số điện thoại liên hệ <span style="color: #dc2626;">*</span></label>
                <input type="tel" name="phone" required placeholder="09xx xxx xxx" class="vinfast-autohaiphong_modal_form_input" style="width: 100%; padding: 9px 12px; border: 1px solid var(--client-color-border); border-radius: 4px; font-size: 0.9rem; outline: none;">
            </div>

            <div class="vinfast-autohaiphong_modal_form_group" style="margin-bottom: 14px;">
                <label class="vinfast-autohaiphong_modal_form_label" style="display: block; font-size: 0.85rem; font-weight: 600; margin-bottom: 4px; color: var(--client-color-heading);">Khu vực đăng ký biển số</label>
                <select name="registration_area" class="vinfast-autohaiphong_modal_form_select" style="width: 100%; padding: 9px 12px; border: 1px solid var(--client-color-border); border-radius: 4px; font-size: 0.9rem; background: #ffffff;">
                    <option value="Hải Phòng">Hải Phòng</option>
                    <option value="Hà Nội">Hà Nội</option>
                    <option value="Quảng Ninh">Quảng Ninh</option>
                    <option value="Hải Dương">Hải Dương</option>
                    <option value="Thái Bình">Thái Bình</option>
                    <option value="Tỉnh thành khác">Tỉnh thành khác</option>
                </select>
            </div>

            <div class="vinfast-autohaiphong_modal_form_consent" style="margin-bottom: 18px; font-size: 0.8rem; color: var(--client-color-muted); display: flex; align-items: flex-start; gap: 8px;">
                <input type="checkbox" required id="consent-check" checked style="margin-top: 2px;">
                <label for="consent-check">Tôi đồng ý nhận thông tin bảng giá lăn bánh và chính sách ưu đãi từ VinFast Minh Đạo Hải Phòng.</label>
            </div>

            <button type="submit" class="vinfast-autohaiphong_btn vinfast-autohaiphong_btn_primary" style="width: 100%; padding: 11px; font-size: 0.95rem;">
                Gửi Yêu Cầu Báo Giá
            </button>
        </form>
    </div>
</div>
