<!-- @include('admin.includes.navbar') -->
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const editButtons = document.querySelectorAll('.btn-edit');
        editButtons.forEach(function (btn) {
            btn.addEventListener('click', function () {
                const modal = document.querySelector('#accountUpdateModal');
                if (!modal) return;
                // data-fullname="' . $tk->getHoTen() . '"
                // data-datebirth="'.$tk->getNgaySinh().'"
                // data-gender="' . $tk->getGioiTinh() . '"
                // data-address="' .$tk->getDiaChi() . '"
                // data-tinh="' . $tk->getTinh()->getId() . '"
                // data-phonenumber="' . $tk->getSoDienThoai() . '"
                // data-cccd="' . $tk->getCccd() . '"
                modal.querySelector('input[name="username"]').value = this.dataset.username;
                modal.querySelector('input[name="email"]').value = this.dataset.email;
                modal.querySelector('select[name="idnguoidung"]').value = this.dataset.idnguoidung;
                modal.querySelector('select[name="idquyen"]').value = this.dataset.idquyen;
            });
        });
        const successAlert = document.getElementById('successAlert');
        if (successAlert) {
            setTimeout(() => {
                successAlert.classList.remove('show');
                successAlert.classList.add('fade');
                successAlert.style.opacity = 0;
            }, 3000); // 3 giây

            setTimeout(() => {
                successAlert.remove(); // Xoá hẳn khỏi DOM
            }, 4000);
        }
        // Refresh: Xoá toàn bộ query params (ngoại trừ 'modun')
        document.getElementById('refreshBtn').addEventListener('click', function () {
            const currentUrl = new URL(window.location.href);
            // Giữ lại 'modun'
            const modun = currentUrl.searchParams.get('modun');
            currentUrl.search = ''; // Xóa hết params
            if (modun) {
                currentUrl.searchParams.set('modun', modun); // Giữ lại modun nếu có
            }
            window.location.href = currentUrl.toString();
        });

        // Tìm kiếm: cập nhật mã để giữ lại 'modun'
        const searchForm = document.querySelector('form[role="search"]');
        if (searchForm) {
            searchForm.addEventListener('submit', function (e) {
                e.preventDefault();
                const currentUrl = new URL(window.location.href);
                const keywordInput = document.getElementById('keyword');
                const quyenSelect = searchForm.querySelector('select[name="keywordTinh"]');

                // Giữ lại 'modun'
                const modun = currentUrl.searchParams.get('modun');
                if (modun) {
                    currentUrl.searchParams.set('modun', modun);
                }

                if (keywordInput && keywordInput.value.trim()) {
                    currentUrl.searchParams.set('keyword', keywordInput.value.trim());
                } else {
                    currentUrl.searchParams.delete('keyword');
                }

                if (quyenSelect && quyenSelect.value) {
                    currentUrl.searchParams.set('keywordTinh', quyenSelect.value);
                } else {
                    currentUrl.searchParams.delete('keywordTinh');
                }

                currentUrl.searchParams.delete('page'); // Reset về page 1

                window.location.href = currentUrl.toString();
            });
        }
    });
</script>
<!-- 
@if(session('success'))
    const modal = bootstrap.Modal.getInstance(document.getElementById('userModal'));
    if (modal) modal.hide();
