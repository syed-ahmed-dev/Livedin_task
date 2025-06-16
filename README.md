# Task Management API

This is a RESTful API for managing tasks using Laravel.

## Setup Instructions

### Prerequisites

- PHP (version 8.0 or higher)
- Composer
- Laravel (latest stable version)
- MySQL or any other database supported by Laravel

### Installation Steps

1. **Clone the Repository**

   ```bash
   git clone https://github.com/syed-ahmed-dev/Livedin_task.git
   cd Livedin_task
   ```

2. **Install Dependencies**

   ```bash
   composer install
   ```

3. **Set Up the Environment**

   ```bash
   cp .env.example .env
   ```

   Update your `.env` file with your database credentials:

   ```env
   DB_CONNECTION=mysql
   DB_HOST=127.0.0.1
   DB_PORT=3306
   DB_DATABASE=your_database_name
   DB_USERNAME=your_username
   DB_PASSWORD=your_password
   ```

4. **Generate Application Key**

   ```bash
   php artisan key:generate
   ```

5. **Run Migrations**

   ```bash
   php artisan migrate
   ```

6. **Seed the Database (Optional)**

   ```bash
   php artisan db:seed
   ```

7. **Set Up Sanctum Authentication**

   ```bash
   php artisan vendor:publish --provider="Laravel\Sanctum\SanctumServiceProvider"
   php artisan migrate
   ```

8. **Run the Application**

   ```bash
   php artisan serve
   ```

   The app will be available at `http://localhost:8000`.

---

## API Endpoint Descriptions

### Base URL

```
http://localhost:8000/api
```

### Endpoints

| Method | Endpoint            | Description                     |
|--------|---------------------|---------------------------------|
| POST   | /login              | User Login                      |
| POST   | /signup             | User Signup                     |
| GET    | /tasks              | Get all tasks (auth required)   |
| POST   | /tasks              | Create a new task               |
| GET    | /tasks/{id}         | Get a specific task by ID       |
| PUT    | /tasks/{id}         | Update a specific task          |
| DELETE | /tasks/{id}         | Delete a specific task          |
| GET    | /task/searches      | Search tasks by title/keyword   |

---

## Request/Response Examples

### Create Task

**Request:**

```http
POST /api/tasks
Authorization: Bearer {token}
Content-Type: application/json

{
  "title": "Buy groceries",
  "description": "Milk, Bread, Eggs",
  "completed": false
}
```

**Response:**

```json
{
  "success": true,
  "status": 201,
  "message": "Task created successfully",
  "data": {
    "id": 1,
    "title": "Buy groceries",
    "description": "Milk, Bread, Eggs",
    "completed": false,
    "created_at": "2025-06-16T00:00:00.000000Z",
    "updated_at": "2025-06-16T00:00:00.000000Z"
  }
}
```

### Get All Tasks

**Request:**

```http
GET /api/tasks
Authorization: Bearer {token}
```

**Response:**

```json
{
  "success": true,
  "status": 200,
  "message": "Tasks retrieved successfully",
  "data": [
    {
      "id": 1,
      "title": "Buy groceries",
      "description": "Milk, Bread, Eggs",
      "completed": false
    }
  ]
}
```

### Update Task

**Request:**

```http
PUT /api/tasks/1
Authorization: Bearer {token}
Content-Type: application/json

{
  "title": "Buy groceries and snacks",
  "completed": true
}
```

**Response:**

```json
{
  "success": true,
  "status": 200,
  "message": "Task updated successfully",
  "data": {
    "id": 1,
    "title": "Buy groceries and snacks",
    "description": "Milk, Bread, Eggs",
    "completed": true
  }
}
```

### Delete Task

**Request:**

```http
DELETE /api/tasks/1
Authorization: Bearer {token}
```

**Response:**

```json
{
  "success": true,
  "status": 200,
  "message": "Task deleted successfully"
}
```

### Search Tasks

**Request:**

```http
GET /api/task/searches?title=groceries
Authorization: Bearer {token}
```

**Response:**

```json
{
  "success": true,
  "status": 200,
  "message": "Search result",
  "data": [
    {
      "id": 1,
      "title": "Buy groceries and snacks",
      "description": "Milk, Bread, Eggs",
      "completed": true
    }
  ]
}
```

## Authentication

- Sanctum is used for token-based authentication.
- After login or signup, send the token in the `Authorization` header for all requests:

```http
Authorization: Bearer {your-access-token}
```

## Testing

```bash
php artisan test
```

## Conclusion

This README outlines how to install, use, and test the Laravel Task Management API. For any contributions or issues, please visit the project repository.