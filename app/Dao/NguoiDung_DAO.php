<?php
namespace App\Dao;

use App\Bus\Tinh_BUS;
use App\Enum\GioiTinhEnum;
use App\Interface\DAOInterface;
use App\Models\NguoiDung;
use App\Services\database_connection;
use Illuminate\Support\Arr;
use InvalidArgumentException;
use PhpParser\Node\Expr\List_;

use function Laravel\Prompts\error;

class NguoiDung_DAO implements DAOInterface {
    private static $instance;
    private $tinhBUS;
    public static function getInstance()
    {
        if(self::$instance == null) {
            self::$instance = new NguoiDung_DAO();
        }
        return self::$instance;
    }
    public function __construct()
    {
        $this->tinhBUS = new Tinh_BUS();
    }
    public function readDatabase(): array
    {
        $list = [];
        $rs = database_connection::executeQuery("SELECT * FROM NGUOIDUNG");
        while($row = $rs->fetch_assoc()) {
            $model = $this->createNguoiDungModel($row);
            $list[] = $model;
        }
        return $list;
    }
    public function createNguoiDungModel($rs): NguoiDung {
        $gioiTinh = $rs['GIOITINH'];
        switch($gioiTinh) {
            case 'MALE':
                $gioiTinh = GioiTinhEnum::MALE;
                break;
            case 'FEMALE':
                $gioiTinh = GioiTinhEnum::FEMALE;
                break;
            case 'UNDEFINED':
                $gioiTinh = GioiTinhEnum::UNDEFINED;
                break;
            default:
                error("Can not create NGUOIDUNG model");
                break;
        }
        $tinh = $this->tinhBUS->getModelById($rs['IDTINH']);
        return new NguoiDung(
            $rs['ID'],
            $rs['HOTEN'],
            $rs['NGAYSINH'],
            $gioiTinh,
            $rs['DIACHI'],
            $tinh,
            $rs['SODIENTHOAI'],
            $rs['CCCD'],
            $rs['TRANGTHAIHD']
        );
    }
    public function getAll() : array{
        $list = [];
        $rs = database_connection::executeQuery("SELECT * FROM NGUOIDUNG");
        while($row = $rs->fetch_assoc()) {
            $model = $this->createNguoiDungModel($row);
            array_push($list, $model);
        }
        return $list;
    }
    public function getById($id) {
        $query = "SELECT * FROM NGUOIDUNG WHERE id = ?";
        $result = database_connection::executeQuery($query, $id);
        if($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            if($row) {
                return $this->createNguoiDungModel($row);
            }
        }
        return null;
    }
    public function insert($e): int
    {
        $query = "INSERT INTO NGUOIDUNG (ID, HOTEN, NGAYSINH, GIOITINH, DIACHI, IDTINH, SODIENTHOAI, CCCD, TRANGTHAIHD) VALUES (?,?,?,?,?,?,?,?,?)";
        $args = [$e->getId(), $e->getHoTen(), $e->getNgaySinh(), $e->getGioiTinh(), $e->getDiaChi(), $e->getTinh()->getId(), $e->getSoDienThoai(), $e->getCccd(), $e->getTrangThaiHD()];
        $rs = database_connection::executeQuery($query, ...$args);
        return is_int($rs) ? $rs : 0;
    }
    public function update($e): int
    {
        $query = "UPDATE NGUOIDUNG SET HOTEN = ?, NGAYSINH = ?, GIOITINH = ?, DIACHI = ?, IDTINH = ?, SODIENTHOAI = ?, CCCD = ?, TRANGTHAIHD = ? WHERE ID = ?";
        $args = [$e->getHoTen(), $e->getNgaySinh(), $e->getGioiTinh(), $e->getDiaChi(), $e->getTinh()->getId(), $e->getSoDienThoai(), $e->getCccd(), $e->getTrangThaiHD(), $e->getId()];
        $rs = database_connection::executeUpdate($query, ...$args);
        return is_int($rs) ? $rs : 0;
    }
    public function delete(int $id): int
    {
        $query = "UPDATE NGUOIDUNG SET TRANGTHAIHD = FALSE WHERE ID = ?";
        $rs = database_connection::executeUpdate($query, $id);
        return is_int($rs) ? $rs : 0;
    }
    public function search(string $condition, array $columnNames): array
    {
        if (empty($condition)) {
            throw new InvalidArgumentException("Search condition cannot be empty or null");
        }
        $query = "";
        if ($columnNames === null || count($columnNames) === 0) {
            $query = "SELECT * FROM NGUOIDUNG WHERE id LIKE ? OR HOTEN LIKE ? OR NGAYSINH LIKE ? OR GIOITINH LIKE ? OR DIACHI LIKE ? OR IDTINH LIKE ? OR SODIENTHOAI LIKE ? OR CCCD LIKE ? OR TRANGTHAIHD LIKE ?";
            $args = array_fill(0, 9, "%" . $condition . "%");
        } else if (count($columnNames) === 1) {
            $column = $columnNames[0];
            $query = "SELECT * FROM NGUOIDUNG WHERE $column LIKE ?";
            $args = ["%" . $condition . "%"];
        } else {
            $query = "SELECT * FROM NGUOIDUNG WHERE " . implode(" LIKE ? OR ", $columnNames) . " LIKE ?";
            $args = array_fill(0, count($columnNames), "%" . $condition . "%");
        }
        $rs = database_connection::executeQuery($query, ...$args);
        $list = [];
        while ($row = $rs->fetch_assoc()) {
            $model = $this->createNguoiDungModel($row);
            array_push($list, $model);
        }
        if (count($list) === 0) {
            return [];
        }
        return $list;
    }
}
?>