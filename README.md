# TASK MANAGER API (ENGLISH)

## SECTION 1 - About the Project

Task Manager REST API is a backend application built with Laravel 13 for managing tasks.

The project demonstrates REST API development using Laravel, including CRUD operations, request validation, search, sorting, pagination, database migrations, Eloquent ORM, and Swagger documentation.

## SECTION 2 - API Features

- Create a task
- Retrieve all tasks
- Retrieve a task by ID
- Update a task
- Delete a task
- Search tasks by title
- Sort tasks by due date (`due_date`)
- Sort tasks by creation date (`created_at`)
- Paginate task results
- Validate incoming requests
- Swagger API documentation

## SECTION 3 - Technologies

- PHP 8.2
- Laravel 13
- MySQL
- Eloquent ORM
- Swagger (L5-Swagger)
- Postman

## SECTION 4 - Installation

**Clone the repository:**

```bash
git clone <repository-url>
cd task-manager-api
```

**Install dependencies:**

```bash
composer install
```

**Create the environment file:**

```bash
cp .env.example .env
```

**Generate the application key:**

```bash
php artisan key:generate
```

**Configure the database connection in the `.env` file.**

**Run the migrations:**

```bash
php artisan migrate
```

**Start the development server:**

```bash
php artisan serve
```

## SECTION 5 - Swagger Documentation

**Swagger UI is available at:**

```
http://127.0.0.1:8000/api/documentation
```

## SECTION 6 - API Endpoints

| Method | Endpoint        | Description       |
| ------ | --------------- | ----------------- |
| GET    | /api/tasks      | Get all tasks     |
| POST   | /api/tasks      | Create a new task |
| GET    | /api/tasks/{id} | Get a task by ID  |
| PUT    | /api/tasks/{id} | Update a task     |
| DELETE | /api/tasks/{id} | Delete a task     |

## SECTION 7 - Search, Sort, and Pagination

**Search by Title:**

```
GET /api/tasks?search=Laravel
```

**Sort by Due Date:**

```
GET /api/tasks?sort=due_date
```

**Sort by Creation Date:**

```
GET /api/tasks?sort=created_at
```

**Get Second Page:**

```
GET /api/tasks?page=2
```

**Combined Query:**

```
GET /api/tasks?search=Laravel&sort=created_at&page=2
```

## SECTION 8 - Validation

**Validated Fields:**

The following fields are validated when creating or updating a task:

- `title` — Task title (required)
- `description` — Task description (optional)
- `due_date` — Task deadline (required)
- `status` — Task status (required: completed or not_completed)
- `priority` — Task priority (required: low, medium, or high)
- `category` — Task category (required)

**Error Response:**

If validation fails, the API returns:

```
HTTP 422 Unprocessable Entity
```

## SECTION 9 - Testing

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

## SECTION 10 - HOW AN API REQUEST MOVES THROUGH THE APPLICATION

This section explains how a request travels through the Laravel application, starting from the client (Postman or Swagger) and ending at the MySQL database.

```

Client (Postman / Swagger)
▼
routes/api.php
▼
TaskController
▼
Task Model
▼
MySQL Database
▲
Migration

```

### 1. Client (Postman / Swagger)

**Purpose:** The client is the application that sends HTTP requests to the Laravel API.

**HTTP Methods:**

```

GET /api/tasks
POST /api/tasks
PUT /api/tasks/3
DELETE /api/tasks/3

```

**Data Types Sent by Client:**

**A. URL Query Parameters**

Used mainly for filtering or controlling the returned results.

```

GET /api/tasks?search=Laravel
GET /api/tasks?sort=due_date
GET /api/tasks?page=2
GET /api/tasks?search=Laravel&sort=created_at&page=2

```

Laravel automatically stores these URL query values inside the Request object:

```php
$request->search
$request->sort
$request->page
```

**B. JSON Request Body**

Used when creating or updating a task.

```json
{
    "title": "Learn Laravel",
    "description": "Complete technical task",
    "due_date": "2026-06-25 18:00:00",
    "status": "not_completed",
    "priority": "high",
    "category": "Work"
}
```

Laravel automatically places each JSON value inside the Request object:

```php
$request->title
$request->description
$request->status
$request->priority
```

These values are later used by the controller.

### 2. routes/api.php

**Purpose:** This file receives every incoming API request and matches it to the correct controller method.

**Routing Logic:**

Routes match:

- The HTTP method (GET, POST, PUT, DELETE)
- The endpoint URL

**Example Match:**

```
POST /api/tasks
```

Laravel matches this to:

```php
Route::apiResource('tasks', TaskController::class);
```

**Controller Method Mapping:**

```
GET           → index()
POST          → store()
GET /{id}     → show()
PUT /{id}     → update()
DELETE /{id}  → destroy()
```

### 3. TaskController

**Purpose:** The controller receives the request from routes/api.php and decides what action should be performed.

**Available Methods:**

- `store()` — Creates a new task
- `show()` — Returns one task from the tasks table
- `update()` — Updates an existing task
- `destroy()` — Deletes an existing task
- `index()` — Returns task rows from the tasks table

