@extends('layout')
@section('content')

@php
    $dogproducts = $dogproducts ?? [];
    $catproducts = $catproducts ?? [];
    $choGiongs   = $choGiongs ?? [];
    $meoGiongs   = $meoGiongs ?? [];
    $alls        = $alls ?? [];
@endphp

@php
    // fallback ảnh (đặt file abc.png trong public/frontend/upload/abc.png)
    $fallbackImg = '/frontend/upload/abc.png';
@endphp

<div class="post-slider">
    <i class="fa fa-chevron-left prev" aria-hidden="true"></i>
    <i class="fa fa-chevron-right next" aria-hidden="true"></i>

    <div class="post-wrapper">
        <div class="post">
            <img src="{{ asset('frontend/img/bn6.jpg') }}" alt="">
        </div>
        <div class="post">
            <img src="{{ asset('frontend/img/bn7.jpg') }}" alt="">
        </div>
    </div>
</div>

<!-- Sản phẩm cho chó -->
<div class="body">
    <div class="body__mainTitle d-flex align-items-center">
        <h2>Sản phẩm dành cho chó</h2>
    </div>

    <div class="dogfood active">
        <div class="row">
            @forelse($dogproducts as $dogproduct)
                <div class="col-lg-2_5 col-md-4 col-6 post2">
                    <a href="{{ route('detail', ['id' => $dogproduct->id_sanpham]) }}">
                        <div class="product">
                            <div class="product__img">
                                <img
                                    src="{{ $dogproduct->anhsp ?: $fallbackImg }}"
                                    alt="{{ $dogproduct->tensp ?? '' }}"
                                    onerror="this.onerror=null;this.src='{{ $fallbackImg }}';"
                                >
                            </div>

                            <div class="product__sale">
                                <div>
                                    @if(!empty($dogproduct->giamgia))
                                        -{{ $dogproduct->giamgia }}%
                                    @else
                                        Mới
                                    @endif
                                </div>
                            </div>

                            <div class="product__content">
                                <div class="product__title">
                                    {{ $dogproduct->tensp ?? 'Sản phẩm' }}
                                </div>

                                <div class="product__pride-oldPride">
                                    <span class="Price">
                                        <bdi>
                                            {{ number_format((float)($dogproduct->giasp ?? 0), 0, ',', '.') }}
                                            <span class="currencySymbol">₫</span>
                                        </bdi>
                                    </span>
                                </div>

                                <div class="product__pride-newPride">
                                    <span class="Price">
                                        <bdi>
                                            {{ number_format((float)($dogproduct->giakhuyenmai ?? ($dogproduct->giasp ?? 0)), 0, ',', '.') }}
                                            <span class="currencySymbol">₫</span>
                                        </bdi>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>
            @empty
                <div class="col-12">
                    <p class="text-center">Chưa có sản phẩm dành cho chó.</p>
                </div>
            @endforelse
        </div>
    </div>

    <!-- dogstyle placeholder -->
    <div class="dogstyle">
        <div class="row">
            <div class="col-lg-2_5 col-md-4 col-6 post2">
                <a href="#">
                    <div class="product">
                        <div class="product__img">
                            <img src="{{ $fallbackImg }}" alt="" onerror="this.onerror=null;this.src='{{ $fallbackImg }}';">
                        </div>
                        <div class="product__sale"><div>Mới</div></div>

                        <div class="product__content">
                            <div class="product__title">Sản phẩm mẫu</div>
                            <div class="product__pride-oldPride"><span class="Price"><bdi>300000 <span class="currencySymbol">₫</span></bdi></span></div>
                            <div class="product__pride-newPride"><span class="Price"><bdi>250000 <span class="currencySymbol">₫</span></bdi></span></div>
                        </div>
                    </div>
                </a>
            </div>
        </div>
    </div>

    <!-- dogequi placeholder -->
    <div class="dogequi">
        <div class="row">
            <div class="col-lg-2_5 col-md-4 col-6 post2">
                <a href="#">
                    <div class="product">
                        <div class="product__img">
                            <img src="{{ $fallbackImg }}" alt="" onerror="this.onerror=null;this.src='{{ $fallbackImg }}';">
                        </div>
                        <div class="product__sale"><div>Mới</div></div>

                        <div class="product__content">
                            <div class="product__title">Sản phẩm mẫu</div>
                            <div class="product__pride-oldPride"><span class="Price"><bdi>300000 <span class="currencySymbol">₫</span></bdi></span></div>
                            <div class="product__pride-newPride"><span class="Price"><bdi>250000 <span class="currencySymbol">₫</span></bdi></span></div>
                        </div>
                    </div>
                </a>
            </div>
        </div>
    </div>
</div>

<div class="banner">
    <div class="banner-top">
        <img src="{{ asset('frontend/img/BG-2.jpg') }}" alt="">
    </div>
</div>

