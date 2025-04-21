<?php
namespace App\Bus;

use App\Dao\PhieuNhap_DAO;
use App\Interface\BUSInterface;
use App\Models\PhieuNhap;
use App\Dao\CTPN_DAO;
use PhpParser\Node\Stmt\Echo_;

use function Laravel\Prompts\error;

class PhieuNhap_BUS implements BUSInterface
{
    private $phieuNhapList = array();
    private static $instance;
    private $ctpnDAO;

    public static function getInstance()
    {
        if (self::$instance == null) {
            self::$instance = new PhieuNhap_BUS();
        }
        return self::$instance;
    }

    public function __construct()
    {
        $this->ctpnDAO = CTPN_DAO::getInstance();
        $this->refreshData();
    }

    public function refreshData(): void
    {
        $this->phieuNhapList = PhieuNhap_DAO::getInstance()->getAll();
        // if (!empty($this->phieuNhapList)) {
        //     foreach ($this->phieuNhapList as $phieuNhap) {
        //         $chiTiet = $this->ctpnDAO->getByPhieuNhapId($phieuNhap->getId());
        //         $phieuNhap->setChiTietPhieuNhap($chiTiet);
        //     }
        // }
    }

    public function getAllModels(): array
    {
        return $this->phieuNhapList;
    }

    public function getModelById(int $id)
    {
        $phieuNhap = PhieuNhap_DAO::getInstance()->getById($id);
        // if ($phieuNhap) {
        //     $chiTiet = $this->ctpnDAO->getByPhieuNhapId($id);
        //     $phieuNhap->setChiTietPhieuNhap($chiTiet);
        // }
        return $phieuNhap;
    }

    public function addModel($model)
    {
        if ($model == null) {
            error("Error when adding a PhieuNhap");
            return;
        }
        return PhieuNhap_DAO::getInstance()->insert($model);
    }

    public function updateModel($model)
    {
        if ($model == null) {
            error("Error when updating a PhieuNhap");
            return;
        }
        return PhieuNhap_DAO::getInstance()->update($model);
    }

    public function deleteModel(int $id)
    {
        if ($id == null || $id == "") {
            error("Error when deleting a PhieuNhap");
            return;
        }
        return PhieuNhap_DAO::getInstance()->delete($id);
    }

    public function searchModel(string $value, array $columns)
    {
        $list = PhieuNhap_DAO::getInstance()->search($value, $columns);
        if (count($list) > 0) {
            return $list;
        } else {
            echo "Not found";
        }
        return null;
    }
    public function populationChiTietPhieuNhaps($phieuNhap) {
        $chiTietPhieuNhaps = $this->ctpnDAO->getByPhieuNhapId($phieuNhap->getId());
        $phieuNhap->setChiTietPhieuNhaps($chiTietPhieuNhaps);
        return $phieuNhap;
    }
}
?>