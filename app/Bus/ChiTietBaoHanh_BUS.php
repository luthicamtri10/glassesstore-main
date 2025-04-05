<?php
namespace App\Bus;

use App\Dao\ChiTietBaoHanh_DAO;
use App\Interface\BUSInterface;
use App\Models\ChiTietBaoHanh;
use InvalidArgumentException;

class ChiTietBaoHanh_BUS implements BUSInterface
{
    private array $chiTietBaoHanhList = [];
    private ChiTietBaoHanh_DAO $dao;

    /**
     * Khởi tạo với DAO được inject
     */
    public function __construct()
    {
        $this->dao = app(ChiTietBaoHanh_DAO::class);
        $this->refreshData();
    }

    /**
     * Làm mới dữ liệu từ DAO
     */
    public function refreshData(): void
    {
        $this->chiTietBaoHanhList = $this->dao->getAll();
    }

    /**
     * Lấy tất cả mô hình ChiTietBaoHanh
     */
    public function getAllModels(): array
    {
        return $this->chiTietBaoHanhList;
    }

    /**
     * Lấy mô hình theo ID (idKhachHang và idSanPham)
     */
    public function getModelById($id): ?ChiTietBaoHanh
    {
        if (!is_array($id) || !isset($id['idKhachHang']) || !isset($id['idSanPham'])) {
            throw new InvalidArgumentException("ID phải là mảng chứa idKhachHang và idSanPham");
        }
        return $this->dao->getById($id);
    }

    /**
     * Thêm một mô hình ChiTietBaoHanh
     */
    public function addModel($model): int
    {
        if (!$model instanceof ChiTietBaoHanh) {
            throw new InvalidArgumentException("Model phải là instance của ChiTietBaoHanh");
        }

        $result = $this->dao->insert($model);
        if ($result > 0) {
            $this->refreshData(); // Cập nhật danh sách sau khi thêm
        }
        return $result;
    }

    /**
     * Cập nhật một mô hình ChiTietBaoHanh
     */
    public function updateModel($model): int
    {
        if (!$model instanceof ChiTietBaoHanh) {
            throw new InvalidArgumentException("Model phải là instance của ChiTietBaoHanh");
        }

        $result = $this->dao->update($model);
        if ($result > 0) {
            $this->refreshData(); // Cập nhật danh sách sau khi sửa
        }
        return $result;
    }

    /**
     * Xóa một mô hình ChiTietBaoHanh
     */
    public function deleteModel($id): int
    {
        if (!is_array($id) || !isset($id['idKhachHang']) || !isset($id['idSanPham'])) {
            throw new InvalidArgumentException("ID phải là mảng chứa idKhachHang và idSanPham");
        }

        $result = $this->dao->delete($id);
        if ($result > 0) {
            $this->refreshData(); // Cập nhật danh sách sau khi xóa
        }
        return $result;
    }

    /**
     * Tìm kiếm mô hình theo giá trị và cột
     */
    public function searchModel(string $value, array $columns): array
    {
        if (empty($value)) {
            throw new InvalidArgumentException("Giá trị tìm kiếm không được để trống");
        }

        $list = $this->dao->search($value, $columns);
        if (empty($list)) {
            return []; // Trả về mảng rỗng nếu không tìm thấy
        }
        return $list;
    }
}
?>