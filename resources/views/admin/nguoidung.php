<?php
    include '../includes/navbar.php';
?>
<div class="p-3 bg-light">
    <div>
            <!-- Nút mở Modal -->
            <button type="button" class="btn btn-success mb-2" data-bs-toggle="modal" data-bs-target="#userModal">
                <i class='bx bx-plus'></i>
            </button>

            <select class="form-select w-25 mb-1 ms-1" aria-label="Default select example">
                <option selected>Open this select menu</option>
                <option value="1">One</option>
                <option value="2">Two</option>
                <option value="3">Three</option>
            </select>

            <table class="table table-hover">
            <thead>
                <tr>
                <th scope="col">ID</th>
                <th scope="col">Họ tên</th>
                <th scope="col">Email</th>
                <th scope="col">Ngày sinh</th>
                <th scope="col">Giới tính</th>
                <th scope="col">Địa chỉ</th>
                <th scope="col">Thành phố</th>
                <th scope="col">Số điện thoại</th>
                <th scope="col">CCCD</th>
                <th scope="col">Trạng thái</th>
                <th scope="col">Hành động</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                <th scope="row">1</th>
                <td>Minh đẹp trại</td>
                <td>pcongminh551@gmail.com</td>
                <td>14/04/2004</td>
                <td>Nữ</td>
                <td>123</td>
                <td>Đồng Nai</td>
                <td>0896634215</td>
                <td>011104001111</td>
                <td>1</td>
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

<div class="modal fade" id="userModal" tabindex="-1" aria-labelledby="userModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="userModalLabel">Thông tin tài khoản</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form class="row g-3">
          <div class="col-md-6">
              <label for="fullName" class="form-label">Họ tên</label>
              <input type="text" class="form-control" id="fullName">
          </div>
          <div class="col-md-6">
              <label for="email" class="form-label">Email</label>
              <input type="email" class="form-control" id="email">
          </div>
          <div class="col-md-6">
              <label for="dob" class="form-label">Ngày sinh</label>
              <input type="date" class="form-control" id="dob">
          </div>
          <div class="col-md-6">
              <label for="gender" class="form-label">Giới tính</label>
              <select id="gender" class="form-select">
                <option selected>Choose...</option>
                <option>Nam</option>
                <option>Nữ</option>
                <option>Khác</option>
              </select>
          </div>
          <div class="col-md-6">
              <label for="address" class="form-label">Địa chỉ</label>
              <input type="text" class="form-control" id="address">
          </div>
          <div class="col-md-6">
              <label for="city" class="form-label">Thành phố</label>
              <input type="text" class="form-control" id="city">
          </div>
          <div class="col-md-6">
              <label for="phone" class="form-label">Số điện thoại</label>
              <input type="tel" class="form-control" id="phone">
          </div>
          <div class="col-md-6">
              <label for="cccd" class="form-label">CCCD</label>
              <input type="text" class="form-control" id="cccd">
          </div>
          <div class="col-md-6">
              <label for="status" class="form-label">Trạng thái</label>
              <select id="status" class="form-select">
                <option selected>Choose...</option>
                <option>Hoạt động</option>
                <option>Ngừng hoạt động</option>
              </select>
          </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="submit" class="btn btn-primary">Lưu</button>
      </div>
    </div>
  </div>
</div>