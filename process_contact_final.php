<?php
// Version finale pour le formulaire de contact complet
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    // Récupérer TOUS les champs du formulaire
    $name = htmlspecialchars(trim($_POST['name'] ?? ''));
    $email = htmlspecialchars(trim($_POST['email'] ?? ''));
    $phone = htmlspecialchars(trim($_POST['phone'] ?? ''));
    $company = htmlspecialchars(trim($_POST['company'] ?? ''));
    $subject = htmlspecialchars(trim($_POST['subject'] ?? ''));
    $budget = htmlspecialchars(trim($_POST['budget'] ?? ''));
    $timeline = htmlspecialchars(trim($_POST['timeline'] ?? ''));
    $message = htmlspecialchars(trim($_POST['message'] ?? ''));
    
    // Validation des champs obligatoires
    if (!empty($name) && !empty($email) && !empty($subject) && !empty($message) && filter_var($email, FILTER_VALIDATE_EMAIL)) {
        
        // Mapper les valeurs pour l'email
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
        
        // Préparer l'email complet
        $to = "sambasy837@gmail.com";
        $email_subject = "📧 Nouveau message de contact - " . $name;
        
        $email_body = "
=== NOUVEAU MESSAGE DE CONTACT ===
Portfolio Samba SY - Expert Data Science & IA

👤 INFORMATIONS CLIENT
Nom complet : $name
Email : $email
Téléphone : " . ($phone ?: 'Non renseigné') . "
Entreprise : " . ($company ?: 'Non renseignée') . "

📋 DÉTAILS DU PROJET
Sujet : " . ($subject_map[$subject] ?? $subject) . "
Budget estimé : " . ($budget ? ($budget_map[$budget] ?? $budget) : 'Non renseigné') . "
Délai souhaité : " . ($timeline ? ($timeline_map[$timeline] ?? $timeline) : 'Non renseigné') . "

💬 MESSAGE
$message

⚡ ACTIONS RECOMMANDÉES
1. Répondre dans les 24h
2. Analyser les besoins du client
3. Proposer une solution adaptée
4. Programmer un appel si nécessaire

---
Message reçu le " . date('d/m/Y à H:i:s') . "
Portfolio Samba SY - sambasy837@gmail.com - +221 77 378 48 14
        ";
        
        // Headers
        $headers = "From: Portfolio Samba SY <noreply@sambasy.com>\r\n";
        $headers .= "Reply-To: $email\r\n";
        $headers .= "Content-Type: text/plain; charset=UTF-8\r\n";
        
        // Envoyer l'email
        $mail_sent = mail($to, $email_subject, $email_body, $headers);
        
        // Redirection forcée vers la page de succès
        header("Location: contact_success_simple.php?name=" . urlencode($name));
        exit();
        
    } else {
        $error = "Veuillez remplir tous les champs obligatoires (nom, email valide, sujet, message).";
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
            <?php echo isset($error) ? $error : 'Une erreur inattendue s\'est produite.'; ?>
        </div>
        <a href="contact.html" class="btn-back">← Retour au formulaire</a>
    </div>
</body>
</html>
