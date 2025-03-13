<?php
    include '../../views/admin/includes/navbar.php'
?>
<div class="p-3">
            <!-- Nút mở Modal -->
            <!-- <button type="button" class="btn btn-success mb-2" data-bs-toggle="modal" data-bs-target="#warehouseModal">
                <i class='bx bx-plus'></i>
            </button> -->
            <table class="table table-hover shadow-sm">
                <thead>
                    <tr>
                    <th scope="col">ID khách hàng</th>
                    <th scope="col">ID sản phẩm</th>
                    <th scope="col">Chi phí bảo hành</th>
                    <th scope="col">Thời điểm bảo hành</th>
                    <th scope="col">Số seri</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                    <th scope="row"></th>
                    <th scope="row"></th>
                    <th scope="row"></th>
                    <th scope="row"></th>
                    <th scope="row"></th>
                    </tr>
                </tbody>
            </table>

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

<!-- <div class="modal fade" id="warehouseModal">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="userModalLabel">Thông tin kho</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form class="row g-3 modal-lg">
          <div class="col-md-6">
              <label for="inputEmail4" class="form-label">Tên nhà cung cấp</label>
              <input type="text" class="form-control" id="inputEmail4">
          </div>
          <div class="col-md-6">
              <label for="inputEmail4" class="form-label">Số điện thoại</label>
              <input type="text" class="form-control" id="inputEmail4">
          </div>
          <div class="col-md-6">
              <label for="inputEmail4" class="form-label">Địa chỉ</label>
              <input type="text" class="form-control" id="inputEmail4">
          </div>
          <div class="col-md-6">
              <label for="inputStatus" class="form-label">Trạng thái</label>
              <select id="inputStatus" class="form-select">
                <option selected>Choose...</option>
                <option>Hoạt động</option>
                <option>Ngừng hoạt động</option>
              </select>
          </div>
          <div class="mb-3">
            <label class="form-label">Mô tả</label>
            <textarea class="form-control" rows="3" placeholder="Nhập mô tả"></textarea>
          </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="submit" class="btn btn-primary">Lưu</button>
      </div>
    </div>
  </div>
</div> -->