<?php
// Configuration
$to_email = "sambasy837@gmail.com";
$from_name = "Portfolio Samba SY";
$from_email = "noreply@sambasy.com";

// Fonction pour nettoyer les données
function clean_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

// Fonction pour valider l'email
function validate_email($email) {
    return filter_var($email, FILTER_VALIDATE_EMAIL);
}

// Vérifier si le formulaire a été soumis
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    // Récupérer et nettoyer les données
    $name = clean_input($_POST['name'] ?? '');
    $email = clean_input($_POST['email'] ?? '');
    $phone = clean_input($_POST['phone'] ?? '');
    $company = clean_input($_POST['company'] ?? '');
    $subject = clean_input($_POST['subject'] ?? '');
    $budget = clean_input($_POST['budget'] ?? '');
    $timeline = clean_input($_POST['timeline'] ?? '');
    $message = clean_input($_POST['message'] ?? '');
    
    // Validation des champs obligatoires
    $errors = [];
    
    if (empty($name)) {
        $errors[] = "Le nom est obligatoire";
    }
    
    if (empty($email)) {
        $errors[] = "L'email est obligatoire";
    } elseif (!validate_email($email)) {
        $errors[] = "L'email n'est pas valide";
    }
    
    if (empty($subject)) {
        $errors[] = "Le sujet est obligatoire";
    }
    
    if (empty($message)) {
        $errors[] = "Le message est obligatoire";
    }
    
    // Si pas d'erreurs, envoyer l'email
    if (empty($errors)) {
        
        // Préparer le contenu de l'email
        $email_subject = "Nouveau message de contact - " . $name;
        
        $email_body = "
        <html>
        <head>
            <title>Nouveau message de contact</title>
            <style>
                body { font-family: Arial, sans-serif; line-height: 1.6; color: #333; }
                .container { max-width: 600px; margin: 0 auto; padding: 20px; }
                .header { background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; padding: 20px; text-align: center; }
                .content { background: #f9f9f9; padding: 20px; }
                .field { margin-bottom: 15px; }
                .label { font-weight: bold; color: #555; }
                .value { background: white; padding: 10px; border-left: 4px solid #667eea; margin-top: 5px; }
                .footer { text-align: center; padding: 20px; color: #666; font-size: 12px; }
            </style>
        </head>
        <body>
            <div class='container'>
                <div class='header'>
                    <h2>📧 Nouveau Message de Contact</h2>
                    <p>Portfolio Samba SY</p>
                </div>
                
                <div class='content'>
                    <div class='field'>
                        <div class='label'>👤 Nom complet :</div>
                        <div class='value'>" . htmlspecialchars($name) . "</div>
                    </div>
                    
                    <div class='field'>
                        <div class='label'>📧 Email :</div>
                        <div class='value'>" . htmlspecialchars($email) . "</div>
                    </div>
                    
                    <div class='field'>
                        <div class='label'>📱 Téléphone :</div>
                        <div class='value'>" . (empty($phone) ? 'Non renseigné' : htmlspecialchars($phone)) . "</div>
                    </div>
                    
                    <div class='field'>
                        <div class='label'>🏢 Entreprise :</div>
                        <div class='value'>" . (empty($company) ? 'Non renseignée' : htmlspecialchars($company)) . "</div>
                    </div>
                    
                    <div class='field'>
                        <div class='label'>📋 Sujet :</div>
                        <div class='value'>" . htmlspecialchars($subject) . "</div>
                    </div>
                    
                    <div class='field'>
                        <div class='label'>💰 Budget estimé :</div>
                        <div class='value'>" . (empty($budget) ? 'Non renseigné' : htmlspecialchars($budget)) . "</div>
                    </div>
                    
                    <div class='field'>
                        <div class='label'>⏰ Délai souhaité :</div>
                        <div class='value'>" . (empty($timeline) ? 'Non renseigné' : htmlspecialchars($timeline)) . "</div>
                    </div>
                    
                    <div class='field'>
                        <div class='label'>💬 Message :</div>
                        <div class='value'>" . nl2br(htmlspecialchars($message)) . "</div>
                    </div>
                </div>
                
                <div class='footer'>
                    <p>Message reçu le " . date('d/m/Y à H:i:s') . "</p>
                    <p>Portfolio Samba SY - Expert Data Science & IA</p>
                </div>
            </div>
        </body>
        </html>
        ";
        
        // Headers pour l'email HTML
        $headers = "MIME-Version: 1.0" . "\r\n";
        $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
        $headers .= "From: " . $from_name . " <" . $from_email . ">" . "\r\n";
        $headers .= "Reply-To: " . $email . "\r\n";
        $headers .= "X-Mailer: PHP/" . phpversion();
        
        // Envoyer l'email
        if (mail($to_email, $email_subject, $email_body, $headers)) {
            // Redirection vers une page de succès
            header("Location: contact_success.php?name=" . urlencode($name));
            exit();
        } else {
            $error_message = "Erreur lors de l'envoi de l'email. Veuillez réessayer.";
        }
        
    } else {
        $error_message = "Erreurs de validation : " . implode(", ", $errors);
    }
    
} else {
    // Si accès direct au fichier PHP
    header("Location: contact.html");
    exit();
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Erreur - Contact</title>
    <link rel="stylesheet" href="css/style.css">
    <style>
        .error-container {
            max-width: 600px;
            margin: 100px auto;
            padding: 40px;
            text-align: center;
            background: white;
            border-radius: 10px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.1);
        }
        .error-icon {
            font-size: 4rem;
            color: #ef4444;
            margin-bottom: 20px;
        }
        .error-message {
            color: #ef4444;
            margin-bottom: 30px;
            padding: 20px;
            background: #fef2f2;
            border-radius: 8px;
            border-left: 4px solid #ef4444;
        }
        .btn-back {
            display: inline-block;
            padding: 12px 24px;
            background: #667eea;
            color: white;
            text-decoration: none;
            border-radius: 6px;
            transition: background 0.3s;
        }
        .btn-back:hover {
            background: #5a67d8;
        }
    </style>
</head>
<body>
    <div class="error-container">
        <div class="error-icon">⚠️</div>
        <h2>Erreur lors de l'envoi</h2>
        <div class="error-message">
            <?php echo isset($error_message) ? $error_message : 'Une erreur inattendue s\'est produite.'; ?>
        </div>
        <a href="contact.html" class="btn-back">← Retour au formulaire</a>
    </div>
</body>
</html>
