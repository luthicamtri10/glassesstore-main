<?php
namespace App\Bus;
use App\Interface\BUSInterface;
use Illuminate\Support\Facades\Validator;
use App\Dao\SanPham_DAO;

class SanPham_BUS implements BUSInterface {
    private $listSanPham = array();
    private $sanPhamDAO;
    public function __construct(SanPham_DAO $sanPhamDAO)
    {
        $this->sanPhamDAO = $sanPhamDAO;
        $this->refreshData();
    }

    public function getAllModels() {
        return $this->listSanPham;
    }

    public function getAllModelsActive() {
        return $this->sanPhamDAO->getAllModelsActive();
    }

    public function refreshData(): void {
       $this->listSanPham = $this->sanPhamDAO->getAll();
    }

    public function getModelById($id) {
        $models = $this->sanPhamDAO->getById($id);
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
    public function searchByLoaiSanPham($idLSP) {
        return $this->sanPhamDAO->searchByLoaiSanPham($idLSP);
    }
    public function searchByHang($idHang) {
        return $this->sanPhamDAO->searchByHang($idHang);
    }
    public function searchByLSPAndHang($lsp,$hang) {
        return $this->sanPhamDAO->searchByLSPAndHang($lsp,$hang);
    }
    public function getTop4ProductWasHigestSale() {
        return $this->sanPhamDAO->getTop4ProductWasHigestSale();
    }
    public function getStock($idPd) {
        return $this->sanPhamDAO->getStock($idPd);
    }
}