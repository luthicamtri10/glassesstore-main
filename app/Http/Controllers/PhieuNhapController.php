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
        // Tạo phiếu nhập
        $phieuNhap = new PhieuNhap(
            $request->IDNCC,
            date('Y-m-d H:i:s'),
            1,
            '',
            0,
            ReceiptStatus::UNPAID
        );

        $this->phieuNhapBus->addModel($phieuNhap);

        // Lấy ID của phiếu nhập vừa tạo
        $idPhieuNhap = $this->phieuNhapBus->getLastInsertId();

        // Thêm chi tiết phiếu nhập
        $sanPhamIds = $request->IDSANPHAM;
        $soLuongs = $request->SOLUONG;
        $donGias = $request->DONGIA;

        foreach ($sanPhamIds as $index => $idSanPham) {
            $ctpn = new CTPN(
                $idPhieuNhap,
                $idSanPham,
                $soLuongs[$index],
                $donGias[$index],
                null
            );

            $this->phieuNhapBus->addCTPN($ctpn);
        }

        return redirect()->back()->with('success', 'Thêm phiếu nhập thành công');
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
} 