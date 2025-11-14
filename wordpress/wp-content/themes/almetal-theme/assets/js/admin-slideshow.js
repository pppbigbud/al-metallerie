/**
 * JavaScript pour l'interface d'administration du slideshow
 * 
 * @package ALMetallerie
 * @since 1.0.0
 */

(function($) {
    'use strict';

    $(document).ready(function() {
        console.log('🎞️ Admin Slideshow - Initialisation');

        /**
         * Upload d'image avec WordPress Media Uploader
         */
        function initMediaUploader() {
            $('.upload-image-button').on('click', function(e) {
                e.preventDefault();

                const button = $(this);
                const slideEditor = button.closest('.slide-editor');
                const imagePreview = slideEditor.find('.image-preview');
                const imageInput = slideEditor.find('.image-url-input');

                // Créer le media uploader
                const mediaUploader = wp.media({
                    title: 'Choisir une image pour le slide',
                    button: {
                        text: 'Utiliser cette image'
                    },
                    multiple: false,
                    library: {
                        type: 'image'
                    }
                });

                // Quand une image est sélectionnée
                mediaUploader.on('select', function() {
                    const attachment = mediaUploader.state().get('selection').first().toJSON();
                    
                    // Utiliser l'image full size ou large
                    const imageUrl = attachment.sizes.full ? attachment.sizes.full.url : attachment.url;
                    
                    // Mettre à jour l'aperçu
                    imagePreview.addClass('has-image');
                    imagePreview.find('img').remove();
                    imagePreview.prepend('<img src="' + imageUrl + '" alt="Aperçu">');
                    
                    // Mettre à jour l'input caché
                    imageInput.val(imageUrl);
                    
                    // Mettre à jour le bouton de suppression
                    updateRemoveButton(slideEditor);
                    
                    console.log('✅ Image sélectionnée:', imageUrl);
                });

                // Ouvrir le media uploader
                mediaUploader.open();
            });
        }

        /**
         * Suppression d'image
         */
        function initImageRemoval() {
            $(document).on('click', '.remove-image-button', function(e) {
                e.preventDefault();

                const button = $(this);
                const slideEditor = button.closest('.slide-editor');
                const imagePreview = slideEditor.find('.image-preview');
                const imageInput = slideEditor.find('.image-url-input');

                // Confirmer la suppression
                if (!confirm('Êtes-vous sûr de vouloir supprimer cette image ?')) {
                    return;
                }

                // Supprimer l'image
                imagePreview.removeClass('has-image');
                imagePreview.find('img').remove();
                imageInput.val('');

                // Mettre à jour le bouton
                updateRemoveButton(slideEditor);

                console.log('🗑️ Image supprimée');
            });
        }

        /**
         * Mettre à jour le bouton de suppression
         */
        function updateRemoveButton(slideEditor) {
            const imagePreview = slideEditor.find('.image-preview');
            const removeButton = slideEditor.find('.remove-image-button');
            const uploadButton = slideEditor.find('.upload-image-button');

            if (imagePreview.hasClass('has-image')) {
                if (removeButton.length === 0) {
                    uploadButton.after(
                        '<button type="button" class="button button-link-delete remove-image-button">' +
                        '<span class="dashicons dashicons-no"></span> Supprimer' +
                        '</button>'
                    );
                }
                uploadButton.html('<span class="dashicons dashicons-upload"></span> Changer l\'image');
            } else {
                removeButton.remove();
                uploadButton.html('<span class="dashicons dashicons-upload"></span> Choisir une image');
            }
        }

        /**
         * Toggle actif/inactif
         */
        function initSlideToggle() {
            $('.slide-active-toggle').on('change', function() {
                const slideEditor = $(this).closest('.slide-editor');
                const toggleLabel = $(this).closest('.slide-toggle').find('.toggle-label');
                const isActive = $(this).is(':checked');

                if (isActive) {
                    slideEditor.removeClass('slide-inactive');
                    toggleLabel.text('Activé');
                } else {
                    slideEditor.addClass('slide-inactive');
                    toggleLabel.text('Désactivé');
                }

                console.log('🔄 Slide ' + (isActive ? 'activé' : 'désactivé'));
            });
        }

        /**
         * Drag & Drop pour réorganiser les slides
         */
        function initSortable() {
            $('#slides-container').sortable({
                handle: '.slide-drag-handle',
                placeholder: 'slide-placeholder',
                cursor: 'move',
                opacity: 0.8,
                tolerance: 'pointer',
                start: function(e, ui) {
                    ui.placeholder.height(ui.item.height());
                    console.log('🎯 Début du drag');
                },
                stop: function(e, ui) {
                    console.log('✅ Fin du drag');
                    updateSlideOrder();
                }
            });

            // Style du placeholder
            $('<style>')
                .prop('type', 'text/css')
                .html('.slide-placeholder { background: #f0f0f0; border: 2px dashed #F08B18; border-radius: 8px; margin-bottom: 20px; }')
                .appendTo('head');
        }

        /**
         * Mettre à jour l'ordre des slides
         */
        function updateSlideOrder() {
            $('#slides-container .slide-editor').each(function(index) {
                $(this).find('.slide-order-input').val(index);
                $(this).find('.slide-title-header').text('Slide ' + (index + 1));
                console.log('📊 Slide ' + (index + 1) + ' - Ordre mis à jour');
            });
        }

        /**
         * Validation du formulaire
         */
        function initFormValidation() {
            $('.almetal-slideshow-form').on('submit', function(e) {
                let isValid = true;
                const errors = [];

                // Vérifier que chaque slide actif a une image
                $('.slide-editor').each(function(index) {
                    const slideEditor = $(this);
                    const isActive = slideEditor.find('.slide-active-toggle').is(':checked');
                    const imageUrl = slideEditor.find('.image-url-input').val();
                    const title = slideEditor.find('input[name*="[title]"]').val();

                    if (isActive) {
                        if (!imageUrl) {
                            isValid = false;
                            errors.push('Slide ' + (index + 1) + ' : Image manquante');
                            slideEditor.find('.image-preview').css('border-color', '#dc3232');
                        }

                        if (!title) {
                            isValid = false;
                            errors.push('Slide ' + (index + 1) + ' : Titre manquant');
                            slideEditor.find('input[name*="[title]"]').css('border-color', '#dc3232');
                        }
                    }
                });

                if (!isValid) {
                    e.preventDefault();
                    alert('⚠️ Erreurs de validation :\n\n' + errors.join('\n'));
                    return false;
                }

                // Animation de sauvegarde
                $('.slide-editor').addClass('is-saving');
                console.log('💾 Sauvegarde en cours...');
            });

            // Retirer les bordures rouges lors de la modification
            $('input, textarea').on('input', function() {
                $(this).css('border-color', '');
            });
        }

        /**
         * Réinitialiser aux valeurs par défaut
         */
        function initResetButton() {
            $('#reset-slides').on('click', function(e) {
                e.preventDefault();

                if (!confirm('⚠️ Êtes-vous sûr de vouloir réinitialiser le slideshow aux valeurs par défaut ?\n\nToutes vos modifications seront perdues.')) {
                    return;
                }

                // Afficher un loader
                $(this).prop('disabled', true).html('<span class="dashicons dashicons-update"></span> Réinitialisation...');

                // Recharger la page avec un paramètre pour déclencher la réinitialisation
                window.location.href = window.location.href.split('?')[0] + '?page=almetal-slideshow&reset=true';
            });
        }

        /**
         * Compteur de caractères pour les champs
         */
        function initCharacterCounter() {
            $('input[type="text"], textarea').each(function() {
                const maxLength = $(this).attr('maxlength');
                if (maxLength) {
                    const counter = $('<span class="character-counter"></span>');
                    $(this).after(counter);
                    updateCounter($(this), counter, maxLength);

                    $(this).on('input', function() {
                        updateCounter($(this), counter, maxLength);
                    });
                }
            });
        }

        function updateCounter(input, counter, maxLength) {
            const currentLength = input.val().length;
            counter.text(currentLength + ' / ' + maxLength);

            if (currentLength > maxLength * 0.9) {
                counter.css('color', '#dc3232');
            } else {
                counter.css('color', '#666');
            }
        }

        /**
         * Prévisualisation en temps réel (optionnel)
         */
        function initLivePreview() {
            // TODO: Ajouter une prévisualisation en temps réel si nécessaire
            console.log('ℹ️ Prévisualisation en temps réel : À implémenter');
        }

        /**
         * Gestion des messages de succès
         */
        function initSuccessMessage() {
            // Auto-dismiss des notices après 5 secondes
            setTimeout(function() {
                $('.notice.is-dismissible').fadeOut();
            }, 5000);
        }

        /**
         * Raccourcis clavier
         */
        function initKeyboardShortcuts() {
            $(document).on('keydown', function(e) {
                // Ctrl/Cmd + S pour sauvegarder
                if ((e.ctrlKey || e.metaKey) && e.key === 's') {
                    e.preventDefault();
                    $('.almetal-slideshow-form').submit();
                    console.log('⌨️ Raccourci clavier : Sauvegarde');
                }
            });
        }

        /**
         * Initialisation
         */
        function init() {
            initMediaUploader();
            initImageRemoval();
            initSlideToggle();
            initSortable();
            initFormValidation();
            initResetButton();
            initCharacterCounter();
            initLivePreview();
            initSuccessMessage();
            initKeyboardShortcuts();

            console.log('✅ Admin Slideshow - Prêt');
        }

        // Démarrer
        init();
    });

})(jQuery);
