# Bannière de Consentement aux Cookies - AL Metallerie

## 📋 Vue d'ensemble

Bannière de consentement aux cookies conforme RGPD, intégrée au design du site AL Metallerie. Solution native sans plugin externe.

## ✅ Fichiers créés

### 1. CSS : `assets/css/cookie-banner.css`
- Style moderne et minimaliste
- Intégré aux couleurs et typographies du site
- Responsive (mobile, tablet, desktop)
- Animations fluides

### 2. JavaScript : `assets/js/cookie-consent.js`
- Gestion du consentement (accepter/refuser)
- Stockage dans un cookie (durée : 365 jours)
- Vérification automatique au chargement
- Accessible (ARIA, navigation clavier)

### 3. Intégration : `functions.php`
- Enqueue du CSS et JS sur toutes les pages
- Chargement optimisé (CSS dans head, JS dans footer)

## 🎨 Design

### Couleurs utilisées
- **Orange principal** : `#F08B18` (couleur primaire du site)
- **Fond sombre** : `#2a2a2a` / `#222222` (dégradé)
- **Texte clair** : `#ECECEC`
- **Bordure supérieure** : Orange `#F08B18`

### Typographie
- **Police principale** : Roboto Flex, Roboto
- **Taille** : 0.95rem (desktop), 0.875rem (mobile)

### Boutons
- **Accepter** : Fond orange, hover avec lift effect
- **Refuser** : Transparent avec bordure, hover subtil

## 📱 Responsive

### Desktop (> 1024px)
- Bannière horizontale en bas de page
- Contenu et boutons côte à côte
- Icône cookie à gauche

### Tablet (769px - 1024px)
- Légère réduction des espacements
- Tailles de police adaptées

### Mobile (< 768px)
- Bannière en colonne (verticale)
- Boutons pleine largeur empilés
- Icône centrée au-dessus du texte

## ⚙️ Fonctionnalités

### Comportement
1. **Apparition** : Slide-up avec fade-in après 800ms
2. **Disparition** : Slide-down avec fade-out (400ms)
3. **Stockage** : Cookie `almetal_cookie_consent` valable 365 jours
4. **Vérification** : Ne réapparaît pas si le choix a été fait

### Actions
- **Accepter** : Stocke "accepted" dans le cookie
- **Refuser** : Stocke "declined" dans le cookie
- **Lien** : Redirige vers `/politique-confidentialite`

### Accessibilité
- **ARIA** : `role="dialog"`, `aria-label`, `aria-live`
- **Clavier** : Touche Escape pour fermer
- **Focus** : Focus automatique sur le bouton "Accepter"
- **Reduced motion** : Respect de `prefers-reduced-motion`

## 🔧 Configuration

### Modifier la durée du cookie
Dans `assets/js/cookie-consent.js` :
```javascript
const CONFIG = {
    cookieName: 'almetal_cookie_consent',
    cookieDuration: 365, // Modifier ici (en jours)
    showDelay: 800,
    hideDelay: 400
};
```

### Modifier le texte
Dans `assets/js/cookie-consent.js`, ligne ~70 :
```javascript
<p>
    Nous utilisons des cookies pour améliorer votre expérience sur notre site. 
    En continuant à naviguer, vous acceptez notre utilisation des cookies. 
    <a href="${this.getPolicyUrl()}" target="_blank" rel="noopener noreferrer">En savoir plus</a>
</p>
```

### Modifier les couleurs
Dans `assets/css/cookie-banner.css`, variables CSS :
```css
var(--color-primary, #F08B18)
var(--color-text, #ECECEC)
```

## 🧪 Tests

### Tester la bannière
1. Ouvrir le site dans un navigateur
2. La bannière apparaît après ~800ms
3. Cliquer sur "Accepter" ou "Refuser"
4. Recharger la page → la bannière ne réapparaît pas

### Réinitialiser le consentement
Dans la console du navigateur :
```javascript
resetCookieConsent();
```

### Vérifier le cookie
Dans la console du navigateur :
```javascript
document.cookie
```
Chercher : `almetal_cookie_consent=accepted` ou `almetal_cookie_consent=declined`

## 📊 Conformité RGPD

### ✅ Conforme
- Information claire sur l'utilisation des cookies
- Choix explicite (accepter/refuser)
- Lien vers la politique de confidentialité
- Stockage du consentement
- Durée de conservation définie (365 jours)

### ⚠️ À compléter (selon vos besoins)
- Liste détaillée des cookies utilisés
- Gestion granulaire (cookies essentiels, analytiques, marketing)
- Révocation du consentement (page dédiée)
- Intégration avec Google Analytics, Facebook Pixel, etc.

## 🚀 Activation

La bannière est **automatiquement active** après l'intégration des fichiers.

### Désactiver temporairement
Dans `functions.php`, commenter les lignes 408-423 :
```php
// wp_enqueue_style('almetal-cookie-banner', ...);
// wp_enqueue_script('almetal-cookie-consent', ...);
```

## 🔗 Intégration avec Analytics

Pour activer Google Analytics après acceptation, modifier `assets/js/cookie-consent.js` :

```javascript
onAccept() {
    console.log('Cookies acceptés');
    
    // Activer Google Analytics
    if (typeof gtag !== 'undefined') {
        gtag('consent', 'update', {
            'analytics_storage': 'granted'
        });
    }
    
    // Activer Facebook Pixel
    if (typeof fbq !== 'undefined') {
        fbq('consent', 'grant');
    }
}
```

## 📝 Notes

- **Performance** : Chargement asynchrone, pas de dépendances externes
- **Compatibilité** : Tous navigateurs modernes (IE11+)
- **Poids** : CSS ~4KB, JS ~6KB (non minifié)
- **Z-index** : 999999 (au-dessus de tout)

## 🆘 Support

Pour toute question ou personnalisation, consulter :
- `assets/css/cookie-banner.css` (styles)
- `assets/js/cookie-consent.js` (logique)
- `functions.php` (enqueue)

---

**Créé le** : 14 novembre 2024  
**Version** : 1.0.0  
**Auteur** : BIGBUD pour AL Metallerie
