console.log('script is running');

// Lấy các phần tử cần thiết
const header = document.querySelector('header');
const menuBtn = document.getElementById('menu-btn');
const userBtn = document.getElementById('user-btn');
const navbar = document.querySelector('.navbar');
const userBox = document.querySelector('.user-box');

// Hàm thay đổi trạng thái cố định của navbar khi cuộn
function fixedNavbar() {
    header.classList.toggle('scroll', window.scrollY > 0);
}

// Gọi hàm cố định navbar ngay khi tải trang
fixedNavbar();
window.addEventListener('scroll', fixedNavbar);

// Xử lý sự kiện click vào nút menu
menuBtn.addEventListener('click', () => {
    navbar.classList.toggle('active');
});

// Xử lý sự kiện click vào nút user
userBtn.addEventListener('click', () => {
    console.log(userBox); // Kiểm tra xem userBox có được chọn đúng không
    userBox.classList.toggle('active');
});

// Đóng menu hoặc userBox khi click ra ngoài
document.addEventListener('click', (e) => {
    // Đóng menu nếu click ra ngoài
    if (!menuBtn.contains(e.target) && !navbar.contains(e.target)) {
        navbar.classList.remove('active');
    }

    // Đóng userBox nếu click ra ngoài
    if (!userBtn.contains(e.target) && !userBox.contains(e.target)) {
        userBox.classList.remove('active');
    }
});
document.addEventListener('DOMContentLoaded', function () {
    const paginationLinks = document.querySelectorAll('.pagination a');
    const productContainer = document.querySelector('.products .box-container');

    paginationLinks.forEach(link => {
        link.addEventListener('click', function (e) {
            e.preventDefault();
            const url = this.getAttribute('href');

            fetch(url)
                .then(response => response.text())
                .then(data => {
                    productContainer.innerHTML = data;
                    window.history.pushState({}, '', url); // Cập nhật URL mà không tải lại trang
                })
                .catch(error => console.error('Error:', error));
        });
    });
});
