# Delivery Task API

This is a Laravel API for managing restaurant delivery assignments. 

## Requirements:
- Postman (https://www.postman.com/downloads/)

## Project Set Up:

### Clone the project

    git clone git@github.com:unsta/av-delivery-task.git

### Create an `.env` file from `.env.example`

    cp .env.example .env

### From the project directory run

    composer install

### To start the Docker containers in the background run

    ./vendor/bin/sail up -d

Note: Make sure that all the containers are started successfully and there are no port conflicts!

### To generate an APP_KEY run

    ./vendor/bin/sail artisan key:generate

### Run the migrations

    ./vendor/bin/sail artisan migrate:fresh

### Run the seeders

    ./vendor/bin/sail artisan db:seed

### Run code quality checks (Check the `app/Makefile`)

    make pipeline

### Run the Feature tests (Docker provides a testing db)

    make test-feature

## API Endpoints (v1)

All API endpoints are prefixed with `/api/v1/`

### 1. Login
**POST** `/api/v1/login`

```bash
curl --location --request POST 'http://localhost:8080/api/v1/login' \
--header 'Accept: application/json' \
--header 'Content-Type: application/json' \
--data-raw '{
    "email": "bob.bobber@va.com",
    "password": "password123"
}'
```

**Response:**
```json
{
    "status": "success",
    "message": "User logged in successfully",
    "token": "6|ktMrrICuwuRy9X6GboHhFXshNsUIWmLgNkam65dJf2312de3"
}
```

NOTE: The TOKEN is needed for the rest of the requests!

### 2. Randomize
**POST** `/api/v1/randomize`

```bash
curl --location --request POST 'http://localhost:8080/api/v1/randomize' \
--header 'Accept: application/json' \
--header 'Authorization: Bearer 6|ktMrrICuwuRy9X6GboHhFXshNsUIWmLgNkam65dJf2312de3'
```

**Response:**
```json
{
  "success": true,
  "message": "Randomization completed successfully",
  "drivers_count": 100,
  "restaurants_count": 10
}
```

### 3. Solve
**POST** `/api/v1/solve`

```bash
curl --location --request POST 'http://localhost:8080/api/v1/solve' \
--header 'Accept: application/json' \
--header 'Authorization: Bearer 6|ktMrrICuwuRy9X6GboHhFXshNsUIWmLgNkam65dJf2312de3'
```

**Response:**
```json
{
  "success": true,
  "message": "Assignment completed successfully",
  "assignments_count": 100
}
```

### 4. Report
**GET** `/api/v1/report`

```bash
curl --location --request GET 'http://localhost:8080/api/v1/report' \
--header 'Accept: application/json' \
--header 'Authorization: Bearer 6|ktMrrICuwuRy9X6GboHhFXshNsUIWmLgNkam65dJf2312de3'
```

**Response:**
```json
{
  "restaurants": [
    {
      "id": 1,
      "title": "Хепи Бъкстон",
      "latitude": 42.667122,
      "longitude": 23.281657,
      "orders_count_before": 25,
      "orders_count_after": 5,
      "assigned_capacity": 20,
      "assigned_drivers_count": 6
    }
  ],
  "drivers": [
    {
      "id": 1,
      "name": "Driver 1",
      "latitude": 42.668,
      "longitude": 23.282,
      "capacity": 3,
      "assigned_restaurant_id": 1,
      "assigned_restaurant_title": "Хепи Бъкстон",
      "distance_to_assigned_km": 2.45,
      "closest_restaurant_id": 1,
      "closest_restaurant_title": "Хепи Бъкстон",
      "distance_to_closest_km": 2.45
    }
  ],
  "summary": {
    "total_drivers": 100,
    "assigned_drivers": 100,
    "total_restaurants": 10,
    "total_orders": 275,
    "total_capacity": 250,
    "assigned_capacity": 250,
    "remaining_orders": 25,
    "average_distance_km": 3.45,
    "total_distance_km": 345.0
  }
}


```
### 5. Logout
**POST** `/api/v1/logout`

```bash
curl --location --request POST 'http://localhost:8080/api/v1/logout' \
--header 'Accept: application/json' \
--header 'Authorization: Bearer 6|ktMrrICuwuRy9X6GboHhFXshNsUIWmLgNkam65dJf2312de3'
```

**Response:**
```json
{
    "status": "success",
    "message": "Logged out successfully"
}
```

## Future Ideas/Improvements
- `UI with map`
- `Improved algorithm`
- `Unit Tests`
