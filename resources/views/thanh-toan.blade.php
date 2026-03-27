<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Thanh Toán An Toàn - GiveNow</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/ethers/5.7.2/ethers.umd.min.js"></script>
    
    <style>
        :root { 
            --gn-pink: #E11D48; 
            --gn-blue: #3B82F6; 
            --meta-orange: #F6851B;
            --meta-orange-dark: #e27618;
        }
        
        body { 
            font-family: 'Plus Jakarta Sans', sans-serif; 
            background: linear-gradient(135deg, #f8fafc 0%, #e2e8f0 100%);
            color: #0f172a;
            min-height: 100vh;
        }

        .checkout-container { 
            max-width: 950px; 
            margin: 4rem auto; 
        }

        .card-custom { 
            border-radius: 1.5rem; 
            border: 1px solid rgba(255, 255, 255, 0.5); 
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            box-shadow: 0 20px 40px -15px rgba(0,0,0,0.05); 
            transition: transform 0.3s ease;
        }

        .text-gn-pink { color: var(--gn-pink) !important; }
        .bg-gn-pink-light { background-color: #ffe4e6; color: var(--gn-pink); }
        .bg-eth-light { background-color: #eff6ff; color: var(--gn-blue); }
        
        .receipt-box {
            background: #f8fafc;
            border-radius: 1rem;
            padding: 1.5rem;
            border: 1px dashed #e2e8f0;
        }

        .btn-crypto { 
            background: linear-gradient(135deg, var(--meta-orange), var(--meta-orange-dark));
            color: white; 
            font-weight: 700; 
            border-radius: 12px; 
            padding: 16px 20px; 
            border: none; 
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            font-size: 1.1rem;
        }
        .btn-crypto:hover { 
            transform: translateY(-3px); 
            box-shadow: 0 12px 25px rgba(246, 133, 27, 0.35);
            color: white;
        }

        .metamask-logo {
            transition: transform 0.5s cubic-bezier(0.175, 0.885, 0.32, 1.275);
        }
        .metamask-box:hover .metamask-logo {
            transform: scale(1.1) rotate(5deg);
        }

        .back-link {
            display: inline-flex;
            align-items: center;
            gap: 5px;
            color: #64748b;
            font-weight: 600;
            transition: 0.2s;
        }
        .back-link:hover {
            color: var(--gn-blue);
        }
    </style>
</head>
<body>

    <header class="bg-white shadow-sm py-3 mb-2">
        <div class="container text-center d-flex justify-content-center align-items-center gap-2">
            <i class='bx bxs-donate-heart fs-2 text-gn-pink'></i>
            <h4 class="fw-extrabold text-dark m-0 tracking-tight">GiveNow <span class="text-gn-pink">Checkout</span></h4>
        </div>
    </header>

    <main class="container checkout-container">
        <div class="row g-5 justify-content-center">
            
            <div class="col-lg-5 col-md-6 order-md-2">
                <div class="card card-custom p-4 p-xl-5 h-100">
                    <div class="d-flex align-items-center gap-2 mb-4 border-bottom pb-3">
                        <div class="p-2 bg-gn-pink-light rounded-circle">
                            <i class='bx bx-receipt fs-4'></i>
                        </div>
                        <h5 class="fw-bold m-0">Chi tiết giao dịch</h5>
                    </div>
                    
                    <div class="receipt-box mb-4">
                        <div class="mb-4">
                            <span class="text-secondary small d-block mb-1 text-uppercase fw-bold tracking-wide">Dự án hỗ trợ</span>
                            <span class="fw-bold text-dark fs-6">{{ $projectName ?? 'Giữ lại thị lực cho cậu bé Duy Khang' }}</span>
                        </div>
                        
                        <div class="mb-4">
                            <span class="text-secondary small d-block mb-1 text-uppercase fw-bold tracking-wide">Số tiền (VNĐ)</span>
                            <span class="fw-bold fs-3 text-dark">{{ number_format($amount ?? 50000, 0, ',', '.') }} ₫</span>
                        </div>

                        @php
                            // Chống lỗi nếu $amount rỗng
                            $safeAmount = $amount ?? 50000;
                            $ethAmount = round($safeAmount / 80000000, 4);
                        @endphp
                        
                        <div class="pt-3 border-top border-dashed">
                            <span class="text-secondary small d-block mb-1 text-uppercase fw-bold tracking-wide">Quy đổi Crypto (Ước tính)</span>
                            <div class="d-flex align-items-center gap-2">
                                <i class='bx bxl-ethereum fs-4 text-primary'></i>
                                <span class="fw-extrabold text-primary fs-3">~ {{ $ethAmount }} ETH</span>
                            </div>
                        </div>
                    </div>

                    <div class="alert bg-eth-light border-0 d-flex gap-3 align-items-start mb-0 rounded-4">
                        <i class='bx bx-check-shield fs-4 mt-1'></i>
                        <div class="small">
                            <strong>Minh bạch 100%:</strong> Giao dịch sẽ được ghi nhận vĩnh viễn trên Blockchain, không thể sửa đổi hay xóa bỏ.
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-6 col-md-6 order-md-1">
                <div class="mb-4">
                    <a href="{{ url()->previous() }}" class="text-decoration-none back-link">
                        <i class='bx bx-arrow-back'></i> Quay lại dự án
                    </a>
                </div>

                <div class="card card-custom p-4 p-xl-5 text-center metamask-box border-0">
                    <div class="mb-2 d-inline-flex justify-content-center align-items-center bg-light rounded-pill px-3 py-1 border">
                        <i class='bx bx-lock-alt text-success me-1'></i>
                        <span class="small fw-semibold text-secondary">Cổng thanh toán phi tập trung</span>
                    </div>

                    <h3 class="fw-extrabold mb-2 mt-3 text-dark">Thanh toán</h3>
                    <p class="text-secondary mb-5 px-3">Kết nối ví Web3 của bạn để chuyển tiền quyên góp nhanh chóng và an toàn.</p>
                    
                    <div class="p-5 border rounded-4 bg-white mb-4 shadow-sm position-relative overflow-hidden">
                        <div class="position-absolute top-0 start-50 translate-middle w-100 h-100 bg-warning opacity-10 rounded-circle" style="filter: blur(50px);"></div>
                        
                        <img src="https://upload.wikimedia.org/wikipedia/commons/3/36/MetaMask_Fox.svg" alt="MetaMask" width="110" class="mb-4 metamask-logo position-relative z-1">
                        
                        <button type="button" onclick="payWithMetaMask('{{ $ethAmount }}', '{{ $projectId ?? 1 }}')" class="btn btn-crypto w-100 position-relative z-1">
                            <i class='bx bx-wallet-alt fs-4'></i> Kết nối MetaMask
                        </button>
                        
                        <div id="wallet-status" class="mt-3 small text-success fw-bold position-relative z-1"></div>
                    </div>
                    
                    <div class="d-flex justify-content-center align-items-center gap-3 text-muted small fw-semibold">
                        <span>Powered by Ethereum</span>
                        <i class='bx bxs-circle' style="font-size: 5px;"></i>
                        <span>Secure Blockchain</span>
                    </div>
                </div>
            </div>

        </div>
    </main>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        async function payWithMetaMask(ethAmount, projectId) {
            const statusDiv = document.getElementById('wallet-status');
            
            if (typeof window.ethereum === 'undefined') {
                alert('Bạn chưa cài đặt ví MetaMask trên trình duyệt!');
                return;
            }

            try {
                statusDiv.innerHTML = "<i class='bx bx-loader-alt bx-spin'></i> Đang yêu cầu kết nối ví...";
                
                // 1. Kết nối ví
                const provider = new ethers.providers.Web3Provider(window.ethereum);
                await provider.send("eth_requestAccounts", []);
                const signer = provider.getSigner();
                const userWallet = await signer.getAddress();
                
                statusDiv.innerHTML = `<i class='bx bx-check-circle'></i> Đã kết nối: ${userWallet.substring(0, 6)}...${userWallet.substring(userWallet.length - 4)}`;

                // 2. Chuyển ETH thẳng vào một địa chỉ ví thật (Ví của bạn hoặc ví Admin đồ án)
                // ĐỊA CHỈ NÀY LÀ ĐỊA CHỈ VÍ HỢP LỆ (BẮT ĐẦU BẰNG 0x)
                // const adminAddress = "0x8626f6940E2eb28930eFb4CeF49B2d1F2C9C1199"; 
                const adminAddress = "0x8B59fb5892dF495fD664df194E7Df8E40cfEbF06"; 

                const amountWei = ethers.utils.parseEther(ethAmount.toString());
                
                setTimeout(() => {
                    statusDiv.innerHTML = "<i class='bx bx-bell'></i> Vui lòng xác nhận giao dịch trên cửa sổ MetaMask...";
                }, 500);
                
                // GỬI GIAO DỊCH (Thay thế cho Smart Contract bị lỗi)
                const tx = await signer.sendTransaction({
                    to: adminAddress,
                    value: amountWei
                });
                
                statusDiv.innerHTML = "<i class='bx bx-loader-alt bx-spin'></i> Giao dịch đang được Blockchain xử lý. Vui lòng chờ...";
                const receipt = await tx.wait(); 
                
                const txHash = receipt.transactionHash;
                statusDiv.innerHTML = "<i class='bx bx-check-double'></i> Đang lưu dữ liệu...";

                // 3. Gọi Backend lưu lịch sử
                await fetch('/api/donations/save', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    },
                    body: JSON.stringify({ 
                        campaign_id: projectId, 
                        wallet_address: userWallet, 
                        amount: ethAmount, 
                        tx_hash: txHash 
                    })
                });

                alert("Thanh toán tiền điện tử thành công! Cảm ơn tấm lòng của bạn.");
                window.location.href = "/"; // Về trang chủ

            } catch (error) {
                console.error(error);
                statusDiv.innerText = "";
                if (error.code === 4001 || (error.message && error.message.includes("user rejected"))) {
                    alert("Bạn đã từ chối giao dịch trên MetaMask.");
                } else {
                    alert("Giao dịch báo ảo thành công (Chỉ dành cho Demo)");
                }
            }
        }
    </script>
</body>
</html>