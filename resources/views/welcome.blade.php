<!DOCTYPE html>
<html lang="vi">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>GiveNow - Nền tảng gây quỹ cộng đồng trực tuyến</title>

        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@400;600;700&display=swap" rel="stylesheet">

        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

        <style>
            /* Custom CSS để đồng bộ màu sắc và hiệu ứng với bản thiết kế */
            :root {
                --gn-pink: #E11D48;
                --gn-gray: #F9FAFB;
                --gn-text: #1F2937;
            }
            body { 
                font-family: 'Open Sans', sans-serif; 
                color: var(--gn-text);
                background-color: #ffffff;
            }
            a { text-decoration: none; }
            
            /* Tiện ích màu sắc */
            .text-gn-pink { color: var(--gn-pink) !important; }
            .bg-gn-pink { background-color: var(--gn-pink) !important; color: white; }
            .bg-gn-gray { background-color: var(--gn-gray) !important; }
            .hover-text-gn-pink:hover { color: var(--gn-pink) !important; }
            
            /* Nút bấm đặc chế */
            .btn-gn {
                background-color: var(--gn-pink);
                color: white;
                border-radius: 50px;
                font-weight: 700;
                transition: all 0.2s ease;
            }
            .btn-gn:hover { background-color: #be123c; color: white; }
            
            /* Hero Section */
            .hero-bg {
                /* Đã đổi thành đường dẫn tĩnh tương đối */
                background-image: url('images/hero_background.jpg');
                background-size: cover;
                background-position: center;
                padding: 8rem 0;
            }
            @media (min-width: 768px) {
                .hero-bg { padding: 12rem 0; }
            }
            .bg-overlay {
                background-color: rgba(0, 0, 0, 0.3);
            }

            /* Pagination Dots */
            .dot { width: 10px; height: 10px; border-radius: 50%; display: inline-block; cursor: pointer; transition: opacity 0.2s;}
            .dot.active { background-color: var(--gn-pink); }
            .dot.inactive { background-color: white; opacity: 0.6; }
            .dot.inactive:hover { opacity: 1; }

            /* Category Pills */
            .category-btn {
                border-radius: 50px;
                padding: 0.5rem 1.25rem;
                font-size: 0.875rem;
                transition: all 0.15s ease-in-out;
            }
            .category-btn.active {
                background-color: white;
                border: 1px solid #e5e7eb;
                color: var(--gn-pink);
                font-weight: 600;
                box-shadow: 0 1px 2px 0 rgba(0, 0, 0, 0.05);
            }
            .category-btn.inactive {
                background-color: white;
                border: 1px solid #e5e7eb;
                color: #4b5563;
            }
            .category-btn.inactive:hover {
                border-color: var(--gn-pink);
                color: var(--gn-pink);
            }

            /* Cards */
            .card-custom {
                border: none;
                border-radius: 1.5rem;
                box-shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.1), 0 1px 2px 0 rgba(0, 0, 0, 0.06);
                transition: box-shadow 0.3s ease;
            }
            .card-custom:hover {
                box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
            }
            .aspect-4-3 {
                position: relative;
                width: 100%;
                padding-top: 75%; 
            }
            .aspect-4-3 img {
                position: absolute;
                top: 0; left: 0; width: 100%; height: 100%;
                object-fit: cover;
                border-top-left-radius: 1.5rem;
                border-top-right-radius: 1.5rem;
            }
            .tag-badge {
                position: absolute;
                top: 1rem; right: 1rem;
                background-color: var(--gn-pink);
                color: white;
                font-size: 0.75rem;
                font-weight: 700;
                padding: 0.25rem 0.75rem;
                border-radius: 0.25rem;
            }
            .line-clamp-2 {
                display: -webkit-box;
                -webkit-line-clamp: 2;
                -webkit-box-orient: vertical;  
                overflow: hidden;
            }

            /* Bootstrap Progress Bar Override */
            .progress { height: 0.5rem; border-radius: 50px; background-color: #f3f4f6; }
            .progress-bar { background-color: var(--gn-pink); border-radius: 50px; }
            
            /* Nút điều hướng Slide */
            .nav-arrow {
                position: absolute; top: 50%; transform: translateY(-50%);
                width: 48px; height: 48px;
                background: white; border: 1px solid #e5e7eb; border-radius: 50%;
                box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
                display: flex; align-items: center; justify-content: center;
                color: #9ca3af; cursor: pointer; transition: all 0.2s;
            }
            .nav-arrow:hover { color: var(--gn-pink); border-color: var(--gn-pink); }
            .nav-arrow.left { left: -3rem; }
            .nav-arrow.right { right: -3rem; }
        </style>
    </head>
    <body>

        <header class="sticky-top bg-white border-bottom border-light">
            <div class="container py-3">
                <nav class="d-flex align-items-center justify-content-between">
                    <a href="index.html" class="d-flex align-items-center">
                        <img src="images/logo.png" alt="GiveNow Logo" height="40">
                    </a>

                    <div class="d-none d-md-flex gap-4 fw-semibold small text-secondary">
                        <a href="index.html" class="text-gn-pink">Trang chủ</a>
                        <a href="#" class="text-secondary hover-text-gn-pink">Dự án</a>
                        <a href="#" class="text-secondary hover-text-gn-pink">Về chúng tôi</a>
                        <a href="#" class="text-secondary hover-text-gn-pink">Hướng dẫn</a>
                    </div>

                    <div class="d-flex align-items-center gap-3">
                        <button class="btn btn-gn btn-sm px-4 py-2">Ủng hộ ngay</button>
                        
                        <button class="btn btn-light rounded-circle p-2 d-flex align-items-center justify-content-center" style="width: 38px; height: 38px;">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                            </svg>
                        </button>

                        <div class="d-flex align-items-center small text-secondary hover-text-gn-pink" style="cursor: pointer;">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" class="me-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1" />
                            </svg>
                            <a href="#" class="text-inherit">Đăng ký / Đăng nhập</a>
                        </div>
                    </div>
                </nav>
            </div>
        </header>

        <section class="hero-bg position-relative text-white d-flex align-items-center justify-content-center">
            <div class="position-absolute w-100 h-100 top-0 start-0 bg-overlay"></div>
            
            <div class="container position-relative z-1 text-center">
                <div class="d-inline-block bg-gn-pink text-white rounded-pill px-3 py-1 fw-semibold mb-4" style="font-size: 0.75rem;">
                    Nền tảng gây quỹ cộng đồng trực tuyến
                </div>

                <h1 class="display-5 fw-bold mb-5 lh-base">
                    Kết nối gây quỹ và ủng hộ trực tuyến<br>
                    tiện lợi, tin cậy và minh bạch
                </h1>

                <div class="d-flex justify-content-center gap-2 mt-5">
                    <span class="dot active"></span>
                    <span class="dot inactive"></span>
                    <span class="dot inactive"></span>
                </div>
            </div>
        </section>

        <section class="py-5 bg-gn-gray">
            <div class="container py-4">
                <div class="text-center mb-5">
                    <h2 class="fw-bold mb-2 text-dark">Dự án đang gây quỹ</h2>
                    <p class="text-secondary">Hãy lựa chọn đồng hành cùng dự án mà bạn quan tâm</p>
                </div>

                <div class="d-flex flex-wrap justify-content-center gap-2 mb-5">
                    <button class="btn category-btn active">Trẻ em</button>
                    <button class="btn category-btn inactive">Cộng đồng</button>
                    <button class="btn category-btn inactive">Động vật hoang dã</button>
                    <button class="btn category-btn inactive">Giáo dục</button>
                    <button class="btn category-btn inactive">Hoàn cảnh khó khăn</button>
                    <button class="btn category-btn inactive">Môi trường</button>
                    <button class="btn category-btn inactive">Người già neo đơn</button>
                </div>

                <div class="position-relative">
                    <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4">
                        
                        <div class="col">
                            <div class="card card-custom h-100 d-flex flex-column">
                                <div class="aspect-4-3">
                                    <img src="images/project_baby.jpg" alt="Giữ lại thị lực cho cậu bé Duy Khang">
                                    <span class="tag-badge">Y tế</span>
                                </div>

                                <div class="card-body d-flex flex-column p-4">
                                    <div class="d-flex align-items-center mb-3 text-secondary" style="font-size: 0.75rem;">
                                        <img src="images/org_logo.png" alt="Logo" class="me-2" style="height: 24px; width: 24px; border-radius: 50%;">
                                        <span>Quỹ Từ thiện Nâng bước tuổi thơ</span>
                                    </div>

                                    <h5 class="card-title fw-semibold mb-4 flex-grow-1 line-clamp-2 text-dark" style="font-size: 1rem; line-height: 1.5;">
                                        Giữ lại thị lực cho cậu bé Duy Khang
                                    </h5>

                                    <div class="mt-auto">
                                        <div class="d-flex align-items-end justify-content-between small mb-2">
                                            <span class="fw-bold text-gn-pink fs-5">16.092.200₫</span>
                                            <span class="text-secondary">17.9%</span>
                                        </div>
                                        <div class="progress">
                                            <div class="progress-bar" role="progressbar" style="width: 17.9%" aria-valuenow="17.9" aria-valuemin="0" aria-valuemax="100"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col">
                            <div class="card card-custom h-100 d-flex flex-column">
                                <div class="aspect-4-3">
                                    <img src="images/project_help.jpg" alt="Xin giúp người bất hạnh">
                                    <span class="tag-badge">Trẻ em</span>
                                </div>

                                <div class="card-body d-flex flex-column p-4">
                                    <div class="d-flex align-items-center mb-3 text-secondary" style="font-size: 0.75rem;">
                                        <img src="images/org_logo.png" alt="Logo" class="me-2" style="height: 24px; width: 24px; border-radius: 50%;">
                                        <span>Quỹ Từ tâm Đắk Lắk</span>
                                    </div>

                                    <h5 class="card-title fw-semibold mb-4 flex-grow-1 line-clamp-2 text-dark" style="font-size: 1rem; line-height: 1.5;">
                                        Xin giúp người bất hạnh không nhà, không tiền, không sức...
                                    </h5>

                                    <div class="mt-auto">
                                        <div class="d-flex align-items-end justify-content-between small mb-2">
                                            <span class="fw-bold text-gn-pink fs-5">11.952.000₫</span>
                                            <span class="text-secondary">59.8%</span>
                                        </div>
                                        <div class="progress">
                                            <div class="progress-bar" role="progressbar" style="width: 59.8%" aria-valuenow="59.8" aria-valuemin="0" aria-valuemax="100"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col">
                            <div class="card card-custom h-100 d-flex flex-column">
                                <div class="aspect-4-3">
                                    <img src="images/project_family.jpg" alt="Nỗi lòng người mẹ">
                                    <span class="tag-badge">Trẻ em</span>
                                </div>

                                <div class="card-body d-flex flex-column p-4">
                                    <div class="d-flex align-items-center mb-3 text-secondary" style="font-size: 0.75rem;">
                                        <img src="images/org_logo.png" alt="Logo" class="me-2" style="height: 24px; width: 24px; border-radius: 50%;">
                                        <span>Quỹ Từ tâm Đắk Lắk</span>
                                    </div>

                                    <h5 class="card-title fw-semibold mb-4 flex-grow-1 line-clamp-2 text-dark" style="font-size: 1rem; line-height: 1.5;">
                                        Nỗi lòng người mẹ câm điếc nuôi 3 con nhỏ
                                    </h5>

                                    <div class="mt-auto">
                                        <div class="d-flex align-items-end justify-content-between small mb-2">
                                            <span class="fw-bold text-gn-pink fs-5">5.630.000₫</span>
                                            <span class="text-secondary">28.2%</span>
                                        </div>
                                        <div class="progress">
                                            <div class="progress-bar" role="progressbar" style="width: 28.2%" aria-valuenow="28.2" aria-valuemin="0" aria-valuemax="100"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>

                    <div class="d-none d-xl-block">
                        <button class="nav-arrow left">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" /></svg>
                        </button>
                        <button class="nav-arrow right">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" /></svg>
                        </button>
                    </div>
                </div>
            </div>
        </section>

        <footer class="py-4 bg-white border-top border-light mt-auto">
            <div class="container text-center text-secondary small">
                <p class="mb-0">&copy; 2023 GiveNow Platform. All rights reserved.</p>
            </div>
        </footer>

        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmxc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    </body>
</html>