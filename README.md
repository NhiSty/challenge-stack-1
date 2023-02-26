# Symfony Docker (PHP8 / Caddy / Postgresql)

A [Docker](https://www.docker.com/)-based installer and runtime for the [Symfony](https://symfony.com) web framework, with full [HTTP/2](https://symfony.com/doc/current/weblink.html), HTTP/3 and HTTPS support.

## Getting Started

1. If not already done, [install Docker Compose](https://docs.docker.com/compose/install/)
2. Run `docker compose build --pull --no-cache` to build fresh images
3. Run `docker compose up` (the logs will be displayed in the current shell) or Run `docker compose up -d` to run in background 
4. Open `https://localhost` in your favorite web browser and [accept the auto-generated TLS certificate](https://stackoverflow.com/a/15076602/1352334)
5. Run  `npm install`
6. Run  `npm run dev` to start webpack encore
7. Run  `docker compose exect -it php bin/console d:f:l -n` to load fixtures
8. Run  `docker compose exect -it php bin/console messenger:consume async -vv` to cosume queued mails
9. Run `docker compose down --remove-orphans` to stop the Docker containers.
10. Run `docker compose logs -f` to display current logs, `docker compose logs -f [CONTAINER_NAME]` to display specific container's current logs

## Configuration
Add your sendblue and stripe api key in the .env file
