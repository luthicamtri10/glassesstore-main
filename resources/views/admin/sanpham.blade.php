<script>
  document.addEventListener('DOMContentLoaded', function () {
    // Tìm kiếm: giữ lại tất cả query hiện có và chỉ cập nhật 'keyword' + 'keywordQuyen'
    const searchForm = document.querySelector('form[role="search"]');
    if (searchForm) {
    searchForm.addEventListener('submit', function (e) {
        e.preventDefault();

        const currentUrl = new URL(window.location.href);
        const keywordInput = document.getElementById('keyword');

        if (keywordInput && keywordInput.value.trim()) {
            currentUrl.searchParams.set('keyword', keywordInput.value.trim());
        } else {
            currentUrl.searchParams.delete('keyword');
        }

        // Reset về page 1 nếu có param page
        currentUrl.searchParams.delete('page');

        window.location.href = currentUrl.toString();
    });

    }

    const refreshBtn = document.getElementById('refreshBtn');
    refreshBtn.addEventListener('click', function () {
        const url = new URL(window.location.href);

        // Xóa keyword khỏi URL
        url.searchParams.delete('keyword');

        // Reset về trang đầu nếu có tham số phân trang
        url.searchParams.delete('page');

        // Chuyển hướng
        window.location.href = url.toString();
    });

    const editButtons = document.querySelectorAll('.btn-edit');
    const previewImage = document.getElementById('previewImage');
    editButtons.forEach(function (btn) {
        btn.addEventListener('click', function () {
            const modal = document.querySelector('#updateProductModal');
            if (!modal) return;

            const tenSanPhamInput = modal.querySelector('input[name="tenSanPham"]');
            const hangSanPhamInput = modal.querySelector('select[name="idHang"]');
            const loaiSanPhamInput = modal.querySelector('select[name="idLSP"]');
            const donGiaSanPhamInput = modal.querySelector('input[name="donGia"]');
            const thoiGianBaoHanhSanPhamInput = modal.querySelector('input[name="thoiGianBaoHanh"]');
            const moTaSanPhamInput = modal.querySelector('textarea[name="moTa"]');
            
            tenSanPhamInput.value = this.getAttribute('data-tenSanPham');
            hangSanPhamInput.value = this.getAttribute('data-hang');
            loaiSanPhamInput.value = this.getAttribute('data-loaisanpham');
            donGiaSanPhamInput.value = this.getAttribute('data-dongia');
            thoiGianBaoHanhSanPhamInput.value = this.getAttribute('data-thoigianbaohanh');
            moTaSanPhamInput.value = this.getAttribute('data-mota');

            const idSanPham = this.getAttribute('data-id').trim();
            previewImage.src = '/productImg/' + idSanPham + '.webp';
        });
    });
})

document.querySelector('form').addEventListener('submit', function(event) {
    var fileInput = document.querySelector('input[name="anhSanPham"]');
    if (!fileInput.files.length) {
        alert('Vui lòng chọn ảnh sản phẩm.');
        event.preventDefault(); // Ngừng gửi form nếu không chọn file
    }
});

</script>

@if(session('success'))
<script>
    document.addEventListener("DOMContentLoaded", function() {
      const addModal = bootstrap.Modal.getInstance(document.getElementById('addProductModal'));
      if (addModal) addModal.hide();

      const updateModal = bootstrap.Modal.getInstance(document.getElementById('updateProductModal'));
      if (updateModal) updateModal.hide();

    });
</script>
@endif

