const contenRight = document.querySelector(".content-right")
const contenLeft = document.querySelector(".content-left")

function registerLink(){
    contenRight.style.transform = "translateX(-100%)"
    contenLeft.style.transform = "translateX(100%)"
    contenLeft.innerHTML = `
        <img src="./img/img-register.jpeg" class="w-100 img-fluid  p-auto" alt="" style="border-radius: 30px;overflow: hidden;">
    `
    contenRight.innerHTML = `
        <div style="width:80%;margin:0 auto;display: block;text-align: center;">
            <h1>ĐĂNG KÝ</h1>
            <p>Hãy đăng ký để được hưởng những đặc quyền dành cho riêng bạn</p>
            <div class="form-group">
                <label for="exampleFormControlInput1" class="form-label">Địa chỉ Email</label>
                <input type="email" class="form-control" id="exampleFormControlInput1" placeholder="Nhập địa chỉ Email">
            </div>
            <div class="form-group">
                <label for="inputPassword5" class="form-label">Mật khẩu</label>
                <input type="password" id="inputPassword5" class="form-control" aria-describedby="passwordHelpBlock" placeholder="Nhập mật khẩu">
                <div id="passwordHelpBlock" class="form-text text-start">
                    Mật khẩu của bạn phải dài từ 8-20 ký tự, chứa chữ và số và không chứa khoảng trắng, ký tự đặc biệt hoặc biểu tượng cảm xúc.
                </div>
            </div>
            <p>Thông tin của bạn sẽ được bảo mật theo chính sách riêng tư của chúng tôi</p>
            <div class="form-check">
                <input class="form-check-input" type="checkbox" value="" id="defaultCheck1">
                <label class="form-check-label" for="defaultCheck1">
                    Đồng ý với chính sách của chúng tôi
                </label>
            </div>
            <button type="submit" class="w-100">Đăng ký ngay</button>
            <p>Bạn đã có tài khoản? <a href="#"  class="link-login" onclick="loginLink()">Đăng nhập ngay</a></p>
        </div>
    `
}

function loginLink(){
    contenRight.style.transform = "translateX(0%)"
    contenLeft.style.transform = "translateX(0%)"
    contenLeft.innerHTML = `
        <img src="./img/img-login.jpeg" class="w-100 img-fluid  p-auto" alt="" style="border-radius: 30px;overflow: hidden;">
    `
    contenRight.innerHTML = `
        <div style="width:80%;margin:0 auto;display: block;text-align: center;">
            <h1>ĐĂNG NHẬP</h1>
            <p>Hãy đăng nhập để được hưởng những đặc quyền dành cho riêng bạn</p>
            <div class="form-group">
                <label for="exampleFormControlInput1" class="form-label">Địa chỉ Email</label>
                <input type="email" class="form-control" id="exampleFormControlInput1" placeholder="Nhập địa chỉ Email">
            </div>
            <div class="form-group">
                <label for="inputPassword5" class="form-label">Mật khẩu</label>
                <input type="password" id="inputPassword5" class="form-control" aria-describedby="passwordHelpBlock" placeholder="Nhập mật khẩu">
                <div id="passwordHelpBlock" class="form-text text-start">
                    Mật khẩu của bạn phải dài từ 8-20 ký tự, chứa chữ và số và không chứa khoảng trắng, ký tự đặc biệt hoặc biểu tượng cảm xúc.
                </div>
            </div>
            <div class="form-check">
                <input class="form-check-input" type="checkbox" value="" id="defaultCheck1">
                <label class="form-check-label" for="defaultCheck1">
                    Ghi nhớ đăng nhập
                </label>
            </div>
            <button type="submit" class="w-100">Đăng nhập ngay</button>
            <p class="text-start my-4"><a href="#">Quên mật khẩu?</a></p>
            <p>Bạn chưa có tài khoản? <a href="#"  class="link-register" onclick="registerLink()       ">Đăng ký ngay</a></p>
        </div>
    `
}