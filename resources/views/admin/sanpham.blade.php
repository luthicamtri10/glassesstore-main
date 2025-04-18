@include('admin.includes.navbar')
<div class="p-3 bg-light">
        <!-- Nút Plus để mở Modal -->
        <button type="button" class="btn btn-primary mb-2" data-bs-toggle="modal" data-bs-target="#addProductModal">
            <i class='bx bx-plus'></i>
        </button>

        <!-- Bảng hiển thị dữ liệu -->
        <table class="table table-hover">
            <thead>
                <tr>
                    <th scope="col">ID</th>
                    <th scope="col">Tên</th>
                    <th scope="col">ID hãng</th>
                    <th scope="col">ID loại sản phẩm</th>
                    <th scope="col">Số lượng</th>
                    <th scope="col">Đơn giá</th>
                    <th scope="col">Số lượng</th>
                    <th scope="col">Thời gian bảo hành</th>
                    <th scope="col">Mô tả</th>
                    <th scope="col">Trạng thái</th>
                    <th scope="col">Hành động</th>
                </tr>
            </thead>
            <tbody>
              @foreach($sanPhams as $sanPham)
                <tr>
                  <td>{{ $sanPham->getId() }}</td>
                  <td>{{ $sanPham->getTenSanPham() }}</td>
                  <td>{{ $sanPham->getIdHang() }}</td>
                  <td>{{ $sanPham->getIdLSP() }}</td>
                  <td>{{ $sanPham->getSoLuong() }}</td>
                  <td>{{ number_format($sanPham->getDonGia()) }} VNĐ</td>
                  <td>{{ $sanPham->getThoiGianBaoHanh() }} tháng</td>
                  <td>{{ Str::limit($sanPham->getMoTa(), 50) }}</td>
                  <td>
                      @if($sanPham->getTrangThaiHD() == 1)
                          <span class="badge bg-success">Đang kinh doanh</span>
                      @else
                          <span class="badge bg-danger">Ngừng kinh doanh</span>
                      @endif
                  </td>
                </tr>
                @endforeach
            </tbody>
        </table>

        <!-- Phân trang -->
        <nav aria-label="Page navigation example" class="d-flex justify-content-center">
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

<!-- Modal Form Thêm Sản Phẩm -->
<div class="modal fade" id="addProductModal" tabindex="-1" aria-labelledby="addProductModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="addProductModalLabel">Thêm sản phẩm</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Đóng"></button>
      </div>
      <div class="modal-body">
        <form>
          <!-- Hàng 1: Tên sản phẩm & Số lượng -->
          <div class="row mb-3">
            <div class="col">
              <label class="form-label">Tên sản phẩm</label>
              <input type="text" class="form-control" placeholder="Nhập tên sản phẩm">
            </div>
            <div class="col">
              <label class="form-label">Số lượng</label>
              <input type="number" class="form-control" placeholder="Nhập số lượng">
            </div>
            <div class="col">
              <label class="form-label">Loại sản phẩm</label>
              <select id="" class="form-select">
                <option selected>Chọn...</option>
              </select>
        
            </div>
          
          <!-- Hàng 2: Hãng & Mức giá -->
          <div class="row mb-3">
            <div class="col">
              <label class="form-label">Hãng</label>
              <select id="inputCompany" class="form-select">
                <option selected>Choose...</option>

                </option>
              </select>
            </div>
            <div class="col">
              <label class="form-label">Mức giá</label>
              <input type="text" class="form-control" placeholder="Nhập mức giá">
            </div>
            <div class="col">
              <label class="form-label">Thời gian bảo hành</label>
              <input type="text" class="form-control" placeholder="Nhập thời gian bảo hành">
            </div>
          </div>

          <!-- Hàng 3: Mô tả -->
          <div class="mb-3">
            <label class="form-label">Mô tả</label>
            <textarea class="form-control" rows="3" placeholder="Nhập mô tả"></textarea>
          </div>

          <!-- Hàng 4: Trạng thái -->
          <div class="mb-3">
            <label class="form-label">Trạng thái</label>
            <select class="form-select">
              <option>Đang kinh doanh</option>
              <option>Ngừng kinh doanh</option>
              <option>Hết hàng</option>
            </select>
          </div>

          <!-- Nút Lưu -->
          <button type="submit" class="btn btn-primary">Lưu</button>
        </form>
      </div>
    </div>
  </div>
</div>
