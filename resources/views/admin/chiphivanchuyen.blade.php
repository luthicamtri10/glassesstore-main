
<div class="p-3 bg-light">
    <div>
        <!-- Nút mở Modal -->
        <button type="button" class="btn btn-success mb-2" data-bs-toggle="modal" data-bs-target="#shippingCostModal">
            <i class='bx bx-plus'></i>
        </button>
        <table class="table table-hover">
            <thead>
                <tr>
                    <th scope="col">ID Tỉnh</th>
                    <th scope="col">ID Vận chuyển</th>
                    <th scope="col">Chi phí vận chuyển</th>
                    <th scope="col">Hành động</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($listCPVC as $cost)
                <tr>
                    <td>{{ $cost->getIDTINH() }}</td>
                    <td>{{ $cost->getIDVC() }}</td>
                    <td>{{ $cost->getCHIPHIVC() }}</td>
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

<!-- Modal Thêm/Sửa Chi phí vận chuyển -->
<div class="modal fade" id="shippingCostModal">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="shippingCostModalLabel">Thêm chi phí vận chuyển</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form method="POST" action="{{ route('admin.shipping-cost.store') }}" class="row g-3">
                @csrf
                <div class="modal-body">
                    <div class="col-md-12">
                        <label for="provinceId" class="form-label">ID Tỉnh</label>
                        <input type="text" class="form-control" id="provinceId" name="IDTINH" required>
                    </div>
                    <div class="col-md-12">
                        <label for="shippingId" class="form-label">ID Vận chuyển</label>
                        <input type="text" class="form-control" id="shippingId" name="IDVC" required>
                    </div>
                    <div class="col-md-12">
                        <label for="shippingCost" class="form-label">Chi phí vận chuyển</label>
                        <input type="number" class="form-control" id="shippingCost" name="CHIPHIVC" required>
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
