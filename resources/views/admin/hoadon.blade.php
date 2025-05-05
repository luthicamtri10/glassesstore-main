
<script>
document.addEventListener("DOMContentLoaded", function () {
    const searchForm = document.querySelector('form[method="GET"]');

    if (searchForm) {
        searchForm.addEventListener('submit', function (e) {
            e.preventDefault();

            const formData = new FormData(searchForm);
            const url = new URL(window.location.href);

            // Lấy các tham số cũ và thêm vào URL
            const currentParams = new URLSearchParams(window.location.search);

            // Giữ lại tham số 'modun=hoadon' nếu có
            if (!currentParams.has('modun')) {
                currentParams.set('modun', 'hoadon');
            }

            // Thêm hoặc thay đổi các tham số từ form
            for (const [key, value] of formData.entries()) {
                if (value.trim() !== '') {
                    currentParams.set(key, value);
                } else {
                    currentParams.delete(key); // Nếu trường nào trống thì xóa khỏi URL
                }
            }

            // Gắn lại các tham số vào URL
            url.search = currentParams.toString();

            // Chuyển hướng đến URL mới
            window.location.href = url.toString();
        });
    }

    const refreshBtn = document.getElementById('refreshBtn');
    refreshBtn.addEventListener('click', function () {
        const url = new URL(window.location.href);

        // Xóa keyword khỏi URL
        url.searchParams.delete('keywordTinh');

        // Reset về trang đầu nếu có tham số phân trang
        url.searchParams.delete('page');

        // Giữ lại 'modun=hoadon'
        url.searchParams.set('modun', 'hoadon');

        // Chuyển hướng
        window.location.href = url.toString();
    });

    const modal = document.getElementById("staticBackdropOrderModal");
    modal.addEventListener("show.bs.modal", function (event) {
        const button = event.relatedTarget;

        const id = button.getAttribute("data-id");
        const email = button.getAttribute("data-email");
        const nhanvien = button.getAttribute("data-nhanvien");
        const tenKhachHang = button.getAttribute("data-tenkhachhang");
        const ngayTao = button.getAttribute("data-ngaytao");
        const pttt = button.getAttribute("data-pttt");
        const trangThai = button.getAttribute("data-trangthai");
        const tongTien = button.getAttribute("data-tongtien");

        // Gán dữ liệu vào modal
        modal.querySelector(".modal-body .ma-don-hang").textContent = id;
        modal.querySelector(".modal-body .tai-khoan").textContent = email;
        modal.querySelector(".modal-body .ten-khach-hang").textContent = tenKhachHang;
        modal.querySelector(".modal-body .nhan-vien").textContent = nhanvien;
        modal.querySelector(".modal-body .ngay-tao").textContent = ngayTao;
        modal.querySelector(".modal-body .pttt").textContent = pttt;
        modal.querySelector(".modal-body .trang-thai").textContent = trangThai;
        modal.querySelector(".modal-body .tong-tien").textContent = tongTien;

        // Hiển thị chi tiết sản phẩm
        const cthd = JSON.parse(button.getAttribute("data-cthd"));
        const tbody = modal.querySelector(".cthd-body");
        tbody.innerHTML = "";

        cthd.forEach(item => {
            const row = `
                <tr>
                    <td>${item.SOSERI}</td>
                    <td>${item.GIALUCDAT}đ</td>
                    <td>${item.TRANGTHAIBH}</td>
                </tr>
            `;
            tbody.innerHTML += row;
        });
    });

});
</script>




