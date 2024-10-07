function editComment(commentId) {
  // Ẩn phần nội dung hiện tại và hiển thị form chỉnh sửa
  document.getElementById("comment-content-" + commentId).style.display =
    "none";
  document.getElementById("edit-form-" + commentId).style.display = "block";
}

function cancelEdit(commentId) {
  document.getElementById("edit-form-" + commentId).style.display = "none";
  document.getElementById("comment-content-" + commentId).style.display =
    "block";
}

function saveComment(commentId, postId) {
  var content = document.getElementById("edit-content-" + commentId).value;

  var xhr = new XMLHttpRequest();
  xhr.open("POST", "index.php?paction=updateComment", true);
  xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

  xhr.onreadystatechange = function () {
    if (xhr.readyState == 4 && xhr.status == 200) {
      document.getElementById("comment-content-" + commentId).innerHTML =
        content;
      document.getElementById("edit-form-" + commentId).style.display = "none";
      document.getElementById("comment-content-" + commentId).style.display =
        "block";
    }
  };

  // Gửi dữ liệu
  xhr.send(
    "comment_id=" +
      commentId +
      "&content=" +
      encodeURIComponent(content) +
      "&post_id=" +
      postId
  );

  return false;
}
