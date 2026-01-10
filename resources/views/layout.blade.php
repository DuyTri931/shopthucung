<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quản lý cửa hàng thú cưng</title>

    <link rel="shortcut icon" type="image/png" href="{{ asset('frontend/img/logo.jpg') }}"/>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/css/bootstrap.min.css">
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/js/bootstrap.bundle.min.js"></script>

    <link rel="stylesheet" href="{{ asset('frontend/css/bsgrid.min.css') }}">
    <link rel="stylesheet" href="{{ asset('frontend/css/style.min.css') }}">

    {{-- slick css để slider đẹp --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.8.1/slick.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.8.1/slick-theme.min.css">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta2/css/all.min.css" />
</head>
<body>
<div class="header">
    <div class="navbar">
        <div class="navbar__left">
            <a href="{{ url('/') }}" class="navbar__logo">
                <img src="{{ asset('frontend/img/logo.jpg') }}" alt="">
            </a>

            <div class="navbar__menu">
                <i id="bars" class="fa fa-bars" aria-hidden="true"></i>
                <ul>
                    <li><a href="{{ url('/') }}">Trang chủ</a></li>
                    <li><a href="{{ route('viewAll') }}">Sản Phẩm</a></li>
                    <li><a href="{{ url('/services') }}">Dịch vụ</a></li>
                    <li><a href="{{ url('/donhang') }}">Đơn hàng</a></li>
                </ul>
            </div>
        </div>

        <div class="navbar__center">
            <form action="{{ route('search') }}" method="GET" class="navbar__search">
                <input type="text" value="" placeholder="Nhập để tìm kiếm..." name="tukhoa" class="search" required>
                <i class="fa fa-search" id="searchBtn"></i>
            </form>
        </div>

        <div class="navbar__right">
            @if (Auth::check())
                <span class="mr-2">{{ Auth::user()->hoten }}</span>
                <div class="logout">
                    <form action="{{ route('logout') }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button style="border: none;" type="submit">
                            <i class="fas fa-sign-out-alt text-primary"></i>
                        </button>
                    </form>
                </div>
            @else
                <div class="login">
                    <a href="{{ url('login') }}"><i class="fa fa-user"></i></a>
                </div>
            @endif

            <a href="{{ route('cart') }}" class="navbar__shoppingCart">
                <img src="{{ asset('frontend/img/shopping-cart.svg') }}" style="width: 24px;" alt="">
                <span>{{ session('cart') ? count((array) session('cart')) : 0 }}</span>
            </a>
        </div>
    </div>
</div>

@yield('content')

<div class="go-to-top"><i class="fas fa-chevron-up"></i></div>

<footer>
    <div class="footer">
        <div class="footer__title">
            <span>Liên hệ</span>
            <div class="footer__social">
                <a href="facebook.com/trieuetam" target="_blank"><i class="fab fa-facebook-f"></i></a>
                <a href="#"><i class="fab fa-github"></i></a>
                <a href="#"><i class="fab fa-google"></i></a>
            </div>
        </div>
    </div>

    <div class="footer__info">
        <div class="footer__info-content">
            <h3>Giới thiệu</h3>
            <p>Website quản lý, mua bán thú cưng</p>
        </div>

        <div class="footer__info-content">
            <h3>Liên hệ</h3>
            <p>Địa chỉ: quận 6 TPGCM VN</p>
            <p>Email: chube@gmail.com</p>
            <p>Sđt: 09997676</p>
        </div>

        <div class="footer__info-content">
            <h3>Fanpage</h3>
            <p>
                <iframe src="https://www.facebook.com/plugins/page.php?href=https%3A%2F%2Fwww.facebook.com%2FC%25E1%25BB%25ADa-h%25C3%25A0ng-S%25E1%25BA%25A3n-ph%25E1%25BA%25A9m-D%25C3%25A0nh-cho-Th%25C3%25BA-C%25C6%25B0ng-100178969197228%2F%3Fref%3Dpages_you_manage&tabs=timeline&width=300px&height=150px&small_header=false&adapt_container_width=true&hide_cover=false&show_facepile=true&appId"
                        width="100%" height="150px" style="border:none;overflow:hidden"
                        scrolling="no" frameborder="0" allowfullscreen="true"
                        allow="autoplay; clipboard-write; encrypted-media; picture-in-picture; web-share"></iframe>
            </p>
        </div>
    </div>

    <div class="footer__copyright">
        <center>2022 All rights reserved.</center>
    </div>
</footer>

<script src="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.8.1/slick.min.js"></script>
<script>
    $(document).ready(function () {
        $('.post-wrapper').slick({
            slidesToScroll: 1,
            autoplay: true,
            arrow: true,
            dots: true,
            autoplaySpeed: 5000,
            prevArrow: $('.prev'),
            nextArrow: $('.next'),
            appendDots: $(".dot"),
        });
    });

    $('.post-wrapper2').slick({
        slidesToShow: 5,
        slidesToScroll: 1,
        autoplay: true,
        autoplaySpeed: 2000,
        prevArrow: $('.prev2'),
        nextArrow: $('.next2'),
        responsive: [
            { breakpoint: 1024, settings: { slidesToShow: 4, slidesToScroll: 3, infinite: true } },
            { breakpoint: 600,  settings: { slidesToShow: 3, slidesToScroll: 2 } },
            { breakpoint: 480,  settings: { slidesToShow: 2, slidesToScroll: 1 } }
        ]
    });
</script>

<script src="{{ asset('frontend/script/script.js') }}"></script>
</body>
</html>
