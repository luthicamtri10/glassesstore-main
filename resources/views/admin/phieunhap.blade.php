@include('admin.includes.navbar')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Danh sách phiếu nhập</h3>
                    <div class="card-tools">
                        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addPhieuNhapModal">
                            <i class="fas fa-plus"></i> Thêm phiếu nhập
                        </button>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <form action="{{ url()->current() }}" method="GET">
                                <input type="hidden" name="modun" value="phieunhap">
                                <div class="input-group">
                                    <input type="text" name="keyword" class="form-control" placeholder="Tìm kiếm...">
                                    <div class="input-group-append">
                                        <button type="submit" class="btn btn-default">
                                            <i class="fas fa-search"></i>
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <div class="col-md-6 text-right">
                            <a href="{{ url()->current() }}?modun=phieunhap" class="btn btn-secondary">
                                <i class="fas fa-sync-alt"></i> Làm mới
                            </a>
                        </div>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Nhà cung cấp</th>
                                    <th>Ngày nhập</th>
                                    <th>Tổng tiền</th>
                                    <th>Thao tác</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($listPhieuNhap as $phieuNhap)
                                <tr>
                                    <td>{{ $phieuNhap->getId() }}</td>
                                    <td>{{ $phieuNhap->getIdNCC() }}</td>
                                    <td>{{ $phieuNhap->getNgayTao()->format('d/m/Y') }}</td>
                                    <td>{{ number_format($phieuNhap->getTongTien(), 0, ',', '.') }} đ</td>
                                    <td>
                                        <a href="{{ url()->current() }}?modun=phieunhap-chitiet&id={{ $phieuNhap->getId() }}"
                                            class="btn btn-info btn-sm">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    @if($total_page > 1)
                    <div class="d-flex justify-content-center mt-3">
                        <nav>
                            <ul class="pagination">
                                @if($current_page > 1)
                                <li class="page-item">
                                    <a class="page-link" href="{{ url()->current() }}?modun=phieunhap&page={{ $current_page - 1 }}" aria-label="Previous">
                                        <span aria-hidden="true">&laquo;</span>
                                    </a>
                                </li>
                                @endif

                                @for($i = 1; $i <= $total_page; $i++)
                                    <li class="page-item {{ $i == $current_page ? 'active' : '' }}">
                                    <a class="page-link" href="{{ url()->current() }}?modun=phieunhap&page={{ $i }}">{{ $i }}</a>
                                    </li>
                                    @endfor

                                    @if($current_page < $total_page)
                                        <li class="page-item">
                                        <a class="page-link" href="{{ url()->current() }}?modun=phieunhap&page={{ $current_page + 1 }}" aria-label="Next">
                                            <span aria-hidden="true">&raquo;</span>
                                        </a>
                                        </li>
                                        @endif
                            </ul>
                        </nav>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal xem chi tiết -->
