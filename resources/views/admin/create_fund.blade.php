@php
// Lấy ID cao nhất hiện tại cộng thêm 1 (Chắc chắn đúng 100% không sợ lệch ID)
$latestCampaign = \Illuminate\Support\Facades\DB::table('campaigns')->orderBy('id', 'desc')->first();
$nextId = $latestCampaign ? $latestCampaign->id + 1 : 1;
@endphp

<div id="tao-quy" class="page-section hidden p-8 fade-in">
    @if ($errors->any())
    <div class="max-w-5xl mx-auto mb-4 p-4 bg-rose-50 border border-slate-200 text-rose-600 rounded-lg">
        <ul class="list-disc pl-5 mb-0">
            @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    <form id="createFundForm" action="{{ route('admin.fund.store') }}" method="POST" enctype="multipart/form-data" class="max-w-5xl mx-auto flex flex-col lg:flex-row gap-8">
        @csrf
        <div class="flex-1 space-y-6">
            <div class="bg-white p-6 rounded-2xl shadow-sm border border-slate-100">
                <h2 class="text-lg font-bold text-slate-800 mb-4 border-b border-slate-100 pb-4">Thông tin chiến dịch</h2>
                <div class="space-y-4">
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-1">Tên quỹ <span class="text-rose-500">*</span></label>
                        <input type="text" name="title" placeholder="Nhập tên quỹ..." required class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-lg outline-none focus:border-indigo-500 text-sm">
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-1">Ví người thụ hưởng (ETH) <span class="text-rose-500">*</span></label>
                        <input type="text" name="receiver_wallet" placeholder="0x..." required class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-lg outline-none focus:border-indigo-500 text-sm font-mono">
                        <p class="text-xs text-slate-500 mt-1">Hệ thống sẽ chuyển tiền giải ngân vào địa chỉ ví này.</p>
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-slate-700 mb-1">Mục tiêu (ETH) <span class="text-rose-500">*</span></label>
                            <input type="number" name="goal_eth" step="0.01" min="0" placeholder="0.00" required class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-lg outline-none focus:border-indigo-500 text-sm">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-slate-700 mb-1">Danh mục</label>
                            <select name="category" class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-lg outline-none focus:border-indigo-500 text-sm">
                                <option value="Giáo dục">Giáo dục</option>
                                <option value="Y tế">Y tế</option>
                                <option value="Môi trường">Môi trường</option>
                            </select>
                        </div>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-1">Ngày kết thúc <span class="text-rose-500">*</span></label>
                        <input type="date" name="end_date" id="input_end_date" required class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-lg outline-none focus:border-indigo-500 text-sm">
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-1">Mô tả chi tiết</label>
                        <textarea name="description" rows="6" placeholder="Viết câu chuyện..." required class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-lg outline-none focus:border-indigo-500 text-sm"></textarea>
                    </div>
                </div>
            </div>
        </div>

        <div class="w-full lg:w-80 flex flex-col gap-6">
            <div class="bg-white p-6 rounded-2xl shadow-sm border border-slate-100">
                <h2 class="text-base font-bold text-slate-800 mb-4">Hình ảnh đại diện</h2>
                <label id="upload-area" class="flex flex-col items-center justify-center w-full h-40 border-2 border-slate-300 border-dashed rounded-xl cursor-pointer hover:border-indigo-400 bg-slate-50 transition-colors relative overflow-hidden">
                    
                    <img id="image-preview" src="" alt="Preview" class="absolute inset-0 w-full h-full object-cover hidden">
                    
                    <div id="upload-text" class="flex flex-col items-center">
                        <i class='bx bx-cloud-upload text-3xl text-indigo-400 mb-2'></i>
                        <span class="text-sm text-slate-500">Tải ảnh lên</span>
                    </div>

                    <input type="file" name="image" class="hidden" accept="image/*" onchange="previewImage(event)" />
                </label>
            </div>
            
            <div class="bg-white p-6 rounded-2xl shadow-sm border border-slate-100">
                <button id="btnSubmitForm" type="submit" class="w-full px-4 py-3 bg-indigo-600 text-white text-sm font-semibold rounded-lg hover:bg-indigo-700 transition-all flex items-center justify-center gap-2 mb-3">
                    <i class='bx bx-send'></i> Đăng Chiến Dịch
                </button>
            </div>
        </div>
    </form>
