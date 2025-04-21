<?php

use App\Bus\Auth_BUS;
use App\Bus\GioHang_BUS;
use App\Bus\Hang_BUS;
use App\Bus\LoaiSanPham_BUS;
use App\Bus\NguoiDung_BUS;
use App\Bus\Quyen_BUS;
use App\Bus\SanPham_BUS;
use App\Bus\TaiKhoan_BUS;
use App\Enum\GioiTinhEnum;
use App\Models\GioHang;
use App\Models\Hang;
use App\Models\NguoiDung;
use App\Models\Quyen;
use App\Models\TaiKhoan;
use App\Utils\JWTUtils;
use Illuminate\Support\Facades\Auth;
use App\Bus\CPVC_BUS;
use App\Bus\NCC_BUS;
use App\Bus\PhieuNhap_BUS;
use App\Enum\ReceiptStatus;
use App\Models\PhieuNhap;

// Test PhieuNhap_BUS
echo "<h3>Test PhieuNhap_BUS</h3>";

try {
    // 1. Test getAllModels
    $phieuNhapBUS = PhieuNhap_BUS::getInstance();
    $listPhieuNhap = $phieuNhapBUS->getAllModels();
    echo "Số lượng phiếu nhập: " . count($listPhieuNhap) . "<br>";
    
    if (count($listPhieuNhap) > 0) {
        // 2. Test getModelById
        $firstPhieuNhap = $listPhieuNhap[0];
        echo "Thông tin phiếu nhập đầu tiên:<br>";
        echo "ID: " . $firstPhieuNhap->getId() . "<br>";
        echo "ID NCC: " . $firstPhieuNhap->getIdNCC() . "<br>";
        echo "Tổng tiền: " . $firstPhieuNhap->getTongTien() . "<br>";
        echo "Ngày tạo: " . $firstPhieuNhap->getNgayTao()->format('Y-m-d') . "<br>";
        echo "Trạng thái: " . $firstPhieuNhap->getTrangThaiPN()->value . "<br>";

        // 3. Test NCC relationship
        $ncc = $firstPhieuNhap->getNCC();
        if ($ncc) {
            echo "<br>Thông tin nhà cung cấp:<br>";
            echo "ID NCC: " . $ncc->getIdNCC() . "<br>";
            echo "Tên NCC: " . $ncc->getTenNCC() . "<br>";
            echo "Địa chỉ: " . $ncc->getDiachi() . "<br>";
            echo "Mô tả: " . $ncc->getMoTa() . "<br>";
        } else {
            echo "<br>Không tìm thấy thông tin nhà cung cấp<br>";
        }
    } else {
        echo "Không có phiếu nhập nào trong database<br>";
        
        // Tạo phiếu nhập test
        echo "<br>Tạo phiếu nhập test...<br>";
        $nccBUS = NCC_BUS::getInstance();
        $listNCC = $nccBUS->getAllModels();
        if (count($listNCC) > 0) {
            $firstNCC = $listNCC[0];
            $phieuNhap = new PhieuNhap(
                1, // ID
                $firstNCC->getIdNCC(), // IDNCC
                1000000, // tongTien
                date('Y-m-d'), // ngayTao
                1, // idNhanVien
                ReceiptStatus::UNPAID // trangThaiPN
            );
            
            $result = $phieuNhapBUS->addModel($phieuNhap);
            if ($result) {
                echo "Tạo phiếu nhập thành công!<br>";
                
                // Refresh data và hiển thị lại
                $phieuNhapBUS->refreshData();
                $listPhieuNhap = $phieuNhapBUS->getAllModels();
                echo "Số lượng phiếu nhập sau khi tạo: " . count($listPhieuNhap) . "<br>";
                
                if (count($listPhieuNhap) > 0) {
                    $newPhieuNhap = $listPhieuNhap[0];
                    echo "Thông tin phiếu nhập mới:<br>";
                    echo "ID: " . $newPhieuNhap->getId() . "<br>";
                    echo "ID NCC: " . $newPhieuNhap->getIdNCC() . "<br>";
                    echo "Tổng tiền: " . $newPhieuNhap->getTongTien() . "<br>";
                    echo "Ngày tạo: " . $newPhieuNhap->getNgayTao()->format('Y-m-d') . "<br>";
                    echo "Trạng thái: " . $newPhieuNhap->getTrangThaiPN()->value . "<br>";
                }
            } else {
                echo "Lỗi khi tạo phiếu nhập<br>";
            }
        } else {
            echo "Không có nhà cung cấp nào để tạo phiếu nhập<br>";
        }
    }

    // 4. Test searchModel
    echo "<br>Test tìm kiếm:<br>";
    $searchResults = $phieuNhapBUS->searchModel("1", ["ID"]);
    if ($searchResults) {
        echo "Kết quả tìm kiếm: " . count($searchResults) . " kết quả<br>";
    } else {
        echo "Không tìm thấy kết quả<br>";
    }

} catch (Exception $e) {
    echo "Lỗi: " . $e->getMessage() . "<br>";
    echo "File: " . $e->getFile() . "<br>";
    echo "Line: " . $e->getLine() . "<br>";
}

// Test NCC_BUS
echo "<br><h3>Test NCC_BUS</h3>";
$nccBUS = NCC_BUS::getInstance();
$listNCC = $nccBUS->getAllModels();
echo "Số lượng nhà cung cấp: " . count($listNCC) . "<br>";
if (count($listNCC) > 0) {
    echo "Danh sách mô tả NCC:<br>";
    foreach($listNCC as $ncc) {
        echo $ncc->getMoTa() . "<br>";
    }
}

app(Auth_BUS::class)->logout();
?>