<div class="modal fade" id="viewPhieuNhapModal" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Chi tiết phiếu nhập</h5>
                <button type="button" class="close" data-dismiss="modal">
                    <span>&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-6">
                        <p><strong>ID:</strong> <span id="view-id"></span></p>
                        <p><strong>Nhà cung cấp:</strong> <span id="view-ncc"></span></p>
                        <p><strong>Ngày nhập:</strong> <span id="view-ngaynhap"></span></p>
                    </div>
                    <div class="col-md-6">
                        <p><strong>Tổng tiền:</strong> <span id="view-tongtien"></span></p>
                        <p><strong>Trạng thái:</strong> <span id="view-trangthai"></span></p>
                    </div>
                </div>
                <div class="table-responsive mt-3">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Sản phẩm</th>
                                <th>Số lượng</th>
                                <th>Đơn giá</th>
                                <th>Thành tiền</th>
                            </tr>
                        </thead>
                        <tbody id="view-chitiet">
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal thêm phiếu nhập -->
<div class="modal fade" id="addPhieuNhapModal" tabindex="-1" aria-labelledby="addPhieuNhapModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addPhieuNhapModalLabel">Thêm phiếu nhập</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="addPhieuNhapForm">
                    @csrf
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="ncc" class="form-label">Nhà cung cấp</label>
                            <select class="form-control" id="ncc-select" name="ncc" required>
                                <option value="">Chọn nhà cung cấp</option>
                                @foreach($listNCC as $ncc)
                                    <option value="{{ $ncc->getIdNCC() }}">{{ $ncc->getTenNCC() }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label for="ngayNhap" class="form-label">Ngày nhập</label>
                            <input type="date" class="form-control" id="ngayNhap" name="ngayNhap" required>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-12">
                            <label for="sanPham" class="form-label">Sản phẩm</label>
                            <select class="form-control" id="sanPham" name="sanPham">
                                <option value="">Chọn sản phẩm</option>
                                @foreach($listSanPham as $sanPham)
                                    <option value="{{ $sanPham->getId() }}" data-gia="{{ $sanPham->getDonGia() }}">
                                        {{ $sanPham->getTenSanPham() }} - {{ number_format($sanPham->getDonGia(), 0, ',', '.') }} đ
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-4">
                            <label for="soLuong" class="form-label">Số lượng</label>
                            <input type="number" class="form-control" id="soLuong" name="soLuong" min="1" value="1">
                        </div>
                        <div class="col-md-4">
                            <label for="giaNhap" class="form-label">Giá nhập</label>
                            <input type="number" class="form-control" id="giaNhap" name="giaNhap" min="0" required>
                        </div>
                        <div class="col-md-4">
                            <label for="phanTramLN" class="form-label">Phần trăm lợi nhuận</label>
                            <input type="number" class="form-control" id="phanTramLN" name="phanTramLN" min="0" value="15" required>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-12">
                            <button type="button" class="btn btn-primary" id="addProductBtn">
                                <i class="fas fa-plus"></i> Thêm sản phẩm
                            </button>
                        </div>
                    </div>

                    <div class="table-responsive">
                        <table class="table table-bordered" id="productTable">
                            <thead>
                                <tr>
                                    <th>Sản phẩm</th>
                                    <th>Số lượng</th>
                                    <th>Giá nhập</th>
                                    <th>Thành tiền</th>
                                    <th>Thao tác</th>
                                </tr>
                            </thead>
                            <tbody></tbody>
                            <tfoot>
                                <tr>
                                    <td colspan="3" class="text-right"><strong>Tổng tiền:</strong></td>
                                    <td colspan="2"><span id="totalAmount">0</span> đ</td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
                <button type="button" class="btn btn-primary" id="savePhieuNhapBtn">Lưu</button>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<!-- Bootstrap 5 JS Bundle with Popper -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Khởi tạo modal
        const addPhieuNhapModal = new bootstrap.Modal(document.getElementById('addPhieuNhapModal'), {
            keyboard: false
        });

        // Xử lý sự kiện mở modal
        document.querySelector('[data-bs-target="#addPhieuNhapModal"]').addEventListener('click', function(e) {
            e.preventDefault();
            addPhieuNhapModal.show();
        });

        let selectedProducts = [];
        let totalAmount = 0;

        // Khi chọn sản phẩm, tự động điền giá nhập
        document.getElementById('sanPham').addEventListener('change', function() {
            const selectedOption = this.options[this.selectedIndex];
            if (selectedOption.value) {
                const giaBan = selectedOption.dataset.gia;
                document.getElementById('giaNhap').value = giaBan || '';
            }
        });

        // Thêm sản phẩm vào bảng
        document.getElementById('addProductBtn').addEventListener('click', function() {
            const sanPhamId = document.getElementById('sanPham').value;
            const sanPhamText = document.getElementById('sanPham').options[document.getElementById('sanPham').selectedIndex].text;
            const soLuong = parseInt(document.getElementById('soLuong').value);
            const giaNhap = parseFloat(document.getElementById('giaNhap').value);

            // Kiểm tra dữ liệu đầu vào
            if (!sanPhamId) {
                alert('Vui lòng chọn sản phẩm');
                return;
            }

            if (isNaN(soLuong) || soLuong <= 0) {
                alert('Số lượng phải là số nguyên dương');
                return;
            }

            if (isNaN(giaNhap) || giaNhap <= 0) {
                alert('Giá nhập phải là số dương');
                return;
            }

            const thanhTien = soLuong * giaNhap;

            // Kiểm tra sản phẩm đã tồn tại chưa
            const existingProduct = selectedProducts.find(p => p.id === sanPhamId);
            if (existingProduct) {
                existingProduct.soLuong += soLuong;
                existingProduct.thanhTien = existingProduct.soLuong * existingProduct.giaNhap;
            } else {
                selectedProducts.push({
                    id: sanPhamId,
                    ten: sanPhamText,
                    soLuong: soLuong,
                    giaNhap: giaNhap,
                    phanTramLN: parseFloat(document.getElementById('phanTramLN').value) || 15,
                    thanhTien: thanhTien
                });
            }

            updateProductTable();
            calculateTotal();
        });

        // Cập nhật bảng sản phẩm
        function updateProductTable() {
            const tbody = document.querySelector('#productTable tbody');
            tbody.innerHTML = '';

            selectedProducts.forEach((product, index) => {
                tbody.innerHTML += `
                    <tr>
                        <td>${product.ten}</td>
                        <td>${product.soLuong}</td>
                        <td>${product.giaNhap.toLocaleString()} đ</td>
                        <td>${product.thanhTien.toLocaleString()} đ</td>
                        <td>
                            <button type="button" class="btn btn-danger btn-sm remove-product" data-index="${index}">
                                <i class="fas fa-trash"></i>
                            </button>
                        </td>
                    </tr>
                `;
            });
        }

        // Xóa sản phẩm
        document.addEventListener('click', function(e) {
            if (e.target.closest('.remove-product')) {
                const index = e.target.closest('.remove-product').dataset.index;
                selectedProducts.splice(index, 1);
                updateProductTable();
                calculateTotal();
            }
        });

        // Tính tổng tiền
        function calculateTotal() {
            totalAmount = selectedProducts.reduce((sum, product) => sum + product.thanhTien, 0);
            document.getElementById('totalAmount').textContent = totalAmount.toLocaleString();
        }

        // Lưu phiếu nhập
        document.getElementById('savePhieuNhapBtn').addEventListener('click', function() {
            if (selectedProducts.length === 0) {
                alert('Vui lòng thêm ít nhất một sản phẩm');
                return;
            }

            const nccSelect = document.getElementById('ncc-select');
            const nccId = nccSelect.value;

            console.log('Selected NCC ID:', nccId);
            const ngayNhap = document.getElementById('ngayNhap').value;

            // if (!nccId || !ngayNhap) {
            //     alert('Vui lòng điền đầy đủ thông tin phiếu nhập');
                
            //     return;
            // }

            const formData = {
                // _token: document.querySelector('meta[name="csrf-token"]').content,
                idNCC: nccId,
                ngayNhap: ngayNhap,
                chiTiet: selectedProducts.map(product => ({
                    id: product.id,
                    soLuong: product.soLuong,
                    giaNhap: product.giaNhap,
                    phanTramLN: product.phanTramLN
                }))
            };

            console.log('Sending data:', formData);

            fetch('/admin/phieunhap/store', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    // 'X-CSRF-TOKEN': formData._token,
                },
                body: JSON.stringify(formData)
            })
            .then(response => response.json())
            .then(data => {
                console.log('Response:', data);
                if (data.success) {
                    alert('Thêm phiếu nhập thành công');
                    location.reload();
                } else {
                    alert('Có lỗi xảy ra: ' + data.message);
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Có lỗi xảy ra: ' + error.message);
            });
        });

        document.getElementById('viewPhieuNhapModal').addEventListener('show.bs.modal', function(event) {
            // Lấy nút đã click để mở modal
            var button = event.relatedTarget;
            if (!button) return;
            var id = button.getAttribute('data-id');
            var modal = document.getElementById('viewPhieuNhapModal');

            // Gọi API để lấy chi tiết phiếu nhập
            fetch('/admin/phieunhap/' + id)
                .then(response => response.json())
                .then(data => {
                    modal.querySelector('#view-id').textContent = data.id;
                    modal.querySelector('#view-ncc').textContent = data.ncc.tenNCC;
                    modal.querySelector('#view-ngaynhap').textContent = data.ngayTao;
                    modal.querySelector('#view-tongtien').textContent = data.tongTien.toLocaleString() + ' đ';
                    modal.querySelector('#view-trangthai').textContent = data.trangThaiPN == 'UNPAID' ? 'Chưa thanh toán' : 'Đã thanh toán';

                    // Hiển thị chi tiết
                    var chiTietHtml = '';
                    data.chiTietPhieuNhaps.forEach(function(ct) {
                        chiTietHtml += '<tr>' +
                            '<td>' + ct.sanPham.tenSP + '</td>' +
                            '<td>' + ct.soLuong + '</td>' +
                            '<td>' + ct.donGia.toLocaleString() + ' đ</td>' +
                            '<td>' + (ct.soLuong * ct.donGia).toLocaleString() + ' đ</td>' +
                            '</tr>';
                    });
                    modal.querySelector('#view-chitiet').innerHTML = chiTietHtml;
                });
        });
    });
</script>
