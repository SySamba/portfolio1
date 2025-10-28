<?php
// Version de secours devis utilisant l'email qui fonctionne
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
        
        // Email vers Gmail
        $to_gmail = "sambasy837@gmail.com";
        
        $email_subject = "🎯 Demande de Devis - " . $fullName;
        $email_body = "
NOUVELLE DEMANDE DE DEVIS
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

=== DESCRIPTION DU PROJET ===
$projectDescription

=== ACTIONS RECOMMANDÉES ===
1. Répondre dans les 24h (PRIORITÉ HAUTE)
2. Programmer un appel de découverte
3. Préparer une proposition détaillée
4. Envoyer des exemples de projets similaires

---
Demande reçue le " . date('d/m/Y à H:i:s') . "
Portfolio Samba SY
📧 sambasy837@gmail.com
📱 +221 77 378 48 14
🌍 Dakar, Sénégal

NOTE: Email envoyé via solution de secours en attendant l'activation complète de sambasy@teranganumerique.com
        ";
        
        // Headers avec l'email qui fonctionne
        $headers = "From: Portfolio Samba SY <teranganumerique@teranganumerique.com>\r\n";
        $headers .= "Reply-To: $email\r\n";
        $headers .= "Content-Type: text/plain; charset=UTF-8\r\n";
        $headers .= "X-Priority: 1\r\n"; // Priorité haute pour les devis
        $headers .= "X-Mailer: PHP/" . phpversion() . "\r\n";
        
        // Envoyer à Gmail
        $mail_result = mail($to_gmail, $email_subject, $email_body, $headers);
        
        // Sauvegarder dans un fichier (backup)
        $log_file = 'messages_devis.txt';
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
        $log_entry .= "Status Email : " . ($mail_result ? 'Envoyé (backup)' : 'Échec') . "\n";
        $log_entry .= "================================\n";
        
        file_put_contents($log_file, $log_entry, FILE_APPEND | LOCK_EX);
        
        // Redirection vers la page de succès
        echo "<!DOCTYPE html>
<html>
<head>
    <meta charset='UTF-8'>
    <title>Redirection...</title>
</head>
<body>
    <script>
        window.location.href = 'devis_success.php?name=" . urlencode($fullName) . "&project=" . urlencode($projectType) . "';
    </script>
    <p>Devis envoyé, redirection... <a href='devis_success.php?name=" . urlencode($fullName) . "&project=" . urlencode($projectType) . "'>Cliquez ici</a></p>
</body>
</html>";
        exit();
    }
}

// Redirection par défaut
echo "<!DOCTYPE html>
<html>
<head>
    <meta charset='UTF-8'>
    <title>Redirection...</title>
</head>
<body>
    <script>
        window.location.href = 'devis.html';
    </script>
    <p>Redirection... <a href='devis.html'>Cliquez ici</a></p>
</body>
</html>";
?>
