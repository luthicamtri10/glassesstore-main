<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
include 'connect.blade.php';

if (isset($_POST['dangky'])) {

    $email = $_POST['email-regis'];
    $password = $_POST['password-regis'];
    $username = $_POST['tenTk-regis'];
    $hashed_password = md5($password); // Mã hóa mật khẩu

    // Kiểm tra xem email đã tồn tại chưa
    $checkEmailQuery = "SELECT * FROM taikhoan WHERE EMAIL = ?";
    $stmt = $conn->prepare($checkEmailQuery);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        echo "Email đã tồn tại!";
    } else {
        // ✅ Chèn dữ liệu vào bảng nguoidung với các giá trị NULL
        $insertUserQuery = "INSERT INTO nguoidung (HOTEN, IDTINH, TRANGTHAIHD, NGAYSINH, GIOITINH, SODIENTHOAI, CCCD, DIACHI) 
                            VALUES (?, NULL, 1, NULL, NULL, NULL, NULL, NULL)";
        
        $stmt = $conn->prepare($insertUserQuery);
        $stmt->bind_param("s", $username);
    
        if ($stmt->execute()) {
            $userId = $conn->insert_id; // Lấy ID người dùng vừa tạo
    
            // ✅ Chèn dữ liệu vào bảng taikhoan
            $insertAccountQuery = "INSERT INTO taikhoan (TENTK, EMAIL, PASSWORD, IDNGUOIDUNG, IDQUYEN, TRANGTHAIHD)
                                   VALUES (?, ?, ?, ?, 3, 1)";
            
            $stmt = $conn->prepare($insertAccountQuery);
            $stmt->bind_param("sssi", $username, $email, $hashed_password, $userId);
    
            if ($stmt->execute()) {
                echo "Đăng ký thành công! Đang chuyển hướng...";
                header("refresh:2; url=Login-Register.blade.php");
                exit();
            } else {
                die("Lỗi khi tạo tài khoản: " . $conn->error);
            }
        } else {
            die("Lỗi khi thêm người dùng: " . $conn->error);
        }
    }
    
    
    
}
if(isset($_POST['dangnhap'])){

    $email = $_POST['email-Login'];
    $password = $_POST['password-Login'];
    $password = md5($password);

    $sql = "SELECT * FROM taikhoan WHERE EMAIL = '$email' AND PASSWORD = '$password'";
    $result = $conn->query($sql);
    if($result->num_rows>0){
        session_start();
        $row = $result->fetch_assoc();
        $_SESSION['EMAIL'] = $row['EMAIL'];
        header("location: AcctInfoOH.blade.php");
        exit();
    }else{
        echo"không đúng";
    }

}

?>