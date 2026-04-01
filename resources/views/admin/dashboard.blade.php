<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Admin - Nhóm dự án vì cộng đồng</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/ethers/6.7.0/ethers.umd.min.js"></script>

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

        .delay-100 {
            animation-delay: 100ms;
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
    <!-- hệ thống -->
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

            <!-- Tạo quỹ mới -->

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


                <!-- quản lý quỹ -->

                <div class="bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden overflow-x-auto">
                    <table class="w-full text-left whitespace-nowrap min-w-[1000px] table-fixed">
                        <thead class="bg-slate-50 border-b border-slate-100 text-xs text-black font-bold uppercase tracking-wider">
                            <tr>
                                <th class="px-4 py-4 w-[22%]">Tên Quỹ</th>
                                <th class="px-4 py-4 w-[12%] text-indigo-600">Mục tiêu (ETH)</th>
                                <th class="px-4 py-4 w-[13%]">Ví người nhận</th>
                                <th class="px-4 py-4 w-[15%]">Mô tả</th>
                                <th class="px-4 py-4 w-[10%] text-center">Ngày kết thúc</th>
                                <th class="px-4 py-4 w-[10%] text-center">Trạng thái</th>
                                <th class="px-4 py-4 w-[18%] text-center">Hành động</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100">
                            @foreach($campaigns as $campaign)
                            <tr class="hover:bg-slate-50 group transition-colors">
                                <td class="px-4 py-4 font-semibold text-slate-800 truncate" title="{{ $campaign->title }}">
                                    {{ $campaign->title }}
                                </td>

                                <td class="px-4 py-4 font-bold text-indigo-600">{{ number_format($campaign->goal_eth, 2) }} ETH</td>

                                <td class="px-4 py-4 font-mono text-xs text-slate-500" title="{{ $campaign->receiver_wallet }}">
                                    @if($campaign->receiver_wallet)
                                    {{ substr($campaign->receiver_wallet, 0, 6) }}...{{ substr($campaign->receiver_wallet, -4) }}
                                    @else
                                    <span class="text-rose-400 italic">Chưa có</span>
                                    @endif
                                </td>

                                <td class="px-4 py-4">
                                    <div class="w-full truncate text-sm text-slate-500" title="{{ $campaign->description }}">
                                        {{ $campaign->description }}
                                    </div>
                                </td>

                                <td class="px-4 py-4 text-sm text-slate-500 ">{{ \Carbon\Carbon::parse($campaign->end_date)->format('d/m/Y') }}</td>

                                <td class="px-4 py-4 text-center">
                                    @if($campaign->status == 1)
                                    <span class="px-3 py-1 text-xs rounded-full bg-emerald-100 text-emerald-700">Đang hoạt động</span>
                                    @elseif($campaign->status == 2)
                                    <span class="px-3 py-1 text-xs rounded-full bg-blue-100 text-blue-700">Hoàn thành</span>
                                    @else
                                    <span class="px-3 py-1 text-xs rounded-full bg-slate-100 text-slate-700">Bản nháp</span>
                                    @endif
                                </td>

                                <td class="px-4 py-4 text-center">
                                    <a href="{{ route('admin.fund.detail', $campaign->id) }}" class="inline-block text-slate-400 hover:text-emerald-600 mx-1 transition-colors" title="Xem chi tiết">
                                        <i class='bx bx-show text-xl'></i>
                                    </a>
                                    <button class="text-slate-400 hover:text-blue-600 mx-1 transition-colors" title="Chỉnh sửa"
                                        data-id="{{ $campaign->id }}"
                                        data-title="{{ $campaign->title }}"
                                        data-goal="{{ $campaign->goal_eth }}"
                                        data-category="{{ $campaign->category }}"
                                        data-status="{{ $campaign->status }}"
                                        data-desc="{{ $campaign->description }}"
                                        data-wallet="{{ $campaign->receiver_wallet }}"
                                        data-enddate="{{ \Carbon\Carbon::parse($campaign->end_date)->format('Y-m-d') }}"

                                        data-image="{{ $campaign->image_url ? asset($campaign->image_url) : '' }}"

                                        onclick="openEditTab(this)">
                                        <i class='bx bx-edit text-xl'></i>
                                    </button>
                                    <a href="{{ route('admin.fund.delete', $campaign->id) }}" onclick="return confirm('Bạn có chắc chắn muốn xóa quỹ này không? Dữ liệu không thể khôi phục.')" class="inline-block text-slate-400 hover:text-rose-600 mx-1 transition-colors" title="Xóa">
                                        <i class='bx bx-trash text-xl'></i>
                                    </a>
                                </td>
                            </tr>
                            @endforeach

                            @if($campaigns->isEmpty())
                            <tr>
                                <td colspan="7" class="px-4 py-8 text-center text-slate-500">
                                    Chưa có chiến dịch nào trên hệ thống. Hãy tạo chiến dịch đầu tiên!
                                </td>
                            </tr>
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- lịch sử quyên góp -->
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

                            @php
                            // Kéo toàn bộ danh sách quyên góp, mới nhất xếp lên trên
                            $tatCaGiaoDich = \App\Models\Donation::orderBy('created_at', 'desc')->get();
                            @endphp

                            @forelse($tatCaGiaoDich as $gd)
                            @php
                            // Đổi ngược VNĐ ra ETH (Tỷ giá tạm tính: 1 ETH = 80.000.000 VNĐ)
                            $soEth = $gd->amount_vnd / 80000000;
                            @endphp
                            <tr class="hover:bg-slate-50">
                                <td class="px-6 py-4 font-mono text-slate-600">
                                    <span class="bg-slate-100 px-2 py-1 rounded text-xs">Ẩn danh</span>
                                </td>

                                <td class="px-6 py-4 font-bold text-emerald-600">
                                    + {{ number_format($soEth, 4) }} ETH
                                    <span class="block text-xs text-slate-400 font-normal mt-1">
                                        ({{ number_format($gd->amount_vnd, 0, ',', '.') }} đ)
                                    </span>
                                </td>

                                <td class="px-6 py-4 text-slate-800 font-medium">
                                    {{ $gd->campaign_title }}
                                </td>

                                <td class="px-6 py-4 text-slate-500">
                                    {{ \Carbon\Carbon::parse($gd->created_at)->locale('vi')->diffForHumans() }}
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="4" class="px-6 py-10 text-center text-slate-500">
                                    <i class='bx bx-receipt fs-2 mb-2 text-slate-300 d-block'></i>
                                    Chưa có giao dịch quyên góp nào.
                                </td>
                            </tr>
                            @endforelse

                        </tbody>
                    </table>
                </div>
            </div>

            @include('admin.create_fund')

            @include('admin.edit_fund')

        </div>
    </main>

    <script>
        // ================= XỬ LÝ CHUYỂN TAB =================
        function switchTab(tabId, element) {
            const navItems = document.querySelectorAll('.nav-item');
            navItems.forEach(item => {
                item.className = "nav-item flex items-center px-4 py-3 rounded-xl hover:bg-slate-800 hover:text-white transition-colors group";
                const icon = item.querySelector('i');
                if (icon) icon.className = icon.className.replace('text-white', 'group-hover:text-indigo-400').replace('bxs-', 'bx-');
            });

            if (element) {
                element.className = "nav-item flex items-center px-4 py-3 bg-gradient-to-r from-indigo-500 to-purple-600 text-white rounded-xl shadow-lg shadow-indigo-500/30 transition-all hover:scale-[1.02]";
                const activeIcon = element.querySelector('i');
                if (activeIcon) activeIcon.className = activeIcon.className.replace('group-hover:text-indigo-400', 'text-white').replace('bx-', 'bxs-');
            }

            const pages = document.querySelectorAll('.page-section');
            pages.forEach(page => page.classList.add('hidden'));

            document.getElementById(tabId).classList.remove('hidden');

            const titles = {
                'dashboard': {
                    title: 'Tổng quan hệ thống',
                    sub: 'Theo dõi tiến độ và các khoản quyên góp'
                },
                'quan-ly': {
                    title: 'Quản lý Quỹ Từ Thiện',
                    sub: 'Quản lý, chỉnh sửa và theo dõi trạng thái'
                },
                'lich-su': {
                    title: 'Lịch sử Quyên Góp',
                    sub: 'Danh sách các giao dịch mạng lưới ETH'
                },
                'tao-quy': {
                    title: 'Tạo Chiến Dịch Mới',
                    sub: 'Khởi tạo một quỹ từ thiện mới lên hệ thống'
                },
                'edit-quy': {
                    title: 'Chỉnh sửa Quỹ Từ Thiện',
                    sub: 'Cập nhật lại thông tin chiến dịch đã chọn'
                }
            };

            if (titles[tabId]) {
                document.getElementById('header-title').innerText = titles[tabId].title;
                document.getElementById('header-subtitle').innerText = titles[tabId].sub;
            }
        }

        function handleLogout() {
            const isConfirm = confirm("Bạn có chắc chắn muốn đăng xuất khỏi trang Quản trị?");
            if (isConfirm) {
                alert("Đăng xuất thành công! Chuyển hướng về trang chủ...");
                window.location.href = "#login";
            }
        }

        // 3. Chart.js
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
                    datasets: [{
                            label: 'Đã quyên góp',
                            data: [3.5, 5.2, 1.8, 8.0, 2.4],
                            backgroundColor: gradientBlue,
                            borderRadius: 6
                        },
                        {
                            label: 'Mục tiêu',
                            data: [5.0, 10.0, 2.0, 8.0, 5.0],
                            backgroundColor: gradientGray,
                            borderRadius: 6
                        }
                    ]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            position: 'top'
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            grid: {
                                color: '#f1f5f9'
                            }
                        },
                        x: {
                            grid: {
                                display: false
                            }
                        }
                    }
                }
            });
        });
    </script>
</body>

</html>