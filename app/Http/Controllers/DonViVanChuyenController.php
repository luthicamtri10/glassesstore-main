<?php

namespace App\Http\Controllers;

use App\Bus\DonViVanChuyen_BUS;
use App\Models\DonViVanChuyen;
use Illuminate\Http\Request;

class DonViVanChuyenController extends Controller
{
    private $dvvcBus;

    public function __construct()
    {
        $this->dvvcBus = app(DonViVanChuyen_BUS::class);
    }

 

    public function store(Request $request)
    {
        $dvvc = new DonViVanChuyen([
            'TENDV' => $request->TENDV,
            'MOTA' => $request->MOTA,
            'TRANGTHAIHD' => $request->TRANGTHAIHD
        ]);

        $this->dvvcBus->addModel($dvvc);
        return redirect()->back()->with('success', 'Thêm đơn vị vận chuyển thành công');
    }

    public function update(Request $request)
    {
        $id = (int)$request->input('id');
        
        if (!$id) {
            return redirect()->back()->with('error', 'ID không hợp lệ');
        }
        
        $dvvc = $this->dvvcBus->getModelById($id);
        
        if ($dvvc) {
            $dvvc->setTenDV($request->TENDV);
            $dvvc->setMoTa($request->MOTA);
            $dvvc->setTrangThaiHD($request->TRANGTHAIHD);
            
            $this->dvvcBus->updateModel($dvvc);
            return redirect()->back()->with('success', 'Cập nhật đơn vị vận chuyển thành công');
        }
        
        return redirect()->back()->with('error', 'Không tìm thấy đơn vị vận chuyển');
    }

    public function destroy(Request $request)
    {
        $id = $request->input('id');
        $isActive = $this->dvvcBus->getModelById($id)?->getTrangThaiHD();
        $this->dvvcBus->DeleteModel($id, $isActive === 1 ? 0 : 1);
        return redirect()->back()->with('success', 'Xóa đơn vị vận chuyển thành công');
    }


    public function search(Request $request)
    {
        $keyword = $request->input('keyword');
        $columns = ['TENDV'];
        $listDVVC = $this->dvvcBus->searchModel($keyword, $columns);
        $current_page = request()->query('page', 1);
        $limit = 8;
        $total_record = count($listDVVC ?? []);
        $total_page = ceil($total_record / $limit);
        $current_page = max(1, min($current_page, $total_page));
        $start = ($current_page - 1) * $limit;
        if(empty($listDVVC)) {
            $tmp = [];
        } else {
            $tmp = array_slice($listDVVC, $start, $limit);
        }
        return view('admin.donvivanchuyen', [
            'listDVVC' => $tmp,
            'current_page' => $current_page,
            'total_page' => $total_page
        ]);
    }
} 