---
layout: default
chapitre: Analyse Techniques
order: 400
---

# Analyse Techniques
{:class="sectionHeader"}

<!-- new slide -->

## Capturer des besoins techniques

Capturer des besoins techniques pour le projet de gestion de projet solicode basé sur les fonctionnalités définies pour le Sprint 1 et en tenant compte du framework Laravel, de la base de données MySQL et du pattern Repository, voici une capture des besoins techniques :

### Technologies:

* **Backend: Laravel** (framework PHP)
* **Base de données**: MySQL
* **Gestion des dépendances**: Composer

### Architecture de l'application:

* **Modèle MVC (Model-View-Controller)**: Séparation des concerns en couches distinctes pour la logique métier (modèle), l'affichage (vue) et la gestion des requêtes (contrôleur).
* **Pattern Repository**: Utilisation de repositories pour encapsuler l'accès aux données et simplifier les interactions avec la base de données MySQL.

## Laravel

## Mysql

## Design pattern :  Repository


![Desing pattern](/prototype/analyse-techniques/images/Desing-pattern.jpg){:width="60%"}*Figure: Desing pattern*

<!-- note -->

Le pattern Repository est une technique de conception logicielle qui permet d'abstraire l'accès aux données et de simplifier les interactions avec la base de données MySQL dans une application Laravel. 

Avantages du Pattern Repository:

* **Abstraction de la couche persistance**: Le code métier ne dépend pas des détails d'implémentation de la base de données.
* **Réutilisabilité du code:** Les méthodes communes d'accès aux données peuvent être regroupées dans le repository.
* **Testabilité améliorée**: Les repositories peuvent être facilement testés unitairement.
* **Séparation des concerns**: Sépare la logique métier de l'accès aux données.
<!-- new slide -->