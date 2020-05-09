# Scratchpad API

A REST API for scratchpad front projects.

## Installation

> Docker coming soon...

1. `git clone repositoryUrlHere`
1. `composer install`
1. Create a `/.env.local` file with your database credentials.
1. `php bin/console doctrine:database:create` to create the database.
1. `php bin/console doctrine:schema:update --force` to set the database tables.

## Authentication

> Coming soon...
>
[JWT](https://jwt.io)

## Model

- Note
    - title
    - content
    - users
- User
    - email
    - nickName
    - firstName
    - lastName
    - notes