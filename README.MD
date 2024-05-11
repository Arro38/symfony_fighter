# Projet Symfony FIGHTER

Ce projet Symfony est une application de combat de champions. Les utilisateurs peuvent s'inscrire et se voir attribuer un champion existant avec des valeurs PV (Points de Vie) et Attack (Attaque) aléatoires. Les administrateurs peuvent créer de nouveaux champions.

### Fonctionnalités réalisées

1. **Inscription des utilisateurs** : Les utilisateurs peuvent s'inscrire et se voir attribuer un champion existant avec des valeurs PV et Attack aléatoires. Ces valeurs ne sont pas visibles par l'utilisateur, mais uniquement par l'administrateur. Cette fonctionnalité est implémentée dans `src/Controller/RegistrationController.php`.

2. **Création de champions par l'administrateur** : Les administrateurs peuvent créer de nouveaux champions avec des valeurs max pour PV et Attack. Cette fonctionnalité est implémentée dans `src/Controller/AdminController.php`.

3. **Combat entre utilisateurs** : Les utilisateurs peuvent lancer un combat entre eux pour obtenir un gagnant. Le combat se déroule au tour par tour, avec un tirage au sort pour déterminer qui commence. Un utilisateur attaque en soustrayant un nombre aléatoire de PV à son adversaire, et le combat se termine lorsqu'un utilisateur atteint 0 PV ou moins. Cette fonctionnalité est implémentée dans `src/Controller/FightController.php`.

### Fonctionnalités manquantes

1. **Historique/détails des combats** : Il n'y a pas encore de fonctionnalité pour obtenir l'historique ou les détails des combats. Cette fonctionnalité pourrait être ajoutée dans un nouveau contrôleur, par exemple `src/Controller/BattleHistoryController.php`.

### Comment démarrer

Pour démarrer ce projet, vous devez d'abord installer les dépendances avec Composer :

```sh
composer install
```

Ensuite, vous pouvez démarrer le serveur de développement Symfony avec la commande suivante :

```sh
symfony server:start
```

Vous pouvez maintenant accéder à l'application à l'adresse `http://localhost:8000`.

### Tests

Pour exécuter les tests, utilisez la commande suivante :

```sh
php bin/phpunit
```

### Contribution

Les contributions sont les bienvenues. N'hésitez pas à ouvrir une issue ou à soumettre une pull request.