# Renforcement Développement Web

#### Maimiti Saint-Marc
#### M1 dev - octobre 2025
---

Tous les fichiers demandés sont disponibles dans le dossier `/k8s` pour les fichiers kubernetes et `/.github/workflows` pour le pipeline.

## Partie 1: Conteneurisation avec Docker
### commandes pour construire les images

Fichiers dockerfile disponibles aux chemins suivants : `/php` et `/database`.
Le docker compose est disponible à la racine du projet.

1) Construire les images

```bash
docker build -t 20220796/mysql-renf-eval:latest ./database
docker build -t 20220796/php-renf-eval:latest ./php
```

Ces commandes vont permettre de construire les images à partir des Dockerfiles locaux (emplacements ./php et ./database). le nom de l'image est composé de trois parties. La première "20220796" correspond au registry sur lequel les images pourront être poussées. Ensuite, la partie "mysql-renf-eval" qui correspond tout simplement le nom de l'image. Enfin, on attribue un tag à l'image, ici "latest".

2) Pousser les images sur le registry

```bash
docker push 20220796/mysql-renf-eval:latest
docker push 20220796/php-renf-eval:latest
```

Ici, nous allons pousser les images sur le registry 20220796. Il faut avant de pouvoir pousser une image exécuter la commande `docker login` pour pouvoir s'identifier au Docker Hub.

3) Lancer le docker compose

```bash
docker compose build (facultatif)
docker compose up -d
```

La première commande est facultative car elle permet de construire toutes les images renseignées dans le fichier docker-compose. La seconde commande permet de lancer le docker compose, en arrière plan grace à la commande `-d`.


### Url des images poussées sur Dockere Hub
- L'image php-renf-eval : https://hub.docker.com/r/20220796/php-renf-eval

- L'image mysql-renf-eval : https://hub.docker.com/r/20220796/mysql-renf-eval

## Partie 2: Orchestration avec Kubernetes

### Le cluster k8s
Le cluster a été créé sur Azure Cloud. Afin d'y accéder, j'ai téléchargé le fichier kubeconfig et l'ai mis dans ~/.kube/config-az. J'ai enfin instancié la variable d'environnement kubeconfig pour pointer vers ce fichier avec
`export KUBECONFIG=$HOME/.kube/config-az`.

Tous les fichiers kubernetes sont disponibles dans le fichier `/k8s`.

### Scalabilité
![alt text](scalability.png)
Ici, le déploiement php-renf-eval-deployment possède trois réplicas donc trois pods ont été créé.

### Déploiement
![alt text](deployed.png)
Lorsque l'on accède à l'ip du service, on arrive bien sur l'application et les données sont bien persistantes grace aux PV et PVC

## Partie 3: CI/CD

La partie CI/CD a été effectuée sur GitHub Action. Voici la vidéo du pipeline en action. Le fichier de configuration du pipeline est disponible dans `/.github/workflows`.

Retrouvez la vidéo dans le mail que je vous ai envoyé.

Explication de la vidéo:

Dans un premier temps, je regarde s'il y a des pods lancés dans mon namespace. Il n'y en a aucun. Je lance la commande `kubectl get po -w` pour mettre un watch sur la récupération des pods.
Ensuite, je fais un commit sur le projet et je push les modifications sur la branche distante. Le workflow / pipeline va se lancer. 
Le pipeline contient deux jobs, un premier job qui va construire les images et les pousser sur le registry docker hub et un deuxième job qui va déployer le projet sur kubernetes et qui dépend du premier job. On voit en temps réel que le projet est déployé et que les pods sont créés. Enfin, je vois que l'ip retournée par le load balancer pointe bien vers mon application.
