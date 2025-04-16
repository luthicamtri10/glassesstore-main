<?php
namespace App\Bus;
use App\Dao\SanPham_DAO;
use App\Interface\BUSInterface;
use Illuminate\Support\Facades\Validator;
class SanPham_BUS implements BUSInterface {

    private $sanPhamDAO;

    public function __construct(SanPham_DAO $sanPhamDAO)
    {
        $this->sanPhamDAO = $sanPhamDAO;
    }

    public function getAllModels() {
        return $this->sanPhamDAO->readDatabase();
    }

    public function refreshData(): void {
       $this->sanPhamDAO->getAll();
    }

    public function getModelById(int $id) {
        $models = $this->sanPhamDAO->readDatabase();
        foreach ($models as $model) {
            if ($model->getId() === $id) {
                return $model;
            }
        }
        return null;
    }

    public function addModel($model): int {
        
        // Validate dữ liệu
        $validator = Validator::make($model->toArray(), [
            'tenSanPham' => 'required|string|max:255',
            'idHang' => 'required|integer|exists:hangs,id',
            'idLSP' => 'required|integer|exists:loai_san_phams,id',
            'soLuong' => 'required|integer|min:0',
            'moTa' => 'nullable|string',
            'donGia' => 'required|numeric|min:0',
            'thoiGianBaoHanh' => 'nullable|string|max:50',
            'trangThaiHD' => 'required|boolean',
        ]);
         
        return $this->sanPhamDAO->insert($model);
    }

    public function updateModel($model): int {
        return $this->sanPhamDAO->update($model);
    }

    public function deleteModel(int $id): int {
        return $this->sanPhamDAO->delete($id);
    }

    public function searchModel(string $value, array $columns): array {
        return $this->sanPhamDAO->search($value, $columns);
    }

}