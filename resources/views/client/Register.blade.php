<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
<script>
    document.addEventListener('DOMContentLoaded', function () {
        document.getElementById("kiemTraSDT").addEventListener("click", function () {
        const sdt = document.querySelector('input[name="sdt"]').value;

        if (!sdt) return alert("Vui lòng nhập số điện thoại!");

        fetch(`/register?sdt=${sdt}`)
            .then(res => res.json())
            .then(data => {
                const infoDiv = document.querySelector('form[role="search"]');
                if (data.exists) {
                    const nd = data.data;
                    document.getElementById("hoTen").value = nd.ho_ten;
                    const gioiTinhSelect = document.getElementById("gioiTinh");
                    if (nd.gioi_tinh === "MALE") {
                        gioiTinhSelect.value = "MALE";
                    } else if (nd.gioi_tinh === "FEMALE") {
                        gioiTinhSelect.value = "FEMALE";
                    } else {
                        gioiTinhSelect.value = "UNDEFINED";
                    }
                    document.getElementById("ngaySinh").value = nd.ngay_sinh;
                    document.getElementById("diachi").value = nd.dia_chi;
                    const tinhSelect = document.getElementById("tinh");
                    tinhSelect.value = nd.tinh; // ID hoặc mã của tỉnh
                    document.getElementById("sodienthoai").value = nd.sodienthoai;
                    document.getElementById("cccd").value = nd.cccd;
                } else {
                    infoDiv.innerHTML = `<p style="color:red">Số điện thoại chưa tồn tại. Bạn cần nhập thông tin mới.</p>`;
                }
            });
        });
    });
