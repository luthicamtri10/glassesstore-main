<?php
namespace App\Http\Controllers;

use App\Bus\CTGH_BUS;
use App\Bus\CTSP_BUS;
use App\Bus\GioHang_BUS;
use App\Http\Controllers\Controller;
use App\Models\CTGH;
use Illuminate\Http\Request;

class GioHangController extends Controller {
    public function updateQuantity(Request $request)
    {
        $idgh = $request->input('idgh');
        $idsp = $request->input('idsp');
        $action = $request->input('action'); // 'increase' hoặc 'decrease'

        $ctgh = app(CTGH_BUS::class)->getCTGHByIDGHAndIDSP($idgh, $idsp);

        if (!$ctgh) {
            return back()->withErrors(['Sản phẩm không tồn tại trong giỏ hàng']);
        }

        $list = app(CTSP_BUS::class)->getCTSPIsNotSoldByIDSP($idsp);
        if (count($list) >= 1) {
            $soluong = $ctgh->getSoLuong();
            if ($action === 'increase') {
                $soluong++;
            } elseif ($action === 'decrease' && $soluong > 1) {
                $soluong--;
            }

            $ctgh->setSoLuong($soluong);
            app(\App\Bus\CTGH_BUS::class)->updateCTGH($ctgh);

            return redirect()->back();
        } else {
            return back()->withErrors(['Hiện tại sản phẩm đang hết hàng']);
        }
    }
    public function deleteCTGH(Request $request) {
        $idgh = $request->input('idgh');
        $idsp = $request->input('idsp');
        app(CTGH_BUS::class)->deleteCTGH($idgh, $idsp);
        return redirect()->back()->with('success','Xóa khỏi giỏ hàng thành công!');
    }
    public function search(Request $request) {
        $idgh = $request->input('idgh');
        $keyword = $request->input('keyword');
    
        // Lấy danh sách sản phẩm trong giỏ hàng theo từ khóa
        $listCTGH = app(CTGH_BUS::class)->searchCTGHByKeyword($idgh, $keyword);
    
        // Trả về view với danh sách tìm kiếm
        return view('client.userCart', [
            'listCTGH' => $listCTGH,
            'keyword' => $keyword // Để giữ từ khóa trong input
        ]);
    }
}
?>