<!-- Sản phẩm cho mèo -->
<div class="body">
    <div class="body__mainTitle d-flex align-items-center">
        <h2>Sản phẩm dành cho mèo</h2>
    </div>

    <div class="catfood active">
        <div class="row">
            @forelse($catproducts as $catproduct)
                <div class="col-lg-2_5 col-md-4 col-6 post2">
                    <a href="{{ route('detail', ['id' => $catproduct->id_sanpham]) }}">
                        <div class="product">
                            <div class="product__img">
                                <img
                                    src="{{ $catproduct->anhsp ?: $fallbackImg }}"
                                    alt="{{ $catproduct->tensp ?? '' }}"
                                    onerror="this.onerror=null;this.src='{{ $fallbackImg }}';"
                                >
                            </div>

                            <div class="product__sale">
                                <div>
                                    @if(!empty($catproduct->giamgia))
                                        -{{ $catproduct->giamgia }}%
                                    @else
                                        Mới
                                    @endif
                                </div>
                            </div>

                            <div class="product__content">
                                <div class="product__title">{{ $catproduct->tensp ?? 'Sản phẩm' }}</div>

                                <div class="product__pride-oldPride">
                                    <span class="Price">
                                        <bdi>
                                            {{ number_format((float)($catproduct->giasp ?? 0), 0, ',', '.') }}
                                            <span class="currencySymbol">₫</span>
                                        </bdi>
                                    </span>
                                </div>

                                <div class="product__pride-newPride">
                                    <span class="Price">
                                        <bdi>
                                            {{ number_format((float)($catproduct->giakhuyenmai ?? ($catproduct->giasp ?? 0)), 0, ',', '.') }}
                                            <span class="currencySymbol">₫</span>
                                        </bdi>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>
            @empty
                <div class="col-12"><p class="text-center">Chưa có sản phẩm dành cho mèo.</p></div>
            @endforelse
        </div>
    </div>

    <!-- catstyle placeholder -->
    <div class="catstyle">
        <div class="row">
            <div class="col-lg-2_5 col-md-4 col-6 post2">
                <a href="#">
                    <div class="product">
                        <div class="product__img">
                            <img src="{{ $fallbackImg }}" alt="" onerror="this.onerror=null;this.src='{{ $fallbackImg }}';">
                        </div>
                        <div class="product__sale"><div>Mới</div></div>
                        <div class="product__content">
                            <div class="product__title">Sản phẩm mẫu</div>
                            <div class="product__pride-oldPride"><span class="Price"><bdi>300000 <span class="currencySymbol">₫</span></bdi></span></div>
                            <div class="product__pride-newPride"><span class="Price"><bdi>250000 <span class="currencySymbol">₫</span></bdi></span></div>
                        </div>
                    </div>
                </a>
            </div>
        </div>
    </div>

    <!-- catequi placeholder -->
    <div class="catequi">
        <div class="row">
            <div class="col-lg-2_5 col-md-4 col-6 post2">
                <a href="#">
                    <div class="product">
                        <div class="product__img">
                            <img src="{{ $fallbackImg }}" alt="" onerror="this.onerror=null;this.src='{{ $fallbackImg }}';">
                        </div>
                        <div class="product__sale"><div>Mới</div></div>
                        <div class="product__content">
                            <div class="product__title">Sản phẩm mẫu</div>
                            <div class="product__pride-oldPride"><span class="Price"><bdi>300000 <span class="currencySymbol">₫</span></bdi></span></div>
                            <div class="product__pride-newPride"><span class="Price"><bdi>250000 <span class="currencySymbol">₫</span></bdi></span></div>
                        </div>
                    </div>
                </a>
            </div>
        </div>
    </div>
</div>

<div class="banner">
    <div class="row banner-top">
        <img class="col-md-4 col-sm-6" src="{{ asset('frontend/img/BG-1.jpg') }}" alt="">
        <img class="col-md-4 col-sm-6" src="{{ asset('frontend/img/BG-2.jpg') }}" alt="">
        <img class="col-md-4 col-sm-6" src="{{ asset('frontend/img/BG-3.jpg') }}" alt="">
    </div>
</div>

