<?php

use App\Bus\Auth_BUS;
use App\Bus\CTQ_BUS;
use App\Bus\TaiKhoan_BUS;

  $email = app(Auth_BUS::class)->getEmailFromToken();
  $user = app(TaiKhoan_BUS::class)->getModelById($email);
  $ctq = app(CTQ_BUS::class)->getModelById($user->getIdQuyen()->getId());
?>
<aside id="sidebar" class="expand">
<div class="d-flex justify-content-between p-4">
    <div class="sidebar-logo">
      <a href="/">
      <img src="https://img.ws.mms.shopee.vn/vn-11134216-7r98o-lq2sgdy60w5uba" 
                    alt="Logo" 
                    class="img-fluid rounded-5" 
                    style="height: 70px;">
      </a>
    </div>
  </div>
  <ul class="sidebar-nav">
    @if(app(CTQ_BUS::class)->checkChucNangExistInListCTQ($ctq, 9))
    <li class="sidebar-item" id="quyen">
      <a href="/admin?modun=quyen" class="sidebar-link">
        <i class='bx bx-bug'></i>
        <span>Quyền</span>
      </a>
    </li>
    @endif
    @if(app(CTQ_BUS::class)->checkChucNangExistInListCTQ($ctq, 12))
    <li class="sidebar-item" id="nguoidung">
      <a href="/admin?modun=nguoidung" class="sidebar-link">
        <i class='bx bx-user'></i>
        <span>Người dùng</span>
      </a>
    </li>
    @endif
    @if(app(CTQ_BUS::class)->checkChucNangExistInListCTQ($ctq, 5))
    <li class="sidebar-item" id="taikhoan">
      <a href="/admin?modun=taikhoan" class="sidebar-link">
        <i class='bx bxs-user-account'></i>
        <span>Tài khoản</span>
      </a>
    </li>
    @endif
    @if(app(CTQ_BUS::class)->checkChucNangExistInListCTQ($ctq, 1))
    <li class="sidebar-item" id="sanpham">
      <a href="/admin?modun=sanpham" class="sidebar-link">
        <i class='bx bx-glasses'></i>
        <span>Sản phẩm</span>
      </a>
    </li>
    @endif
    @if(app(CTQ_BUS::class)->checkChucNangExistInListCTQ($ctq, 13))
    <li class="sidebar-item" id="loaisanpham">
      <a href="/admin?modun=loaisanpham" class="sidebar-link">
        <i class='bx bx-bar-chart'></i>
        <span>Loại sản phẩm</span>
      </a>
    </li>
    @endif
    @if(app(CTQ_BUS::class)->checkChucNangExistInListCTQ($ctq, 14))
    <li class="sidebar-item" id="hang">
      <a href="/admin?modun=hang" class="sidebar-link">
        <i class='bx bx-bar-chart'></i>
        <span>Hãng</span>
      </a>
    </li>
    @endif
    @if(app(CTQ_BUS::class)->checkChucNangExistInListCTQ($ctq, 2))
    <li class="sidebar-item" id="hoadon">
      <a href="/admin?modun=hoadon" class="sidebar-link">
        <i class='bx bx-cart'></i>
        <span>Hóa đơn</span>
      </a>
    </li>
    @endif
    @if(app(CTQ_BUS::class)->checkChucNangExistInListCTQ($ctq, 10))
    <li class="sidebar-item" id="donvivanchuyen">
      <a href="/admin?modun=donvivanchuyen" class="sidebar-link">
        <i class='bx bxs-truck'></i>
        <span>Đơn vị vận chuyển</span>
      </a>
    </li>
    @endif
    @if(app(CTQ_BUS::class)->checkChucNangExistInListCTQ($ctq, 15))
    <li class="sidebar-item" id="thanhpho">
      <a href="/admin?modun=thanhpho" class="sidebar-link" >
        <i class='bx bxs-truck'></i>
        <span>Thành phố</span>
      </a>
    </li>
    @endif
    @if(app(CTQ_BUS::class)->checkChucNangExistInListCTQ($ctq, 3))
    <li class="sidebar-item" id="ncc">
      <a href="/admin?modun=nhacungcap" class="sidebar-link"  >
        <i class='bx bx-edit-alt'></i>
        <span>Nhà cung cấp</span>
      </a>
    </li>
    @endif
    @if(app(CTQ_BUS::class)->checkChucNangExistInListCTQ($ctq, 4))
    <li class="sidebar-item" id="kho">
      <a href="/admin?modun=kho" class="sidebar-link"  >
        <i class='bx bx-home-alt'></i>  
        <span>Nhập kho</span>
      </a>
    </li>
    @endif
    @if(app(CTQ_BUS::class)->checkChucNangExistInListCTQ($ctq, 8))
    <li class="sidebar-item" id="khuyenmai">
      <a href="/admin?modun=khuyenmai" class="sidebar-link"  >
        <i class='bx bx-time'></i>
        <span>Khuyến mại</span>
      </a>
    </li>
    @endif
    @if(app(CTQ_BUS::class)->checkChucNangExistInListCTQ($ctq, 16))
    <li class="sidebar-item" id="baohanh">
      <a href="/admin?modun=baohanh" class="sidebar-link"  >
        <i class='bx bx-shield-plus'></i>
        <span>Bảo hành</span>
      </a>
    </li>
    @endif
    @if(app(CTQ_BUS::class)->checkChucNangExistInListCTQ($ctq, 16))
    <li class="sidebar-item" id="baohanh">
      <a href="/admin?modun=chiphivanchuyen" class="sidebar-link"  >
        <i class='bx bx-shield-plus'></i>
        <span>Chi phí vận chuyển</span>
      </a>
    </li>
    @endif
    @if(app(CTQ_BUS::class)->checkChucNangExistInListCTQ($ctq, 7))
    <li class="sidebar-item" id="thongke">
      <a href="/admin?modun=thongke" class="sidebar-link"  >
        <i class='bx bx-bar-chart'></i>
        <span>Thống kê</span>
      </a>
    </li>
    @endif
  </ul>
</aside>
