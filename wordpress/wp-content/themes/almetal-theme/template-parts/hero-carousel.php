<?php
/**
 * Template part pour le carrousel hero
 * Version adaptative : Desktop (JS custom) / Mobile (Swiper.js)
 * Données dynamiques depuis l'interface d'administration
 */

$is_mobile = almetal_is_mobile();

// Récupérer les slides depuis la base de données
$slides = Almetal_Slideshow_Admin::get_slides();

// Filtrer les slides actifs uniquement
$active_slides = array_filter($slides, function($slide) {
    return isset($slide['active']) && $slide['active'] === true;
});

// Trier par ordre
usort($active_slides, function($a, $b) {
    return ($a['order'] ?? 0) - ($b['order'] ?? 0);
});

// Si aucun slide actif, ne rien afficher
if (empty($active_slides)) {
    return;
}
?>

<?php if ($is_mobile) : ?>
    <!-- Hero Carousel MOBILE (Swiper) - Contenu dynamique -->
    <div class="mobile-hero-swiper swiper">
        <div class="swiper-wrapper">
            <?php foreach ($active_slides as $index => $slide) : ?>
                <!-- Slide <?php echo ($index + 1); ?> -->
                <div class="swiper-slide mobile-hero-slide">
                    <div class="mobile-hero-image" style="background-image: url('<?php echo esc_url($slide['image']); ?>');"></div>
                    <div class="mobile-hero-overlay"></div>
                    <div class="mobile-hero-content">
                        <?php if (!empty($slide['title'])) : ?>
                            <h1 class="mobile-hero-title"><?php echo esc_html($slide['title']); ?></h1>
                        <?php endif; ?>
                        
                        <?php if (!empty($slide['subtitle'])) : ?>
                            <p class="mobile-hero-subtitle"><?php echo esc_html($slide['subtitle']); ?></p>
                        <?php endif; ?>
                        
                        <?php if (!empty($slide['cta_text']) && !empty($slide['cta_url'])) : ?>
                            <a href="<?php echo esc_url($slide['cta_url']); ?>" class="mobile-hero-cta">
                                <?php echo esc_html($slide['cta_text']); ?>
                            </a>
                        <?php endif; ?>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
        
        <!-- Pagination -->
        <div class="swiper-pagination"></div>
    </div>

<?php else : ?>
    <!-- Hero Carousel DESKTOP (JS custom) - Contenu dynamique -->
    <section id="hero" class="hero-carousel">
        <div class="hero-slides">
            <?php foreach ($active_slides as $index => $slide) : ?>
                <!-- Slide <?php echo ($index + 1); ?> -->
                <div class="hero-slide" style="background-image: url('<?php echo esc_url($slide['image']); ?>');">
                    <div class="hero-content">
                        <?php if (!empty($slide['title'])) : ?>
                            <h1 class="hero-title"><?php echo esc_html($slide['title']); ?></h1>
                        <?php endif; ?>
                        
                        <?php if (!empty($slide['subtitle'])) : ?>
                            <p class="hero-subtitle"><?php echo esc_html($slide['subtitle']); ?></p>
                        <?php endif; ?>
                        
                        <?php if (!empty($slide['cta_text']) && !empty($slide['cta_url'])) : ?>
                            <a href="<?php echo esc_url($slide['cta_url']); ?>" class="hero-cta">
                                <?php echo esc_html($slide['cta_text']); ?>
                            </a>
                        <?php endif; ?>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
        
        <!-- Contrôles du carrousel -->
        <button class="hero-prev" aria-label="Slide précédent">
            <span class="circle" aria-hidden="true">
                <svg class="icon arrow arrow-left" width="18" height="12" viewBox="0 0 18 12" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M17 6H1M1 6L6 1M1 6L6 11" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
            </span>
        </button>
        <button class="hero-next" aria-label="Slide suivant">
            <span class="circle" aria-hidden="true">
                <svg class="icon arrow arrow-right" width="18" height="12" viewBox="0 0 18 12" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M1 6H17M17 6L12 1M17 6L12 11" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
            </span>
        </button>
        
        <!-- Indicateurs de slide -->
        <div class="hero-indicators"></div>
    </section>
<?php endif; ?>
