@include('admin.includes.navbar')
<div class="p-3 bg-light">
    <div>
            <!-- Nút mở Modal -->
            <button type="button" class="btn btn-success mb-2" data-bs-toggle="modal" data-bs-target="#transportModal">
                <i class='bx bx-plus'></i>
            </button>
            <table class="table table-hover">
            <thead>
                <tr>
                <th scope="col">ID</th>
                <th scope="col">Tên đơn vị vận chuyển</th>
                <th scope="col">Thành phố</th>
                <th scope="col">Chi phí vận chuyển</th>
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
                <th scope="row"></th>
                <th scope="row"></th>
                
                <td>
                    <button class="btn btn-warning btn-sm">Sửa</button>
                    <button class="btn btn-danger btn-sm">Xóa</button>
                </td>
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
</div>

<div class="modal fade" id="transportModal">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="userModalLabel">Thông tin tài khoản</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form class="row g-3 modal-lg">
          <div class="col-md-6">
              <label for="inputEmail4" class="form-label">Tên đơn vị vận chuyển</label>
              <input type="text" class="form-control" id="inputEmail4">
          </div>
          <div class="col-md-6">
              <label for="inputStatus" class="form-label">Thành phố</label>
              <select id="inputStatus" class="form-select">
                <option selected>Choose...</option>
                <option selected>Hồ chí minh</option>
              </select>
          </div>
          <div class="col-md-6">
              <label for="inputEmail4" class="form-label">Chi phí vận chuyển</label>
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
</div>