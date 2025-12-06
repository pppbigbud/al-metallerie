# 🍪 Implémentation Bannière de Cookies - AL Metallerie

## ✅ RÉSUMÉ DE L'IMPLÉMENTATION

J'ai créé une bannière de consentement aux cookies **100% native** (sans plugin), parfaitement intégrée au design de votre site AL Metallerie.

---

## 📁 FICHIERS CRÉÉS

### 1. **CSS** : `assets/css/cookie-banner.css`
```
Taille : ~4KB
Contenu : Styles responsive, animations, accessibilité
Couleurs : Intégrées à votre palette (#F08B18, #2a2a2a)
Polices : Roboto Flex, Poppins (vos polices existantes)
```

### 2. **JavaScript** : `assets/js/cookie-consent.js`
```
Taille : ~6KB
Contenu : Logique de consentement, gestion des cookies
Dépendances : Aucune (vanilla JS)
Fonctionnalités : Accepter, Refuser, Stockage, Vérification
```

### 3. **Documentation** : `COOKIE-BANNER-README.md`
```
Guide complet d'utilisation, configuration et personnalisation
```

---

## 🔧 FICHIERS MODIFIÉS

### 1. **functions.php** (lignes 404-423)
```php
// Ajout de l'enqueue du CSS et JS de la bannière
wp_enqueue_style('almetal-cookie-banner', ...);
wp_enqueue_script('almetal-cookie-consent', ...);
```

### 2. **footer.php** (lignes 305-310)
```php
// Ajout d'un commentaire pour indiquer l'injection JS
```

---

## 🎨 DESIGN & INTÉGRATION

### Couleurs utilisées (de votre palette)
- **Orange principal** : `#F08B18` (bouton Accepter, bordure, icône)
- **Fond sombre** : `#2a2a2a` / `#222222` (dégradé)
- **Texte clair** : `#ECECEC`
- **Hover orange** : `#ff9f3a`

### Typographie (vos polices)
- **Police principale** : Roboto Flex, Roboto
- **Titres** : Poppins

### Style des boutons (cohérent avec votre site)
- **Border radius** : 8px
- **Transitions** : 0.3s ease
- **Hover** : Lift effect (-2px translateY)
- **Box shadow** : Ombres subtiles

---

## 📱 RESPONSIVE

| Device | Layout | Comportement |
|--------|--------|--------------|
| **Desktop** (>1024px) | Horizontal | Contenu + boutons côte à côte |
| **Tablet** (769-1024px) | Horizontal compact | Espacements réduits |
| **Mobile** (<768px) | Vertical | Boutons pleine largeur empilés |

---

## ⚙️ FONCTIONNALITÉS

### ✅ Comportement
- **Apparition** : Slide-up avec fade-in après 800ms
- **Disparition** : Slide-down avec fade-out (400ms)
- **Vérification** : Au chargement de chaque page
- **Stockage** : Cookie `almetal_cookie_consent` valable 365 jours

### ✅ Actions utilisateur
- **Accepter** : Stocke "accepted" → Cache la bannière
- **Refuser** : Stocke "declined" → Cache la bannière
- **Lien "En savoir plus"** : Redirige vers `/politique-confidentialite`
- **Touche Escape** : Ferme la bannière (équivalent à "Refuser")

### ✅ Accessibilité
- **ARIA** : `role="dialog"`, `aria-label`, `aria-live="polite"`
- **Clavier** : Navigation complète au clavier
- **Focus** : Focus automatique sur "Accepter" à l'ouverture
- **Reduced motion** : Respect de `prefers-reduced-motion`

---

## 🧪 COMMENT TESTER

### 1. Première visite
```
1. Ouvrir votre site dans un navigateur
2. La bannière apparaît en bas après ~800ms
3. Vérifier l'apparence (couleurs, polices, responsive)
```

### 2. Accepter les cookies
```
1. Cliquer sur "Accepter"
2. La bannière disparaît avec animation
3. Recharger la page → La bannière ne réapparaît pas
```

### 3. Refuser les cookies
```
1. Réinitialiser : resetCookieConsent() dans la console
2. Recharger la page
3. Cliquer sur "Refuser"
4. La bannière disparaît
5. Recharger → La bannière ne réapparaît pas
```

### 4. Vérifier le cookie
```javascript
// Dans la console du navigateur
document.cookie

// Résultat attendu :
// "almetal_cookie_consent=accepted" ou "almetal_cookie_consent=declined"
```

### 5. Réinitialiser le consentement
```javascript
// Dans la console du navigateur
resetCookieConsent()

// La page se recharge et la bannière réapparaît
```

---

## 🔐 CONFORMITÉ RGPD

### ✅ Points conformes
- ✅ Information claire sur l'utilisation des cookies
- ✅ Choix explicite de l'utilisateur (accepter/refuser)
- ✅ Lien vers la politique de confidentialité
- ✅ Stockage du consentement
- ✅ Durée de conservation définie (365 jours)
- ✅ Bannière non intrusive (ne bloque pas le contenu)

### ⚠️ À compléter (selon vos besoins légaux)
- Liste détaillée des cookies utilisés (page dédiée)
- Gestion granulaire (cookies essentiels, analytiques, marketing)
- Possibilité de révoquer le consentement (page paramètres)
- Intégration avec Google Analytics, Facebook Pixel, etc.

