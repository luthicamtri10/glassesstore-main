<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Bus\CPVC_BUS;
use App\Models\CPVC;
use Illuminate\Support\Facades\DB;

class CPVCController extends Controller
{
    private $cpvcBUS;

    public function __construct()
    {
        $this->cpvcBUS = app(CPVC_BUS::class);
    }

    // Xử lý thêm chi phí vận chuyển
    public function store(Request $request)
    {
        $request->validate([
            'IDTINH' => 'required|integer',
            'IDVC' => 'required|integer',
            'CHIPHIVC' => 'required|numeric|min:0'
        ]);

        try {
            $cpvc = new CPVC(
                $request->IDTINH,
                $request->IDVC,
                $request->CHIPHIVC
            );
            
            $this->cpvcBUS->addModel($cpvc);
            return redirect()->back()->with('success', 'Thêm chi phí vận chuyển thành công');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Lỗi khi thêm chi phí vận chuyển: ' . $e->getMessage());
        }
    }

    public function update(Request $request)
    {
        $request->validate([
            'IDTINH' => 'required|integer',
            'IDVC' => 'required|integer',
            'CHIPHIVC' => 'required|numeric|min:0'
        ]);

        try {
            $cpvc = new CPVC(
                $request->IDTINH,
                $request->IDVC,
                $request->CHIPHIVC
            );
            
            $this->cpvcBUS->updateModel($cpvc);
            return redirect()->back()->with('success', 'Cập nhật chi phí vận chuyển thành công');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Lỗi khi cập nhật chi phí vận chuyển: ' . $e->getMessage());
        }
    }

    // Xử lý xóa chi phí vận chuyển
    public function destroy(Request $request)
    {
        $id = $request->input('id');
        $isActive = $this->cpvcBUS->getModelById($id)?->getTrangThaiHD();
        $this->cpvcBUS->DeleteModel($id, $isActive === 1 ? 0 : 1);
        return redirect()->back()->with('success', 'Xóa thành công!');
    }
}
