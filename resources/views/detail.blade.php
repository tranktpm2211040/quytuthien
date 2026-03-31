<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Chi tiết dự án - {{ $campaign->title }}</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@400;600;700&display=swap" rel="stylesheet">
    <link href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet">
    <style>
        :root {
            --gn-pink: #E11D48;
            --gn-blue: #3B82F6;
            --gn-gray: #F9FAFB;
        }

        body {
            font-family: 'Open Sans', sans-serif;
            background-color: #fff;
            color: #1F2937;
        }

        .text-gn-pink {
            color: var(--gn-pink) !important;
        }

        .btn-gn-pink {
            background-color: var(--gn-pink);
            color: white;
            border-radius: 8px;
            font-weight: 700;
            padding: 12px 24px;
            transition: 0.3s;
            border: none;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
        }

        .btn-gn-pink:hover {
            background-color: #be123c;
            color: white;
        }

        .btn-gn-blue {
            background-color: var(--gn-blue);
            color: white;
            border-radius: 8px;
            font-weight: 600;
            padding: 12px 24px;
            transition: 0.3s;
            border: none;
        }

        .detail-carousel img {
            border-radius: 1.5rem;
            width: 100%;
            height: 450px;
            object-fit: cover;
        }

        .badge-category {
            position: absolute;
            top: 20px;
            right: 20px;
            background: var(--gn-pink);
            color: white;
            padding: 5px 15px;
            border-radius: 8px;
            font-size: 0.8rem;
            z-index: 10;
        }

        .donation-box {
            background: var(--gn-gray);
            border-radius: 1.5rem;
            padding: 2rem;
        }

        .progress {
            height: 10px;
            border-radius: 10px;
            background-color: #e5e7eb;
        }

        .progress-bar {
            background-color: var(--gn-pink);
        }

        .nav-tabs {
            border-bottom: 2px solid #f3f4f6;
            gap: 10px;
        }

        .nav-link {
            border: none !important;
            color: #6b7280;
            font-weight: 600;
            padding: 10px 25px;
            border-radius: 8px !important;
        }

        .nav-link.active {
            background-color: var(--gn-blue) !important;
            color: white !important;
        }

        .sidebar-partner {
            background: var(--gn-gray);
            border-radius: 1rem;
            padding: 1.5rem;
        }
    </style>
</head>

