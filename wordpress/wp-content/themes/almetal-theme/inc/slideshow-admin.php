<?php
/**
 * Interface d'administration pour la gestion du slideshow
 * 
 * @package ALMetallerie
 * @since 1.0.0
 */

// Sécurité : empêcher l'accès direct
if (!defined('ABSPATH')) {
    exit;
}

/**
 * Classe de gestion du slideshow
 */
class Almetal_Slideshow_Admin {
    
    /**
     * Nom de l'option dans la base de données
     */
    const OPTION_NAME = 'almetal_slideshow_slides';
    
    /**
     * Nombre maximum de slides
     */
    const MAX_SLIDES = 3;
    
    /**
     * Constructeur
     */
    public function __construct() {
        // Ajouter le menu d'administration
        add_action('admin_menu', array($this, 'add_admin_menu'));
        
        // Enregistrer les scripts et styles admin
        add_action('admin_enqueue_scripts', array($this, 'enqueue_admin_assets'));
        
        // Traiter la sauvegarde
        add_action('admin_post_save_slideshow', array($this, 'save_slideshow'));
        
        // AJAX pour la réorganisation des slides
        add_action('wp_ajax_reorder_slides', array($this, 'ajax_reorder_slides'));
    }
    
    /**
     * Ajouter le menu dans l'administration
     */
    public function add_admin_menu() {
        add_menu_page(
            'Gestion du Slideshow',           // Titre de la page
            'Slideshow Accueil',               // Titre du menu
            'edit_theme_options',              // Capacité requise
            'almetal-slideshow',               // Slug du menu
            array($this, 'render_admin_page'), // Fonction de callback
            'dashicons-images-alt2',           // Icône
            25                                 // Position (après "Apparence")
        );
    }
    
    /**
     * Enregistrer les assets admin
     */
    public function enqueue_admin_assets($hook) {
        // Charger uniquement sur notre page
        if ($hook !== 'toplevel_page_almetal-slideshow') {
            return;
        }
        
        // Enqueue WordPress Media Uploader
        wp_enqueue_media();
        
        // Enqueue jQuery UI Sortable pour le drag & drop
        wp_enqueue_script('jquery-ui-sortable');
        
        // CSS admin personnalisé
        wp_enqueue_style(
            'almetal-slideshow-admin',
            get_template_directory_uri() . '/assets/css/admin-slideshow.css',
            array(),
            '1.0.0'
        );
        
        // JS admin personnalisé
        wp_enqueue_script(
            'almetal-slideshow-admin',
            get_template_directory_uri() . '/assets/js/admin-slideshow.js',
            array('jquery', 'jquery-ui-sortable'),
            '1.0.0',
            true
        );
        
        // Passer des données à JavaScript
        wp_localize_script('almetal-slideshow-admin', 'almetalSlideshow', array(
            'ajaxUrl' => admin_url('admin-ajax.php'),
            'nonce' => wp_create_nonce('almetal_slideshow_nonce'),
            'maxSlides' => self::MAX_SLIDES,
        ));
    }
    
    /**
     * Récupérer les slides depuis la base de données
     */
    public static function get_slides() {
        $slides = get_option(self::OPTION_NAME, array());
        
        // Si vide, retourner les valeurs par défaut (slides actuelles hardcodées)
        if (empty($slides)) {
            $slides = self::get_default_slides();
        }
        
        return $slides;
    }
    
    /**
     * Slides par défaut (valeurs actuelles du site)
     */
    private static function get_default_slides() {
        return array(
            array(
                'active' => true,
                'image' => get_template_directory_uri() . '/assets/images/hero/hero-1.png',
                'title' => 'Bienvenue chez AL Métallerie',
                'subtitle' => 'Expert en métallerie à Clermont-Ferrand',
                'cta_text' => 'Demander un devis',
                'cta_url' => '#contact',
                'order' => 0,
            ),
            array(
                'active' => true,
                'image' => get_template_directory_uri() . '/assets/images/hero/hero-2.png',
                'title' => 'Créations sur mesure',
                'subtitle' => 'Portails, garde-corps, escaliers',
                'cta_text' => 'Découvrir nos réalisations',
                'cta_url' => '#services',
                'order' => 1,
            ),
            array(
                'active' => true,
                'image' => get_template_directory_uri() . '/assets/images/hero/hero-3.png',
                'title' => 'Formations',
                'subtitle' => 'Particulier, centre de formation, à la demande',
                'cta_text' => 'Découvrir nos formations',
                'cta_url' => '#services',
                'order' => 2,
            ),
        );
    }
    
