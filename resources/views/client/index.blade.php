    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('css/client/include/navbar.css') }}">
    <link rel="stylesheet" href="{{ asset('css/client/include/footer.css') }}">
    <link rel="stylesheet" href="{{ asset('css/client/Login-Register.css') }}">
    <link rel="stylesheet" href="{{ asset('css/client/HomePageClient.css') }}">
    <link rel="stylesheet" href="{{ asset('css/client/AcctInfoOH.css') }}">
    <script>
      document.addEventListener('DOMContentLoaded', function () {
        
  const searchForms = document.querySelectorAll('form[role="search"]');

  searchForms.forEach(function (searchForm) {
    searchForm.addEventListener('submit', function (e) {
      e.preventDefault();

      const currentUrl = new URL(window.location.href);
      const keywordInput = searchForm.querySelector('#keyword');
      const lspSelect = searchForm.querySelector('select[name="lsp"]');
      const hangSelect = searchForm.querySelector('select[name="hang"]')
      if (keywordInput && keywordInput.value.trim()) {
        currentUrl.searchParams.set('keyword', keywordInput.value.trim());
        currentUrl.searchParams.delete('lsp');
        currentUrl.searchParams.delete('hang');
      } else if (lspSelect && lspSelect.value && lspSelect.value !== "0") {
        currentUrl.searchParams.set('lsp', lspSelect.value);
        currentUrl.searchParams.delete('hang');
        currentUrl.searchParams.delete('keyword');
      } else if (hangSelect && hangSelect.value && hangSelect.value !== "0") {
        currentUrl.searchParams.set('hang', hangSelect.value);
        currentUrl.searchParams.delete('lsp');
        currentUrl.searchParams.delete('keyword');
      } else {
        currentUrl.searchParams.delete('keyword');
        currentUrl.searchParams.delete('hang');
        currentUrl.searchParams.delete('lsp');
      }

      currentUrl.searchParams.delete('page');

      window.location.href = currentUrl.toString();
    });

    const lspSelect = searchForm.querySelector('select[name="lsp"]');
    if (lspSelect) {
      lspSelect.addEventListener('change', function () {
        searchForm.dispatchEvent(new Event('submit'));
      });
    }
    const hangSelect = searchForm.querySelector('select[name="hang"]');
    if (hangSelect) {
      hangSelect.addEventListener('change', function () {
        searchForm.dispatchEvent(new Event('submit'));
      });
    }
  });
  const userBtn = document.getElementById('userDropdownBtn');
  const dropdownMenu = document.getElementById('userDropdownMenu');

  if (userBtn && dropdownMenu) {
    userBtn.addEventListener('click', function (e) {
      e.stopPropagation(); // tránh việc click ngoài làm tắt menu ngay lập tức
      const isVisible = dropdownMenu.style.display === 'block';
      dropdownMenu.style.display = isVisible ? 'none' : 'block';
    });

    // Click ngoài menu thì ẩn dropdown
    document.addEventListener('click', function (e) {
      if (!userBtn.contains(e.target)) {
        dropdownMenu.style.display = 'none';
      }
    });
  }
  document.querySelectorAll(".product").forEach((productDiv) => {
    productDiv.addEventListener("click", () => {
      
      const modal = document.querySelector('#productDetailModal');
      if (!modal) return;
      modal.querySelector('input[name="tensp"]').value = this.dataset.tensp;
      modal.querySelector('input[name="hang"]').value = this.dataset.hang;
      modal.querySelector('select[name="lsp"]').value = this.dataset.lsp;
      modal.querySelector('select[name="soluong"]').value = this.dataset.soluong;
      modal.querySelector('select[name="mota"]').value = this.dataset.mota;
      modal.querySelector('select[name="dongia"]').value = this.dataset.dongia;
      modal.querySelector('select[name="tgbh"]').value = this.dataset.thbh;
      modal.querySelector('img[name="img"]').src = this.dataset.img;
      // Hiển thị modal
      document.getElementById("productDetailModal").style.display = "block";
    });
  });

  // Đóng modal khi click nút đóng
  document.querySelector(".btn-close").addEventListener("click", () => {
    document.getElementById("productDetailModal").style.display = "none";
  });
});

  </script>

    <!-- Nội dung trang chính ở đây -->
     <header>
    <div class="text-white" id="navbar-ctn">
      <div class="top-nav">
        <p style="color: #55d5d2; font-size: 14px; font-weight: 600;">GIẢM GIÁ NGAY 15% CHO ĐƠN ĐẦU TIÊN</p>
        <ul class="list-top-nav d-flex ms-auto gap-2">
          <li class="nav-item px-3 py-1 bg-secondary text-white fw-medium rounded-pill " id="chinhsach"><a href="">Chính sách</a></li>
          <li class="nav-item px-3 py-1 bg-secondary text-white fw-medium rounded-pill" id="tracuudonhang"><a href="">Tra cứu đơn hàng</a></li>
          @if($user->getIdQuyen()->getId() == 1 || $user->getIdQuyen()->getId() == 2) 
            <li class="nav-item px-3 py-1 bg-secondary text-white fw-medium rounded-pill" id="tracuudonhang"><a href="/admin">Trang quản trị</a></li>
          @endif
          @if($isLogin) 
          <li class="nav-item px-3 py-1 bg-secondary text-white fw-medium rounded-pill" id="userDropdownBtn" style="position: relative; cursor: pointer;">
            {{$user->getTenTK()}}
            <div id="userDropdownMenu" class="" style="display: none ; width: 150px; height: auto; position: absolute; right: 0; background: white; border: 1px solid #ccc; padding: 10px; z-index: 999;align-items: center; border-radius: 5px; padding: 15px;">
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="btn btn-danger btn-sm" style="height: 40px; width: 120px; margin: auto;">Đăng xuất</button>
                </form>
            </div>
          </li>
          @else 
          <li class="nav-item px-3 py-1 bg-secondary text-white fw-medium rounded-pill" id="taikhoan"><a href="/login">Đăng nhập</a></li>
          @endif
        </ul>
      </div>
      <div class="navbar text-white navbar-expand" id="navbar">
        <a href="" class="navbar-brand">Logo</a>
        <form action="" method="get" role="search">
          <ul class="navbar-nav gap-5">
            <li class="nav-item fw-medium my-2 mx-2" id="item-sanpham"><a href="" class="nav-link text-white">Sản Phẩm <i class="fa-regular fa-angle-up"></i></a></li>
            <li class="nav-item fw-medium d-flex"><a href="#" class="nav-link text-white">Tìm Cửa Hàng<i class="fa-regular fa-location-dot fa-bounce"></i></a> </li>
            <li class="nav-item fw-medium" style="position: relative;"><input class="rounded-pill py-2" type="text" placeholder="Tìm kiếm sản phẩm" style="width: 300px;outline: none;border:none;padding: 0 30px 0 10px;" name="keyword" value="{{ request('keyword') }}"><i class="fa-solid fa-magnifying-glass" style="position: absolute; right: 10px; color: #555;"></i></li>
            <li class="nav-item fw-medium my-2" id="item-xemthem"><a href="" class="nav-link text-white">Xem Thêm <i class="fa-regular fa-angle-up"></i></a></li>
            <li class="nav-item fw-medium"><a href="#" class="nav-link text-white">Hành Trình Tử Tế</a></li>
            <li class="nav-item fw-medium my-2" id="item-giohang"><a href="#" class="nav-link text-white">Giỏ Hàng <i class="fa-light fa-bag-shopping" style="position: relative;"><small style="padding: 5px;background:rgb(232, 164, 76);color: white;position: absolute;right: -15px;bottom: -15px;font-size: 12px;border-radius: 50%;">0</small></i></a></li>
          </ul>
        </form>
        
      </div>
    </div>
  </header>
  <div class="submenu card" style="z-index: 100;">
    <div class="card-menu d-flex ">

    </div>

  </div>
  <div class="ctn-content">
  <img src="{{ asset('client/img/bannner.png') }}" class="img-fluid w-100">

    <div class="main justify-content-center d-flex">
      <div class="best-seller text-center">
        <h1 class="text-start" style="width: fit-content; ;padding: 15px 0 10px;color: #55d5d2; border-bottom: solid 5px #55d5d2;margin-right: auto; font-family: Roboto;">BÁN CHẠY NHẤT</h1>
        <div class="row my-5" style="max-height: 380px;display: flex;">
          <div class="col-3 item-product">
            <div class="img-product">
            <img src="{{ asset('client/img/sanpham.jpeg') }}" class="img-fluid w-100" alt="">

            </div>
            <div class="info-product ">
              <div class="name-product">GK.M GỌNG NHỰA AN221393 (50.18.145)</div>
              <div class="price-product" style="position: relative;">350.000đ <i class="fa-solid fa-arrow-up-right icon-arrow"></i></div>
            </div>
            <div class="" style="height: 80px; width: 100%;"></div>
          </div>
          <div class="col-3 item-product">
            <div class="img-product">
            <img src="{{ asset('client/img/sanpham.jpeg') }}" class="img-fluid w-100" alt="">
            </div>
            <div class="info-product ">
              <div class="name-product">GK.M GỌNG NHỰA AN221393 (50.18.145)</div>
              <div class="price-product" style="position: relative;">350.000đ <i class="fa-solid fa-arrow-up-right icon-arrow"></i></div>
            </div>
            <div class="" style="height: 80px; width: 100%;"></div>
          </div>
          <div class="col-3 item-product">
            <div class="img-product">
            <img src="{{ asset('client/img/sanpham.jpeg') }}" class="img-fluid w-100" alt="">
            </div>
            <div class="info-product ">
              <div class="name-product">GK.M GỌNG NHỰA AN221393 (50.18.145)</div>
              <div class="price-product" style="position: relative;">350.000đ <i class="fa-solid fa-arrow-up-right icon-arrow"></i></div>
            </div>
            <div class="" style="height: 80px; width: 100%;"></div>
          </div>
          <div class="col-3 item-product">
            <div class="img-product">
            <img src="{{ asset('client/img/sanpham.jpeg') }}" class="img-fluid w-100" alt="">
            </div>
            <div class="info-product ">
              <div class="name-product">GK.M GỌNG NHỰA AN221393 (50.18.145)</div>
              <div class="price-product" style="position: relative;">350.000đ <i class="fa-solid fa-arrow-up-right icon-arrow"></i></div>
            </div>
            <div class="" style="height: 80px; width: 100%;"></div>
          </div>
        </div>

      </div>

    </div>
    <div class="banner-small ">
      <div class="bnsm"><img src="client/img/small-banner1.png" class="img-fluid w-100"></div>
      <div class="bnsm"><img src="client/img/small-banner2.png" class="img-fluid w-100"></div>
    </div>
    <div class="ctn-danhmucsanpham" style="background-color: #f6f2f2;padding-bottom: 30px;">
      <div class="type-product-items flex flex-row justify-between">
        <h1 style="font-family: Sigmar;font-weight: 800;color: #555;width: 40%;">BỘ SƯU TẬP MỚI NHẤT</h1>
        <form action="" method="get" class="d-flex flex-row-reverse w-50 g-10" role="search">
            <select class="form-select w-15" name="lsp" id="lsp">
              <option disabled {{ request('lsp') ? '' : 'selected' }}>Lọc theo loại</option>
              <option value="0">Xem tất cả</option>
              @foreach($listLSP as $lsp)
              <option value="{{ $lsp->getId() }}" {{ request('lsp') == $lsp->getId() ? 'selected' : '' }}>{{$lsp->gettenLSP()}}</option>
              @endforeach
            </select>
            <select class="form-select w-15" name="hang" id="hang">
              <option disabled {{ request('hang') ? '' : 'selected' }}>Lọc theo hãng</option>
              <option value="0">Xem tất cả</option>
              @foreach($listHang as $h)
              <option value="{{ $h->getId() }}" {{ request('hang') == $h->getId() ? 'selected' : '' }}>{{$h->gettenHang()}}</option>
              @endforeach
            </select>
          </form>
      </div>

      <div class="content-prd " style="margin: 0 5% 0;display: flex;">
        <div class="container-filter my-5" style="width: 0%;opacity: 0;height: 0;transition: all .4s ease;">
          <div class="ft-mau-sac">
            <h3>Màu sắc</h3>
            <ul class="list-checkBox">
              <li><input type="checkbox">Cam</li>
              <li><input type="checkbox">Đỏ</li>
              <li><input type="checkbox">Vàng</li>
              <li><input type="checkbox">Đen</li>
              <li><input type="checkbox">Xám</li>
              <li><input type="checkbox">Trắng</li>
              <li><input type="checkbox">Lục</li>
              <li><input type="checkbox">Lam</li>
              <li><input type="checkbox">Tím</li>
              <li><input type="checkbox">Hồng</li>
              <li><input type="checkbox">Cam</li>
              <li><input type="checkbox">Đỏ</li>
              <li><input type="checkbox">Vàng</li>
              <li><input type="checkbox">Đen</li>
              <li><input type="checkbox">Xám</li>
              <li><input type="checkbox">Trắng</li>
              <li><input type="checkbox">Lục</li>
              <li><input type="checkbox">Lam</li>
              <li><input type="checkbox">Tím</li>
              <li><input type="checkbox">Hồng</li>
            </ul>
            <span id="ft-mausac-xemthem">Xem thêm</span>
          </div>
          <div class="ft-chat-lieu">
            <h3>Chất liệu</h3>
            <ul class="list-checkBox">
              <li><input type="checkbox">Atetace</li>
              <li><input type="checkbox">Nhựa</li>
              <li><input type="checkbox">Nhựa Dẻo</li>
              <li><input type="checkbox">Nhựa Pha Kim Loại</li>
              <li><input type="checkbox">Kim loại</li>
              <li><input type="checkbox">Titan</li>

            </ul>
          </div>
          <div class="ft-hinh-dang">
            <h3>Hình dáng</h3>
            <ul class="list-checkBox">
              <li><input type="checkbox">Mắt mèo</li>
              <li><input type="checkbox">Hình tròn</li>
              <li><input type="checkbox">Hình vuông</li>
              <li><input type="checkbox">Hình tròn</li>
              <li><input type="checkbox">Hình Oval</li>
              <li><input type="checkbox">Đa giác</li>
              <li><input type="checkbox">Chữ nhật</li>

            </ul>
          </div>
        </div>
        <div class="dmsp w-100">
          <div class="container-rows" style="width: 100%;display: block;" id="product-list">
          @if(empty($listSP))
            <div class="row row-cols-1 row-cols-sm-2 row-cols-md-4 g-4 my-5 w-100">
              <h3 class="text-center text-gray w-100">Không có sản phẩm cần tìm</h3>
            </div>
          @else
            @php $count = 0; @endphp
            <div class="row row-cols-1 row-cols-sm-2 row-cols-md-4 g-4 my-5 w-100">
              @foreach($listSP as $sp)
                @if($count++ >= 8) @break @endif
                <div class="col rounded-5 product"
                    data-tensp="{{ $sp->getTenSanPham() }}"
                    data-hang="{{ $sp->getIdHang()->getTenHang() }}"
                    data-lsp="{{ $sp->getIdLSP()->getTenLSP() }}"
                    data-soluong="{{ $sp->getSoLuong() }}"
                    data-mota="{{ $sp->getMoTa() }}"
                    data-dongia="{{ $sp->getDonGia() }}"
                    data-thbg="{{ $sp->getThoiGianBaoHanh() }}"
                    data-img="productImg/{{ $sp->getId() }}.webp"
                    data-bs-toggle="modal"
                    data-bs-target="#productDetailModal"
                >
                  <div class="card shadow-sm border-0 h-100 col rounded-5 product-item">
                    <div class="ratio ratio-1x1">
                      <img src="productImg/{{ $sp->getId() }}.webp" class="card-img-top object-fit-cover rounded-top-5" alt="Ảnh sản phẩm">
                    </div>
                    <div class=" card-body d-flex flex-column justify-content-between h-60 p-3">
                      <h6 class="card-title text-truncate text-center w-100" title="{{ $sp->getTenSanPham() }}">{{ $sp->getTenSanPham() }}</h6>
                      <div class="d-flex align-items-center justify-content-between mt-auto rounded-4 bg-blue-500">
                        <span class="fw-bold text-primary fs-5 text-center w-100 text-white rounded-4 flex justify-center p-2" style="background-color: #55d5d2;height: 50px;">
                          {{ number_format($sp->getDonGia(), 0, ',', '.') }}₫
                        </span>
                        <i class="fa-solid fa-arrow-up-right text-success"></i>
                      </div>
                    </div>
                  </div>
                </div>
            @endforeach
          @endif
          </div>
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

    </div>
  </div>
  <div class="container-custom">
    <a><i class="fa-solid fa-shield-check fa-beat"></i>
      <p>Bảo hành trọn đời</p>
    </a>
    <a><i class="fa-solid fa-flower-daffodil fa-beat"></i>
      <p>Đo mắt miễn phí</p>
    </a>
    <a><i class="fa-solid fa-rotate fa-spin"></i>
      <p>Thu cũ đổi mới</p>
    </a>
    <a><i class="fa-solid fa-spray-can-sparkles fa-shake"></i>
      <p>Vệ sinh & Bảo quản</p>
    </a>
  </div>
  <div class="d-flex " style="padding: 0 5%;">
    <div style="width: 40%;"><img src="client/img/traidep.png" alt="" class="img-fluid w-100"></div>
    <div style="padding-left: 50px;width: 60%;">
      <h2 style="padding: 30px;background-color: #e4f4f4;border-top-left-radius: 30px;border-top-right-radius: 30px;border-bottom-right-radius: 30px;color: #55d5d2;font-weight: 800;">CHỌN KÍNH PHÙ HỢP VỚI BẠN</h2>
      <div class="choiceglasses" >
        <a href="#">
          <h3>CHỌN KÍNH THEO KHUÔN MẶT</h3>
          <p style="margin: 0;width: 60%;">Lựa chọn kính theo hình dáng khuôn mặt và sở thích cá nhân của bạn</p>
        </a>
        <div style="display: block; text-align: center;font-size: 50px;transform: translateX(-100px);color: #413f3f;"><i class="fa-solid fa-arrow-right" style="transition: transform 0.5s ease;"></i></div>
      </div>
      <div class="choiceglasses" >
        <a href="#">
          <h3>CHỌN KÍNH THEO PHONG CÁCH</h3>
          <p style="margin: 0;width: 60%;">Lựa chọn kính theo hình dáng khuôn mặt và sở thích cá nhân của bạn</p>
        </a>
        <div style="display: block; text-align: center;font-size: 50px;transform: translateX(-100px);color: #413f3f;"><i class="fa-solid fa-arrow-right" style="transition: transform 0.5s ease;"></i></div>
      </div><div class="choiceglasses" >
        <a href="#">
          <h3>CHỌN KÍNH THEO CÔNG VIỆC</h3>
          <p style="margin: 0;width: 60%;">Lựa chọn kính theo hình dáng khuôn mặt và sở thích cá nhân của bạn</p>
        </a>
        <div style="display: block; text-align: center;font-size: 50px;transform: translateX(-100px);color: #413f3f;"><i class="fa-solid fa-arrow-right" style="transition: transform 0.5s ease;"></i></div>
      </div><div class="choiceglasses" >
        <a href="#">
          <h3>CHỌN KÍNH THEO SỞ THÍCH</h3>
          <p style="margin: 0;width: 60%;">Lựa chọn kính theo hình dáng khuôn mặt và sở thích cá nhân của bạn</p>
        </a>
        <div style="display: block; text-align: center;font-size: 50px;transform: translateX(-100px);color: #413f3f;"><i class="fa-solid fa-arrow-right" style="transition: transform 0.5s ease;"></i></div>
      </div>
    </div>

  </div>
  <!-- Footer -->
  <footer>
    <div class="footer-container d-flex">
      <div class="footer-left">
        <div class="logo">
          <img src="client/img/logo.svg" alt="Anna Logo">
        </div>
        <div class="newsletter">
          <p>Đăng kí để nhận tin mới nhất</p>
          <div class="email-input">
            <input type="email" placeholder="Để lại email của bạn" style="font-size:20px;padding: 5px; border-radius:20px;width:50%;">
            <button>></button>
          </div>
        </div>
        <div class="social-icons">
          <a href="#"><i class="fa-brands fa-facebook-f"></i></a>
          <a href="#"><i class="fa-brands fa-instagram"></i></a>
          <a href="#"><i class="fa-brands fa-tiktok"></i></a>
          <a href="#"><i class="fa-brands fa-youtube"></i></a>
        </div>
      </div>
      <div class="footer-center">
        <div class="product-info">
          <label for="">Sản phẩm</label>
          <ul>
            <li><a href="#">The Titan</a></li>
            <li><a href="#">Gọng Kính</a></li>
            <li><a href="#">Tròng Kính</a></li>
            <li><a href="#">Kính râm</a></li>
            <li><a href="#">Kính râm trẻ em</a></li>
          </ul>
        </div>
        <div class="purchase-policy">
          <label for="">Chính sách mua hàng</label>
          <ul>
            <li><a href="#">Hình thức thanh toán</a></li>
            <li><a href="#">Chính sách giao hàng</a></li>
            <li><a href="#">Chính sách bảo hành</a></li>
          </ul>
        </div>
      </div>
      <div class="footer-right">
        <div class="contact-info">
          <label for="" style="font-size: 22px;color:#e6f4f3;">Thông tin liên hệ</label>
          <p>19000359</p>
          <p>marketing@kinhmatanna.com</p>
        </div>
        <div class="business-info">
          <p>MST: 0108195925</p>

        </div>
      </div>
    </div>
    <div class="copyright">
      <p style="margin: 0;">Anna 2018-2023. Design by OKHUB Viet Nam</p>
    </div>
  </footer>

  <!-- modal chi tiết sản phẩm -->
  <div class="modal fade" id="productDetailModal" tabindex="-1" aria-labelledby="userModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg"> <!-- modal-lg để modal to hơn -->
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="userModalLabel">Thông tin sản phẩm</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body d-flex flex-column mb-3">
        <div class="p-3 d-flex flex-row" style="height: 80%; background-color: #55d5d2;">
          <div class="" style="width: 30%; background-color: blue;">
          <div class="ratio ratio-1x1">
            <img name="img" src="" alt="Product Image" />
          </div>
          </div>
          <div class="" style="width: 70%;background-color: coral;">xeyo</div>
        </div>
        <div class="p-5" style="height: 20%; background-color: aquamarine;">BYE</div>
      </div>
      
    </div>
  </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>