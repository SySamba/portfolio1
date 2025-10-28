<?php
/**
 * Test simple SANS erreurs de syntaxe
 */

require_once 'smtp_simple.php';

echo "<h2>🧪 Test Email Simple (Sans erreurs)</h2>";

// Tester la configuration
test_config();

if (isset($_POST['test_email'])) {
    echo "<h3>🚀 Test d'envoi en cours...</h3>";
    
    $test_subject = "TEST SIMPLE - Portfolio Samba SY";
    $test_body = "
TEST EMAIL SIMPLE - Portfolio

Ceci est un test d'envoi simple pour vérifier que le système fonctionne sans erreurs.

Détails du test :
- Date : " . date('d/m/Y H:i:s') . "
- Méthode : Headers optimisés anti-spam
- Email : sambasy837@gmail.com

Si vous recevez cet email, le système fonctionne parfaitement !

---
Portfolio Samba SY
Expert Data Science & Intelligence Artificielle
📧 sambasy837@gmail.com
📱 +221 77 378 48 14
🌍 Dakar, Sénégal
    ";
    
    $result = send_email_optimized("sambasy837@gmail.com", $test_subject, $test_body);
    
    if ($result) {
        echo "<div style='background: #d4edda; color: #155724; padding: 20px; border-radius: 8px; margin: 20px 0;'>";
        echo "<h4 style='margin: 0 0 10px 0;'>✅ Email envoyé avec succès !</h4>";
        echo "<p style='margin: 0;'>Vérifiez votre boîte email : sambasy837@gmail.com</p>";
        echo "<p style='margin: 10px 0 0 0; font-size: 14px; color: #6c757d;'>Note : Vérifiez aussi le dossier spam.</p>";
        echo "</div>";
    } else {
        echo "<div style='background: #f8d7da; color: #721c24; padding: 20px; border-radius: 8px; margin: 20px 0;'>";
        echo "<h4 style='margin: 0 0 10px 0;'>❌ Échec de l'envoi</h4>";
        echo "<p style='margin: 0;'>Problème avec la fonction mail() du serveur.</p>";
        echo "</div>";
    }
}
?>

<style>
body {
    font-family: Arial, sans-serif;
    max-width: 800px;
    margin: 0 auto;
    padding: 20px;
    line-height: 1.6;
    background: #f8f9fa;
}
.test-container {
    background: white;
    padding: 30px;
    border-radius: 10px;
    box-shadow: 0 4px 15px rgba(0,0,0,0.1);
    margin-bottom: 20px;
}
.test-form {
    background: #f8fafc;
    padding: 25px;
    border-radius: 8px;
    border-left: 4px solid #28a745;
    text-align: center;
}
.test-button {
    background: linear-gradient(135deg, #28a745 0%, #1e7e34 100%);
    color: white;
    padding: 15px 30px;
    border: none;
    border-radius: 8px;
    font-size: 16px;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.3s ease;
}
.test-button:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 20px rgba(40, 167, 69, 0.3);
}
h2, h3 {
    color: #1f2937;
    border-bottom: 2px solid #e5e7eb;
    padding-bottom: 10px;
}
</style>

<div class="test-container">
    <div class="test-form">
        <h3 style="border: none; color: #374151; margin-bottom: 20px;">Test Email Simple</h3>
        <p style="margin-bottom: 25px; color: #6b7280;">Version sans erreurs de syntaxe - Headers optimisés anti-spam</p>
        
        <form method="POST">
            <button type="submit" name="test_email" class="test-button">
                📧 Tester l'envoi simple
            </button>
        </form>
    </div>
    
    <div style="text-align: center; margin-top: 30px;">
        <a href="contact.html" style="color: #28a745; text-decoration: none; margin-right: 20px;">📝 Formulaire de contact</a>
        <a href="devis.html" style="color: #28a745; text-decoration: none;">💰 Formulaire de devis</a>
    </div>
</div>
