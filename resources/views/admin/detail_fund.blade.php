<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Chi tiết quỹ #{{ $campaign->id }} - Admin</title>

    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <style>
        body {
            font-family: 'Inter', sans-serif;
        }

        .fade-in {
            animation: fadeIn 0.4s ease-out forwards;
            opacity: 0;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(10px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        ::-webkit-scrollbar {
            width: 6px;
            height: 6px;
        }

        ::-webkit-scrollbar-track {
            background: #f1f5f9;
        }

        ::-webkit-scrollbar-thumb {
            background: #cbd5e1;
            border-radius: 10px;
        }

        ::-webkit-scrollbar-thumb:hover {
            background: #94a3b8;
        }
    </style>
</head>

<body class="bg-slate-50 flex h-screen overflow-hidden text-slate-800">
    <!-- Phần sidebar bên trái -->
    <aside class="w-72 bg-[#0f172a] text-slate-300 flex flex-col transition-all duration-300 shadow-2xl z-20 shrink-0">
        <div class="h-20 flex items-center px-8 border-b border-slate-700/50">
            <i class='bx bxs-donate-heart text-3xl text-indigo-500 mr-3'></i>
            <span class="text-xl font-bold text-white tracking-wide">GiveNow Admin</span>
        </div>

        <nav class="flex-1 px-4 py-6 space-y-2 overflow-y-auto">
            <a href="javascript:history.back()" class="nav-item flex items-center px-4 py-3 rounded-xl hover:bg-slate-800 hover:text-white transition-colors group">
                <i class='bx bx-arrow-back text-xl mr-3 group-hover:text-indigo-400 transition-colors'></i>
                <span class="font-medium">Về trang trước</span>
            </a>

            <a href="#" class="nav-item flex items-center px-4 py-3 bg-gradient-to-r from-indigo-500 to-purple-600 text-white rounded-xl shadow-lg shadow-indigo-500/30 transition-all hover:scale-[1.02]">
                <i class='bx bxs-detail text-xl mr-3'></i>
                <span class="font-medium">Chi Tiết Quỹ #{{ $campaign->id }}</span>
            </a>
        </nav>

        <div class="p-4 border-t border-slate-700/50">
            <button onclick="handleLogout()" class="w-full flex items-center justify-center px-4 py-3 bg-rose-500/10 text-rose-400 rounded-xl hover:bg-rose-500 hover:text-white transition-all duration-300">
                <i class='bx bx-log-out text-xl mr-2'></i>
                <span class="font-medium">Đăng xuất</span>
            </button>
        </div>
    </aside>

    <main class="flex-1 flex flex-col h-screen overflow-hidden relative">
        <!-- Phần bên phải -->
        <header class="h-20 bg-white shadow-sm flex items-center justify-between px-8 z-10 shrink-0">
            <div>
                <h1 class="text-2xl font-bold text-slate-800">Chi Tiết Chiến Dịch #{{ $campaign->id }}</h1>
                <p class="text-sm text-slate-500 mt-1">Quản lý và đối chiếu dữ liệu Blockchain trực tiếp</p>
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

        <div class="flex-1 overflow-y-auto relative p-8">
            <div class="max-w-7xl mx-auto fade-in">

                <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                    <div class="lg:col-span-2 space-y-6">
                        <div class="bg-white p-6 rounded-2xl shadow-sm border border-slate-100">
                            <div class="flex flex-col sm:flex-row items-start sm:items-center gap-6 mb-6">
                                <img src="{{ $campaign->image_url ? asset($campaign->image_url) : asset('img/admin/quy-1.jpg') }}" alt="Ảnh quỹ" class="w-full sm:w-32 h-32 object-cover rounded-xl border border-slate-100 shadow-sm">
                                <div>
                                    <span class="px-3 py-1 bg-indigo-50 text-indigo-600 text-xs font-bold rounded-full mb-2 inline-block">{{ $campaign->category }}</span>
                                    <h2 class="text-xl font-bold text-slate-800">{{ $campaign->title }}</h2>
                                    <div class="flex flex-wrap items-center gap-2 mt-2 text-sm text-slate-500">
                                        <span class="flex items-center gap-1"><i class='bx bx-calendar'></i> Ngày tạo: {{ \Carbon\Carbon::parse($campaign->created_at)->format('d/m/Y') }}</span>
                                        @if($campaign->end_date)
                                        <span class="mx-2 hidden sm:inline">|</span>
                                        <span class="flex items-center gap-1"><i class='bx bx-timer'></i> Kết thúc: {{ \Carbon\Carbon::parse($campaign->end_date)->format('d/m/Y') }}</span>
                                        @endif
                                    </div>
                                </div>
                            </div>

                            <div class="grid grid-cols-2 gap-4 mb-6">
                                <div class="p-4 bg-slate-50 rounded-xl border border-slate-100">
                                    <p class="text-xs text-slate-500 font-medium mb-1">Mục tiêu quyên góp</p>
                                    <p class="text-lg font-bold text-slate-800">{{ number_format($campaign->goal_eth, 2) }} ETH</p>
                                </div>
                                <div class="p-4 bg-slate-50 rounded-xl border border-slate-100">
                                    <p class="text-xs text-slate-500 font-medium mb-1">Trạng thái</p>
                                    @if($campaign->status == 1)
                                    <p class="text-lg font-bold text-emerald-600 flex items-center gap-1"><i class='bx bxs-circle text-xs'></i> Đang hoạt động</p>
                                    @else
                                    <p class="text-lg font-bold text-rose-600 flex items-center gap-1"><i class='bx bxs-circle text-xs'></i> Đã đóng </p>
                                    @endif
                                </div>
                            </div>

                            <div>
                                <h3 class="text-sm font-bold text-slate-800 mb-2">Ví người thụ hưởng:</h3>
                                <code class="block p-3 bg-slate-800 text-emerald-400 rounded-lg text-sm mb-6 shadow-inner font-mono overflow-x-auto">
                                    {{ $campaign->receiver_wallet }}
                                </code>
                            </div>

                            <div>
                                <h3 class="text-sm font-bold text-slate-800 mb-2">Mô tả chiến dịch:</h3>
                                <div class="text-slate-600 text-sm leading-relaxed p-4 bg-slate-50 rounded-xl border border-slate-100">
                                    {!! nl2br(e($campaign->description)) !!}
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="space-y-6">
                        <div class="bg-gradient-to-br from-slate-800 to-slate-900 p-6 rounded-2xl shadow-lg border border-slate-700 text-white relative overflow-hidden">
                            <i class='bx bxl-meta absolute -bottom-6 -right-4 text-9xl text-white opacity-5'></i>

                            <h2 class="text-base font-bold mb-4 flex items-center gap-2 border-b border-slate-700 pb-3 relative z-10">
                                <i class='bx bx-data text-emerald-400'></i> Smart Contract Data
                            </h2>

                            <p class="text-xs text-slate-400 mb-4 relative z-10">Dữ liệu được lấy trực tiếp từ Blockchain thông qua hàm <code class="text-emerald-400 bg-slate-800 px-1 rounded">danhSachChienDich()</code></p>

                            <div id="sc-loading" class="text-center py-6 relative z-10">
                                <i class='bx bx-loader-alt bx-spin text-3xl text-emerald-400 mb-2'></i>
                                <p class="text-sm text-slate-400">Đang đồng bộ node...</p>
                            </div>

                            <div id="sc-data" class="space-y-4 hidden relative z-10">
                                <div class="bg-slate-800/50 p-3 rounded-xl border border-slate-700 backdrop-blur-sm">
                                    <p class="text-xs text-slate-400 mb-1">Số dư đang giữ trong Quỹ</p>
                                    <p class="text-xl font-bold text-emerald-400" id="sc_tong_tien">-- ETH</p>
                                </div>

                                <div class="bg-slate-800/50 p-3 rounded-xl border border-slate-700 backdrop-blur-sm">
                                    <p class="text-xs text-slate-400 mb-1">Tổng tiền đã giải ngân</p>
                                    <p class="text-xl font-bold text-rose-400" id="sc_da_rut">-- ETH</p>
                                </div>

                                <div class="bg-slate-800/50 p-3 rounded-xl border border-slate-700 backdrop-blur-sm">
                                    <p class="text-xs text-slate-400 mb-1">Trạng thái Blockchain</p>
                                    <p class="text-sm font-bold text-white" id="sc_trang_thai">--</p>
                                </div>
                            </div>

                            <div id="sc-error" class="hidden mt-4 p-3 bg-rose-500/20 border border-rose-500/50 rounded-xl text-xs text-rose-300 relative z-10">
                                <i class='bx bx-error-circle'></i> <span id="error-msg">Lỗi không thể lấy dữ liệu Blockchain.</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/ethers/6.7.0/ethers.umd.min.js"></script>

    <script>
        // Xử lý nút Đăng xuất
        function handleLogout() {
            const isConfirm = confirm("Bạn có chắc chắn muốn đăng xuất khỏi trang Quản trị?");
            if (isConfirm) {
                window.location.href = "{{ route('logout') }}";
            }
        }

        // Lấy dữ liệu Blockchain
        document.addEventListener("DOMContentLoaded", async function() {
            const loadingEl = document.getElementById('sc-loading');
            const dataEl = document.getElementById('sc-data');
            const errorEl = document.getElementById('sc-error');
            const errorMsgEl = document.getElementById('error-msg');

            try {
                // 1. Kết nối với mạng Flare Coston2
                const rpcUrl = "https://coston2-api.flare.network/ext/C/rpc";
                const provider = new ethers.JsonRpcProvider(rpcUrl);

                // 2. Thông tin Contract
                const contractAddress = "{{ env('SMART_CONTRACT_ADDRESS') }}";
                const campaignId = parseInt("{{ $campaign->id }}");

                // 3. ABI hàm danhSachChienDich (ĐÃ XÓA thoiGianKetThuc)
                const contractABI = [{
                    "inputs": [{
                        "internalType": "uint256",
                        "name": "",
                        "type": "uint256"
                    }],
                    "name": "danhSachChienDich",
                    "outputs": [{
                            "internalType": "uint256",
                            "name": "idTrenDatabase",
                            "type": "uint256"
                        },
                        {
                            "internalType": "address payable",
                            "name": "nguoiNhanTien",
                            "type": "address"
                        },
                        {
                            "internalType": "uint256",
                            "name": "mucTieuTien",
                            "type": "uint256"
                        },
                        {
                            "internalType": "uint256",
                            "name": "tongTienDangGiu",
                            "type": "uint256"
                        },
                        {
                            "internalType": "uint256",
                            "name": "soTienDaRut",
                            "type": "uint256"
                        },
                        {
                            "internalType": "bool",
                            "name": "trangThaiDong",
                            "type": "bool"
                        }
                    ],
                    "stateMutability": "view",
                    "type": "function"
                }];

                const contract = new ethers.Contract(contractAddress, contractABI, provider);

                // 4. Gọi dữ liệu từ Blockchain
                const data = await contract.danhSachChienDich(campaignId);

                // data[3] là tongTienDangGiu, data[4] là soTienDaRut, data[5] là trangThaiDong
                const tongTienEth = ethers.formatEther(data[3]);
                const soTienRutEth = ethers.formatEther(data[4]);
                const isClosed = data[5]; // Đã sửa từ data[6] thành data[5]

                document.getElementById('sc_tong_tien').innerText = tongTienEth + " ETH";
                document.getElementById('sc_da_rut').innerText = soTienRutEth + " ETH";
                document.getElementById('sc_trang_thai').innerHTML = isClosed ?
                    "<span class='text-rose-400'><i class='bx bxs-lock'></i> Đã khóa (Closed)</span>" :
                    "<span class='text-emerald-400'><i class='bx bx-lock-open-alt'></i> Đang mở nhận tiền</span>";

                loadingEl.classList.add('hidden');
                dataEl.classList.remove('hidden');

            } catch (error) {
                console.error("Lỗi:", error);
                loadingEl.classList.add('hidden');
                errorEl.classList.remove('hidden');
                errorMsgEl.innerText = error.message || "Không thể truy xuất dữ liệu từ Blockchain.";
            }
        });
    </script>
</body>

</html>