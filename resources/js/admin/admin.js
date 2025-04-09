document.addEventListener('DOMContentLoaded', function () {
    const links = document.querySelectorAll('.sidebar-nav a');

    links.forEach(link => {
        link.addEventListener('click', function (e) {
            e.preventDefault();
            const modun = this.dataset.modun;

            // Cập nhật URL mà không reload
            const newUrl = `/admin?modun=${modun}`;
            history.pushState({modun}, '', newUrl);

            // Load nội dung qua AJAX
            loadModule(modun);
        });
    });

    // Xử lý khi bấm nút back/forward trình duyệt
    window.addEventListener('popstate', function (e) {
        const modun = (e.state && e.state.modun) || 'nguoidung';
        loadModule(modun);
    });

    // Hàm load nội dung qua AJAX
    function loadModule(modun) {
        fetch(`/admin-content?modun=${modun}`)
            .then(res => res.text())
            .then(html => {
                document.getElementById('content').innerHTML = html;
            });
    }

    // Load lần đầu theo URL
    const currentModun = new URLSearchParams(window.location.search).get('modun') || 'nguoidung';
    loadModule(currentModun);
});
