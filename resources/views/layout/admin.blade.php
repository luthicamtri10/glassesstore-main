<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Trang quản trị</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

    @vite(['resources/css/admin/admin.css'])
</head>
<body>
    <div class="wrapper">
        @include('admin.includes.sidebar')
        <div class="main bg-light" id="content">
        @include('admin.includes.navbar')
            <?php
                use App\Enum\HoaDonEnum;
                use App\Bus\SanPham_BUS;
                use App\Bus\CTHD_BUS;
                use App\Bus\DVVC_BUS;
                use App\Bus\Hang_BUS;
                use App\Bus\HoaDon_BUS;
                use App\Bus\LoaiSanPham_BUS;
                use App\Bus\NguoiDung_BUS;
                use App\Bus\PTTT_BUS;
                use App\Bus\Quyen_BUS;
                use App\Bus\TaiKhoan_BUS;
                use App\Bus\Tinh_BUS;
                use Illuminate\Support\Facades\View as FacadesView;

                $page = $_GET['modun'] ?? 'nguoidung';

                switch ($page) {
                    case 'taikhoan':
                        $taikhoanBUS = app(TaiKhoan_BUS::class);
                        $quyenBUS = app(Quyen_BUS::class);
                        $ndBUS = app(NguoiDung_BUS::class);
                        $listTK = $taikhoanBUS->getAllModels();
                        $listQ = $quyenBUS->getAllModels();
                        $listND = $ndBUS->getAllModels();
                        if (isset($_GET['keyword']) || !empty($_GET['keyword'])) {
                            $keyword = $_GET['keyword'];
                            $listTK = $taikhoanBUS->searchModel($keyword, []);
                        } elseif (isset($_GET['keywordQuyen']) || !empty($_GET['keywordQuyen'])) {
                            $keywordQuyen = $_GET['keywordQuyen'];
                            $listTK = $taikhoanBUS->searchByQuyen($keywordQuyen);
                        }

                        $current_page = request()->query('page', 1);
                        $limit = 8;
                        $total_record = count($listTK ?? []);
                        $total_page = ceil($total_record / $limit);
                        $current_page = max(1, min($current_page, $total_page));
                        $start = ($current_page - 1) * $limit;
                        if(empty($listTK)) {
                            $tmp = [];
                        } else {
                            $tmp = array_slice($listTK, $start, $limit);
                        }

                        echo FacadesView::make('admin.taikhoan', [
                            'tmp' => $tmp,
                            'listQ' => $listQ,
                            'listND' => $listND,
                            'current_page' => $current_page,
                            'total_page' => $total_page
                        ])->render();
                        break;
                    case 'nguoidung':
                        $ndBUS = app(NguoiDung_BUS::class);
                        $tinhBUS = app(Tinh_BUS::class);
                        $listND = $ndBUS->getAllModels();
                        $listTinh = $tinhBUS->getAllModels();
                        if (isset($_GET['keyword']) || !empty($_GET['keyword'])) {
                            $keyword = $_GET['keyword'];
                            $listND = $ndBUS->searchModel($keyword, []);
                        } elseif (isset($_GET['keywordTinh']) || !empty($_GET['keywordTinh'])) {
                            $keywordTinh = $_GET['keywordTinh'];
                            $listND = $ndBUS->searchByTinh($keywordTinh);
                        }

                        $current_page = request()->query('page', 1);
                        $limit = 8;
                        $total_record = count($listND ?? []);
                        $total_page = ceil($total_record / $limit);
                        $current_page = max(1, min($current_page, $total_page));
                        $start = ($current_page - 1) * $limit;
                        if(empty($listND)) {
                            $tmp = [];
                        } else {
                            $tmp = array_slice($listND, $start, $limit);
                        }

                        echo FacadesView::make('admin.nguoidung', [
                            'tmp' => $tmp,
                            'listTinh' => $listTinh,
                            'current_page' => $current_page,
                            'total_page' => $total_page
                        ])->render();
                        break;
                    
                    case 'quyen':
                        include base_path('resources/views/admin/quyen.blade.php');
                        break;
                    case 'thongke':
                        include base_path('resources/views/admin/thongke.blade.php');
                        break;
                    case 'loaisanpham':
                        $bus = app(LoaiSanPham_BUS::class);
                        $list = $bus->getAllModels();

                        $keyword = trim(request('keyword'));
                        if ($keyword === '') {
                            $list = $bus->getAllModels();
                        } else {
                            $list = $bus->searchModel($keyword, []);
                        }

                        $current_page = request()->query('page', 1);
                        $limit = 8;
                        $total_record = count($list ?? []);
                        $total_page = ceil($total_record / $limit);
                        $current_page = max(1, min($current_page, $total_page));
                        $start = ($current_page - 1) * $limit;
                        if(empty($list)) {
                            $tmp = [];
                        } else {
                            $tmp = array_slice($list, $start, $limit);
                        }

                        echo FacadesView::make('admin.loaisanpham', [
                            'listLSP' => $tmp,
                            'current_page' => $current_page,
                            'total_page' => $total_page
              
                        ])->render();
                
                        break;  
                    case 'sanpham':
                        $loaiSanPhamBUS = app(LoaiSanPham_BUS::class);
                        $hangBUS = app(Hang_BUS::class);
                        $sanPhamBUS = app(SanPham_BUS::class);
                        $listLSP = $loaiSanPhamBUS->getAllModels();
                        $listHang = $hangBUS->getAllModels();
                        $listSP = $sanPhamBUS->getAllModels();

                        $mapTenHang = [];
                        foreach ($listHang as $hang){
                            $mapTenHang[$hang->getId()] = $hang->gettenHang();
                        }

                        $mapTenLoaiSP = [];
                        foreach ($listLSP as $loaiSP) {
                            $mapTenLoaiSP[$loaiSP->getId()] = $loaiSP->getTenLSP();
                        }

                        $keyword = trim(request('keyword'));
                        if ($keyword === '') {
                            $listSP = $sanPhamBUS->getAllModels();
                        } else {
                            $listSP = $sanPhamBUS->searchModel($keyword, []);
                        }

                        $current_page = request()->query('page', 1);
                        $limit = 8;
                        $total_record = count($listSP ?? []);
                        $total_page = ceil($total_record / $limit);
                        $current_page = max(1, min($current_page, $total_page));
                        $start = ($current_page - 1) * $limit;
                        if(empty($listSP)) {
                            $tmp = [];
                        } else {
                            $tmp = array_slice($listSP, $start, $limit);            
                        }

                        echo FacadesView::make('admin.sanpham', [
                            'listSP' => $tmp,
                            'listHang' => $listHang,
                            'listLSP' => $listLSP,
                            'mapTenLoaiSP' => $mapTenLoaiSP, 
                            'mapTenHang' => $mapTenHang,
                            'current_page' => $current_page,
                            'total_page' => $total_page
                        ])->render();
                        break;
                    case 'hoadon':
                        $cthdBUS = app(CTHD_BUS::class);
                        $hoaDonBUS = app(HoaDon_BUS::class);
                        $listHoaDon = $hoaDonBUS->getAllModels();

                        $mapCTHD = [];
                        foreach ($listHoaDon as $hoaDon) {
                            $mapCTHD[$hoaDon->getId()] = $cthdBUS->getCTHTbyIDHD($hoaDon->getId());
                            $cthdData = $cthdBUS->getCTHTbyIDHD($hoaDon->getId());
                        }

                        $tinhBUS = app(Tinh_BUS::class);
                        $listTinh = $tinhBUS->getAllModels();
                        $nguoiDungBUS = app(NguoiDung_BUS::class);
                        $listNguoiDung = $nguoiDungBUS->getAllModels();
                        $pttBUS = app(PTTT_BUS::class);
                        $listpttt = $pttBUS->getAllModels();
                        $dvvcBUS = app(DVVC_BUS::class);
                        $listdvvc = $dvvcBUS->getAllModels();
                        $taiKhoanBUS = app(TaiKhoan_BUS::class);
                        $listtaiKhoan = $taiKhoanBUS->getAllModels();

                        $sanPhamBUS = app(SanPham_BUS::class);
                        $listSanPham = $sanPhamBUS->getAllModels();
                        
                        $mapSanPham = [];
                        foreach ($listSanPham as $sanpham){
                            $mapSanPham[$sanpham->getId()] = $sanpham->getTenSanPham();
                        }

                        $mapNguoiDung = [];
                        foreach ($listNguoiDung as $nguoiDung){
                            $mapNguoiDung[$nguoiDung->getId()] = $nguoiDung->getHoTen();
                        }

                        $mapHoTenByEmail = [];
                        foreach ($listtaiKhoan as $taiKhoan) {
                            $nguoiDung = $taiKhoan->getIdNguoiDung(); // Trả về đối tượng NguoiDung
                            $email = $taiKhoan->getEmail();
                        
                            $mapHoTenByEmail[$email] = $nguoiDung->getHoTen(); // Lấy trực tiếp
                        }

                        $mapTinh = [];
                        foreach ($listTinh as $tinh) {
                            $mapTinh[$tinh->getId()] = $tinh->getTenTinh();
                        }

                        $mapPTTT = [];
                        foreach ($listpttt as $pttt) {
                            $mapPTTT[$pttt->getId()] = $pttt->gettenPTTT();
                        }

                        $mapDVVC = [];
                        foreach ($listdvvc as $dvvc) {
                            $mapDVVC[$dvvc->getIdDVVC()] = $dvvc->getTenDV();
                        }

                
                        if (isset($_GET['keywordTinh']) || !empty($_GET['keywordTinh'])) {
                            $keywordTinh = $_GET['keywordTinh'];
                            $listHoaDon = $hoaDonBUS->searchByTinh($keywordTinh);
                        }

                        $current_page = request()->query('page', 1);
                        $limit = 8;
                        $total_record = count($listHoaDon ?? []);
                        $total_page = ceil($total_record / $limit);
                        $current_page = max(1, min($current_page, $total_page));
                        $start = ($current_page - 1) * $limit;
                        if(empty($listHoaDon)) {
                            $tmp = [];
                        } else {
                            $tmp = array_slice($listHoaDon, $start, $limit);            
                        }
                        
                        echo FacadesView::make('admin.hoadon', [
                            'listHoaDon' => $tmp,
                            'mapCTHD' => $mapCTHD,
                            'mapHoTenByEmail' => $mapHoTenByEmail,
                            'mapNguoiDung' => $mapNguoiDung, 
                            'mapPTTT' => $mapPTTT,
                            'mapDVVC' => $mapDVVC,
                            'mapTinh' => $mapTinh,
                            'listTinh' => $listTinh,
                            'current_page' => $current_page,
                            'total_page' => $total_page,
                            'hoaDonStatuses' => HoaDonEnum::cases(),
                        ])->render();
                        break;
                    default:
                        include base_path('resources/views/admin/nguoidung.blade.php');
                        break;
                }
            ?>
        </div>
    </div>
</body>
</html>
