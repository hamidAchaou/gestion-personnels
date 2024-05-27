---
layout: default
chapitre : true
package: pkg_notifications
order:  630
---


### Création des seeders par package 


````bash

php artisan make:seeder pkg_projets/StatutTacheSeeder
php artisan make:seeder pkg_projets/EquipeSeeder
php artisan make:seeder pkg_notifications/NotificationSeeder
php artisan make:seeder pkg_posts/TagsSeeder
php artisan make:seeder pkg_posts/PostSeeder
php artisan make:seeder pkg_realisation_projet/NatureLivrableSeeder
php artisan make:seeder pkg_autorisations/ControllerSeeder
php artisan make:seeder pkg_autorisations/ActionSeeder



php artisan make:seeder pkg_competences/CompetenceSeeder
php artisan make:seeder pkg_competences/NiveauCompetencesSeeder
php artisan make:seeder pkg_competences/CategorieTechnologiesSeeder



php artisan make:seeder pkg_rh/GroupeSeeder
````