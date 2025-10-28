<?php
/**
 * Debug de l'envoi d'email
 */

echo "<h2>🔍 Debug de l'envoi d'email</h2>";

// Test 1: Fonction mail() disponible
if (function_exists('mail')) {
    echo "<p style='color: green;'>✅ Fonction mail() disponible</p>";
} else {
    echo "<p style='color: red;'>❌ Fonction mail() non disponible</p>";
}

// Test 2: Configuration serveur
echo "<h3>Configuration du serveur :</h3>";
echo "<ul>";
echo "<li><strong>SMTP :</strong> " . (ini_get('SMTP') ?: 'Non configuré') . "</li>";
echo "<li><strong>Port SMTP :</strong> " . (ini_get('smtp_port') ?: 'Non configuré') . "</li>";
echo "<li><strong>Sendmail Path :</strong> " . (ini_get('sendmail_path') ?: 'Non configuré') . "</li>";
echo "</ul>";

// Test 3: Envoi d'email de test
if (isset($_POST['test_email'])) {
    echo "<h3>🧪 Résultat du test d'envoi :</h3>";
    
    $to = "sambasy837@gmail.com";
    $subject = "TEST DEBUG - Portfolio Contact";
    $message = "
TEST D'ENVOI EMAIL - DEBUG

Ceci est un email de test pour diagnostiquer le problème d'envoi.

Détails du test :
- Date : " . date('d/m/Y H:i:s') . "
- Serveur : " . ($_SERVER['SERVER_NAME'] ?? 'localhost') . "
- IP : " . ($_SERVER['SERVER_ADDR'] ?? 'inconnue') . "
- User Agent : " . ($_SERVER['HTTP_USER_AGENT'] ?? 'inconnu') . "

Si vous recevez cet email, la fonction mail() fonctionne.
    ";
    
    $headers = "From: Portfolio Debug <debug@sambasy.com>\r\n";
    $headers .= "Reply-To: debug@sambasy.com\r\n";
    $headers .= "Content-Type: text/plain; charset=UTF-8\r\n";
    
    // Activer le reporting d'erreurs
    error_reporting(E_ALL);
    ini_set('display_errors', 1);
    
    $result = mail($to, $subject, $message, $headers);
    
    if ($result) {
        echo "<div style='background: #d4edda; color: #155724; padding: 15px; border-radius: 5px; border-left: 4px solid #28a745;'>";
        echo "<strong>✅ Email envoyé avec succès !</strong><br>";
        echo "Vérifiez votre boîte email : sambasy837@gmail.com<br>";
        echo "<strong>Important :</strong> Vérifiez aussi le dossier SPAM/Courrier indésirable !";
        echo "</div>";
    } else {
        echo "<div style='background: #f8d7da; color: #721c24; padding: 15px; border-radius: 5px; border-left: 4px solid #dc3545;'>";
        echo "<strong>❌ Échec de l'envoi !</strong><br>";
        
        $last_error = error_get_last();
        if ($last_error) {
            echo "<strong>Erreur PHP :</strong> " . $last_error['message'] . "<br>";
        }
        
        echo "<strong>Solutions possibles :</strong><br>";
        echo "• Vérifier la configuration SMTP du serveur<br>";
        echo "• Contacter l'hébergeur<br>";
        echo "• Utiliser SMTP authentifié (PHPMailer)";
        echo "</div>";
    }
}

// Test 4: Simuler les données du formulaire
if (isset($_POST['test_form'])) {
    echo "<h3>🧪 Test avec données du formulaire :</h3>";
    
    $form_data = [
        'name' => 'Test Debug',
        'email' => 'test@example.com',
        'subject' => 'ia',
        'message' => 'Message de test pour debug'
    ];
    
    echo "<p><strong>Données simulées :</strong></p>";
    echo "<pre>" . print_r($form_data, true) . "</pre>";
    
    // Inclure le traitement
    $_POST = $form_data;
    $_SERVER["REQUEST_METHOD"] = "POST";
    
    echo "<p><strong>Traitement en cours...</strong></p>";
    
    ob_start();
    include 'process_contact_force.php';
    $output = ob_get_clean();
    
    echo "<div style='background: #f8f9fa; padding: 15px; border-radius: 5px; border: 1px solid #dee2e6;'>";
    echo "<strong>Sortie du script :</strong><br>";
    echo $output ?: "Aucune sortie (redirection réussie)";
    echo "</div>";
}
?>

<style>
body {
    font-family: Arial, sans-serif;
    max-width: 800px;
    margin: 0 auto;
    padding: 20px;
    line-height: 1.6;
}
h2, h3 {
    color: #333;
    border-bottom: 2px solid #eee;
    padding-bottom: 5px;
}
.test-form {
    background: #f8f9fa;
    padding: 20px;
    border-radius: 8px;
    margin: 20px 0;
    border-left: 4px solid #007bff;
}
.test-button {
    background: #007bff;
    color: white;
    padding: 12px 24px;
    border: none;
    border-radius: 4px;
    cursor: pointer;
    font-size: 16px;
    margin: 10px 10px 10px 0;
}
.test-button:hover {
    background: #0056b3;
}
.test-button.success {
    background: #28a745;
}
.test-button.success:hover {
    background: #1e7e34;
}
</style>

<div class="test-form">
    <h3>🧪 Tests de diagnostic</h3>
    
    <form method="POST">
        <button type="submit" name="test_email" class="test-button">
            📧 Test d'envoi email simple
        </button>
    </form>
    
    <form method="POST">
        <button type="submit" name="test_form" class="test-button success">
            📝 Test avec données du formulaire
        </button>
    </form>
</div>

<h3>💡 Conseils de vérification :</h3>
<ul>
    <li><strong>Boîte de réception :</strong> Vérifiez sambasy837@gmail.com</li>
    <li><strong>Dossier SPAM :</strong> Les emails automatiques finissent souvent dans les spams</li>
    <li><strong>Filtres Gmail :</strong> Vérifiez s'il n'y a pas de filtres qui bloquent</li>
    <li><strong>Délai :</strong> Parfois il faut attendre 5-10 minutes</li>
</ul>

<p><a href="contact.html">← Retour au formulaire de contact</a></p>
