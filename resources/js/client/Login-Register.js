const contenRight = document.querySelector(".content-right")
const contenLeft = document.querySelector(".content-left")

function registerLink(){
    contenRight.style.transform = "translateX(-100%)"
    contenLeft.style.transform = "translateX(100%)"
    contenLeft.innerHTML = `
        <img src="./img/img-register.jpeg" class="w-100 img-fluid  p-auto" alt="" style="border-radius: 30px;overflow: hidden;">
    `
    contenRight.innerHTML = `
        <form style="width:80%;margin:0 auto;display: block;text-align: center;" method="POST" action="process_login.blade.php">
            <h1>ĐĂNG KÝ</h1>
            <p>Hãy đăng ký để được hưởng những đặc quyền dành cho riêng bạn</p>
            <div class="form-group">
                <label for="tenTK-regis" class="form-label">Tên tài khoản</label>
                <input type="text" class="form-control" id="tenTk-regis" name="tenTk-regis" placeholder="Nhập địa Tên tài khoản">
            </div>
            <div class="form-group">
                <label for="email-regis" class="form-label">Địa chỉ Email</label>
                <input type="email" class="form-control" id="email-regis" name="email-regis" placeholder="Nhập địa chỉ Email">
            </div>
            <div class="form-group">
                <label for="password-regis" class="form-label">Mật khẩu</label>
                <input type="password" id="password-regis" name="password-regis" class="form-control" aria-describedby="passwordHelpBlock" placeholder="Nhập mật khẩu">
                <div id="passwordHelpBlock" class="form-text text-start">
                    Mật khẩu của bạn phải dài từ 8-20 ký tự, chứa chữ và số và không chứa khoảng trắng, ký tự đặc biệt hoặc biểu tượng cảm xúc.
                </div>
            </div>
            <p>Thông tin của bạn sẽ được bảo mật theo chính sách riêng tư của chúng tôi</p>
            <div class="form-check">
                <input class="form-check-input" type="checkbox" value="Đồng ý với chính sách của chúng tôi" id="condition-Regis">
                <label class="form-check-label" for="condition-Regis">
                    
                </label>
            </div>
            <button type="submit" class="w-100" name="dangky">Đăng ký ngay</button>
            <p>Bạn đã có tài khoản? <a href="#"  class="link-login" onclick="loginLink()">Đăng nhập ngay</a></p>
        </form>
    `
}

function loginLink(){
    contenRight.style.transform = "translateX(0%)"
    contenLeft.style.transform = "translateX(0%)"
    contenLeft.innerHTML = `
        <img src="./img/img-login.jpeg" class="w-100 img-fluid  p-auto" alt="" style="border-radius: 30px;overflow: hidden;">
    `
    contenRight.innerHTML = `
        <form style="width:80%;margin:0 auto;display: block;text-align: center;" method="POST" action="process_login.blade.php">
            <h1>ĐĂNG NHẬP</h1>
            <p>Hãy đăng nhập để được hưởng những đặc quyền dành cho riêng bạn</p>
            <div class="form-group">
                <label for="email-login" class="form-label">Địa chỉ Email</label>
                <input type="email" class="form-control" id="email-login" name="email-login" placeholder="Nhập địa chỉ Email">
            </div>
            <div class="form-group">
                <label for="password-login" class="form-label">Mật khẩu</label>
                <input type="password" id="password-login" name="password-login" class="form-control" aria-describedby="passwordHelpBlock" placeholder="Nhập mật khẩu">
                <div id="passwordHelpBlock" class="form-text text-start">
                    Mật khẩu của bạn phải dài từ 8-20 ký tự, chứa chữ và số và không chứa khoảng trắng, ký tự đặc biệt hoặc biểu tượng cảm xúc.
                </div>
            </div>
            <div class="form-check">
                <input class="form-check-input" type="checkbox" value="" id="condition-Login">
                <label class="form-check-label" for="condition-Login">
                    Ghi nhớ đăng nhập
                </label>
            </div>
            <button type="submit" class="w-100" name="dangnhap"> Đăng nhập ngay</button>
            <p class="text-start my-4"><a href="#">Quên mật khẩu?</a></p>
            <p>Bạn chưa có tài khoản? <a href="#"  class="link-register" onclick="registerLink()       ">Đăng ký ngay</a></p>
        </form>
    `
}