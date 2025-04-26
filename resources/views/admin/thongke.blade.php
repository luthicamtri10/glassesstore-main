<?php
use App\Bus\ThongKe_BUS;

// Nếu không có dữ liệu post lên thì lấy mặc định
$to = $_POST['to'] ?? date('Y-m-d');
$from = $_POST['from'] ?? date('Y-m-d', strtotime('-1 year'));

$bus = new ThongKe_BUS();
$topCustomers = $bus->getTop5KhachHang($from, $to);

$hoaDonHang = $bus->getListDonHang(1, $from, $to);
$CTHDList = $bus->getCTHD(1);
?>

<div class="container mt-5">
    <h2 class="mb-4 text-center">Thống Kê Khách Hàng</h2>

    <!-- Form lọc thời gian -->
    <form action="{{ route('admin.thongke') }}" method="POST" class="row g-3 mb-5">
    <div class="col-md-4">
        <label for="from" class="form-label">Từ ngày:</label>
        <input type="date" id="from" name="from" class="form-control" value="<?= $from ?>" required>
    </div>
    <div class="col-md-4">
        <label for="to" class="form-label">Đến ngày:</label>
        <input type="date" id="to" name="to" class="form-control" value="<?= $to ?>" required>
    </div>
    <div class="col-md-4 d-flex align-items-end">
        <button type="submit" class="btn btn-primary w-100">Thống kê</button>
    </div>
</form>


    <div class="row">
        <!-- Bên trái: Top khách hàng -->
        <div class="col-md-5 mb-5">
            <h5 class="mb-4">Top 5 khách hàng có tổng tiền mua cao nhất</h5>
                           <!-- Biểu đồ cột -->
            <canvas id="topCustomersChart" height="250"></canvas>
            <?php if ($topCustomers && count($topCustomers) > 0): ?>
                <div class="table-responsive mb-4">
                    <table class="table table-hover text-center align-middle">
                        <thead class="table-light">
                            <tr>
                                <th>Họ Tên</th>
                                <th>SĐT</th>
                                <th>Tổng Mua</th>
                                <th>Đơn Hàng</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($topCustomers as $customer): ?>
                                <tr>
                                <td><?= htmlspecialchars($customer['HOTEN'] . '-' . $customer['ID']) ?></td>
                                    <td><?= htmlspecialchars($customer['SODIENTHOAI']) ?></td>
                                    <td><?= number_format($customer['TONGMUA']) ?> VNĐ</td>
                                    <td>
                                        <button class="btn btn-outline-primary btn-sm" onclick="showDsHD(<?= $customer['ID'] ?>)">Xem đơn hàng</button>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
 

            <?php else: ?>
                <div class="alert alert-info">Không có dữ liệu khách hàng trong khoảng thời gian đã chọn.</div>
            <?php endif; ?>
        </div>

        <!-- Bên phải: Danh sách hóa đơn -->
        <div class="col-md-7 mb-5">
            <h5 class="mb-4">Danh sách đơn hàng của khách hàng</h5>

            <div class="row mb-3 g-3">
                <div class="col-md-4">
                    <label for="sortSelect" class="form-label">Sắp xếp tổng tiền:</label>
                    <select class="form-select" id="sortSelect">
                        <option value="desc">Giảm dần</option>
                        <option value="asc">Tăng dần</option>
                    </select>
                </div>
                <div class="col-md-6">
                    <label for="searchInput" class="form-label">Tìm kiếm:</label>
                    <input type="text" class="form-control" id="searchInput" placeholder="Tìm kiếm...">
                </div>
                <div class="col-md-2 d-flex align-items-end">
                    <button class="btn btn-success w-100" onclick="searchTable()">Tìm</button>
                </div>
            </div>

            <div class="table-responsive">
                <table class="table table-hover text-center align-middle" id="hoaDonTable">
                    <thead class="table-light">
                        <tr>
                            <th>Email TK</th>
                            <th>Ngày Hoàn Thành</th>
                            <th>Tổng Tiền</th>
                            <th>Nhân Viên</th>
                            <th>Chi Tiết</th>
                        </tr>
                    </thead>
                    <tbody id="hoaDonTableBody">
                        <?php if (!$hoaDonHang || count($hoaDonHang) <= 0): ?>
                            <tr>
                                <td colspan="5" class="text-center">Không có dữ liệu hiển thị</td>
                            </tr>
                        <?php else: ?>
                            <?php foreach ($hoaDonHang as $hoaDon): ?>
                                <tr>
                                    <td><?= htmlspecialchars($hoaDon['EMAIL']) ?></td>
                                    <td><?= htmlspecialchars($hoaDon['NGAYTAO']) ?></td>
                                    <td><?= number_format($hoaDon['TONGTIEN']) ?> VNĐ</td>
                                    <td><?= htmlspecialchars($hoaDon['TENNV']) ?></td>
                                    <td>
                                        <button class="btn btn-outline-primary btn-sm">Xem chi tiết</button>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Chi tiết đơn hàng -->
    <div class="row">
        <h5 class="mb-4">Chi tiết đơn hàng</h5>

        <div class="table-responsive">
            <table class="table table-hover text-center align-middle">
                <thead class="table-light">
                    <tr>
                        <th>Loại SP</th>
                        <th>Tên SP</th>
                        <th>Series</th>
                        <th>Số Lượng</th>
                        <th>Đơn Giá Gốc</th>
                        <th>Giá Lúc Đặt</th>
                        <th>Tổng Giá Gốc</th>
                        <th>Thành Tiền</th>
                    </tr>
                </thead>
                <tbody id="CTHDTableBody">
                    <?php if (!$CTHDList || count($CTHDList) <= 0): ?>
                        <tr>
                            <td colspan="8" class="text-center">Không có dữ liệu hiển thị</td>
                        </tr>
                    <?php else: ?>
                        <?php foreach ($CTHDList as $CTHD): ?>
                            <tr>
                                <td><?= htmlspecialchars($CTHD['TENLSP']) ?></td>
                                <td><?= htmlspecialchars($CTHD['TENSANPHAM']) ?></td>
                                <td><?= htmlspecialchars($CTHD['SERIS']) ?></td>
                                <td><?= htmlspecialchars($CTHD['SOLUONG']) ?></td>
                                <td><?= number_format($CTHD['DONGIA']) ?> VNĐ</td>
                                <td><?= number_format($CTHD['GIALUCDAT']) ?> VNĐ</td>
                                <td><?= number_format($CTHD['TONGTIEN']) ?> VNĐ</td>
                                <td><?= number_format($CTHD['THANHTIEN']) ?> VNĐ</td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Script -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    const hoaDonTableBody = document.getElementById('hoaDonTableBody');
    const sortSelect = document.getElementById('sortSelect');

    function showDsHD(customerId) {
    console.log('Đang load đơn hàng cho khách ID:', customerId);

    fetch('<?= route('admin.ajaxGetDonHang') ?>', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': '<?= csrf_token() ?>' // Nếu bạn dùng Laravel
        },
        body: JSON.stringify({ customerId: customerId })
    })
    .then(response => response.json())
    .then(data => {
        console.log('Đã nhận dữ liệu:', data);
        renderHoaDonTable(data);
    })
    .catch(error => {
        console.error('Lỗi khi load đơn hàng:', error);
    });
}

