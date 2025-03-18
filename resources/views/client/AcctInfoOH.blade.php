<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../css/client/include/footer.css">
    <link rel="stylesheet" href="../../css/client/include/navbar.css">
    <link rel="stylesheet" href="../../css/client/AcctIfoOH.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="https://site-assets.fontawesome.com/releases/v6.7.2/css/all.css">

    <title>InfomationAccount/OrderHistoryBuy</title>
</head>

<body>
    <header>
        <div class="text-white" id="navbar-ctn">
            <div class="top-nav">
                <p style="color: #55d5d2; font-size: 14px; font-weight: 600;">GIẢM GIÁ NGAY 15% CHO ĐƠN ĐẦU TIÊN</p>
                <ul class="list-top-nav d-flex ms-auto gap-2">
                    <li class="nav-item px-3 py-1 bg-secondary text-white fw-medium rounded-pill" id="chinhsach"><a href="">Chính sách</a></li>
                    <li class="nav-item px-3 py-1 bg-secondary text-white fw-medium rounded-pill" id="tracuudonhang"><a href="">Tra cứu đơn hàng</a></li>
                    <li class="nav-item px-3 py-1 bg-secondary text-white fw-medium rounded-pill" id="taikhoan"><a href="../../views/client/Login-Register.php">Tài khoản</a></li>
                </ul>
            </div>
            <div class="navbar text-white navbar-expand" id="navbar">  
                <a href="" class="navbar-brand">Logo</a>
                <ul class="navbar-nav gap-5">
                    <li class="nav-item fw-medium my-2 mx-2" id="item-sanpham"><a href="" class="nav-link text-white">Sản Phẩm <i class="fa-regular fa-angle-up"></i></a></li>
                    <li class="nav-item fw-medium d-flex"><a href="#" class="nav-link text-white">Tìm Cửa Hàng<i class="fa-regular fa-location-dot fa-bounce"></i></a></li>
                    <li class="nav-item fw-medium" style="position: relative;"><input class="rounded-pill py-2" type="text" placeholder="Tìm kiếm sản phẩm" style="width: 300px;outline: none;border:none;padding: 0 30px 0 10px;"><i class="fa-solid fa-magnifying-glass" style="position: absolute; right: 10px; color: #555;"></i></li>
                    <li class="nav-item fw-medium my-2" id="item-xemthem"><a href="" class="nav-link text-white">Xem Thêm <i class="fa-regular fa-angle-up"></i></a></li>
                    <li class="nav-item fw-medium"><a href="#" class="nav-link text-white">Hành Trình Tử Tế</a></li>
                    <li class="nav-item fw-medium my-2"><a href="#" class="nav-link text-white">Giỏ Hàng</a> <i class="fa-light fa-bag-shopping"></i></li>
                </ul>
            </div>
        </div>
    </header>
    <div class="submenu card" style="z-index: 100;">
        <div class="card-menu d-flex">
        </div>
    </div>
    <div class="content-ctn">
        <div class="container">
            <!-- Sidebar -->
            <div class="sidebar">
                <div class="avatar">
                    <img src="./img/itxt1.jpeg" alt="Avatar">
                </div>
                <h2>Quang Vinh Bui Gia</h2>
                <ul>
                    <li id="list-product"><span class="icon"><i class="fa-light fa-square-list"></i></span> Danh sách sản phẩm</li>
                    <li id="information-account"><span class="icon"><i class="fa-light fa-user"></i></span> Thông tin tài khoản</li>
                    <li id="infomation-location"><span class="icon"><i class="fa-light fa-location-dot"></i></span> Thông tin địa chỉ</li>
                    <li id="logout"><span class="icon"><i class="fa-light fa-arrow-right-from-bracket"></i></span> Đăng xuất</li>
                </ul>
            </div>

            <!-- Main Content -->
            <div class="main-content">
                <!-- Top Buttons -->
                <div class="top-buttons">
                    <div class="circle-btn-container active">
                        <div class="circle-btn">
                            <span class="icon">🛒</span>
                            <span class="count">0</span>
                        </div>
                        <p>Sản phẩm đã mua</p>
                    </div>
                    <div class="circle-btn-container">
                        <div class="circle-btn">
                            <span class="icon">❤️</span>
                            <span class="count">0</span>
                        </div>
                        <p>Sản phẩm yêu thích</p>
                    </div>
                </div>

                <!-- Purchase History Table -->
                <div class="purchase-history">
                    <h3>Sản phẩm đã mua</h3>
                    <table>
                        <thead>
                            <tr>
                                <th>Mã đơn hàng</th>
                                <th>Số lượng</th>
                                <th>Trạng thái</th>
                                <th>Ngày tạo</th>
                                <th>Tầng</th>
                                <th>Thao tác</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td colspan="6" style="text-align: center;">Chưa có đơn hàng</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
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
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
<script src="../../js/client/include/navbar.js"></script>
<script src="../../js/client/AcctInfoOH.js"></script>

</html>