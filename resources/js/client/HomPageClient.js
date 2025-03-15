
const itemProduct = document.querySelectorAll('.item-product')

itemProduct.forEach(item => {
    item.addEventListener('mouseenter', () => {
        const iconArrow = item.querySelector('i')
        const price = item.querySelector('.price-product')
        iconArrow.style.transform = "rotate(45deg)"
        iconArrow.style.transition = 'transform 0.5s ease';
        iconArrow.style.height = "40px"
        iconArrow.style.width = "40px"
        iconArrow.style.right = "0.5px"
        iconArrow.style.top = "0.5px"
        iconArrow.style.fontWeight = 900
        price.style.backgroundColor = "#fb923c"

    })
    item.addEventListener('mouseleave', () => {
        const iconArrow = item.querySelector('i')
        const price = item.querySelector('.price-product')
        iconArrow.style.transform = "rotate(0deg)"
        iconArrow.style.height = "30px"
        iconArrow.style.width = "30px"
        iconArrow.style.right = "7px"
        iconArrow.style.top = "7px"
        price.style.backgroundColor = "#55d5d2"

    })
});
const typeProduct = document.querySelectorAll('.type-product-items-ul li')
typeProduct.forEach(item => {
    item.addEventListener('mouseenter', () => {
        const icon = item.querySelector('i')
        icon.style.opacity = 1
        icon.style.visibility = 'visible'
        item.style.color = '#fb923c'
    })
    item.addEventListener('mouseleave', () => {
        const icon = item.querySelector('i')
        icon.style.opacity = 0
        icon.style.visibility = 'hidden'
        item.style.color = '#535252'
    })
})

const containerFilter = document.querySelector(".container-filter")
const dmsp = document.querySelector(".dmsp")
const filter = document.getElementById("filter-btn")
let isFilterVisible = false; 

filter.addEventListener("click", () => {
    if (!isFilterVisible) {
        containerFilter.style.width = '15%';
        containerFilter.style.opacity = 1;
        containerFilter.style.height = 'auto';
        filter.textContent = "Close Filter"
        dmsp.style.width = '85%';

    } else {
        containerFilter.style.width = '0%';
        dmsp.style.width = '100%';
        containerFilter.style.opacity = 0;
        filter.textContent = "Open Filter"
        containerFilter.style.height = 0;
    }
    isFilterVisible = !isFilterVisible;
});

// phân trang//
// Số hàng trên mỗi trang
const rowsPerPage = 2;
const productList = document.getElementById('product-list');
const pagination = document.getElementById('pagination');
const containerRows = document.querySelector('.container-rows');
let allRows = Array.from(productList.getElementsByClassName('row')); // Lưu tất cả các hàng ban đầu
let currentPage = 1;
const totalRows = allRows.length;
const totalPages = Math.ceil(totalRows / rowsPerPage);
const maxPageButtons = 5; // Giới hạn hiển thị 5 số trang

console.log('Tổng số hàng:', totalRows);

// Hàm hiển thị các hàng của trang hiện tại
function displayRows(page) {
  const start = (page - 1) * rowsPerPage;
  const end = start + rowsPerPage;

  productList.innerHTML = '';
  for (let i = start; i < end && i < totalRows; i++) {
    productList.appendChild(allRows[i].cloneNode(true));
    const itemProduct = document.querySelectorAll('.item-product')

itemProduct.forEach(item => {
    item.addEventListener('mouseenter', () => {
        const iconArrow = item.querySelector('i')
        const price = item.querySelector('.price-product')
        iconArrow.style.transform = "rotate(45deg)"
        iconArrow.style.transition = 'transform 0.5s ease';
        iconArrow.style.height = "40px"
        iconArrow.style.width = "40px"
        iconArrow.style.right = "0.5px"
        iconArrow.style.top = "0.5px"
        iconArrow.style.fontWeight = 900
        price.style.backgroundColor = "#fb923c"

    })
    item.addEventListener('mouseleave', () => {
        const iconArrow = item.querySelector('i')
        const price = item.querySelector('.price-product')
        iconArrow.style.transform = "rotate(0deg)"
        iconArrow.style.height = "30px"
        iconArrow.style.width = "30px"
        iconArrow.style.right = "7px"
        iconArrow.style.top = "7px"
        price.style.backgroundColor = "#55d5d2"

    })
});
  }
}

// Hàm tạo các nút phân trang (chỉ hiển thị 5 số trang)
function createPagination() {
  const existingButtons = pagination.querySelectorAll('.page-num');
  existingButtons.forEach(btn => btn.remove());

  // Tính toán phạm vi số trang hiển thị
  let startPage = Math.max(1, currentPage - Math.floor(maxPageButtons / 2));
  let endPage = startPage + maxPageButtons - 1;

  // Điều chỉnh nếu endPage vượt quá totalPages
  if (endPage > totalPages) {
    endPage = totalPages;
    startPage = Math.max(1, endPage - maxPageButtons + 1);
  }

  // Thêm các nút số trang
  for (let i = startPage; i <= endPage; i++) {
    const button = document.createElement('button');
    button.textContent = i;
    button.classList.add('page-btn', 'page-num');
    if (i === currentPage) button.classList.add('active');

    button.addEventListener('click', () => {
      currentPage = i;
      updatePagination();
      displayRows(currentPage);
      createPagination(); // Cập nhật lại nút phân trang
    });
    pagination.insertBefore(button, pagination.querySelector('.next-btn'));
  }
}

// Hàm cập nhật trạng thái phân trang
function updatePagination() {
  const prevBtn = pagination.querySelector('.prev-btn');
  const nextBtn = pagination.querySelector('.next-btn');
  const pageButtons = pagination.querySelectorAll('.page-num');

  pageButtons.forEach((btn, index) => {
    btn.classList.toggle('active', parseInt(btn.textContent) === currentPage);
  });

  prevBtn.disabled = currentPage === 1;
  nextBtn.disabled = currentPage === totalPages;
}

// Sự kiện cho nút "Trang trước"
pagination.querySelector('.prev-btn').addEventListener('click', () => {
  if (currentPage > 1) {
    currentPage--;
    updatePagination();
    displayRows(currentPage);
    createPagination(); // Cập nhật lại nút phân trang
  }
});

// Sự kiện cho nút "Trang sau"
pagination.querySelector('.next-btn').addEventListener('click', () => {
  if (currentPage < totalPages) {
    currentPage++;
    updatePagination();
    displayRows(currentPage);
    createPagination(); // Cập nhật lại nút phân trang
  }
});

// Khởi tạo khi trang tải
document.addEventListener('DOMContentLoaded', () => {
  createPagination();
  displayRows(currentPage);
  updatePagination();
});