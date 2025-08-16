<style>
    .ms {
        background-color: rgba(25, 25, 40, 0.85);
        backdrop-filter: blur(10px);
        color: #eee;
        border-radius: 15px;
    }

    .glass-effect {
        background: rgba(255, 255, 255, 0.92);
        backdrop-filter: blur(12px);
        border-radius: 15px;
        border: 1px solid rgba(255, 255, 255, 0.25);
    }

    .modal-content {
        animation: fadeInUp 0.25s ease-in-out;
    }

    @keyframes fadeInUp {
        from {
            transform: translateY(15px);
            opacity: 0;
        }

        to {
            transform: translateY(0);
            opacity: 1;
        }
    }
</style>

<?php
$user_id = $_SESSION['user_id'];
?>

<div x-data="{
        activePost: null,
        ssid: <?= json_encode((int)$user_id); ?>,
        showCommentBox(post) {
            
            if (this.activePost && this.activePost.id === post.id) {
                this.activePost = null;
                return;
            }

            this.activePost = post;
            
            if (!$store.posts.comments[post.id]) {
                $store.posts.fetchComments(post.id);
            }
        }
    }"

    <?php if ($show_user_profile === true): ?>
    x-init="$store.posts.fetch(true)"
    <?php else: ?>
    x-init="$store.posts.fetch(false)"
    <?php endif ?>
    class="mt-4">

    <!-- Posts Feed -->
    <template x-for="post in $store.posts.items" :key="post.id">
        <div class="bg-white rounded-4 shadow-sm p-3 mb-4">

            <div class="d-flex align-items-center mb-3">
                <img :src="post.photo || 'https://via.placeholder.com/48'"
                    alt="User"
                    class="rounded-circle me-3 border border-light"
                    style="width: 48px; height: 48px; object-fit: cover;">
                <div>
                    <h6 class="mb-0 fw-semibold" x-text="post.name"></h6>
                    <small class="text-muted" x-text="post.created_at"></small>
                </div>

                <!-- DropDown -->
                <div class="ms-auto dropdown">

                    <template x-if="post.user_id == ssid">
                        <button class="btn btn-sm btn-light rounded-circle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="fas fa-ellipsis-h"></i>
                        </button>
                    </template>

                    <ul class="dropdown-menu dropdown-menu-end">
                        <li>
                            <a class="dropdown-item" href="#"
                                data-bs-toggle="modal"
                                :data-bs-target="`#editPostModal-${post.id}`">
                                <i class="fas fa-edit me-2"></i> Edit
                            </a>
                        </li>
                        <li>
                            <a class="dropdown-item text-danger" @click.prevent="$store.posts.deletePostUP(post.id)">
                                <i class="fas fa-trash me-2"></i> Delete
                            </a>
                        </li>
                    </ul>

                </div>


                <!-- Edit Post Modal -->
                <div class="modal fade" :id="`editPostModal-${post.id}`" tabindex="-1" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered modal-lg">
                        <div class="modal-content glass-effect p-3 shadow-lg">

                            <!-- Header -->
                            <div class="modal-header border-0 pb-0">
                                <h5 class="modal-title fw-semibold text-primary m-0">
                                    <i class="fas fa-pen-to-square me-2"></i> Edit Post
                                </h5>
                                <button type="button" class="btn-close shadow-sm" data-bs-dismiss="modal"></button>
                            </div>

                            <!-- Body -->
                            <div class="modal-body">
                                <form :id="`editPostForm-${post.id}`" enctype="multipart/form-data" class="row g-3">

                                    <!-- Current Image -->
                                    <div class="col-12 text-center">
                                        <!-- <label class="form-label small fw-semibold text-muted">Current Image</label> -->
                                        <div class="position-relative d-inline-block">
                                            <img :src="post.image"
                                                :id="`currentImage-${post.id}`"
                                                alt="Current Post Image"
                                                class="img-fluid rounded-4 border shadow-sm"
                                                style="max-height: 200px; object-fit: cover;">
                                        </div>
                                    </div>

                                    <!-- Content -->
                                    <div class="col-12">
                                        <label class="form-label fw-semibold small">Content</label>
                                        <textarea class="form-control rounded-3 shadow-sm"
                                            name="content"
                                            rows="3"
                                            :id="`updatecontent-${post.id}`"
                                            placeholder="Update your post content..."
                                            x-text="post.content"></textarea>
                                    </div>

                                    <!-- Upload New Image -->
                                    <div class="col-12">
                                        <label class="form-label fw-semibold small">Change Image</label>
                                        <input type="file"
                                            class="form-control rounded-3 shadow-sm"
                                            name="image"
                                            :id="`updateimg-${post.id}`"
                                            accept="image/*">
                                        <small class="text-muted">Choose a new image to replace the old one.</small>
                                    </div>

                                </form>
                            </div>

                            <!-- Footer -->
                            <div class="modal-footer border-0 pt-0">
                                <button type="button" class="btn btn-outline-secondary px-3 py-1 rounded-3" data-bs-dismiss="modal">
                                    Cancel
                                </button>
                                <button type="button" :data-post-id="post.id" class="btn btn-primary px-3 py-1 rounded-3 updatesub-btn">
                                    Save Changes
                                </button>
                            </div>

                        </div>
                    </div>
                </div>
            </div>

            <p class="fs-6 mb-3" x-text="post.content"></p>

            <template x-if="post.image">
                <div class="overflow-hidden rounded-3 mb-3">
                    <img :src="post.image"
                        alt="Post Image"
                        class="img-fluid"
                        style="max-height: 450px; object-fit: cover; width: 100%;">
                </div>
            </template>


            <div class="d-flex justify-content-around pt-2 border-top">

                <button class="btn btn-light btn-sm border-0 d-flex align-items-center gap-1"
                    style="min-width: 90px; justify-content: center;"
                    :class="{'text-primary': post.liked_by_user}"
                    @click="$store.posts.toggleLike(post)">
                    <i class="fas"
                        :class="post.liked_by_user ? 'fa-thumbs-up' : 'fa-thumbs-o-up'"
                        style="width: 16px; text-align: center;"></i>
                    <span class="text-center" x-text="`Like (${post.like_count ?? 0})`"></span>
                </button>


                <button class="btn btn-light btn-sm border-0 d-flex align-items-center gap-1"
                    style="min-width: 90px; justify-content: center;"
                    @click="showCommentBox(post)">
                    <i class="fas fa-comment" style="width: 16px; text-align: center;"></i>
                    Comment
                </button>


                <button class="btn btn-light btn-sm border-0 d-flex align-items-center gap-1"
                    style="min-width: 90px; justify-content: center;">
                    <i class="fas fa-share" style="width: 16px; text-align: center;"></i>
                    Share
                </button>
            </div>

            <!-- Comment Box Section -->
            <div x-show="activePost && activePost.id === post.id" x-transition class="bg-white rounded-4 shadow-sm p-3 mt-3">
                <h6 class="fw-semibold mb-3">
                    Comments for: <span x-text="activePost.name"></span>
                </h6>

                <!-- Existing Comments -->
                <template x-for="comment in $store.posts.comments[post.id] || []" :key="comment.id">
                    <div class="d-flex mb-2">
                        <img :src="comment.photo || 'https://via.placeholder.com/32'"
                            class="rounded-circle me-2"
                            style="width: 32px; height: 32px; object-fit: cover;">
                        <div class="bg-light rounded p-2 w-100">
                            <strong x-text="comment.name"></strong>
                            <p class="mb-0" x-text="comment.content"></p>
                        </div>
                    </div>
                </template>

                <!-- Add Comment -->
                <div x-data="{newComment:''}" class="d-flex mt-3">
                    <input type="text"
                        class="form-control rounded-pill me-2"
                        placeholder="Write a comment..."
                        x-model="newComment">
                    <button class="btn btn-primary rounded-pill"
                        @click="$store.posts.addComment(post, newComment); newComment=''">
                        Post
                    </button>
                </div>
            </div>
        </div>
    </template>
</div>

<script>
    document.addEventListener("click", async (e) => {
        if (e.target.classList.contains("updatesub-btn")) {
            e.preventDefault();
            const postId = e.target.dataset.postId;

            const content = document.getElementById(`updatecontent-${postId}`).value;
            const image = document.getElementById(`updateimg-${postId}`).files[0];

            const formData = new FormData();
            formData.append("post_id", postId);
            formData.append("content", content);
            if (image) {
                formData.append("image", image);
            }

            try {
                const res = await fetch("./api/edit_post_action.php", {
                    method: "POST",
                    body: formData
                });

                const data = await res.json();
                const updated = data.updated_post;
                if (data.success) {
                    const store = Alpine.store('posts');
                    const post = store.items.find(p => p.id === postId);

                    if (post) {
                        post.image = updated.image;
                        post.content = updated.content;
                        await store.deletePost(postId);
                        store.add(post);
                        alert("Post Updated Successfully");
                    }
                } else {
                    alert(data.message || "Failed to update post");
                }


            } catch (err) {
                console.error("Fetch Error:", err);
            }
        }
    });
</script>