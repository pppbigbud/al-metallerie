# Documentation Technique - Optimisations SEO AL Métallerie

## Architecture des Optimisations

### Vue d'ensemble

Les optimisations SEO sont implémentées via un système de **hooks WordPress** qui s'exécutent automatiquement sans intervention manuelle. Toutes les fonctions sont centralisées dans `functions.php` pour faciliter la maintenance.

---

## 1. Meta Tags SEO

### Fonction : `almetal_seo_meta_tags()`
**Hook** : `wp_head` (priorité 1)  
**Déclenchement** : Uniquement sur `is_singular('realisation')`

#### Données utilisées
```php
$title = get_the_title();
$lieu = get_post_meta($post->ID, '_almetal_lieu', true) ?: 'Puy-de-Dôme';
$client = get_post_meta($post->ID, '_almetal_client', true);
$duree = get_post_meta($post->ID, '_almetal_duree', true);
$terms = get_the_terms($post->ID, 'type_realisation');
```

#### Meta tags générés
- `<meta name="description">` : Description SEO optimisée
- `<meta name="robots">` : Directives d'indexation
- `<link rel="canonical">` : URL canonique
- Open Graph : `og:locale`, `og:type`, `og:title`, `og:description`, `og:url`, `og:site_name`, `og:image`
- Twitter Card : `twitter:card`, `twitter:title`, `twitter:description`, `twitter:image`
- Géolocalisation : `geo.region`, `geo.placename`, `geo.position`, `ICBM`

#### Logique de description
```
"Découvrez notre réalisation de {type} à {lieu}"
+ (si client) " pour {client}"
+ (si durée) ". Projet réalisé en {durée}"
+ ". AL Métallerie, votre expert en métallerie dans le Puy-de-Dôme."
```

---

## 2. Schemas JSON-LD

### Fonction : `almetal_seo_json_ld_schemas()`
**Hook** : `wp_head` (priorité 2)  
**Déclenchement** : Uniquement sur `is_singular('realisation')`

#### Schema 1 : Article
```json
{
  "@context": "https://schema.org",
  "@type": "Article",
  "headline": "Titre de la réalisation",
  "description": "Extrait du contenu",
  "image": ["url1", "url2", ...],
  "datePublished": "ISO 8601",
  "dateModified": "ISO 8601",
  "author": { "@type": "Organization", "name": "AL Métallerie" },
  "publisher": { ... },
  "mainEntityOfPage": { ... }
}
```

#### Schema 2 : LocalBusiness
```json
{
  "@context": "https://schema.org",
  "@type": "LocalBusiness",
  "name": "AL Métallerie",
  "address": {
    "streetAddress": "Peschadoires",
    "postalCode": "63920",
    "addressCountry": "FR"
  },
  "geo": {
    "latitude": "45.8344",
    "longitude": "3.1636"
  },
  "areaServed": {
    "@type": "GeoCircle",
    "geoRadius": "50000"
  }
}
```

#### Schema 3 : BreadcrumbList
Structure dynamique :
- Position 1 : Accueil
- Position 2 : Réalisations
- Position 3 : Catégorie (si existe)
- Position 4 : Page actuelle

#### Récupération des images
1. Tente de récupérer `_almetal_gallery_images` (custom field)
2. Fallback sur `get_the_post_thumbnail_url()`
3. Format : array d'URLs

---

## 3. Optimisation Structure H1/H2/H3

### Fonction : `almetal_seo_optimize_heading_structure($content)`
**Hook** : `the_content` (priorité 10)  
**Déclenchement** : Uniquement sur `is_singular('realisation')`

#### Logique
1. Vérifie si le contenu contient déjà des `<h2>` ou `<h3>` via regex
2. Si oui : retourne le contenu inchangé
3. Si non : ajoute une structure sémantique

#### Structure ajoutée
```html
<h2>Présentation du projet de {type} à {lieu}</h2>
<p>{contenu original}</p>
<h3>Notre expertise en {type}</h3>
<p>AL Métallerie met son savoir-faire...</p>
```

#### Regex utilisée
```php
preg_match('/<h[2-3]/i', $content)
```

---

## 4. Attributs ALT pour Images

### Fonction : `almetal_seo_generate_image_alt($attr, $attachment, $size)`
**Hook** : `wp_get_attachment_image_attributes` (priorité 10)  
**Déclenchement** : Uniquement sur `is_singular('realisation')`

#### Logique
1. Vérifie si l'image a déjà un ALT
2. Si oui : préserve l'ALT existant
3. Si non : génère un ALT automatique

#### Variations d'ALT (5 modèles)
```php
[
  "{Type} réalisé par AL Métallerie à {Lieu}",
  "Projet de {type} à {Lieu} - AL Métallerie",
  "Réalisation {type} {Lieu} par AL Métallerie",
  "Détail du projet de {type} à {Lieu}",
  "{Titre} - {Type} {Lieu}"
]
```

