<?php
/**
 * Plugin Name: Devis Automatique
 * Description: Plugin WordPress pour générer automatiquement des devis en PDF et les envoyer par e-mail.
 * Version: 1.0
 * Author: Votre Nom
 */

// Inclure FPDF
require_once plugin_dir_path(__FILE__) . 'lib/fpdf.php';

// Ajouter un shortcode pour afficher le formulaire
add_shortcode('devis_form', 'afficher_formulaire_devis');

function afficher_formulaire_devis() {
    ob_start();
    include plugin_dir_path(__FILE__) . 'template-form.php';
    return ob_get_clean();
}

// Traiter le formulaire
add_action('init', 'devis_form_handler');

function devis_form_handler() {
    if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['devis_submit'])) {
        $nom = sanitize_text_field($_POST['nom']);
        $email = sanitize_email($_POST['email']);
        $service = sanitize_text_field($_POST['service']);
        $details = sanitize_textarea_field($_POST['details']);
        $prix = floatval($_POST['prix']);

        // Générer le devis PDF
        require_once plugin_dir_path(__FILE__) . 'generate-pdf.php';

        // Envoyer un e-mail avec le devis en pièce jointe
        $upload_dir = wp_upload_dir();
        $file_path = $upload_dir['basedir'] . "/devis-$nom.pdf";

        wp_mail(
            $email,
            'Votre devis',
            'Merci de trouver en pièce jointe votre devis.',
            [
                'Content-Type: text/html; charset=UTF-8',
                'From: votreentreprise@example.com'
            ],
            [$file_path]
        );

        // Rediriger vers une page de confirmation
        wp_redirect(home_url('/merci-pour-votre-devis/'));
        exit;
    }
}
