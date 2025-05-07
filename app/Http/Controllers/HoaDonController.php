<?php

namespace App\Http\Controllers;

use App\Bus\Auth_BUS;
use App\Bus\DVVC_BUS;
use App\Bus\HoaDon_BUS;
use App\Bus\NguoiDung_BUS;
use App\Bus\PTTT_BUS;
use App\Bus\TaiKhoan_BUS;
use App\Bus\Tinh_BUS;
use App\Enum\HoaDonEnum;
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
        $orderCode = $request->query('orderCode');
        $status = $request->query('status');

        $success = false;

        if ($orderCode && $status === 'PAID') {
            $hoaDon = $this->hoaDonBUS->getByOrderCode($orderCode);
            if ($hoaDon) {
                Log::info("Found order with orderCode: {$orderCode}");
                $hoaDon->setTrangThai(HoaDonEnum::PAID);
                $hoaDon->setOrderCode($orderCode);
                $this->hoaDonBUS->updateModel($hoaDon);
                // $success = true;
            }else {
                // Debugging
                Log::warning("Payment failed for orderCode: {$orderCode} with status: {$status}");
            }
        }

        // return view('client/paymentsuccess', compact('success'));
        $returnUrl = url("/?orderCode={$orderCode}&status={$status}");
        return redirect($returnUrl);
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
        return view('client.CreatePayMent', [
            'listSP' => $listSP,
            'user' => $user,
            'isLogin' => $isLogin,
            'listPTTT' => $listPTTT
        ]);

    }


}
?>