<div class="p-3 bg-light">
        <form class="d-flex me-2 mb-3" method="get" role="search">
            <input class="form-control me-2 w-25" type="search" placeholder="Tìm kiếm" aria-label="Search" id="keyword" name="keyword" value="{{ request('keyword') }}">
            <button class="btn btn-outline-success me-2" type="submit">Tìm</button>    
            <button class="btn btn-info ms-2" id="refreshBtn" type="button">Làm mới</button>
        </form>
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
                    <th scope="col">Hãng</th>
                    <th scope="col">Loại sản phẩm</th>
                    <th scope="col">Đơn giá</th>
                    <th scope="col">Thời gian bảo hành</th>
                    <th scope="col">Mô tả</th>
                    <th scope="col">Trạng thái</th>
                    <th scope="col">Hành động</th>
                </tr>
            </thead>
            <tbody>
              @foreach($listSP as $sanPham)
                <tr>
                  <td>{{ $sanPham->getId() }}</td>
                  <td>{{ $sanPham->getTenSanPham() }}</td>
                  <td>{{ $mapTenHang[$sanPham->getIdHang()->getId()] }}</td>
                  <td>{{ $mapTenLoaiSP[$sanPham->getIdLSP()->getId()] }}</td>  
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
                  <td>
                    <button class="btn btn-warning btn-sm btn-edit"
                      data-bs-toggle="modal"
                      data-bs-target="#updateProductModal"
                      data-id=" {{ $sanPham->getId() }} "
                      data-tenSanPham="{{ $sanPham->getTenSanPham() }}"
                      data-hang="{{ $sanPham->getIdHang()->getId() }}"
                      data-loaisanpham="{{ $sanPham->getIdLSP()->getId() }}"
                      data-dongia="{{ $sanPham->getDonGia() }}"
                      data-thoigianbaohanh="{{ $sanPham->getThoiGianBaoHanh() }}"
                      data-mota="{{ $sanPham->getMoTa() }}">
                    
                      Sửa
                   </button>
                  </td>
                </tr>
                @endforeach
            </tbody>
        </table>

        <!-- Phân trang -->
        <nav aria-label="Page navigation example" class="d-flex justify-content-center">
          <ul class="pagination">
              <!-- Hiển thị PREV nếu không phải trang đầu tiên -->
              <?php
              $queryString = isset($_GET['keyword']) ? '&keyword=' . urlencode($_GET['keyword']) : '';
              $query = $_GET;

              // PREV
              if ($current_page > 1) {
                  echo '<li class="page-item">
                          <a class="page-link" href="?' . http_build_query(array_merge($query, ['page' => $current_page - 1])) . '" aria-label="Previous">
                              <span aria-hidden="true">&laquo;</span>
                          </a>
                      </li>';
              }

              // Hiển thị các trang phân trang xung quanh trang hiện tại
              $page_range = 1; // Hiển thị 1 trang trước và 1 trang sau
              $start_page = max(1, $current_page - $page_range);
              $end_page = min($total_page, $current_page + $page_range);

              for ($i = $start_page; $i <= $end_page; $i++) {
                  if ($i == $current_page) {
                      echo '<li class="page-item active"><span class="page-link">' . $i . '</span></li>';
                  } else {
                      echo '<li class="page-item"><a class="page-link" href="?' . http_build_query(array_merge($query, ['page' => $i])) . '">' . $i . '</a></li>';
                  }
              }
              
              // NEXT
              
              if ($current_page < $total_page) {
                  echo '<li class="page-item">
                          <a class="page-link" href="?' . http_build_query(array_merge($query, ['page' => $current_page + 1])) . '" aria-label="Next">
                              <span aria-hidden="true">&raquo;</span>
                          </a>
                      </li>';
              }
              ?>
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
        <form method="post" action="{{ route('admin.sanpham.store') }}" enctype="multipart/form-data">
          @csrf
          <!-- Hàng 1: Tên sản phẩm & Loại Sản Phẩm & Hãng -->
          <div class="row mb-3">
            <div class="col-4">
              <label class="form-label">Tên sản phẩm</label>
              <input type="text" name="tenSanPham" class="form-control" placeholder="Nhập tên sản phẩm">
            </div>
            <div class="col-4">
              <label class="form-label">Loại sản phẩm</label>
              <select id="" class="form-select" name="idLSP">
                @foreach($listLSP as $it)
                <option value="{{ $it->getId() }}">
                    {{ $it->gettenLSP() }}
                </option>
                @endforeach
              </select>
            </div>
            <div class="col-4">
              <label class="form-label">Hãng</label>
              <select id="inputCompany" name="idHang" class="form-select">
                @foreach($listHang as $it)
                <option value="{{ $it->getId() }}">
                    {{ $it->gettenHang() }}
                </option>
                @endforeach
              </select>
            </div>
          </div>
          
          <!-- Hàng 2: Thời gian bảo hành & Mức giá -->
          <div class="row mb-3">           
            <div class="col-6">
              <label class="form-label">Mức giá</label>
              <input type="text" name="donGia" class="form-control" placeholder="Nhập mức giá">
            </div>
            <div class="col-6">
              <label class="form-label">Thời gian bảo hành</label>
              <input type="text" name="thoiGianBaoHanh" class="form-control" placeholder="Nhập thời gian bảo hành">
            </div>
          </div>

          <!-- Hàng 3: Mô tả -->
          <div class="mb-3">
            <label class="form-label">Mô tả</label>
            <textarea class="form-control" name="moTa" rows="3" placeholder="Nhập mô tả"></textarea>
          </div>
          
          <!-- Hàng 4: Ảnh sản phẩm -->
          <div class="mb-3">
            <label class="form-label">Ảnh sản phẩm</label>
            <input type="file" class="form-control" accept="image/*" name="anhSanPham">
          </div>
          <!-- Nút Lưu -->
          <button type="submit" class="btn btn-primary">Lưu</button>
        </form>
      </div>
    </div>
  </div>
