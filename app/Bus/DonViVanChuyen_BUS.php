<?php
namespace App\Bus;

use App\Dao\DVVC_DAO;
use App\Interface\BUSInterface;
use PhpParser\Node\Stmt\Echo_;

use function Laravel\Prompts\error;

class DonViVanChuyen_BUS implements BUSInterface {
    private $ChucNangDVVCList = array();
    private $StaticList = array();
    private static $instance;

    public static function getInstance() {
        if (self::$instance == null) {
            self::$instance = new DonViVanChuyen_BUS();
        }
        return self::$instance;
    }

    public function __construct() {
        $this->refreshData();
    }

    public function refreshData(): void {
        $this->ChucNangDVVCList = DVVC_DAO::getInstance()->getAll();
    }

    public function getAllModels(): array {
        return $this->ChucNangDVVCList;
    }

    public function getModelById(int $id) {
        return DVVC_DAO::getInstance()->getById($id);
    }

    public function addModel($model) {
        if ($model == null) {
            error("Error when adding a ChucNangDVVC");
            return;
        }
        return DVVC_DAO::getInstance()->insert($model);
    }

    public function updateModel($model) {
        if ($model == null) {
            error("Error when updating a ChucNangDVVC");
            return;
        }
        return DVVC_DAO::getInstance()->update($model);
    }

    public function deleteModel(int $id) {
        if ($id == null || $id == "") {
            error("Error when deleting a ChucNangDVVC");
            return;
        }
        return DVVC_DAO::getInstance()->delete($id);
    }

    public function searchModel(string $value, array $columns) {
        $list = DVVC_DAO::getInstance()->search($value, $columns);
        if (count($list) > 0) {
            return $list;
        } else {
            echo "Not found";
        }
        return null;
    }
}
?>
