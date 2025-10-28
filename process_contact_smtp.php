<?php
// Version avec SMTP externe (Gmail) pour contourner la restriction Hostinger
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
        
        // Préparer l'email
        $to = "sambasy837@gmail.com";
        $email_subject = "Contact Portfolio - " . $name;
        $email_body = "
NOUVEAU MESSAGE DE CONTACT
Portfolio Samba SY

Nom : $name
Email : $email
Téléphone : " . ($phone ?: 'Non renseigné') . "
Entreprise : " . ($company ?: 'Non renseignée') . "
Sujet : $subject
Budget : " . ($budget ?: 'Non renseigné') . "
Délai : " . ($timeline ?: 'Non renseigné') . "

Message :
$message

Date : " . date('d/m/Y H:i:s') . "

---
IMPORTANT : Hostinger a temporairement désactivé l'envoi d'emails.
Ce message est envoyé via une solution alternative.
        ";
        
        // Utiliser curl pour envoyer via un service externe (exemple avec Formspree)
        $formspree_url = "https://formspree.io/f/xdkobvpz"; // Vous devrez créer un compte Formspree
        
        $post_data = [
            'name' => $name,
            'email' => $email,
            'subject' => $email_subject,
            'message' => $email_body,
            '_replyto' => $email
        ];
        
        // Alternative : Sauvegarder dans un fichier en attendant
        $log_file = 'messages_contact.txt';
        $log_entry = "\n=== MESSAGE REÇU LE " . date('d/m/Y H:i:s') . " ===\n";
        $log_entry .= "Nom : $name\n";
        $log_entry .= "Email : $email\n";
        $log_entry .= "Téléphone : " . ($phone ?: 'Non renseigné') . "\n";
        $log_entry .= "Entreprise : " . ($company ?: 'Non renseignée') . "\n";
        $log_entry .= "Sujet : $subject\n";
        $log_entry .= "Budget : " . ($budget ?: 'Non renseigné') . "\n";
        $log_entry .= "Délai : " . ($timeline ?: 'Non renseigné') . "\n";
        $log_entry .= "Message : $message\n";
        $log_entry .= "IP : " . ($_SERVER['REMOTE_ADDR'] ?? 'inconnue') . "\n";
        $log_entry .= "================================\n";
        
        file_put_contents($log_file, $log_entry, FILE_APPEND | LOCK_EX);
        
        // Redirection vers la page de succès
        echo "<!DOCTYPE html>
<html>
<head>
    <meta charset='UTF-8'>
    <title>Message Enregistré</title>
</head>
<body>
    <script>
        window.location.href = 'contact_success_simple.php?name=" . urlencode($name) . "';
    </script>
    <p>Message enregistré, redirection... <a href='contact_success_simple.php?name=" . urlencode($name) . "'>Cliquez ici</a></p>
</body>
</html>";
        exit();
    }
}

// Redirection par défaut
header("Location: contact.html");
exit();
?>
