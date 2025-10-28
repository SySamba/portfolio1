<?php
// Version ultra-simple - pas d'espaces avant <?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    // Récupérer les données
    $name = htmlspecialchars($_POST['name'] ?? 'Visiteur');
    $email = htmlspecialchars($_POST['email'] ?? '');
    $subject = htmlspecialchars($_POST['subject'] ?? '');
    $message = htmlspecialchars($_POST['message'] ?? '');
    
    // Validation minimale
    if (!empty($name) && !empty($email) && !empty($subject) && !empty($message)) {
        
        // Préparer l'email simple
        $to = "sambasy837@gmail.com";
        $email_subject = "Contact Portfolio - " . $name;
        $email_body = "
Nouveau message de contact

Nom: $name
Email: $email
Sujet: $subject

Message:
$message

---
Envoyé le " . date('d/m/Y à H:i:s') . "
        ";
        
        // Headers simples
        $headers = "From: Portfolio <noreply@sambasy.com>\r\n";
        $headers .= "Reply-To: $email\r\n";
        
        // Envoyer l'email
        $mail_sent = mail($to, $email_subject, $email_body, $headers);
        
        // Redirection forcée
        header("Location: contact_success_simple.php?name=" . urlencode($name));
        exit();
        
    } else {
        $error = "Veuillez remplir tous les champs obligatoires.";
    }
} else {
    header("Location: contact.html");
    exit();
}
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Erreur</title>
    <style>
        body { font-family: Arial, sans-serif; text-align: center; padding: 50px; }
        .error { color: red; background: #ffe6e6; padding: 20px; border-radius: 8px; }
    </style>
</head>
<body>
    <div class="error">
        <h2>Erreur</h2>
        <p><?php echo isset($error) ? $error : 'Erreur inconnue'; ?></p>
        <a href="contact.html">← Retour au formulaire</a>
    </div>
</body>
</html>
