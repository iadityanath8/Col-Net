<?php
include './db.php';

$user_id = $_SESSION['user_id'];
$sql = "SELECT * FROM users WHERE id = $user_id";
$result = mysqli_query($conn, $sql);
$user = mysqli_fetch_assoc($result);

?>



<div class="container mt-4">
    <div class="card shadow-sm border-0">
        <div class="card-body">
            <div class="d-flex align-items-center mb-3">
                <img src=" <?php echo $user['photo'] ?>"
                    alt="User"
                    class="rounded-circle me-2"
                    width="45" height="45">
                <button id="openPostBox" class="form-control text-start bg-light rounded-pill">
                    What's on your mind, <?php echo htmlspecialchars($_SESSION['username']); ?>?
                </button>
            </div>

            <div id="postForm" class="mt-3 d-none">
                <textarea id="postContent" class="form-control mb-2" rows="3" placeholder="Write something..."></textarea>
                <div class="d-flex justify-content-between align-items-center">
                    <label for="postImage" class="btn btn-light btn-sm d-flex align-items-center">
                        <i class="fa-solid fa-image text-success me-2"></i> Photo
                        <input type="file" id="postImage" accept="image/*" hidden>
                    </label>
                    <button id="submitPost" class="btn btn-primary btn-sm">Post</button>
                </div>
                <div id="postPreview" class="mt-2"></div>
            </div>
        </div>
    </div>
</div>




<script>
    document.addEventListener("DOMContentLoaded", () => {
        const openBtn = document.getElementById("openPostBox");
        const postForm = document.getElementById("postForm");
        const postImage = document.getElementById("postImage");
        const postPreview = document.getElementById("postPreview");
        const submitBtn = document.getElementById("submitPost");

        // Expand form when clicked
        openBtn.addEventListener("click", () => {
            postForm.classList.remove("d-none");
            openBtn.classList.add("d-none");
        });

        // Preview selected image
        postImage.addEventListener("change", (e) => {
            const file = e.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = () => {
                    postPreview.innerHTML = `<img src="${reader.result}" class="img-fluid rounded">`;
                };
                reader.readAsDataURL(file);
            }
        });

        submitBtn.addEventListener("click", async () => {
            const content = document.getElementById("postContent").value.trim();
            if (!content && !postImage.files.length) {
                alert("Please write something or select an image.");
                return;
            }

            const formData = new FormData();
            formData.append("content", content);
            if (postImage.files.length > 0) {
                formData.append("image", postImage.files[0]);
            }

            const res = await fetch("api/create_post_action.php", {
                method: "POST",
                body: formData
            });

            const data = await res.json();
            if (data.success) {
                alert("Post created!");
                document.getElementById("postContent").value = "";
                postImage.value = "";
                postPreview.innerHTML = "";
                postForm.classList.add("d-none");
                openBtn.classList.remove("d-none");

                Alpine.store('posts').add(data.post);
            } else {
                alert("Error: " + data.message);
            }
        });
    });
</script>