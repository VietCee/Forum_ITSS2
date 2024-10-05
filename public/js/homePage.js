// Menu toggle logic
document.addEventListener('click', function(event) {
    var isClickInside = event.target.closest('.menu-options');

    document.querySelectorAll('.menu-content').forEach(function(menu) {
        if (!isClickInside || !menu.contains(event.target)) {
            menu.style.display = 'none';
        }
    });

    if (isClickInside) {
        var menu = isClickInside.querySelector('.menu-content');
        if (menu) {
            menu.style.display = (menu.style.display === 'block') ? 'none' : 'block';
        }
    }
});

// Like/Unlike button logic using AJAX
$(document).ready(function() {
    $('.like-button').click(function(e) {
        e.preventDefault(); // Ngăn chặn hành động mặc định của nút

        const postId = $(this).data('post-id');
        const button = $(this); // Giữ lại button để cập nhật sau

        $.ajax({
            type: 'POST',
            url: 'index.php?paction=toggleLike', // URL cho request
            data: {
                post_id: postId
            },
            success: function(response) {
                // Cập nhật lại nội dung nút like/unlike
                const currentText = button.html().trim();
                const isUnlike = currentText.includes('Unlike');

                if (isUnlike) {
                    button.html(currentText.replace('Unlike', 'Like'));
                    const newCount = parseInt(currentText.match(/\d+/)[0]) - 1;
                    button.html(button.html().replace(/\(\d+\)/, `(${newCount})`));
                } else {
                    button.html(currentText.replace('Like', 'Unlike'));
                    const newCount = parseInt(currentText.match(/\d+/)[0]) + 1;
                    button.html(button.html().replace(/\(\d+\)/, `(${newCount})`));
                }
            }
        });
    });
});
