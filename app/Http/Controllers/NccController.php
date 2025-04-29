<?php

namespace App\Http\Controllers;

use App\Bus\NCC_BUS;
use App\Models\NCC;
use Illuminate\Http\Request;

class NccController extends Controller
{
    private $nccBus;

    public function __construct()
    {
        $this->nccBus = NCC_BUS::getInstance();
    }

    public function index()
    {
        $listNCC = $this->nccBus->getAllModels();
        return view('admin.nhacungcap', compact('listNCC'));
    }

    public function store(Request $request)
    {
        $ncc = new NCC(
            null,
            $request->TENNCC,
            $request->SODIENTHOAI,
            $request->MOTA,
            $request->DIACHI,
            $request->TRANGTHAIHD
        );

        $this->nccBus->addModel($ncc);
        return redirect()->route('admin.supplier.index')->with('success', 'Thêm nhà cung cấp thành công');
    }

    public function update(Request $request, $id)
    {
        $ncc = new NCC(
            $id,
            $request->TENNCC,
            $request->SODIENTHOAI,
            $request->MOTA,
            $request->DIACHI,
            $request->TRANGTHAIHD
        );

        $this->nccBus->updateModel($ncc);
        return redirect()->route('admin.supplier.index')->with('success', 'Cập nhật nhà cung cấp thành công');
    }

    public function destroy($id)
    {
        $this->nccBus->deleteModel($id);
        return redirect()->route('admin.supplier.index')->with('success', 'Xóa nhà cung cấp thành công');
    }

    public function search(Request $request)
    {
        $keyword = $request->input('keyword');
        $columns = ['TENNCC', 'SODIENTHOAI', 'DIACHI'];
        $listNCC = $this->nccBus->searchModel($keyword, $columns);
        return view('admin.nhacungcap', compact('listNCC'));
    }
}
