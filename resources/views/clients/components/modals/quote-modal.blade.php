{{-- Modal Báo Giá Lăn Bánh --}}
<div id="vf-quote-modal" class="vinfast-autohaiphong_modal_wrapper" style="display: none; position: fixed; inset: 0; background-color: rgba(0,0,0,0.65); z-index: 999; align-items: center; justify-content: center; padding: 16px;">
    <div class="vinfast-autohaiphong_modal_box" style="background: #ffffff; border-radius: 12px; max-width: 500px; width: 100%; box-shadow: 0 20px 25px -5px rgba(0,0,0,0.2); overflow: hidden; position: relative;">
        {{-- Header Modal --}}
        <div class="vinfast-autohaiphong_modal_header" style="background-color: var(--client-color-primary); color: #ffffff; padding: 18px 24px; display: flex; justify-content: space-between; align-items: center;">
            <div>
                <h3 class="vinfast-autohaiphong_modal_title" style="font-size: 1.25rem; font-weight: 700; margin: 0;">YÊU CẦU BÁO GIÁ LĂN BÁNH</h3>
                <p class="vinfast-autohaiphong_modal_subtitle" style="font-size: 0.85rem; margin-top: 4px; opacity: 0.9;" id="vf-modal-car-display">Dòng xe VinFast</p>
            </div>
            <button type="button" onclick="closeQuoteModal()" class="vinfast-autohaiphong_modal_close" style="background: none; border: none; color: #ffffff; font-size: 1.5rem; cursor: pointer; line-height: 1;">✕</button>
        </div>

        {{-- Form Body --}}
        <form action="{{ route('client.leads.store') }}" method="POST" class="vinfast-autohaiphong_modal_form" style="padding: 24px;">
            @csrf
            <input type="hidden" name="type" value="quote">
            <input type="hidden" name="product_id" id="vf-quote-car-id" value="">
            <input type="hidden" name="message" id="vf-quote-car-name" value="">

            <div class="vinfast-autohaiphong_modal_form_group" style="margin-bottom: 16px;">
                <label class="vinfast-autohaiphong_modal_form_label" style="display: block; font-size: 0.9rem; font-weight: 600; margin-bottom: 6px;">Họ và tên của bạn <span style="color: #dc2626;">*</span></label>
                <input type="text" name="name" required placeholder="Nguyễn Văn A" class="vinfast-autohaiphong_modal_form_input" style="width: 100%; padding: 10px 14px; border: 1px solid var(--client-color-border); border-radius: 6px; font-size: 0.95rem;">
            </div>

            <div class="vinfast-autohaiphong_modal_form_group" style="margin-bottom: 16px;">
                <label class="vinfast-autohaiphong_modal_form_label" style="display: block; font-size: 0.9rem; font-weight: 600; margin-bottom: 6px;">Số điện thoại liên hệ <span style="color: #dc2626;">*</span></label>
                <input type="tel" name="phone" required placeholder="09xx xxx xxx" class="vinfast-autohaiphong_modal_form_input" style="width: 100%; padding: 10px 14px; border: 1px solid var(--client-color-border); border-radius: 6px; font-size: 0.95rem;">
            </div>

            <div class="vinfast-autohaiphong_modal_form_group" style="margin-bottom: 16px;">
                <label class="vinfast-autohaiphong_modal_form_label" style="display: block; font-size: 0.9rem; font-weight: 600; margin-bottom: 6px;">Khu vực đăng ký biển số</label>
                <select name="registration_area" class="vinfast-autohaiphong_modal_form_select" style="width: 100%; padding: 10px 14px; border: 1px solid var(--client-color-border); border-radius: 6px; font-size: 0.95rem; background: #ffffff;">
                    <option value="Hải Phòng">Hải Phòng</option>
                    <option value="Hà Nội">Hà Nội</option>
                    <option value="Quảng Ninh">Quảng Ninh</option>
                    <option value="Hải Dương">Hải Dương</option>
                    <option value="Thái Bình">Thái Bình</option>
                    <option value="Tỉnh thành khác">Tỉnh thành khác</option>
                </select>
            </div>

            <div class="vinfast-autohaiphong_modal_form_consent" style="margin-bottom: 20px; font-size: 0.85rem; color: var(--client-color-muted); display: flex; align-items: flex-start; gap: 8px;">
                <input type="checkbox" required id="consent-check" checked style="margin-top: 3px;">
                <label for="consent-check">Tôi đồng ý nhận thông tin bảng giá lăn bánh và chính sách ưu đãi từ VinFast Hải Phòng.</label>
            </div>

            <button type="submit" class="vinfast-autohaiphong_btn vinfast-autohaiphong_btn_accent" style="width: 100%; padding: 12px; font-size: 1rem;">
                GỬI YÊU CẦU NGAY
            </button>
        </form>
    </div>
</div>
