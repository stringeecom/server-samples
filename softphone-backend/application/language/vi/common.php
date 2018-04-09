<?php
global $lang;
if (empty ( $lang ) || ! is_array ( $lang )) {
    $lang = array ();
}

$lang = array_merge ( $lang, array (
        'Index' => 'Trang chủ',
        'Username' => 'Tên đăng nhập',
        'Password' => 'Mật khẩu',
        'ForgotPassword' => 'Quên mật khẩu',
        'Email' => 'Email',
        'Name' => 'Tên',
        'Sex' => 'Giới tính',
        'Male' => 'Nam',
        'Female' => 'Nữ',
        'Title' => 'Tiêu đề',
        'Login' => 'Đăng nhập',
        'Logout' => 'Thoát',
        'EditAvatar' => 'Sửa avatar',
        'MyAccount' => 'Tài khoản của tôi',
        'Inbox' => 'Hộp thư đến',
        'Outbox' => 'Hộp thư đi',
        'ComposeMessage' => 'Soạn tin nhắn',
        'Friends' => 'Bạn bè',
        'Fans' => 'Người hâm mộ',
        'Home' => 'Trang chủ',
        'Register' => 'Đăng ký',
        'Successful' => 'Thành công!',
        'ErrorForm' => 'Có lỗi khi nhập form, vui lòng kiểm tra lại!',
        'Members' => 'Thành viên',
        'Remember' => 'Ghi nhớ',
        'ProfilePage' => 'Trang cá nhân',
        'Edit' => 'Sửa',
        'Delete' => 'Xóa',
        'View' => 'Xem',
        'ForgotPassword' => 'Quên mật khẩu',
        'user' => 'người dùng',
        'message' => 'tin nhắn',
        'admin' => 'quản trị',
        'noscript' => '<h4 class="alert-heading">Cảnh báo!</h4><p>Bạn cần bật JavaScript trên trình duyệt để sử dụng chức năng này.</p>',
        'nodata' => 'Không có dữ liệu',
        'error' => 'Có lỗi',
        'warning' => 'Cảnh báo',
        'time' => 'Thời gian',
        'quantity' => 'Số lượng',
        'open' => 'Mở',
        'close' => 'Đóng',
        'date' => 'ngày',
        'month' => 'tháng',
        'dashboard' => 'Quản trị',
		'addnew' => 'Thêm mới',
		'delete' => 'Xóa',
		'edit' => 'Sửa',
		'cancle' => 'Hủy',
		'options' => 'Tùy chọn',
        'tokenTimeout' => 'Vui lòng reload lại trang để thực hiện lại thao tác.',
        'errors' => array (
                'statisticDate' => 'Ngày chọn thống kê không hợp lệ.',
                'hasError' => 'Có lỗi xảy ra, vui lòng liên hệ quản lý server.'
        ),
        'menus' => array (
                'statisticUser' => 'Thống kê người dùng',
                'allUser' => 'Tất cả người dùng',
                'statisticUserByDate' => 'Người dùng theo ngày',
                'statisticMessage' => 'Thống kê tin nhắn',
                'allMessage' => 'Tất cả tin nhắn',
                'statisticMessageByDate' => 'Tin nhắn theo ngày',
                'sticker' => 'Quản lý sticker'
        ),
        'users' => array (
                'fullname' => 'Tên đầy đủ',
                'status' => 'Trạng thái',
                'registerDate' => 'Ngày đăng ký',
                'lastVisitDate' => 'Lần cuối đăng nhập'
        ),
        'messages' => array (
                'submit' => 'Thống kê'
        ),
        'exports' => array (
                'buttonText' => 'xuất file',
                'success' => 'Xuất file thành công. Chọn nút download để tải file.'
        ),
        'statistics' => array (
                'chart' => 'Biểu đồ',
                'list' => 'Danh sách',
                'notice' => 'Dữ liệu thống kê theo <strong>%s</strong> trong khoảng từ: <strong>%s</strong> tới <strong>%s</strong>',
                'bydate' => 'Theo ngày',
                'bymonth' => 'Theo tháng',
                'selectStartMonth' => 'Chọn tháng bắt đầu',
                'selectEndMonth' => 'Chọn tháng kết thúc',
                'selectStartDate' => 'Chọn ngày bắt đầu',
                'selectEndDate' => 'Chọn ngày kết thúc',
                'submit' => 'Thống kê'
        ),
        'stickers' => array (
                'name' => 'Tên gói',
        		'minicover' => 'Ảnh nhỏ',
        		'fullcover' => 'Ảnh đầy đủ',
        		'url' => 'Url',
        		'package' => 'Gói sticker',
                'fileIncorrectFormat' => 'Chỉ chấp nhận file ảnh và file zip.',
                'uploadFail' => 'Upload sticker thất bại.',
                'uploadSuccess' => 'Upload sticker thành công.',
                'openZipFail' => 'Không thể mở file zip.',
                'unzipFail' => "Unzip file thất bại",
                'updateSuccess' => 'Cập nhật sticker thành công.',
                'deleteSuccess' => 'Xóa sticker thành công.',
                'deleteFail' => 'Xóa sticker không thành công.',
                'notUpdate' => 'Không có thông tin mới được cập nhật.',
                'onlyZipAllow' => 'Chỉ chấp nhận file zip',
                'onlyImgAllow' => 'Chỉ chấp nhận file ảnh png, jpg, jpeg hoặc gif',
        )


) );
