# Spookify

[![Laravel Forge Site Deployment Status](https://img.shields.io/endpoint?url=https%3A%2F%2Fforge.laravel.com%2Fsite-badges%2Ffd6bcfd6-7ccc-4814-b427-7ee9bef24efb&style=plastic)](https://forge.laravel.com/servers/665165/sites/1965404)
![Spookify Workflow](https://github.com/LeeConnelly12/spookify/actions/workflows/tests.yml/badge.svg)

## Setup
Clone the repo
```
git clone https://github.com/LeeConnelly12/spookify.git
```
Change into the directory
```
cd spookify
```
Set sail alias
```
alias sail='[ -f sail ] && sh sail || sh vendor/bin/sail'
```
Start containers
```
sail up -d
```
Install composer dependencies
```
docker run --rm \
    -u "$(id -u):$(id -g)" \
    -v "$(pwd):/var/www/html" \
    -w /var/www/html \
    laravelsail/php82-composer:latest \
    composer install --ignore-platform-reqs
```
Run migrations and seeders
```
sail artisan migrate --seed
```
Run dev server
```
sail npm run dev
```


## About Spookify

Spookify is a halloween-themed clone of Spotify where only spooky music is played.
