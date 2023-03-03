# endpoint
POST /api/v1/sigin

POST /api/v1/signup

GET /api/v1/info

PUT /api/v1/info

DELETE /api/v1/token

GET /api/v1/latency

# running in docker container
```
sail up -d
```

# run migration
```
sail artisan migrate:refresh --seed
```

# run tests
```
sail artisan test
```