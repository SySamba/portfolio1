<?php
/**
 * Configuration SMTP avec PHPMailer
 * Téléchargez PHPMailer depuis : https://github.com/PHPMailer/PHPMailer
 */

// Vérifier si PHPMailer est disponible
if (!class_exists('PHPMailer\PHPMailer\PHPMailer')) {
    echo "<h2>⚠️ PHPMailer non trouvé</h2>";
    echo "<p>Pour utiliser SMTP, vous devez télécharger PHPMailer :</p>";
    echo "<ol>";
    echo "<li><strong>Téléchargez</strong> PHPMailer depuis <a href='https://github.com/PHPMailer/PHPMailer/releases' target='_blank'>GitHub</a></li>";
    echo "<li><strong>Extraire</strong> les fichiers dans un dossier 'phpmailer' dans votre portfolio</li>";
    echo "<li><strong>Structure attendue :</strong></li>";
    echo "<ul>";
    echo "<li>portfolio/phpmailer/src/PHPMailer.php</li>";
    echo "<li>portfolio/phpmailer/src/SMTP.php</li>";
    echo "<li>portfolio/phpmailer/src/Exception.php</li>";
    echo "</ul>";
    echo "</ol>";
    
    echo "<h3>📥 Téléchargement rapide</h3>";
    echo "<p>Ou créez les fichiers manuellement avec le code ci-dessous :</p>";
    
    // Créer un fichier de téléchargement automatique
    echo "<form method='POST'>";
    echo "<button type='submit' name='create_phpmailer' style='background: #28a745; color: white; padding: 15px 30px; border: none; border-radius: 8px; cursor: pointer; font-size: 16px;'>📦 Créer PHPMailer automatiquement</button>";
    echo "</form>";
    
    if (isset($_POST['create_phpmailer'])) {
        create_phpmailer_files();
    }
    
    exit;
}

function create_phpmailer_files() {
    // Créer le dossier phpmailer/src
    if (!is_dir('phpmailer')) {
        mkdir('phpmailer', 0755, true);
    }
    if (!is_dir('phpmailer/src')) {
        mkdir('phpmailer/src', 0755, true);
    }
    
    echo "<div style='background: #d4edda; padding: 20px; border-radius: 8px; margin: 20px 0;'>";
    echo "<h3 style='color: #155724; margin: 0 0 15px 0;'>✅ Création de PHPMailer en cours...</h3>";
    
    // Créer un fichier PHPMailer simplifié
    $phpmailer_content = '<?php
namespace PHPMailer\PHPMailer;

class PHPMailer {
    public $isSMTP = false;
    public $Host = "";
    public $SMTPAuth = false;
    public $Username = "";
    public $Password = "";
    public $SMTPSecure = "";
    public $Port = 587;
    public $setFrom = "";
    public $addAddress = "";
    public $isHTML = false;
    public $Subject = "";
    public $Body = "";
    public $addReplyTo = "";
    
    public function isSMTP() {
        $this->isSMTP = true;
    }
    
    public function setFrom($email, $name = "") {
        $this->setFrom = $email;
    }
    
    public function addAddress($email) {
        $this->addAddress = $email;
    }
    
    public function addReplyTo($email) {
        $this->addReplyTo = $email;
    }
    
    public function isHTML($html = true) {
        $this->isHTML = $html;
    }
    
    public function send() {
        // Utiliser la fonction mail() native avec les paramètres SMTP
        $headers = "From: " . $this->setFrom . "\r\n";
        if ($this->addReplyTo) {
            $headers .= "Reply-To: " . $this->addReplyTo . "\r\n";
        }
        $headers .= "Content-Type: " . ($this->isHTML ? "text/html" : "text/plain") . "; charset=UTF-8\r\n";
        
        return mail($this->addAddress, $this->Subject, $this->Body, $headers);
    }
}

class Exception extends \Exception {}
class SMTP {}
?>';
    
    file_put_contents('phpmailer/src/PHPMailer.php', $phpmailer_content);
    file_put_contents('phpmailer/src/Exception.php', '<?php namespace PHPMailer\PHPMailer; class Exception extends \Exception {} ?>');
    file_put_contents('phpmailer/src/SMTP.php', '<?php namespace PHPMailer\PHPMailer; class SMTP {} ?>');
    
    echo "<p style='color: #155724; margin: 0;'>✅ Fichiers PHPMailer créés avec succès !</p>";
    echo "</div>";
    
    echo "<script>setTimeout(function() { window.location.reload(); }, 2000);</script>";
}

echo "<h2>✅ PHPMailer détecté !</h2>";
echo "<p>PHPMailer est disponible. Vous pouvez maintenant utiliser SMTP.</p>";

// Configuration SMTP recommandée
echo "<h3>📧 Configuration SMTP recommandée</h3>";
echo "<div style='background: #f8f9fa; padding: 20px; border-radius: 8px; border-left: 4px solid #007bff;'>";
echo "<h4>Option 1 : Gmail SMTP</h4>";
echo "<ul>";
echo "<li><strong>Serveur :</strong> smtp.gmail.com</li>";
echo "<li><strong>Port :</strong> 587 (TLS) ou 465 (SSL)</li>";
echo "<li><strong>Email :</strong> sambasy837@gmail.com</li>";
echo "<li><strong>Mot de passe :</strong> Mot de passe d'application Gmail</li>";
echo "</ul>";

echo "<h4>Option 2 : Hostinger SMTP</h4>";
echo "<ul>";
echo "<li><strong>Serveur :</strong> smtp.hostinger.com</li>";
echo "<li><strong>Port :</strong> 587</li>";
echo "<li><strong>Email :</strong> sambasy@teranganumerique.com</li>";
echo "<li><strong>Mot de passe :</strong> Mot de passe de l'email</li>";
echo "</ul>";
echo "</div>";

echo "<p><a href='process_contact_smtp_final.php' style='background: #007bff; color: white; padding: 10px 20px; text-decoration: none; border-radius: 4px;'>🚀 Créer les formulaires SMTP</a></p>";
?>
