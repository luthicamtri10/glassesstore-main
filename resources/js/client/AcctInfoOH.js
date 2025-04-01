const mainContent = document.querySelector(".main-content")
const listProduct = document.querySelector("#list-product")
const informationAccount = document.querySelector("#information-account")
const infomationLocation = document.querySelector("#infomation-location")
const logout = document.querySelector("#logout")

listProduct.addEventListener("click", () => {
    mainContent.innerHTML = `
        <div class="top-buttons">
            <div class="circle-btn-container active">
                <div class="circle-btn">
                    <span class="icon">🛒</span>
                    <span class="count">0</span>
                </div>
                <p>Sản phẩm đã mua</p>
            </div>
            <div class="circle-btn-container">
                <div class="circle-btn">
                    <span class="icon">❤️</span>
                    <span class="count">0</span>
                </div>
                <p>Sản phẩm yêu thích</p>
            </div>
        </div>

        <!-- Purchase History Table -->
        <div class="purchase-history">
            <h3>Sản phẩm đã mua</h3>
            <table>
                <thead>
                    <tr>
                        <th>Mã đơn hàng</th>
                        <th>Số lượng</th>
                        <th>Trạng thái</th>
                        <th>Ngày tạo</th>
                        <th>Tầng</th>
                        <th>Thao tác</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td colspan="6" style="text-align: center;">Chưa có đơn hàng</td>
                    </tr>
                </tbody>
            </table>
        </div>
    
    `
})

informationAccount.addEventListener("click", () => {
    mainContent.innerHTML = `
        <div class="info-acc-ctn">
            <div class ="info-acc-left">
                <h3>Thông tin tài khoản</h3>
                <div class="form-group">
                    <label for="exampleFormControlInput1" class="form-label">Tên</label>
                    <input type="email" class="form-control" id="exampleFormControlInput1" placeholder="Nhập Tên">
                </div>
                <div class="form-group">
                    <label for="exampleFormControlInput1" class="form-label">Họ</label>
                    <input type="email" class="form-control" id="exampleFormControlInput1" placeholder="Nhập Họ">
                </div>
                <div class="form-group">
                    <label for="exampleFormControlInput1" class="form-label">Tên hiển thị</label>
                    <input type="email" class="form-control" id="exampleFormControlInput1" placeholder="Nhập Tên hiển thị">
                </div>
                <div class="form-group">
                    <label for="exampleFormControlInput1" class="form-label">Địa chỉ Email</label>
                    <input type="email" class="form-control" id="exampleFormControlInput1" placeholder="Nhập địa chỉ Email">
                </div>
                <div class="form-group">
                    <label for="exampleFormControlInput1" class="form-label">Số điện thoại</label>
                    <input type="email" class="form-control" id="exampleFormControlInput1" placeholder="Nhập Số điện thoại">
                </div>
            
            </div>

            <div class ="info-acc-right">
                <div class="avt-change"><img src="./img/itxt1.jpeg" alt="Avatar"></div>
                <div class="form-group">
                    <label for="exampleFormControlInput1" class="form-label">Mật khẩu hiện tại</label>
                    <input type="email" class="form-control" id="exampleFormControlInput1" placeholder="Nhập Mật khẩu hiện tại">
                </div>
                <div class="form-group">
                    <label for="exampleFormControlInput1" class="form-label">Mật khẩu mới</label>
                    <input type="email" class="form-control" id="exampleFormControlInput1" placeholder="Nhập Mật khẩu mới">
                </div>
                 
                 <div class="form-group">
                    <label for="exampleFormControlInput1" class="form-label">Nhập lại mật khẩu mới</label>
                    <input type="email" class="form-control" id="exampleFormControlInput1" placeholder="Nhập lại mật khẩu mới">
                </div>
                <div class="control-btn">
                    <button>Hủy</button>
                    <button>Lưu thay đổi</button>
                </div>
            </div>

        </div>
    
    `
})
infomationLocation.addEventListener("click", () => {
    mainContent.innerHTML = `
        <div class="info-loc-ctn">
             <div class="ship-adress">
                <h3>Thông tin địa chỉ giao hàng</h3>
                <table>
                    <thead>
                        <tr>
                            <th>Stt</th>
                            <th>Tỉnh/Thành Phố</th>
                            <th>Huyện/Quận</th>
                            <th>Xã/Phường</th>
                            <th>Thôn/Đường</th>
                            <th>Trạng thái</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td colspan="6" style="text-align: center;">Chưa có địa chỉ</td>
                        </tr>
                    </tbody>
                </table>
                <div class="add-adress control-btn"><button type ="button">Thêm địa chỉ</button></div>
            </div>
        </div>
    
    `
    const addAdress = document.querySelector(".add-adress")
    addAdress.addEventListener('click',() =>{
        mainContent.innerHTML = `
        <div class="info-loc-ctn">
             <div class="ship-adress">
                <h3>Thông tin địa chỉ giao hàng</h3>
                <div class="form-group">
                    <label for="exampleFormControlInput1" class="form-label">Nhập Tỉnh/Thành Phố</label>
                    <input type="email" class="form-control" id="exampleFormControlInput1" placeholder="Nhập Tỉnh/Thành Phố">
                </div>
                <div class="form-group">
                    <label for="exampleFormControlInput1" class="form-label">Nhập Huyện/Quận</label>
                    <input type="email" class="form-control" id="exampleFormControlInput1" placeholder="Nhập Huyện/Quận">
                </div>
                <div class="form-group">
                    <label for="exampleFormControlInput1" class="form-label">Nhập Xã/Phường</label>
                    <input type="email" class="form-control" id="exampleFormControlInput1" placeholder="Nhập Xã/Phường">
                </div>
                <div class="form-group">
                    <label for="exampleFormControlInput1" class="form-label">Nhập Thôn/Đường</label>
                    <input type="email" class="form-control" id="exampleFormControlInput1" placeholder="Nhập Thôn/Đường">
                </div>
                <div class="form-group">
                    <label for="exampleFormControlInput1" class="form-label">Trạng thái</label>
                    <input type="email" class="form-control" id="exampleFormControlInput1" placeholder="Nhập Thôn/Đường">
                </div>
                <div class="add-adress control-btn"><button type ="button">Thêm địa chỉ</button></div>
            </div>
        </div>
    
    `

    })
})