<div class="p-4 bg-light">
    <div class="col-md-12 d-flex flex-wrap align-items-center gap-3">
        <form class="d-flex flex-wrap w-100 gap-2" method="GET" role="search">
            <select name="trangthai" class="selectpicker" title="Chọn trạng thái" style="max-width: 200px;" data-live-search="true" data-size="5">
                <option selected disabled>Chọn trạng thái</option>
                @foreach ($hoaDonStatuses as $status)
                <option value="{{ $status->value }}">
                    @switch($status)
                        @case(\App\Enum\HoaDonEnum::PENDING)
                            Đang xử lý
                            @break
                        @case(\App\Enum\HoaDonEnum::PAID)
                            Đã thanh toán
                            @break
                        @case(\App\Enum\HoaDonEnum::EXPIRED)
                            Hết hạn
                            @break
                        @case(\App\Enum\HoaDonEnum::CANCELLED)
                            Đã hủy
                            @break
                        @case(\App\Enum\HoaDonEnum::REFUNDED)
                            Đã hoàn tiền
                            @break
                        @default
                            {{ $status->value }}
                    @endswitch
                </option>
                @endforeach
    
            </select>

            <select class="selectpicker" name="keywordTinh" data-live-search="true" data-size="5" title="Chọn tỉnh/thành phố" style="max-width: 200px;">
                <option selected disabled>Chọn tỉnh/thành phố</option>
                @foreach($listTinh as $tinh)
                <option value="{{ $tinh->getId() }}" {{ request('keywordTinh') == $tinh->getId() ? 'selected' : '' }}>
                    {{ $tinh->getTenTinh() }}

                </option>
                @endforeach
            </select>
            <div class="d-flex align-items-center gap-2">
                <label for="calendarStart" class="fw-bold">Ngày:</label>
                <input name="ngaybatdau" type="date" id="calendarStart" class="form-control" style="max-width: 140px;">
                <span class="fw-bold">-</span>
                <input name="ngayketthuc" type="date" id="calendarEnd" class="form-control" style="max-width: 140px;">
            </div>
            <div class="d-flex align-items-center gap-2">
                <span class="fw-bold">Tiền:</span>
                <button class="btn btn-outline-primary">
                    <i class="fa-solid fa-arrow-up-wide-short"></i>
                </button>
                <button class="btn btn-outline-primary">
                    <i class="fa-solid fa-arrow-down-wide-short"></i>
                </button>
            </div>
            <button class="btn btn-success" type="submit">Tìm kiếm</button>
            <button class="btn btn-info" id="refreshBtn" type="button">Làm mới</button>
        </form>
    </div>
    
    <div class="table-responsive mt-4">
        <table class="table table-striped table-bordered text-center table-hover">
            <thead class="">
                <tr>
                    <th scope="col">ID</th>
                    <th scope="col">Tài khoản</th>
                    <th scope="col">Nhân viên</th>
                    <th scope="col">Tổng tiền</th>
                    <th scope="col">PTTT</th>
                    <th scope="col">Ngày tạo</th>
                    <th scope="col">DVVC</th>
                    <th scope="col">Trạng thái</th>
                    <th scope="col">Hành động</th>
                </tr>
            </thead>
            <tbody>
                @foreach($listHoaDon as $hoaDon)
                <tr>
                    <td>{{ $hoaDon->getId() }}</td>
                    <td>{{ $hoaDon->getEmail()->getEmail() }}</td>
                    <td>{{ $mapNguoiDung[$hoaDon->getIdNhanVien()->getId()] }}</td>
                    <td>{{ $hoaDon->getTongTien() }}</td>
                    <td>{{ $mapPTTT[$hoaDon->getIdPTTT()->getId()] }}</td>
                    <td>{{ $hoaDon->getNgayTao() }}</td>
                    <td>{{ $mapDVVC[$hoaDon->getIdDVVC()->getIdDVVC()] }}</td>
                    <td>
                        @if($hoaDon->getTrangThai() == \App\Enum\HoaDonEnum::PAID)
                            <span class="badge bg-success">Đã thanh toán</span>
                        @elseif($hoaDon->getTrangThai() == \App\Enum\HoaDonEnum::PENDING)
                            <span class="badge bg-warning text-dark">Đang xử lý</span>
                        @elseif($hoaDon->getTrangThai() == \App\Enum\HoaDonEnum::EXPIRED)
                            <span class="badge bg-secondary">Hết hạn</span>
                        @elseif($hoaDon->getTrangThai() == \App\Enum\HoaDonEnum::CANCELLED)
                            <span class="badge bg-secondary">Đã hủy</span>
                        @elseif($hoaDon->getTrangThai() == \App\Enum\HoaDonEnum::CANCELLED)
                            <span class="badge bg-success">Đã hoàn tiền</span>
                        @endif
                    </td>
                    <td>
                    <button class="btn btn-warning btn-sm"
                        data-bs-toggle="modal"
                        data-bs-target="#staticBackdropOrderModal"
                        data-id="{{ $hoaDon->getId() }}"
                        data-email="{{ $hoaDon->getEmail()->getEmail() }}"
                        data-nhanvien="{{ $mapNguoiDung[$hoaDon->getIdNhanVien()->getId()] }}"
                        data-tenkhachhang="{{ $mapHoTenByEmail[$hoaDon->getEmail()->getEmail()] }}"
                        data-ngaytao="{{ $hoaDon->getNgayTao() }}"
                        data-pttt="{{ $mapPTTT[$hoaDon->getIdPTTT()->getId()] }}"
                        data-trangthai="{{ $hoaDon->getTrangThai() }}"
                        data-tongtien="{{ $hoaDon->getTongTien() }}"
                        data-cthd='@json($mapCTHD[$hoaDon->getId()])'>
                        Chi tiết
                    </button>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    
    <nav aria-label="Page navigation example" class="d-flex justify-content-center">
            <ul class="pagination">
                <!-- Hiển thị PREV nếu không phải trang đầu tiên -->
                <?php
                $queryString = isset($_GET['keyword']) ? '&keyword=' . urlencode($_GET['keyword']) : '';
                $query = $_GET;

                // PREV
                if ($current_page > 1) {
                    echo '<li class="page-item">
                            <a class="page-link" href="?' . http_build_query(array_merge($query, ['page' => $current_page - 1])) . '" aria-label="Previous">
                                <span aria-hidden="true">&laquo;</span>
                            </a>
                        </li>';
                }

                // Hiển thị các trang phân trang xung quanh trang hiện tại
                $page_range = 1; // Hiển thị 1 trang trước và 1 trang sau
                $start_page = max(1, $current_page - $page_range);
                $end_page = min($total_page, $current_page + $page_range);

                for ($i = $start_page; $i <= $end_page; $i++) {
                    if ($i == $current_page) {
                        echo '<li class="page-item active"><span class="page-link">' . $i . '</span></li>';
                    } else {
                        echo '<li class="page-item"><a class="page-link" href="?' . http_build_query(array_merge($query, ['page' => $i])) . '">' . $i . '</a></li>';
                    }
                }
                
                // NEXT
                
                if ($current_page < $total_page) {
                    echo '<li class="page-item">
                            <a class="page-link" href="?' . http_build_query(array_merge($query, ['page' => $current_page + 1])) . '" aria-label="Next">
                                <span aria-hidden="true">&raquo;</span>
                            </a>
                        </li>';
                }
                ?>
            </ul>
          </nav>
