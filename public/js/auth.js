$(document).ready(function() {
    // Xử lý menu active
    $('.sidebar-menu li').click(function() {
        $('.sidebar-menu li').removeClass('active');
        $(this).addClass('active');
    });

    // Xử lý responsive sidebar
    function handleSidebar() {
        if ($(window).width() < 992) {
            $('.sidebar').addClass('collapsed');
        } else {
            $('.sidebar').removeClass('collapsed');
        }
    }

    // Gọi lần đầu khi load trang
    handleSidebar();

    // Gọi lại khi resize window
    $(window).resize(function() {
        handleSidebar();
    });
});
