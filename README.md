# Social Media Platform API

A RESTful API for a social media platform built with Laravel 12 and JWT authentication. This API provides endpoints for user authentication, post management, and social interactions.

## Features

- 🔐 JWT-based authentication
- 👤 User registration and login
- 📝 Post creation, reading, updating, and deletion
- 💬 Comment system
- 👍 Reaction system
- 📊 User profiles with statistics
- 🖼️ Image upload support for posts

## Tech Stack

- **Framework:** Laravel 12
- **Authentication:** JWT (JSON Web Tokens)
- **Database:** MySQL
- **Language:** PHP 8.2+

## Prerequisites

Before running this application, make sure you have the following installed:

- PHP 8.2 or higher
- Composer
- MySQL
- Node.js and npm (for frontend assets, if needed)

## Installation & Setup

### 1. Clone the Repository

```bash
git clone <repository-url>
cd social-media-platform-api
```

### 2. Install Dependencies

```bash
composer install
npm install
```

### 3. Environment Configuration

Copy the `.env.example` file to `.env`:

```bash
cp .env.example .env
```

Update the `.env` file with your configuration:

```env
APP_NAME="Social Media Platform API"
APP_ENV=local
APP_KEY=
APP_DEBUG=true
APP_URL=http://localhost:8000

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=social_media_platform
DB_USERNAME=your_username
DB_PASSWORD=your_password
```

### 4. Generate Application Key

```bash
php artisan key:generate
```

### 5. Database Setup

Create the database and run migrations:

```bash
# Create database in MySQL
# Then run:
php artisan migrate
```

### 6. JWT Configuration

Publish the JWT configuration:

```bash
php artisan vendor:publish --provider="PHPOpenSourceSaver\JWTAuth\Providers\LaravelServiceProvider"
```

Generate JWT secret key:

```bash
php artisan jwt:secret
```

### 7. Storage Link

Create storage symlink for file uploads:

```bash
php artisan storage:link
```

### 8. Start the Server

```bash
php artisan serve
```

The API will be available at `http://localhost:8000`

## API Documentation

### Base URL
```
http://localhost:8000/api
```

### Authentication

Most endpoints require authentication. Include the JWT token in the Authorization header:

```
Authorization: Bearer <your_jwt_token>
```

---

## Endpoints

### Authentication

#### 1. Register User
**POST** `/api/register`

**Request Body:**
```json
{
    "name": "John Doe",
    "email": "john@example.com",
    "password": "password123",
    "password_confirmation": "password123"
}
```

**Response (201):**
```json
{
    "user": {
        "id": 1,
        "name": "John Doe",
        "email": "john@example.com"
    },
    "token": "eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9..."
}
```

**Error Response (422):**
```json
{
    "message": "The given data was invalid.",
    "errors": {
        "email": ["The email has already been taken."],
        "password": ["The password must be at least 8 characters."]
    }
}
```

#### 2. Login User
**POST** `/api/login`

**Request Body:**
```json
{
    "email": "john@example.com",
    "password": "password123"
}
```

**Response (200):**
```json
{
    "token": "eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9...",
    "user": {
        "id": 1,
        "name": "John Doe",
        "email": "john@example.com"
    }
}
```

**Error Response (401):**
```json
{
    "message": "Invalid credentials."
}
```

#### 3. Logout User
**POST** `/api/logout`

**Headers:**
```
Authorization: Bearer <your_jwt_token>
```

**Response (200):**
```json
{
    "message": "Logged out successfully."
}
```

### User Management

#### 4. Get User Profile
**GET** `/api/profile`

**Headers:**
```
Authorization: Bearer <your_jwt_token>
```

**Response (200):**
```json
{
    "user": {
        "id": 1,
        "name": "John Doe",
        "email": "john@example.com",
        "created_at": "25-Sep-2025",
        "updated_at": "25-Sep-2025"
    },
    "post_count": 5,
    "comment_count": 3,
    "reaction_count": 10
}
```

### Posts

#### 5. Get User's Posts
**GET** `/api/posts`

**Headers:**
```
Authorization: Bearer <your_jwt_token>
```

**Response (200):**
```json
{
    "posts": {
        "current_page": 1,
        "data": [
            {
                "id": 1,
                "user_id": 1,
                "title": "My First Post",
                "content": "This is the content of my first post",
                "image": "posts/image1.jpg",
                "created_at": "2025-09-25T00:00:00.000000Z",
                "updated_at": "2025-09-25T00:00:00.000000Z",
                "user": {
                    "id": 1,
                    "name": "John Doe",
                    "email": "john@example.com"
                }
            }
        ],
        "first_page_url": "http://localhost:8000/api/posts?page=1",
        "from": 1,
        "last_page": 1,
        "last_page_url": "http://localhost:8000/api/posts?page=1",
        "next_page_url": null,
        "path": "http://localhost:8000/api/posts",
        "per_page": 10,
        "prev_page_url": null,
        "to": 1,
        "total": 1
    },
    "message": "Posts retrieved successfully"
}
```

#### 6. Create Post
**POST** `/api/posts`

**Headers:**
```
Authorization: Bearer <your_jwt_token>
Content-Type: multipart/form-data
```

