<?php
/**
 * Section Formations - Page d'accueil
 * Version simplifiée avec CSS inline pour garantir l'affichage
 * 
 * @package ALMetallerie
 * @since 3.0.0
 */
?>

<section class="hp-formations-section" id="formations">
    <div class="hp-formations-wrapper">
        
        <!-- Tag -->
        <div class="hp-formations-tag">
            <span>Nos Formations</span>
        </div>

        <!-- Titre -->
        <h2 class="hp-formations-title">DÉVELOPPEZ VOS COMPÉTENCES</h2>

        <!-- Sous-titre -->
        <p class="hp-formations-subtitle">
            Formations professionnelles en métallerie adaptées à vos besoins
        </p>

        <!-- Grille des 2 cards -->
        <div class="hp-formations-cards">
            
            <!-- Card Professionnels -->
            <a href="<?php echo esc_url(home_url('/formations-professionnels')); ?>" class="hp-formation-card">
                <div class="hp-formation-card-icon">
                    <svg xmlns="http://www.w3.org/2000/svg" width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"></path>
                        <circle cx="9" cy="7" r="4"></circle>
                        <path d="M22 21v-2a4 4 0 0 0-3-3.87"></path>
                        <path d="M16 3.13a4 4 0 0 1 0 7.75"></path>
                    </svg>
                </div>
                <h3 class="hp-formation-card-title">PROFESSIONNELS</h3>
                <p class="hp-formation-card-desc">
                    Formations spécialisées pour les professionnels du métal : techniques avancées, perfectionnement et certification.
                </p>
                <ul class="hp-formation-card-list">
                    <li>✓ Certification professionnelle</li>
                    <li>✓ Formateurs experts</li>
                    <li>✓ Équipement professionnel</li>
                </ul>
                <span class="hp-formation-card-btn">En savoir plus →</span>
            </a>

            <!-- Card Particuliers -->
            <a href="<?php echo esc_url(home_url('/formations-particuliers')); ?>" class="hp-formation-card">
                <div class="hp-formation-card-icon">
                    <svg xmlns="http://www.w3.org/2000/svg" width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="m3 9 9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path>
                        <polyline points="9 22 9 12 15 12 15 22"></polyline>
                    </svg>
                </div>
                <h3 class="hp-formation-card-title">PARTICULIERS</h3>
                <p class="hp-formation-card-desc">
                    Initiations et ateliers pour les passionnés de métallerie : découverte des techniques et création de projets personnels.
                </p>
                <ul class="hp-formation-card-list">
                    <li>✓ Ateliers découverte</li>
                    <li>✓ Petits groupes</li>
                    <li>✓ Projets personnels</li>
                </ul>
                <span class="hp-formation-card-btn">En savoir plus →</span>
            </a>

        </div>
    </div>
</section>

<style>
/* ============================================
   SECTION FORMATIONS - HOME PAGE (hp-)
   Classes uniques avec préfixe hp- pour éviter conflits
   ============================================ */
.hp-formations-section {
    padding: 80px 0;
    background: linear-gradient(180deg, #0a0a0a 0%, #1a1a1a 100%);
}

.hp-formations-wrapper {
    max-width: 1200px;
    margin: 0 auto;
    padding: 0 2rem;
    text-align: center;
}

.hp-formations-tag {
    margin-bottom: 1.5rem;
}

.hp-formations-tag span {
    display: inline-block;
    padding: 8px 20px;
    background: rgba(240, 139, 24, 0.1);
    border: 1px solid rgba(240, 139, 24, 0.3);
    border-radius: 30px;
    color: #F08B18;
    font-size: 0.85rem;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 1px;
}

.hp-formations-title {
    font-size: 2.5rem;
    font-weight: 700;
    color: #fff;
    margin: 0 0 1rem 0;
    text-transform: uppercase;
    letter-spacing: 2px;
}

.hp-formations-subtitle {
    font-size: 1.1rem;
    color: rgba(255, 255, 255, 0.7);
    max-width: 600px;
    margin: 0 auto 3rem auto;
    line-height: 1.6;
}

.hp-formations-cards {
    display: grid;
    grid-template-columns: repeat(2, 1fr);
    gap: 2rem;
    max-width: 900px;
    margin: 0 auto;
}

.hp-formation-card {
    background: rgba(34, 34, 34, 0.6);
    backdrop-filter: blur(10px);
    border-radius: 16px;
    border: 1px solid rgba(240, 139, 24, 0.1);
    padding: 2rem;
    text-decoration: none;
    color: inherit;
    display: flex;
    flex-direction: column;
    align-items: center;
    text-align: center;
    transition: all 0.3s ease;
}

.hp-formation-card:hover {
    border-color: rgba(240, 139, 24, 0.4);
    box-shadow: 0 15px 40px rgba(240, 139, 24, 0.2);
    transform: translateY(-5px);
}

.hp-formation-card-icon {
    width: 80px;
    height: 80px;
    display: flex;
    align-items: center;
    justify-content: center;
    background: linear-gradient(135deg, #F08B18 0%, #e67e0f 100%);
    border-radius: 50%;
    margin-bottom: 1.5rem;
    box-shadow: 0 8px 25px rgba(240, 139, 24, 0.3);
}

.hp-formation-card-icon svg {
    width: 40px;
    height: 40px;
    color: white;
    stroke: white;
}

.hp-formation-card-title {
    font-size: 1.5rem;
    font-weight: 700;
    color: #F08B18;
    margin: 0 0 1rem 0;
    text-transform: uppercase;
    letter-spacing: 1px;
}

.hp-formation-card-desc {
    font-size: 1rem;
    line-height: 1.7;
    color: rgba(255, 255, 255, 0.8);
    margin: 0 0 1.5rem 0;
}

.hp-formation-card-list {
    list-style: none;
    padding: 0;
    margin: 0 0 1.5rem 0;
    text-align: left;
    width: 100%;
}

.hp-formation-card-list li {
    color: rgba(255, 255, 255, 0.9);
    font-size: 0.95rem;
    padding: 0.5rem 0;
    border-bottom: 1px solid rgba(255, 255, 255, 0.1);
}

.hp-formation-card-list li:last-child {
    border-bottom: none;
}

.hp-formation-card-btn {
    display: inline-block;
    padding: 12px 24px;
    background: linear-gradient(135deg, #F08B18 0%, #e67e0f 100%);
    color: white;
    font-weight: 600;
    border-radius: 8px;
    margin-top: auto;
    transition: all 0.3s ease;
}

.hp-formation-card:hover .hp-formation-card-btn {
    box-shadow: 0 8px 25px rgba(240, 139, 24, 0.4);
}

/* Responsive */
@media (max-width: 768px) {
    .hp-formations-section {
        padding: 60px 0;
    }
    
    .hp-formations-title {
        font-size: 1.75rem;
    }
    
    .hp-formations-cards {
        grid-template-columns: 1fr;
        gap: 1.5rem;
    }
    
    .hp-formation-card {
        padding: 1.5rem;
    }
    
    .hp-formation-card-icon {
        width: 60px;
        height: 60px;
    }
    
    .hp-formation-card-icon svg {
        width: 30px;
        height: 30px;
    }
    
    .hp-formation-card-title {
        font-size: 1.25rem;
    }
}
</style>