#### Sélection cohérente
```php
$index = $attachment->ID % count($alt_variations);
```
Garantit que la même image aura toujours le même ALT (pas de variation aléatoire à chaque chargement).

---

## 5. Enrichissement Contenu Court

### Fonction : `almetal_seo_enrich_short_content($content)`
**Hook** : `the_content` (priorité 20)  
**Déclenchement** : Uniquement sur `is_singular('realisation')`

#### Logique
1. Compte les mots du contenu via `str_word_count(wp_strip_all_tags($content))`
2. Si ≥ 200 mots : retourne le contenu inchangé
3. Si < 200 mots : ajoute du contenu enrichi

#### Structure du contenu enrichi
```html
<div class="seo-enrichment">
  <h3>À propos de ce projet</h3>
  <p>Ce projet de {type} a été réalisé à {lieu}...</p>
  
  <!-- Si client existe -->
  <p>Réalisé pour {client}...</p>
  
  <!-- Si durée existe -->
  <p>La durée de réalisation... {durée}...</p>
  
  <h3>Pourquoi choisir AL Métallerie ?</h3>
  <ul>
    <li><strong>Expertise locale</strong> : ...</li>
    <li><strong>Savoir-faire artisanal</strong> : ...</li>
    <li><strong>Qualité garantie</strong> : ...</li>
    <li><strong>Sur-mesure</strong> : ...</li>
  </ul>
  
  <p>Vous avez un projet... <a href="/contact">Contactez-nous</a>...</p>
</div>
```

#### Seuil personnalisable
Ligne 1262 de `functions.php` :
```php
if ($word_count >= 200) { // Modifier ce nombre
```

---

## 6. Fil d'Ariane (Breadcrumb)

### Fonction : `almetal_seo_breadcrumb()`
**Appel manuel** : Dans `single-realisation.php` (ligne 36)  
**Déclenchement** : Uniquement sur `is_singular('realisation')`

#### Structure HTML avec microdonnées
```html
<nav class="breadcrumb" aria-label="Fil d'Ariane" itemscope itemtype="https://schema.org/BreadcrumbList">
  <span itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem">
    <a itemprop="item" href="..."><span itemprop="name">Accueil</span></a>
    <meta itemprop="position" content="1" />
  </span>
  &raquo;
  <!-- ... autres éléments ... -->
</nav>
```

#### Logique de position
```php
if (!empty($terms)) {
    // Accueil (1) > Réalisations (2) > Catégorie (3) > Page (4)
    $position = 4;
} else {
    // Accueil (1) > Réalisations (2) > Page (3)
    $position = 3;
}
```

---

## 7. Liens Internes Contextuels

### Fonction : `almetal_seo_add_internal_links($content)`
**Hook** : `the_content` (priorité 30)  
**Déclenchement** : Uniquement sur `is_singular('realisation')`

#### Requête WP_Query
```php
$related_args = [
    'post_type' => 'realisation',
    'posts_per_page' => 3,
    'post__not_in' => [$post->ID], // Exclure la page actuelle
    'tax_query' => [
        [
            'taxonomy' => 'type_realisation',
            'field' => 'term_id',
            'terms' => $terms[0]->term_id // Même catégorie
        ]
    ],
    'orderby' => 'rand' // Aléatoire pour varier
];
```

#### Structure HTML
```html
<div class="internal-links-seo">
  <h3>Découvrez nos autres réalisations de {Type}</h3>
  <ul>
    <li><a href="...">Titre - Lieu</a></li>
    <!-- ... 3 liens max ... -->
  </ul>
  <p><a href="{term_link}" class="btn-see-more">Voir toutes nos réalisations de {Type}</a></p>
</div>
```

#### Gestion des cas limites
- Si aucune réalisation similaire : retourne le contenu inchangé
- Si pas de terme : retourne le contenu inchangé

---

## 8. Styles CSS

### Fichier : `assets/css/seo-enhancements.css`
**Chargement** : Uniquement sur `is_singular('realisation')`  
**Hook** : `wp_enqueue_scripts`

#### Classes CSS principales
- `.breadcrumb` : Fil d'Ariane
- `.seo-enrichment` : Bloc d'enrichissement
- `.internal-links-seo` : Bloc de liens internes
- `.btn-see-more` : Bouton CTA

#### Responsive
Breakpoint : `@media (max-width: 768px)`
- Réduction des paddings
- Réduction des tailles de police
- Ajustement des gaps

---

## Ordre d'Exécution des Hooks

### Dans `<head>` (via `wp_head`)
1. **Priorité 1** : `almetal_seo_meta_tags()` → Meta tags
2. **Priorité 2** : `almetal_seo_json_ld_schemas()` → Schemas JSON-LD

