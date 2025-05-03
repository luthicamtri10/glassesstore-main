<?php
namespace App\Bus;

use App\Dao\PhieuNhap_DAO;
use App\Interface\BUSInterface;
use App\Models\PhieuNhap;
use App\Dao\CTPN_DAO;
use PhpParser\Node\Stmt\Echo_;
use Illuminate\Support\Facades\Validator;
use function Laravel\Prompts\error;
use App\Services\database_connection;

class PhieuNhap_BUS implements BUSInterface
{
    private $phieuNhapList = array();
    private $phieuNhapDAO;
    private $ctpnDAO;

    public function __construct(PhieuNhap_DAO $phieuNhapDAO, CTPN_DAO $ctpnDAO)
    {
        $this->phieuNhapDAO = $phieuNhapDAO;
        $this->ctpnDAO = $ctpnDAO;
        $this->refreshData();
    }

 

    public function refreshData(): void
    {
            $this->phieuNhapList = $this->phieuNhapDAO->getAll();
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
            $phieuNhap = $this->phieuNhapDAO->getById($id);
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
        return $this->phieuNhapDAO->insert($model);
    }

    public function updateModel($model)
    {
        if ($model == null) {
            error("Error when updating a PhieuNhap");
            return;
        }
        return $this->phieuNhapDAO->update($model);
    }

    public function deleteModel(int $id)
    {
        if ($id == null || $id == "") {
            error("Error when deleting a PhieuNhap");
            return;
        }
        return $this->phieuNhapDAO->delete($id);
    }

    public function searchModel(string $value, array $columns)
    {
        $list = $this->phieuNhapDAO->search($value, $columns);
        if (count($list) > 0) {
            return $list;
        } else {
            echo "Not found";
        }
        return null;
    }

    public function getMaxId(): int
    {
        try {
            $query = "SELECT MAX(ID) as max_id FROM PHIEUNHAP";
            $rs = database_connection::executeQuery($query);
            if ($rs && $rs->num_rows > 0) {
                $row = $rs->fetch_assoc();
                return (int)$row['max_id'];
            }
            return 0;
        } catch (\Exception $e) {
            error_log("Error getting max ID: " . $e->getMessage());
            return 0;
        }
    }

    public function populationChiTietPhieuNhaps($phieuNhap) {
        $chiTietPhieuNhaps = $this->ctpnDAO->getByPhieuNhapId($phieuNhap->getId());
        $phieuNhap->setChiTietPhieuNhaps($chiTietPhieuNhaps);
        return $phieuNhap;
    }
}
?>