import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import vue from '@vitejs/plugin-vue';

export default defineConfig({
    plugins: [
        laravel({
            input: ['resources/css/app.css', 'resources/js/app.js'], // Đường dẫn tới các file CSS và JS chính
            refresh: true, // Tự động refresh khi file thay đổi
        }),
        vue(), // Kích hoạt plugin Vue
    ],
});
