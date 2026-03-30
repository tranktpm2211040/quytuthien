<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quỹ Từ Thiện - Blockchain Test</title>
    
    <script src="https://cdnjs.cloudflare.com/ajax/libs/ethers/6.7.0/ethers.umd.min.js"></script>
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <style>
        body { font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; padding: 40px; line-height: 1.6; color: #333; background-color: #f8f9fa; }
        .container-box { max-width: 600px; margin: 0 auto; border: 1px solid #eee; padding: 30px; border-radius: 10px; box-shadow: 0 4px 6px rgba(0,0,0,0.1); background-color: #ffffff; }
        .action-box { margin-top: 30px; padding: 20px; border-top: 2px solid #f1f1f1; display: none; }
        #statusText { padding: 10px; background: #e9ecef; border-radius: 5px; word-break: break-all; display: inline-block; margin-top: 10px;}
        .custom-btn { background-color: #28a745; color: white; border: none; padding: 10px 20px; border-radius: 5px; cursor: pointer; margin-right: 10px; font-weight: bold;}
        .custom-btn-danger { background-color: #dc3545; color: white; border: none; padding: 10px 20px; border-radius: 5px; cursor: pointer; font-weight: bold;}
        .custom-btn:hover, .custom-btn-danger:hover { opacity: 0.8; }
    </style>
</head>
<body>

<div class="container-box">
    <h2 class="mb-4">Quản Lý Quỹ Từ Thiện (Web3)</h2>
    
    <button id="connectWalletBtn" class="btn btn-outline-dark px-4 py-2 d-flex align-items-center gap-2 mb-3" style="border-radius: 0.5rem;">
        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z" />
        </svg>
        <span id="walletAddressText">Kết nối ví</span>
    </button>
    
    <p>Trạng thái hệ thống: <span id="statusText"><b>Chưa kết nối</b></span></p>

    <div id="actionBox" class="action-box">
        <h3 class="mb-3">Giao dịch Test</h3>
        
        <div class="mb-3">
            <label class="form-label">ID Chiến dịch:</label>
            <input type="number" id="campaignId" class="form-control w-50" value="1">
        </div>

        <div class="mb-3">
            <label class="form-label">Số tiền (ETH/MATIC):</label>
            <input type="number" id="amount" class="form-control w-50" value="0.01" step="0.01">
        </div>

        <button id="depositBtn" class="custom-btn">Quyên góp vào Quỹ</button>
        <button id="withdrawBtn" class="custom-btn-danger">Rút tiền Giải ngân</button>
    </div>
</div>

<script>
    // 1. Lấy thông tin từ file .env của Laravel
    const CONTRACT_ADDRESS = "{{ env('SMART_CONTRACT_ADDRESS', '0xc57B9f5C6ca1c4CeC41d7c900a1aB22DbAca1a56') }}"; 
    
    // 2. Mảng ABI rút gọn từ file QuyTuThien.json của bạn
    const CONTRACT_ABI = [
        {
            "inputs": [
                { "internalType": "uint256", "name": "_idChienDich", "type": "uint256" }
            ],
            "name": "quyenGop",
            "outputs": [],
            "stateMutability": "payable",
            "type": "function"
        },
        {
            "inputs": [
                { "internalType": "uint256", "name": "_idChienDich", "type": "uint256" },
                { "internalType": "uint256", "name": "_soTienCanRut", "type": "uint256" },
                { "internalType": "string", "name": "_mucDichChi", "type": "string" }
            ],
            "name": "rutTienGiaiNgan",
            "outputs": [],
            "stateMutability": "nonpayable",
            "type": "function"
        }
    ];

    let provider;
    let signer;
    let contract;

    const connectBtn = document.getElementById('connectWalletBtn');
    const walletText = document.getElementById('walletAddressText');
    const depositBtn = document.getElementById('depositBtn');
    const withdrawBtn = document.getElementById('withdrawBtn');
    const statusText = document.getElementById('statusText');
    const actionBox = document.getElementById('actionBox');

    // --- HÀM 1: KẾT NỐI VÍ METAMASK ---
    connectBtn.addEventListener('click', async () => {
        if (typeof window.ethereum !== 'undefined') {
            try {
                // Mở cửa sổ MetaMask
                await window.ethereum.request({ method: 'eth_requestAccounts' });
                
                provider = new ethers.BrowserProvider(window.ethereum);
                signer = await provider.getSigner();
                const address = await signer.getAddress();
                
                // Cắt ngắn địa chỉ ví (vd: 0x123...abcd)
                const shortAddress = address.slice(0, 6) + "..." + address.slice(-4);
                walletText.innerText = shortAddress;
                
                // Đổi style nút thành xanh báo hiệu thành công
                connectBtn.classList.remove('btn-outline-dark');
                connectBtn.classList.add('btn-success', 'text-white', 'border-success');
                
                // Khởi tạo Smart Contract
                contract = new ethers.Contract(CONTRACT_ADDRESS, CONTRACT_ABI, signer);
                
                // Hiện bảng giao dịch
                actionBox.style.display = "block";
                connectBtn.disabled = true;
                statusText.innerHTML = '<b style="color:green">Sẵn sàng giao dịch!</b>';
            } catch (error) {
                console.error(error);
                statusText.innerHTML = '<b style="color:red">Lỗi kết nối ví! Có thể bạn đã từ chối.</b>';
            }
        } else {
            alert("Bạn chưa cài đặt MetaMask. Vui lòng cài đặt extension để tiếp tục!");
        }
    });

    // --- HÀM 2: QUYÊN GÓP (Gọi hàm quyenGop) ---
    depositBtn.addEventListener('click', async () => {
        try {
            const id = document.getElementById('campaignId').value;
            const ethAmount = document.getElementById('amount').value;
            const weiAmount = ethers.parseEther(ethAmount.toString());

            statusText.innerText = "Vui lòng mở MetaMask và xác nhận giao dịch quyên góp...";
            
            // Thực thi trên Smart Contract
            const tx = await contract.quyenGop(id, { value: weiAmount });

            statusText.innerText = "Đang chờ mạng Blockchain xác nhận... Vui lòng không đóng trang.";
            await tx.wait(); 
            
            alert("Quyên góp thành công! Cảm ơn bạn.");
            statusText.innerHTML = '<b style="color:green">Hoàn tất quyên góp!</b>';
        } catch (error) {
            console.error(error);
            alert("Giao dịch lỗi: " + (error.reason || "Vui lòng xem chi tiết ở F12 (Console)"));
            statusText.innerHTML = '<b style="color:red">Giao dịch quyên góp thất bại.</b>';
        }
    });

    // --- HÀM 3: RÚT TIỀN (Gọi hàm rutTienGiaiNgan) ---
    withdrawBtn.addEventListener('click', async () => {
        try {
            const id = document.getElementById('campaignId').value;
            const ethAmount = document.getElementById('amount').value;
            const weiAmount = ethers.parseEther(ethAmount.toString());
            const mucDich = "Giải ngân để kiểm thử hệ thống Web3";

            statusText.innerText = "Vui lòng mở MetaMask và xác nhận giao dịch rút tiền...";
            
            // Thực thi trên Smart Contract
            const tx = await contract.rutTienGiaiNgan(id, weiAmount, mucDich);

            statusText.innerText = "Đang chờ mạng Blockchain xác nhận lệnh rút tiền...";
            await tx.wait();
            
            alert("Rút tiền thành công!");
            statusText.innerHTML = '<b style="color:green">Giải ngân hoàn tất!</b>';
        } catch (error) {
            console.error(error);
            alert("Lỗi: Bạn không phải Admin hoặc quỹ không đủ tiền!");
            statusText.innerHTML = '<b style="color:red">Giao dịch rút tiền thất bại.</b>';
        }
    });
</script>

</body>
</html>