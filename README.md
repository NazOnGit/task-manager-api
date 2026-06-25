# Task Manager API (РУС)

## О проекте

REST API для управления задачами, разработанный на Laravel 13.

Проект поддерживает:

- создание задачи;
- получение списка задач;
- получение задачи по ID;
- обновление задачи;
- удаление задачи;
- поиск по названию;
- сортировку по сроку выполнения (`due_date`);
- сортировку по дате создания (`created_at`);
- пагинацию;
- документацию Swagger.

---

## Используемые технологии

- PHP 8.2
- Laravel 13
- MySQL
- Eloquent ORM
- Swagger (L5-Swagger)
- Postman

---

## Запуск проекта

Клонировать репозиторий:

```bash
git clone <repository-url>
cd task-manager-api
```

Установить зависимости:

```bash
composer install
```

Создать файл окружения:

```bash
cp .env.example .env
```

Создать ключ приложения:

```bash
php artisan key:generate
```

Настроить подключение к базе данных в файле `.env`.

Выполнить миграции:

```bash
php artisan migrate
```

Запустить проект:

```bash
php artisan serve
```

---

## Swagger

Swagger доступен по адресу:

```text
http://127.0.0.1:8000/api/documentation
```

---

## API

| Метод  | Endpoint        | Описание              |
| ------ | --------------- | --------------------- |
| GET    | /api/tasks      | Получить список задач |
| POST   | /api/tasks      | Создать задачу        |
| GET    | /api/tasks/{id} | Получить задачу по ID |
| PUT    | /api/tasks/{id} | Обновить задачу       |
| DELETE | /api/tasks/{id} | Удалить задачу        |

---

## Поиск

Поиск по названию задачи:

```text
GET /api/tasks?search=Laravel
```

---

## Сортировка

По сроку выполнения:

```text
GET /api/tasks?sort=due_date
```

По дате создания:

```text
GET /api/tasks?sort=created_at
```

---

## Пагинация

Получить вторую страницу:

```text
GET /api/tasks?page=2
```

---

## Валидация

При создании и обновлении задачи проверяются:

- title
- description
- due_date
- status
- priority
- category

Если данные неверны, API возвращает ошибку **422 Unprocessable Entity**.

---

## Тестирование

Проект протестирован с помощью:

- Postman
- Swagger UI

Проверены:

- создание задачи;
- получение списка задач;
- получение задачи по ID;
- обновление задачи;
- удаление задачи;
- поиск;
- сортировка;
- пагинация;
- валидация данных.

---

# Task Manager API (ENGLISH)

## About the Project

This project is a REST API for task management built with Laravel 13.

The API supports:

- Create a task
- Get a list of tasks
- Get a task by ID
- Update a task
- Delete a task
- Search tasks by title
- Sort tasks by due date (`due_date`)
- Sort tasks by creation date (`created_at`)
- Pagination
- Swagger API documentation

---

## Technologies

- PHP 8.2
- Laravel 13
- MySQL
- Eloquent ORM
- Swagger (L5-Swagger)
- Postman

---

## Installation

Clone the repository:

```bash
git clone <repository-url>
cd task-manager-api
```

Install dependencies:

```bash
composer install
```

Create the environment file:

```bash
cp .env.example .env
```

Generate the application key:

```bash
php artisan key:generate
```

Configure the database connection in the `.env` file.

Run the migrations:

```bash
php artisan migrate
```

Start the development server:

```bash
php artisan serve
```

---

## Swagger Documentation

Swagger UI is available at:

```text
http://127.0.0.1:8000/api/documentation
```

---

## API Endpoints

| Method | Endpoint        | Description       |
| ------ | --------------- | ----------------- |
| GET    | /api/tasks      | Get all tasks     |
| POST   | /api/tasks      | Create a new task |
| GET    | /api/tasks/{id} | Get a task by ID  |
| PUT    | /api/tasks/{id} | Update a task     |
| DELETE | /api/tasks/{id} | Delete a task     |

---

## Search

Search tasks by title:

```text
GET /api/tasks?search=Laravel
```

---

## Sorting

Sort by due date:

```text
GET /api/tasks?sort=due_date
```

Sort by creation date:

```text
GET /api/tasks?sort=created_at
```

---

## Pagination

Get the second page of results:

```text
GET /api/tasks?page=2
```

Search, sorting, and pagination can also be combined:

```text
GET /api/tasks?search=Laravel&sort=created_at&page=2
```

---

## Validation

The following fields are validated when creating or updating a task:

- title
- description
- due_date
- status
- priority
- category

If validation fails, the API returns:

```text
HTTP 422 Unprocessable Entity
```

---

## Testing

The API was tested using:

- Postman
- Swagger UI

The following functionality was verified:

- Create task
- Get all tasks
- Get task by ID
- Update task
- Delete task
- Search
- Sort
- Pagination
- Request validation
