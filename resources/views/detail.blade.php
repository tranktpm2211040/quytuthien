<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Chi tiết dự án - Duy Khang</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@400;600;700&display=swap" rel="stylesheet">
    <style>
        :root { --gn-pink: #E11D48; --gn-blue: #3B82F6; --gn-gray: #F9FAFB; }
        body { font-family: 'Open Sans', sans-serif; background-color: #fff; color: #1F2937; }
        .text-gn-pink { color: var(--gn-pink) !important; }
        .btn-gn-pink { background-color: var(--gn-pink); color: white; border-radius: 8px; font-weight: 700; padding: 12px 24px; transition: 0.3s; border: none; }
        .btn-gn-pink:hover { background-color: #be123c; color: white; }
        .btn-gn-blue { background-color: var(--gn-blue); color: white; border-radius: 8px; font-weight: 600; padding: 12px 24px; transition: 0.3s; border: none; }
        
        .detail-carousel img { border-radius: 1.5rem; width: 100%; height: 450px; object-fit: cover; }
        .badge-category { position: absolute; top: 20px; right: 20px; background: var(--gn-pink); color: white; padding: 5px 15px; border-radius: 8px; font-size: 0.8rem; z-index: 10; }
        .donation-box { background: var(--gn-gray); border-radius: 1.5rem; padding: 2rem; }
        .progress { height: 10px; border-radius: 10px; background-color: #e5e7eb; }
        .progress-bar { background-color: var(--gn-pink); }
        
        .nav-tabs { border-bottom: 2px solid #f3f4f6; gap: 10px; }
        .nav-link { border: none !important; color: #6b7280; font-weight: 600; padding: 10px 25px; border-radius: 8px !important; }
        .nav-link.active { background-color: var(--gn-blue) !important; color: white !important; }
        .sidebar-partner { background: var(--gn-gray); border-radius: 1rem; padding: 1.5rem; }
    </style>
</head>
<body>

    @include('header')

    <main class="container py-5">
        <div class="row g-5">
            <div class="col-lg-7">
                <div class="position-relative detail-carousel shadow-sm">
                    <span class="badge-category">Y tế</span>
                    <img src="{{ asset('img/admin/quy-1.jpg') }}" alt="Duy Khang">
                </div>
            </div>

            <div class="col-lg-5">
                <h2 class="fw-bold mb-4" style="line-height: 1.3;">Giữ lại thị lực cho cậu bé Duy Khang</h2>
                
                <div class="donation-box shadow-sm">
                    <!-- <div class="d-flex align-items-center mb-4">
                        <img src="{{ asset('img/home/org_logo.png') }}" class="rounded-circle me-3" style="width: 45px; height: 45px; border: 1px solid #eee;">
                        <div>
                            <div class="fw-bold text-gn-pink">Quỹ Nâng bước tuổi thơ</div>
                            <div class="small text-secondary">156 lượt ủng hộ</div>
                        </div>
                    </div> -->

                    <div class="d-flex justify-content-between mb-2">
                        <span class="text-secondary">Mục tiêu dự án</span>
                        <span class="fw-bold">50.000.000₫</span>
                    </div>

                    <div class="progress mb-4">
                        <div class="progress-bar" style="width: 32%"></div>
                    </div>

                    <div class="d-flex justify-content-between align-items-end mb-4">
                        <span class="text-secondary">Đã đạt được</span>
                        <span class="fs-3 fw-bold text-gn-pink">16.092.200₫</span>
                    </div>

                    <div class="row g-2">
                        <div class="col-12 col-md-5">
                            <div class="input-group h-100">
                                <span class="input-group-text bg-white border-end-0 text-secondary small">VNĐ</span>
                                <input type="text" class="form-control border-start-0 ps-0 fw-bold" value="50.000">
                            </div>
                        </div>
                        <div class="col-6 col-md-7">
                            <button class="btn btn-gn-pink w-100 h-100">Ủng hộ</button>
                        </div>
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
                        <h5 class="fw-bold mb-3 text-dark">Nỗi đau của cậu bé 5 tuổi</h5>
                        <p class="text-secondary mb-4" style="line-height: 1.8;">
                            Bé Duy Khang sinh ra trong một gia đình nghèo. Khi lên 3 tuổi, đôi mắt em bắt đầu có dấu hiệu mờ đi. 
                            Các bác sĩ chẩn đoán em bị đục thủy tinh thể bẩm sinh và cần phẫu thuật gấp để giữ lại ánh sáng...
                        </p>
                        <p class="text-secondary" style="line-height: 1.8;">
                            Chi phí phẫu thuật vượt quá khả năng của gia đình. Cha em làm thuê, mẹ em ở nhà chăm sóc hai anh em. 
                            Rất mong các mạnh thường quân chung tay giúp em tìm lại đôi mắt sáng.
                        </p>
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
</body>
</html>