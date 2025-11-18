#!/bin/bash

# Script de réinitialisation de l'environnement Docker WordPress
# AL Métallerie - Environnement de développement local

set -e  # Arrêter en cas d'erreur

echo "🚀 Réinitialisation de l'environnement Docker WordPress..."
echo ""

# Couleurs pour les messages
GREEN='\033[0;32m'
YELLOW='\033[1;33m'
RED='\033[0;31m'
NC='\033[0m' # No Color

# ============================================
# ÉTAPE 1 : NETTOYAGE
# ============================================

echo -e "${YELLOW}📦 Étape 1/5 : Arrêt et nettoyage de Docker...${NC}"

# Arrêter les conteneurs et supprimer les volumes
if docker compose ps | grep -q "Up"; then
    echo "   → Arrêt des conteneurs..."
    docker compose down -v
else
    echo "   → Aucun conteneur en cours d'exécution"
fi

echo -e "${GREEN}   ✓ Docker nettoyé${NC}"
echo ""

# ============================================
# ÉTAPE 2 : SAUVEGARDE DU THÈME
# ============================================

echo -e "${YELLOW}💾 Étape 2/5 : Sauvegarde du thème...${NC}"

# Vérifier si le thème existe
if [ -d "wordpress/wp-content/themes/almetal-theme" ]; then
    echo "   → Sauvegarde du thème dans ~/Desktop/almetal-theme-backup..."
    rm -rf ~/Desktop/almetal-theme-backup
    cp -r wordpress/wp-content/themes/almetal-theme ~/Desktop/almetal-theme-backup
    echo -e "${GREEN}   ✓ Thème sauvegardé${NC}"
else
    echo -e "${RED}   ⚠ Thème non trouvé dans wordpress/wp-content/themes/almetal-theme${NC}"
    echo "   → Tentative de restauration depuis Git..."
    git restore wordpress/wp-content/themes/almetal-theme 2>/dev/null || echo "   ⚠ Impossible de restaurer depuis Git"
    
    if [ -d "wordpress/wp-content/themes/almetal-theme" ]; then
        echo "   → Sauvegarde du thème restauré..."
        cp -r wordpress/wp-content/themes/almetal-theme ~/Desktop/almetal-theme-backup
        echo -e "${GREEN}   ✓ Thème restauré et sauvegardé${NC}"
    else
        echo -e "${RED}   ✗ ERREUR : Impossible de trouver le thème${NC}"
        echo "   Vérifiez que le thème existe dans le dépôt Git"
        exit 1
    fi
fi

echo ""

# ============================================
# ÉTAPE 3 : SUPPRESSION DU DOSSIER WORDPRESS
# ============================================

echo -e "${YELLOW}🗑️  Étape 3/5 : Suppression du dossier wordpress cassé...${NC}"

if [ -d "wordpress" ]; then
    echo "   → Suppression de wordpress/..."
    rm -rf wordpress/
    echo -e "${GREEN}   ✓ Dossier wordpress supprimé${NC}"
else
    echo "   → Dossier wordpress déjà absent"
fi

echo ""

# ============================================
# ÉTAPE 4 : CRÉATION DE LA STRUCTURE
# ============================================

echo -e "${YELLOW}📁 Étape 4/5 : Création de la structure minimale...${NC}"

# Créer les dossiers nécessaires pour les montages Docker
echo "   → Création des dossiers wp-content..."
mkdir -p wordpress/wp-content/themes
mkdir -p wordpress/wp-content/plugins
mkdir -p wordpress/wp-content/uploads

echo -e "${GREEN}   ✓ Structure créée${NC}"
echo ""

# ============================================
# ÉTAPE 5 : RESTAURATION DU THÈME
# ============================================

echo -e "${YELLOW}🎨 Étape 5/5 : Restauration du thème...${NC}"

if [ -d ~/Desktop/almetal-theme-backup ]; then
    echo "   → Copie du thème depuis la sauvegarde..."
    cp -r ~/Desktop/almetal-theme-backup wordpress/wp-content/themes/almetal-theme
    echo -e "${GREEN}   ✓ Thème restauré${NC}"
else
    echo -e "${RED}   ✗ ERREUR : Sauvegarde du thème introuvable${NC}"
    exit 1
fi

echo ""

# ============================================
# RÉSUMÉ
# ============================================

echo -e "${GREEN}✅ Environnement réinitialisé avec succès !${NC}"
echo ""
echo "📋 Prochaines étapes :"
echo ""
echo "   1. Lancer Docker :"
echo -e "      ${YELLOW}docker compose up -d${NC}"
echo ""
echo "   2. Attendre 30 secondes puis vérifier les logs :"
echo -e "      ${YELLOW}docker compose logs -f wordpress${NC}"
echo ""
echo "   3. Ouvrir WordPress dans le navigateur :"
echo -e "      ${YELLOW}http://localhost:8000${NC}"
echo ""
echo "   4. Suivre l'installation WordPress (langue, base de données, etc.)"
echo ""
echo "   5. Activer le thème AL Métallerie dans Apparence > Thèmes"
echo ""
echo -e "${GREEN}🎉 Bon développement !${NC}"
echo ""
