// Sidebar Toggle
const hamburger = document.querySelector(".toggle-btn");
const toggler = document.querySelector("#icon");
// hamburger.addEventListener("click", function() {
//     document.querySelector("#sidebar").classList.toggle("expand");
//     toggler.classList.toggle("bx-chevrons-right");
//     toggler.classList.toggle("bx-chevrons-left");
// });

document.addEventListener('DOMContentLoaded', function() {
    const content = document.getElementById('content');
    let sidebarLinks = document.querySelectorAll('.sidebar-link'); // Lưu ý: Lấy 1 lần

    const mainContent = document.getElementById('main-content');
    if (mainContent) {
        fetch('/login', {
            headers: { 'X-Requested-With': 'XMLHttpRequest' }
        })
        .then(res => res.text())
        .then(html => {
            mainContent.innerHTML = html;
        });
    }
    // Hàm xử lý tải nội dung
    function loadContent(href, replaceState = true) {
        if (!href || href === "null" || href.trim() === "") {
            console.error('URL không hợp lệ:', href);
            return;
        }

        // Đổi URL trên thanh địa chỉ mà không cần reload
        if (replaceState) {
            history.pushState(null, '', href);
        }
    
        // Hiển thị loading
        content.innerHTML = `
            <div class="text-center p-5">
                <div class="spinner-border" role="status">
                    <span class="visually-hidden">Đang tải...</span>
                </div>
            </div>
        `;

        // Load nội dung bằng AJAX
        fetch(href, {
            headers: {
                'X-Requested-With': 'XMLHttpRequest'
            }
        })
        .then(response => {
            if (!response.ok) {
                throw new Error('Không thể tải nội dung');
            }
            return response.text();
        })
        .then(data => {
            content.innerHTML = data;
            // Gắn lại sự kiện sau khi load nội dung
            attachSidebarEvents();
        })
        .catch(error => {
            console.error('Lỗi:', error);
            content.innerHTML = `
                <div class="alert alert-danger">
                    Không thể tải nội dung. Vui lòng thử lại.
                    <br>Chi tiết: ${error.message}
                </div>
            `;
        });
    }

    // Hàm gắn sự kiện cho sidebar-links (Chỉ gắn 1 lần)
    function attachSidebarEvents() {
        sidebarLinks = document.querySelectorAll('.sidebar-link');
        sidebarLinks.forEach(link => {
            link.removeEventListener('click', handleSidebarClick); // Xóa sự kiện cũ (nếu có)
            link.addEventListener('click', handleSidebarClick);
        });
    }

    // Hàm xử lý khi click vào sidebar-link
    function handleSidebarClick(event) {
        event.preventDefault();
        const href = this.getAttribute('href');
        console.log('Clicked URL:', href);
        loadContent(href);
    }

    // Gắn sự kiện lần đầu tiên
    attachSidebarEvents();

    // Kiểm tra URL hiện tại khi load trang
    const currentPath = window.location.pathname;
    console.log('Current Path:', currentPath);
    loadContent(currentPath, false); // Không thay đổi state vì đây là load lần đầu

    // Lắng nghe sự kiện back/forward của trình duyệt
    window.addEventListener('popstate', function() {
        const path = window.location.pathname;
        console.log("Back/Forward to:", path);
        loadContent(path, false); // Không thay đổi state khi back/forward
    });
});