</div>

<!-- Model update sản phẩm   -->
<div class="modal fade" id="updateProductModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Sửa sản phẩm</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Đóng"></button>
      </div>
      <div class="modal-body">
        <form method="post" action="{{ route('admin.sanpham.store') }}" enctype="multipart/form-data">
          @csrf
          <!-- Hàng 1: Tên sản phẩm & Loại Sản Phẩm & Hãng -->
          <div class="row mb-3">
            <div class="col-4">
              <label class="form-label">Tên sản phẩm</label>
              <input type="text" name="tenSanPham" class="form-control" placeholder="Nhập tên sản phẩm">
            </div>
            <div class="col-4">
              <label class="form-label">Loại sản phẩm</label>
              <select id="" class="form-select" name="idLSP">
                @foreach($listLSP as $it)
                <option value="{{ $it->getId() }}">
                    {{ $it->gettenLSP() }}
                </option>
                @endforeach
              </select>
            </div>
            <div class="col-4">
              <label class="form-label">Hãng</label>
              <select id="inputCompany" name="idHang" class="form-select">
                @foreach($listHang as $it)
                <option value="{{ $it->getId() }}">
                    {{ $it->gettenHang() }}
                </option>
                @endforeach
              </select>
            </div>
          </div>
          
          <!-- Hàng 2: Thời gian bảo hành & Mức giá -->
          <div class="row mb-3">           
            <div class="col-6">
              <label class="form-label">Mức giá</label>
              <input type="text" name="donGia" class="form-control" placeholder="Nhập mức giá">
            </div>
            <div class="col-6">
              <label class="form-label">Thời gian bảo hành</label>
              <input type="text" name="thoiGianBaoHanh" class="form-control" placeholder="Nhập thời gian bảo hành">
            </div>
          </div>

          <!-- Hàng 3: Mô tả -->
          <div class="mb-3">
            <label class="form-label">Mô tả</label>
            <textarea class="form-control" name="moTa" rows="3" placeholder="Nhập mô tả"></textarea>
          </div>
          
          <!-- Hàng 4: Ảnh sản phẩm -->
          <div class="mb-3">
            <label class="form-label">Ảnh sản phẩm</label>
            <input type="file" class="form-control" accept="image/*" name="anhSanPham">
            <img id="previewImage" src="" alt="Ảnh sản phẩm" style="max-width: 200px; margin-top: 10px;">

          </div>
          <!-- Nút Lưu -->
          <button type="submit" class="btn btn-primary">Lưu</button>
        </form>
      </div>
    </div>
  </div>
</div>

@if(session('success'))
<div class="alert alert-success alert-dismissible fade show" role="alert" id="successAlert">
    {{ session('success') }}
</div>
@endif
@if(session('error'))
<div class="alert alert-success alert-dismissible fade show" role="alert" id="errorAlert">
    {{ session('error') }}
</div>
@endif
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