</div>

<script>
    // ================= HÀM XEM TRƯỚC ẢNH (PREVIEW) =================
    function previewImage(event) {
        const file = event.target.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                const preview = document.getElementById('image-preview');
                const uploadText = document.getElementById('upload-text');
                
                // Gắn đường dẫn ảo vào thẻ img và hiển thị lên
                preview.src = e.target.result;
                preview.classList.remove('hidden');
                
                // Ẩn icon upload đi
                uploadText.classList.add('hidden');
            }
            reader.readAsDataURL(file);
        }
    }

    // ================= XỬ LÝ BLOCKCHAIN VÀ SUBMIT FORM =================
    document.getElementById('btnSubmitForm').addEventListener('click', async function(e) {
        // Chặn luồng gửi dữ liệu mặc định để xử lý Web3 trước
        e.preventDefault();

        const formElement = document.getElementById('createFundForm');

        // Kiểm tra xem các ô bắt buộc (*) đã nhập đủ chưa
        if (!formElement.checkValidity()) {
            formElement.reportValidity();
            return;
        }

        const receiverWallet = document.querySelector('input[name="receiver_wallet"]').value;
        const goalEth = document.querySelector('input[name="goal_eth"]').value;
        const btnSubmit = document.getElementById('btnSubmitForm');

        // Lấy ngày kết thúc để kiểm tra tính hợp lệ trên giao diện
        const endDateValue = document.getElementById('input_end_date').value;
        const endDateObj = new Date(endDateValue);
        endDateObj.setHours(23, 59, 59, 999);
        const thoiGianKetThuc = Math.floor(endDateObj.getTime() / 1000);
        const currentTime = Math.floor(Date.now() / 1000);

        if (thoiGianKetThuc <= currentTime) {
            alert("Lỗi: Ngày kết thúc phải lớn hơn ngày hiện tại!");
            return;
        }

        if (typeof window.ethereum === 'undefined') {
            alert("Vui lòng cài đặt MetaMask trên trình duyệt để sử dụng quyền Admin!");
            return;
        }

        try {
            const provider = new ethers.BrowserProvider(window.ethereum);
            const signer = await provider.getSigner();

            const originalBtnHtml = btnSubmit.innerHTML;
            btnSubmit.innerHTML = "<i class='bx bx-loader-alt bx-spin'></i> Đang xác nhận Blockchain...";
            btnSubmit.disabled = true;

            const contractAddress = "{{ env('SMART_CONTRACT_ADDRESS', '0xE7d6c1468aeB1eff34635BaB283bd0120E7E774a') }}";

            // ABI tạo chiến dịch mới
            const contractABI = [{
                "inputs": [{
                        "internalType": "uint256",
                        "name": "_idTrenDatabase",
                        "type": "uint256"
                    },
                    {
                        "internalType": "address payable",
                        "name": "_nguoiNhanTien",
                        "type": "address"
                    },
                    {
                        "internalType": "uint256",
                        "name": "_mucTieuTien",
                        "type": "uint256"
                    }
                ],
                "name": "taoChienDich",
                "outputs": [],
                "stateMutability": "nonpayable",
                "type": "function"
            }];

            const contract = new ethers.Contract(contractAddress, contractABI, signer);

            const nextDatabaseId = parseInt("{{ $nextId }}");
            const mucTieuWei = ethers.parseEther(goalEth.toString());

            // GỌI SMART CONTRACT
            const tx = await contract.taoChienDich(nextDatabaseId, receiverWallet, mucTieuWei);

            btnSubmit.innerHTML = "<i class='bx bx-loader-alt bx-spin'></i> Đang xử lý Blockchain...";

            await tx.wait(); // Chờ đào block thành công

            // BƯỚC CUỐI: Submit form, lúc này Laravel sẽ nhận được toàn bộ Text và Ảnh
            formElement.submit();

        } catch (error) {
            console.error(error);
            btnSubmit.innerHTML = "<i class='bx bx-send'></i> Đăng Chiến Dịch";
            btnSubmit.disabled = false;

            if (error.code === 'ACTION_REJECTED' || error.code === 4001) {
                alert("Admin đã hủy giao dịch trên ví MetaMask.");
            } else {
                alert("Lỗi: " + (error.reason || "Bạn không phải là Admin hoặc thông số không hợp lệ."));
            }
        }
    });
</script>