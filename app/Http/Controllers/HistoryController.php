<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Bus\HoaDon_BUS;
use App\Bus\CTHD_BUS;
use App\Bus\CTSP_BUS;
use App\Bus\Auth_BUS;
use App\Bus\TaiKhoan_BUS;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;

class HistoryController extends Controller
{
    private $hoaDonBUS;
    private $chiTietHoaDonBUS;
    private $ctspBUS;
    private $authBus;
    private $taiKhoanBus;

    public function __construct(HoaDon_BUS $hoaDonBUS, CTHD_BUS $chiTietHoaDonBUS, CTSP_BUS $ctspBUS, Auth_BUS $authBus, TaiKhoan_BUS $taiKhoanBus)
    {
        $this->hoaDonBUS = $hoaDonBUS;
        $this->chiTietHoaDonBUS = $chiTietHoaDonBUS;
        $this->ctspBUS = $ctspBUS;
        $this->authBus = $authBus;
        $this->taiKhoanBus = $taiKhoanBus;
    }

    public function showOrderHistory(Request $request)
    {
        $orders = [];
        $error = null;
        $current_page = $request->query('page', 1);
        $total_page = 1;
        $filter_date = $request->query('filter_date');
        $sort_order = $request->query('sort_order');
        $keyword = $request->query('keyword');
        $isLogin = $this->authBus->isAuthenticated();
        $email = $isLogin ? $this->authBus->getEmailFromToken() : null;
        $user = $email ? $this->taiKhoanBus->getModelById($email) : null;

        try {
            if (!$isLogin || !$email) {
                $error = 'Vui lòng đăng nhập để xem lịch sử đơn hàng.';
            } else {
                Log::info('User email from token: ' . $email);

                // Truy vấn trực tiếp từ bảng hoadon
                $rawHoaDons = DB::select("SELECT * FROM hoadon WHERE EMAIL = ?", [$email]);
                Log::info('Raw hoaDons from direct query: ', ['rawHoaDons' => $rawHoaDons]);

                if (empty($rawHoaDons)) {
                    Log::warning('No raw hoaDons found for email: ' . $email);
                    // Không gán thông báo lỗi cụ thể, để $error là null
                } else {
                    foreach ($rawHoaDons as $rawHoaDon) {
                        Log::info('Processing rawHoaDon: ', ['id' => $rawHoaDon->ID, 'email' => $rawHoaDon->EMAIL]);
                        $chiTietHoaDonsRaw = $this->chiTietHoaDonBUS->getCTHTbyIDHD($rawHoaDon->ID);
                        $chiTietHoaDons = [];

                        if ($chiTietHoaDonsRaw) {
                            foreach ($chiTietHoaDonsRaw as $cthd) {
                                $sanPham = $this->ctspBUS->getSPBySoSeri($cthd->getSoSeri());
                                $chiTietHoaDons[] = [
                                    'soSeri' => $cthd->getSoSeri() ?? 'N/A',
                                    'tenSanPham' => $sanPham ? ($sanPham->getTenSanPham() ?? 'Không xác định') : 'Không xác định',
                                    'giaLucDat' => $cthd->getGiaLucDat() ?? 0,
                                    'trangThaiHD' => $cthd->getTrangThaiHD() ?? false,
                                ];
                            }
                        }

                        $orders[] = [
                            'id' => $rawHoaDon->ID ?? 'N/A',
                            'tongTien' => $rawHoaDon->TONGTIEN ?? 0,
                            'ngayTao' => $rawHoaDon->NGAYTAO ?? null,
                            'trangThai' => $rawHoaDon->TRANGTHAI ?? 'Không xác định',
                            'phuongThucThanhToan' => isset($rawHoaDon->IDPTTT) ? app(\App\Bus\PTTT_BUS::class)->getModelById($rawHoaDon->IDPTTT)->gettenPTTT() ?? 'Không xác định' : 'Không xác định',
                            'donViVanChuyen' => isset($rawHoaDon->IDDVVC) ? app(\App\Bus\DVVC_BUS::class)->getModelById($rawHoaDon->IDDVVC)->getTenDV() ?? 'Không xác định' : 'Không xác định',
                            'emailKhachHang' => $rawHoaDon->EMAIL ?? 'Không xác định',
                            'tinh' => isset($rawHoaDon->IDTINH) ? app(\App\Bus\Tinh_BUS::class)->getModelById($rawHoaDon->IDTINH)->getTenTinh() ?? 'Không xác định' : 'Không xác định',
                            'diaChi' => $rawHoaDon->DIACHI ?? 'Không xác định',
                            'chiTietHoaDons' => $chiTietHoaDons,
                        ];
                    }

                    // Lọc theo keyword
                    if ($keyword) {
                        $keyword = strtolower(trim($keyword));
                        $orders = array_filter($orders, function ($order) use ($keyword) {
                            foreach ($order['chiTietHoaDons'] as $cthd) {
                                if (str_contains(strtolower($cthd['tenSanPham']), $keyword)) {
                                    return true;
                                }
                            }
                            return false;
                        });
                    }

                    // Lọc theo ngày
                    if ($filter_date) {
                        $filter_date = date('Y-m-d', strtotime($filter_date));
                        $orders = array_filter($orders, function ($order) use ($filter_date) {
                            return $order['ngayTao'] ? date('Y-m-d', strtotime($order['ngayTao'])) === $filter_date : false;
                        });
                    }

                    // Sắp xếp
                    if ($sort_order === 'asc' || $sort_order === 'desc') {
                        usort($orders, function ($a, $b) use ($sort_order) {
                            $dateA = $a['ngayTao'] ? strtotime($a['ngayTao']) : 0;
                            $dateB = $b['ngayTao'] ? strtotime($b['ngayTao']) : 0;
                            return $sort_order === 'asc' ? $dateA - $dateB : $dateB - $dateA;
                        });
                    } else {
                        usort($orders, function ($a, $b) {
                            return $a['id'] - $b['id'];
                        });
                    }

                    // Phân trang
                    $limit = 8;
                    $total_record = count($orders);
                    $total_page = ceil($total_record / $limit);
                    $current_page = max(1, min($current_page, $total_page));
                    $start = ($current_page - 1) * $limit;

                    $orders = array_slice($orders, $start, $limit);

                    if (empty($orders) && $total_record === 0) {
                        $error = 'Không tìm thấy đơn hàng nào phù hợp với tiêu chí tìm kiếm.';
                    }
                }
            }
        } catch (\Exception $e) {
            $error = 'Không thể tải lịch sử đơn hàng. Vui lòng thử lại sau.';
            Log::error('Error in showOrderHistory: ' . $e->getMessage());
        }

        // Đảm bảo session('cart') an toàn
        if (!session()->has('cart')) {
            session(['cart' => []]);
        }
        $statuses = [
            ['value' => 'PENDING', 'label' => 'Đang xử lý'],
            ['value' => 'PAID', 'label' => 'Đã thanh toán'],
            ['value' => 'EXPIRED', 'label' => 'Hết hạn'],
            ['value' => 'CANCELLED', 'label' => 'Đã hủy'],
            ['value' => 'REFUNDED', 'label' => 'Đã hoàn tiền'],
            ['value' => 'DANGGIAO', 'label' => 'Đang giao'],
            ['value' => 'DAGIAO', 'label' => 'Đã giao'],
        ];
        return view('client.order-history', [
            'orders' => $orders,
            'error' => $error,
            'current_page' => $current_page,
            'total_page' => $total_page,
            'filter_date' => $filter_date,
            'sort_order' => $sort_order,
            'isLogin' => $isLogin,
            'user' => $user,
            'statuses' => $statuses,
        ]);
    }
}