<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Hồ sơ của tôi</title>
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@400;600;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <style>
        body {
            font-family: 'Open Sans', sans-serif;
            background-color: #f8f9fa; /* Màu nền xám nhạt */
        }
        
        /* Phần Banner tím trên cùng */
        .profile-banner {
            background: linear-gradient(90deg, #5b62d8 0%, #8b5cf6 100%);
            padding: 3rem 0;
            color: white;
        }

        /* Vòng tròn Avatar */
        .avatar-circle {
            width: 120px;
            height: 120px;
            background-color: #ffffff;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            border: 5px solid rgba(255, 255, 255, 0.3);
            overflow: hidden;
        }

        /* Custom Tabs */
        .nav-tabs {
            border-bottom: 1px solid #dee2e6;
        }
        .nav-tabs .nav-link {
            color: #6c757d;
            font-weight: 600;
            border: none;
            padding: 0.75rem 1.5rem;
            margin-right: 0.5rem;
        }
        .nav-tabs .nav-link.active {
            background-color: #5b62d8;
            color: white;
            border-radius: 0.5rem 0.5rem 0 0;
        }
        .nav-tabs .nav-link:hover:not(.active) {
            color: #5b62d8;
        }

        /* Header của Form */
        .card-header-custom {
            background: linear-gradient(90deg, #6c5ce7 0%, #a29bfe 100%);
            color: white;
            font-weight: 600;
            padding: 1rem 1.5rem;
            border-top-left-radius: 0.5rem !important;
            border-top-right-radius: 0.5rem !important;
        }

        /* Nút Lưu thay đổi */
        .btn-custom {
            background-color: #6c5ce7;
            color: white;
            font-weight: 600;
            padding: 0.5rem 1.5rem;
            border-radius: 0.375rem;
            transition: all 0.3s;
        }
        .btn-custom:hover {
            background-color: #5b4bc4;
            color: white;
        }
    </style>
</head>
<body>

    @include('header')

    <div class="profile-banner">
        <div class="container d-flex align-items-center">
            <div class="avatar-circle me-4 shadow">
                <img src="https://ui-avatars.com/api/?name={{ session('name', 'U') }}&background=e2e8f0&color=6c5ce7&size=120" alt="Avatar" style="width: 100%; height: 100%;">
            </div>
            <div>
                <h2 class="fw-bold mb-1">{{ session('full_name', 'Người dùng') }}</h2>
                <p class="mb-0 text-light opacity-75">
                    ✉️ {{ session('email', 'Chưa cập nhật email') }}
                </p>
            </div>
        </div>
    </div>

    <div class="container my-5" style="max-width: 900px;">
        
        <ul class="nav nav-tabs mb-4" id="profileTabs" role="tablist">
            <li class="nav-item" role="presentation">
                <button class="nav-link active" id="profile-tab" data-bs-toggle="tab" data-bs-target="#profile" type="button" role="tab">
                    👤 Hồ sơ
                </button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="password-tab" data-bs-toggle="tab" data-bs-target="#password" type="button" role="tab">
                    🔑 Đổi mật khẩu
                </button>
            </li>
        </ul>

        <div class="tab-content" id="profileTabsContent">
            
            <div class="tab-pane fade show active" id="profile" role="tabpanel">
                <div class="card shadow-sm border-0" style="border-radius: 0.5rem;">
                    <div class="card-header card-header-custom border-0">
                        📝 Cập nhật thông tin tài khoản
                    </div>
                    <div class="card-body p-4 p-md-5">
                        <form action="#" method="POST">
                            <div class="row mb-4">
                                <div class="col-md-6 mb-3 mb-md-0">
                                    <label class="form-label text-muted small fw-bold">Họ và tên</label>
                                    <input type="text" class="form-control" name="name" value="{{ session('full_name', '') }}" placeholder="Nhập họ và tên">
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label text-muted small fw-bold">Số điện thoại</label>
                                    <input type="text" class="form-control" name="phone" value="" placeholder="Nhập số điện thoại">
                                </div>
                            </div>
                            <hr class="text-muted opacity-25 mb-4">
                            <div class="text-end">
                                <button type="submit" class="btn btn-custom border-0 shadow-sm">
                                    💾 Lưu thay đổi
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <div class="tab-pane fade" id="password" role="tabpanel">
                <div class="card shadow-sm border-0" style="border-radius: 0.5rem;">
                    <div class="card-header card-header-custom border-0">
                        🔑 Thay đổi mật khẩu
                    </div>
                    <div class="card-body p-4 p-md-5">
                        <p class="text-muted">Tính năng đổi mật khẩu sẽ sớm được cập nhật!</p>
                    </div>
                </div>
            </div>

        </div>
    </div>

    @include('footer')

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>