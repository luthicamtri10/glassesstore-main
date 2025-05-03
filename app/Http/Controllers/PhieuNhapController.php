<?php

namespace App\Http\Controllers;

use App\Bus\PhieuNhap_BUS;
use App\Bus\NCC_BUS;
use App\Bus\SanPham_BUS;
use App\Models\PhieuNhap;
use App\Models\CTPN;
use Illuminate\Http\Request;
use App\Enum\ReceiptStatus;

class PhieuNhapController extends Controller
{
    private $phieuNhapBus;
    private $nccBus;
    private $sanPhamBus;

    public function __construct()
    {
        $this->phieuNhapBus = app(PhieuNhap_BUS::class);
        $this->nccBus = app(NCC_BUS::class);
        $this->sanPhamBus = app(SanPham_BUS::class);
    }

    public function index()
    {
        $listPhieuNhap = $this->phieuNhapBus->getAllModels();
        $listNCC = $this->nccBus->getAllModels();
        $listSanPham = $this->sanPhamBus->getAllModels();

        $current_page = request()->query('page', 1);
        $limit = 8;
        $total_record = count($listPhieuNhap ?? []);
        $total_page = ceil($total_record / $limit);
        $current_page = max(1, min($current_page, $total_page));
        $start = ($current_page - 1) * $limit;
        
        if(empty($listPhieuNhap)) {
            $tmp = [];
        } else {
            $tmp = array_slice($listPhieuNhap, $start, $limit);
        }

        return view('admin.phieunhap', [
            'listPhieuNhap' => $tmp,
            'listNCC' => $listNCC,
            'listSanPham' => $listSanPham,
            'current_page' => $current_page,
            'total_page' => $total_page
        ]);
    }

    public function store(Request $request)
    {
        try {
            // Lấy ID lớn nhất hiện tại và tăng lên 1
            $maxId = $this->phieuNhapBus->getMaxId();
            $newId = $maxId ? $maxId + 1 : 1;

            // Tạo phiếu nhập
            $phieuNhap = new PhieuNhap(
                $newId,
                $request->idNCC,
                0, // Tổng tiền sẽ được tính sau
                $request->ngayNhap,
                1, // ID nhân viên mặc định
                ReceiptStatus::UNPAID
            );

            // Thêm phiếu nhập vào database
            $idPhieuNhap = $this->phieuNhapBus->addModel($phieuNhap);
            if (!$idPhieuNhap) {
                throw new \Exception('Không thể tạo phiếu nhập');
            }

            // Thêm chi tiết phiếu nhập
            $tongTien = 0;
            foreach ($request->chiTiet as $chiTiet) {
                $ctpn = new CTPN(
                    $idPhieuNhap,
                    $chiTiet['id'],
                    $chiTiet['soLuong'],
                    $chiTiet['giaNhap'],
                    $chiTiet['phanTramLN']
                );

                $result = $this->phieuNhapBus->addCTPN($ctpn);
                if (!$result) {
                    throw new \Exception('Không thể thêm chi tiết phiếu nhập');
                }

                $tongTien += $chiTiet['soLuong'] * $chiTiet['giaNhap'];
            }

            // Cập nhật tổng tiền cho phiếu nhập
            $phieuNhap->setId($idPhieuNhap);
            $phieuNhap->setTongTien($tongTien);
            $this->phieuNhapBus->updateModel($phieuNhap);

            return response()->json(['success' => true, 'message' => 'Thêm phiếu nhập thành công']);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }

    public function search(Request $request)
    {
        $keyword = $request->input('keyword');
        $columns = ['IDPN', 'IDNCC'];
        $listPhieuNhap = $this->phieuNhapBus->searchModel($keyword, $columns);
        $listNCC = $this->nccBus->getAllModels();
        $listSanPham = $this->sanPhamBus->getAllModels();

        $current_page = request()->query('page', 1);
        $limit = 8;
        $total_record = count($listPhieuNhap ?? []);
        $total_page = ceil($total_record / $limit);
        $current_page = max(1, min($current_page, $total_page));
        $start = ($current_page - 1) * $limit;
        
        if(empty($listPhieuNhap)) {
            $tmp = [];
        } else {
            $tmp = array_slice($listPhieuNhap, $start, $limit);
        }

        return view('admin.phieunhap', [
            'listPhieuNhap' => $tmp,
            'listNCC' => $listNCC,
            'listSanPham' => $listSanPham,
            'current_page' => $current_page,
            'total_page' => $total_page
        ]);
    }

    public function getChiTiet($id)
    {
        $chiTiet = $this->phieuNhapBus->getChiTietPhieuNhap($id);
        return response()->json($chiTiet);
    }

    public function storeChiTiet(Request $request)
    {
        try {
            $ctpn = new CTPN(
                $request->idPhieuNhap,
                $request->idSanPham,
                $request->soLuong,
                $request->giaNhap,
                $request->phanTramLN
            );

            $result = $this->phieuNhapBus->addCTPN($ctpn);
            if (!$result) {
                throw new \Exception('Không thể thêm chi tiết phiếu nhập');
            }

            return response()->json(['success' => true, 'message' => 'Thêm chi tiết phiếu nhập thành công']);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }
} 