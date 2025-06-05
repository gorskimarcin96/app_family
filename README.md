# app_family

## Run app

```sh
docker compose -f docker/docker-compose.yml up -d
```

### Run migrations for auth - dev

```sh
docker compose -f docker/docker-compose.yml exec auth ./bin/console doctrine:migrations:migrate -n
```

### Run migrations for auth - tests

```sh
docker compose -f docker/docker-compose.yml exec auth ./bin/console doctrine:database:create --env=test --if-not-exists
docker compose -f docker/docker-compose.yml exec auth ./bin/console doctrine:migrations:migrate --env=test -n
```

### Run for auth tests

```sh
docker compose -f docker/docker-compose.yml exec auth ./bin/phpunit
```

### Crete user to app

```sh
docker compose -f docker/docker-compose.yml exec auth ./bin/console app:user:create "test@example.com" "secret"
```

## Helpers

### Create front project from docker

```sh
docker run --rm -v "$PWD":/php -w /php node:20 npm create vite@latest node -- --template react-ts
```
