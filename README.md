# Electronic Store Clone

This project is a WordPress + WooCommerce clone of the Electronic Store demo.

## Prerequisites
- Docker and Docker Compose

## Setup
1. Copy `nginx/default.conf.example` to `nginx/default.conf` if needed.
2. Start services:

   ```bash
   docker-compose up -d
   ```

3. Visit http://localhost:8080 to run WordPress installation.
4. Install and activate WooCommerce plugin in the WP admin.
5. Place the `electronic-store` theme in `wp-content/themes/electronic-store` and activate it.

## Directory Structure
- `docker-compose.yml` WordPress, MySQL, and Nginx services
- `nginx/default.conf` Nginx configuration
- `wp-content/themes/electronic-store` WordPress theme folder