**Additional Features:**

The controller can also:

- Search rows
- Sort rows
- Paginate rows

**Accessing Request Data:**

If the client sends JSON data, Laravel automatically makes it available through the `Request` object:

```php
$request->title
$request->priority
$request->status
```

These values come directly from the JSON body sent by Postman or Swagger.

### 4. Task Model

**Purpose:** The Task model represents the **tasks table** inside the MySQL database and communicates with it.

**Model Methods:**

```php
Task::create()
Task::findOrFail()
Task::query()
Task::update()
Task::delete()
```

**Mass Assignment Protection:**

The model defines which database columns are allowed to receive data using:

```php
protected $fillable
```

**Allowed Columns:**

```php
'title',
'description',
'due_date',
'status',
'priority',
'category'
```

Only these columns can be filled when using `Task::create()` or `$task->update()`.

### 5. MySQL Database

**Purpose:** The MySQL database stores all task records as rows in the `tasks` table.

**Operations:**

- Creating a task → inserts a new row
- Updating a task → modifies an existing row
- Deleting a task → removes a row
- Listing tasks → retrieves rows from the table

### 6. Migration

**Purpose:** The migration defines the structure of the `tasks` table and creates database columns before the application starts using them.

**Table Columns:**

- `id` — Unique task identifier
- `title` — Task name (required)
- `description` — Task details
- `due_date` — Task deadline
- `status` — Task status (completed or not_completed)
- `priority` — Task priority (low, medium, high)
- `category` — Task category
- `created_at` — Creation timestamp
- `updated_at` — Last update timestamp

---

# TASK MANAGER API (РУССКИЙ)

## РАЗДЕЛ 1 - О ПРОЕКТЕ

API менеджера задач — это серверное приложение, разработанное на Laravel 13 для управления задачами.

Проект демонстрирует разработку REST API с использованием Laravel, включая операции CRUD, валидацию запросов, поиск, сортировку, пагинацию, миграции баз данных, ORM Eloquent и документацию Swagger.

## РАЗДЕЛ 2 - ФУНКЦИИ API

- Создание задачи
- Получение списка всех задач
- Получение одной задачи по ID
- Обновление задачи
- Удаление задачи
- Поиск задач по названию
- Сортировка задач по сроку выполнения (`due_date`)
- Сортировка задач по дате создания (`created_at`)
- Пагинация результатов
- Валидация входящих запросов
- Документация Swagger

## РАЗДЕЛ 3 - ИСПОЛЬЗУЕМЫЕ ТЕХНОЛОГИИ

- PHP 8.2
- Laravel 13
- MySQL
- Eloquent ORM
- Swagger (L5-Swagger)
- Postman

## РАЗДЕЛ 4 - УСТАНОВКА ПРОЕКТА

**Клонировать репозиторий:**

```bash
git clone <repository-url>
cd task-manager-api
```

**Установить зависимости:**

```bash
composer install
```

**Создать файл окружения:**

```bash
cp .env.example .env
```

**Сгенерировать ключ приложения:**

```bash
php artisan key:generate
```

**Настроить подключение к базе данных в файле `.env`.**

**Выполнить миграции:**

```bash
php artisan migrate
```

**Запустить сервер разработки:**

```bash
php artisan serve
```

## РАЗДЕЛ 5 - ДОКУМЕНТАЦИЯ SWAGGER

**Swagger UI доступен по адресу:**

```
http://127.0.0.1:8000/api/documentation
```

## РАЗДЕЛ 6 - ENDPOINTS API

| Метод  | Endpoint        | Описание              |
| ------ | --------------- | --------------------- |
| GET    | /api/tasks      | Получить все задачи   |
| POST   | /api/tasks      | Создать новую задачу  |
| GET    | /api/tasks/{id} | Получить задачу по ID |
| PUT    | /api/tasks/{id} | Обновить задачу       |
| DELETE | /api/tasks/{id} | Удалить задачу        |

## РАЗДЕЛ 7 - ПОИСК, СОРТИРОВКА И ПАГИНАЦИЯ

**Поиск по названию:**

```
GET /api/tasks?search=Laravel
```

**Сортировка по сроку выполнения:**

```
GET /api/tasks?sort=due_date
```

**Сортировка по дате создания:**

```
GET /api/tasks?sort=created_at
```

**Получить вторую страницу:**

```
GET /api/tasks?page=2
```

**Комбинированный запрос:**

```
GET /api/tasks?search=Laravel&sort=created_at&page=2
```

## РАЗДЕЛ 8 - ВАЛИДАЦИЯ

**Проверяемые поля:**

При создании или обновлении задачи проверяются следующие поля:

- `title` — Название задачи (обязательное)
- `description` — Описание задачи (опционально)
- `due_date` — Срок выполнения (обязательное)
- `status` — Статус (обязательное: completed или not_completed)
- `priority` — Приоритет (обязательное: низкий, средний или высокий)
- `category` — Категория (обязательное)

**Ошибка валидации:**