</script>
<div class="w-100 d-flex justify-content-center align-items-center bg-body-secondary" >
    <div class="bg-white shadow rounded p-3 d-flex flex-column mb-3 align-items-center gap-4" style="width: 70%; margin: 20px;">
        <h2>Thông tin đăng kí</h2>
        <!-- kiểm tra sdt -->
        <form class="flex gap-2 border-light-subtle shadow rounded p-4" style="width: 80%;" method="get" role="search">
            @csrf
            <div class="d-flex justify-content-center align-items-center flex-column gap-3">
                <h3>Kiểm tra số điện thoại</h3>
                <div class="d-flex justify-content-start align-items-center gap-3" style="width: 80%;">
                    <label for="" class="fw-semibold fs-5">Số điện thoại</label>
                    <input type="text" name="sdt" id="sdt" class="rounded border border-light-subtle p-1" style="flex: 1;">
                </div>
                <div class="d-flex justify-content-center">
                    <button id="kiemTraSDT" class="p-2 rounded bg-info border-0 fw-semibold text-white fs-5">Kiểm tra</button>
                </div>
            </div>
        </form>
        <!-- thông tin user -->
        <form class="d-flex flex-column mb-3 gap-2 border-light-subtle shadow rounded p-4 align-items-center" style="width: 80%;" action="" method="post" role="" name="information-user">
        @csrf
            <h3>Thông tin người dùng</h3>
            @if($nguoidung==null)
                <div class="d-flex justify-content-between align-items-center gap-3" style="width: 80%;">
                    <label for="" class="fw-semibold fs-5">Họ tên</label>
                    <input type="text" name="hoTen" id="hoTen" class="rounded border border-light-subtle p-1" style="width: 80%;">
                </div>
                <div class="d-flex justify-content-between align-items-center gap-3" style="width: 80%;">
                    <label for="" class="fw-semibold fs-5">Ngày sinh</label>
                    <input type="date" name="ngaySinh" id="ngaySinh" class="rounded border border-light-subtle p-1" style="width: 80%;">
                </div>
                <div class="d-flex justify-content-between align-items-center gap-3" style="width: 80%;">
                    <label for="" class="fw-semibold fs-5">Giới tính</label>
                    <select name="gioiTinh" id="gioiTinh" class="rounded border border-light-subtle p-1" style="width: 80%;">
                        <option selected disabled>Chọn giới tính</option>
                        <option value="MALE">Nam</option>
                        <option value="FEMALE">Nữ</option>
                        <option value="UNDEFINED">Khác</option>
                    </select>
                </div>
                <div class="d-flex justify-content-between align-items-center gap-3" style="width: 80%;">
                    <label for="" class="fw-semibold fs-5">Địa chỉ</label>
                    <input type="text" name="diaChi" id="diaChi" class="rounded border border-light-subtle p-1" style="width: 80%;">
                </div>
                <div class="d-flex justify-content-between align-items-center gap-3" style="width: 80%;">
                    <label for="" class="fw-semibold fs-5">Tỉnh</label>
                    <select id="tinh" class="form-select" name="tinh" class="rounded border border-light-subtle p-1" style="width: 80%;">
                        <option selected disabled>Chọn tỉnh</option>
                        @foreach($listTinh as $it)
                            <option value="{{ $it->getId() }}">
                                {{ $it->getTenTinh() }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="d-flex justify-content-between align-items-center gap-3" style="width: 80%;">
                    <label for="" class="fw-semibold fs-5">Số điện thoại</label>
                    <input type="text" name="sodienthoai" id="sodienthoai" class="rounded border border-light-subtle p-1" style="width: 80%;">
                </div>
                <div class="d-flex justify-content-between align-items-center gap-3" style="width: 80%;">
                    <label for="" class="fw-semibold fs-5">CCCD</label>
                    <input type="text" name="cccd" id="cccd" class="rounded border border-light-subtle p-1" style="width: 80%;">
                </div>
            @else
                <div class="d-flex justify-content-between align-items-center gap-3" style="width: 80%;">
                    <label for="" class="fw-semibold fs-5">Họ tên</label>
                    <input type="text" name="hoTen" id="hoTen" value="{{$nguoidung->getHoTen()}}" class="rounded border border-light-subtle p-1" style="width: 80%;">
                </div>
                <div class="d-flex justify-content-between align-items-center gap-3" style="width: 80%;">
                    <label for="" class="fw-semibold fs-5">Ngày sinh</label>
                    <input type="date" name="ngaySinh" id="ngaySinh" value="{{$nguoidung->getNgaySinh()}}" class="rounded border border-light-subtle p-1" style="width: 80%;">
                </div>
                <div class="d-flex justify-content-between align-items-center gap-3" style="width: 80%;">
                    <label for="" class="fw-semibold fs-5">Giới tính</label>
                    <select name="gioiTinh" id="gioiTinh" class="rounded border border-light-subtle p-1" style="width: 80%;">
                        <option selected disabled>Chọn giới tính</option>
                        <option value="MALE">Nam</option>
                        <option value="FEMALE">Nữ</option>
                        <option value="UNDEFINED">Khác</option>
                    </select>
                </div>
                <div class="d-flex justify-content-between align-items-center gap-3" style="width: 80%;">
                    <label for="" class="fw-semibold fs-5">Địa chỉ</label>
                    <input type="text" name="diaChi" value="{{$nguoidung->getDiaChi()}}" id="diaChi" class="rounded border border-light-subtle p-1" style="width: 80%;">
                </div>
                <div class="d-flex justify-content-between align-items-center gap-3" style="width: 80%;">
                    <label for="" class="fw-semibold fs-5">Tỉnh</label>
                    <select id="tinh" class="form-select" name="tinh" class="rounded border border-light-subtle p-1" style="width: 80%;">
                        <option selected disabled>Chọn tỉnh</option>
                        @foreach($listTinh as $it)
                            <option value="{{ $it->getId() }}">
                                {{ $it->getTenTinh() }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="d-flex justify-content-between align-items-center gap-3" style="width: 80%;">
                    <label for="" class="fw-semibold fs-5">Số điện thoại</label>
                    <input type="text" name="sodienthoai" id="sodienthoai" value="{{$nguoidung->getSoDienThoai()}}" class="rounded border border-light-subtle p-1" style="width: 80%;">
                </div>
                <div class="d-flex justify-content-between align-items-center gap-3" style="width: 80%;">
                    <label for="" class="fw-semibold fs-5">CCCD</label>
                    <input type="text" name="cccd" id="cccd" value="{{$nguoidung->getCccd()}}" class="rounded border border-light-subtle p-1" style="width: 80%;">
                </div>
            @endif
        </form>
        <!-- thông tin tài khoản -->
        <form class="d-flex flex-column mb-3 gap-2 border-light-subtle shadow rounded p-4 align-items-center" style="width: 80%;" action="" method="post" name="information-account">
        @csrf
            <h3>Thông tin tài khoản</h3>
            <div class="d-flex justify-content-between align-items-center gap-3" style="width: 80%;">
                <label for="" class="fw-semibold fs-5">Tên tài khoản</label>
                <input type="text" name="tenTK" id="" class="rounded border border-light-subtle p-1" style="width: 80%;">
            </div>
            <div class="d-flex justify-content-between align-items-center gap-3" style="width: 80%;">
                <label for="" class="fw-semibold fs-5">Email</label>
                <input type="text" name="email" id="" class="rounded border border-light-subtle p-1" style="width: 80%;">
            </div>
            <div class="d-flex justify-content-between align-items-center gap-3" style="width: 80%;">
                <label for="" class="fw-semibold fs-5">Password</label>
                <input type="password" name="password" id="" class="rounded border border-light-subtle p-1" style="width: 80%;">
            </div>
        </form>
    </div>
</div>
