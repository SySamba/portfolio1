<?php
// Configuration
$to_email = "sambasy837@gmail.com";
$from_name = "Portfolio Samba SY - Devis";
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

// Fonction pour valider le téléphone
function validate_phone($phone) {
    // Accepter les formats internationaux et locaux
    return preg_match('/^[\+]?[0-9\s\-\(\)]{8,15}$/', $phone);
}

// Vérifier si le formulaire a été soumis
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    // Protection anti-spam (honeypot)
    if (!empty($_POST['companyWebsite'])) {
        // Si le champ honeypot est rempli, c'est probablement un spam
        header("Location: devis.html");
        exit();
    }
    
    // Récupérer et nettoyer les données
    $fullName = clean_input($_POST['fullName'] ?? '');
    $email = clean_input($_POST['email'] ?? '');
    $phone = clean_input($_POST['phone'] ?? '');
    $company = clean_input($_POST['company'] ?? '');
    $projectType = clean_input($_POST['projectType'] ?? '');
    $budget = clean_input($_POST['budget'] ?? '');
    $projectDescription = clean_input($_POST['projectDescription'] ?? '');
    $timeline = clean_input($_POST['timeline'] ?? '');
    
    // Validation des champs obligatoires
    $errors = [];
    
    if (empty($fullName)) {
        $errors[] = "Le nom complet est obligatoire";
    }
    
    if (empty($email)) {
        $errors[] = "L'email est obligatoire";
    } elseif (!validate_email($email)) {
        $errors[] = "L'email n'est pas valide";
    }
    
    if (empty($phone)) {
        $errors[] = "Le téléphone est obligatoire";
    } elseif (!validate_phone($phone)) {
        $errors[] = "Le numéro de téléphone n'est pas valide";
    }
    
    if (empty($projectType)) {
        $errors[] = "Le type de projet est obligatoire";
    }
    
    if (empty($projectDescription)) {
        $errors[] = "La description du projet est obligatoire";
    }
    
    // Si pas d'erreurs, envoyer l'email
    if (empty($errors)) {
        
        // Mapper les types de projets
        $project_types = [
            'web' => '🌐 Site Web / E-commerce',
            'data' => '📊 Analyse de Données / BI',
            'ai' => '🤖 Intelligence Artificielle',
            'cloud' => '☁️ Cloud / DevOps',
            'mobile' => '📱 Application Mobile',
            'other' => '🔧 Autre'
        ];
        
        $budget_ranges = [
            '< 500k' => 'Moins de 500 000 FCFA',
            '500k-1M' => '500 000 - 1 000 000 FCFA',
            '1M-2M' => '1 000 000 - 2 000 000 FCFA',
            '2M+' => 'Plus de 2 000 000 FCFA'
        ];
        
        $timeline_options = [
            'urgent' => 'Urgent (< 1 mois)',
            'court' => 'Court terme (1-3 mois)',
            'moyen' => 'Moyen terme (3-6 mois)',
            'flexible' => 'Flexible'
        ];
        
        // Préparer le contenu de l'email
        $email_subject = "🎯 Nouvelle demande de devis - " . $fullName;
        
        $email_body = "
        <html>
        <head>
            <title>Nouvelle demande de devis</title>
            <style>
                body { font-family: Arial, sans-serif; line-height: 1.6; color: #333; }
                .container { max-width: 700px; margin: 0 auto; padding: 20px; }
                .header { background: linear-gradient(135deg, #4f46e5 0%, #06b6d4 100%); color: white; padding: 25px; text-align: center; border-radius: 10px 10px 0 0; }
                .content { background: #f8fafc; padding: 30px; border-radius: 0 0 10px 10px; }
                .field { margin-bottom: 20px; }
                .label { font-weight: bold; color: #374151; font-size: 14px; text-transform: uppercase; letter-spacing: 0.5px; }
                .value { background: white; padding: 15px; border-left: 5px solid #4f46e5; margin-top: 8px; border-radius: 5px; box-shadow: 0 2px 4px rgba(0,0,0,0.1); }
                .priority { background: #fef3c7; border-left-color: #f59e0b; }
                .description { background: #eff6ff; border-left-color: #3b82f6; }
                .footer { text-align: center; padding: 20px; color: #6b7280; font-size: 13px; border-top: 1px solid #e5e7eb; margin-top: 20px; }
                .stats { display: flex; justify-content: space-around; margin: 20px 0; }
                .stat { text-align: center; }
                .stat-number { font-size: 24px; font-weight: bold; color: #4f46e5; }
                .stat-label { font-size: 12px; color: #6b7280; }
            </style>
        </head>
        <body>
            <div class='container'>
                <div class='header'>
                    <h2>🎯 Nouvelle Demande de Devis</h2>
                    <p style='margin: 0; opacity: 0.9;'>Portfolio Samba SY - Expert Data Science & IA</p>
                </div>
                
                <div class='content'>
                    <div class='stats'>
                        <div class='stat'>
                            <div class='stat-number'>💼</div>
                            <div class='stat-label'>NOUVEAU CLIENT</div>
                        </div>
                        <div class='stat'>
                            <div class='stat-number'>" . (isset($project_types[$projectType]) ? substr($project_types[$projectType], 0, 2) : '🔧') . "</div>
                            <div class='stat-label'>PROJET</div>
                        </div>
                        <div class='stat'>
                            <div class='stat-number'>⚡</div>
                            <div class='stat-label'>PRIORITÉ</div>
                        </div>
                    </div>
                    
                    <div class='field'>
                        <div class='label'>👤 Informations Client</div>
                        <div class='value'>
                            <strong>Nom :</strong> " . htmlspecialchars($fullName) . "<br>
                            <strong>Email :</strong> <a href='mailto:" . htmlspecialchars($email) . "'>" . htmlspecialchars($email) . "</a><br>
                            <strong>Téléphone :</strong> <a href='tel:" . htmlspecialchars($phone) . "'>" . htmlspecialchars($phone) . "</a><br>
                            <strong>Entreprise :</strong> " . (empty($company) ? 'Particulier' : htmlspecialchars($company)) . "
                        </div>
                    </div>
                    
                    <div class='field'>
                        <div class='label'>🎯 Détails du Projet</div>
                        <div class='value'>
                            <strong>Type :</strong> " . (isset($project_types[$projectType]) ? $project_types[$projectType] : htmlspecialchars($projectType)) . "<br>
                            <strong>Budget estimé :</strong> " . (empty($budget) ? 'Non renseigné' : (isset($budget_ranges[$budget]) ? $budget_ranges[$budget] : htmlspecialchars($budget))) . "<br>
                            <strong>Délai souhaité :</strong> " . (empty($timeline) ? 'Flexible' : (isset($timeline_options[$timeline]) ? $timeline_options[$timeline] : htmlspecialchars($timeline))) . "
                        </div>
                    </div>
                    
                    <div class='field'>
                        <div class='label'>📝 Description du Projet</div>
                        <div class='value description'>
                            " . nl2br(htmlspecialchars($projectDescription)) . "
                        </div>
                    </div>
                    
                    <div class='field priority'>
                        <div class='label'>⚡ Actions Recommandées</div>
                        <div class='value'>
                            <strong>1.</strong> Répondre dans les 24h<br>
                            <strong>2.</strong> Programmer un appel de découverte<br>
                            <strong>3.</strong> Préparer une proposition détaillée<br>
                            <strong>4.</strong> Envoyer des exemples de projets similaires
                        </div>
                    </div>
                </div>
                
                <div class='footer'>
                    <p><strong>Demande reçue le " . date('d/m/Y à H:i:s') . "</strong></p>
                    <p>Portfolio Samba SY - Expert Data Science, IA & Cloud Computing</p>
                    <p>📧 sambasy837@gmail.com | 📱 +221 77 378 48 14 | 🌍 Dakar, Sénégal</p>
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
        $headers .= "X-Priority: 1" . "\r\n"; // Haute priorité pour les devis
        
        // Envoyer l'email
        if (mail($to_email, $email_subject, $email_body, $headers)) {
            // Redirection vers une page de succès
            header("Location: devis_success.php?name=" . urlencode($fullName) . "&project=" . urlencode($projectType));
            exit();
        } else {
            $error_message = "Erreur lors de l'envoi de la demande de devis. Veuillez réessayer.";
        }
        
    } else {
        $error_message = "Erreurs de validation : " . implode(", ", $errors);
    }
    
} else {
    // Si accès direct au fichier PHP
    header("Location: devis.html");
    exit();
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Erreur - Demande de Devis</title>
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
            background: #4f46e5;
            color: white;
            text-decoration: none;
            border-radius: 6px;
            transition: background 0.3s;
        }
        .btn-back:hover {
            background: #4338ca;
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
        <a href="devis.html" class="btn-back">← Retour au formulaire</a>
    </div>
</body>
</html>
