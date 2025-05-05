// Mobile menu toggle
document.addEventListener('DOMContentLoaded', function() {
    const mobileMenuBtn = document.querySelector('.mobile-menu-btn');
    const mobileNav = document.querySelector('.mobile-nav');

    if (mobileMenuBtn && mobileNav) {
        mobileMenuBtn.addEventListener('click', function() {
            mobileNav.style.display = mobileNav.style.display === 'flex' ? 'none' : 'flex';
        });
    }

    // Close mobile menu when clicking outside
    document.addEventListener('click', function(e) {
        if (!e.target.closest('.navbar') && mobileNav.style.display === 'flex') {
            mobileNav.style.display = 'none';
        }
    });
});

$(document).ready(function() {
    // Xử lý click vào button tag
    $('.tag-filter-btn').click(function() {
        $(this).toggleClass('btn-primary btn-outline-primary');
        updateSelectedTags();
    });

    // Cập nhật danh sách tag đã chọn
    function updateSelectedTags() {
        const selectedTags = [];
        $('.tag-filter-btn.btn-primary').each(function() {
            selectedTags.push($(this).data('tag-id'));
        });

        // Trong trang tag, luôn bao gồm tag hiện tại
        @if(isset($tag))
            if (!selectedTags.includes({{ $tag->id }})) {
                selectedTags.push({{ $tag->id }});
            }
        @endif

        $('#selected-tags-input').val(selectedTags.join(','));
    }

    // Tự động submit form khi có thay đổi (tuỳ chọn)
    $('.tag-filter-btn').click(function() {
        $('#tag-filter-form').submit();
    });
});
