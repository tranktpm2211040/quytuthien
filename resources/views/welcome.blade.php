<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Nhóm dự án vì cộng đồng</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@400;600;700&display=swap" rel="stylesheet">
    <!-- <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script> -->

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
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

        a {
            text-decoration: none;
        }

        .text-gn-pink {
            color: var(--gn-pink) !important;
        }

        .bg-gn-pink {
            background-color: var(--gn-pink) !important;
            color: white;
        }

        .bg-gn-gray {
            background-color: var(--gn-gray) !important;
        }

        .hover-text-gn-pink:hover {
            color: var(--gn-pink) !important;
        }

        .btn-gn {
            background-color: var(--gn-pink);
            color: white;
            border-radius: 50px;
            font-weight: 700;
            transition: all 0.2s ease;
        }

        .btn-gn:hover {
            background-color: #be123c;
            color: white;
        }

        /* --- CSS CHO PHẦN DỰ ÁN --- */
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
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            object-fit: cover;
            border-top-left-radius: 1.5rem;
            border-top-right-radius: 1.5rem;
        }

        .tag-badge {
            position: absolute;
            top: 1rem;
            right: 1rem;
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

        .progress {
            height: 0.5rem;
            border-radius: 50px;
            background-color: #f3f4f6;
        }

        .progress-bar {
            background-color: var(--gn-pink);
            border-radius: 50px;
        }

        .nav-arrow {
            position: absolute;
            top: 50%;
            transform: translateY(-50%);
            width: 48px;
            height: 48px;
            background: white;
            border: 1px solid #e5e7eb;
            border-radius: 50%;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
            display: flex;
            align-items: center;
            justify-content: center;
            color: #9ca3af;
            cursor: pointer;
            transition: all 0.2s;
        }

        .nav-arrow:hover {
            color: var(--gn-pink);
            border-color: var(--gn-pink);
        }

        .nav-arrow.left {
            left: -3rem;
        }

        .nav-arrow.right {
            right: -3rem;
        }
    </style>
</head>

<body>

    @include('header')
    <!-- banner -->
    <section class="p-0">
        <div id="demo" class="carousel slide" data-bs-ride="carousel">

            <div class="carousel-indicators">
                <button type="button" data-bs-target="#demo" data-bs-slide-to="0" class="active"></button>
                <button type="button" data-bs-target="#demo" data-bs-slide-to="1"></button>
                <button type="button" data-bs-target="#demo" data-bs-slide-to="2"></button>
            </div>

            <div class="carousel-inner">

                <div class="carousel-item active">
                    <img src="{{ asset('img/home/banner-1.jpg') }}" alt="Banner 1" class="d-block w-100" style="height: 550px; object-fit: cover;">
                </div>

                <div class="carousel-item">
                    <img src="{{ asset('img/home/banner-2.jpg') }}" alt="Banner 2" class="d-block w-100" style="height: 550px; object-fit: cover;">
                </div>

                <div class="carousel-item">
                    <img src="{{ asset('img/home/banner-3.jpg') }}" alt="Banner 3" class="d-block w-100" style="height: 550px; object-fit: cover;">
                </div>

            </div>

            <button class="carousel-control-prev" type="button" data-bs-target="#demo" data-bs-slide="prev">
                <span class="carousel-control-prev-icon"></span>
            </button>
            <button class="carousel-control-next" type="button" data-bs-target="#demo" data-bs-slide="next">
                <span class="carousel-control-next-icon"></span>
            </button>
        </div>
    </section>

    <!-- content -->
    <section class="bg-gn-gray">
        <div class="container py-4">
            <div class="text-center mb-5">
                <h2 class="fw-bold mb-2 text-dark">Dự án đang gây quỹ</h2>
                <p class="text-secondary">Hãy lựa chọn đồng hành cùng dự án mà bạn quan tâm</p>
            </div>

            <!-- <div class="d-flex flex-wrap justify-content-center gap-2 mb-5">
                <button class="btn category-btn active">Trẻ em</button>
                <button class="btn category-btn inactive">Cộng đồng</button>
                <button class="btn category-btn inactive">Động vật hoang dã</button>
                <button class="btn category-btn inactive">Giáo dục</button>
                <button class="btn category-btn inactive">Hoàn cảnh khó khăn</button>
                <button class="btn category-btn inactive">Môi trường</button>
                <button class="btn category-btn inactive">Người già neo đơn</button>
            </div> -->

            <div class="position-relative">
                <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4">

                    @foreach($campaigns as $campaign)
                    <div class="col">
                        <a href="{{ route('fund.detail', $campaign->id) }}" class="text-decoration-none">
                            <div class="card card-custom h-100 d-flex flex-column border-0 shadow-sm">

                                <div class="aspect-4-3">
                                    <img src="{{ $campaign->image_url ? asset($campaign->image_url) : asset('img/admin/quy-1.jpg') }}" alt="{{ $campaign->title }}">

                                    @if($campaign->category)
                                    <span class="tag-badge">{{ $campaign->category }}</span>
                                    @endif
                                </div>

                                <div class="card-body d-flex flex-column p-4">
                                    <h5 class="card-title fw-bold mb-3 text-dark text-center" style="font-size: 1.2rem; line-height: 1.5;">
                                        {{ $campaign->title }}
                                    </h5>

                                    <p class="text-secondary text-sm mb-4 line-clamp-2 text-center" style="font-size: 0.9rem;" title="{{ $campaign->description }}">
                                        {{ $campaign->description }}
                                    </p>

                                    <div class="mt-auto">
                                        <div class="d-flex justify-content-between align-items-center mb-3 pb-3 border-bottom border-light">
                                            <span class="text-secondary" style="font-size: 0.9rem;">Mục tiêu:</span>
                                            <span class="fw-bold text-gn-pink">{{ number_format($campaign->goal_eth, 2) }} ETH</span>
                                        </div>
                                        <div class="btn btn-gn w-100 py-2">Ủng hộ ngay</div>
                                    </div>
                                </div>

                            </div>
                        </a>
                    </div>
                    @endforeach
                </div>

                @if($campaigns->isEmpty())
                <div class="col-12 text-center py-5 text-secondary w-100">
                    <p class="fs-5">Hiện tại chưa có dự án nào đang cần gây quỹ. Bạn hãy quay lại sau nhé!</p>
                </div>
                @endif

            </div>
        </div>
    </section>

    @include('footer')

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/js/bootstrap.bundle.min.js"></script>

</body>

</html>