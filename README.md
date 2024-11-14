# project_laravel

1. Cài composer:
    composer global require laravel/installer

2. Cấu hính File .env: chỉnh sửa DB_USERNAME, DB_PASSWORD
    DB_CONNECTION=mysql
    DB_HOST=127.0.0.1
    DB_PORT=3306
    DB_DATABASE=my_database
    DB_USERNAME=my_username
    DB_PASSWORD=my_password

    Sau khi chỉnh sửa tệp .env, chạy lệnh làm mới:
        php artisan config:cache

3. Tạo Migration giúp quản lý cấu trúc CSDL bằng cách sử dụng mã PHP thay vì thao tác trực tiếp trên CSDL.
    Tạo một migration mới để tạo bảng: 
        php artisan make:migration create_name_table (thay name -> tên table)
    
    Sau khi tạo migration chạy lệnh này để tạo bảng trong CSDL: 
        php artisan migrate

4. Tạo Seeder để thêm dữ liệu vào table:
        php artisan make:seeder UsersTableSeeder (ví dụ này tạo seeder cho bảng 'users')

    Sau khi hoàn tất thì chạy seeder để chèn dữ liệu vào CSDL
        php artisan db:seed

*(Thay vì làm bước 3,4 có thể tạo trực tiếp trên CSDL)

5. Tạo Route, Controller và View
    Tạo Route: định nghĩa các URL, có thể định nghĩa route trong tệp routes/web.php
    Tạo Controller: php artisan make:controller UserController
    Tạo View: trong thư mục resources/views

6. Lệnh thực thi dự án: 
    php artisan serve