<!-- Con giống -->
<div class="body">
    <div class="body__mainTitle d-flex align-items-center">
        <h2>Con giống</h2>
    </div>

    <div class="dog active">
        <div class="row">
            @forelse($choGiongs as $choGiong)
                <div class="col-lg-2_5 col-md-4 col-6 post2">
                    <a href="{{ route('detail', ['id' => $choGiong->id_sanpham]) }}">
                        <div class="product">
                            <div class="product__img">
                                <img
                                    src="{{ $choGiong->anhsp ?: $fallbackImg }}"
                                    alt="{{ $choGiong->tensp ?? '' }}"
                                    onerror="this.onerror=null;this.src='{{ $fallbackImg }}';"
                                >
                            </div>

                            <div class="product__sale">
                                <div>
                                    @if(!empty($choGiong->giamgia))
                                        -{{ $choGiong->giamgia }}%
                                    @else
                                        Mới
                                    @endif
                                </div>
                            </div>

                            <div class="product__content">
                                <div class="product__title">{{ $choGiong->tensp ?? 'Sản phẩm' }}</div>

                                <div class="product__pride-oldPride">
                                    <span class="Price">
                                        <bdi>
                                            {{ number_format((float)($choGiong->giasp ?? 0), 0, ',', '.') }}
                                            <span class="currencySymbol">₫</span>
                                        </bdi>
                                    </span>
                                </div>

                                <div class="product__pride-newPride">
                                    <span class="Price">
                                        <bdi>
                                            {{ number_format((float)($choGiong->giakhuyenmai ?? ($choGiong->giasp ?? 0)), 0, ',', '.') }}
                                            <span class="currencySymbol">₫</span>
                                        </bdi>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>
            @empty
                <div class="col-12"><p class="text-center">Chưa có con giống (chó).</p></div>
            @endforelse
        </div>
    </div>

    <div class="cat">
        <div class="row">
            @forelse($meoGiongs as $meoGiong)
                <div class="col-lg-2_5 col-md-4 col-6 post2">
                    <a href="{{ route('detail', ['id' => $meoGiong->id_sanpham]) }}">
                        <div class="product">
                            <div class="product__img">
                                <img
                                    src="{{ $meoGiong->anhsp ?: $fallbackImg }}"
                                    alt="{{ $meoGiong->tensp ?? '' }}"
                                    onerror="this.onerror=null;this.src='{{ $fallbackImg }}';"
                                >
                            </div>

                            <div class="product__sale">
                                <div>
                                    @if(!empty($meoGiong->giamgia))
                                        -{{ $meoGiong->giamgia }}%
                                    @else
                                        Mới
                                    @endif
                                </div>
                            </div>

                            <div class="product__content">
                                <div class="product__title">{{ $meoGiong->tensp ?? 'Sản phẩm' }}</div>

                                <div class="product__pride-oldPride">
                                    <span class="Price">
                                        <bdi>
                                            {{ number_format((float)($meoGiong->giasp ?? 0), 0, ',', '.') }}
                                            <span class="currencySymbol">₫</span>
                                        </bdi>
                                    </span>
                                </div>

                                <div class="product__pride-newPride">
                                    <span class="Price">
                                        <bdi>
                                            {{ number_format((float)($meoGiong->giakhuyenmai ?? ($meoGiong->giasp ?? 0)), 0, ',', '.') }}
                                            <span class="currencySymbol">₫</span>
                                        </bdi>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>
            @empty
                <div class="col-12"><p class="text-center">Chưa có con giống (mèo).</p></div>
            @endforelse
        </div>
    </div>
</div>

<!-- Tất cả sản phẩm -->
<div class="body">
    <div class="body__mainTitle">
        <h2>TẤT CẢ SẢN PHẨM</h2>
    </div>

    <div>
        <div class="row">
            @forelse($alls as $all)
                <div class="col-lg-2_5 col-md-4 col-6 post2">
                    <a href="{{ route('detail', ['id' => $all->id_sanpham]) }}">
                        <div class="product">
                            <div class="product__img">
                                <img
                                    src="{{ $all->anhsp ?: $fallbackImg }}"
                                    alt="{{ $all->tensp ?? '' }}"
                                    onerror="this.onerror=null;this.src='{{ $fallbackImg }}';"
                                >
                            </div>

                            <div class="product__sale">
                                <div>
                                    @if(!empty($all->giamgia))
                                        -{{ $all->giamgia }}%
                                    @else
                                        Mới
                                    @endif
                                </div>
                            </div>

                            <div class="product__content">
                                <div class="product__title">{{ $all->tensp ?? 'Sản phẩm' }}</div>

                                <div class="product__pride-oldPride">
                                    <span class="Price">
                                        <bdi>
                                            {{ number_format((float)($all->giasp ?? 0), 0, ',', '.') }}
                                            <span class="currencySymbol">₫</span>
                                        </bdi>
                                    </span>
                                </div>

                                <div class="product__pride-newPride">
                                    <span class="Price">
                                        <bdi>
                                            {{ number_format((float)($all->giakhuyenmai ?? ($all->giasp ?? 0)), 0, ',', '.') }}
                                            <span class="currencySymbol">₫</span>
                                        </bdi>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>
            @empty
                <div class="col-12"><p class="text-center">Chưa có sản phẩm.</p></div>
            @endforelse
        </div>
    </div>
</div>

<center style="margin-top: 30px;">
    <a href="{{ route('viewAll') }}" class="btn text-white" style="background: #ff4500;">Xem thêm</a>
</center>

@endsection