function renderHoaDonTable(hoaDons) {
    const hoaDonTableBody = document.getElementById('hoaDonTableBody');
    hoaDonTableBody.innerHTML = ''; // Clear bảng cũ

    if (hoaDons.length === 0) {
        hoaDonTableBody.innerHTML = `
            <tr>
                <td colspan="6" class="text-center text-muted">Không có đơn hàng nào</td>
            </tr>
        `;
        return;
    }

    hoaDons.forEach(hoaDon => {
        const row = `
            <tr>
                <td>${hoaDon.EMAIL}</td>
                <td>${hoaDon.NGAYTAO}</td>
                <td>${parseInt(hoaDon.TONGTIEN).toLocaleString()} VNĐ</td>
                <td>${hoaDon.TENNV}</td>
                <td>
                    <button class="btn btn-outline-primary btn-sm" onclick="xemChiTietDon(${hoaDon.ID})">Xem chi tiết</button>
                </td>
            </tr>
        `;
        hoaDonTableBody.insertAdjacentHTML('beforeend', row);
    });
}


    function searchTable() {
        const input = document.getElementById('searchInput').value.toLowerCase();
        const rows = document.querySelectorAll('#hoaDonTable tbody tr');
        rows.forEach(row => {
            const cells = row.querySelectorAll('td');
            let match = false;
            cells.forEach(cell => {
                if (cell.textContent.toLowerCase().includes(input)) {
                    match = true;
                }
            });
            row.style.display = match ? '' : 'none';
        });
    }

    sortSelect.addEventListener('change', function() {
        const order = this.value;
        const rows = Array.from(hoaDonTableBody.querySelectorAll('tr'));

        rows.sort((a, b) => {
            const tongTienA = parseInt(a.children[2].textContent.replace(/[^\d]/g, ''));
            const tongTienB = parseInt(b.children[2].textContent.replace(/[^\d]/g, ''));
            return order === 'asc' ? tongTienA - tongTienB : tongTienB - tongTienA;
        });

        hoaDonTableBody.innerHTML = '';
        rows.forEach(row => hoaDonTableBody.appendChild(row));
    });

    // Biểu đồ Top 5 khách hàng
    <?php if ($topCustomers && count($topCustomers) > 0): ?>
    const ctx = document.getElementById('topCustomersChart').getContext('2d');
    const customerNames = <?= json_encode(array_column($topCustomers, 'HOTEN')) ?>;
    const totalPurchases = <?= json_encode(array_column($topCustomers, 'TONGMUA')) ?>;
    new Chart(ctx, {
        type: 'bar',
        data: {
            labels: customerNames,
            datasets: [{
                label: 'Tổng Mua (VNĐ)',
                data: totalPurchases,
                backgroundColor: 'rgba(54, 162, 235, 0.7)',
                borderColor: 'rgba(54, 162, 235, 1)',
                borderWidth: 1
            }]
        },
        options: {
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        callback: function(value) {
                            return value.toLocaleString() + ' VNĐ';
                        }
                    }
                }
            },
            plugins: {
                legend: { display: false }
            }
        }
    });
    <?php endif; ?>
</script>
