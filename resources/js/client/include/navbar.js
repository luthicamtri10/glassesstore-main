const itemSanPham = document.querySelector('#item-sanpham');
const itemXemThem = document.querySelector('#item-xemthem');
const itemGioHang = document.querySelector('#item-giohang');
const submenu = document.querySelector('.submenu');

itemSanPham.addEventListener('mouseenter', () => {
    setTimeout(() => {
        submenu.style.width = "80%"
        submenu.style.transform = "translateX(-50%)"
        submenu.innerHTML = `
            <div class="card-menu d-flex " style="position:relative">
                <i class="fa-solid fa-caret-up" style="position:absolute; color:#55d5d2; left:10%;top:-35px;font-size:70px"></i>

                <div class="card-menu-right w-25">
                    <ul class="list-gr text-white">
                    <li class="px-4 py-4 d-flex justify-content-between gongkinh"><div>GỌNG KÍNH</div> <i class="fa-solid fa-arrow-right"></i></li>
                    <li class="px-4 py-4 d-flex justify-content-between trongkinh"><div>TRÒNG KÍNH</div> <i class="fa-solid fa-arrow-right"></i></li>
                    <li class="px-4 py-4 d-flex justify-content-between kinhram"><div>KÍNH RÂM</div> <i class="fa-solid fa-arrow-right"></i></li>
                    <li class="px-4 py-4 d-flex justify-content-between kinhtreem"><div>KÍNH TRẺ EM</div> <i class="fa-solid fa-arrow-right"></i></li>
                    </ul>
                </div>
                <div class="card-menu-left w-75 px-4 py-4 d-flex justify-content-between" >
                    <div class="card-menu-left-content d-flex fw-medium w-50"></div>
                    <div class="card-menu-left-img " style="width: 300px;height: 300px;overflow: hidden;">
                    <img src="../../views/client/img/itemsanpham.jpeg" style="transform: translateY(-20%);">
                    
                    </div>
                </div>
            </div>
        
        `

        submenu.style.visibility = 'visible';
        submenu.style.opacity = '1';
        const content = document.querySelector('.card-menu-left-content')
        const gongkinh = document.querySelector('.gongkinh')
        const trongkinh = document.querySelector('.trongkinh')
        const kinhram = document.querySelector('.kinhram')
        const kinhtreem = document.querySelector('.kinhtreem')
        gongkinh.addEventListener('mouseenter', () => {
            content.innerHTML = `
                <ul class='w-50'>
                    <h5>CHẤT LIỆU</h5>
                    <li style="font-size:18px;margin-bottom:5px;cursor: pointer;">Kim loại</li>
                    <li style="font-size:18px;margin-bottom:5px;cursor: pointer;">Nhựa</li>
                </ul>
                <ul class='w-50'>
                    <h5>KIỂU DÁNG</h5>
                    <li style="font-size:18px;margin-bottom:5px;cursor: pointer;">Mắt mèo</li>
                    <li style="font-size:18px;margin-bottom:5px;cursor: pointer;">Vuông</li>
                </ul>
            `
        })
        content.addEventListener('mouseleave', () => {
            content.innerHTML = ``
        });
        trongkinh.addEventListener('mouseenter', () => {
            content.innerHTML = ``

        })
        kinhram.addEventListener('mouseenter', () => {
            content.innerHTML = ``

        })
        kinhtreem.addEventListener('mouseenter', () => {
            content.innerHTML = ``

        })
    }, 300);

});

itemSanPham.addEventListener('mouseleave', () => {
    setTimeout(() => {
        if (!submenu.matches(':hover')) {
            submenu.style.visibility = 'hidden';
            submenu.style.opacity = '0';
        }
    }, 200);
});

submenu.addEventListener('mouseleave', () => {
    submenu.style.visibility = 'hidden';
    submenu.style.opacity = '0';
});