</div>

<div class="modal fade" id="staticBackdropOrderModal" aria-hidden="true" aria-labelledby="staticBackdropLabelInfoOrder" tabindex="-1">
                          <div class="modal-dialog modal-xl ">
                            <div class="modal-content">
                              <div class="modal-header">
                                <h1 class="modal-title fs-5" id="staticBackdropLabelInfoOrder">Chỉnh sửa đơn hàng</h1>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                              </div>
                              <form action="">
                                <div class="modal-body">
                                  <div class="row">
                                      <!-- col bảng sản phẩm trong đơn hàng -->
                                      <div class="col-md-8">
                                          <div class="cart-product pb-2 px-2 border rounded-3 shadow bg-white table-responsive">
                                            <div style="max-height: 400px; overflow-y: auto;">
                                                <table class="table">
                                                    <thead>
                                                        <tr>
                                                        <th scope="col" class="text-dark">Seri</th>
                                                        <th scope="col" class="text-dark">Đơn giá</th>
                                                        <th scope="col" class="text-dark">Trạng thái bảo Hành</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody class="cthd-body">
                                                                        
                                                    </tbody>
                                                </table>
                                            </div>
                                          </div>
                                      </div>
                                      <!-- col thông tin thanh toán -->
                                      <div class="col-md-4 ">
                                          <!-- Row thông tin đơn hàng-->
                                          <div class="row pe-3">
                                              <div class="card border shadow rounded-3 w-100" style="width: 18rem;">
                                                  <ul class="list-group list-group-flush">
                                                    <li class="list-group-item fw-bold py-2">Thông tin đơn hàng</li>
                                                    <li class="list-group-item">
                                                      <div class="mt-2 mb-2 d-flex justify-content-between align-items-center small">
                                                          <strong>Mã hóa đơn</strong>
                                                          <span class="ma-don-hang opacity-50 fw-medium">
                                                              {{ $hoaDon->getId() }}
                                                          </span>
                                                      </div>
                                                      <div class="mt-2 mb-2 d-flex justify-content-between align-items-center small">
                                                          <strong>Tài khoản</strong>
                                                          <span class="tai-khoan opacity-50 fw-medium">
                                                          {{ $hoaDon->getEmail()->getEmail() }}
                                                          </span>
                                                      </div>
                                                      <div class="mt-2 mb-2 d-flex justify-content-between align-items-center small">
                                                          <strong>Tên khách hàng</strong>
                                                          <span class="ten-khach-hang opacity-50 fw-medium">
                                                          {{ $mapHoTenByEmail[$hoaDon->getEmail()->getEmail()] }}
                                                          </span>   
                                                      </div>
                                                      <div class="mt-2 mb-2 d-flex justify-content-between align-items-center small">
                                                          <strong >Nhân viên</strong>
                                                          <span class="nhan-vien opacity-50 fw-medium">
                                                          {{ $mapNguoiDung[$hoaDon->getIdNhanVien()->getId()] }}
                                                          </span>
                                                      </div>
                                                      <div class="mt-2 mb-2 small address-css">
                                                          <div><strong>Địa chỉ giao hàng</strong></div>
                                                          <div class="opacity-50 fw-medium">
                                                          {{ $hoaDon->getDiaChi() }} - {{ $mapTinh[$hoaDon->getTinh()->getId()] }}
                                                          </div>
                                                      </div>
                                                      
                                                      <div class="mt-2 mb-2 d-flex justify-content-between align-items-center small">
                                                          <strong>Ngày tạo đơn hàng</strong>
                                                          <span class="ngay-tao opacity-50 fw-medium">
                                                          {{ $hoaDon->getNgayTao() }}
                                                          </span>
                                                      </div>
                                
                                                      <div class="mb-2 d-flex justify-content-between align-items-center small ">
                                                          <strong>Phương thức thanh toán</strong>
                                                          <span class="pttt opacity-50 fw-medium">
                                                          {{ $mapPTTT[$hoaDon->getIdPTTT()->getId()] }}
                                                          </span>
                                                      </div>                                               
                                                    </li>
                                                    <li class="list-group-item py-2">
                                                      <div class="mt-2 mb-2 d-flex justify-content-between align-items-center small ">
                                                          <strong>Trạng thái</strong>
                                                          <span class="trang-thai opacity-50 fw-medium">
                                                          {{ $hoaDon->getTrangThai() }}
                                                          </span>
                                                      </div>
                                                    </li>
                                                    <li class="list-group-item">
                                                      <div class="mb-2 mt-2 d-flex justify-content-between align-items-center small ">
                                                          <strong>Tổng tiền</strong>
                                                          <span class="tong-tien opacity-50 fw-medium">{{ $hoaDon->getTongTien() }} </span>
                                                      </div>
                                                    </li>
                                                  </ul>
                                              </div>
                                          </div>
                                      </div>
                                  </div>
                                </div>
                            </div>
                          </div>
                        </div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
<!-- Select2 CSS -->
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

<!-- Select2 JS -->
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

<!-- jQuery (cần thiết cho Select2) -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<!-- Bootstrap-select CSS -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-select@1.14.0-beta3/dist/css/bootstrap-select.min.css">

<!-- jQuery (nếu chưa có) -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<!-- Bootstrap-select JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap-select@1.14.0-beta3/dist/js/bootstrap-select.min.js"></script>



