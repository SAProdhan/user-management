# User Management System
##### _Manage your user data easily_

## Features
- User login.
- Edit profile.
- Users list.
- Add new user with role.
- Edit & Create user.
- Delete user.

## Installation

Requires ``PHP`` v8.3 to run.

Install the dependencies and start your server.
Update database credential on file: src/Database.php

```sh
cd user-management
composer install
php database/prepare.php #For preparing database
```


## Docker

You can also run this server with docker. 

```sh
cd user-management
docker compose up --build -d
docker exec -it um-php composer install #if vendor folder not created
sudo docker exec -it um-php php database/prepare.php #For preparing database
```


Verify the deployment by navigating to your server address in
your preferred browser.

```sh
127.0.0.1:8080
```
##### Login credentials
--- Userame: ``sakeef``
--- Password: ``password``

## License

MIT
