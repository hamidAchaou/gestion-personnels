---
layout: default
order: 1
---

# Rapports

<a href="/gestion-personnels/pkg_global/rapport"> Rapport globale </a> 

## Par packages

<ul>
  {% for package in site.data.packages %}
    <li> <a href="/gestion-personnels/{{ package }}/rapport"> {{ package }} </a> </li>
  {% endfor %}
</ul>
