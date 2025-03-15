@include('admin.includes.navbar')
<div class="p-3 bg-light">
        <!-- Nút Plus để mở Modal -->
        <button type="button" class="btn btn-primary mb-2" data-bs-toggle="modal" data-bs-target="#addBrand">
            <i class='bx bx-plus'></i>
        </button>

        <!-- Bảng hiển thị dữ liệu -->
        <table class="table table-hover">
            <thead>
                <tr>
                    <th scope="col">ID</th>
                    <th scope="col">Tên hãng</th>
                    <th scope="col">Mô tả</th>
                    <th scope="col">Trạng thái</th>
                    <th scope="col">Hành động</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <th scope="row"></th>
                    <th scope="row"></th>
                    <th scope="row"></th>
                    <th scope="row"></th>
                    
                    <td>
                        <button class="btn btn-warning btn-sm">Sửa</button>
                    </td>
                </tr>
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

<!-- Modal Form Thêm Hãng -->
<div class="modal fade" id="addBrand" tabindex="-1" aria-labelledby="addBrandLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="addTypeProductModalLabel">Thêm hãng</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Đóng"></button>
      </div>
      <div class="modal-body">
        <form>
          <!-- Hàng 1: Tên sản phẩm & Số lượng -->
          <div class="row mb-3">
            <div class="col-6">
              <label class="form-label">Tên hãng</label>
              <input type="text" class="form-control" placeholder="Nhập tên sản phẩm">
            </div>
            <div class="col-6">
            <label class="form-label">Trạng thái</label>
            <select class="form-select">
              <option>Đang kinh doanh</option>
              <option>Ngừng kinh doanh</option>
              <option>Hết hàng</option>
            </select>
          </div>
          </div>

          <!-- Hàng 3: Mô tả -->
          <div class="row mb-3">
            <label class="form-label">Mô tả</label>
            <textarea class="form-control" rows="3" placeholder="Nhập mô tả"></textarea>
          </div>

          <!-- Nút Lưu -->
          <button type="submit" class="btn btn-primary">Lưu</button>
        </form>
      </div>
    </div>
  </div>
</div>
