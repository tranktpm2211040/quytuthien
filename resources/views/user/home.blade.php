<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Quỹ từ thiện</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<div class="container mt-4">

    <h2 class="text-center mb-4">🌟 Danh sách quỹ từ thiện</h2>

    <!-- Kết nối MetaMask -->
    <div class="text-end mb-3">
        <button class="btn btn-primary" onclick="connectWallet()">Kết nối ví</button>
    </div>

    <div class="row">
        @foreach($funds as $fund)
        <div class="col-md-4">
            <div class="card mb-4">
                <img src="{{ $fund->image }}" class="card-img-top" height="200">
                <div class="card-body">
                    <h5>{{ $fund->name }}</h5>
                    <p>{{ $fund->description }}</p>

                    <p><b>Mục tiêu:</b> {{ $fund->target_amount }} ETH</p>
                    <p><b>Đã có:</b> {{ $fund->current_amount }} ETH</p>

                    <!-- Donate -->
                    <input type="number" id="amount{{ $fund->id }}" class="form-control mb-2" placeholder="Số ETH">

                    <button class="btn btn-success w-100" onclick="donate({{ $fund->id }})">
                        Quyên góp
                    </button>
                </div>
            </div>
        </div>
        @endforeach
    </div>

</div>

<script src="https://cdn.jsdelivr.net/npm/ethers/dist/ethers.min.js"></script>

<script>
let provider, signer, contract;
const contractAddress = "YOUR_CONTRACT_ADDRESS";
const abi = [/* ABI */];

async function connectWallet() {
    if (window.ethereum) {
        provider = new ethers.providers.Web3Provider(window.ethereum);
        await provider.send("eth_requestAccounts", []);
        signer = provider.getSigner();
        contract = new ethers.Contract(contractAddress, abi, signer);

        alert("Đã kết nối ví!");
    } else {
        alert("Cài MetaMask!");
    }
}

async function donate(fundId) {
    let amount = document.getElementById("amount" + fundId).value;

    const tx = await contract.donate({
        value: ethers.utils.parseEther(amount)
    });

    await tx.wait();

    alert("Donate thành công!");

    // Gửi về Laravel lưu DB
    fetch("/save-donation", {
        method: "POST",
        headers: {
            "Content-Type": "application/json",
            "X-CSRF-TOKEN": "{{ csrf_token() }}"
        },
        body: JSON.stringify({
            fund_id: fundId,
            amount: amount,
            tx_hash: tx.hash
        })
    });
}
</script>

</body>
</html>
