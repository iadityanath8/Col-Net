<style>
    .ms {
        background-color: rgba(25, 25, 40, 0.85);
        backdrop-filter: blur(10px);
        color: #eee;
        border-radius: 15px;
    }
</style>

<div x-data="{
        activePost: null,
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
                <div class="ms-auto">
                    <button class="btn btn-sm btn-light rounded-circle">
                        <i class="fas fa-ellipsis-h"></i>
                    </button>
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