    /**
     * Afficher la page d'administration
     */
    public function render_admin_page() {
        // Vérifier les permissions
        if (!current_user_can('edit_theme_options')) {
            wp_die(__('Vous n\'avez pas les permissions nécessaires pour accéder à cette page.'));
        }
        
        // Récupérer les slides
        $slides = self::get_slides();
        
        // Trier par ordre
        usort($slides, function($a, $b) {
            return ($a['order'] ?? 0) - ($b['order'] ?? 0);
        });
        
        ?>
        <div class="wrap almetal-slideshow-admin">
            <h1>
                <span class="dashicons dashicons-images-alt2"></span>
                Gestion du Slideshow - Page d'Accueil
            </h1>
            
            <div class="almetal-admin-notice">
                <p>
                    <strong>ℹ️ Instructions :</strong> 
                    Gérez les 3 slides du carrousel de la page d'accueil. 
                    Vous pouvez modifier les images, textes et boutons. 
                    Glissez-déposez les slides pour changer leur ordre.
                </p>
            </div>
            
            <?php if (isset($_GET['updated']) && $_GET['updated'] === 'true') : ?>
                <div class="notice notice-success is-dismissible">
                    <p><strong>✅ Slideshow mis à jour avec succès !</strong></p>
                </div>
            <?php endif; ?>
            
            <form method="post" action="<?php echo admin_url('admin-post.php'); ?>" class="almetal-slideshow-form">
                <?php wp_nonce_field('almetal_slideshow_save', 'almetal_slideshow_nonce'); ?>
                <input type="hidden" name="action" value="save_slideshow">
                
                <div id="slides-container" class="slides-container">
                    <?php foreach ($slides as $index => $slide) : ?>
                        <?php $this->render_slide_editor($index, $slide); ?>
                    <?php endforeach; ?>
                </div>
                
                <div class="almetal-form-footer">
                    <button type="submit" class="button button-primary button-hero">
                        <span class="dashicons dashicons-yes"></span>
                        Enregistrer les modifications
                    </button>
                    
                    <button type="button" id="reset-slides" class="button button-secondary">
                        <span class="dashicons dashicons-image-rotate"></span>
                        Réinitialiser aux valeurs par défaut
                    </button>
                </div>
            </form>
        </div>
        <?php
    }
    
    /**
     * Afficher l'éditeur d'un slide
     */
    private function render_slide_editor($index, $slide) {
        $active = isset($slide['active']) ? $slide['active'] : true;
        $image = isset($slide['image']) ? $slide['image'] : '';
        $title = isset($slide['title']) ? $slide['title'] : '';
        $subtitle = isset($slide['subtitle']) ? $slide['subtitle'] : '';
        $cta_text = isset($slide['cta_text']) ? $slide['cta_text'] : '';
        $cta_url = isset($slide['cta_url']) ? $slide['cta_url'] : '';
        $order = isset($slide['order']) ? $slide['order'] : $index;
        
        ?>
        <div class="slide-editor <?php echo $active ? '' : 'slide-inactive'; ?>" data-slide-index="<?php echo $index; ?>">
            <div class="slide-header">
                <div class="slide-drag-handle">
                    <span class="dashicons dashicons-menu"></span>
                </div>
                <h2 class="slide-title-header">
                    Slide <?php echo ($index + 1); ?>
                </h2>
                <div class="slide-toggle">
                    <label class="toggle-switch">
                        <input type="checkbox" 
                               name="slides[<?php echo $index; ?>][active]" 
                               value="1" 
                               <?php checked($active, true); ?>
                               class="slide-active-toggle">
                        <span class="toggle-slider"></span>
                    </label>
                    <span class="toggle-label"><?php echo $active ? 'Activé' : 'Désactivé'; ?></span>
                </div>
            </div>
            
            <div class="slide-content">
                <input type="hidden" name="slides[<?php echo $index; ?>][order]" value="<?php echo $order; ?>" class="slide-order-input">
                
                <!-- Image -->
                <div class="form-group">
                    <label class="form-label">
                        <span class="dashicons dashicons-format-image"></span>
                        Image de fond
                        <span class="required">*</span>
                    </label>
                    <div class="image-upload-wrapper">
                        <div class="image-preview <?php echo $image ? 'has-image' : ''; ?>">
                            <?php if ($image) : ?>
                                <img src="<?php echo esc_url($image); ?>" alt="Aperçu">
                            <?php endif; ?>
                            <div class="image-preview-overlay">
                                <button type="button" class="button upload-image-button">
                                    <span class="dashicons dashicons-upload"></span>
                                    <?php echo $image ? 'Changer l\'image' : 'Choisir une image'; ?>
                                </button>
                                <?php if ($image) : ?>
                                    <button type="button" class="button button-link-delete remove-image-button">
                                        <span class="dashicons dashicons-no"></span>
                                        Supprimer
                                    </button>
                                <?php endif; ?>
                            </div>
                        </div>
                        <input type="hidden" 
                               name="slides[<?php echo $index; ?>][image]" 
                               value="<?php echo esc_attr($image); ?>" 
                               class="image-url-input"
                               required>
                    </div>
                    <p class="form-help">Taille recommandée : 1920x800px minimum</p>
                </div>
                
                <!-- Titre -->
                <div class="form-group">
                    <label class="form-label">
                        <span class="dashicons dashicons-text"></span>
                        Titre principal
                        <span class="required">*</span>
                    </label>
                    <input type="text" 
                           name="slides[<?php echo $index; ?>][title]" 
                           value="<?php echo esc_attr($title); ?>" 
                           class="form-control"
                           placeholder="Ex: Bienvenue chez AL Métallerie"
                           required>
                </div>
                
                <!-- Sous-titre -->
                <div class="form-group">
                    <label class="form-label">
                        <span class="dashicons dashicons-editor-alignleft"></span>
                        Sous-titre / Description
                    </label>
                    <textarea name="slides[<?php echo $index; ?>][subtitle]" 
                              class="form-control"
                              rows="2"
                              placeholder="Ex: Expert en métallerie à Clermont-Ferrand"><?php echo esc_textarea($subtitle); ?></textarea>
                </div>
                
                <!-- Bouton CTA -->
                <div class="form-row">
                    <div class="form-group form-group-half">
                        <label class="form-label">
                            <span class="dashicons dashicons-admin-links"></span>
                            Texte du bouton
                        </label>
                        <input type="text" 
                               name="slides[<?php echo $index; ?>][cta_text]" 
                               value="<?php echo esc_attr($cta_text); ?>" 
                               class="form-control"
                               placeholder="Ex: Demander un devis">
                    </div>
                    
                    <div class="form-group form-group-half">
                        <label class="form-label">
                            <span class="dashicons dashicons-admin-site"></span>
                            URL du bouton
                        </label>
                        <input type="text" 
                               name="slides[<?php echo $index; ?>][cta_url]" 
                               value="<?php echo esc_attr($cta_url); ?>" 
                               class="form-control"
                               placeholder="Ex: #contact ou /contact">
                        <p class="form-help">Utilisez # pour les ancres (ex: #contact) ou une URL complète</p>
                    </div>
                </div>
            </div>
        </div>
        <?php
    }
    
