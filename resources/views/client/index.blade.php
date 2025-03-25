<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="../../css/client/HomePageClient.css">
  <link rel="stylesheet" href="../../css/client/include/navbar.css">
  <link rel="stylesheet" href="../../css/client/include/footer.css">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
  <title>Document</title>
  <link rel="stylesheet" href="https://site-assets.fontawesome.com/releases/v6.7.2/css/all.css">
</head>

<body>
  <header>
    <div class="text-white" id="navbar-ctn">
      <div class="top-nav">
        <p style="color: #55d5d2; font-size: 14px; font-weight: 600;">GIẢM GIÁ NGAY 15% CHO ĐƠN ĐẦU TIÊN</p>
        <ul class="list-top-nav d-flex ms-auto gap-2">
          <li class="nav-item px-3 py-1 bg-secondary text-white fw-medium rounded-pill " id="chinhsach"><a href="">Chính sách</a></li>
          <li class="nav-item px-3 py-1 bg-secondary text-white fw-medium rounded-pill" id="tracuudonhang"><a href="">Tra cứu đơn hàng</a></li>
          <li class="nav-item px-3 py-1 bg-secondary text-white fw-medium rounded-pill" id="taikhoan"><a href="../../views/client/Login-Register.blade.php">Tài khoản</a></li>
        </ul>
      </div>
      <div class="navbar text-white navbar-expand" id="navbar">
        <a href="" class="navbar-brand">Logo</a>
        <ul class="navbar-nav gap-5">
          <li class="nav-item fw-medium my-2 mx-2" id="item-sanpham"><a href="" class="nav-link text-white">Sản Phẩm <i class="fa-regular fa-angle-up"></i></a></li>
          <li class="nav-item fw-medium d-flex"><a href="#" class="nav-link text-white">Tìm Cửa Hàng<i class="fa-regular fa-location-dot fa-bounce"></i></a> </li>
          <li class="nav-item fw-medium" style="position: relative;"><input class="rounded-pill py-2" type="text" placeholder="Tìm kiếm sản phẩm" style="width: 300px;outline: none;border:none;padding: 0 30px 0 10px;"><i class="fa-solid fa-magnifying-glass" style="position: absolute; right: 10px; color: #555;"></i></li>
          <li class="nav-item fw-medium my-2" id="item-xemthem"><a href="" class="nav-link text-white">Xem Thêm <i class="fa-regular fa-angle-up"></i></a></li>
          <li class="nav-item fw-medium"><a href="#" class="nav-link text-white">Hành Trình Tử Tế</a></li>
          <li class="nav-item fw-medium my-2"><a href="#" class="nav-link text-white">Giỏ Hàng <i class="fa-light fa-bag-shopping"></i></a></li>
        </ul>
      </div>
    </div>
  </header>
  <div class="submenu card" style="z-index: 100;">
    <div class="card-menu d-flex ">

    </div>

  </div>
  <div class="ctn-content">
    <img src="./img/bannner.png" class="img-fluid w-100">

    <div class="main justify-content-center d-flex">
      <div class="best-seller text-center">
        <h1 class="text-start" style="width: fit-content; ;padding: 15px 0 10px;color: #55d5d2; border-bottom: solid 5px #55d5d2;margin-right: auto; font-family: Roboto;">BÁN CHẠY NHẤT</h1>
        <div class="row my-5" style="max-height: 380px;display: flex;">
          <div class="col-3 item-product">
            <div class="img-product">
              <img src="./img/sanpham.jpeg" class="img-fluid w-100 " alt="">

            </div>
            <div class="info-product ">
              <div class="name-product">GK.M GỌNG NHỰA AN221393 (50.18.145)</div>
              <div class="price-product" style="position: relative;">350.000đ <i class="fa-solid fa-arrow-up-right icon-arrow"></i></div>
            </div>
            <div class="" style="height: 80px; width: 100%;"></div>
          </div>
          <div class="col-3 item-product">
            <div class="img-product">
              <img src="./img/sanpham.jpeg" class="img-fluid w-100" alt="">
            </div>
            <div class="info-product ">
              <div class="name-product">GK.M GỌNG NHỰA AN221393 (50.18.145)</div>
              <div class="price-product" style="position: relative;">350.000đ <i class="fa-solid fa-arrow-up-right icon-arrow"></i></div>
            </div>
            <div class="" style="height: 80px; width: 100%;"></div>
          </div>
          <div class="col-3 item-product">
            <div class="img-product">
              <img src="./img/sanpham.jpeg" class="img-fluid w-100" alt="">
            </div>
            <div class="info-product ">
              <div class="name-product">GK.M GỌNG NHỰA AN221393 (50.18.145)</div>
              <div class="price-product" style="position: relative;">350.000đ <i class="fa-solid fa-arrow-up-right icon-arrow"></i></div>
            </div>
            <div class="" style="height: 80px; width: 100%;"></div>
          </div>
          <div class="col-3 item-product">
            <div class="img-product">
              <img src="./img/sanpham.jpeg" class="img-fluid w-100" alt="">
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
      <div class="bnsm"><img src="./img/small-banner1.png" class="img-fluid w-100"></div>
      <div class="bnsm"><img src="./img/small-banner2.png" class="img-fluid w-100"></div>
    </div>
    <div class="ctn-danhmucsanpham" style="background-color: #f6f2f2;padding-bottom: 30px;">
      <div class="type-product-items">
        <h1 style="font-family: Sigmar;font-weight: 800;color: #555;width: 40%;">BỘ SƯU TẬP MỚI NHẤT</h1>
        <ul class="type-product-items-ul" style="display: flex;margin: 0;padding: 0;width: 60%;justify-content: space-between; align-items: center;">
          <li><i class="fa-solid fa-arrow-right fa-shake" style="opacity: 0;visibility: hidden;color: #fb923c;margin-right: 3px;"></i>GỌNG KÍNH</li>
          <li><i class="fa-solid fa-arrow-right fa-shake" style="opacity: 0;visibility: hidden;color: #fb923c;margin-right: 3px;"></i>TRÒNG KÍNH</li>
          <li><i class="fa-solid fa-arrow-right fa-shake" style="opacity: 0;visibility: hidden;color: #fb923c;margin-right: 3px;"></i>KÍNH RÂM</li>
          <li><i class="fa-solid fa-arrow-right fa-shake" style="opacity: 0;visibility: hidden;color: #fb923c;margin-right: 3px;"></i>KÍNH ÁP TRÒNG</li>
          <li><i class="fa-solid fa-arrow-right fa-shake" style="opacity: 0;visibility: hidden;color: #fb923c;margin-right: 3px;"></i>XEM TẤT CẢ</li>
        </ul>
      </div>
      <div class="filter">
        <button id="filter-btn">Open Filter</button>
        <div id="filter-options" style="">
          <select id="sort-by">
            <option value="">Sort By</option>
            <option value="price-desc">Giá Cao - Thấp</option>
            <option value="price-asc">Giá Thấp - Cao</option>
            <option value="noibat">Nổi Bật</option>
          </select>
        </div>
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
        <div class="dmsp">
          <div class="container-rows" style="width: 100%;display: block;" id="product-list">
            <div class="row my-5 d-flex ">
              <div class="col-3 item-product">
                <div class="img-product">
                  <img src="./img/sanpham.jpeg" class="img-fluid w-100 " alt="">
                </div>
                <div class="info-product ">
                  <div class="name-product">GK.M GỌNG NHỰA AN221393 (50.18.145)</div>
                  <div class="price-product" style="position: relative;">350.000đ <i class="fa-solid fa-arrow-up-right icon-arrow"></i></div>
                </div>
                <div class="" style="height: 80px; width: 100%;"></div>
              </div>
              <div class="col-3 item-product">
                <div class="img-product">
                  <img src="./img/sanpham.jpeg" class="img-fluid w-100" alt="">
                </div>
                <div class="info-product ">
                  <div class="name-product">GK.M GỌNG NHỰA AN221393 (50.18.145)</div>
                  <div class="price-product" style="position: relative;">350.000đ <i class="fa-solid fa-arrow-up-right icon-arrow"></i></div>
                </div>
                <div class="" style="height: 80px; width: 100%;"></div>
              </div>
              <div class="col-3 item-product">
                <div class="img-product">
                  <img src="./img/sanpham.jpeg" class="img-fluid w-100" alt="">
                </div>
                <div class="info-product ">
                  <div class="name-product">GK.M GỌNG NHỰA AN221393 (50.18.145)</div>
                  <div class="price-product" style="position: relative;">350.000đ <i class="fa-solid fa-arrow-up-right icon-arrow"></i></div>
                </div>
                <div class="" style="height: 80px; width: 100%;"></div>
              </div>
              <div class="col-3 item-product">
                <div class="img-product">
                  <img src="./img/sanpham.jpeg" class="img-fluid w-100" alt="">
                </div>
                <div class="info-product ">
                  <div class="name-product">GK.M GỌNG NHỰA AN221393 (50.18.145)</div>
                  <div class="price-product" style="position: relative;">350.000đ <i class="fa-solid fa-arrow-up-right icon-arrow"></i></div>
                </div>
                <div class="" style="height: 80px; width: 100%;"></div>
              </div>
            </div>
            <div class="row my-5 d-flex ">
              <div class="col-3 item-product">
                <div class="img-product">
                  <img src="./img/sanpham.jpeg" class="img-fluid w-100 " alt="">
                </div>
                <div class="info-product ">
                  <div class="name-product">GK.M GỌNG NHỰA AN221393 (50.18.145)</div>
                  <div class="price-product" style="position: relative;">350.000đ <i class="fa-solid fa-arrow-up-right icon-arrow"></i></div>
                </div>
                <div class="" style="height: 80px; width: 100%;"></div>
              </div>
              <div class="col-3 item-product">
                <div class="img-product">
                  <img src="./img/sanpham.jpeg" class="img-fluid w-100" alt="">
                </div>
                <div class="info-product ">
                  <div class="name-product">GK.M GỌNG NHỰA AN221393 (50.18.145)</div>
                  <div class="price-product" style="position: relative;">350.000đ <i class="fa-solid fa-arrow-up-right icon-arrow"></i></div>
                </div>
                <div class="" style="height: 80px; width: 100%;"></div>
              </div>
              <div class="col-3 item-product">
                <div class="img-product">
                  <img src="./img/sanpham.jpeg" class="img-fluid w-100" alt="">
                </div>
                <div class="info-product ">
                  <div class="name-product">GK.M GỌNG NHỰA AN221393 (50.18.145)</div>
                  <div class="price-product" style="position: relative;">350.000đ <i class="fa-solid fa-arrow-up-right icon-arrow"></i></div>
                </div>
                <div class="" style="height: 80px; width: 100%;"></div>
              </div>
              <div class="col-3 item-product">
                <div class="img-product">
                  <img src="./img/sanpham.jpeg" class="img-fluid w-100" alt="">
                </div>
                <div class="info-product ">
                  <div class="name-product">GK.M GỌNG NHỰA AN221393 (50.18.145)</div>
                  <div class="price-product" style="position: relative;">350.000đ <i class="fa-solid fa-arrow-up-right icon-arrow"></i></div>
                </div>
                <div class="" style="height: 80px; width: 100%;"></div>
              </div>
            </div>
            <div class="row my-5 d-flex ">
              <div class="col-3 item-product">
                <div class="img-product">
                  <img src="./img/sanpham.jpeg" class="img-fluid w-100 " alt="">
                </div>
                <div class="info-product ">
                  <div class="name-product">GK.M GỌNG NHỰA AN221393 (50.18.145)</div>
                  <div class="price-product" style="position: relative;">350.000đ <i class="fa-solid fa-arrow-up-right icon-arrow"></i></div>
                </div>
                <div class="" style="height: 80px; width: 100%;"></div>
              </div>
              <div class="col-3 item-product">
                <div class="img-product">
                  <img src="./img/sanpham.jpeg" class="img-fluid w-100" alt="">
                </div>
                <div class="info-product ">
                  <div class="name-product">GK.M GỌNG NHỰA AN221393 (50.18.145)</div>
                  <div class="price-product" style="position: relative;">350.000đ <i class="fa-solid fa-arrow-up-right icon-arrow"></i></div>
                </div>
                <div class="" style="height: 80px; width: 100%;"></div>
              </div>
              <div class="col-3 item-product">
                <div class="img-product">
                  <img src="./img/sanpham.jpeg" class="img-fluid w-100" alt="">
                </div>
                <div class="info-product ">
                  <div class="name-product">GK.M GỌNG NHỰA AN221393 (50.18.145)</div>
                  <div class="price-product" style="position: relative;">350.000đ <i class="fa-solid fa-arrow-up-right icon-arrow"></i></div>
                </div>
                <div class="" style="height: 80px; width: 100%;"></div>
              </div>
              <div class="col-3 item-product">
                <div class="img-product">
                  <img src="./img/sanpham.jpeg" class="img-fluid w-100" alt="">
                </div>
                <div class="info-product ">
                  <div class="name-product">GK.M GỌNG NHỰA AN221393 (50.18.145)</div>
                  <div class="price-product" style="position: relative;">350.000đ <i class="fa-solid fa-arrow-up-right icon-arrow"></i></div>
                </div>
                <div class="" style="height: 80px; width: 100%;"></div>
              </div>
            </div>
            <div class="row my-5 d-flex ">
              <div class="col-3 item-product">
                <div class="img-product">
                  <img src="./img/sanpham.jpeg" class="img-fluid w-100 " alt="">
                </div>
                <div class="info-product ">
                  <div class="name-product">GK.M GỌNG NHỰA AN221393 (50.18.145)</div>
                  <div class="price-product" style="position: relative;">350.000đ <i class="fa-solid fa-arrow-up-right icon-arrow"></i></div>
                </div>
                <div class="" style="height: 80px; width: 100%;"></div>
              </div>
              <div class="col-3 item-product">
                <div class="img-product">
                  <img src="./img/sanpham.jpeg" class="img-fluid w-100" alt="">
                </div>
                <div class="info-product ">
                  <div class="name-product">GK.M GỌNG NHỰA AN221393 (50.18.145)</div>
                  <div class="price-product" style="position: relative;">350.000đ <i class="fa-solid fa-arrow-up-right icon-arrow"></i></div>
                </div>
                <div class="" style="height: 80px; width: 100%;"></div>
              </div>
              <div class="col-3 item-product">
                <div class="img-product">
                  <img src="./img/sanpham.jpeg" class="img-fluid w-100" alt="">
                </div>
                <div class="info-product ">
                  <div class="name-product">GK.M GỌNG NHỰA AN221393 (50.18.145)</div>
                  <div class="price-product" style="position: relative;">350.000đ <i class="fa-solid fa-arrow-up-right icon-arrow"></i></div>
                </div>
                <div class="" style="height: 80px; width: 100%;"></div>
              </div>
              <div class="col-3 item-product">
                <div class="img-product">
                  <img src="./img/sanpham.jpeg" class="img-fluid w-100" alt="">
                </div>
                <div class="info-product ">
                  <div class="name-product">GK.M GỌNG NHỰA AN221393 (50.18.145)</div>
                  <div class="price-product" style="position: relative;">350.000đ <i class="fa-solid fa-arrow-up-right icon-arrow"></i></div>
                </div>
                <div class="" style="height: 80px; width: 100%;"></div>
              </div>
            </div>
            <div class="row my-5 d-flex ">
              <div class="col-3 item-product">
                <div class="img-product">
                  <img src="./img/sanpham.jpeg" class="img-fluid w-100 " alt="">
                </div>
                <div class="info-product ">
                  <div class="name-product">GK.M GỌNG NHỰA AN221393 (50.18.145)</div>
                  <div class="price-product" style="position: relative;">350.000đ <i class="fa-solid fa-arrow-up-right icon-arrow"></i></div>
                </div>
                <div class="" style="height: 80px; width: 100%;"></div>
              </div>
              <div class="col-3 item-product">
                <div class="img-product">
                  <img src="./img/sanpham.jpeg" class="img-fluid w-100" alt="">
                </div>
                <div class="info-product ">
                  <div class="name-product">GK.M GỌNG NHỰA AN221393 (50.18.145)</div>
                  <div class="price-product" style="position: relative;">350.000đ <i class="fa-solid fa-arrow-up-right icon-arrow"></i></div>
                </div>
                <div class="" style="height: 80px; width: 100%;"></div>
              </div>
              <div class="col-3 item-product">
                <div class="img-product">
                  <img src="./img/sanpham.jpeg" class="img-fluid w-100" alt="">
                </div>
                <div class="info-product ">
                  <div class="name-product">GK.M GỌNG NHỰA AN221393 (50.18.145)</div>
                  <div class="price-product" style="position: relative;">350.000đ <i class="fa-solid fa-arrow-up-right icon-arrow"></i></div>
                </div>
                <div class="" style="height: 80px; width: 100%;"></div>
              </div>
              <div class="col-3 item-product">
                <div class="img-product">
                  <img src="./img/sanpham.jpeg" class="img-fluid w-100" alt="">
                </div>
                <div class="info-product ">
                  <div class="name-product">GK.M GỌNG NHỰA AN221393 (50.18.145)</div>
                  <div class="price-product" style="position: relative;">350.000đ <i class="fa-solid fa-arrow-up-right icon-arrow"></i></div>
                </div>
                <div class="" style="height: 80px; width: 100%;"></div>
              </div>
            </div>
            <div class="row my-5 d-flex ">
              <div class="col-3 item-product">
                <div class="img-product">
                  <img src="./img/sanpham.jpeg" class="img-fluid w-100 " alt="">
                </div>
                <div class="info-product ">
                  <div class="name-product">GK.M GỌNG NHỰA AN221393 (50.18.145)</div>
                  <div class="price-product" style="position: relative;">350.000đ <i class="fa-solid fa-arrow-up-right icon-arrow"></i></div>
                </div>
                <div class="" style="height: 80px; width: 100%;"></div>
              </div>
              <div class="col-3 item-product">
                <div class="img-product">
                  <img src="./img/sanpham.jpeg" class="img-fluid w-100" alt="">
                </div>
                <div class="info-product ">
                  <div class="name-product">GK.M GỌNG NHỰA AN221393 (50.18.145)</div>
                  <div class="price-product" style="position: relative;">350.000đ <i class="fa-solid fa-arrow-up-right icon-arrow"></i></div>
                </div>
                <div class="" style="height: 80px; width: 100%;"></div>
              </div>
              <div class="col-3 item-product">
                <div class="img-product">
                  <img src="./img/sanpham.jpeg" class="img-fluid w-100" alt="">
                </div>
                <div class="info-product ">
                  <div class="name-product">GK.M GỌNG NHỰA AN221393 (50.18.145)</div>
                  <div class="price-product" style="position: relative;">350.000đ <i class="fa-solid fa-arrow-up-right icon-arrow"></i></div>
                </div>
                <div class="" style="height: 80px; width: 100%;"></div>
              </div>
              <div class="col-3 item-product">
                <div class="img-product">
                  <img src="./img/sanpham.jpeg" class="img-fluid w-100" alt="">
                </div>
                <div class="info-product ">
                  <div class="name-product">GK.M GỌNG NHỰA AN221393 (50.18.145)</div>
                  <div class="price-product" style="position: relative;">350.000đ <i class="fa-solid fa-arrow-up-right icon-arrow"></i></div>
                </div>
                <div class="" style="height: 80px; width: 100%;"></div>
              </div>
            </div>
            <div class="row my-5 d-flex ">
              <div class="col-3 item-product">
                <div class="img-product">
                  <img src="./img/sanpham.jpeg" class="img-fluid w-100 " alt="">
                </div>
                <div class="info-product ">
                  <div class="name-product">GK.M GỌNG NHỰA AN221393 (50.18.145)</div>
                  <div class="price-product" style="position: relative;">350.000đ <i class="fa-solid fa-arrow-up-right icon-arrow"></i></div>
                </div>
                <div class="" style="height: 80px; width: 100%;"></div>
              </div>
              <div class="col-3 item-product">
                <div class="img-product">
                  <img src="./img/sanpham.jpeg" class="img-fluid w-100" alt="">
                </div>
                <div class="info-product ">
                  <div class="name-product">GK.M GỌNG NHỰA AN221393 (50.18.145)</div>
                  <div class="price-product" style="position: relative;">350.000đ <i class="fa-solid fa-arrow-up-right icon-arrow"></i></div>
                </div>
                <div class="" style="height: 80px; width: 100%;"></div>
              </div>
              <div class="col-3 item-product">
                <div class="img-product">
                  <img src="./img/sanpham.jpeg" class="img-fluid w-100" alt="">
                </div>
                <div class="info-product ">
                  <div class="name-product">GK.M GỌNG NHỰA AN221393 (50.18.145)</div>
                  <div class="price-product" style="position: relative;">350.000đ <i class="fa-solid fa-arrow-up-right icon-arrow"></i></div>
                </div>
                <div class="" style="height: 80px; width: 100%;"></div>
              </div>
              <div class="col-3 item-product">
                <div class="img-product">
                  <img src="./img/sanpham.jpeg" class="img-fluid w-100" alt="">
                </div>
                <div class="info-product ">
                  <div class="name-product">GK.M GỌNG NHỰA AN221393 (50.18.145)</div>
                  <div class="price-product" style="position: relative;">350.000đ <i class="fa-solid fa-arrow-up-right icon-arrow"></i></div>
                </div>
                <div class="" style="height: 80px; width: 100%;"></div>
              </div>
            </div>
            <div class="row my-5 d-flex ">
              <div class="col-3 item-product">
                <div class="img-product">
                  <img src="./img/sanpham.jpeg" class="img-fluid w-100 " alt="">
                </div>
                <div class="info-product ">
                  <div class="name-product">GK.M GỌNG NHỰA AN221393 (50.18.145)</div>
                  <div class="price-product" style="position: relative;">350.000đ <i class="fa-solid fa-arrow-up-right icon-arrow"></i></div>
                </div>
                <div class="" style="height: 80px; width: 100%;"></div>
              </div>
              <div class="col-3 item-product">
                <div class="img-product">
                  <img src="./img/sanpham.jpeg" class="img-fluid w-100" alt="">
                </div>
                <div class="info-product ">
                  <div class="name-product">GK.M GỌNG NHỰA AN221393 (50.18.145)</div>
                  <div class="price-product" style="position: relative;">350.000đ <i class="fa-solid fa-arrow-up-right icon-arrow"></i></div>
                </div>
                <div class="" style="height: 80px; width: 100%;"></div>
              </div>
              <div class="col-3 item-product">
                <div class="img-product">
                  <img src="./img/sanpham.jpeg" class="img-fluid w-100" alt="">
                </div>
                <div class="info-product ">
                  <div class="name-product">GK.M GỌNG NHỰA AN221393 (50.18.145)</div>
                  <div class="price-product" style="position: relative;">350.000đ <i class="fa-solid fa-arrow-up-right icon-arrow"></i></div>
                </div>
                <div class="" style="height: 80px; width: 100%;"></div>
              </div>
              <div class="col-3 item-product">
                <div class="img-product">
                  <img src="./img/sanpham.jpeg" class="img-fluid w-100" alt="">
                </div>
                <div class="info-product ">
                  <div class="name-product">GK.M GỌNG NHỰA AN221393 (50.18.145)</div>
                  <div class="price-product" style="position: relative;">350.000đ <i class="fa-solid fa-arrow-up-right icon-arrow"></i></div>
                </div>
                <div class="" style="height: 80px; width: 100%;"></div>
              </div>
            </div>
            <div class="row my-5 d-flex ">
              <div class="col-3 item-product">
                <div class="img-product">
                  <img src="./img/sanpham.jpeg" class="img-fluid w-100 " alt="">
                </div>
                <div class="info-product ">
                  <div class="name-product">GK.M GỌNG NHỰA AN221393 (50.18.145)</div>
                  <div class="price-product" style="position: relative;">350.000đ <i class="fa-solid fa-arrow-up-right icon-arrow"></i></div>
                </div>
                <div class="" style="height: 80px; width: 100%;"></div>
              </div>
              <div class="col-3 item-product">
                <div class="img-product">
                  <img src="./img/sanpham.jpeg" class="img-fluid w-100" alt="">
                </div>
                <div class="info-product ">
                  <div class="name-product">GK.M GỌNG NHỰA AN221393 (50.18.145)</div>
                  <div class="price-product" style="position: relative;">350.000đ <i class="fa-solid fa-arrow-up-right icon-arrow"></i></div>
                </div>
                <div class="" style="height: 80px; width: 100%;"></div>
              </div>
              <div class="col-3 item-product">
                <div class="img-product">
                  <img src="./img/sanpham.jpeg" class="img-fluid w-100" alt="">
                </div>
                <div class="info-product ">
                  <div class="name-product">GK.M GỌNG NHỰA AN221393 (50.18.145)</div>
                  <div class="price-product" style="position: relative;">350.000đ <i class="fa-solid fa-arrow-up-right icon-arrow"></i></div>
                </div>
                <div class="" style="height: 80px; width: 100%;"></div>
              </div>
              <div class="col-3 item-product">
                <div class="img-product">
                  <img src="./img/sanpham.jpeg" class="img-fluid w-100" alt="">
                </div>
                <div class="info-product ">
                  <div class="name-product">GK.M GỌNG NHỰA AN221393 (50.18.145)</div>
                  <div class="price-product" style="position: relative;">350.000đ <i class="fa-solid fa-arrow-up-right icon-arrow"></i></div>
                </div>
                <div class="" style="height: 80px; width: 100%;"></div>
              </div>
            </div>
            <div class="row my-5 d-flex ">
              <div class="col-3 item-product">
                <div class="img-product">
                  <img src="./img/sanpham.jpeg" class="img-fluid w-100 " alt="">
                </div>
                <div class="info-product ">
                  <div class="name-product">GK.M GỌNG NHỰA AN221393 (50.18.145)</div>
                  <div class="price-product" style="position: relative;">350.000đ <i class="fa-solid fa-arrow-up-right icon-arrow"></i></div>
                </div>
                <div class="" style="height: 80px; width: 100%;"></div>
              </div>
              <div class="col-3 item-product">
                <div class="img-product">
                  <img src="./img/sanpham.jpeg" class="img-fluid w-100" alt="">
                </div>
                <div class="info-product ">
                  <div class="name-product">GK.M GỌNG NHỰA AN221393 (50.18.145)</div>
                  <div class="price-product" style="position: relative;">350.000đ <i class="fa-solid fa-arrow-up-right icon-arrow"></i></div>
                </div>
                <div class="" style="height: 80px; width: 100%;"></div>
              </div>
              <div class="col-3 item-product">
                <div class="img-product">
                  <img src="./img/sanpham.jpeg" class="img-fluid w-100" alt="">
                </div>
                <div class="info-product ">
                  <div class="name-product">GK.M GỌNG NHỰA AN221393 (50.18.145)</div>
                  <div class="price-product" style="position: relative;">350.000đ <i class="fa-solid fa-arrow-up-right icon-arrow"></i></div>
                </div>
                <div class="" style="height: 80px; width: 100%;"></div>
              </div>
              <div class="col-3 item-product">
                <div class="img-product">
                  <img src="./img/sanpham.jpeg" class="img-fluid w-100" alt="">
                </div>
                <div class="info-product ">
                  <div class="name-product">GK.M GỌNG NHỰA AN221393 (50.18.145)</div>
                  <div class="price-product" style="position: relative;">350.000đ <i class="fa-solid fa-arrow-up-right icon-arrow"></i></div>
                </div>
                <div class="" style="height: 80px; width: 100%;"></div>
              </div>
            </div>
            <div class="row my-5 d-flex ">
              <div class="col-3 item-product">
                <div class="img-product">
                  <img src="./img/sanpham.jpeg" class="img-fluid w-100 " alt="">
                </div>
                <div class="info-product ">
                  <div class="name-product">GK.M GỌNG NHỰA AN221393 (50.18.145)</div>
                  <div class="price-product" style="position: relative;">350.000đ <i class="fa-solid fa-arrow-up-right icon-arrow"></i></div>
                </div>
                <div class="" style="height: 80px; width: 100%;"></div>
              </div>
              <div class="col-3 item-product">
                <div class="img-product">
                  <img src="./img/sanpham.jpeg" class="img-fluid w-100" alt="">
                </div>
                <div class="info-product ">
                  <div class="name-product">GK.M GỌNG NHỰA AN221393 (50.18.145)</div>
                  <div class="price-product" style="position: relative;">350.000đ <i class="fa-solid fa-arrow-up-right icon-arrow"></i></div>
                </div>
                <div class="" style="height: 80px; width: 100%;"></div>
              </div>
              <div class="col-3 item-product">
                <div class="img-product">
                  <img src="./img/sanpham.jpeg" class="img-fluid w-100" alt="">
                </div>
                <div class="info-product ">
                  <div class="name-product">GK.M GỌNG NHỰA AN221393 (50.18.145)</div>
                  <div class="price-product" style="position: relative;">350.000đ <i class="fa-solid fa-arrow-up-right icon-arrow"></i></div>
                </div>
                <div class="" style="height: 80px; width: 100%;"></div>
              </div>
              <div class="col-3 item-product">
                <div class="img-product">
                  <img src="./img/sanpham.jpeg" class="img-fluid w-100" alt="">
                </div>
                <div class="info-product ">
                  <div class="name-product">GK.M GỌNG NHỰA AN221393 (50.18.145)</div>
                  <div class="price-product" style="position: relative;">350.000đ <i class="fa-solid fa-arrow-up-right icon-arrow"></i></div>
                </div>
                <div class="" style="height: 80px; width: 100%;"></div>
              </div>
            </div>
            <div class="row my-5 d-flex ">
              <div class="col-3 item-product">
                <div class="img-product">
                  <img src="./img/sanpham.jpeg" class="img-fluid w-100 " alt="">
                </div>
                <div class="info-product ">
                  <div class="name-product">GK.M GỌNG NHỰA AN221393 (50.18.145)</div>
                  <div class="price-product" style="position: relative;">350.000đ <i class="fa-solid fa-arrow-up-right icon-arrow"></i></div>
                </div>
                <div class="" style="height: 80px; width: 100%;"></div>
              </div>
              <div class="col-3 item-product">
                <div class="img-product">
                  <img src="./img/sanpham.jpeg" class="img-fluid w-100" alt="">
                </div>
                <div class="info-product ">
                  <div class="name-product">GK.M GỌNG NHỰA AN221393 (50.18.145)</div>
                  <div class="price-product" style="position: relative;">350.000đ <i class="fa-solid fa-arrow-up-right icon-arrow"></i></div>
                </div>
                <div class="" style="height: 80px; width: 100%;"></div>
              </div>
              <div class="col-3 item-product">
                <div class="img-product">
                  <img src="./img/sanpham.jpeg" class="img-fluid w-100" alt="">
                </div>
                <div class="info-product ">
                  <div class="name-product">GK.M GỌNG NHỰA AN221393 (50.18.145)</div>
                  <div class="price-product" style="position: relative;">350.000đ <i class="fa-solid fa-arrow-up-right icon-arrow"></i></div>
                </div>
                <div class="" style="height: 80px; width: 100%;"></div>
              </div>
              <div class="col-3 item-product">
                <div class="img-product">
                  <img src="./img/sanpham.jpeg" class="img-fluid w-100" alt="">
                </div>
                <div class="info-product ">
                  <div class="name-product">GK.M GỌNG NHỰA AN221393 (50.18.145)</div>
                  <div class="price-product" style="position: relative;">350.000đ <i class="fa-solid fa-arrow-up-right icon-arrow"></i></div>
                </div>
                <div class="" style="height: 80px; width: 100%;"></div>
              </div>
            </div>
            <div class="row my-5 d-flex ">
              <div class="col-3 item-product">
                <div class="img-product">
                  <img src="./img/sanpham.jpeg" class="img-fluid w-100 " alt="">
                </div>
                <div class="info-product ">
                  <div class="name-product">GK.M GỌNG NHỰA AN221393 (50.18.145)</div>
                  <div class="price-product" style="position: relative;">350.000đ <i class="fa-solid fa-arrow-up-right icon-arrow"></i></div>
                </div>
                <div class="" style="height: 80px; width: 100%;"></div>
              </div>
              <div class="col-3 item-product">
                <div class="img-product">
                  <img src="./img/sanpham.jpeg" class="img-fluid w-100" alt="">
                </div>
                <div class="info-product ">
                  <div class="name-product">GK.M GỌNG NHỰA AN221393 (50.18.145)</div>
                  <div class="price-product" style="position: relative;">350.000đ <i class="fa-solid fa-arrow-up-right icon-arrow"></i></div>
                </div>
                <div class="" style="height: 80px; width: 100%;"></div>
              </div>
              <div class="col-3 item-product">
                <div class="img-product">
                  <img src="./img/sanpham.jpeg" class="img-fluid w-100" alt="">
                </div>
                <div class="info-product ">
                  <div class="name-product">GK.M GỌNG NHỰA AN221393 (50.18.145)</div>
                  <div class="price-product" style="position: relative;">350.000đ <i class="fa-solid fa-arrow-up-right icon-arrow"></i></div>
                </div>
                <div class="" style="height: 80px; width: 100%;"></div>
              </div>
              <div class="col-3 item-product">
                <div class="img-product">
                  <img src="./img/sanpham.jpeg" class="img-fluid w-100" alt="">
                </div>
                <div class="info-product ">
                  <div class="name-product">GK.M GỌNG NHỰA AN221393 (50.18.145)</div>
                  <div class="price-product" style="position: relative;">350.000đ <i class="fa-solid fa-arrow-up-right icon-arrow"></i></div>
                </div>
                <div class="" style="height: 80px; width: 100%;"></div>
              </div>
            </div>
            <div class="row my-5 d-flex ">
              <div class="col-3 item-product">
                <div class="img-product">
                  <img src="./img/sanpham.jpeg" class="img-fluid w-100 " alt="">
                </div>
                <div class="info-product ">
                  <div class="name-product">GK.M GỌNG NHỰA AN221393 (50.18.145)</div>
                  <div class="price-product" style="position: relative;">350.000đ <i class="fa-solid fa-arrow-up-right icon-arrow"></i></div>
                </div>
                <div class="" style="height: 80px; width: 100%;"></div>
              </div>
              <div class="col-3 item-product">
                <div class="img-product">
                  <img src="./img/sanpham.jpeg" class="img-fluid w-100" alt="">
                </div>
                <div class="info-product ">
                  <div class="name-product">GK.M GỌNG NHỰA AN221393 (50.18.145)</div>
                  <div class="price-product" style="position: relative;">350.000đ <i class="fa-solid fa-arrow-up-right icon-arrow"></i></div>
                </div>
                <div class="" style="height: 80px; width: 100%;"></div>
              </div>
              <div class="col-3 item-product">
                <div class="img-product">
                  <img src="./img/sanpham.jpeg" class="img-fluid w-100" alt="">
                </div>
                <div class="info-product ">
                  <div class="name-product">GK.M GỌNG NHỰA AN221393 (50.18.145)</div>
                  <div class="price-product" style="position: relative;">350.000đ <i class="fa-solid fa-arrow-up-right icon-arrow"></i></div>
                </div>
                <div class="" style="height: 80px; width: 100%;"></div>
              </div>
              <div class="col-3 item-product">
                <div class="img-product">
                  <img src="./img/sanpham.jpeg" class="img-fluid w-100" alt="">
                </div>
                <div class="info-product ">
                  <div class="name-product">GK.M GỌNG NHỰA AN221393 (50.18.145)</div>
                  <div class="price-product" style="position: relative;">350.000đ <i class="fa-solid fa-arrow-up-right icon-arrow"></i></div>
                </div>
                <div class="" style="height: 80px; width: 100%;"></div>
              </div>
            </div>
            <div class="row my-5 d-flex ">
              <div class="col-3 item-product">
                <div class="img-product">
                  <img src="./img/sanpham.jpeg" class="img-fluid w-100 " alt="">
                </div>
                <div class="info-product ">
                  <div class="name-product">GK.M GỌNG NHỰA AN221393 (50.18.145)</div>
                  <div class="price-product" style="position: relative;">350.000đ <i class="fa-solid fa-arrow-up-right icon-arrow"></i></div>
                </div>
                <div class="" style="height: 80px; width: 100%;"></div>
              </div>
              <div class="col-3 item-product">
                <div class="img-product">
                  <img src="./img/sanpham.jpeg" class="img-fluid w-100" alt="">
                </div>
                <div class="info-product ">
                  <div class="name-product">GK.M GỌNG NHỰA AN221393 (50.18.145)</div>
                  <div class="price-product" style="position: relative;">350.000đ <i class="fa-solid fa-arrow-up-right icon-arrow"></i></div>
                </div>
                <div class="" style="height: 80px; width: 100%;"></div>
              </div>
              <div class="col-3 item-product">
                <div class="img-product">
                  <img src="./img/sanpham.jpeg" class="img-fluid w-100" alt="">
                </div>
                <div class="info-product ">
                  <div class="name-product">GK.M GỌNG NHỰA AN221393 (50.18.145)</div>
                  <div class="price-product" style="position: relative;">350.000đ <i class="fa-solid fa-arrow-up-right icon-arrow"></i></div>
                </div>
                <div class="" style="height: 80px; width: 100%;"></div>
              </div>
              <div class="col-3 item-product">
                <div class="img-product">
                  <img src="./img/sanpham.jpeg" class="img-fluid w-100" alt="">
                </div>
                <div class="info-product ">
                  <div class="name-product">GK.M GỌNG NHỰA AN221393 (50.18.145)</div>
                  <div class="price-product" style="position: relative;">350.000đ <i class="fa-solid fa-arrow-up-right icon-arrow"></i></div>
                </div>
                <div class="" style="height: 80px; width: 100%;"></div>
              </div>
            </div>
            <div class="row my-5 d-flex ">
              <div class="col-3 item-product">
                <div class="img-product">
                  <img src="./img/sanpham.jpeg" class="img-fluid w-100 " alt="">
                </div>
                <div class="info-product ">
                  <div class="name-product">GK.M GỌNG NHỰA AN221393 (50.18.145)</div>
                  <div class="price-product" style="position: relative;">350.000đ <i class="fa-solid fa-arrow-up-right icon-arrow"></i></div>
                </div>
                <div class="" style="height: 80px; width: 100%;"></div>
              </div>
              <div class="col-3 item-product">
                <div class="img-product">
                  <img src="./img/sanpham.jpeg" class="img-fluid w-100" alt="">
                </div>
                <div class="info-product ">
                  <div class="name-product">GK.M GỌNG NHỰA AN221393 (50.18.145)</div>
                  <div class="price-product" style="position: relative;">350.000đ <i class="fa-solid fa-arrow-up-right icon-arrow"></i></div>
                </div>
                <div class="" style="height: 80px; width: 100%;"></div>
              </div>
              <div class="col-3 item-product">
                <div class="img-product">
                  <img src="./img/sanpham.jpeg" class="img-fluid w-100" alt="">
                </div>
                <div class="info-product ">
                  <div class="name-product">GK.M GỌNG NHỰA AN221393 (50.18.145)</div>
                  <div class="price-product" style="position: relative;">350.000đ <i class="fa-solid fa-arrow-up-right icon-arrow"></i></div>
                </div>
                <div class="" style="height: 80px; width: 100%;"></div>
              </div>
              
            </div>
          </div>
          <div id="pagination">
            <button class="page-btn prev-btn"><i class="fa-solid fa-angles-left"></i></button>
            <!-- Các nút số trang sẽ được thêm bằng JS -->
            <button class="page-btn next-btn"><i class="fa-solid fa-angles-right"></i></button>
          </div>
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
    <div style="width: 40%;"><img src="./img/traidep.png" alt="" class="img-fluid w-100"></div>
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
          <img src="./img/logo.svg" alt="Anna Logo">
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
</body>
<script src="../../js/client/HomPageClient.js"></script>
<script src="../../js/client/include/navbar.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>

</html>