itemXemThem.addEventListener('mouseenter', () => {
    setTimeout(() => {
        submenu.style.width = "80%"
        submenu.style.transform = "translateX(-50%)"
        submenu.innerHTML = `
            <div class="card-menu d-flex " style="position:relative">
                <i class="fa-solid fa-caret-up" style="position:absolute; color:#ffff; right:32%;top:-35px;font-size:70px"></i>
                <div class="card-menu-right w-25">
                    <ul class="list-gr text-white">
                    <li class="px-4 py-4 d-flex justify-content-between chonkinh"><div>CHỌN KÍNH THEO MẶT</div> <i class="fa-solid fa-arrow-right"></i></li>
                    <li class="px-4 py-4 d-flex justify-content-between vechungtoi"><div>VỀ CHÚNG TÔI</div> <i class="fa-solid fa-arrow-right"></i></li>
                    <li class="px-4 py-4 d-flex justify-content-between blog"><div>BLOG</div> <i class="fa-solid fa-arrow-right"></i></li>
                    </ul>
                </div>
                <div class="card-menu-left w-75 px-4 py-4 d-flex gap-2 align-items-center justify-content-center" >
                    <div class="itxt" style="width: 280px;height: 280px;overflow: hidden;border-radius:15px;position:relative">
                        <img src="../../views/client/img/itxt1.jpeg" style="width: 280px;height: 280px;">
                        <div class="d-flex  fw-medium itxt-div" style="color:white;white-space: nowrap;;background-color:#55d5d2;position:absolute;bottom:10px;left:50%;transform: translateX(-50%);font-size:12px;padding:10px 5px 10px 5px;border-radius:40px;"><div class="d-flex align-items-center justify-content-center">CHỌN KÍNH THEO KHUÔN MẶT</div> <i class="fa-solid fa-arrow-up-right d-flex align-items-center justify-content-center" style="background-color:white;color:#55d5d2;height:30px;width:30px;border-radius:50%;margin-left:5px"></i></div>
                    </div>
                    <div class="itxt" style="width: 280px;height: 280px;overflow: hidden;border-radius:15px;position:relative">
                        <img src="../../views/client/img/itxt2.jpeg" style="width: 280px;height: 280px;">
                        <div class="d-flex  fw-medium itxt-div" style="color:white;white-space: nowrap;;background-color:#55d5d2;position:absolute;bottom:10px;left:50%;transform: translateX(-50%);font-size:12px;padding:10px 5px 10px 5px;border-radius:40px;"><div class="d-flex align-items-center justify-content-center">CÁCH ĐO KHUNG KÍNH</div> <i class="fa-solid fa-arrow-up-right d-flex align-items-center justify-content-center" style="background-color:white;color:#55d5d2;height:30px;width:30px;border-radius:50%;margin-left:5px"></i></div>
                    </div>
                    <div class="itxt" style="width: 280px;height: 280px;overflow: hidden;border-radius:15px;position:relative">
                        <img src="../../views/client/img/itxt3.jpeg" style="width: 280px;height: 280px;">
                        <div class="d-flex  fw-medium itxt-div" style="color:white;white-space: nowrap;;background-color:#55d5d2;position:absolute;bottom:10px;left:50%;transform: translateX(-50%);font-size:12px;padding:10px 5px 10px 5px;border-radius:40px;"><div class="d-flex align-items-center justify-content-center">CÁCH ĐO ỐNG KÍNH</div> <i class="fa-solid fa-arrow-up-right d-flex align-items-center justify-content-center" style="background-color:white;color:#55d5d2;height:30px;width:30px;border-radius:50%;margin-left:5px"></i></div>
                    </div>
                </div>
            </div>
        
        `

        submenu.style.visibility = 'visible';
        submenu.style.opacity = '1';
        const itxt = document.querySelectorAll('.itxt');
        itxt.forEach(element => {
            itxt.forEach(element => {
                element.addEventListener('mouseenter', () => {
                    const icon = element.querySelector('i');
                    const div = element.querySelector('.itxt-div');
                    icon.style.transition = 'transform 0.4s ease';
                    icon.style.fontSize = "15px"
                    icon.style.transform = 'rotate(45deg)';
                    div.style.backgroundColor = "#fb923c"
                });
                element.addEventListener('mouseleave', () => {
                    const icon = element.querySelector('i');
                    const div = element.querySelector('.itxt-div');
                    icon.style.transform = 'rotate(0deg)';
                    div.style.backgroundColor = "#55d5d2"

                });
            });

        });
    }, 300);

});

