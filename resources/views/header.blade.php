<header class="sticky-top bg-white border-bottom border-light">
    <div class="container py-3">
        <nav class="d-flex align-items-center justify-content-between">
            
            <a href="/" class="d-flex align-items-center text-decoration-none">
                <img src="{{ asset('img/home/logo.jpg') }}" alt="Logo" width="80">
            </a>

            <div class="d-none d-md-flex gap-4 fw-semibold fs-6 text-secondary">
                <a href="/" class="text-gn-pink text-decoration-none">Trang chủ</a>
                <a href="#" class="text-secondary hover-text-gn-pink text-decoration-none">Dự án</a>
                <a href="#" class="text-secondary hover-text-gn-pink text-decoration-none">Về chúng tôi</a>
                <a href="#" class="text-secondary hover-text-gn-pink text-decoration-none">Hướng dẫn</a>
            </div>

            <div class="d-flex align-items-center gap-3">
                <button class="btn btn-gn px-4 py-2">Ủng hộ ngay</button>

                <button class="btn btn-light rounded-circle p-2 d-flex align-items-center justify-content-center" style="width: 42px; height: 42px;">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                    </svg>
                </button>

                <div class="d-flex align-items-center fs-6 text-secondary hover-text-gn-pink" style="cursor: pointer;">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" class="me-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1" />
                    </svg>
                    <a href="/login" class="text-inherit text-decoration-none">Đăng nhập</a>
                </div>
            </div>
            
        </nav>
    </div>
</header>