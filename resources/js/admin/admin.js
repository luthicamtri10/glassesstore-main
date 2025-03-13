// Controller Sidebar
const hamburger = document.querySelector(".toggle-btn");
const toggler = document.querySelector("#icon");
hamburger.addEventListener("click", function() {
    document.querySelector("#sidebar").classList.toggle("expand");
    toggler.classList.toggle("bx-chevrons-right");
    toggler.classList.toggle("bx-chevrons-left");

})  

document.addEventListener("DOMContentLoaded", function () {
    const sidebarLinks = document.querySelectorAll(".sidebar-link");
    const contentDiv = document.getElementById("content");

    sidebarLinks.forEach(link => {
        link.addEventListener("click", function (event) {
            event.preventDefault(); // Ngăn trang reload
            const page = this.getAttribute("data-page"); // Lấy file PHP cần tải

            fetch(page)
                .then(response => response.text())
                .then(data => {
                    contentDiv.innerHTML = data; // Chèn nội dung vào phần chính
                })
                .catch(error => console.error("Lỗi tải trang:", error));
        });
    });
});
