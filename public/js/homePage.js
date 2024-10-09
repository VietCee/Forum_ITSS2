$(document).ready(function() {
    // Like/Unlike button logic
    $('.like-button').click(function(e) {
        e.preventDefault();
    
        const postId = $(this).data('post-id');
        const button = $(this);
    
        $.ajax({
            type: 'POST',
            url: 'index.php?paction=toggleLike',
            data: { post_id: postId },
            success: function(response) {
                
                const currentText = button.html().trim();
                const isUnlike = currentText.includes('好かん'); 
    
                if (isUnlike) {
                    button.html(currentText.replace('好かん', '好き')); 
                    const newCount = parseInt(currentText.match(/\d+/)[0]) - 1;
                    button.html(button.html().replace(/\(\d+\)/, `(${newCount})`));
                } else {
                    button.html(currentText.replace('好き', '好かん'));
                    const newCount = parseInt(currentText.match(/\d+/)[0]) + 1;
                    button.html(button.html().replace(/\(\d+\)/, `(${newCount})`));
                }
            }
        });
    });
    

    // Save/Unsave button logic
    $('.save-button').click(function(e) {
        e.preventDefault();
        
        const postId = $(this).data('post-id');
        const button = $(this);
        
        $.ajax({
            type: 'POST',
            url: 'index.php?paction=toggleSave',
            data: { post_id: postId },
            success: function(response) {
                // Cập nhật lại nội dung nút save/unsave
                const currentText = button.html().trim();
                const isUnsave = currentText.includes('保存しない');
                
                if (isUnsave) {
                    button.html('<i class="fas fa-bookmark"></i> 保存');
                } else {
                    button.html('<i class="fas fa-bookmark"></i> 保存しない');
                }
            }
        });
    });

    
});
