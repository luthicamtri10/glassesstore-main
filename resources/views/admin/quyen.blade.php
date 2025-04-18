@include('admin.includes.navbar')

<div class="p-3 bg-light">
    <div>
            <!-- Nút mở Modal -->
            <button type="button" class="btn btn-success mb-2" data-bs-toggle="modal" data-bs-target="#editRoleGroupModal">
                <i class='bx bx-plus'></i>
            </button>

            <table class="table table-hover">
            <thead>
                <tr>
                <th scope="col">ID</th>
                <th scope="col">Tên quyền</th>
                <th scope="col">ID chức năng</th>
                <th scope="col">Trạng thái</th>
                <th scope="col">Hành động</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                <th scope="row">1</th>
                <td>Nhân viên bán hàng</td>
                <td>1</td>
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

<!-- Modal Chỉnh sửa nhóm quyền -->
<div class="modal fade" id="editRoleGroupModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabelEditCatalog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <h1 class="modal-title fs-5" id="roleModalLabel">Chỉnh sửa nhóm quyền</h1>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <form action="" id="roleForm">
          <div class="modal-body">
            <div class="form-floating mb-3">
                <input type="text" class="form-control" name="tenNQ" id="permissionGroupName" placeholder="Nhập tên nhóm quyền">
                <label for="permissionGroupName" style="color: #1D712C;">Tên nhóm quyền</label>
                <span class="text-message role-name-msg"></span>
            </div>
            <table class="table table-borderless permission-group table-hover">
                <thead>
                    <tr>
                        <th class="text-success fs-5">Danh mục chức năng</th>
                        <th class="text-success fs-5">Được quyền</th>                   
                    </tr>
                </thead>
                <tbody>                   
                    <tr>
                        <td>Quản lý nhóm quyền</td>
                        <td><input type="checkbox" name="NQ_xem" class="form-check-input"></td>
                       
                    </tr>
                    <tr>
                        <td>Quản lý tài khoản</td>
                        <td><input type="checkbox" name="NQ_xem" class="form-check-input"></td>
                    </tr>
                    <tr>
                        <td>Quản lý sản phẩm</td>
                        <td><input type="checkbox" name="NQ_xem" class="form-check-input"></td>
                    </tr>
                    <tr>
                        <td>Quản lý hóa đơn</td>
                        <td><input type="checkbox" name="NQ_xem" class="form-check-input"></td>
                    </tr>
                    <tr>
                        <td>Quản lý nhà cung cấp</td>
                        <td><input type="checkbox" name="NQ_xem" class="form-check-input"></td>
                    </tr>
                    <tr>
                        <td>Quản lý mã giảm giá</td>
                        <td><input type="checkbox" name="NQ_xem" class="form-check-input"></td>
                    </tr>
                    <tr>
                        <td>Quản lý phiếu nhập</td>
                        <td><input type="checkbox" name="NQ_xem" class="form-check-input"></td>
                    </tr>
                    <tr>
                        <td>Đặt hàng</td>
                        <td><input type="checkbox" name="NQ_xem" class="form-check-input"></td>
                    </tr>
                    <tr>
                        <td>Quản lý đơn vị vận chuyển</td>
                        <td><input type="checkbox" name="NQ_xem" class="form-check-input"></td>
                    </tr>
                    <tr>
                        <td>Quản lý Bảo hành</td>
                        <td><input type="checkbox" name="DH_xem" class="form-check-input"></td>
                        
                    </tr>
                    <tr>
                        <td>Thống kê</td>
                        <td><input type="checkbox" name="PN_xem" class="form-check-input"></td>
                    </tr>
               
                  
                </tbody>
            </table>
            <div class="col-8 ">
                <input type="text" class="form-control" id="inputEmail4" placeholder="Nhập tên quyền">
            </div>
                        
             <div class="my-2">
                <button class="btn btn-info btn-sm"><i class='bx bx-plus' ></i></button>
                <!-- <button class="btn btn-danger btn-sm"><i class='bx bx-minus'></i></button> -->
             </div>
                
    
          <div class="modal-footer">
            <button type="button" class="btn btn-success" id="submit_btn">Xác nhận</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
