<?php

return [
    'admin_menu' => [
        'caching' => 'Bộ nhớ đệm',
    ],
    'cache_management' => 'Quản lý bộ nhớ đệm',
    'cache_commands' => 'Các lệnh cơ bản',
    'commands' => [
        'clear_cms_cache' => [
            'title' => 'Xóa tất cả bộ đệm hiện có của ứng dụng',
            'description' => 'Xóa các bộ nhớ đệm của ứng dụng: cơ sở dữ liệu, nội dung tĩnh... Chạy lệnh này khi bạn thử cập nhật dữ liệu nhưng giao diện không thay đổi',
        ],
        'refresh_compiled_views' => [
            'title' => 'Làm mới bộ đệm giao diện',
            'description' => 'Làm mới bộ đệm giao diện giúp phần giao diện luôn mới nhất',
        ],
        'create_config_cache' => [
            'title' => 'Tạo bộ đệm cho phần cấu hình',
            'description' => 'Để ứng dụng của bạn chạy nhanh hơn, bạn cần phải lưu bộ nhớ đệm phần cấu hình vào một tập tin duy nhất. Lệnh này giúp nối tất cả các tập tin cấu hình vào một tập tin duy nhất và sẽ dược hệ thống tải nhanh hơn.',
        ],
        'clear_config_cache' => [
            'title' => 'Xóa bộ nhớ đệm của phần cấu hình',
            'description' => 'Bạn cần làm mới bộ đệm cấu hình khi bạn tạo ra sự thay đổi nào đó ở môi trường thành phẩm.',
        ],
        'optimize_class_loader' => [
            'title' => 'Tối ưu hóa class loader',
            'description' => 'Bạn muốn ứng dụng chạy nhanh hơn? Chúng ta sẽ tối ưu hóa bộ tự động tải',
        ],
        'clear_optimized_class_loader' => [
            'title' => 'Xóa các class loader đã tối ưu hóa',
            'description' => 'Thực hiện điều này có thể làm ứng dụng của bạn chạy chậm hơn.',
        ],
    ],
    'messages' => [
        'cache_cleaned' => 'Bộ đệm đã được xóa',
        'cache_view_refreshed' => 'Bộ đệm giao diện đã được làm mới',
        'cache_config_created' => 'Bộ đệm cấu hình đã được khởi tạo',
        'cache_config_cleaned' => 'Bộ đệm cấu hình đã được xóa',
        'class_loader_optimized' => 'Class loader đã được tối ưu hóa',
        'class_loader_cleaned' => 'Các class loader tối ưu hóa đã bị xóa',
        'cache_route_created' => 'Bộ đệm điều hướng đã được khởi tạo',
        'cache_route_cleaned' => 'Bộ đệm điều hướng đã bị xóa'
    ],
];