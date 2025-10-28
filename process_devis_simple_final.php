<?php
/**
 * Formulaire de devis SANS erreurs - Version finale
 */

require_once 'smtp_simple.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    // Récupérer les données
    $fullName = htmlspecialchars(trim($_POST['fullName'] ?? ''));
    $email = htmlspecialchars(trim($_POST['email'] ?? ''));
    $phone = htmlspecialchars(trim($_POST['phone'] ?? ''));
    $company = htmlspecialchars(trim($_POST['company'] ?? ''));
    $projectType = htmlspecialchars(trim($_POST['projectType'] ?? ''));
    $budget = htmlspecialchars(trim($_POST['budget'] ?? ''));
    $projectDescription = htmlspecialchars(trim($_POST['projectDescription'] ?? ''));
    $timeline = htmlspecialchars(trim($_POST['timeline'] ?? ''));
    
    // Validation
    if (!empty($fullName) && !empty($email) && !empty($projectType) && !empty($projectDescription) && filter_var($email, FILTER_VALIDATE_EMAIL)) {
        
        // Mapper les types de projets
        $project_map = [
            'web' => '🌐 Site Web / E-commerce',
            'data' => '📊 Analyse de Données / BI',
            'ai' => '🤖 Intelligence Artificielle',
            'cloud' => '☁️ Cloud / DevOps',
            'mobile' => '📱 Application Mobile',
            'other' => '🔧 Autre'
        ];
        
        $email_subject = "🎯 DEVIS URGENT - " . $fullName;
        $email_body = "
NOUVELLE DEMANDE DE DEVIS - PRIORITÉ HAUTE
Portfolio Samba SY - Expert Data Science & IA

=== INFORMATIONS CLIENT ===
Nom complet : $fullName
Email : $email
Téléphone : " . ($phone ?: 'Non renseigné') . "
Entreprise : " . ($company ?: 'Particulier') . "

=== DÉTAILS DU PROJET ===
Type de projet : " . ($project_map[$projectType] ?? $projectType) . "
Budget estimé : $budget
Délai souhaité : $timeline

=== DESCRIPTION COMPLÈTE DU PROJET ===
$projectDescription

=== ACTIONS IMMÉDIATES RECOMMANDÉES ===
🔥 PRIORITÉ HAUTE - Répondre dans les 4 heures
📞 Programmer un appel de découverte dans les 24h
💼 Préparer une proposition détaillée personnalisée
📊 Envoyer des exemples de projets similaires
💰 Calculer un devis précis selon les besoins

---
Demande reçue le " . date('d/m/Y à H:i:s') . "
Portfolio Samba SY
📧 sambasy837@gmail.com
📱 +221 77 378 48 14 (WhatsApp disponible)
🌍 Dakar, Sénégal

✅ Email optimisé anti-spam - Priorité haute
        ";
        
        // Envoyer avec priorité haute
        $mail_result = send_email_optimized("sambasy837@gmail.com", $email_subject, $email_body, $email, 'high');
        
        // Sauvegarder (backup)
        $log_file = 'messages_devis_final.txt';
        $log_entry = "\n=== DEVIS DEMANDÉ LE " . date('d/m/Y H:i:s') . " ===\n";
        $log_entry .= "Nom : $fullName\n";
        $log_entry .= "Email : $email\n";
        $log_entry .= "Téléphone : " . ($phone ?: 'Non renseigné') . "\n";
        $log_entry .= "Entreprise : " . ($company ?: 'Particulier') . "\n";
        $log_entry .= "Type : " . ($project_map[$projectType] ?? $projectType) . "\n";
        $log_entry .= "Budget : $budget\n";
        $log_entry .= "Délai : $timeline\n";
        $log_entry .= "Description : $projectDescription\n";
        $log_entry .= "IP : " . ($_SERVER['REMOTE_ADDR'] ?? 'inconnue') . "\n";
        $log_entry .= "Status : " . ($mail_result ? 'Envoyé (Priorité Haute)' : 'Échec') . "\n";
        $log_entry .= "================================\n";
        
        file_put_contents($log_file, $log_entry, FILE_APPEND | LOCK_EX);
        
        // Redirection
        header("Location: devis_success.php?name=" . urlencode($fullName) . "&project=" . urlencode($projectType));
        exit();
    }
}

// Redirection par défaut
header("Location: devis.html");
exit();
?>
