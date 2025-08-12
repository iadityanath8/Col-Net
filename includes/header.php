<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Col-Net - Home</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- <link rel="stylesheet" href="style.css"> -->
    <!-- Alpine.js -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">

    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.bundle.min.js" integrity="sha384-ndDqU0Gzau9qJ1lfW4pNLlhNTkCfHzAVBReH9diLvGRem5+R9g2FzA8ZGN954O5Q" crossorigin="anonymous"></script>


    <script>
        document.addEventListener('alpine:init', () => {
            Alpine.store('posts', {
                items: [],
                comments: {},
                loading: false,
                error: '',

                async fetch() {
                    this.loading = true;
                    this.error = '';
                    try {
                        const res = await fetch('./api/posts_feed_action.php');
                        if (!res.ok) throw new Error('Failed to fetch posts');
                        const data = await res.json();
                        this.items = data.posts;
                    } catch (e) {
                        this.error = e.message;
                    }
                    this.loading = false;
                },

                async toggleLike(post) {
                    const formdata = new FormData();
                    formdata.append("post_id", post.id);

                    const res = await fetch("./api/like_action.php", {
                        method: "POST",
                        body: formdata
                    });
                    const data = await res.json();
                    if (data.success) {
                        post.liked_by_user = data.liked;
                        post.like_count = data.like_count;
                    }
                },

                async fetchComments(postId) {
                    try {
                        const res = await fetch(`./api/comments_action.php?post_id=${postId}`);
                        const data = await res.json();
                        if (data.success) {
                            this.comments[postId] = data.comments;
                        }
                    } catch (e) {
                        console.error(e);
                    }
                },

                async addComment(post, commentContent) {
                    if (!commentContent.trim()) return;
                    try {
                        const res = await fetch('./api/comments_action.php', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json'
                            },
                            body: JSON.stringify({
                                post_id: post.id,
                                content: commentContent
                            })
                        });
                        const data = await res.json();
                        if (data.success) {
                            if (!this.comments) this.comments = {};
                            if (!this.comments[post.id]) this.comments[post.id] = [];
                            this.comments[post.id].push(data.comment);
                        }
                    } catch (e) {
                        console.error(e);
                    }
                },


                add(post) {
                    this.items.unshift(post);
                }
            });
        });
    </script>
</head>

<body class="bg-light">