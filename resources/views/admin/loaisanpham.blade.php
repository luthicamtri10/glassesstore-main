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

})
</script>

<div class="p-3 bg-light">
        <form class="d-flex me-2 mb-3" method="get" role="search">
            <input class="form-control me-2 w-25" type="search" placeholder="Tìm kiếm" aria-label="Search" id="keyword" name="keyword" value="{{ request('keyword') }}">
            <button class="btn btn-outline-success me-2" type="submit">Tìm</button>    
            <button class="btn btn-info ms-2" id="refreshBtn" type="button">Refresh</button>
        </form>
        
        <!-- Nút Plus để mở Modal -->
        <button type="button" class="btn btn-primary mb-2" data-bs-toggle="modal" data-bs-target="#addTypeProductModal">
            <i class='bx bx-plus'></i>
        </button>

        <!-- Bảng hiển thị dữ liệu -->
        <table class="table table-hover">
            <thead>
                <tr>
                    <th scope="col">ID</th>
                    <th scope="col">Tên loại sản phẩm</th>
                    <th scope="col">Mô tả</th>
                    <th scope="col">Trạng thái</th>
                    <th scope="col">Hành động</th>
                </tr>
            </thead>
            <tbody>
            @foreach($listLSP as $loai)
            <tr>
              <td>{{ $loai->getId() }}</td>
              <td>{{ $loai->gettenLSP() }}</td>
              <td>{{ $loai->getmoTa() }}</td>
              <td>
                  <span class="badge {{ $loai->getTrangThaiHD() ? 'bg-success' : 'bg-danger' }}">
                      {{ $loai->getTrangThaiHD() ? 'Hoạt động' : 'Ngừng hoạt động' }}
                  </span>
              </td>
              <td>
                  <button class="btn btn-warning btn-sm">Sửa</button>
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
<div class="modal fade" id="addTypeProductModal" tabindex="-1" aria-labelledby="addTypeProductModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="addTypeProductModalLabel">Thêm loại sản phẩm</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Đóng"></button>
      </div>
      <div class="modal-body">
        <form method="post" action="{{ route('admin.loaisanpham.store') }}">
          <!-- Hàng 1: Tên sản phẩm & Số lượng -->
          @csrf 
          <div class="row mb-3">
            <div class="col">
              <label class="form-label">Tên sản phẩm</label>
              <input type="text" name="tenLSP" class="form-control" placeholder="Nhập tên sản phẩm">
            </div>
          </div>

          <!-- Hàng 3: Mô tả -->
          <div class="row mb-3">
            <label class="form-label">Mô tả</label>
            <textarea class="form-control" name="moTa" rows="3" placeholder="Nhập mô tả"></textarea>
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
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>