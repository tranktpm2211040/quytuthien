<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Ví Flare Của Tôi</title>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/ethers/6.7.0/ethers.umd.min.js"></script>
    <style>
        body { font-family: sans-serif; padding: 20px; }
        button { padding: 10px 15px; margin: 5px; cursor: pointer; }
        .action-box { margin-top: 20px; padding: 15px; border: 1px solid #ccc; display: none; }
    </style>
</head>
<body>
    <h2>Giao diện Web3 trên Laravel</h2>
    
    <button id="connectBtn">1. Kết nối ví MetaMask</button>
    <p>Trạng thái: <b id="statusText">Chưa kết nối</b></p>

    <div id="actionBox" class="action-box">
        <h3>Tương tác Smart Contract</h3>
        <button id="depositBtn">Nạp 0.01 FLR vào Contract</button>
        <button id="withdrawBtn">Rút 0.01 FLR về ví</button>
    </div>

    <script>
        // Địa chỉ contract của bạn sau khi chạy lệnh deploy
        const CONTRACT_ADDRESS = "0x8B59fb5892dF495fD664df194E7Df8E40cfEbF06"; 
        
        // Mảng ABI lấy chính xác từ file JSON của bạn
        const CONTRACT_ABI = [
            {
                "inputs": [],
                "stateMutability": "nonpayable",
                "type": "constructor"
            },
            {
                "inputs": [],
                "name": "deposite",
                "outputs": [],
                "stateMutability": "payable",
                "type": "function"
            },
            {
                "inputs": [
                    {
                        "internalType": "uint256",
                        "name": "value",
                        "type": "uint256"
                    }
                ],
                "name": "withdraw",
                "outputs": [],
                "stateMutability": "nonpayable",
                "type": "function"
            }
        ];

        let provider;
        let signer;
        let contract;

        const connectBtn = document.getElementById('connectBtn');
        const depositBtn = document.getElementById('depositBtn');
        const withdrawBtn = document.getElementById('withdrawBtn');
        const statusText = document.getElementById('statusText');
        const actionBox = document.getElementById('actionBox');

        // Hàm Kết nối ví
        connectBtn.addEventListener('click', async () => {
            if (window.ethereum) {
                try {
                    await window.ethereum.request({ method: 'eth_requestAccounts' });
                    
                    provider = new ethers.BrowserProvider(window.ethereum);
                    signer = await provider.getSigner();
                    const address = await signer.getAddress();
                    
                    statusText.innerText = "Đã kết nối: " + address;
                    statusText.style.color = "green";
                    
                    // Khởi tạo Contract
                    contract = new ethers.Contract(CONTRACT_ADDRESS, CONTRACT_ABI, signer);
                    
                    // Hiện khu vực bấm nạp/rút
                    actionBox.style.display = "block";
                    connectBtn.innerText = "Đã kết nối";
                } catch (error) {
                    console.error(error);
                    statusText.innerText = "Kết nối thất bại!";
                    statusText.style.color = "red";
                }
            } else {
                alert("Vui lòng cài đặt MetaMask!");
            }
        });

        // Hàm Nạp tiền (Gọi hàm deposite trong Contract)
        depositBtn.addEventListener('click', async () => {
            try {
                statusText.innerText = "Đang gửi yêu cầu nạp tiền, vui lòng xác nhận trên MetaMask...";
                
                // Chuyển đổi 0.01 FLR sang đơn vị Wei
                const amountToDeposit = ethers.parseEther("0.01");
                
                // Gọi hàm deposite (nhớ viết đúng chữ e ở cuối như trong ABI)
                const tx = await contract.deposite({ value: amountToDeposit });
                
                statusText.innerText = "Đang chờ mạng lưới xác nhận giao dịch...";
                await tx.wait(); // Chờ block được đào
                
                statusText.innerText = "Nạp tiền thành công!";
            } catch (error) {
                console.error(error);
                statusText.innerText = "Lỗi khi nạp tiền (Xem Console F12)";
            }
        });

        // Hàm Rút tiền (Gọi hàm withdraw trong Contract)
        withdrawBtn.addEventListener('click', async () => {
            try {
                statusText.innerText = "Đang gửi yêu cầu rút tiền...";
                
                // Rút 0.01 FLR (Cần truyền tham số value vào hàm withdraw)
                const amountToWithdraw = ethers.parseEther("0.01");
                const tx = await contract.withdraw(amountToWithdraw);
                
                statusText.innerText = "Đang chờ mạng lưới xác nhận giao dịch...";
                await tx.wait();
                
                statusText.innerText = "Rút tiền thành công!";
            } catch (error) {
                console.error(error);
                statusText.innerText = "Lỗi khi rút tiền (Có thể do contract không đủ số dư hoặc ví không có quyền)";
            }
        });
    </script>
</body>
</html>