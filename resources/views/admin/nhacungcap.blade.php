<div class="p-3 bg-light">
    <div>
        <!-- Nút mở Modal -->
        <button type="button" class="btn btn-success mb-2" data-bs-toggle="modal" data-bs-target="#supplierModal">
            <i class='bx bx-plus'></i>
        </button>
        <table class="table table-hover">
            <thead>
                <tr>
                    
                    <th scope="col">Tên nhà cung cấp</th>
                    <th scope="col">Số điện thoại</th>
                    <th scope="col">Mô tả</th>
                    <th scope="col">Địa chỉ</th>
                    <th scope="col">Trạng thái</th>
                    <th scope="col">Hành động</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($listNCC as $supplier)
                <tr>
                   
                    <td>{{ $supplier->getTenNCC() }}</td>
                    <td>{{ $supplier->getSdtNCC() }}</td>
                    <td>{{ $supplier->getMoTa() }}</td>
                    <td>{{ $supplier->getDiachi() }}</td>
                    <td>{{ $supplier->getTrangthaiHD() }}</td>
                    <td>
                        <button class="btn btn-warning btn-sm">Sửa</button>
                        <button class="btn btn-danger btn-sm">Xóa</button>
                    </td>
                </tr>
                @endforeach
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

<!-- Modal Thêm/Sửa Nhà cung cấp -->
<div class="modal fade" id="supplierModal">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="supplierModalLabel">Thêm nhà cung cấp</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form method="POST" action="{{ route('admin.supplier.store') }}" class="row g-3">
                @csrf
                <div class="modal-body">
                    <div class="col-md-12">
                        <label for="supplierName" class="form-label">Tên nhà cung cấp</label>
                        <input type="text" class="form-control" id="supplierName" name="TENNCC" required>
                    </div>
                    <div class="col-md-12">
                        <label for="phone" class="form-label">Số điện thoại</label>
                        <input type="text" class="form-control" id="phone" name="SODIENTHOAI" required>
                    </div>
                    <div class="col-md-12">
                        <label for="description" class="form-label">Mô tả</label>
                        <textarea class="form-control" id="description" name="MOTA"></textarea>
                    </div>
                    <div class="col-md-12">
                        <label for="address" class="form-label">Địa chỉ</label>
                        <input type="text" class="form-control" id="address" name="DIACHI" required>
                    </div>
                    <div class="col-md-12">
                        <label for="status" class="form-label">Trạng thái</label>
                        <select class="form-control" id="status" name="TRANGTHAIHD">
                            <option value="1">Hoạt động</option>
                            <option value="0">Không hoạt động</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
                    <button type="submit" class="btn btn-primary">Lưu</button>
                </div>
            </form>
        </div>
    </div>
</div>
