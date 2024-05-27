---
layout: default
chapitre: Conception
order: 501
---

## Rappel 



### Rappel - Diagramme de classe dynamique

<!-- TODO uml-2 : Rappel 
- réalisation d'un exposé sur 
- diagramme de séquence dynamique
- diagramme de classe dynamique  
-->


### Edition des diagrammes 

à voir sur : 

- [documentation](https://mermaid.js.org/syntax/classDiagram.html)
- [mermaid.live](https://mermaid.live/)

````mermaid
classDiagram
class Projet {
  + id: int
  + nom: string
  + description: text
}

class Tâche {
  + id: int
  + nom: string
  + description: text
  + priorité: int
  + état: string
}

Projet --* Tâche

````

### Diagramme de navigation 

Un exemple de diagramme de navigation

````mermaid
graph TD
A[Index] --> B[Ajouter]
A --id--> C[Supprimer]
A --id--> D[Modifier]
````


### Organigramme de navigation des actions Laravel paramétrée

diagramme de flux de navigation des actions paramétrée d'une application de type CRUD. 
Chaque Element doit contient :
- nom de l'action
- nom de route 
- paramètre 

