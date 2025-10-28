<?php
// Version corrigée et simplifiée du traitement de contact
// Pas d'espaces avant <?php pour éviter les erreurs de headers

// Configuration
$to_email = "sambasy837@gmail.com";
$from_name = "Portfolio Samba SY";
$from_email = "noreply@sambasy.com";

// Fonction pour nettoyer les données
function clean_input($data) {
    return htmlspecialchars(trim(stripslashes($data)));
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
    
    // Validation simple
    $errors = [];
    if (empty($name)) $errors[] = "Le nom est obligatoire";
    if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) $errors[] = "Email invalide";
    if (empty($subject)) $errors[] = "Le sujet est obligatoire";
    if (empty($message)) $errors[] = "Le message est obligatoire";
    
    // Si pas d'erreurs, envoyer l'email
    if (empty($errors)) {
        
        // Mapper les sujets
        $subject_map = [
            'ia' => '🤖 Projet Intelligence Artificielle',
            'cloud' => '☁️ Solution Cloud & DevOps',
            'data' => '📊 Data Analytics & BI',
            'web' => '🌐 Développement Web',
            'consultation' => '💼 Consultation',
            'autre' => '🔧 Autre'
        ];
        
        $budget_map = [
            '< 500k' => 'Moins de 500 000 FCFA',
            '500k-1M' => '500 000 - 1 000 000 FCFA',
            '1M-2M' => '1 000 000 - 2 000 000 FCFA',
            '2M-5M' => '2 000 000 - 5 000 000 FCFA',
            '> 5M' => 'Plus de 5 000 000 FCFA'
        ];
        
        $timeline_map = [
            'urgent' => 'Urgent (< 1 mois)',
            'court' => 'Court terme (1-3 mois)',
            'moyen' => 'Moyen terme (3-6 mois)',
            'long' => 'Long terme (> 6 mois)'
        ];
        
        // Préparer l'email
        $email_subject = "📧 Nouveau message de contact - " . $name;
        
        $email_body = "
<!DOCTYPE html>
<html>
<head>
    <meta charset='UTF-8'>
    <title>Nouveau message de contact</title>
    <style>
        body { font-family: Arial, sans-serif; line-height: 1.6; color: #333; margin: 0; padding: 20px; }
        .container { max-width: 600px; margin: 0 auto; background: white; border-radius: 10px; overflow: hidden; box-shadow: 0 4px 15px rgba(0,0,0,0.1); }
        .header { background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; padding: 30px 20px; text-align: center; }
        .content { padding: 30px 20px; background: #f8fafc; }
        .field { margin-bottom: 20px; }
        .label { font-weight: bold; color: #374151; font-size: 14px; text-transform: uppercase; margin-bottom: 8px; display: block; }
        .value { background: white; padding: 15px; border-left: 4px solid #667eea; border-radius: 5px; box-shadow: 0 2px 4px rgba(0,0,0,0.05); }
        .message-field { background: #eff6ff; border-left-color: #3b82f6; }
        .footer { text-align: center; padding: 20px; color: #6b7280; font-size: 13px; border-top: 1px solid #e5e7eb; }
        .highlight { background: #fef3c7; border-left-color: #f59e0b; }
    </style>
</head>
<body>
    <div class='container'>
        <div class='header'>
            <h2 style='margin: 0; font-size: 24px;'>📧 Nouveau Message de Contact</h2>
            <p style='margin: 10px 0 0 0; opacity: 0.9;'>Portfolio Samba SY - Expert Data Science & IA</p>
        </div>
        
        <div class='content'>
            <div class='field'>
                <div class='label'>👤 Nom complet</div>
                <div class='value'>" . $name . "</div>
            </div>
            
            <div class='field'>
                <div class='label'>📧 Email</div>
                <div class='value'><a href='mailto:" . $email . "' style='color: #667eea; text-decoration: none;'>" . $email . "</a></div>
            </div>
            
            <div class='field'>
                <div class='label'>📱 Téléphone</div>
                <div class='value'>" . ($phone ? "<a href='tel:" . $phone . "' style='color: #667eea; text-decoration: none;'>" . $phone . "</a>" : "Non renseigné") . "</div>
            </div>
            
            <div class='field'>
                <div class='label'>🏢 Entreprise</div>
                <div class='value'>" . ($company ?: "Non renseignée") . "</div>
            </div>
            
            <div class='field'>
                <div class='label'>📋 Sujet</div>
                <div class='value'>" . ($subject_map[$subject] ?? $subject) . "</div>
            </div>
            
            <div class='field'>
                <div class='label'>💰 Budget estimé</div>
                <div class='value'>" . ($budget ? ($budget_map[$budget] ?? $budget) : "Non renseigné") . "</div>
            </div>
            
            <div class='field'>
                <div class='label'>⏰ Délai souhaité</div>
                <div class='value'>" . ($timeline ? ($timeline_map[$timeline] ?? $timeline) : "Non renseigné") . "</div>
            </div>
            
            <div class='field'>
                <div class='label'>💬 Message</div>
                <div class='value message-field'>" . nl2br($message) . "</div>
            </div>
            
            <div class='field'>
                <div class='label'>⚡ Actions recommandées</div>
                <div class='value highlight'>
                    <strong>1.</strong> Répondre dans les 24h<br>
                    <strong>2.</strong> Analyser les besoins du client<br>
                    <strong>3.</strong> Proposer une solution adaptée<br>
                    <strong>4.</strong> Programmer un appel si nécessaire
                </div>
            </div>
        </div>
        
        <div class='footer'>
            <p><strong>Message reçu le " . date('d/m/Y à H:i:s') . "</strong></p>
            <p>Portfolio Samba SY - Expert Data Science, IA & Cloud Computing</p>
            <p>📧 sambasy837@gmail.com | 📱 +221 77 378 48 14 | 🌍 Dakar, Sénégal</p>
        </div>
    </div>
</body>
</html>";
        
        // Headers
        $headers = "MIME-Version: 1.0\r\n";
        $headers .= "Content-type: text/html; charset=UTF-8\r\n";
        $headers .= "From: " . $from_name . " <" . $from_email . ">\r\n";
        $headers .= "Reply-To: " . $email . "\r\n";
        $headers .= "X-Mailer: PHP/" . phpversion() . "\r\n";
        
        // Envoyer l'email
        $mail_sent = mail($to_email, $email_subject, $email_body, $headers);
        
        if ($mail_sent) {
            // Redirection vers la page de succès
            header("Location: contact_success_simple.php?name=" . urlencode($name));
            exit();
        } else {
            $error_message = "Erreur lors de l'envoi de l'email.";
        }
        
    } else {
        $error_message = "Erreurs : " . implode(", ", $errors);
    }
    
} else {
    // Redirection si accès direct
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
    <style>
        body {
            font-family: Arial, sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            margin: 0;
            padding: 20px;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .error-container {
            background: white;
            border-radius: 15px;
            padding: 40px;
            text-align: center;
            max-width: 500px;
            width: 100%;
            box-shadow: 0 20px 40px rgba(0,0,0,0.1);
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
