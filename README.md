## I - Contexte :
Dans le cadre de notre cours d’Architecture Logicielle, nous nous sommes attelés à la réalisation d’un projet ayant pour objectif de nous entraîner à avoir une réflexion concernant l’architecture, l’optimisation et la structure de notre code.

## II - Technologies utilisées :
Concernant les technologies utilisées pour le projet, nous avons décidé de choisir des technologies correspondant à nos compétences, et qui semblaient en plus de cela concorder avec les besoins du projet.

#### Back :
- PHP >7.4
- Symfony 5.2.5
  - Doctrine
- MySQL
- JWT

#### Front :
- Vue.js 2.6
- Vuetify
- Webpack


## III - Concept du projet :
Notre application est à destination des sociétés, associations, clubs, et autres collectivités, et a pour objectif de fournir aux utilisateurs un visuel sur l’ensemble des informations concernant les véhicules de la collectivité. Différentes actions seront réalisables sur ces véhicules.
Concernant l’authentification, un formulaire de connexion permettra l’accès à l’application. Un compte “manager” sera fourni au même moment que l’application. Les managers pourront bénéficier de fonctionnalités supplémentaires comparés aux autres membres. Vient s’ajouter à cela une connexion dite “admin”.

#### Espace manager :
- Saisir les différents véhicules de la collectivité
- Consulter les véhicules (listes + détails)
- Éditer des véhicules
- Supprimer les véhicules
- Gérer l’affichage (public / privé) de certains véhicules aux autres membres.
- Gestion des demandes d’accès membres
- (Créer des comptes “membres”)
- (Rechercher / filtrer les véhicules)
#### Espace membres :
- Consulter les véhicules
- (Changement d’identifiants)
- (Rechercher / filtrer un véhicule)
#### Espace administrateur :
- Ajout de types de véhicules
- (Création et gestion de comptes managers)

### Diagramme de cas d’utilisation :


## IV - Architecture :
La particularité de ce sujet repose sur les différences entre les types de véhicules.

#### Problématique :
Le concept de notre projet nous imposait la création de véhicules ayant des propriétés communes, mais il y a aussi des types de véhicules disposant de propriétés propres à eux.
Il était donc nécessaire d’avoir une réflexion sur la structure de notre code, notamment des différentes classes pour gérer les différents types particuliers de véhicules.

Exemples d’informations véhicules dites “générales” :
- Type
- Label
- Marque
- Description
- Type d’essence
- Année de construction
- Dernier contrôle technique
- Type de carburant
- Type de permis (ex: plusieurs types de permis bateaux, idem pour moto etc…)
Exemples de particularités :
- Charge max (ex: véhicule utilitaire)
- Volume coffre (ex: véhicule utilitaire)
- Casque (boolean) (ex : moto/quad)
- Gilet de sauvetage (boolean) (ex: bateau)

Pour l’architecture de notre projet, nous nous sommes inspirés du design pattern Builder qui semblait répondre à notre problématique.


### Diagramme de classe :
Nous avons fait le choix d’adapter le design pattern Builder afin qu’il corresponde au mieux à notre projet. C’est pourquoi certains aspects diffèrent.
La partie que nous avons souhaité conserver est celle qui concerne la structure dite “générale” d’un véhicule.
S’en suit les structures particulières se rapportant à d’autres types, ici Motorcycle et UtilityVehicle comme exemple.

## V - Installation :
#### Symfony

# ArchiLogicielProject
To install the project, begin by write these commands :

Composer install,

Yarn install

# To compil with webpack :
Yarn encore dev
Or Yarn watch 

#### Données

#### Vue.js


