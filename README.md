An API project where users create enrollments to organizer presentations.

### Installation

#### Prerequisites

In order to install the application, you need the following:
- Docker 20.10.* or higher with the compose plugin
- Postman for API consumer

#### Installation steps

1. Clone the repository

`git clone git@github.com:Mihai24/presentation-appointment-api.git`

2. Setup your local environment values

`cp ./docker/database/.env.dist ./docker/database/.env`

`cp ./.env ./.env.local`

3. Set the values for the environment variables in the `./docker/database/.env` and `./.env.local` files based on your configuration.

4. Build and start the Docker containers

`docker compose down`
`docker compose build`
`docker compose up -d`

5. Enter the php-fpm container
`docker exec -it polyclinic-appointment-api-php-1 sh`

6. Inside the container install project dependencies
`composer install`

7. Run migrations and fixtures
`bin/console doctrine:migrations:migrate --no-interaction`
`bin/console d:f:l --no-interaction`

8. Run unit tests
`bin/console phpunit`

#### Project endpoints
The endpoints are consumed by Postman

Every endpoint require an X-APP-TOKEN constant in Headers with a generated token from the database.

User endpoints

`POST /api/users` with
    Json Body
    {
        "firstName": "dasdasd",
        "lastName": "blaasdas1",
        "email": "use1r12123@gmail.com",
        "password": "password"
    }
`GET /api/users`
`GET /api/users/{id}`
`GET /api/users/{id}/presentation`
`GET /api/users/{id}/enrollments`
`DELETE /api/users/{id}`
`UPDATE /api/users/{id}` with the following JSON Body
    {
        "firstName": "first",
        "lastName": "last",
        "email": "test@gmail.com",
        "password": "password"
    }

Enrollment endpoints

`GET /api/enrollments`
`GET /api/enrollments/{id}`
`DELETE /api/enrollments/{id}`
`POST /api/presentation/{id}/enrollment`

Presentation endpoints

`POST /api/presentation` with the following JSON Body
    {
        "name": "presentation",
        "description": "description",
        "startsAt": "09.08.2023 15:00",
        "endsAt": "09.08.2023 16:00"
    }
`GET /api/presentation`
`GET /api/presentation/{id}`
`DELETE /api/presentation/{id}`

Token endpoints"
`POST /api/tokens`

#### Features which are not implemented
- authentication using credentials
- validators for enrollments overlapping
- validators for presentations overlapping
- custom messages for exceptions
- validators improvement
- refactoring 
