<nav>
    <ul style="display: flex; align-items: center; gap: 15px; list-style: none; padding: 10px;">
        <!-- Logo -->
        <li>
            <a href="{{ url('/') }}">
                <img src="https://assets-cdn.kahoot.it/auth/assets/topbar_logo_purple-BNw_v6xK.svg" alt="Logo" style="height: 40px;">
            </a>
        </li>

        <!-- Menu items (Sẽ được thay đổi qua JavaScript dựa trên trạng thái đăng nhập) -->
        <li style="margin-left: auto;" id="menu-items">
            <a href="#" id="login-link" style="text-decoration: none; color: #6c63ff; font-weight: bold;">Đăng nhập</a>
        </li>
    </ul>
</nav>

<script>
    // Kiểm tra trạng thái đăng nhập qua API
    fetch('/api/user', {
        method: 'GET', // Gửi yêu cầu GET để lấy thông tin user
        headers: {
            'Authorization': `Bearer ${localStorage.getItem('token')}` // Lấy token từ localStorage và gửi qua header
        }
    })
    .then(response => {
        if (response.ok) {
            // Nếu phản hồi từ server là OK (200)
            response.json().then(user => {
                // Lấy phần tử chứa menu
                const menuItems = document.getElementById('menu-items');

                // Cập nhật menu cho user đã đăng nhập
                menuItems.innerHTML = `
                    <a href="/" style="text-decoration: none; color: #6c63ff; font-weight: bold;">Trang chủ</a>
                    <a href="/games" style="text-decoration: none; color: #6c63ff; font-weight: bold;">Games</a>
                    <a href="/news" style="text-decoration: none; color: #6c63ff; font-weight: bold;">Tin tức</a>
                    <button id="logout-btn" style="background: none; border: none; color: #6c63ff; font-weight: bold; cursor: pointer; text-decoration: underline;">Đăng xuất</button>
                `;

                // Thêm sự kiện click cho nút Đăng xuất
                document.getElementById('logout-btn').addEventListener('click', () => {
                    // Gửi request API để đăng xuất
                    fetch('/api/logout', {
                        method: 'POST', // API đăng xuất yêu cầu POST
                        headers: {
                            'Authorization': `Bearer ${localStorage.getItem('token')}`, // Gửi token trong header
                            'Content-Type': 'application/json',
                        }
                    }).then(() => {
                        localStorage.removeItem('token'); // Xóa token khỏi localStorage sau khi đăng xuất
                        location.reload(); // Reload lại trang để cập nhật menu
                    }).catch(error => {
                        console.error('Đăng xuất thất bại:', error); // Hiển thị lỗi nếu đăng xuất thất bại
                    });
                });
            });
        } else {
            // Nếu token không hợp lệ hoặc user chưa đăng nhập
            throw new Error('Token không hợp lệ hoặc chưa đăng nhập');
        }
    })
    .catch(error => {
        console.warn('Lỗi trạng thái đăng nhập:', error.message); // Hiển thị cảnh báo trong console
        // Không thay đổi nút đăng nhập (giữ nguyên trạng thái chưa đăng nhập)
    });

    // Xử lý khi bấm nút Đăng nhập
    document.getElementById('login-link').addEventListener('click', () => {
        const email = prompt('Nhập email:'); // Hiển thị input cho email
        const password = prompt('Nhập mật khẩu:'); // Hiển thị input cho mật khẩu

        // Gửi request API đăng nhập
        fetch('/api/login', {
            method: 'POST', // API đăng nhập yêu cầu POST
            headers: {
                'Content-Type': 'application/json', // Dữ liệu gửi dạng JSON
            },
            body: JSON.stringify({ email, password }), // Chuyển email và password thành JSON
        })
        .then(response => response.json())
        .then(data => {
            if (data.status === 'success') {
                localStorage.setItem('token', data.token); // Lưu token vào localStorage
                alert('Đăng nhập thành công!'); // Thông báo đăng nhập thành công
                location.reload(); // Reload lại trang để cập nhật menu
            } else {
                alert('Đăng nhập thất bại: ' + data.message); // Thông báo lỗi nếu đăng nhập thất bại
            }
        })
        .catch(error => {
            console.error('Lỗi kết nối API đăng nhập:', error); // Hiển thị lỗi trong console
        });
    });
</script>