---

## 🚀 ACTIVATION

La bannière est **automatiquement active** dès maintenant !

### Vérification
1. Vider le cache du navigateur
2. Ouvrir votre site
3. La bannière devrait apparaître en bas

### Si la bannière n'apparaît pas
1. Vérifier que les fichiers existent :
   - `assets/css/cookie-banner.css`
   - `assets/js/cookie-consent.js`
2. Vérifier la console du navigateur (F12) pour les erreurs
3. Vider le cache WordPress (si plugin de cache actif)

---

## 🎯 PERSONNALISATION

### Modifier le texte
**Fichier** : `assets/js/cookie-consent.js` (ligne ~70)
```javascript
<p>
    Votre nouveau texte ici...
    <a href="${this.getPolicyUrl()}">En savoir plus</a>
</p>
```

### Modifier la durée du cookie
**Fichier** : `assets/js/cookie-consent.js` (ligne ~12)
```javascript
const CONFIG = {
    cookieDuration: 365, // Modifier ici (en jours)
};
```

### Modifier les couleurs
**Fichier** : `assets/css/cookie-banner.css`
```css
/* Changer la couleur principale */
var(--color-primary, #F08B18) → var(--color-primary, #VOTRE_COULEUR)
```

### Modifier l'animation
**Fichier** : `assets/js/cookie-consent.js` (ligne ~13-14)
```javascript
const CONFIG = {
    showDelay: 800, // Délai d'apparition (ms)
    hideDelay: 400  // Délai de disparition (ms)
};
```

---

## 🔗 INTÉGRATION AVEC ANALYTICS

Si vous souhaitez activer Google Analytics ou Facebook Pixel après acceptation :

**Fichier** : `assets/js/cookie-consent.js` (ligne ~180)
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

---

## 📊 STRUCTURE DU CODE

### CSS (cookie-banner.css)
```
1. Conteneur principal (.cookie-consent-banner)
2. Conteneur interne (.cookie-consent-container)
3. Contenu texte (.cookie-consent-content)
4. Icône cookie (.cookie-consent-icon)
5. Boutons d'action (.cookie-consent-actions)
6. Responsive (media queries)
7. Animations (keyframes)
8. Accessibilité (focus, reduced motion)
```

### JavaScript (cookie-consent.js)
```
1. Configuration (CONFIG)
2. Classe CookieConsent
3. Méthodes :
   - init() : Initialisation
   - hasConsent() : Vérification du cookie
   - createBanner() : Création du HTML
   - showBanner() : Affichage avec animation
   - hideBanner() : Masquage avec animation
   - handleAccept() : Gestion de l'acceptation
   - handleDecline() : Gestion du refus
   - setCookie() / getCookie() : Gestion des cookies
4. Fonction globale resetCookieConsent()
```

---

## 📝 NOTES IMPORTANTES

### Performance
- **Poids total** : ~10KB (CSS + JS non minifié)
- **Chargement** : Asynchrone, pas de blocage
- **Dépendances** : Aucune (vanilla JS)

### Compatibilité
- **Navigateurs** : Tous navigateurs modernes (Chrome, Firefox, Safari, Edge)
- **IE11** : Compatible (avec polyfills si nécessaire)

### Z-index
- **Valeur** : 999999
- **Raison** : Garantir que la bannière est toujours au-dessus du contenu

### Sécurité
- **SameSite** : Lax (protection CSRF)
- **Secure** : Activé automatiquement en HTTPS
- **Sanitization** : Tous les inputs sont nettoyés

---

## 🆘 SUPPORT & DÉPANNAGE

### La bannière n'apparaît pas
1. Vérifier la console (F12) pour les erreurs JavaScript
2. Vérifier que les fichiers CSS/JS sont bien chargés (onglet Network)
3. Vider le cache du navigateur et WordPress
4. Vérifier que `wp_footer()` est présent dans footer.php

### La bannière apparaît à chaque visite
1. Vérifier que les cookies sont activés dans le navigateur
2. Vérifier que le domaine du cookie est correct
3. Tester dans un autre navigateur

### Le style ne correspond pas
1. Vider le cache CSS
2. Vérifier que `cookie-banner.css` est bien chargé
3. Vérifier les conflits avec d'autres CSS (DevTools)

### Questions ou personnalisations
Consulter les fichiers :
- `COOKIE-BANNER-README.md` (documentation complète)
- `assets/css/cookie-banner.css` (styles)
- `assets/js/cookie-consent.js` (logique)

---

## ✨ RÉSULTAT FINAL

Vous disposez maintenant d'une bannière de cookies :
- ✅ **Conforme RGPD** (information + consentement)
- ✅ **Intégrée au design** (couleurs, polices, style)
- ✅ **Responsive** (mobile, tablet, desktop)
- ✅ **Accessible** (ARIA, clavier, reduced motion)
- ✅ **Performante** (vanilla JS, pas de dépendances)
- ✅ **Personnalisable** (texte, couleurs, durée)
- ✅ **Documentée** (README complet)

---

**Créé le** : 14 novembre 2024  
**Version** : 1.0.0  
**Auteur** : BIGBUD pour AL Metallerie  
**Thème** : almetal-theme