**Request Body:**
```json
{
    "title": "My Awesome Post",
    "content": "This is the content of my awesome post",
    "image": "(optional) image file"
}
```

**Response (200):**
```json
{
    "post": {
        "id": 2,
        "user_id": 1,
        "title": "My Awesome Post",
        "content": "This is the content of my awesome post",
        "image": "posts/image2.jpg",
        "created_at": "2025-09-25T00:00:00.000000Z",
        "updated_at": "2025-09-25T00:00:00.000000Z"
    },
    "message": "Post created successfully"
}
```

#### 7. Update Post
**PUT** `/api/posts/{id}`

**Headers:**
```
Authorization: Bearer <your_jwt_token>
```

**Request Body:**
```json
{
    "title": "Updated Title",
    "content": "Updated content"
}
```

**Response (200):**
```json
{
    "post": {
        "id": 2,
        "user_id": 1,
        "title": "Updated Title",
        "content": "Updated content",
        "image": "posts/image2.jpg",
        "created_at": "2025-09-25T00:00:00.000000Z",
        "updated_at": "2025-09-25T00:00:00.000000Z"
    },
    "message": "Post updated successfully"
}
```

#### 8. Delete Post
**DELETE** `/api/posts/{id}`

**Headers:**
```
Authorization: Bearer <your_jwt_token>
```

**Response (200):**
```json
{
    "message": "Post deleted successfully"
}
```

### Feed & Social Features

#### 9. Get All Posts (Feed)
**GET** `/api/posts` (Note: This endpoint is defined in HomeController)

**Headers:**
```
Authorization: Bearer <your_jwt_token>
```

**Response (200):**
```json
[
    {
        "id": 1,
        "user_id": 1,
        "title": "My First Post",
        "content": "This is the content of my first post",
        "image": "posts/image1.jpg",
        "created_at": "2025-09-25T00:00:00.000000Z",
        "updated_at": "2025-09-25T00:00:00.000000Z",
        "user": {
            "id": 1,
            "name": "John Doe",
            "email": "john@example.com"
        },
        "comments": [...],
        "reactions": [...]
    }
]
```

#### 10. Get Comments by Post
**GET** `/api/posts/{postId}/comments`

**Headers:**
```
Authorization: Bearer <your_jwt_token>
```

**Response (200):**
```json
[
    {
        "id": 1,
        "post_id": 1,
        "user_id": 1,
        "content": "This is a great post!",
        "created_at": "2025-09-25T00:00:00.000000Z",
        "updated_at": "2025-09-25T00:00:00.000000Z"
    }
]
```

#### 11. Get Reactions by Post
**GET** `/api/posts/{postId}/reactions`

**Headers:**
```
Authorization: Bearer <your_jwt_token>
```

**Response (200):**
```json
[
    {
        "id": 1,
        "user_id": 1,
        "post_id": 1,
        "created_at": "2025-09-25T00:00:00.000000Z",
        "updated_at": "2025-09-25T00:00:00.000000Z"
    }
]
```

## Data Models

### User
```json
{
    "id": "integer",
    "name": "string",
    "email": "string",
    "email_verified_at": "datetime|null",
    "created_at": "datetime",
    "updated_at": "datetime"
}
```

### Post
```json
{
    "id": "integer",
    "user_id": "integer",
    "title": "string",
    "content": "string",
    "image": "string|null",
    "created_at": "datetime",
    "updated_at": "datetime",
    "user": "User",
    "comments": "Comment[]",
    "reactions": "Reaction[]"
}
```

### Comment
```json
{
    "id": "integer",
    "post_id": "integer",
    "user_id": "integer",
    "content": "string",
    "created_at": "datetime",
    "updated_at": "datetime",
    "user": "User",
    "post": "Post"
}
```

### Reaction
```json
{
    "id": "integer",
    "user_id": "integer",
    "post_id": "integer",
    "created_at": "datetime",
    "updated_at": "datetime",
    "user": "User",
    "post": "Post"
}
```

## Error Handling

The API uses standard HTTP status codes:

- **200:** Success
- **201:** Created
- **400:** Bad Request
- **401:** Unauthorized
- **403:** Forbidden
- **404:** Not Found
- **422:** Validation Error
- **500:** Internal Server Error

Error responses follow this format:
```json
{
    "message": "Error description",
    "errors": {
        "field": ["Error message"]
    }
}
```

## File Upload

- Supported formats: JPEG, PNG, JPG, GIF
- Maximum file size: 2MB
- Files are stored in `storage/app/public/posts/`
- Access uploaded images via `/storage/posts/filename`

## Development

### Running Tests
```bash
php artisan test
```

### Code Style
```bash
php artisan pint
```

### Development Server
```bash
php artisan serve
```

## Contributing

1. Fork the repository
2. Create a feature branch
3. Make your changes
4. Add tests if applicable
5. Run tests and linting
6. Submit a pull request

## License

This project is licensed under the MIT License.

## Support

For support, please contact the development team or create an issue in the repository.

---

**Note:** This API is designed for development and testing purposes. Make sure to implement proper security measures before deploying to production.
