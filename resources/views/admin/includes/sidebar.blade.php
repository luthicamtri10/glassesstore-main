<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
  <title>Document</title>

  <!-- Boxicon -->
  <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>

  <!-- Font Awesome -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">


  <!--  -->
  @vite(['resources/css/admin/admin.css', 'resources/js/admin/admin.js'])

</head>
<body>
<div class="wrapper"> 
<aside id="sidebar">
<div class="d-flex justify-content-between p-4">
        <div class="sidebar-logo">
          <a href="#">Web2</a>
        </div>
        <button class="toggle-btn border-0" type="button">
          <i id="icon"class='bx bx-chevrons-right'></i>
        </button>
      </div>
      <ul class="sidebar-nav">
        <li class="sidebar-item">
          <a href="/admin/quyen" class="sidebar-link">
            <i class='bx bx-bug'></i>
            <span>Quyền</span>
          </a>
        </li>
        <li class="sidebar-item">
          <a href="/admin/nguoidung" class="sidebar-link">
            <i class='bx bx-user'></i>
            <span>Người dùng</span>
          </a>
        </li>
        <li class="sidebar-item">
          <a href="/admin/taikhoan" class="sidebar-link">
            <i class='bx bxs-user-account'></i>
            <span>Tài khoản</span>
          </a>
        </li>
        <li class="sidebar-item">
          <a href="/admin/sanpham" class="sidebar-link">
            <i class='bx bx-glasses'></i>
            <span>Sản phẩm</span>
          </a>
        </li>
        <li class="sidebar-item">
          <a href="/admin/loaisanpham" class="sidebar-link">
            <i class='bx bx-bar-chart'></i>
            <span>Loại sản phẩm</span>
          </a>
        </li>
        <li class="sidebar-item">
          <a href="/admin/hang" class="sidebar-link">
            <i class='bx bx-bar-chart'></i>
            <span>Hãng</span>
          </a>
        </li>
        <li class="sidebar-item">
          <a href="/admin/hoadon" class="sidebar-link">
            <i class='bx bx-cart'></i>
            <span>Hóa đơn</span>
          </a>
        </li>
        <li class="sidebar-item">
          <a href="/admin/donvivanchuyen" class="sidebar-link">
            <i class='bx bxs-truck'></i>
            <span>Đơn vị vận chuyển</span>
          </a>
        </li>
        <li class="sidebar-item">
          <a href="/admin/thanhpho" class="sidebar-link" >
            <i class='bx bxs-truck'></i>
            <span>Thành phố</span>
          </a>
        </li>
        <li class="sidebar-item">
          <a href="/admin/nhacungcap" class="sidebar-link"  >
            <i class='bx bx-edit-alt'></i>
            <span>Nhà cung cấp</span>
          </a>
        </li>
        <li class="sidebar-item">
          <a href="/admin/kho" class="sidebar-link"  >
            <i class='bx bx-home-alt'></i>  
            <span>Nhập kho</span>
          </a>
        </li>
        <li class="sidebar-item">
          <a href="/admin/khuyenmai" class="sidebar-link"  >
            <i class='bx bx-time'></i>
            <span>Khuyến mại</span>
          </a>
        </li>
        <li class="sidebar-item">
          <a href="/admin/baohanh" class="sidebar-link"  >
            <i class='bx bx-shield-plus'></i>
            <span>Bảo hành</span>
          </a>
        </li>
        <li class="sidebar-item">
          <a href="/admin/thongke" class="sidebar-link"  >
            <i class='bx bx-bar-chart'></i>
            <span>Thống kê</span>
          </a>
        </li>
      </ul>
    </aside>
  <div class="main bg-light" id="content">
    <!-- @include('admin.nguoidung') -->
  </div>
</div>


  <!-- js bootstrap -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
  

</body>
</html>