// Lấy navbar
const navbar = document.querySelector('#navbar-ctn');
let lastScrollY = window.scrollY;
window.addEventListener('scroll', () => {
    const currentScrollY = window.scrollY;
    if (currentScrollY > lastScrollY) {
        navbar.style.transform = "translateY(-110%)";
    } else {
        navbar.style.transform = "translateY(0%)";
    }

    lastScrollY = currentScrollY;
});
itemGioHang.addEventListener('mouseenter', () => {
    setTimeout(() => {
        submenu.style.width = "25%"
        submenu.style.transform = "translateX(70%)"


        submenu.innerHTML = `
            <div class="card-menu d-flex " style="position:relative;width:100%;">
                <div class="card" style="width: 100%;">
                <div class="card-body" >
                    <h5 class="card-title">Giỏ Hàng</h5>
                    <h6 class="card-subtitle mb-2 text-body-secondary">Số lượng: <small style="padding:1px 4px;background:#55d5d2;border-radius:50%;color:white">0</small></h6>
                    <ul class="product-list-cart">
                        <li class="item-product-cart">
                            <div class="left">
                                <img src="../../views/client/img/itemsanpham.jpeg" class="img-fluid">
                            </div>
                            <div class="center">
                            <small>Mắt kính</small>
                            <p>tên sản phẩm sdnguv bưg</p>
                            <p class="quantity-price">2 X 400000</p>
                            </div>
                            <div class="right">
                            x
                            </div>
                        
                        </li>
                        <li class="item-product-cart">
                            <div class="left">
                                <img src="../../views/client/img/itemsanpham.jpeg" class="img-fluid">
                            </div>
                            <div class="center">
                            <small>Mắt kính</small>
                            <p>tên sản phẩm sdnguv bưg</p>
                            <p class="quantity-price">2 X 400000</p>
                            </div>
                            <div class="right">
                            x
                            </div>
                        
                        </li>
                        <li class="item-product-cart">
                            <div class="left">
                                <img src="../../views/client/img/itemsanpham.jpeg" class="img-fluid">
                            </div>
                            <div class="center">
                            <small>Gọng kính</small>
                            <p>tên sản phẩm sdnguv bưg</p>
                            <p class="quantity-price">2 X 400000</p>
                            </div>
                            <div class="right">
                            x
                            </div>
                        
                        </li>
                        <li class="item-product-cart">
                            <div class="left">
                                <img src="../../views/client/img/itemsanpham.jpeg" class="img-fluid">
                            </div>
                            <div class="center">
                            <small>Mắt kính</small>
                            <p>tên sản phẩm sdnguv bưg</p>
                            <p class="quantity-price">2 X 400000</p>
                            </div>
                            <div class="right">
                            x
                            </div>
                        
                        </li>
                        <li class="item-product-cart">
                            <div class="left">
                                <img src="../../views/client/img/itemsanpham.jpeg" class="img-fluid">
                            </div>
                            <div class="center">
                            <small>Mắt kính</small>
                            <p>tên sản phẩm sdnguv bưg</p>
                            <p class="quantity-price">2 X 400000</p>
                            </div>
                            <div class="right">
                            x
                            </div>
                        
                        </li>
                    </ul>
                    <div class="d-flex  fw-medium itgh-div" style="width:50%;color:white;white-space: nowrap;background-color:#55d5d2;font-size:16px;padding:5px 5px 5px 5px;border-radius:40px;"><div class="d-flex align-items-center justify-content-center">Thanh toán ngay</div> <i class="fa-solid fa-arrow-up-right d-flex align-items-center justify-content-center" style="background-color:white;color:#55d5d2;height:30px;width:30px;border-radius:50%;margin-left:5px"></i></div>
                </div>
                </div>
                
            </div>
        
        `

        submenu.style.visibility = 'visible';
        submenu.style.opacity = '1';
        const itgh = document.querySelector(".itgh-div")

        itgh.addEventListener('mouseenter', () => {
                const icon = itgh.querySelector('i');
                const div = itgh.querySelector('.itxt-div');
                icon.style.transition = 'transform 0.4s ease';
                icon.style.fontSize = "15px"
                icon.style.transform = 'rotate(45deg)';
                itgh.style.backgroundColor = "#fb923c"
            });
            itgh.addEventListener('mouseleave', () => {
                const icon = itgh.querySelector('i');
                icon.style.transform = 'rotate(0deg)';
                itgh.style.backgroundColor = "#55d5d2"

            });
        

    }, 300);

});