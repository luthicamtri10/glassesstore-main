<nav class="navbar navbar-expand-lg bg-body-tertiary">
  <div class="container">
    <div class="collapse navbar-collapse d-flex justify-content-end">
      
      <div class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
          <i class='bx bxs-cog'></i>
        </a>
        <ul class="dropdown-menu dropdown-menu-end">
          <li><a class="dropdown-item" href="#">Hồ sơ</a></li>
          <li><a class="dropdown-item" href="#">Đơn mua</a></li>
          <li><a class="dropdown-item" href="#">Giỏ hàng</a></li>
          <li><a class="dropdown-item" href="#">Đổi mật khẩu</a></li>
          <li><hr class="dropdown-divider"></li>
          <li>
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit" class="dropdown-item d-flex align-items-center" href=""><i class='bx bx-log-out-circle me-2' ></i>Đăng xuất</button>
            </form>
            
          </li>
        </ul>
      </div>
    </div>
  </div>
</nav>
