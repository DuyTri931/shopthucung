<?php

namespace App\Http\Controllers\admin;

use Illuminate\Http\Request;
use App\Models\Danhmuc;
use App\Http\Controllers\Controller;
use App\Repositories\IProductRepository;

class ProductController extends Controller
{
    private $productRepository;

    public function __construct(IProductRepository $productRepository)
    {
        $this->productRepository = $productRepository;
    }

    public function index()
    {
        $products = $this->productRepository->allProduct();
        return view('admin.products.index', ['products' => $products]);
    }

    public function create()
    {
        $list_danhmucs = Danhmuc::all();
        return view('admin.products.create', ['list_danhmucs' => $list_danhmucs]);
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'tensp' => 'required|string|max:255',
            'anhsp' => 'required|image|mimes:jpg,jpeg,png,webp,gif|max:5120',
            'giasp' => 'required|numeric|min:0',
            'mota' => 'nullable|string',
            'giamgia' => 'nullable|numeric|min:0|max:100',
            'giakhuyenmai' => 'nullable|numeric|min:0',
            'soluong' => 'required|numeric|min:0',
            'id_danhmuc' => 'required'
        ]);

        // ✅ Lưu ảnh vào: public/frontend/upload
        // $imagePath trả về: upload/xxxx.jpg
        $imagePath = $request->file('anhsp')->store('upload', 'public_frontend');

        // ✅ Lưu DB chỉ: upload/xxxx.jpg
        $validatedData['anhsp'] = $imagePath;

        // ✅ Tính giá khuyến mãi (nếu không nhập giảm giá => 0)
        $giagoc = (float) $validatedData['giasp'];
        $giamgia = isset($validatedData['giamgia']) ? (float) $validatedData['giamgia'] : 0;

        $validatedData['giakhuyenmai'] = $giagoc - (($giagoc * $giamgia) / 100);

        $this->productRepository->storeProduct($validatedData);

        return redirect()->route('product.index')->with('success', 'Thêm sản phẩm thành công');
    }

    public function edit($id)
    {
        $list_danhmucs = Danhmuc::all();
        $product = $this->productRepository->findProduct($id);

        return view('admin.products.edit', [
            'product' => $product,
            'list_danhmucs' => $list_danhmucs
        ]);
    }

    public function update($id, Request $request)
    {
        $validatedData = $request->validate([
            'tensp' => 'required|string|max:255',
            'anhsp' => 'nullable|image|mimes:jpg,jpeg,png,webp,gif|max:5120',
            'giasp' => 'required|numeric|min:0',
            'mota' => 'nullable|string',
            'giamgia' => 'nullable|numeric|min:0|max:100',
            'giakhuyenmai' => 'nullable|numeric|min:0',
            'soluong' => 'required|numeric|min:0',
            'id_danhmuc' => 'required'
        ]);

        // ✅ Nếu có chọn ảnh mới thì lưu vào public/frontend/upload
        if ($request->hasFile('anhsp')) {
            $imagePath = $request->file('anhsp')->store('upload', 'public_frontend');
            $validatedData['anhsp'] = $imagePath; // upload/xxx.jpg
        } else {
            // ✅ Giữ ảnh cũ (anhsp1 phải lưu kiểu upload/xxx.jpg)
            $validatedData['anhsp'] = $request->anhsp1;
        }

        // ✅ Tính giá khuyến mãi
        $giagoc = (float) $validatedData['giasp'];
        $giamgia = isset($validatedData['giamgia']) ? (float) $validatedData['giamgia'] : 0;

        $validatedData['giakhuyenmai'] = $giagoc - (($giagoc * $giamgia) / 100);

        $this->productRepository->updateProduct($validatedData, $id);

        return redirect()->route('product.index')->with('success', 'Cập nhập sản phẩm thành công');
    }

    public function destroy($id)
    {
        $this->productRepository->deleteProduct($id);
        return redirect()->route('product.index')->with('success', 'Xóa sản phẩm thành công');
    }
}