    /**
     * Sauvegarder le slideshow
     */
    public function save_slideshow() {
        // Vérifier le nonce
        if (!isset($_POST['almetal_slideshow_nonce']) || 
            !wp_verify_nonce($_POST['almetal_slideshow_nonce'], 'almetal_slideshow_save')) {
            wp_die('Erreur de sécurité');
        }
        
        // Vérifier les permissions
        if (!current_user_can('edit_theme_options')) {
            wp_die('Permissions insuffisantes');
        }
        
        // Récupérer et nettoyer les données
        $slides = isset($_POST['slides']) ? $_POST['slides'] : array();
        $cleaned_slides = array();
        
        foreach ($slides as $index => $slide) {
            $cleaned_slides[$index] = array(
                'active' => isset($slide['active']) && $slide['active'] === '1',
                'image' => esc_url_raw($slide['image']),
                'title' => sanitize_text_field($slide['title']),
                'subtitle' => sanitize_textarea_field($slide['subtitle']),
                'cta_text' => sanitize_text_field($slide['cta_text']),
                'cta_url' => esc_url_raw($slide['cta_url']),
                'order' => intval($slide['order']),
            );
        }
        
        // Sauvegarder dans la base de données
        update_option(self::OPTION_NAME, $cleaned_slides);
        
        // Rediriger avec message de succès
        wp_redirect(add_query_arg(
            array('page' => 'almetal-slideshow', 'updated' => 'true'),
            admin_url('admin.php')
        ));
        exit;
    }
    
    /**
     * AJAX : Réorganiser les slides
     */
    public function ajax_reorder_slides() {
        // Vérifier le nonce
        check_ajax_referer('almetal_slideshow_nonce', 'nonce');
        
        // Vérifier les permissions
        if (!current_user_can('edit_theme_options')) {
            wp_send_json_error('Permissions insuffisantes');
        }
        
        // Récupérer l'ordre
        $order = isset($_POST['order']) ? $_POST['order'] : array();
        
        if (empty($order)) {
            wp_send_json_error('Ordre invalide');
        }
        
        // Récupérer les slides actuels
        $slides = self::get_slides();
        
        // Réorganiser
        $reordered = array();
        foreach ($order as $new_index => $old_index) {
            if (isset($slides[$old_index])) {
                $slides[$old_index]['order'] = $new_index;
                $reordered[$old_index] = $slides[$old_index];
            }
        }
        
        // Sauvegarder
        update_option(self::OPTION_NAME, $reordered);
        
        wp_send_json_success('Ordre mis à jour');
    }
}

// Initialiser la classe
new Almetal_Slideshow_Admin();
