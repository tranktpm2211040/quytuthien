<div id="edit-quy" class="page-section hidden p-8 fade-in">
    <form action="{{ route('admin.fund.update') }}" method="POST" enctype="multipart/form-data" class="max-w-5xl mx-auto flex flex-col lg:flex-row gap-8">
        @csrf
        <input type="hidden" name="id" id="edit-fund-id">

        <div class="flex-1 space-y-6">
            <div class="bg-white p-6 rounded-2xl shadow-sm border border-slate-100">
                <h2 class="text-lg font-bold text-slate-800 mb-4 border-b border-slate-100 pb-4">Cập nhật chiến dịch</h2>
                <div class="space-y-4">
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-1">Tên quỹ <span class="text-rose-500">*</span></label>
                        <input type="text" name="title" id="edit-fund-title" required class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-lg outline-none focus:border-indigo-500 text-sm">
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-1">Ví người thụ hưởng (ETH) <span class="text-rose-500">*</span></label>
                        <input type="text" name="receiver_wallet" id="edit-fund-wallet" required class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-lg outline-none focus:border-indigo-500 text-sm font-mono">
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-slate-700 mb-1">Mục tiêu (ETH) <span class="text-rose-500">*</span></label>
                            <input type="number" name="goal_eth" id="edit-fund-goal" step="0.01" min="0" required class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-lg outline-none focus:border-indigo-500 text-sm">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-slate-700 mb-1">Danh mục</label>
                            <select name="category" id="edit-fund-category" class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-lg outline-none focus:border-indigo-500 text-sm">
                                <option value="Giáo dục">Giáo dục</option>
                                <option value="Y tế">Y tế</option>
                                <option value="Môi trường">Môi trường</option>
                            </select>
                        </div>
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-slate-700 mb-1">Ngày kết thúc <span class="text-rose-500">*</span></label>
                            <input type="date" name="end_date" id="edit-fund-end-date" required class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-lg outline-none focus:border-indigo-500 text-sm">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-slate-700 mb-1">Trạng thái</label>
                            <select name="status" id="edit-fund-status" class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-lg outline-none focus:border-indigo-500 text-sm">
                                <option value="1">Đang hoạt động</option>
                                <option value="2">Hoàn thành</option>
                                <option value="0">Bản nháp</option>
                            </select>
                        </div>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-1">Mô tả chi tiết</label>
                        <textarea name="description" id="edit-fund-desc" rows="5" class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-lg outline-none focus:border-indigo-500 text-sm"></textarea>
                    </div>
                </div>
            </div>
        </div>

        <div class="w-full lg:w-80 flex flex-col gap-6">
            <div class="bg-white p-6 rounded-2xl shadow-sm border border-slate-100">
                <h2 class="text-base font-bold text-slate-800 mb-4">Hình ảnh đại diện</h2>
                <label class="flex flex-col items-center justify-center w-full h-40 border-2 border-slate-300 border-dashed rounded-xl cursor-pointer hover:border-indigo-400 bg-slate-50 transition-colors relative overflow-hidden group">

                    <div id="edit-upload-text" class="flex flex-col items-center z-10 transition-all duration-300 group-hover:scale-105">
                        <i class='bx bx-cloud-upload text-3xl text-indigo-400 mb-2'></i>
                        <span class="text-sm text-slate-500 font-medium">Đổi ảnh mới</span>
                    </div>

                    <img id="edit-image-preview" src="" alt="Preview" class="absolute inset-0 w-full h-full object-cover hidden pointer-events-none z-20 transition-all duration-300 group-hover:filter group-hover:blur-[2px] group-hover:scale-105">

                    <div id="edit-overlay" class="absolute inset-0 flex flex-col items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity duration-300 hidden z-30 pointer-events-none">
                        <div class="bg-indigo-600 px-3 py-1 rounded-full flex items-center justify-center gap-1.5 shadow-lg group-hover:scale-105">
                            <i class='bx bx-refresh text-lg text-white'></i>
                            <span class="text-xs text-white font-semibold">Bấm để đổi ảnh</span>
                        </div>
                    </div>

                    <input type="file" name="image" class="hidden" accept="image/*" onchange="previewEditImage(event)" />
                </label>
            </div>
            <div class="bg-white p-6 rounded-2xl shadow-sm border border-slate-100">
                <button type="submit" class="w-full px-4 py-3 bg-indigo-600 text-white text-sm font-semibold rounded-lg hover:bg-indigo-700 transition-all flex items-center justify-center gap-2 mb-3">
                    <i class='bx bx-save'></i> Cập nhật Chiến Dịch
                </button>
                <button type="button" onclick="switchTab('quan-ly', document.querySelectorAll('.nav-item')[1])" class="w-full px-4 py-3 bg-white border border-slate-200 text-slate-600 text-sm font-semibold rounded-lg hover:bg-slate-50 transition-all flex items-center justify-center gap-2">
                    Hủy bỏ
                </button>
            </div>
        </div>
    </form>
</div>

<script>
    function previewEditImage(event) {
        const file = event.target.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                const preview = document.getElementById('edit-image-preview');
                const uploadText = document.getElementById('edit-upload-text');
                const overlay = document.getElementById('edit-overlay');

                preview.src = e.target.result;
                preview.classList.remove('hidden');
                uploadText.classList.add('hidden');
                overlay.classList.remove('hidden');
            }
            reader.readAsDataURL(file);
        }
    }

    function openEditTab(btn) {
        document.getElementById('edit-fund-id').value = btn.getAttribute('data-id');
        document.getElementById('edit-fund-title').value = btn.getAttribute('data-title');
        document.getElementById('edit-fund-goal').value = btn.getAttribute('data-goal');
        document.getElementById('edit-fund-category').value = btn.getAttribute('data-category');
        document.getElementById('edit-fund-status').value = btn.getAttribute('data-status');
        document.getElementById('edit-fund-desc').value = btn.getAttribute('data-desc');
        document.getElementById('edit-fund-wallet').value = btn.getAttribute('data-wallet');
        document.getElementById('edit-fund-end-date').value = btn.getAttribute('data-enddate');

        // ĐÃ THÊM: Bắt link ảnh cũ và hiển thị
        const imageUrl = btn.getAttribute('data-image');
        const preview = document.getElementById('edit-image-preview');
        const uploadText = document.getElementById('edit-upload-text');
        const overlay = document.getElementById('edit-overlay');

        if (imageUrl && imageUrl.trim() !== '') {
            // Nếu có ảnh cũ -> Hiện ảnh, giấu chữ "Đổi ảnh mới", bật hiệu ứng hover
            preview.src = imageUrl;
            preview.classList.remove('hidden');
            uploadText.classList.add('hidden');
            if (overlay) overlay.classList.remove('hidden');
        } else {
            // Nếu không có ảnh cũ -> Reset về trạng thái trống
            preview.src = "";
            preview.classList.add('hidden');
            uploadText.classList.remove('hidden');
            if (overlay) overlay.classList.add('hidden');
        }

        if (typeof switchTab === 'function') {
            switchTab('edit-quy', null);
            document.getElementById('header-title').innerText = "Chỉnh sửa Quỹ Từ Thiện";
            document.getElementById('header-subtitle').innerText = "Cập nhật lại thông tin chiến dịch đã chọn";
        }
    }
</script>