### Dans le contenu (via `the_content`)
1. **Priorité 10** : `almetal_seo_optimize_heading_structure()` → H2/H3
2. **Priorité 20** : `almetal_seo_enrich_short_content()` → Enrichissement
3. **Priorité 30** : `almetal_seo_add_internal_links()` → Liens internes

### Images (via `wp_get_attachment_image_attributes`)
- **Priorité 10** : `almetal_seo_generate_image_alt()` → ALT

### Breadcrumb (appel manuel)
- Dans `single-realisation.php` : `almetal_seo_breadcrumb()`

---

## Custom Fields Utilisés

| Custom Field | Utilisation | Fallback |
|--------------|-------------|----------|
| `_almetal_lieu` | Ville/localisation | `'Puy-de-Dôme'` |
| `_almetal_client` | Nom du client | Aucun (optionnel) |
| `_almetal_duree` | Durée du projet | Aucun (optionnel) |
| `_almetal_gallery_images` | IDs des images (CSV) | Image à la une |
| `_almetal_date_realisation` | Date du projet | `get_the_date()` |

---

## Taxonomies Utilisées

| Taxonomie | Slug | Utilisation |
|-----------|------|-------------|
| Type de réalisation | `type_realisation` | Catégorisation, liens internes, schemas |

---

## Performances

### Optimisations implémentées
1. **Chargement conditionnel du CSS** : Uniquement sur `is_singular('realisation')`
2. **Vérifications précoces** : Return rapide si pas sur une réalisation
3. **Mise en cache native WordPress** : Les meta et schemas sont générés à chaque chargement mais WordPress les met en cache
4. **Requêtes optimisées** : `posts_per_page => 3` pour les liens internes

### Impact estimé
- **Temps d'exécution** : +50-100ms par page de réalisation
- **Requêtes DB** : +1 requête (liens internes)
- **Taille HTML** : +2-3 KB (schemas JSON-LD)

---

## Désactivation Sélective

Pour désactiver une fonctionnalité, commentez le `add_action` ou `add_filter` correspondant :

```php
// Désactiver les meta tags
// add_action('wp_head', 'almetal_seo_meta_tags', 1);

// Désactiver les schemas
// add_action('wp_head', 'almetal_seo_json_ld_schemas', 2);

// Désactiver l'enrichissement
// add_filter('the_content', 'almetal_seo_enrich_short_content', 20);

// etc.
```

---

## Compatibilité

### Plugins SEO
Ces optimisations sont **compatibles** avec :
- Yoast SEO (nos meta tags ont priorité)
- Rank Math
- All in One SEO

Pour éviter les doublons, désactivez les fonctionnalités équivalentes dans ces plugins.

### WordPress
- **Version minimale** : WordPress 5.0+
- **PHP** : 7.4+
- **Thème** : AL Métallerie custom theme

---

## Maintenance

### Mise à jour des coordonnées GPS
Fichier : `functions.php`
```php
// Ligne 963-964 (meta tags)
$latitude = '45.8344';
$longitude = '3.1636';

// Ligne 1085-1086 (schema LocalBusiness)
'latitude' => '45.8344',
'longitude' => '3.1636',
```

### Mise à jour du téléphone
Fichier : `functions.php`, ligne 1089
```php
'telephone' => '+33-4-XX-XX-XX-XX',
```

### Ajout d'une nouvelle variation d'ALT
Fichier : `functions.php`, lignes 1230-1236
```php
$alt_variations = [
    // ... variations existantes ...
    'Nouvelle variation {Type} {Lieu}', // Ajouter ici
];
```

---

## Logs et Débogage

### Activer les logs WordPress
Dans `wp-config.php` :
```php
define('WP_DEBUG', true);
define('WP_DEBUG_LOG', true);
define('WP_DEBUG_DISPLAY', false);
```

### Vérifier les logs
Fichier : `wp-content/debug.log`

### Déboguer une fonction spécifique
```php
error_log('SEO Debug: ' . print_r($data, true));
```

---

## Tests Automatisés (Recommandé)

### Test des schemas
```bash
curl -s https://search.google.com/test/rich-results?url=https://votre-site.com/realisation/test
```

### Test des meta tags
```bash
curl -s https://votre-site.com/realisation/test | grep -A 5 "SEO Meta Tags"
```

---

## Changelog

### Version 1.0.0 (18 novembre 2025)
- ✅ Implémentation initiale de toutes les optimisations SEO
- ✅ Meta tags automatiques
- ✅ Schemas JSON-LD (Article, LocalBusiness, Breadcrumb)
- ✅ Optimisation H1/H2/H3
- ✅ ALT images automatiques
- ✅ Enrichissement contenu court
- ✅ Fil d'Ariane avec microdonnées
- ✅ Liens internes contextuels
- ✅ Styles CSS dédiés

---

**Auteur** : Cascade AI  
**Date** : 18 novembre 2025  
**Environnement** : Docker (WordPress latest + MySQL 8.0)
