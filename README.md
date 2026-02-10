---
marp: true
theme: default
_class: lead
paginate: true
backgroundColor: #ffffffff
style: |
  section {
    font-size: 22px;
    color: #040404ff;
    line-height: 1.5;
    padding: 2em;
    
  }
  h1, h2, h3 {
    color: #38bdf8;
    font-weight: 700;
    margin-bottom: 0.6em;
  }
  h1 { font-size: 2.8em; }
  h2 { font-size: 2.2em; }
  h3 { font-size: 1.6em; color: #3d3d3dff; }
  p, li {
    font-size: 1.15em;
    margin-bottom: 0.6em;
  }
  ul, ol {
    margin-left: 1.4em;
    margin-bottom: 1.2em;
  }
  img {
    max-width: 100%;
    display: block;
    margin:  0em auto;
    border-radius: 8px;

  }
---




# **Présentation Projet-technique**
### Mini E-Commerce (Product,Categories)
**Réalisé par :** Ben Taleb Mehdi  
**Encadré par :** M. ESSARRAJ Fouad
**Date :** 05/01/2026

---

## Exigences: Travail à faire

**Développer l'Application Mini E-Commerce (Product/Categories)**

* **Partie Publique :** Interface permettant aux visiteurs de consulter les produits et leurs catégories. 
    * **Fonctionnalités :** pagination (10 produits/page).
* **Partie Admin :** Tableau de bord sécurisé pour la gestion complète du catalogue (CRUD). 
    * **Fonctionnalités :** Modales pour l’ajout et l’édition d'éléments, intégration de AJAX - Alpine.js pour les mises à jour asynchrones (sans rechargement de page).

---
## Waterfall 

![w:900 Waterfall](images/Waterfall.png)

---
## Contexte 

![w:500 2TUP](images/2TUP.png)


---
## Analyse Technique

### Les Technologies a Utiliser (parte 1)
1. Base de donnee : Mysql 
2. Archittecture N-tier : Services
3. Framwork : Laravel
4. Archittecture : MVC
5. Moteur de vues Blade
6. AJAX 
---
### Les Technologies a Utiliser (parte 2)
7. Upload image
8. Laravel Multilingue
9. Vite
10. Preline Ui
11. Lucide Library (icons)
12. Alpine
13. spatie
14. laravel/ui



---

## Analyse - Fonctionnalités


![w:1150 usecase](images/usecase.png)

---

## Conception 

![w:1050 diagramme de class](images/diagramme_class.png)

---

## Sujet - Live coding
- Un bouton “Ajouter” qui ouvre une modale pour créer un nouvel élément.
- Une barre de recherche filtrant des éléments par titre.

---

## Versions

| Version | Branch Name | Code Version / Tags |
| :--- | :--- | :--- |
| **v1: Public Side** | `public` | — |
| **v2: Admin Side** | `admin` | `prototype-admin`, `live-coding-admin` |
| **v3: Authentication / Authorization (Gates)** | `gates` | — |
| **v4: SPA (AJAX, Alpine)** | `ajax, alpine` | `prototype-ajax`, `live-coding-ajax` |
| **v5: Spatie Authorization** | `spatie` | `live-coding-spatie` |
| **v6: API** | `api` | — |
| **v7: Mobile** | `mobile` | — |
