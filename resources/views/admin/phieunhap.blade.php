<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Danh sách phiếu nhập</h3>
                    <div class="card-tools">
                        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#addPhieuNhapModal">
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


@push('scripts')
<script>
    $(document).ready(function() {
        $('#viewPhieuNhapModal').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget);
            var id = button.data('id');
            var modal = $(this);

            // Gọi API để lấy chi tiết phiếu nhập
            $.get('/admin/phieunhap/' + id, function(data) {
                modal.find('#view-id').text(data.id);
                modal.find('#view-ncc').text(data.ncc.tenNCC);
                modal.find('#view-ngaynhap').text(data.ngayTao);
                modal.find('#view-tongtien').text(data.tongTien.toLocaleString() + ' đ');
                modal.find('#view-trangthai').text(data.trangThaiPN == 'UNPAID' ? 'Chưa thanh toán' : 'Đã thanh toán');

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
                modal.find('#view-chitiet').html(chiTietHtml);
            });
        });
    });
</script>