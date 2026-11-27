
# Cabinet Dentaire - Dr Dupont

## Présentation du projet

Ce projet consiste à développer un site web pour le cabinet dentaire du Dr Dupont.

Le site permet aux visiteurs de découvrir le cabinet, les soins proposés et de prendre rendez-vous.

## Technologies utilisées

- HTML
- CSS
- PHP
- PDO pour la gestion des requêtes vers la base de données
- MySQL (si utilisé pour la base de données)

## Prérequis

Pour installer et utiliser ce projet, vous devez disposer de :

- PHP (version 8.0 ou supérieure recommandée)
- L'extension PDO de PHP
- Un serveur web compatible PHP (Apache, par exemple)
- MySQL si le projet utilise une base de données MySQL

## Installation du projet

### 1. Récupérer le projet

Clonez le dépôt GitHub :

```bash
git clone https://github.com/cyril-nalin/cabinet.git
```

Ou téléchargez directement les fichiers du projet.

### 2. Installer le projet

Placez le dossier du projet dans le répertoire de votre serveur web.

Exemple avec XAMPP :

```text
C:\xampp\htdocs\cabinet-dentaire
```

### 3. Vérifier PHP et PDO

Vérifiez que PHP est installé :

```bash
php -v
```

Vérifiez que PDO est activé :

```bash
php -m
```

L'extension PDO doit apparaître dans la liste.

### 4. Configurer la base de données

Si le projet utilise une base de données MySQL :

- Créez une base de données.
- Configurez les paramètres de connexion dans le fichier prévu à cet effet.
- Vérifiez que les identifiants de connexion sont corrects.

### 5. Lancer le site

Démarrez votre serveur web, puis ouvrez votre navigateur à l'adresse :

```text
http://localhost/cabinet-dentaire
```
```

## Auteur

Projet réalisé dans le cadre d'un exercice de développement web.

## Licence

Ce projet est destiné à un usage pédagogique.
