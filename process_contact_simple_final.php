<?php
/**
 * Formulaire de contact SANS erreurs - Version finale
 */

require_once 'smtp_simple.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    // Récupérer les données
    $name = htmlspecialchars(trim($_POST['name'] ?? ''));
    $email = htmlspecialchars(trim($_POST['email'] ?? ''));
    $phone = htmlspecialchars(trim($_POST['phone'] ?? ''));
    $company = htmlspecialchars(trim($_POST['company'] ?? ''));
    $subject = htmlspecialchars(trim($_POST['subject'] ?? ''));
    $budget = htmlspecialchars(trim($_POST['budget'] ?? ''));
    $timeline = htmlspecialchars(trim($_POST['timeline'] ?? ''));
    $message = htmlspecialchars(trim($_POST['message'] ?? ''));
    
    // Validation
    if (!empty($name) && !empty($email) && !empty($subject) && !empty($message) && filter_var($email, FILTER_VALIDATE_EMAIL)) {
        
        // Mapper les sujets
        $subject_map = [
            'ia' => '🤖 Projet Intelligence Artificielle',
            'cloud' => '☁️ Solution Cloud & DevOps',
            'data' => '📊 Data Analytics & BI',
            'web' => '🌐 Développement Web',
            'consultation' => '💼 Consultation',
            'autre' => '🔧 Autre'
        ];
        
        $email_subject = "📧 Contact Portfolio - " . $name;
        $email_body = "
NOUVEAU MESSAGE DE CONTACT
Portfolio Samba SY - Expert Data Science & IA

=== INFORMATIONS CLIENT ===
Nom complet : $name
Email : $email
Téléphone : " . ($phone ?: 'Non renseigné') . "
Entreprise : " . ($company ?: 'Non renseignée') . "

=== DÉTAILS DU PROJET ===
Sujet : " . ($subject_map[$subject] ?? $subject) . "
Budget estimé : " . ($budget ?: 'Non renseigné') . "
Délai souhaité : " . ($timeline ?: 'Non renseigné') . "

=== MESSAGE ===
$message

=== ACTIONS RECOMMANDÉES ===
1. Répondre dans les 24h
2. Analyser les besoins du client
3. Proposer une solution adaptée
4. Programmer un appel si nécessaire

---
Message reçu le " . date('d/m/Y à H:i:s') . "
Portfolio Samba SY
📧 sambasy837@gmail.com
📱 +221 77 378 48 14
🌍 Dakar, Sénégal

✅ Email optimisé anti-spam
        ";
        
        // Envoyer l'email
        $mail_result = send_email_optimized("sambasy837@gmail.com", $email_subject, $email_body, $email);
        
        // Sauvegarder (backup)
        $log_file = 'messages_contact_final.txt';
        $log_entry = "\n=== MESSAGE REÇU LE " . date('d/m/Y H:i:s') . " ===\n";
        $log_entry .= "Nom : $name\n";
        $log_entry .= "Email : $email\n";
        $log_entry .= "Téléphone : " . ($phone ?: 'Non renseigné') . "\n";
        $log_entry .= "Entreprise : " . ($company ?: 'Non renseignée') . "\n";
        $log_entry .= "Sujet : " . ($subject_map[$subject] ?? $subject) . "\n";
        $log_entry .= "Budget : " . ($budget ?: 'Non renseigné') . "\n";
        $log_entry .= "Délai : " . ($timeline ?: 'Non renseigné') . "\n";
        $log_entry .= "Message : $message\n";
        $log_entry .= "IP : " . ($_SERVER['REMOTE_ADDR'] ?? 'inconnue') . "\n";
        $log_entry .= "Status : " . ($mail_result ? 'Envoyé' : 'Échec') . "\n";
        $log_entry .= "================================\n";
        
        file_put_contents($log_file, $log_entry, FILE_APPEND | LOCK_EX);
        
        // Redirection
        header("Location: contact_success_simple.php?name=" . urlencode($name));
        exit();
    }
}

// Redirection par défaut
header("Location: contact.html");
exit();
?>
