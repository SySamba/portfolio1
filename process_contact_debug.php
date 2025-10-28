<?php
// Activer l'affichage des erreurs pour le debug
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Log de debug
function debug_log($message) {
    $log_file = 'debug_contact.log';
    $timestamp = date('Y-m-d H:i:s');
    file_put_contents($log_file, "[$timestamp] $message\n", FILE_APPEND | LOCK_EX);
}

debug_log("=== DÉBUT DU TRAITEMENT ===");
debug_log("Méthode: " . $_SERVER["REQUEST_METHOD"]);
debug_log("POST data: " . print_r($_POST, true));

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
    debug_log("Formulaire soumis");
    
    // Récupérer et nettoyer les données
    $name = clean_input($_POST['name'] ?? '');
    $email = clean_input($_POST['email'] ?? '');
    $phone = clean_input($_POST['phone'] ?? '');
    $company = clean_input($_POST['company'] ?? '');
    $subject = clean_input($_POST['subject'] ?? '');
    $budget = clean_input($_POST['budget'] ?? '');
    $timeline = clean_input($_POST['timeline'] ?? '');
    $message = clean_input($_POST['message'] ?? '');
    
    debug_log("Données nettoyées - Nom: $name, Email: $email, Sujet: $subject");
    
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
    
    debug_log("Erreurs de validation: " . implode(", ", $errors));
    
    // Si pas d'erreurs, envoyer l'email
    if (empty($errors)) {
        debug_log("Validation réussie, préparation de l'email");
        
        // Mapper les sujets
        $subject_types = [
            'ia' => '🤖 Projet Intelligence Artificielle',
            'cloud' => '☁️ Solution Cloud & DevOps',
            'data' => '📊 Data Analytics & BI',
            'web' => '🌐 Développement Web',
            'consultation' => '💼 Consultation',
            'autre' => '🔧 Autre'
        ];
        
        $budget_ranges = [
            '< 500k' => 'Moins de 500 000 FCFA',
            '500k-1M' => '500 000 - 1 000 000 FCFA',
            '1M-2M' => '1 000 000 - 2 000 000 FCFA',
            '2M-5M' => '2 000 000 - 5 000 000 FCFA',
            '> 5M' => 'Plus de 5 000 000 FCFA'
        ];
        
        $timeline_options = [
            'urgent' => 'Urgent (< 1 mois)',
            'court' => 'Court terme (1-3 mois)',
            'moyen' => 'Moyen terme (3-6 mois)',
            'long' => 'Long terme (> 6 mois)'
        ];
        
        // Préparer le contenu de l'email
        $email_subject = "📧 Nouveau message de contact - " . $name;
        
        $email_body = "
        <html>
        <head>
            <title>Nouveau message de contact</title>
            <style>
                body { font-family: Arial, sans-serif; line-height: 1.6; color: #333; }
                .container { max-width: 700px; margin: 0 auto; padding: 20px; }
                .header { background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; padding: 25px; text-align: center; border-radius: 10px 10px 0 0; }
                .content { background: #f8fafc; padding: 30px; border-radius: 0 0 10px 10px; }
                .field { margin-bottom: 20px; }
                .label { font-weight: bold; color: #374151; font-size: 14px; text-transform: uppercase; letter-spacing: 0.5px; }
                .value { background: white; padding: 15px; border-left: 5px solid #667eea; margin-top: 8px; border-radius: 5px; box-shadow: 0 2px 4px rgba(0,0,0,0.1); }
                .priority { background: #fef3c7; border-left-color: #f59e0b; }
                .message-field { background: #eff6ff; border-left-color: #3b82f6; }
                .footer { text-align: center; padding: 20px; color: #6b7280; font-size: 13px; border-top: 1px solid #e5e7eb; margin-top: 20px; }
                .stats { display: flex; justify-content: space-around; margin: 20px 0; }
                .stat { text-align: center; }
                .stat-number { font-size: 24px; font-weight: bold; color: #667eea; }
                .stat-label { font-size: 12px; color: #6b7280; }
            </style>
        </head>
        <body>
            <div class='container'>
                <div class='header'>
                    <h2>📧 Nouveau Message de Contact</h2>
                    <p style='margin: 0; opacity: 0.9;'>Portfolio Samba SY - Expert Data Science & IA</p>
                </div>
                
                <div class='content'>
                    <div class='stats'>
                        <div class='stat'>
                            <div class='stat-number'>💬</div>
                            <div class='stat-label'>NOUVEAU MESSAGE</div>
                        </div>
                        <div class='stat'>
                            <div class='stat-number'>" . (isset($subject_types[$subject]) ? substr($subject_types[$subject], 0, 2) : '📋') . "</div>
                            <div class='stat-label'>SUJET</div>
                        </div>
                        <div class='stat'>
                            <div class='stat-number'>⚡</div>
                            <div class='stat-label'>CONTACT</div>
                        </div>
                    </div>
                    
                    <div class='field'>
                        <div class='label'>👤 Nom complet :</div>
                        <div class='value'>" . htmlspecialchars($name) . "</div>
                    </div>
                    
                    <div class='field'>
                        <div class='label'>📧 Email :</div>
                        <div class='value'><a href='mailto:" . htmlspecialchars($email) . "'>" . htmlspecialchars($email) . "</a></div>
                    </div>
                    
                    <div class='field'>
                        <div class='label'>📱 Téléphone :</div>
                        <div class='value'>" . (empty($phone) ? 'Non renseigné' : "<a href='tel:" . htmlspecialchars($phone) . "'>" . htmlspecialchars($phone) . "</a>") . "</div>
                    </div>
                    
                    <div class='field'>
                        <div class='label'>🏢 Entreprise :</div>
                        <div class='value'>" . (empty($company) ? 'Non renseignée' : htmlspecialchars($company)) . "</div>
                    </div>
                    
                    <div class='field'>
                        <div class='label'>📋 Sujet :</div>
                        <div class='value'>" . (isset($subject_types[$subject]) ? $subject_types[$subject] : htmlspecialchars($subject)) . "</div>
                    </div>
                    
                    <div class='field'>
                        <div class='label'>💰 Budget estimé :</div>
                        <div class='value'>" . (empty($budget) ? 'Non renseigné' : (isset($budget_ranges[$budget]) ? $budget_ranges[$budget] : htmlspecialchars($budget))) . "</div>
                    </div>
                    
                    <div class='field'>
                        <div class='label'>⏰ Délai souhaité :</div>
                        <div class='value'>" . (empty($timeline) ? 'Non renseigné' : (isset($timeline_options[$timeline]) ? $timeline_options[$timeline] : htmlspecialchars($timeline))) . "</div>
                    </div>
                    
                    <div class='field'>
                        <div class='label'>💬 Message :</div>
                        <div class='value message-field'>" . nl2br(htmlspecialchars($message)) . "</div>
                    </div>
                    
                    <div class='field priority'>
                        <div class='label'>⚡ Actions Recommandées :</div>
                        <div class='value'>
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
        </html>
        ";
        
        debug_log("Email préparé, longueur: " . strlen($email_body));
        
        // Headers pour l'email HTML
        $headers = "MIME-Version: 1.0" . "\r\n";
        $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
        $headers .= "From: " . $from_name . " <" . $from_email . ">" . "\r\n";
        $headers .= "Reply-To: " . $email . "\r\n";
        $headers .= "X-Mailer: PHP/" . phpversion();
        
        debug_log("Headers préparés");
        
        // Envoyer l'email
        $mail_result = mail($to_email, $email_subject, $email_body, $headers);
        debug_log("Résultat mail(): " . ($mail_result ? 'true' : 'false'));
        
        if ($mail_result) {
            debug_log("Email envoyé avec succès, redirection vers contact_success.php");
            // Redirection vers une page de succès
            header("Location: contact_success.php?name=" . urlencode($name));
            exit();
        } else {
            debug_log("Échec de l'envoi d'email");
            $error_message = "Erreur lors de l'envoi de l'email. Veuillez réessayer.";
        }
        
    } else {
        debug_log("Erreurs de validation trouvées");
        $error_message = "Erreurs de validation : " . implode(", ", $errors);
    }
    
} else {
    debug_log("Accès direct au fichier PHP, redirection vers contact.html");
    // Si accès direct au fichier PHP
    header("Location: contact.html");
    exit();
}

debug_log("=== FIN DU TRAITEMENT ===");
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
        .debug-info {
            background: #f8f9fa;
            padding: 15px;
            border-radius: 8px;
            margin: 20px 0;
            text-align: left;
            font-family: monospace;
            font-size: 12px;
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
        
        <?php if (file_exists('debug_contact.log')): ?>
        <div class="debug-info">
            <strong>Informations de debug :</strong><br>
            <?php 
            $log_content = file_get_contents('debug_contact.log');
            echo nl2br(htmlspecialchars(substr($log_content, -1000))); // Derniers 1000 caractères
            ?>
        </div>
        <?php endif; ?>
        
        <a href="contact.html" class="btn-back">← Retour au formulaire</a>
        <a href="debug_contact.php" class="btn-back" style="background: #f59e0b;">🔍 Diagnostic</a>
    </div>
</body>
</html>