<body>

    @include('header')

    <main class="container py-5">
        <div class="row g-5">
            <div class="col-lg-7">
                <div class="position-relative detail-carousel shadow-sm">
                    @if($campaign->category)
                    <span class="badge-category">{{ $campaign->category }}</span>
                    @endif
                    <img src="{{ $campaign->image_url ? asset($campaign->image_url) : asset('img/admin/quy-1.jpg') }}" alt="{{ $campaign->title }}">
                </div>
            </div>

            <div class="col-lg-5">
                <h2 class="fw-bold mb-4" style="line-height: 1.3;">{{ $campaign->title }}</h2>

                <div class="donation-box shadow-sm">
                    <div class="d-flex justify-content-between mb-2">
                        <span class="text-secondary">Mục tiêu dự án</span>
                        <span class="fw-bold">{{ number_format($campaign->goal_eth, 2) }} ETH</span>
                    </div>

                    <div class="progress mb-2" style="height: 10px; border-radius: 10px; background-color: #ffe4e6;">
                        <div id="progress-bar" class="progress-bar" style="width: 0%; background-color: #E11D48; border-radius: 10px; transition: width 1s ease-in-out;"></div>
                    </div>

                    <div class="d-flex justify-content-between mb-4">
                        <span class="text-secondary">Đã đạt được</span>
                        <span class="fw-bold fs-5" style="color: #E11D48;" id="total-raised">
                            <i class='bx bx-loader-alt bx-spin text-sm'></i> Đang tính...
                        </span>
                    </div>

                    <div class="row g-2">
                        <div class="col-12 col-md-5">
                            <div class="input-group h-100">
                                <span class="input-group-text bg-white border-end-0 text-secondary small">VNĐ</span>
                                <input type="number" id="donation-amount" class="form-control border-start-0 ps-0 fw-bold" value="50000" min="10000" step="10000">
                            </div>
                        </div>
                        <div class="col-6 col-md-7">
                            <button onclick="donateNow()" id="btn-donate" class="btn btn-gn-pink w-100 h-100">
                                <i class='bx bxs-heart'></i> Ủng hộ
                            </button>
                        </div>
                    </div>

                    <div class="progress mb-4 mt-4">
                        <div class="progress-bar" style="width: 0%"></div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row mt-5 pt-4">
            <div class="col-lg-8">
                <ul class="nav nav-tabs mb-4" id="projectTab" role="tablist">
                    <li class="nav-item"><button class="nav-link active" data-bs-toggle="tab" data-bs-target="#content">Câu chuyện</button></li>
                    <li class="nav-item"><button class="nav-link" data-bs-toggle="tab" data-bs-target="#donors">Người ủng hộ</button></li>
                </ul>
                <div class="tab-content border-0 p-2">
                    <div class="tab-pane fade show active" id="content">
                        <h5 class="fw-bold mb-3 text-dark">Thông tin chi tiết</h5>

                        <div class="text-secondary mb-4" style="line-height: 1.8;">
                            {!! nl2br(e($campaign->description)) !!}
                        </div>

                    </div>
                    <div class="tab-pane fade text-center py-5" id="donors">
                        <img src="https://cdn-icons-png.flaticon.com/512/102/102661.png" width="50" class="opacity-25 mb-3">
                        <p class="text-secondary">Hãy là người đầu tiên ủng hộ dự án này!</p>
                    </div>
                </div>
            </div>

            <div class="col-lg-4">
                <div class="sidebar-partner sticky-top" style="top: 100px;">
                    <h6 class="fw-bold mb-3">Đơn vị đồng hành</h6>
                    <div class="d-flex align-items-center p-3 bg-white rounded-1 shadow-sm border border-3">
                        <img src="{{ asset('img/home/logo.jpg') }}" class="me-3" style="height: 30px;">
                        <span class="small fw-bold">Nhóm dự án vì cộng đồng</span>
                    </div>
                </div>
            </div>
        </div>
    </main>

    @include('footer')

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/ethers/6.7.0/ethers.umd.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        async function donateNow() {
            const amountInput = document.getElementById('donation-amount').value;
            const btnDonate = document.getElementById('btn-donate');

            const receiverWallet = "{{ $campaign->receiver_wallet }}";

            if (!amountInput || amountInput < 10000) {
                Swal.fire('Lỗi', 'Vui lòng nhập số tiền hợp lệ (Tối thiểu 10.000 VNĐ)', 'warning');
                return;
            }

            if (!receiverWallet) {
                Swal.fire('Lỗi', 'Chiến dịch này chưa được Admin cài đặt ví người thụ hưởng!', 'error');
                return;
            }

            if (typeof window.ethereum === 'undefined') {
                Swal.fire('Thông báo', 'Bạn chưa cài đặt ví MetaMask trên trình duyệt!', 'info');
                return;
            }

            try {
                // Quy đổi VNĐ sang ETH 
                const ethRate = 80000000;
                const ethAmount = (amountInput / ethRate).toFixed(6);

                // ==============================================================
                // HIỂN THỊ HỘP THOẠI XÁC NHẬN SIÊU ĐẸP (SWEETALERT2)
                // ==============================================================
                const confirmResult = await Swal.fire({
                    title: 'Xác nhận quyên góp',
                    html: `
                    <div class="text-start mt-3">
                        <p>Số tiền quyên góp: <b class="text-danger fs-5">${Number(amountInput).toLocaleString('vi-VN')} VNĐ</b></p>
                        <p>Tương đương khoảng: <b>~${ethAmount} ETH</b></p>
                        <p class="mb-1 text-secondary">Tiền sẽ được chuyển TRỰC TIẾP đến ví:</p>
                        <code class="bg-light p-2 rounded border d-block text-center text-dark fs-6">
                            ${receiverWallet.substring(0,6)}...${receiverWallet.substring(38)}
                        </code>
                    </div>
                `,
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonColor: '#E11D48', // Màu hồng giống nút trên web
                    cancelButtonColor: '#6c757d',
                    confirmButtonText: '<i class="bx bxs-heart"></i> Tiếp tục',
                    cancelButtonText: 'Hủy bỏ'
                });

                // Nếu người dùng bấm Hủy bỏ thì dừng lại
                if (!confirmResult.isConfirmed) return;

                // ... Tiếp tục xử lý giao dịch ...
                const provider = new ethers.BrowserProvider(window.ethereum);
                const signer = await provider.getSigner();

                const contractAddress = "{{ env('SMART_CONTRACT_ADDRESS') }}";

                // Xóa thoiGianKetThuc ở hàm taoChienDich, nhưng ở hàm quyenGop vẫn chỉ có _idChienDich
                const contractABI = [{
                    "inputs": [{
                        "internalType": "uint256",
                        "name": "_idChienDich",
                        "type": "uint256"
                    }],
                    "name": "quyenGop",
                    "outputs": [],
                    "stateMutability": "payable",
                    "type": "function"
                }];

                const contract = new ethers.Contract(contractAddress, contractABI, signer);

                const originalText = btnDonate.innerHTML;
                btnDonate.innerHTML = "<i class='bx bx-loader-alt bx-spin'></i> Đang chờ xác nhận...";
                btnDonate.disabled = true;

                const campaignId = "{{ $campaign->id }}";
                const weiAmount = ethers.parseEther(ethAmount.toString());

                // Gọi hàm quyenGop
                const tx = await contract.quyenGop(campaignId, {
                    value: weiAmount
                });

                btnDonate.innerHTML = "<i class='bx bx-loader-alt bx-spin'></i> Đang xử lý Blockchain...";

                const receipt = await tx.wait();
                const txHash = receipt.hash;

                // HIỂN THỊ THÔNG BÁO THÀNH CÔNG BẰNG SWEETALERT2
                Swal.fire({
                    title: 'Thành công!',
                    html: `
                    🎉 Quyên góp vào Smart Contract thành công!<br><br>
                    <span class="text-secondary">Mã giao dịch (Hash):</span><br>
                    <code class="text-primary" style="word-break: break-all;">${txHash}</code>
                `,
                    icon: 'success',
                    confirmButtonColor: '#E11D48'
                }).then(() => {
                    window.location.reload();
                });

            } catch (error) {
                console.error(error);
                btnDonate.innerHTML = "<i class='bx bxs-heart'></i> Ủng hộ";
                btnDonate.disabled = false;

                if (error.code === 'ACTION_REJECTED' || error.code === 4001) {
                    Swal.fire('Đã hủy', 'Bạn đã hủy giao dịch trên ví MetaMask.', 'info');
                } else {
                    const errorMessage = error.reason || error.message || "Lỗi không xác định";
                    Swal.fire({
                        title: 'Giao dịch thất bại!',
                        text: errorMessage,
                        icon: 'error',
                        confirmButtonColor: '#E11D48'
                    });
                }
            }
        }
        // ==============================================================
        // HÀM LẤY DỮ LIỆU TỪ SMART CONTRACT & EXPLORER API (BẢN CHUẨN)
        // ==============================================================
        async function loadDonors() {
            const donorsContainer = document.getElementById('donor-list');
            const totalRaisedEl = document.getElementById('total-raised');
            const progressBarEl = document.getElementById('progress-bar');

            // Lấy mục tiêu ETH từ Database
            const goalEth = parseFloat("{{ $campaign->goal_eth }}");

            try {
                const contractAddress = "{{ env('SMART_CONTRACT_ADDRESS') }}";
                const campaignId = parseInt("{{ $campaign->id }}");
                const rpcUrl = "https://coston2-api.flare.network/ext/C/rpc";
                const provider = new ethers.JsonRpcProvider(rpcUrl);

                // ----------------------------------------------------------
                // 1. LẤY TỔNG TIỀN TỪ SMART CONTRACT (Chính xác tuyệt đối)
                // ----------------------------------------------------------
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
                const blockchainData = await contract.danhSachChienDich(campaignId);

                // Tính tổng = Đang giữ + Đã rút
                const tongTienDangGiu = blockchainData[3];
                const soTienDaRut = blockchainData[4];
                const totalRaisedEth = parseFloat(ethers.formatEther(tongTienDangGiu + soTienDaRut));

                // BƠM TIỀN LÊN GIAO DIỆN VÀ KÉO THANH PROGRESS
                totalRaisedEl.innerText = totalRaisedEth.toFixed(4) + " ETH";
                let percent = (totalRaisedEth / goalEth) * 100;
                if (percent > 100) percent = 100;
                progressBarEl.style.width = percent + "%";


                // ----------------------------------------------------------
                // 2. LẤY DANH SÁCH NGƯỜI ỦNG HỘ TỪ EXPLORER
                // ----------------------------------------------------------
                const apiUrl = `https://coston2-explorer.flare.network/api?module=logs&action=getLogs&address=${contractAddress}`;
                const response = await fetch(apiUrl);
                const data = await response.json();

                // Nếu Explorer báo rỗng -> Chỉ hiển thị khung giỏ hàng rỗng, KHÔNG xóa số tiền
                if (data.status !== "1" || !data.result || data.result.length === 0) {
                    donorsContainer.innerHTML = `
                        <div class="text-center py-5">
                            <img src="https://cdn-icons-png.flaticon.com/512/102/102661.png" width="50" class="opacity-25 mb-3">
                            <p class="text-secondary fw-bold">Hãy là người đầu tiên ủng hộ dự án này!</p>
                        </div>`;
                    return;
                }

                const abiCoder = ethers.AbiCoder.defaultAbiCoder();
                const eventTopic = "0x8ceef0f3fa6aae899e4f7a25ee836a441dd6a9b9f6da648085ef15e927034ede";

                let campaignLogs = [];
                for (const log of data.result) {
                    if (log.topics[0] === eventTopic) {
                        try {
                            const decoded = abiCoder.decode(['uint256', 'address', 'uint256'], log.data);
                            if (Number(decoded[0]) === campaignId) {
                                campaignLogs.push({
                                    donorAddress: decoded[1],
                                    amountEth: parseFloat(ethers.formatEther(decoded[2])).toFixed(4),
                                    txHash: log.transactionHash
                                });
                            }
                        } catch (e) {}
                    }
                }

                campaignLogs.reverse();

                // Nếu có giao dịch nhưng không phải của quỹ này
                if (campaignLogs.length === 0) {
                    donorsContainer.innerHTML = `
                        <div class="text-center py-5">
                            <img src="https://cdn-icons-png.flaticon.com/512/102/102661.png" width="50" class="opacity-25 mb-3">
                            <p class="text-secondary fw-bold">Hãy là người đầu tiên ủng hộ dự án này!</p>
                        </div>`;
                    return;
                }

                // Render danh sách thành công
                let html = '';
                for (const log of campaignLogs) {
                    const shortAddress = log.donorAddress.substring(0, 6) + '...' + log.donorAddress.substring(38);
                    html += `
                        <div class="d-flex align-items-center p-3 bg-white border rounded-3 shadow-sm mb-2 transition-all hover-shadow">
                            <div class="bg-light rounded-circle d-flex align-items-center justify-content-center me-3 border" style="width: 48px; height: 48px;">
                                <i class='bx bx-wallet text-gn-pink fs-4'></i>
                            </div>
                            <div class="flex-grow-1">
                                <h6 class="mb-1 fw-bold text-dark font-monospace" style="font-size: 0.9rem;">${shortAddress}</h6>
                                <a href="https://coston2-explorer.flare.network/tx/${log.txHash}" target="_blank" class="text-decoration-none text-secondary small d-flex align-items-center gap-1">
                                    <i class='bx bx-link-external'></i> ${log.txHash.substring(0, 10)}...
                                </a>
                            </div>
                            <div class="text-end">
                                <span class="fw-bold fs-6" style="color: #10B981;">+${log.amountEth} ETH</span>
                            </div>
                        </div>`;
                }
                donorsContainer.innerHTML = html;

            } catch (error) {
                console.error("Lỗi Blockchain:", error);
                // Chỉ báo lỗi nhỏ dưới danh sách, không chạm vào tổng tiền bên trên
                donorsContainer.innerHTML = `<p class="text-center py-5 text-danger small">Không thể tải danh sách lúc này.</p>`;
            }
        }
        // ==============================================================
        // 3. GỌI HÀM KHI TRANG TẢI XONG (BẮT BUỘC PHẢI CÓ)
        // ==============================================================
        document.addEventListener("DOMContentLoaded", loadDonors);
    </script>
</body>

</html>