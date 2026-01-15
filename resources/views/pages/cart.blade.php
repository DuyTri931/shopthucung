@extends('layout')
@section('content')

<style>
.quantity-input { display:flex; align-items:center; }
.quantity-btn{
    background-color:#ff4500;border:none;color:#fff;cursor:pointer;
    padding:8px 15px;transition:background-color .3s ease,color .3s ease;
    box-shadow:0 2px 4px rgba(0,0,0,.1);font-weight:bold;font-size:14px;
}
.quantity-btn:hover{ background-color:#ff5a1f; }
.quantity-field::-webkit-outer-spin-button,
.quantity-field::-webkit-inner-spin-button{ -webkit-appearance:none;margin:0; }
.quantity-field:focus::-webkit-outer-spin-button,
.quantity-field:focus::-webkit-inner-spin-button{ -webkit-appearance:none;margin:0; }
.quantity-field{
    width:50px;text-align:center;padding:8px 0px;outline:none;border:none;border-top:.px solid;
}
</style>

@php
    $fallbackImg = asset('frontend/upload/abc.png'); // ảnh mặc định
@endphp

<div class="body">

    @if(session('success'))
        <div class="alert alert-success mt-3">
            {{ session('success') }}
        </div>
    @endif

    <table id="cart" class="table table-hover table-condensed">
        <thead>
        <tr>
            <th>Ảnh sp</th>
            <th>Tên sp</th>
            <th>Giá gốc</th>
            <th>Giảm giá</th>
            <th>Giá khuyến mại</th>
            <th>Số lượng</th>
            <th>Tổng tiền</th>
        </tr>
        </thead>

        <tbody>
        @php $total = 0 @endphp

        @if(session('cart'))
            @foreach(session('cart') as $id => $details)
                @php
                    $total += ($details['giakhuyenmai'] ?? 0) * ($details['quantity'] ?? 0);

                    // ảnh từ session cart: có thể là "/frontend/upload/xxx.jpg" hoặc "frontend/upload/xxx.jpg"
                    $img = $details['anhsp'] ?? '';
                    $imgUrl = $img ? asset(ltrim($img, '/')) : $fallbackImg;
                @endphp

                <tr data-id="{{ $id }}">
                    <td>
                        <img
                            src="{{ $imgUrl }}"
                            width="100"
                            height="100"
                            class="img-responsive"
                            alt="Ảnh sản phẩm"
                            onerror="this.onerror=null;this.src='{{ $fallbackImg }}';"
                        />
                    </td>

                    <td>
                        <div>{{ $details['tensp'] ?? '' }}</div>
                        <button class="btn btn-danger btn-sm cart_remove mt-2">
                            <i class="fa fa-trash-o"></i> Xóa
                        </button>
                    </td>

                    <td data-th="Price">{{ $details['giasp'] ?? 0 }}</td>
                    <td data-th="Price">{{ $details['giamgia'] ?? 0 }}%</td>
                    <td data-th="Subtotal" class="text-center">{{ $details['giakhuyenmai'] ?? 0 }}đ</td>

                    <td data-th="Quantity" class="quantity-input">
                        <button class="quantity-btn decreaseValue">-</button>
                        <input class="quantity-field quantity cart_update"
                               type="number" min="1" max="999"
                               value="{{ $details['quantity'] ?? 1 }}">
                        <button class="quantity-btn increaseValue">+</button>
                    </td>

                    <td class="text-center">
                        {{ ($details['giakhuyenmai'] ?? 0) * ($details['quantity'] ?? 0) }}đ
                    </td>
                </tr>
            @endforeach
        @endif
        </tbody>

        <tfoot>
        <tr>
            <td colspan="7" class="text-right">
                <h3 class="d-flex justify-content-end align-items-center">
                    Tổng thanh toán &nbsp;
                    <div class="text-danger" style="font-size: 40px;">
                        {{ number_format($total, 0, ',', '.') }}đ
                    </div>
                </h3>
            </td>
        </tr>

        <tr>
            <td colspan="7" class="text-right">
                <a href="{{ url('/') }}" class="btn btn-danger">
                    <i class="fa fa-arrow-left"></i> Tiếp tục mua sắm
                </a>
                <button class="btn btn-success">
                    <a class="text-white" href="{{ route('checkout') }}">Mua hàng</a>
                </button>
            </td>
        </tr>
        </tfoot>
    </table>
</div>

<script type="text/javascript">
var decreaseValues = document.querySelectorAll('.decreaseValue');
decreaseValues.forEach(function(decreaseValue) {
    decreaseValue.addEventListener('click', function(e) {
        e.preventDefault();

        // chỉ giảm trong đúng dòng
        var row = this.closest('tr');
        var quantity = row.querySelector('.quantity');

        var value = parseInt(quantity.value, 10);
        var min = parseInt(quantity.getAttribute('min'), 10);

        if (!isNaN(min) && value > min) {
            quantity.value = value - 1;
        }

        var ele = $(this);
        $.ajax({
            url: '{{ route('update_cart') }}',
            method: "patch",
            data: {
                _token: '{{ csrf_token() }}',
                id: ele.parents("tr").attr("data-id"),
                quantity: ele.parents("tr").find(".quantity").val()
            },
            success: function () { window.location.reload(); }
        });
    });
});

var increaseValues = document.querySelectorAll('.increaseValue');
increaseValues.forEach(function(increaseValue) {
    increaseValue.addEventListener('click', function(e) {
        e.preventDefault();

        var row = this.closest('tr');
        var quantity = row.querySelector('.quantity');

        var value = parseInt(quantity.value, 10);
        value = isNaN(value) ? 1 : value;
        quantity.value = value + 1;

        var ele1 = $(this);
        $.ajax({
            url: '{{ route('update_cart') }}',
            method: "patch",
            data: {
                _token: '{{ csrf_token() }}',
                id: ele1.parents("tr").attr("data-id"),
                quantity: ele1.parents("tr").find(".quantity").val()
            },
            success: function () { window.location.reload(); }
        });
    });
});

var cart_updates = document.querySelectorAll('.cart_update');
cart_updates.forEach(function(cart_update) {
    cart_update.addEventListener('change', function (e) {
        e.preventDefault();

        var value = parseInt(this.value, 10);
        var min = parseInt(this.getAttribute('min'), 10);
        var max = parseInt(this.getAttribute('max'), 10);

        if (isNaN(value) || value < min) this.value = min;
        else if (value > max) this.value = max;

        var ele = $(this);
        $.ajax({
            url: '{{ route('update_cart') }}',
            method: "patch",
            data: {
                _token: '{{ csrf_token() }}',
                id: ele.parents("tr").attr("data-id"),
                quantity: ele.parents("tr").find(".quantity").val()
            },
            success: function () { window.location.reload(); }
        });
    });
});

var cart_removes = document.querySelectorAll('.cart_remove');
cart_removes.forEach(function(cart_remove) {
    cart_remove.addEventListener('click', function(e) {
        e.preventDefault();

        var ele3 = $(this);
        if(confirm("Bạn có thật sự muốn xóa?")) {
            $.ajax({
                url: '{{ route('remove_from_cart') }}',
                method: "DELETE",
                data: {
                    _token: '{{ csrf_token() }}',
                    id: ele3.parents("tr").attr("data-id")
                },
                success: function () { window.location.reload(); }
            });
        }
    })
})
</script>

@endsection
