## partie 1
### commandes 

#### construire les images
- docker build -t 20220796/mysql-renf-eval:latest ./database
- docker build -t 20220796/php-renf-eval:latest ./php

#### pousser les images sur le registry
- docker push 20220796/mysql-renf-eval:latest
- docker push 20220796/php-renf-eval:latest

#### lancer le docker compose
- docker compose build (facultatif)
- docker compose up -d

### url des images
php : https://hub.docker.com/r/20220796/php-renf-eval

mysql : https://hub.docker.com/r/20220796/mysql-renf-eval