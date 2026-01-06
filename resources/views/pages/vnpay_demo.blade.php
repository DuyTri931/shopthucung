<!doctype html>
<html lang="vi">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width,initial-scale=1" />
    <title>VNPay QR</title>
</head>
<body style="margin:0;font-family:Arial,Helvetica,sans-serif;background:#f3f5f9;">
    <div style="max-width:980px;margin:28px auto;padding:0 16px;">
        <div style="display:flex;gap:16px;flex-wrap:wrap;">
            <!-- LEFT -->
            <div style="flex:1;min-width:320px;background:#fff;border-radius:14px;box-shadow:0 10px 30px rgba(16,24,40,.08);overflow:hidden;">
                <div style="padding:18px 18px 10px;border-bottom:1px solid #eef0f4;display:flex;align-items:center;justify-content:space-between;">
                    <div>
                        <div style="font-size:18px;font-weight:700;">Cổng thanh toán VNPay QR</div>
                        <div style="font-size:12px;color:#667085;margin-top:4px;">
                            Sandbox đang báo <b>code=71</b> nên không thể thanh toán thật trên localhost.
                        </div>
                    </div>
                    <!-- BỎ chữ DEMO ở đây -->
                </div>

                <div style="padding:18px;">
                    <div style="display:flex;gap:18px;flex-wrap:wrap;align-items:flex-start;">
                        <!-- QR -->
                        <div style="width:280px;max-width:100%;border:1px dashed #d0d5dd;border-radius:14px;padding:14px;text-align:center;">
                            <div style="font-size:13px;color:#475467;margin-bottom:10px;font-weight:700;">
                                Quét mã QR để thanh toán
                            </div>

                            <!-- chọn ngân hàng -->
                            <div style="text-align:left;margin-bottom:10px;">
                                <div style="font-size:12px;color:#667085;margin-bottom:6px;font-weight:700;">Chọn ngân hàng</div>
                                <select id="bankSelect"
                                    style="width:100%;padding:10px 12px;border:1px solid #d0d5dd;border-radius:10px;outline:none;">
                                    <option value="Vietcombank">Vietcombank (VCB)</option>
                                    <option value="VietinBank">VietinBank (CTG)</option>
                                    <option value="BIDV">BIDV</option>
                                    <option value="ACB">ACB</option>
                                    <option value="MB">MB Bank</option>
                                    <option value="Techcombank">Techcombank</option>
                                    <option value="Sacombank">Sacombank</option>
                                    <option value="VPBank">VPBank</option>
                                </select>

                                <div style="font-size:12px;color:#667085;margin-top:8px;">
                                    Ngân hàng đang chọn: <b id="bankLabel">Vietcombank (VCB)</b>
                                </div>
                            </div>

                            <div id="qr" style="display:inline-block;padding:8px;border-radius:12px;background:#fff;"></div>

                            <div style="font-size:12px;color:#667085;margin-top:10px;line-height:1.4;">
                                Mở camera / app ngân hàng → quét QR<br/>
                                hoặc bấm nút “Thanh toán” bên dưới
                            </div>

                            <div style="margin-top:12px;">
                                <a id="payBtn" href="{{ $payUrl }}"
                                   style="display:inline-block;width:100%;text-align:center;padding:12px 14px;border-radius:10px;background:#d81b60;color:#fff;text-decoration:none;font-weight:700;">
                                    Thanh toán
                                </a>
                            </div>

                            <div style="margin-top:10px;">
                                <a href="{{ route('vnpay.fake_fail', $order->id_dathang) }}"
                                   style="display:inline-block;width:100%;text-align:center;padding:10px 14px;border-radius:10px;background:#ef4444;color:#fff;text-decoration:none;font-weight:700;">
                                    Hủy giao dịch
                                </a>
                            </div>
                        </div>

                        <!-- INFO -->
                        <div style="flex:1;min-width:260px;">
                            <div style="border:1px solid #eef0f4;border-radius:14px;padding:14px;">
                                <div style="font-weight:800;margin-bottom:10px;">Thông tin giao dịch</div>

                                <div style="display:flex;justify-content:space-between;gap:12px;padding:8px 0;border-bottom:1px solid #f2f4f7;">
                                    <span style="color:#667085;">Mã đơn</span>
                                    <b>#{{ $order->id_dathang }}</b>
                                </div>

                                <div style="display:flex;justify-content:space-between;gap:12px;padding:8px 0;border-bottom:1px solid #f2f4f7;">
                                    <span style="color:#667085;">Số tiền</span>
                                    <b style="color:#0f172a;">{{ number_format($order->tongtien) }} VNĐ</b>
                                </div>

                                <div style="display:flex;justify-content:space-between;gap:12px;padding:8px 0;border-bottom:1px solid #f2f4f7;">
                                    <span style="color:#667085;">Nội dung</span>
                                    <b>Thanh toán đơn hàng</b>
                                </div>

                                <div style="display:flex;justify-content:space-between;gap:12px;padding:8px 0;">
                                    <span style="color:#667085;">Trạng thái</span>
                                    <span style="display:inline-block;padding:6px 10px;border-radius:999px;background:#fff7ed;color:#9a3412;font-weight:700;">
                                        {{ $order->trangthai }}
                                    </span>
                                </div>
                            </div>

                            <div style="margin-top:12px;border-radius:14px;background:#0b1220;color:#cbd5e1;padding:14px;line-height:1.5;">
                                <b style="color:#fff;">Lưu ý:</b><br/>
                                ✔ Sandbox bị chặn nên dùng mô phỏng quét QR<br/>
                                ✔ Chọn ngân hàng để đổi thông tin giao dịch & QR
                            </div>

                            <div style="margin-top:12px;">
                                <a href="{{ route('cart') }}" style="color:#2563eb;text-decoration:none;">← Quay lại giỏ hàng</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- RIGHT (Brand / notice) -->
            <div style="width:320px;max-width:100%;background:#fff;border-radius:14px;box-shadow:0 10px 30px rgba(16,24,40,.08);overflow:hidden;">
                <div style="padding:16px;border-bottom:1px solid #eef0f4;">
                    <div style="font-weight:900;font-size:16px;">VNPay QR</div>
                    <div style="font-size:12px;color:#667085;margin-top:6px;">
                        Trang mô phỏng thanh toán quét mã.
                    </div>
                </div>

                <div style="padding:16px;">
                    <div style="border:1px solid #eef0f4;border-radius:14px;padding:14px;">
                        <div style="font-weight:800;">Hướng dẫn</div>
                        <ul style="margin:10px 0 0 18px;color:#475467;line-height:1.5;font-size:13px;">
                            <li>Chọn ngân hàng ở bên trái</li>
                            <li>Quét QR hoặc bấm “Thanh toán”</li>
                            <li>Hệ thống chuyển sang trạng thái thanh toán thành công</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>

        <div style="text-align:center;color:#98a2b3;font-size:12px;margin-top:14px;">
            © VNPay QR - Laravel
        </div>
    </div>

    <!-- QRCode generator (JS) -->
    <script src="https://cdn.jsdelivr.net/npm/qrcodejs@1.0.0/qrcode.min.js"></script>
    <script>
        const basePayUrl = @json($payUrl);

        const bankSelect = document.getElementById('bankSelect');
        const bankLabel  = document.getElementById('bankLabel');
        const payBtn     = document.getElementById('payBtn');

        function buildPayUrlWithBank(bankName) {
            // thêm tham số ?bank=... để nhìn giống thật (dù fake_success không cần dùng)
            const url = new URL(basePayUrl, window.location.origin);
            url.searchParams.set('bank', bankName);
            return url.toString();
        }

        function renderQR(text) {
            const qrDiv = document.getElementById("qr");
            qrDiv.innerHTML = ""; // clear QR cũ
            new QRCode(qrDiv, { text, width: 220, height: 220 });
        }

        function updateByBank() {
            const bank = bankSelect.value;
            bankLabel.textContent = bankSelect.options[bankSelect.selectedIndex].text;

            const payUrl = buildPayUrlWithBank(bank);
            payBtn.href = payUrl;
            renderQR(payUrl);
        }

        // init
        updateByBank();
        bankSelect.addEventListener('change', updateByBank);
    </script>
</body>
</html>
