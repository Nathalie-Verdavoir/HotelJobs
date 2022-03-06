# HotelJobs

## 1-Un projet symfony

### Déployez en local

Clonez le projet sur votre ficher htdocs de xampp et créer votre base de données grâce qu ficher sql fourni.
Vous devrez commencer par ajouter un compte admin dans la table user avec un mot de passe pré encodé avec **Bcrypt** : <https://www.bcrypt.fr/>
Ajoutez les fichier de configuration des variables d'environnement (.env, .env.local).
Ce projet nécessite le paramétrage de APP_ENV, APP_SECRET, DATABASE_URL ET MAILER_DSN

Lancez la commande : **composer install** pour installer les dépendences de symfony pour ce projet.

Pour servir votre application, lancez la commande : **symfony server:start**
Pensez également à activer MySQL sur xampp pour que votre base de données soit accessible.

Ouvrez votre navigateur sur **<http://localhost:8000/>**

Pour plus d'informations, vous pouvez lire la documentations symfony :
<https://symfony.com/doc/current/setup.html>
