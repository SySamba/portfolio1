<?php
/**
 * Configuration PHP pour le portfolio de Samba SY
 * Fichier de configuration centralisé pour les formulaires
 */

// Configuration Email
define('EMAIL_TO', 'sambasy837@gmail.com');
define('EMAIL_FROM_NAME', 'Portfolio Samba SY');
define('EMAIL_FROM_ADDRESS', 'noreply@sambasy.com');

// Configuration du site
define('SITE_NAME', 'Portfolio Samba SY');
define('SITE_URL', 'https://sambasy.teranganumerique.com');
define('SITE_DESCRIPTION', 'Expert Data Science, IA et Cloud Computing');

// Informations de contact
define('PHONE', '+221 77 378 48 14');
define('EMAIL_CONTACT', 'sambasy837@gmail.com');
define('LOCATION', 'Dakar, Sénégal');
define('LINKEDIN', 'https://www.linkedin.com/in/samba-sy/');
define('GITHUB', 'https://github.com/SySamba/');

// Configuration des emails
define('EMAIL_CHARSET', 'UTF-8');
define('EMAIL_CONTENT_TYPE', 'text/html');

// Messages de succès
define('SUCCESS_CONTACT_MESSAGE', 'Votre message a été envoyé avec succès ! Je vous répondrai sous 24h.');
define('SUCCESS_DEVIS_MESSAGE', 'Votre demande de devis a été envoyée avec succès ! Je vous répondrai sous 24h.');

// Messages d'erreur
define('ERROR_REQUIRED_FIELDS', 'Veuillez remplir tous les champs obligatoires.');
define('ERROR_INVALID_EMAIL', 'L\'adresse email n\'est pas valide.');
define('ERROR_INVALID_PHONE', 'Le numéro de téléphone n\'est pas valide.');
define('ERROR_SEND_FAILED', 'Erreur lors de l\'envoi. Veuillez réessayer.');
define('ERROR_SPAM_DETECTED', 'Votre message a été détecté comme spam.');

// Configuration anti-spam
define('HONEYPOT_FIELD', 'companyWebsite');
define('MAX_MESSAGE_LENGTH', 5000);
define('MIN_MESSAGE_LENGTH', 10);

// Délais et limites
define('RESPONSE_TIME', '24 heures');
define('MAX_FILE_SIZE', 5242880); // 5MB en bytes

// Types de projets disponibles
$PROJECT_TYPES = [
    'web' => '🌐 Site Web / E-commerce',
    'data' => '📊 Analyse de Données / BI',
    'ai' => '🤖 Intelligence Artificielle',
    'cloud' => '☁️ Cloud / DevOps',
    'mobile' => '📱 Application Mobile',
    'other' => '🔧 Autre'
];

// Gammes de budget
$BUDGET_RANGES = [
    '< 500k' => 'Moins de 500 000 FCFA',
    '500k-1M' => '500 000 - 1 000 000 FCFA',
    '1M-2M' => '1 000 000 - 2 000 000 FCFA',
    '2M+' => 'Plus de 2 000 000 FCFA'
];

// Options de délai
$TIMELINE_OPTIONS = [
    'urgent' => 'Urgent (< 1 mois)',
    'court' => 'Court terme (1-3 mois)',
    'moyen' => 'Moyen terme (3-6 mois)',
    'flexible' => 'Flexible'
];

// Sujets de contact
$CONTACT_SUBJECTS = [
    'ia' => 'Projet Intelligence Artificielle',
    'cloud' => 'Solution Cloud & DevOps',
    'data' => 'Data Analytics & BI',
    'web' => 'Développement Web',
    'consultation' => 'Consultation',
    'autre' => 'Autre'
];

// Fonction utilitaires
function clean_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data, ENT_QUOTES, 'UTF-8');
    return $data;
}

function validate_email($email) {
    return filter_var($email, FILTER_VALIDATE_EMAIL);
}

function validate_phone($phone) {
    // Accepter les formats internationaux et locaux
    return preg_match('/^[\+]?[0-9\s\-\(\)]{8,15}$/', $phone);
}

function is_spam($data) {
    // Vérification honeypot
    if (!empty($data[HONEYPOT_FIELD])) {
        return true;
    }
    
    // Vérification de la longueur du message
    if (isset($data['message'])) {
        $message_length = strlen($data['message']);
        if ($message_length > MAX_MESSAGE_LENGTH || $message_length < MIN_MESSAGE_LENGTH) {
            return true;
        }
    }
    
    // Vérification de mots-clés spam (basique)
    $spam_keywords = ['viagra', 'casino', 'lottery', 'winner', 'congratulations'];
    $content = strtolower(implode(' ', $data));
    
    foreach ($spam_keywords as $keyword) {
        if (strpos($content, $keyword) !== false) {
            return true;
        }
    }
    
    return false;
}

function log_submission($type, $data) {
    $log_entry = [
        'timestamp' => date('Y-m-d H:i:s'),
        'type' => $type,
        'ip' => $_SERVER['REMOTE_ADDR'] ?? 'unknown',
        'user_agent' => $_SERVER['HTTP_USER_AGENT'] ?? 'unknown',
        'data' => $data
    ];
    
    // Créer le dossier logs s'il n'existe pas
    if (!file_exists('logs')) {
        mkdir('logs', 0755, true);
    }
    
    // Écrire dans le fichier de log
    $log_file = 'logs/submissions_' . date('Y-m') . '.log';
    file_put_contents($log_file, json_encode($log_entry) . "\n", FILE_APPEND | LOCK_EX);
}

function send_notification_email($to, $subject, $body, $reply_to = null) {
    $headers = "MIME-Version: 1.0" . "\r\n";
    $headers .= "Content-type: " . EMAIL_CONTENT_TYPE . "; charset=" . EMAIL_CHARSET . "\r\n";
    $headers .= "From: " . EMAIL_FROM_NAME . " <" . EMAIL_FROM_ADDRESS . ">" . "\r\n";
    
    if ($reply_to) {
        $headers .= "Reply-To: " . $reply_to . "\r\n";
    }
    
    $headers .= "X-Mailer: PHP/" . phpversion() . "\r\n";
    $headers .= "X-Priority: 1" . "\r\n"; // Haute priorité
    
    return mail($to, $subject, $body, $headers);
}

// Configuration de la timezone
date_default_timezone_set('Africa/Dakar');

// Configuration des erreurs (à désactiver en production)
if ($_SERVER['SERVER_NAME'] === 'localhost' || $_SERVER['SERVER_NAME'] === '127.0.0.1') {
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);
} else {
    ini_set('display_errors', 0);
    ini_set('display_startup_errors', 0);
    error_reporting(0);
}

// Protection CSRF (basique)
if (!isset($_SESSION)) {
    session_start();
}

function generate_csrf_token() {
    if (!isset($_SESSION['csrf_token'])) {
        $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
    }
    return $_SESSION['csrf_token'];
}

function verify_csrf_token($token) {
    return isset($_SESSION['csrf_token']) && hash_equals($_SESSION['csrf_token'], $token);
}

// Constantes pour les réseaux sociaux
define('SOCIAL_LINKEDIN', LINKEDIN);
define('SOCIAL_GITHUB', GITHUB);

// Version du site (pour le cache busting)
define('SITE_VERSION', '1.0.0');

?>
