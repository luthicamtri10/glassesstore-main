document.addEventListener("DOMContentLoaded", function () {
    const sidebarLinks = document.querySelectorAll(".sidebar-link");
    const contentDiv = document.getElementById("content");
    const hamburger = document.querySelector(".toggle-btn");


    hamburger.addEventListener("click", function () {
        document.querySelector("#sidebar").classList.toggle("expand");
        toggler.classList.toggle("bx-chevrons-right");
        toggler.classList.toggle("bx-chevrons-left");
    });
    function loadPage(page, updateHistory = true) {
        fetch(`/${page}`)
            .then(response => response.text())
            .then(html => {
                // Tạo một div ẩn để phân tích HTML mà không chèn lại sidebar
                const tempDiv = document.createElement("div");
                tempDiv.innerHTML = html;

                // Chỉ lấy nội dung trong phần `#content`
                const newContent = tempDiv.querySelector("#content");
                if (newContent) {
                    contentDiv.innerHTML = newContent.innerHTML; // Cập nhật nội dung
                }

                // Cập nhật URL trên thanh địa chỉ
                if (updateHistory) {
                    history.pushState({ page: page }, "", `/${page}`);
                }
            })
            .catch(error => console.error("Lỗi khi tải trang:", error));
    }

    sidebarLinks.forEach(link => {
        link.addEventListener("click", function (e) {
            e.preventDefault();
            const page = this.getAttribute("data-page"); 
            loadPage(page);
        });
    });

    window.addEventListener("popstate", function (event) {
        if (event.state && event.state.page) {
            loadPage(event.state.page, false);
        }
    });

    // Kiểm tra nếu trang đang load lại
    const currentPath = window.location.pathname.replace(/^\/+/, "");
    if (currentPath && currentPath.startsWith("admin/")) {
        loadPage(currentPath, false);
    }
});
