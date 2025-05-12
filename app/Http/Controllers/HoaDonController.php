<?php

namespace App\Http\Controllers;

use App\Bus\Auth_BUS;
use App\Bus\CPVC_BUS;
use App\Bus\CTGH_BUS;
use App\Bus\CTHD_BUS;
use App\Bus\CTSP_BUS;
use App\Bus\DVVC_BUS;
use App\Bus\GioHang_BUS;
use App\Bus\HoaDon_BUS;
use App\Bus\NguoiDung_BUS;
use App\Bus\PTTT_BUS;
use App\Bus\SanPham_BUS;
use App\Bus\TaiKhoan_BUS;
use App\Bus\Tinh_BUS;
use App\Dao\CPVC_DAO;
use App\Enum\HoaDonEnum;
use App\Models\CTHD;
use App\Models\HoaDon;
use App\Models\TaiKhoan;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class HoaDonController extends Controller {
    private $hoaDonBUS;
    private $taiKhoanBUS;
    private $ptttBUS;
    private $dvvcBUS;
    private $tinhBUS;
    private $nguoiDungBUS;

    public function __construct(HoaDon_BUS $hoaDonBUS, TaiKhoan_BUS $taiKhoanBUS, PTTT_BUS $ptttBUS, DVVC_BUS $dvvcBUS, Tinh_BUS $tinhBUS, NguoiDung_BUS $nguoiDungBUS)
    {
        $this->hoaDonBUS = $hoaDonBUS;
        $this->taiKhoanBUS = $taiKhoanBUS;
        $this->ptttBUS = $ptttBUS;
        $this->dvvcBUS = $dvvcBUS;
        $this->tinhBUS = $tinhBUS;
        $this->nguoiDungBUS = $nguoiDungBUS;
    }


    public function store(Request $request)
    {
        $email = $this->taiKhoanBUS->getModelById($request->input('email'));
        $city = $this->tinhBUS->getModelById($request->input('city'));
        $address = $request->input('address');
;

        $hoaDon = new HoaDon(
            null,
            // null,
            $email,
            $this->nguoiDungBUS->getModelById(1),
            0.0,
            $this->ptttBUS->getModelById(1),
            new \DateTime(),
            1,
            $address,
            $city, 
            HoaDonEnum::PENDING
        );

        $newId = $this->hoaDonBUS->addModel($hoaDon);
        $hoaDon->setId($newId);

        $orderCode = (int)($newId . substr(time(), -4));

        $hoaDon->setOrderCode($orderCode);

        $na = $this->hoaDonBUS->updateModel($hoaDon);


        $returnUrl = url("client/paymentsuccess?orderCode=" . $orderCode);
        $cancelUrl = url("/");

        $amount = 2000;
        $description = "Thanh toan don hang";

        $signatureRaw = "amount={$amount}&cancelUrl={$cancelUrl}&description={$description}&orderCode={$orderCode}&returnUrl={$returnUrl}";

        $signature = hash_hmac('sha256', $signatureRaw, env('PAYOS_CHECKSUM_KEY'));

        $payload = [
            "orderCode" => $orderCode,
            "amount" => $amount,
            "description" => $description,
            "returnUrl" => $returnUrl,
            "cancelUrl" => $cancelUrl,
            "signature" => $signature,
        ];

        $response = Http::withHeaders([
            'Content-Type' => 'application/json',
            'x-client-id' => env('PAYOS_CLIENT_ID'),
            'x-api-key' => env('PAYOS_API_KEY')
        ])->post('https://api-merchant.payos.vn/v2/payment-requests', $payload);

        // dd($response->body());

        $responseData = $response->json();
        if ($response->successful() && isset($responseData['data']['checkoutUrl'])) {
            $checkoutUrl = $responseData['data']['checkoutUrl'];

            // Redirect to the checkout URL or pass it along to the front end
            return redirect($checkoutUrl);

        } else {
            // Handle failure (you can customize this part)
            return back()->with('error', 'Không thể tạo đơn hàng thanh toán.')->withErrors($responseData);
        }

    }

    public function paymentSuccess(Request $request)
    {
        
        $orderCode = $request->input('orderCode');
        Log::info("Received order code: {$orderCode}"); // Thêm dòng này để debug
        $status = 'PAID'; // Giả định trạng thái đã thanh toán
        // dd($orderCode);
        if ($orderCode) {
            $hoaDon = $this->hoaDonBUS->getByOrderCode($orderCode);
            if ($hoaDon) {
                Log::info("Found order with orderCode: {$orderCode}");
                $hoaDon->setTrangThai(HoaDonEnum::PAID);
                $this->hoaDonBUS->updateModel($hoaDon);
                // return response()->json(['success' => true, 'checkoutUrl' => url('/success')]);
                return back()->with('success', 'Bạn đã thanh toán đơn hàng thành công.');
                
            } else {
                // Log::warning("Payment failed for orderCode: {$orderCode}");
                return back()->with('error', 'Không tìm thấy đơn hàng.');
            }
        }
        return back()->with('error', 'Thanh toán đơn hàng không thành công.');

        // return response()->json(['success' => false, 'error' => 'Không tìm thấy hóa đơn.'], 400);
    }

    public function updateStatus(Request $request)
    {
        // Validate input
        $request->validate([
            'id' => 'required|integer',
            'trangthai' => 'required|in:' . implode(',', array_column(HoaDonEnum::cases(), 'value'))
        ]);

        try {
            $hoaDon = $this->hoaDonBUS->getModelById($request->id);
            if (!$hoaDon) {
                return redirect()->back()->with('error', 'Không tìm thấy hóa đơn.');
            }

            // Chuyển chuỗi thành HoaDonEnum
            $trangThaiEnum = HoaDonEnum::from($request->trangthai);
            $hoaDon->setTrangThai($trangThaiEnum);
            $this->hoaDonBUS->updateModel($hoaDon);

            return redirect()->back()->with('success', 'Cập nhật trạng thái thành công.');
        } catch (\ValueError $e) {
            // Xử lý trường hợp chuỗi không khớp với bất kỳ giá trị enum nào
            return redirect()->back()->with('error', 'Trạng thái không hợp lệ.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Cập nhật trạng thái thất bại: ' . $e->getMessage());
        }
    }

    public function createdPayMent(Request $request)  {
        // dd($request->all());
        $listSP = $request->input('listSP');
        $email = app(Auth_BUS::class)->getEmailFromToken();
        $user = app(TaiKhoan_BUS::class)->getModelById($email);
        $isLogin = app(Auth_BUS::class)->isAuthenticated();
        $listPTTT = app(PTTT_BUS::class)->getAllModels();
        $listTinh = app(Tinh_BUS::class)->getAllModels();
        $listDVVC = app(DVVC_BUS::class)->getAllModels();
        $listSP = json_decode($listSP); 
        date_default_timezone_set('Asia/Ho_Chi_Minh');
        // $current_time = new \DateTime();
        // dd($current_time);
        $hoaDon = new HoaDon(
            null,
            // null,
            $user,
            $this->nguoiDungBUS->getModelById(1),
            0.0,
            $this->ptttBUS->getModelById(1),
            new \DateTime(),
            1,
            $user->getIdNguoiDung()->getDiaChi(),
            $user->getIdNguoiDung()->getTinh(), 
            HoaDonEnum::PENDING
        );

        $newId = $this->hoaDonBUS->addModel($hoaDon);
        $hoaDon->setId($newId);

        // $listSP = json_decode($request->input('listSP'), true);
        // dd($listSP);
        return view('client.CreatePayMent', [
            'listSP' => $listSP,
            'user' => $user,
            'isLogin' => $isLogin,
            'listPTTT' => $listPTTT,
            'listTinh' => $listTinh,
            'listDVVC' => $listDVVC,
            'idHD' => $hoaDon->getId()
        ]);

    }
    public function muangay(Request $request) {
        // Lấy idsp và quantity từ request
        // dd($request->all());
        $idsp = $request->input('idsp2'); // Đảm bảo sử dụng đúng tên trường
        $quantity = $request->input('quantity');
    
        // Lấy thông tin người dùng
        $email = app(Auth_BUS::class)->getEmailFromToken();
        $user = app(TaiKhoan_BUS::class)->getModelById($email);
        $isLogin = app(Auth_BUS::class)->isAuthenticated();
    
        // Lấy giá sản phẩm
        $gia = app(SanPham_BUS::class)->getModelById($idsp)->getDonGia();
    
        // Tạo danh sách sản phẩm
        $listSP = [[
            'idsp' => $idsp,
            'price' => $gia,
            'quantity' => $quantity
        ]]; // Sử dụng mảng để tạo danh sách sản phẩm
        // $listSP = [];
        
        // Tạo hóa đơn
        date_default_timezone_set('Asia/Ho_Chi_Minh');

        $hoaDon = new HoaDon(
            null,
            $user,
            $this->nguoiDungBUS->getModelById(1),
            0.0,
            $this->ptttBUS->getModelById(1),
            new \DateTime(),
            1,
            $user->getIdNguoiDung()->getDiaChi(),
            $user->getIdNguoiDung()->getTinh(), 
            HoaDonEnum::PENDING
        );
    
        $newId = $this->hoaDonBUS->addModel($hoaDon);
        $hoaDon->setId($newId);
    
        // Trả về view với dữ liệu cần thiết
        // dd($listSP);
        return view('client.MuaNgay', [
            'listSP' => $listSP, // Trả về danh sách sản phẩm
            'user' => $user,
            'isLogin' => $isLogin,
            'listPTTT' => app(PTTT_BUS::class)->getAllModels(),
            'listTinh' => app(Tinh_BUS::class)->getAllModels(),
            'listDVVC' => app(DVVC_BUS::class)->getAllModels(),
            'idHD' => $hoaDon->getId()
        ]);
    }

    public function search(Request $request) {
        // dd($request->all());
        $tongtien = $request->tongtien;
        $tinh = $request->input('tinh');
        $dvvc = $request->input('dvvc');
        $pttt = $request->input('pttt');
        $diachi=  $request->input('diachi');
        $cpvc = app(CPVC_DAO::class)->getByTinhAndDVVC($tinh, $dvvc)->getChiPhiVC();
        $tongtien += $cpvc;
        // dd($tinh);
        return response()->json([
            'tinh' => $tinh,
            'dvvc' => $dvvc,
            'pttt' => $pttt,
            'cpvc' => $cpvc,
            'diachi' => $diachi,
            'tongtien' => $tongtien
        ]);
    }

    public function changeStatusHD(Request $request) {
        // dd($request->all());
        $hd = app(HoaDon_BUS::class)->getModelById($request->input('idHD'));
        $tinh = app(Tinh_BUS::class)->getModelById($request->input('tinh'));
        $pttt = app(PTTT_BUS::class)->getModelById($request->input('pttt'));
        $dvvc = app(DVVC_BUS::class)->getModelById($request->input('dvvc'));
        $diachi = $request->input('diachi');
        $listCTHD = json_decode($request->listCTHD);
        $email = app(Auth_BUS::class)->getEmailFromToken();
        $user = app(TaiKhoan_BUS::class)->getModelById($email);
        $gh = app(GioHang_BUS::class)->getByEmail($email);
        $sum = 0;
        foreach ($listCTHD as $key) {
            # code...
            
            $sp = app(SanPham_BUS::class)->getModelById($key->sanPham);
            $sum += $sp->getDonGia() * $key->soLuong;
            $listCTSP = app(CTSP_BUS::class)->getCTSPIsNotSoldByIDSP($key->sanPham);
            for($i = 0 ; $i < $key->soLuong ; $i++) {
                $cthd = new CTHD($hd->getId(), app(SanPham_BUS::class)->getModelById($key->sanPham)->getDonGia(),$listCTSP[$i]->getSoSeri(),1);
                // dd($cthd);
                app(CTHD_BUS::class)->addModel($cthd);
                $ctsp = app(CTSP_BUS::class)->getCTSPBySoSeri($listCTSP[$i]->getSoSeri());
                app(CTSP_BUS::class)->updateStatus($ctsp->getSoSeri(), 0);
                app(CTGH_BUS::class)->deleteCTGH($gh->getIdGH(), $key->sanPham);
            }
        }
        $cpvc = app(CPVC_DAO::class)->getByTinhAndDVVC($tinh->getId(),$dvvc->getIdDVVC());
        $sum += $cpvc->getChiPhiVC();
        $hd->setTrangThai(HoaDonEnum::DADAT);
        $hd->setTongTien($sum);
        $hd->setTinh($tinh);
        $hd->setDiaChi($diachi);
        $hd->setIdPTTT($pttt);
        $hd->setIdDVVC($dvvc);
        $isLogin = app(Auth_BUS::class)->isAuthenticated();
        app(HoaDon_BUS::class)->updateModel($hd);
        if($pttt->getId() == 1) {
            return view('client.SuccessPayment',[
                'hoaDon' => $hd,
                'dvvc' => $dvvc,
                'pttt' => $pttt,
                'isLogin' => $isLogin,
                'user' => $user,
                'listSP' => $listCTHD
            ]);
        } else {
            $orderCode = (int)($hd->getId() . substr(time(), -4));
            $hd->setOrderCode($orderCode);
            $hd->setIdPTTT($pttt);
            $hd->setTongTien(10000);
            app(HoaDon_BUS::class)->updateModel($hd); // Cập nhật mã đơn hàng

            $returnUrl = url("client/paymentsuccess?orderCode=" . $orderCode);
            $cancelUrl = url("/");

            $amount = $sum;
            $description = "Thanh toán đơn hàng #" . $orderCode;

            $signatureRaw = "amount={$amount}&cancelUrl={$cancelUrl}&description={$description}&orderCode={$orderCode}&returnUrl={$returnUrl}";
            $signature = hash_hmac('sha256', $signatureRaw, env('PAYOS_CHECKSUM_KEY'));

            $payload = [
                "orderCode" => $orderCode,
                "amount" => $amount,
                "description" => $description,
                "returnUrl" => $returnUrl,
                "cancelUrl" => $cancelUrl,
                "signature" => $signature,
            ];

            $response = Http::withHeaders([
                'Content-Type' => 'application/json',
                'x-client-id' => env('PAYOS_CLIENT_ID'),
                'x-api-key' => env('PAYOS_API_KEY')
            ])->post('https://api-merchant.payos.vn/v2/payment-requests', $payload);

            $responseData = $response->json();
            // if ($response->successful() && isset($responseData['data']['checkoutUrl'])) {
            //     return redirect($responseData['data']['checkoutUrl']);
            // } else {
            //     return back()->with('error', 'Không thể tạo đơn hàng thanh toán với PayOS.')->withErrors($responseData);
            // }
            // dd($hd);
            return view('client.SuccessPayment',[
                'hoaDon' => $hd,
                'dvvc' => $dvvc,
                'isLogin' => $isLogin,
                'user' => $user,
                'listSP' => $listCTHD,
                'responseData' => $responseData
            ]);
        }

    }
    public function paid(Request $request) {
        // dd($request->all());
        $tongtien = (int) $request->input('tongtien');
        $ordercode = (int) $request->input('ordercode');
        $returnUrl = url("client/paymentsuccess?orderCode=" . $ordercode);
        $cancelUrl = url("/");
        $description = "Thanh toán #" . $ordercode;
        $signatureRaw = "amount={$tongtien}&cancelUrl={$cancelUrl}&description={$description}&orderCode={$ordercode}&returnUrl={$returnUrl}";
        $signature = hash_hmac('sha256', $signatureRaw, 'e565caa65f2ddfcc509fb1cf94ab52a4f37c1a8abb403af3cb339941f430261c');
        $payload = [
            "orderCode" => $ordercode,
            "amount" => $tongtien,
            "description" => $description,
            "returnUrl" => $returnUrl,
            "cancelUrl" => $cancelUrl,
            "signature" => $signature,
        ];
        $response = Http::withHeaders([
            'Content-Type' => 'application/json',
            'x-client-id' => 'd4999768-4dc1-4c9d-a8ca-85553d797c3f',
            'x-api-key' => '261c7797-ea98-40ef-9da6-a8bd1714a9bf'
        ])->post('https://api-merchant.payos.vn/v2/payment-requests', $payload);
    
        $responseData = $response->json();
        
        if ($response->successful() && isset($responseData['data']['checkoutUrl'])) {
            return redirect($responseData['data']['checkoutUrl']);
        } else {
            dd($responseData);
            return back()->with('error', 'Không thể tạo đơn hàng thanh toán với PayOS.')->withErrors($responseData);
        }
    }
    
    public function getCTHDByIDSPAndIDHD(Request $request) {
        // dd($request->all());
        $idsp = $request->idsp;
        $idhd = $request->idhd;
        $list = app(CTHD_BUS::class)->getCTHDByIDSPAndIDHD($idsp, $idhd);
        return response()->json([
            'list' => collect($list)->map(function($item) {
                return [
                    'soSeri' => $item->getSoSeri(),
                ];
            }),
        ]);        
    }

}
?>