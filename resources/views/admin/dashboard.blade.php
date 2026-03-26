<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Admin - Quản lý Quỹ Từ Thiện</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/ethers/5.7.2/ethers.umd.min.js"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <style>
        body { font-family: 'Inter', sans-serif; }
        /* Hiệu ứng mượt mà khi chuyển tab */
        .fade-in { animation: fadeIn 0.4s ease-out forwards; opacity: 0; }
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(10px); }
            to { opacity: 1; transform: translateY(0); }
        }
        .delay-100 { animation-delay: 100ms; }
        
        /* Tùy chỉnh thanh cuộn */
        ::-webkit-scrollbar { width: 6px; height: 6px; }
        ::-webkit-scrollbar-track { background: #f1f5f9; }
        ::-webkit-scrollbar-thumb { background: #cbd5e1; border-radius: 10px; }
        ::-webkit-scrollbar-thumb:hover { background: #94a3b8; }
    </style>
</head>
<body class="bg-slate-50 flex h-screen overflow-hidden text-slate-800">

    <aside class="w-72 bg-[#0f172a] text-slate-300 flex flex-col transition-all duration-300 shadow-2xl z-20">
        <div class="h-20 flex items-center px-8 border-b border-slate-700/50">
            <i class='bx bxs-donate-heart text-3xl text-indigo-500 mr-3'></i>
            <span class="text-xl font-bold text-white tracking-wide">GiveNow Admin</span>
        </div>

        <nav class="flex-1 px-4 py-6 space-y-2 overflow-y-auto" id="sidebar-menu">
            <a href="#" onclick="switchTab('dashboard', this)" class="nav-item flex items-center px-4 py-3 bg-gradient-to-r from-indigo-500 to-purple-600 text-white rounded-xl shadow-lg shadow-indigo-500/30 transition-all hover:scale-[1.02]">
                <i class='bx bxs-dashboard text-xl mr-3'></i>
                <span class="font-medium">Tổng quan</span>
            </a>
            
            <a href="#" onclick="switchTab('quan-ly', this)" class="nav-item flex items-center px-4 py-3 rounded-xl hover:bg-slate-800 hover:text-white transition-colors group">
                <i class='bx bx-wallet text-xl mr-3 group-hover:text-indigo-400 transition-colors'></i>
                <span class="font-medium">Quản lý Quỹ</span>
            </a>

            <a href="#" onclick="switchTab('lich-su', this)" class="nav-item flex items-center px-4 py-3 rounded-xl hover:bg-slate-800 hover:text-white transition-colors group">
                <i class='bx bx-history text-xl mr-3 group-hover:text-indigo-400 transition-colors'></i>
                <span class="font-medium">Lịch sử quyên góp</span>
            </a>

            <div class="pt-4 mt-4 border-t border-slate-700/50">
                <a href="#" onclick="switchTab('tao-quy', this)" class="nav-item flex items-center px-4 py-3 rounded-xl border border-slate-600 border-dashed hover:border-indigo-400 hover:bg-slate-800 hover:text-indigo-300 transition-all group">
                    <i class='bx bx-plus-circle text-xl mr-3 group-hover:text-indigo-400'></i>
                    <span class="font-medium">Tạo Quỹ Mới</span>
                </a>
            </div>
        </nav>

        <div class="p-4 border-t border-slate-700/50">
            <button onclick="handleLogout()" class="w-full flex items-center justify-center px-4 py-3 bg-rose-500/10 text-rose-400 rounded-xl hover:bg-rose-500 hover:text-white transition-all duration-300">
                <i class='bx bx-log-out text-xl mr-2'></i>
                <span class="font-medium">Đăng xuất</span>
            </button>
        </div>
    </aside>

    <main class="flex-1 flex flex-col h-screen overflow-hidden relative">
        <header class="h-20 bg-white shadow-sm flex items-center justify-between px-8 z-10 shrink-0">
            <div>
                <h1 id="header-title" class="text-2xl font-bold text-slate-800">Tổng quan hệ thống</h1>
                <p id="header-subtitle" class="text-sm text-slate-500 mt-1">Theo dõi tiến độ và các khoản quyên góp</p>
            </div>
            
            <div class="flex items-center gap-4">
                <button class="w-10 h-10 rounded-full bg-slate-100 flex items-center justify-center hover:bg-slate-200 transition-colors relative">
                    <i class='bx bx-bell text-xl text-slate-600'></i>
                    <span class="absolute top-2 right-2 w-2 h-2 bg-rose-500 rounded-full"></span>
                </button>
                <div class="flex items-center gap-3 pl-4 border-l border-slate-200">
                    <div class="w-10 h-10 rounded-full bg-indigo-100 border-2 border-indigo-500 flex items-center justify-center text-indigo-700 font-bold">AD</div>
                    <div class="hidden md:block">
                        <p class="text-sm font-semibold text-slate-700">Admin</p>
                        <p class="text-xs text-slate-500">Quản trị viên</p>
                    </div>
                </div>
            </div>
        </header>

        <div class="flex-1 overflow-y-auto relative">

            <div id="dashboard" class="page-section p-8">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8 fade-in">
                    <div class="bg-white p-6 rounded-2xl shadow-sm border border-slate-100">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-sm font-medium text-slate-500 mb-1">Tổng Quyên Góp (ETH)</p>
                                <h3 class="text-3xl font-bold text-slate-800">14.5</h3>
                            </div>
                            <div class="w-12 h-12 rounded-full bg-emerald-100 flex items-center justify-center text-emerald-600">
                                <i class='bx bx-trending-up text-2xl'></i>
                            </div>
                        </div>
                    </div>
                    <div class="bg-white p-6 rounded-2xl shadow-sm border border-slate-100">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-sm font-medium text-slate-500 mb-1">Quỹ Đang Hoạt Động</p>
                                <h3 class="text-3xl font-bold text-slate-800">08</h3>
                            </div>
                            <div class="w-12 h-12 rounded-full bg-blue-100 flex items-center justify-center text-blue-600">
                                <i class='bx bx-heart text-2xl'></i>
                            </div>
                        </div>
                    </div>
                    <div class="bg-white p-6 rounded-2xl shadow-sm border border-slate-100">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-sm font-medium text-slate-500 mb-1">Lượt Giao Dịch</p>
                                <h3 class="text-3xl font-bold text-slate-800">1,245</h3>
                            </div>
                            <div class="w-12 h-12 rounded-full bg-purple-100 flex items-center justify-center text-purple-600">
                                <i class='bx bx-transfer-alt text-2xl'></i>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="bg-white p-6 rounded-2xl shadow-sm border border-slate-100 fade-in delay-100">
                    <div class="flex justify-between items-center mb-6">
                        <h2 class="text-lg font-bold text-slate-800">Thống kê mục tiêu các quỹ</h2>
                    </div>
                    <div class="relative h-[400px] w-full">
                        <canvas id="fundChart"></canvas>
                    </div>
                </div>
            </div>

            <div id="quan-ly" class="page-section hidden p-8 fade-in">
                <div class="flex justify-between items-center mb-6">
                    <div class="relative w-72">
                        <i class='bx bx-search absolute left-3 top-1/2 transform -translate-y-1/2 text-slate-400'></i>
                        <input type="text" placeholder="Tìm kiếm quỹ..." class="w-full pl-10 pr-4 py-2 border border-slate-200 rounded-lg focus:border-indigo-500 outline-none text-sm">
                    </div>
                    <button onclick="switchTab('tao-quy', document.querySelectorAll('.nav-item')[3])" class="px-5 py-2.5 bg-indigo-600 text-white text-sm font-medium rounded-lg hover:bg-indigo-700 transition-all flex items-center gap-2">
                        <i class='bx bx-plus'></i> Tạo Quỹ Mới
                    </button>
                </div>
                
                <div class="bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden">
                    <table class="w-full text-left whitespace-nowrap">
                        <thead class="bg-slate-50 border-b border-slate-100 text-xs text-slate-500 uppercase">
                            <tr>
                                <th class="px-6 py-4">Tên Quỹ</th>
                                <th class="px-6 py-4">Tiến độ (ETH)</th>
                                <th class="px-6 py-4">Trạng thái</th>
                                <th class="px-6 py-4 text-center">Hành động</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100">
                            <tr class="hover:bg-slate-50 group">
                                <td class="px-6 py-4 font-semibold text-slate-800">Xây Trường Vùng Cao</td>
                                <td class="px-6 py-4">
                                    <div class="flex justify-between text-xs mb-1"><span class="text-indigo-600">3.5 ETH</span><span class="text-slate-500">/ 5.0 ETH</span></div>
                                    <div class="w-40 h-2 bg-slate-100 rounded-full"><div class="bg-indigo-500 h-full rounded-full" style="width: 70%"></div></div>
                                </td>
                                <td class="px-6 py-4"><span class="px-3 py-1 text-xs rounded-full bg-emerald-100 text-emerald-700">Đang hoạt động</span></td>
                                <td class="px-6 py-4 text-center">
                                    <button class="text-slate-400 hover:text-blue-600 mx-1"><i class='bx bx-edit text-xl'></i></button>
                                    <button class="text-slate-400 hover:text-rose-600 mx-1"><i class='bx bx-trash text-xl'></i></button>
                                </td>
                            </tr>
                            <tr class="hover:bg-slate-50 group">
                                <td class="px-6 py-4 font-semibold text-slate-800">Quỹ Y Tế Cộng Đồng</td>
                                <td class="px-6 py-4">
                                    <div class="flex justify-between text-xs mb-1"><span class="text-emerald-600">10.0 ETH</span><span class="text-slate-500">/ 10.0 ETH</span></div>
                                    <div class="w-40 h-2 bg-slate-100 rounded-full"><div class="bg-emerald-500 h-full rounded-full" style="width: 100%"></div></div>
                                </td>
                                <td class="px-6 py-4"><span class="px-3 py-1 text-xs rounded-full bg-blue-100 text-blue-700">Hoàn thành</span></td>
                                <td class="px-6 py-4 text-center">
                                    <button class="text-slate-400 hover:text-blue-600 mx-1"><i class='bx bx-edit text-xl'></i></button>
                                    <button class="text-slate-400 hover:text-rose-600 mx-1"><i class='bx bx-trash text-xl'></i></button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

            <div id="lich-su" class="page-section hidden p-8 fade-in">
                <div class="bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden">
                    <div class="p-6 border-b border-slate-100">
                        <h2 class="text-lg font-bold text-slate-800">Giao dịch gần đây</h2>
                    </div>
                    <table class="w-full text-left whitespace-nowrap">
                        <thead class="bg-slate-50 border-b border-slate-100 text-xs text-slate-500 uppercase">
                            <tr>
                                <th class="px-6 py-4">Mã Ví (Wallet)</th>
                                <th class="px-6 py-4">Số lượng</th>
                                <th class="px-6 py-4">Quỹ ủng hộ</th>
                                <th class="px-6 py-4">Thời gian</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100 text-sm">
                            <tr class="hover:bg-slate-50">
                                <td class="px-6 py-4 font-mono text-slate-600">0x71C...9A23</td>
                                <td class="px-6 py-4 font-bold text-emerald-600">+ 0.5 ETH</td>
                                <td class="px-6 py-4 text-slate-800">Xây Trường Vùng Cao</td>
                                <td class="px-6 py-4 text-slate-500">10 phút trước</td>
                            </tr>
                            <tr class="hover:bg-slate-50">
                                <td class="px-6 py-4 font-mono text-slate-600">0x33A...4F11</td>
                                <td class="px-6 py-4 font-bold text-emerald-600">+ 1.2 ETH</td>
                                <td class="px-6 py-4 text-slate-800">Quỹ Y Tế Cộng Đồng</td>
                                <td class="px-6 py-4 text-slate-500">2 giờ trước</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

            <div id="tao-quy" class="page-section hidden p-8 fade-in">
                <form action="#" class="max-w-5xl mx-auto flex flex-col lg:flex-row gap-8">
                    <div class="flex-1 space-y-6">
                        <div class="bg-white p-6 rounded-2xl shadow-sm border border-slate-100">
                            <h2 class="text-lg font-bold text-slate-800 mb-4 border-b border-slate-100 pb-4">Thông tin chiến dịch</h2>
                            <div class="space-y-4">
                                <div>
                                    <label class="block text-sm font-medium text-slate-700 mb-1">Tên quỹ <span class="text-rose-500">*</span></label>
                                    <input type="text" placeholder="Nhập tên quỹ..." class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-lg outline-none focus:border-indigo-500 text-sm">
                                </div>
                                <div class="grid grid-cols-2 gap-4">
                                    <div>
                                        <label class="block text-sm font-medium text-slate-700 mb-1">Mục tiêu (ETH) <span class="text-rose-500">*</span></label>
                                        <input type="number" placeholder="0.00" class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-lg outline-none focus:border-indigo-500 text-sm">
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-slate-700 mb-1">Danh mục</label>
                                        <select class="w-full px-4 py-2.5 bg-slate-50 border border-slate-200 rounded-lg outline-none focus:border-indigo-500 text-sm">
                                            <option>Giáo dục</option>
                                            <option>Y tế</option>
                                            <option>Môi trường</option>
                                        </select>
                                    </div>
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-slate-700 mb-1">Mô tả chi tiết</label>
                                    <textarea rows="6" placeholder="Viết câu chuyện..." class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-lg outline-none focus:border-indigo-500 text-sm"></textarea>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="w-full lg:w-80 flex flex-col gap-6">
                        <div class="bg-white p-6 rounded-2xl shadow-sm border border-slate-100">
                            <h2 class="text-base font-bold text-slate-800 mb-4">Hình ảnh đại diện</h2>
                            <label class="flex flex-col items-center justify-center w-full h-40 border-2 border-slate-300 border-dashed rounded-xl cursor-pointer hover:border-indigo-400 bg-slate-50 transition-colors">
                                <i class='bx bx-cloud-upload text-3xl text-indigo-400 mb-2'></i>
                                <span class="text-sm text-slate-500">Tải ảnh lên</span>
                                <input type="file" class="hidden" accept="image/*" />
                            </label>
                        </div>
                        <div class="bg-white p-6 rounded-2xl shadow-sm border border-slate-100">
                            <button type="button" onclick="alert('Chiến dịch đã được đăng thành công!')" class="w-full px-4 py-3 bg-indigo-600 text-white text-sm font-semibold rounded-lg hover:bg-indigo-700 transition-all flex items-center justify-center gap-2 mb-3">
                                <i class='bx bx-send'></i> Đăng Chiến Dịch
                            </button>
                        </div>
                    </div>
                </form>
            </div>

        </div>
    </main>

    <script>
        // Hàm xử lý quyên góp với MetaMask
        async function handleDonation(campaignId, amountInEth) {
            if (typeof window.ethereum !== 'undefined') {
                try {
                    // 1. Kết nối ví MetaMask
                    const provider = new ethers.providers.Web3Provider(window.ethereum);
                    await provider.send("eth_requestAccounts", []);
                    const signer = provider.getSigner();
                    const userWallet = await signer.getAddress();

                    // 2. Thông tin Smart Contract
                    const contractAddress = "ĐỊA_CHỈ_SMART_CONTRACT_CỦA_BẠN";
                    // ABI là mảng JSON bạn lấy được sau khi compile code Solidity
                    const contractABI = [
                        "function donate(uint256 _campaignId) public payable"
                    ];
                    const contract = new ethers.Contract(contractAddress, contractABI, signer);

                    // 3. Thực hiện giao dịch chuyển ETH
                    const amountWei = ethers.utils.parseEther(amountInEth.toString());
                    const tx = await contract.donate(campaignId, { value: amountWei });
                    
                    console.log("Đang chờ xác nhận giao dịch trên Blockchain...");
                    const receipt = await tx.wait(); // Đợi giao dịch đào xong
                    
                    // 4. Lấy TxHash và gửi về Backend Laravel để lưu Database
                    const txHash = receipt.transactionHash;
                    await saveToDatabase(campaignId, userWallet, amountInEth, txHash);

                } catch (error) {
                    console.error("Lỗi giao dịch:", error);
                    alert("Giao dịch bị hủy hoặc xảy ra lỗi!");
                }
            } else {
                alert("Vui lòng cài đặt ví MetaMask!");
            }
        }

        // Hàm gọi API Backend để lưu dữ liệu
        async function saveToDatabase(campaignId, wallet, amount, txHash) {
            // Gọi route api của Laravel
            const response = await fetch('/api/donations/save', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content') // Dành cho web nội bộ
                },
                body: JSON.stringify({
                    campaign_id: campaignId,
                    wallet_address: wallet,
                    amount: amount,
                    tx_hash: txHash
                })
            });

            if (response.ok) {
                alert("Quyên góp thành công! Cảm ơn bạn.");
                window.location.reload(); // Load lại trang để cập nhật thanh tiến độ
            }
        }

        // 1. Logic chuyển Tab (Menu)
        function switchTab(tabId, element) {
            // Xóa trạng thái active của tất cả menu
            const navItems = document.querySelectorAll('.nav-item');
            navItems.forEach(item => {
                // Đưa về trạng thái bình thường (xám)
                item.className = "nav-item flex items-center px-4 py-3 rounded-xl hover:bg-slate-800 hover:text-white transition-colors group";
                const icon = item.querySelector('i');
                if(icon) icon.className = icon.className.replace('text-white', 'group-hover:text-indigo-400').replace('bxs-', 'bx-');
            });

            // Gắn trạng thái active cho menu được click
            if(element) {
                element.className = "nav-item flex items-center px-4 py-3 bg-gradient-to-r from-indigo-500 to-purple-600 text-white rounded-xl shadow-lg shadow-indigo-500/30 transition-all hover:scale-[1.02]";
                const activeIcon = element.querySelector('i');
                if(activeIcon) activeIcon.className = activeIcon.className.replace('group-hover:text-indigo-400', 'text-white').replace('bx-', 'bxs-');
            }

            // Ẩn tất cả các trang
            const pages = document.querySelectorAll('.page-section');
            pages.forEach(page => page.classList.add('hidden'));

            // Hiện trang được chọn
            document.getElementById(tabId).classList.remove('hidden');

            // Cập nhật Tiêu đề Header
            const titles = {
                'dashboard': { title: 'Tổng quan hệ thống', sub: 'Theo dõi tiến độ và các khoản quyên góp' },
                'quan-ly': { title: 'Quản lý Quỹ Từ Thiện', sub: 'Quản lý, chỉnh sửa và theo dõi trạng thái' },
                'lich-su': { title: 'Lịch sử Quyên Góp', sub: 'Danh sách các giao dịch mạng lưới ETH' },
                'tao-quy': { title: 'Tạo Chiến Dịch Mới', sub: 'Khởi tạo một quỹ từ thiện mới lên hệ thống' }
            };
            
            document.getElementById('header-title').innerText = titles[tabId].title;
            document.getElementById('header-subtitle').innerText = titles[tabId].sub;
        }

        // 2. Logic Đăng xuất
        function handleLogout() {
            // Hiển thị hộp thoại xác nhận
            const isConfirm = confirm("Bạn có chắc chắn muốn đăng xuất khỏi trang Quản trị?");
            if(isConfirm) {
                // Chuyển hướng về trang đăng nhập (Giả lập)
                // Nếu bạn làm Laravel, sau này sửa thành: window.location.href = '/logout';
                alert("Đăng xuất thành công! Chuyển hướng về trang chủ...");
                window.location.href = "#login"; 
            }
        }

        // 3. Logic vẽ Biểu đồ Chart.js (Chỉ chạy 1 lần khi load)
        document.addEventListener('DOMContentLoaded', function() {
            const ctx = document.getElementById('fundChart').getContext('2d');
            
            const gradientBlue = ctx.createLinearGradient(0, 0, 0, 400);
            gradientBlue.addColorStop(0, 'rgba(99, 102, 241, 0.9)'); 
            gradientBlue.addColorStop(1, 'rgba(99, 102, 241, 0.3)');
            
            const gradientGray = ctx.createLinearGradient(0, 0, 0, 400);
            gradientGray.addColorStop(0, 'rgba(203, 213, 225, 0.5)');
            gradientGray.addColorStop(1, 'rgba(203, 213, 225, 0.2)');

            new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: ['Xây Trường', 'Y Tế', 'Khởi Nghiệp', 'Cứu Trợ', 'Môi Trường'],
                    datasets: [
                        { label: 'Đã quyên góp', data: [3.5, 5.2, 1.8, 8.0, 2.4], backgroundColor: gradientBlue, borderRadius: 6 },
                        { label: 'Mục tiêu', data: [5.0, 10.0, 2.0, 8.0, 5.0], backgroundColor: gradientGray, borderRadius: 6 }
                    ]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: { legend: { position: 'top' } },
                    scales: {
                        y: { beginAtZero: true, grid: { color: '#f1f5f9' } },
                        x: { grid: { display: false } }
                    }
                }
            });
        });
    </script>
</body>
</html>