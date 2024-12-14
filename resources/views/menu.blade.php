<nav>
    <ul style="display: flex; align-items: center; gap: 15px; list-style: none; padding: 10px;">
        <!-- Logo -->
        <li>
            <a href="{{ url('/') }}">
                <img src="https://assets-cdn.kahoot.it/auth/assets/topbar_logo_purple-BNw_v6xK.svg" alt="Logo" style="height: 40px;">
            </a>
        </li>

        <!-- Sử dụng JavaScript để kiểm tra trạng thái đăng nhập -->
        <li style="margin-left: auto;" id="menu-items">
            <a href="{{ url('/login') }}" id="login-link" style="text-decoration: none; color: #6c63ff; font-weight: bold;">Đăng nhập</a>
        </li>
    </ul>
</nav>

<script>
    // Kiểm tra trạng thái đăng nhập qua API
    fetch('/api/user', {
        method: 'GET',
        headers: {
            'Authorization': `Bearer ${localStorage.getItem('token')}` // Gửi token trong header
        }
    })
    .then(response => {
        if (response.ok) {
            // Nếu user đã đăng nhập
            response.json().then(user => {
                const menuItems = document.getElementById('menu-items');
                menuItems.innerHTML = `
                    <a href="/" style="text-decoration: none; color: #6c63ff; font-weight: bold;">Trang chủ</a>
                    <a href="/games" style="text-decoration: none; color: #6c63ff; font-weight: bold;">Games</a>
                    <a href="/news" style="text-decoration: none; color: #6c63ff; font-weight: bold;">Tin tức</a>
                    <form action="/api/logout" method="POST" style="display: inline;">
                        <button type="button" id="logout-btn" style="background: none; border: none; color: #6c63ff; font-weight: bold; cursor: pointer; text-decoration: underline;">Đăng xuất</button>
                    </form>
                `;
                document.getElementById('logout-btn').addEventListener('click', () => {
                    // Gửi request đăng xuất
                    fetch('/api/logout', {
                        method: 'POST',
                        headers: {
                            'Authorization': `Bearer ${localStorage.getItem('token')}`,
                            'Content-Type': 'application/json',
                        }
                    }).then(() => {
                        localStorage.removeItem('token'); // Xóa token sau khi đăng xuất
                        location.reload();
                    });
                });
            });
        }
    });
</script>
