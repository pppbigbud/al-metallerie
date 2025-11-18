# ✅ Checklist de Vérification SEO - AL Métallerie

## 🎯 Tests Rapides (5 minutes)

### 1. Créer une Réalisation de Test
- [ ] Aller dans **Réalisations > Ajouter**
- [ ] Titre : "Test Portail Clermont"
- [ ] Contenu : 50 mots environ
- [ ] Type : Portail
- [ ] Lieu : Clermont-Ferrand
- [ ] Client : Test Client
- [ ] Durée : 2 semaines
- [ ] Ajouter 2-3 images (sans ALT)
- [ ] Publier

### 2. Vérification Visuelle Front-End
- [ ] Ouvrir la réalisation en front-end
- [ ] **Breadcrumb visible en haut** (fond gris)
- [ ] **Contenu enrichi visible** (bloc gris avec "À propos de ce projet")
- [ ] **Liens internes visibles** (bloc orange en bas, si autres portails existent)
- [ ] **Styles appliqués correctement**

### 3. Vérification Code Source
- [ ] Clic droit > "Afficher le code source"
- [ ] Chercher : `<!-- SEO Meta Tags - Générés automatiquement -->`
- [ ] Vérifier présence de :
  - [ ] `<meta name="description">`
  - [ ] `<meta property="og:title">`
  - [ ] `<meta name="twitter:card">`
  - [ ] `<meta name="geo.position">`
- [ ] Chercher : `<!-- Schema.org JSON-LD - Générés automatiquement -->`
- [ ] Vérifier présence de 3 blocs `<script type="application/ld+json">`

### 4. Vérification Images ALT
- [ ] Inspecter une image de la galerie (F12)
- [ ] Vérifier que `alt="..."` est rempli automatiquement
- [ ] Exemple attendu : "Portail réalisé par AL Métallerie à Clermont-Ferrand"

### 5. Test Google Rich Results
- [ ] Aller sur : https://search.google.com/test/rich-results
- [ ] Coller l'URL de la réalisation
- [ ] Vérifier détection de :
  - [ ] Article
  - [ ] LocalBusiness
  - [ ] BreadcrumbList

---

## 🔍 Tests Approfondis (15 minutes)

### Test 1 : Meta Tags Dynamiques
**Objectif** : Vérifier que les meta tags s'adaptent aux données

1. Créer 2 réalisations :
   - [ ] Réalisation A : Portail à Clermont-Ferrand
   - [ ] Réalisation B : Garde-corps à Thiers
2. Vérifier dans le code source :
   - [ ] Description de A contient "Portail" et "Clermont-Ferrand"
   - [ ] Description de B contient "Garde-corps" et "Thiers"
   - [ ] Les OG:title sont différents

### Test 2 : Enrichissement Conditionnel
**Objectif** : Vérifier que l'enrichissement ne s'active que si < 200 mots

1. Créer 2 réalisations :
   - [ ] Réalisation courte : 50 mots
   - [ ] Réalisation longue : 250 mots
2. Vérifier :
   - [ ] Réalisation courte : bloc "seo-enrichment" présent
   - [ ] Réalisation longue : pas de bloc "seo-enrichment"

### Test 3 : Structure H2/H3 Conditionnelle
**Objectif** : Vérifier que la structure ne s'ajoute que si absente

1. Créer 2 réalisations :
   - [ ] Sans titres : texte simple
   - [ ] Avec titres : inclure des `<h2>` et `<h3>`
2. Vérifier :
   - [ ] Sans titres : H2/H3 ajoutés automatiquement
   - [ ] Avec titres : structure préservée, pas de duplication

### Test 4 : Liens Internes Contextuels
**Objectif** : Vérifier le maillage interne

1. Créer 4 réalisations de type "Portail"
2. Ouvrir l'une d'elles
3. Vérifier :
   - [ ] Bloc "internal-links-seo" présent
   - [ ] 3 liens vers d'autres portails
   - [ ] Bouton "Voir toutes nos réalisations de Portail"
   - [ ] Liens fonctionnels

### Test 5 : Breadcrumb Dynamique
**Objectif** : Vérifier l'adaptation du fil d'Ariane

1. Créer une réalisation avec catégorie
2. Créer une réalisation sans catégorie
3. Vérifier :
   - [ ] Avec catégorie : Accueil » Réalisations » Catégorie » Titre
   - [ ] Sans catégorie : Accueil » Réalisations » Titre
   - [ ] Tous les liens fonctionnent

### Test 6 : ALT Images Variés
**Objectif** : Vérifier la diversité des ALT

1. Ajouter 5 images à une galerie
2. Inspecter chaque image
3. Vérifier :
   - [ ] Chaque image a un ALT différent
   - [ ] ALT contiennent : type + lieu + "AL Métallerie"
   - [ ] Pas de duplication

---

## 🌐 Tests Externes (10 minutes)

### Google Rich Results Test
- [ ] URL : https://search.google.com/test/rich-results
- [ ] Tester 2-3 réalisations
- [ ] Vérifier : 0 erreur, 0 avertissement
- [ ] Capturer les résultats (screenshot)

### Schema Markup Validator
- [ ] URL : https://validator.schema.org/
- [ ] Coller le code source d'une réalisation
- [ ] Vérifier : validation réussie
- [ ] Vérifier les 3 schemas détectés

### Facebook Sharing Debugger
- [ ] URL : https://developers.facebook.com/tools/debug/
- [ ] Tester l'URL d'une réalisation
- [ ] Vérifier :
  - [ ] Image OG affichée
  - [ ] Titre correct
  - [ ] Description correcte

