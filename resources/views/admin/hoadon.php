<?php
    include '../../views/admin/includes/navbar.php'
?>
<div class="p-4 bg-light">
    <div class="col-md-12 d-flex flex-wrap align-items-center gap-3">
        <form class="d-flex flex-wrap w-100 gap-2">
            <select class="form-select" aria-label="Chọn trạng thái" style="max-width: 200px;">
                <option selected>Chọn trạng thái</option>
                <option value="1">Đang xử lý</option>
                <option value="2">Đã hoàn thành</option>
            </select>
            <input type="text" placeholder="Nhập mã đơn hàng..." class="form-control" style="max-width: 300px;">
            
            <div class="d-flex align-items-center gap-2">
                <label for="calendarStart" class="fw-bold">Ngày:</label>
                <input type="date" id="calendarStart" class="form-control" style="max-width: 140px;">
                <span class="fw-bold">-</span>
                <input type="date" id="calendarEnd" class="form-control" style="max-width: 140px;">
            </div>
            
            <div class="d-flex align-items-center gap-2">
                <span class="fw-bold">Tiền:</span>
                <button class="btn btn-outline-primary">
                    <i class="fa-solid fa-arrow-up-wide-short"></i>
                </button>
                <button class="btn btn-outline-primary">
                    <i class="fa-solid fa-arrow-down-wide-short"></i>
                </button>
            </div>
            <button class="btn btn-success">Tìm kiếm</button>
        </form>
    </div>
    
    <div class="table-responsive mt-4">
        <table class="table table-striped table-bordered text-center table-hover">
            <thead class="">
                <tr>
                    <th scope="col">ID</th>
                    <th scope="col">ID khách hàng</th>
                    <th scope="col">ID nhân viên</th>
                    <th scope="col">Tổng tiền</th>
                    <th scope="col">ID PTTT</th>
                    <th scope="col">Ngày tạo</th>
                    <th scope="col">ID DVVC</th>
                    <th scope="col">Trạng thái</th>
                    <th scope="col">Hành động</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <th scope="row">1</th>
                    <td>Nguyễn</td>
                    <td>Văn A</td>
                    <td>@vana</td>
                    <td>Nguyễn</td>
                    <td>Văn A</td>
                    <td>@vana</td>
                    <?php
                     
                    ?>
                    <td class="text-danger">@vana</td>
                    <td>
                        <button class="btn btn-warning btn-sm">Xem chi tiết</button>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
    
    <nav aria-label="Page navigation" class="d-flex justify-content-center mt-3">
        <ul class="pagination">
            <li class="page-item">
                <a class="page-link" href="#" aria-label="Previous">
                    <span aria-hidden="true">&laquo;</span>
                </a>
            </li>
            <li class="page-item"><a class="page-link" href="#">1</a></li>
            <li class="page-item"><a class="page-link" href="#">2</a></li>
            <li class="page-item"><a class="page-link" href="#">3</a></li>
            <li class="page-item">
                <a class="page-link" href="#" aria-label="Next">
                    <span aria-hidden="true">&raquo;</span>
                </a>
            </li>
        </ul>
    </nav>
</div>
