<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
<link rel="stylesheet" href="{{ asset('css/client/include/navbar.css') }}">
<link rel="stylesheet" href="{{ asset('css/client/include/footer.css') }}">
<div class="d-flex flex-column gap-3 p-5 bg-light" style="height: 100vh;">
<div class="text-white" id="navbar-ctn">
    <div class="top-nav">
        <p style="color: #55d5d2; font-size: 14px; font-weight: 600;">GIẢM GIÁ NGAY 15% CHO ĐƠN ĐẦU TIÊN</p>
        <ul class="list-top-nav d-flex ms-auto gap-2">
          <li class="nav-item px-3 py-1 bg-secondary text-white fw-medium rounded-pill " id="chinhsach"><a href="/yourInfo">Thông tin cá nhân</a></li>
          <li class="nav-item px-3 py-1 bg-secondary text-white fw-medium rounded-pill" id="tracuudonhang">
              <a href="{{ route('order.history') }}">Tra cứu đơn hàng</a>
          </li>
          @if($isLogin) 
          @if($user->getIdQuyen()->getId() == 1 || $user->getIdQuyen()->getId() == 2) 
            <li class="nav-item px-3 py-1 bg-secondary text-white fw-medium rounded-pill" id="tracuudonhang"><a href="/admin">Trang quản trị</a></li>
          @endif
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
    <div class="d-flex justify-content-between gap-5 mt-5 " style="">
        <div class="d-flex flex-column gap-3 p-3" style="width: 50%;height: 100%">
            <h1 class="text-dark fw-semibold">Thanh toán</h1>
            <div class="d-flex flex-column">
                <label class="text-dark fw-semibold" for="">Họ tên *</label>
                <input class="p-2 rounded hover:border-blue-500" type="text" name="hoten" id="" required>
            </div>
            <div class="d-flex flex-column">
                <label class="text-dark fw-semibold" for="">Số điện thoại *</label>
                <input class="p-2 rounded hover:border-blue-500" type="text" name="sdt" id="" required>
            </div>
            <div class="d-flex flex-column">
                <label class="text-dark fw-semibold" for="">Email *</label>
                <input class="p-2 rounded hover:border-blue-500" type="text" name="email" id="" required>
            </div>
            
            <div class="d-flex flex-column">
                <label class="text-dark fw-semibold" for="">Địa chỉ *</label>
                <input class="p-2 rounded hover:border-blue-500" type="text" name="diachi" id="" required>
            </div>
            <div class="d-flex flex-column">
                <label class="text-dark fw-semibold" for="">Phương thức thanh toán *</label>
                <!-- <input class="rounded hover:border-blue-500" type="text" name="pttt" id="" required> -->
                <select class="p-2 rounded hover:border-blue-500" name="pttt" id="">
                    <option value="" disabled>Chọn phương thức thanh toán</option>
                    @foreach($listPTTT as $pttt) 
                        <option value="{{$pttt->getId()}}">{{$pttt->getTenPTTT()}}</option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="d-flex flex-column gap-3 p-3 bg-body-secondary rounded" style="width: 50%;height: 100%;">
            <div class="d-flex justify-content-between">
                <p class="fw-semibold fs-5" style="color: black;">Sản phẩm</p>
                <p class="fw-semibold fs-5" style="color: black;">Thành tiền</p>
            </div>
            <hr style="color: gray;">
            @foreach($listSP as $sp)
                <div class="d-flex justify-content-start gap-3">
                    <img src="" alt="">
                </div>
            @endforeach
        </div>
    </div>
    
</div>