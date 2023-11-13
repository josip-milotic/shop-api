## Setup

1. Run `docker compose up -d` to start the containers
2. Run `docker exec -it app sh` to connect to the container
3. Run `composer install` if needed
4. Run `php artisan migrate:fresh` to set up the database. Optionally you can run it with `--seed` flag to seed dummy data