@endif -->
<div class="p-3 bg-light flex">
    <form class="d-flex me-2 mb-3" method="get" role="search">
        <input class="form-control me-2 w-25" type="search" placeholder="Tìm kiếm" aria-label="Search" id="keyword" name="keyword" value="{{ request('keyword') }}">

        <button class="btn btn-outline-success me-2" type="submit">Tìm</button>

        <select class="form-select w-25 ms-2" name="keywordTinh">
            <option disabled {{ request('keywordTinh') ? '' : 'selected' }}>Lọc theo quyền</option>
            @foreach($listTinh as $it)
                <option value="{{ $it->getId() }}" {{ request('keywordTinh') == $it->getId() ? 'selected' : '' }}>
                    {{ $it->getTenTinh() }}
                </option>
            @endforeach
        </select>

        <button class="btn btn-info ms-2" id="refreshBtn" type="button">Refresh</button>
        <button type="button" class="btn btn-success p-3 w-10 ms-5" data-bs-toggle="modal" data-bs-target="#userAddModal">
            <i class='bx bx-plus'></i>
        </button>
    </form>
    <div class="ms-2">
        <table class="table table-hover">
            <thead>
                <tr>
                    <th scope="col">Họ tên</th>
                    <th scope="col">Ngày sinh</th>
                    <th scope="col">Giới Tính</th>
                    <th scope="col">Địa chỉ</th>
                    <th scope="col">Tỉnh</th>
                    <th scope="col">Số điện thoại</th>
                    <th scope="col">CCCD</th>
                    <th scope="col">Trạng thái</th>
                    <th scope="col">Hành động</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if(empty($tmp)) {
                    echo '<tr class="text-center">Không tìm thấy...</tr>';
                } else {
                    foreach ($tmp as $tk) {
                        echo '<tr>
                                <td>' . $tk->getHoTen() . '</td>
                                <td>' . $tk->getNgaySinh() . '</td>
                                <td>' . $tk->getGioiTinh() == 'MALE' ? 'Nam' : 'Nữ' . '</td>
                                <td>' . $tk->getDiaChi() . '</td>\
                                <td>' . $tk->getTinh()->getTenTinh() . '</td>
                                <td>' . $tk->getSoDienThoai() . '</td>
                                <td>' . $tk->getCccd() . '</td>
                                <td></td>
                                <td>
                                    <span class="badge ' . ($tk->getTrangThaiHD() ? 'bg-success' : 'bg-danger') . '">
                                        ' . ($tk->getTrangThaiHD() ? 'Hoạt động' : 'Ngừng hoạt động') . '
                                    </span>
                                </td>
                                <td>
                                    <button class="btn btn-warning btn-sm btn-edit"
                                        data-fullname="' . $tk->getHoTen() . '"
                                        data-datebirth="'.$tk->getNgaySinh().'"
                                        data-gender="' . $tk->getGioiTinh() . '"
                                        data-address="' .$tk->getDiaChi() . '"
                                        data-tinh="' . $tk->getTinh()->getId() . '"
                                        data-phonenumber="' . $tk->getSoDienThoai() . '"
                                        data-cccd="' . $tk->getCccd() . '"
                                        data-bs-toggle="modal"
                                        data-bs-target="#userUpdateModal">Sửa</button>
                                    <button class="btn btn-danger btn-sm">Xóa</button>
                                </td>
                            </tr>';
                    }
                }
                ?>
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
</div>
<!-- modal them nguoidung -->
<!-- data-fullname="' . $tk->getHoTen() . '"
data-datebirth="'.$tk->getNgaySinh().'"
data-gender="' . $tk->getGioiTinh() . '"
data-address="' .$tk->getDiaChi() . '"
data-tinh="' . $tk->getTinh()->getId() . '"
data-phonenumber="' . $tk->getSoDienThoai() . '"
data-cccd="' . $tk->getCccd() . '" -->
<div class="modal fade" id="userAddModal" tabindex="-1" aria-labelledby="userModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg"> <!-- modal-lg để modal to hơn -->
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="userModalLabel">Thông tin tài khoản</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form class="row g-3" method="post" action="{{ route('admin.taikhoan.store') }}">
        @csrf  <!-- Thêm csrf token để bảo vệ bảo mật -->
          <div class="col-md-6">
              <label for="inputEmail4" class="form-label" name="username">Username</label>
              <input type="text" class="form-control" name="username">
          </div>
          <div class="col-md-6">
              <label for="inputEmail4" class="form-label" name="email">Email</label>
              <input type="text" class="form-control" name="email">
          </div>
          <div class="col-md-6">
              <label for="inputPassword4" class="form-label" name="password">Password</label>
              <input type="password" class="form-control" name="password">
          </div>
          <div class="col-md-6">
              <label for="inputGroup" class="form-label">Nhóm quyền</label>
              <select id="inputGroup" class="form-select" name="idquyen">
                <option selected disabled>Chọn quyền</option>
                @foreach($listTinh as $it)
                    <option value="{{ $it->getId() }}">
                        {{ $it->getTenTinh() }}
                    </option>
                @endforeach
              </select>
          </div>
          <div class="col-md-6">
              <label for="inputGroup" class="form-label">Người dùng</label>
              <select id="inputGroup" class="form-select" name="idnguoidung">
                <option selected disabled>Chọn người dùng</option>
                @foreach($listND as $it)
                    <option value="{{ $it->getId() }}">
                        {{ $it->getId() }} - {{ $it->getHoTen() }}
                    </option>
                @endforeach
              </select>
          </div>
          <!-- <div class="col-md-6">
              <label for="inputStatus" class="form-label">Trạng thái</label>
              <select id="inputStatus" class="form-select">
                <option selected>Choose...</option>
                <option>Hoạt động</option>
                <option>Ngừng hoạt động</option>
              </select>
          </div> -->
          <div class="modal-footer">
            <button type="submit" class="btn btn-primary">Lưu</button>
        </div>
        </form>
      </div>
      
    </div>
  </div>
</div>
<!-- modal update nguoidung -->
<div class="modal fade" id="userUpdateModal" tabindex="-1" aria-labelledby="userModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg"> <!-- modal-lg để modal to hơn -->
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="userModalLabel">Thông tin tài khoản</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form class="row g-3" method="post" action="{{ route('admin.taikhoan.update') }}">
        @csrf  <!-- Thêm csrf token để bảo vệ bảo mật -->
          <div class="col-md-6">
              <label for="inputEmail4" class="form-label" name="username">Username</label>
              <input type="text" class="form-control" name="username">
          </div>
          <div class="col-md-6">
              <label for="inputEmail4" class="form-label" name="email">Email</label>
              <input type="text" class="form-control" name="email">
          </div>
          <div class="col-md-6">
              <label for="inputPassword4" class="form-label" name="password">Mật khẩu mới (để trống nếu không đổi):</label>
              <input type="password" class="form-control" name="password" placeholder="********">
          </div>
          <div class="col-md-6">
              <label for="inputGroup" class="form-label">Nhóm quyền</label>
              <select id="inputGroup" class="form-select" name="idquyen">
                <option selected disabled>Chọn quyền</option>
                @foreach($listTinh as $it)
                    <option value="{{ $it->getId() }}">
                        {{ $it->getTenTinh() }}
                    </option>
                @endforeach
              </select>
          </div>
          <div class="col-md-6">
              <label for="inputGroup" class="form-label">Người dùng</label>
              <select id="inputGroup" class="form-select" name="idnguoidung">
                <option selected disabled>Chọn người dùng</option>
                @foreach($listND as $it)
                    <option value="{{ $it->getId() }}">
                        {{ $it->getId() }} - {{ $it->getHoTen() }}
                    </option>
                @endforeach
              </select>
          </div>
          <!-- <div class="col-md-6">
              <label for="inputStatus" class="form-label">Trạng thái</label>
              <select id="inputStatus" class="form-select">
                <option selected>Choose...</option>
                <option>Hoạt động</option>
                <option>Ngừng hoạt động</option>
              </select>
          </div> -->
          <div class="modal-footer">
            <button type="submit" class="btn btn-primary">Lưu</button>
        </div>
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