### Twitter Card Validator
- [ ] URL : https://cards-dev.twitter.com/validator
- [ ] Tester l'URL d'une réalisation
- [ ] Vérifier :
  - [ ] Card type : summary_large_image
  - [ ] Image affichée
  - [ ] Titre et description corrects

---

## 📱 Tests Responsive (5 minutes)

### Mobile
- [ ] Ouvrir une réalisation sur mobile (ou DevTools mobile)
- [ ] Vérifier :
  - [ ] Breadcrumb lisible et adapté
  - [ ] Bloc enrichissement bien formaté
  - [ ] Liens internes empilés verticalement
  - [ ] Bouton CTA accessible
  - [ ] Pas de débordement horizontal

### Tablet
- [ ] Tester sur tablette (ou DevTools tablet)
- [ ] Vérifier l'affichage correct de tous les éléments SEO

---

## 🔧 Tests Techniques (5 minutes)

### Performance
- [ ] Ouvrir DevTools > Network
- [ ] Recharger une réalisation
- [ ] Vérifier :
  - [ ] `seo-enhancements.css` chargé (uniquement sur réalisations)
  - [ ] Temps de chargement acceptable (< 2s)
  - [ ] Pas d'erreur 404

### Console JavaScript
- [ ] Ouvrir DevTools > Console
- [ ] Vérifier : 0 erreur JavaScript
- [ ] Vérifier : pas de warning lié aux schemas

### HTML Validation
- [ ] URL : https://validator.w3.org/
- [ ] Tester une réalisation
- [ ] Vérifier : 0 erreur critique
- [ ] Warnings acceptables : microdonnées Schema.org

---

## 🎨 Tests Visuels (5 minutes)

### Breadcrumb
- [ ] Fond gris clair (#f8f9fa)
- [ ] Liens orange (#F08B18)
- [ ] Hover : orange foncé + soulignement
- [ ] Séparateurs : &raquo; (»)

### Enrichissement SEO
- [ ] Fond gris (#f8f9fa)
- [ ] Bordure gauche orange (4px)
- [ ] Titres H3 bien visibles
- [ ] Liste avec puces orange
- [ ] Lien contact orange

### Liens Internes
- [ ] Bloc blanc avec bordure orange (2px)
- [ ] Ombre légère
- [ ] Hover sur items : translation vers la droite
- [ ] Flèches orange (→) devant chaque lien
- [ ] Bouton CTA orange avec hover

---

## 🐛 Tests de Régression (10 minutes)

### Compatibilité Thème
- [ ] Page d'accueil fonctionne
- [ ] Archive réalisations fonctionne
- [ ] Autres pages (contact, formations) fonctionnent
- [ ] Menu de navigation fonctionne
- [ ] Footer fonctionne

### Compatibilité Mobile
- [ ] Template mobile réalisations fonctionne
- [ ] Header mobile fonctionne
- [ ] Pas de conflit avec les styles mobiles existants

### Back-Office
- [ ] Ajouter une réalisation : OK
- [ ] Modifier une réalisation : OK
- [ ] Supprimer une réalisation : OK
- [ ] Uploader des images : OK
- [ ] Pas d'erreur PHP dans debug.log

---

## 📊 Résultats Attendus

### ✅ Tous les tests passent
- Toutes les fonctionnalités SEO sont actives
- Aucune erreur technique
- Affichage correct sur tous les devices
- Validation externe réussie

### ⚠️ Quelques tests échouent
- Identifier les fonctionnalités problématiques
- Vérifier les logs : `wp-content/debug.log`
- Désactiver temporairement la fonction concernée
- Contacter le support

### ❌ Beaucoup de tests échouent
- Vérifier que Docker est bien lancé
- Vérifier que le thème est activé
- Vérifier les permissions fichiers
- Réinstaller si nécessaire

---

## 📝 Rapport de Test

### Informations
- **Date du test** : _______________
- **Testeur** : _______________
- **Environnement** : ☐ Local Docker ☐ Staging ☐ Production
- **URL testée** : _______________

### Résultats
| Catégorie | Tests Passés | Tests Échoués | Notes |
|-----------|--------------|---------------|-------|
| Tests Rapides (5 min) | __ / 5 | __ | |
| Tests Approfondis (15 min) | __ / 6 | __ | |
| Tests Externes (10 min) | __ / 4 | __ | |
| Tests Responsive (5 min) | __ / 2 | __ | |
| Tests Techniques (5 min) | __ / 3 | __ | |
| Tests Visuels (5 min) | __ / 3 | __ | |
| Tests Régression (10 min) | __ / 3 | __ | |

### Score Global
**__ / 26 tests passés** (__ %)

### Statut Final
☐ ✅ Validé - Prêt pour la production  
☐ ⚠️ Validé avec réserves - Corrections mineures nécessaires  
☐ ❌ Non validé - Corrections majeures nécessaires

### Problèmes Identifiés
1. _______________________________________________
2. _______________________________________________
3. _______________________________________________

### Actions Correctives
1. _______________________________________________
2. _______________________________________________
3. _______________________________________________

---

## 🚀 Validation Finale

Avant de passer en production, vérifier :

- [ ] Tous les tests rapides passent (100%)
- [ ] Au moins 80% des tests approfondis passent
- [ ] Validation Google Rich Results : 0 erreur
- [ ] Validation Schema.org : 0 erreur
- [ ] Affichage mobile correct
- [ ] Aucune erreur dans debug.log
- [ ] Performance acceptable (< 2s)
- [ ] Backup de la base de données effectué
- [ ] Commit Git effectué avec message clair

**Signature** : _______________  
**Date de validation** : _______________

---

**Version** : 1.0.0  
**Dernière mise à jour** : 18 novembre 2025
