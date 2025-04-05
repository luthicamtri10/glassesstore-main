<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
<link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

@include('admin.includes.navbar')
<?php

use App\Bus\Quyen_BUS;
use App\Bus\TaiKhoan_BUS;
$taiKhoanBUS = app(TaiKhoan_BUS::class);
$quyenBUS = app(Quyen_BUS::class);
$listTK = $taiKhoanBUS->getAllModels();
$listQ = $quyenBUS->getAllModels();
$listTK = $taiKhoanBUS->getAllModels();

if (isset($_GET['keyword']) && !empty(trim($_GET['keyword']))) {
    $keyword = $_GET['keyword'];
    $listTK = $taiKhoanBUS->searchModel($keyword, []);
} elseif (isset($_GET['keywordQuyen']) && !empty(trim($_GET['keywordQuyen']))) {
    $keyword = $_GET['keywordQuyen'];
    $listTK = $taiKhoanBUS->searchByQuyen($keyword);
}



$current_page = isset($_GET['page']) ? intval($_GET['page']) : 1;
$limit = 8;
$total_record = count($listTK); 
$total_page = ceil($total_record / $limit);
$current_page = max(1, min($current_page, $total_page));
$start = ($current_page - 1) * $limit;
$tmp = array_slice($listTK, $start, $limit);
echo "Current page: " . $current_page . '<br>';
?>
<div class="p-3 bg-light">
    <form class="d-flex" method="get" role="search">
        <input class="form-control me-2" type="search" placeholder="Tìm kiếm" aria-label="Search"
            id="keyword" name="keyword" value="<?php echo isset($_GET['keyword']) ? htmlspecialchars($_GET['keyword']) : ''; ?>">

        <button class="btn btn-outline-success" type="submit" >Tìm</button>
    </form>
    <div>
        <!-- Nút mở Modal -->
        <button type="button" class="btn btn-success mb-2" data-bs-toggle="modal" data-bs-target="#userModal">
            <i class='bx bx-plus'></i>
        </button>

        <form method="get" class="mb-2 ms-1 w-25">
            <select class="form-select" name="keywordQuyen" onchange="this.form.submit()">
                <option selected disabled>Lọc theo quyền</option>
                <?php
                    foreach($listQ as $it) {
                        $selected = isset($_GET['keywordQuyen']) && $_GET['keywordQuyen'] == $it->getId() ? 'selected' : '';
                        echo '<option value="'.$it->getId().'" '.$selected.'>'.$it->getTenQuyen().'</option>';
                    }
                ?>
            </select>
        </form>

        <table class="table table-hover">
            <thead>
                <tr>
                    <th scope="col">Tên tài khoản</th>
                    <th scope="col">Email</th>
                    <th scope="col">Tên người dùng</th>
                    <th scope="col">Tên quyền</th>
                    <th scope="col">Trạng thái</th>
                    <th scope="col">Hành động</th>
                </tr>
            </thead>
            <tbody>
                <?php
                foreach ($tmp as $tk) {
                    echo '<tr>
                            <td>' . $tk->getTenTK() . '</td>
                            <td>' . $tk->getEmail() . '</td>
                            <td>' . $tk->getIdNguoiDung()->getHoTen() . '</td>
                            <td>' . $tk->getIdQuyen()->getTenQuyen() . '</td>
                            <td>
                                <span class="badge ' . ($tk->getTrangThaiHD() ? 'bg-success' : 'bg-danger') . '">
                                    ' . ($tk->getTrangThaiHD() ? 'Hoạt động' : 'Ngừng hoạt động') . '
                                </span>
                            </td>
                            <td>
                                <button class="btn btn-warning btn-sm">Sửa</button>
                                <button class="btn btn-danger btn-sm">Xóa</button>
                            </td>
                        </tr>';
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

        // PREV
        if ($current_page > 1) {
            echo '<li class="page-item">
                    <a class="page-link" href="?page=' . ($current_page - 1) . $queryString . '" aria-label="Previous">
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
                echo '<li class="page-item"><a class="page-link" href="?page=' . $i . $queryString . '">' . $i . '</a></li>';
            }
        }
        
        // NEXT
        if ($current_page < $total_page) {
            echo '<li class="page-item">
                    <a class="page-link" href="?page=' . ($current_page + 1) . $queryString . '" aria-label="Next">
                        <span aria-hidden="true">&raquo;</span>
                    </a>
                  </li>';
        }
        ?>
    </ul>
</nav>

    </div>
</div>

<div class="modal fade" id="userModal" tabindex="-1" aria-labelledby="userModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg"> <!-- modal-lg để modal to hơn -->
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="userModalLabel">Thông tin tài khoản</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form class="row g-3">
          <div class="col-md-6">
              <label for="inputEmail4" class="form-label">Username</label>
              <input type="text" class="form-control" id="inputEmail4">
          </div>
          <div class="col-md-6">
              <label for="inputPassword4" class="form-label">Password</label>
              <input type="password" class="form-control" id="inputPassword4">
          </div>
          <div class="col-md-6">
              <label for="inputGroup" class="form-label">Nhóm quyền</label>
              <select id="inputGroup" class="form-select">
                <option selected>Choose...</option>
                <option>Admin</option>
                <option>User</option>
              </select>
          </div>
          <div class="col-md-6">
              <label for="inputStatus" class="form-label">Trạng thái</label>
              <select id="inputStatus" class="form-select">
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
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-w76A2z02tPqdjfvJ0f0FftCjN4Ckz1p5F1TXMGL6H1F6Cf0AxvKU8kHku6XlQW1T" crossorigin="anonymous"></script>
