# Social Post & Comment System

A simple social media-like feed with posts and comments built using PHP, MySQL, and Alpine.js for frontend interactivity.  
Users can view posts, like/unlike posts, and add/view comments dynamically.

---

## Features

- User authentication (assumed included)
- Display posts with images, likes, and timestamps
- Like/unlike posts with instant UI updates
- View comments for each post in a separate comment panel
- Add new comments with real-time update and user avatar display
- Secure backend API for fetching posts and comments and posting comments

---

## Technologies Used

- **Backend:** PHP, MySQL (mysqli)
- **Frontend:** Alpine.js, Bootstrap 5, FontAwesome
- **Data Exchange:** JSON via AJAX/fetch API

---

## Database Schema

- **users**  
  - `id`, `name`, `email`, `password`, `photo` (profile image), ...
- **posts**  
  - `id`, `user_id`, `content`, `image`, `created_at`
- **comments**  
  - `id`, `post_id`, `user_id`, `content`, `created_at`
- **likes**  
  - `id`, `post_id`, `user_id`

---

## Setup & Installation

1. Clone or download the repository.
2. Import the provided SQL dump or create your own database schema as above.
3. Update `db.php` with your MySQL database credentials.
4. Ensure your PHP server supports sessions and has mysqli enabled.
5. Place the project in your web root directory.
6. Open the project in your browser.

---

## API Endpoints

- `GET /api/posts.php`  
  Fetch all posts with user info and like counts.

- `GET /api/comments_action.php?post_id={post_id}`  
  Fetch comments for a specific post.

- `POST /api/comments_action.php`  
  Add a comment to a post. Accepts JSON body:  
  ```json
  {
    "post_id": 1,
    "content": "Your comment here"
  }