Если данные некорректны, API возвращает:

```
HTTP 422 Unprocessable Entity
```

## РАЗДЕЛ 9 - ТЕСТИРОВАНИЕ

**API протестирован с помощью:**

- Postman
- Swagger UI

**Проверена функциональность:**

- Создание задачи
- Получение всех задач
- Получение задачи по ID
- Обновление задачи
- Удаление задачи
- Поиск
- Сортировка
- Пагинация
- Валидация запросов

## РАЗДЕЛ 10 - КАК ЗАПРОС ПРОХОДИТ ЧЕРЕЗ ПРИЛОЖЕНИЕ

В этом разделе объясняется, как запрос проходит через приложение Laravel, начиная с клиента (Postman или Swagger) и заканчивая базой данных MySQL.

```
Клиент (Postman / Swagger)
▼
routes/api.php
▼
TaskController
▼
Task Model
▼
MySQL Database
▲
Migration
```

### 1. Клиент (Postman / Swagger)

**Назначение:** Клиент — это приложение, которое отправляет HTTP-запросы к Laravel API.

**HTTP методы:**

```
GET /api/tasks
POST /api/tasks
PUT /api/tasks/3
DELETE /api/tasks/3
```

**Типы данных, отправляемые клиентом:**

**A. Параметры URL запроса**

Используются в основном для фильтрации и управления возвращаемыми результатами.

```
GET /api/tasks?search=Laravel
GET /api/tasks?sort=due_date
GET /api/tasks?page=2
GET /api/tasks?search=Laravel&sort=created_at&page=2
```

Laravel автоматически сохраняет эти параметры в объект Request:

```php
$request->search
$request->sort
$request->page
```

**B. JSON тело запроса**

Используется при создании или обновлении задачи.

```json
{
    "title": "Изучить Laravel",
    "description": "Завершить проект менеджера задач",
    "due_date": "2026-06-25 18:00:00",
    "status": "not_completed",
    "priority": "high",
    "category": "Работа"
}
```

Laravel автоматически помещает каждое значение JSON в объект Request:

```php
$request->title
$request->description
$request->status
$request->priority
```

Эти значения позже используются контроллером.

### 2. routes/api.php

**Назначение:** Этот файл получает каждый входящий API запрос и сопоставляет его с нужным методом контроллера.

**Логика маршрутизации:**

Маршруты сопоставляют:

- HTTP метод (GET, POST, PUT, DELETE)
- URL endpoint

**Пример сопоставления:**

```
POST /api/tasks
```

Laravel сопоставляет это с:

```php
Route::apiResource('tasks', TaskController::class);
```

**Сопоставление методов контроллера:**

```
GET           → index()
POST          → store()
GET /{id}     → show()
PUT /{id}     → update()
DELETE /{id}  → destroy()
```

### 3. TaskController

**Назначение:** Контроллер получает запрос от routes/api.php и решает, какое действие должно быть выполнено.

**Доступные методы:**

- `store()` — Создает новую задачу
- `show()` — Возвращает одну задачу из таблицы tasks
- `update()` — Обновляет существующую задачу
- `destroy()` — Удаляет задачу
- `index()` — Возвращает строки задач из таблицы

**Дополнительные возможности:**

Контроллер также может:

- Искать строки
- Сортировать строки
- Разбивать результаты на страницы

**Доступ к данным запроса:**

Если клиент отправляет JSON данные, Laravel автоматически делает их доступными через объект `Request`:

```php
$request->title
$request->priority
$request->status
```

Эти значения поступают непосредственно из JSON тела, отправленного Postman или Swagger.

### 4. Task Model

**Назначение:** Модель Task представляет таблицу **tasks** в базе данных MySQL и взаимодействует с ней.

**Методы модели:**

```php
Task::create()
Task::findOrFail()
Task::query()
Task::update()
Task::delete()
```

**Защита от массового присваивания:**

Модель определяет, какие столбцы базы данных могут получать данные, используя:

```php
protected $fillable
```

**Разрешенные столбцы:**

```php
'title',
'description',
'due_date',
'status',
'priority',
'category'
```

Только эти столбцы могут быть заполнены при использовании `Task::create()` или `$task->update()`.

### 5. MySQL Database

**Назначение:** БД MySQL хранит все записи задач как строки в таблице `tasks`.

**Операции:**

- Создание задачи → вставляет новую строку
- Обновление задачи → изменяет существующую строку
- Удаление задачи → удаляет строку
- Получение списка задач → извлекает строки из таблицы

### 6. Migration

**Назначение:** Миграция определяет структуру таблицы `tasks` и создает столбцы базы данных перед использованием приложением.

**Столбцы таблицы:**

- `id` — Уникальный идентификатор задачи
- `title` — Название задачи (обязательное)
- `description` — Описание задачи
- `due_date` — Срок выполнения
- `status` — Статус задачи (completed или not_completed)
- `priority` — Приоритет (low, medium или high)
- `category` — Категория задачи
- `created_at` — Временная метка создания
- `updated_at` — Временная метка последнего обновления
