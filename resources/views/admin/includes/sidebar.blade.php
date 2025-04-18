<aside id="sidebar" class="expand">
<div class="d-flex justify-content-between p-4">
    <div class="sidebar-logo">
      <a href="#">Web2</a>
    </div>
  </div>
  <ul class="sidebar-nav" style="max-height: calc(100vh - 100px); overflow-y: auto;">
    <li class="sidebar-item {{ request()->get('modun') == 'quyen' ? 'active' : '' }}" id="quyen">
      <a href="/admin?modun=quyen" class="sidebar-link">
        <i class='bx bx-bug'></i>
        <span>Quyền</span>
      </a>
    </li>
    <li class="sidebar-item {{ request()->get('modun') == 'nguoidung' ? 'active' : '' }}" id="nguoidung">
      <a href="/admin?modun=nguoidung" class="sidebar-link">
        <i class='bx bx-user'></i>
        <span>Người dùng</span>
      </a>
    </li>
    <li class="sidebar-item {{ request()->get('modun') == 'taikhoan' ? 'active' : '' }}" id="taikhoan">
      <a href="/admin?modun=taikhoan" class="sidebar-link">
        <i class='bx bxs-user-account'></i>
        <span>Tài khoản</span>
      </a>
    </li>
    <li class="sidebar-item {{ request()->get('modun') == 'sanpham' ? 'active' : '' }}" id="sanpham">
      <a href="/admin?modun=sanpham" class="sidebar-link">
        <i class='bx bx-glasses'></i>
        <span>Sản phẩm</span>
      </a>
    </li>
    <li class="sidebar-item {{ request()->get('modun') == 'loaisanpham' ? 'active' : '' }}" id="loaisanpham">
      <a href="/admin?modun=loaisanpham" class="sidebar-link">
        <i class='bx bx-bar-chart'></i>
        <span>Loại sản phẩm</span>
      </a>
    </li>
    <li class="sidebar-item {{ request()->get('modun') == 'hang' ? 'active' : '' }}" id="hang">
      <a href="/admin?modun=hang" class="sidebar-link">
        <i class='bx bx-bar-chart'></i>
        <span>Hãng</span>
      </a>
    </li>
    <li class="sidebar-item {{ request()->get('modun') == 'hoadon' ? 'active' : '' }}" id="hoadon">
      <a href="/admin?modun=hoadon" class="sidebar-link">
        <i class='bx bx-cart'></i>
        <span>Hóa đơn</span>
      </a>
    </li>
    <li class="sidebar-item {{ request()->get('modun') == 'donvivanchuyen' ? 'active' : '' }}" id="donvivanchuyen">
      <a href="/admin?modun=donvivanchuyen" class="sidebar-link">
        <i class='bx bxs-truck'></i>
        <span>Đơn vị vận chuyển</span>
      </a>
    </li>
    <li class="sidebar-item {{ request()->get('modun') == 'chiphivanchuyen' ? 'active' : '' }}" id="chiphivanchuyen">
      <a href="/admin?modun=chiphivanchuyen" class="sidebar-link">
        <i class='bx bxs-truck'></i>
        <span>Chi phí vận chuyển</span>
      </a>
    </li>
    <li class="sidebar-item {{ request()->get('modun') == 'nhacungcap' ? 'active' : '' }}" id="nhacungcap">
      <a href="/admin?modun=nhacungcap" class="sidebar-link">
        <i class='bx bxs-truck'></i>
        <span>Nhà cung cấp</span>
      </a>
    </li>
    <li class="sidebar-item {{ request()->get('modun') == 'thanhpho' ? 'active' : '' }}" id="thanhpho">
      <a href="/admin?modun=thanhpho" class="sidebar-link" >
        <i class='bx bxs-truck'></i>
        <span>Thành phố</span>
      </a>
    </li>
    <li class="sidebar-item {{ request()->get('modun') == 'ncc' ? 'active' : '' }}" id="ncc">
      <a href="/admin?modun=nhacungcap" class="sidebar-link"  >
        <i class='bx bx-edit-alt'></i>
        <span>Nhà cung cấp</span>
      </a>
    </li>
    <li class="sidebar-item {{ request()->get('modun') == 'kho' ? 'active' : '' }}" id="kho">
      <a href="/admin?modun=kho" class="sidebar-link"  >
        <i class='bx bx-home-alt'></i>  
        <span>Nhập kho</span>
      </a>
    </li>
    <li class="sidebar-item {{ request()->get('modun') == 'khuyenmai' ? 'active' : '' }}" id="khuyenmai">
      <a href="/admin?modun=khuyenmai" class="sidebar-link"  >
        <i class='bx bx-time'></i>
        <span>Khuyến mại</span>
      </a>
    </li>
    <li class="sidebar-item {{ request()->get('modun') == 'baohanh' ? 'active' : '' }}" id="baohanh">
      <a href="/admin?modun=baohanh" class="sidebar-link"  >
        <i class='bx bx-shield-plus'></i>
        <span>Bảo hành</span>
      </a>
    </li>
    <li class="sidebar-item {{ request()->get('modun') == 'thongke' ? 'active' : '' }}" id="thongke">
      <a href="/admin?modun=thongke" class="sidebar-link"  >
        <i class='bx bx-bar-chart'></i>
        <span>Thống kê</span>
      </a>
    </li>
  </ul>
</aside>

<style>
/* Custom scrollbar */
.sidebar-nav {
  scrollbar-width: thin;
  scrollbar-color: #4a5568 #2d3748;
}

.sidebar-nav::-webkit-scrollbar {
  width: 8px;
}

.sidebar-nav::-webkit-scrollbar-track {
  background: #2d3748;
  border-radius: 4px;
}

.sidebar-nav::-webkit-scrollbar-thumb {
  background-color: #4a5568;
  border-radius: 4px;
  border: 2px solid #2d3748;
}

.sidebar-nav::-webkit-scrollbar-thumb:hover {
  background-color: #718096;
}

/* Active menu item */
.sidebar-item.active {
  background-color: #4a5568;
  border-left: 4px solid #4299e1;
}

.sidebar-item.active .sidebar-link {
  color: #fff;
}

.sidebar-item.active .sidebar-link i {
  color: #4299e1;
}

/* Hover effect */
.sidebar-item:hover {
  background-color: #4a5568;
}

.sidebar-item:hover .sidebar-link {
  color: #fff;
}

.sidebar-item:hover .sidebar-link i {
  color: #4299e1;
}
</style>
