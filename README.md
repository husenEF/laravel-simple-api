# 📄 README.md

## 🧩 Overview

This project is a simple Laravel API.  
The main goal is to demonstrate **clean code**, **good structure**, and **maintainable logic**, not just correctness.

The API provides:

- Create User
- Get Users (with filtering, sorting, pagination)
- Relationship count (orders_count)
- Role-based `can_edit` field
- Basic seeding to generate realistic data

Everything is designed in a way that another developer can easily read and extend the code.

---

## 🛠️ Tech Stack

- Laravel 10
- PHP 8+
- Laravel Sanctum (optional for authentication)
- Scramble (optional for API docs)
- mailhog (optional for email testing)

---

# 🚀 Installation

```bash
composer install
cp .env.example .env
php artisan key:generate

# run mailhog
docker-compose -f docker/docker-compose.yml up -d
```

Configure your database in `.env`, then run:

```bash
php artisan migrate --seed
```

This will generate:

- 1 Administrator
- 1 Manager
- 50 Normal Users
- Random fake orders for each normal user

---

# 📡 API Endpoints

## 🔹 GET `/api/users`

Retrieve paginated list of users with:

- Search
- Sort
- Pagination
- orders_count
- can_edit
- Wrapped under `user` key

### Query Parameters:

| Name   | Type    | Description                                                        |
|--------|---------|--------------------------------------------------------------------|
| search | string  | Search by name or email                                            |
| page   | integer | Page number (default: 1)                                           |
| sortBy | string  | Allowed: `id`, `name`, `email`, `role`, `created_at`, `updated_at` |

Example:

```
GET /api/users?search=john&sortBy=name&page=1
```

---

## 🔹 POST `/api/users`

Create new user.

Required fields:

- name
- email
- password + password_confirmation
- role (optional, default: user)

Password automatically hashed.

---

# 🔐 Role & can_edit Logic

Simple role-based edit permission:

- **Administrator** → can edit *normal users*
- **Manager** → can edit *normal users*
- **User** → can edit *themselves only*
- **No one** can edit admin or manager

---

# 🧱 Code Structure

- `UserService` handles business logic
- `UserResource` formats API response
- `UserPolicy` optional (can be extended)
- Database seeders for testable data
- Model helpers for role checking

Everything is split to keep code easy to read and maintain.

---

# 🧪 Testing

Start server:

```bash
php artisan serve
```

Test using Postman, Thunder Client, or API Docs (`/docs/api` if Scramble is enabled).

---

# 📘 How to Use

After running:

```bash
php artisan migrate --seed
php artisan serve
```

### 📍 Get users

```
http://localhost:8000/api/users
```

With filters:

```
http://localhost:8000/api/users?search=alice&sortBy=email&page=2
```

### 📍 Create user

POST `/api/users`  
Body:

```json
{
    "name": "New User",
    "email": "new@example.com",
    "password": "password",
    "password_confirmation": "password",
    "role": "user"
}
```

---

# 🤝 How to Contribute

Contributions are welcome!  
Follow this simple flow:

### 1. Fork this repository

### 2. Clone your fork

### 3. Create new branch : prefer use [nvie git flow](https://nvie.com/posts/a-successful-git-branching-model/)

### 4. Make changes

### 5. Commit

### 6. Push

### 7. Open Pull Request

---

# 🙏 Thank You!

Hope this project is easy to review and enjoyable to read!
