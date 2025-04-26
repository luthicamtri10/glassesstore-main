
<script>
document.addEventListener("DOMContentLoaded", function () {
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
        // const cthdData = button.getAttribute("data-cthd");
        // console.log("Raw CTHD Data: ", cthdData); 
        // const cthd = JSON.parse(cthdData);
        // console.log("Parsed CTHD Data: ", cthd); 


        const tbody = modal.querySelector(".cthd-body");
        tbody.innerHTML = "";

        cthd.forEach(item => {
            const row = `
                <tr>
                    <td>
                     ${item.IDHD}
                    </td>
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
        <form class="d-flex flex-wrap w-100 gap-2">
            <select class="form-select" aria-label="Chọn trạng thái" style="max-width: 200px;">
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
            <input type="text" placeholder="Nhập mã đơn hàng..." class="form-control" style="max-width: 300px;">
            
            <div class="d-flex align-items-center gap-2">
                <label for="calendarStart" class="fw-bold">Ngày:</label>
                <input type="date" id="calendarStart" class="form-control" style="max-width: 140px;">
                <span class="fw-bold">-</span>
                <input type="date" id="calendarEnd" class="form-control" style="max-width: 140px;">
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
            <button class="btn btn-success">Tìm kiếm</button>
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
                    <td>{{ $mapPTTT[$hoaDon->getIdDVVC()->getIdDVVC()] }}</td>
                    <td>{{ $hoaDon->getTrangThai() }}</td>
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
    
    <nav aria-label="Page navigation" class="d-flex justify-content-center mt-3">
        <ul class="pagination">
            <li class="page-item">
                <a class="page-link" href="#" aria-label="Previous">
                    <span aria-hidden="true">&laquo;</span>
                </a>
            </li>
            <li class="page-item"><a class="page-link" href="#">1</a></li>
            <li class="page-item"><a class="page-link" href="#">2</a></li>
            <li class="page-item"><a class="page-link" href="#">3</a></li>
            <li class="page-item">
                <a class="page-link" href="#" aria-label="Next">
                    <span aria-hidden="true">&raquo;</span>
                </a>
            </li>
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
                                                        <th scope="col" class="text-dark">Sản phẩm</th>
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
                                                      <!-- <div class="mt-2 mb-2 small address-css">
                                                          <div><strong>Địa chỉ giao hàng</strong></div>
                                                          <div class="opacity-50 fw-medium">
                                                            Đồng khởi,Diên Khánh, Khánh Hòa
                                                          </DIV>
                                                      </div> -->
                                                      
                                                      <div class="mt-2 mb-2 d-flex justify-content-between align-items-center small">
                                                          <strong>Ngày tạo đơn hàng</strong>
                                                          <span class="ngay-tao opacity-50 fw-medium">
                                                          {{ $hoaDon->getNgayTao() }}
                                                          </span>
                                                      </div>
                                                      <!-- <div class="mb-2 d-flex justify-content-between align-items-center small">
                                                          <strong>Ngày cập nhật</strong>
                                                          <span class="opacity-50 fw-medium">
                                                              2025-01-07
                                                          </span >
                                                      </div> -->
                                                      
                                                      <div class="mb-2 d-flex justify-content-between align-items-center small ">
                                                          <strong>Phương thức thanh toán</strong>
                                                          <span class="pttt opacity-50 fw-medium">
                                                          {{ $mapPTTT[$hoaDon->getIdPTTT()->getId()] }}
                                                          </span>
                                                      </div>
                                                      <!-- <div class="mb-2 d-flex justify-content-between align-items-center small ">
                                                          <strong>Tổng số lượng sản phẩm</strong>
                                                          <span class="opacity-50 fw-medium">
                                                              6
                                                          </span>
                                                      </div> -->
                                                      <!-- <div class="mb-2 d-flex justify-content-between align-items-center small">
                                                          <strong>Tổng tiền sản phẩm</strong>
                                                          <span class="opacity-50 fw-medium">
                                                          {{ $hoaDon->getTongTien() }}
                                                          </span>
                                                      </div> -->
                                                      <!-- <div class="mb-2 d-flex justify-content-between align-items-center small">
                                                          <strong>Phí giao hàng</strong>
                                                          <span class="opacity-50 fw-medium">
                                                              41.000đ
                                                          </span>
                                                      </div> -->
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
<!-- <script src="../../js/"></script> -->


