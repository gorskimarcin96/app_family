# app_family

## Run app

```sh
docker compose -f docker/docker-compose.yml up -d
```

### Run migrations for dev
```sh
docker compose -f docker/docker-compose.yml exec auth ./bin/console doctrine:migrations:migrate -n
```

### Run migrations for tests
```sh
docker compose -f docker/docker-compose.yml exec auth ./bin/console doctrine:database:create --env=test --if-not-exists
docker compose -f docker/docker-compose.yml exec auth ./bin/console doctrine:migrations:migrate --env=test -n
```

### Run tests
```sh
docker compose -f docker/docker-compose.yml exec auth ./bin/phpunit
```

### Crete user to app
```sh
docker compose -f docker/docker-compose.yml exec auth ./bin/console app:user:create "test@example.com" "secret"
```
