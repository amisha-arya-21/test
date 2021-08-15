# Test Api
This project will fetch data for football leagues, teams and matches from an external API, Rapid API.
A player will make a guess for the game and get a point for a right guess.

## Unit Testing

If you are using docker, just run these commands.

```bash
docker-compose up -d
```
```bash
docker exec -it test-api php vendor/bin/phpunit tests/
```