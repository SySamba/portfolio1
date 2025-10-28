<?php
// Debug de la redirection - pas d'espaces avant <?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

echo "<h2>🔍 Debug de la redirection</h2>";

// Vérifier les fichiers
$files_to_check = [
    'contact_success_simple.php',
    'process_contact_fixed.php',
    'contact.html'
];

foreach ($files_to_check as $file) {
    if (file_exists($file)) {
        echo "<p style='color: green;'>✅ $file existe</p>";
    } else {
        echo "<p style='color: red;'>❌ $file manquant</p>";
    }
}

// Test de redirection simple
if (isset($_GET['test_redirect'])) {
    echo "<p>Test de redirection en cours...</p>";
    echo "<script>setTimeout(function() { window.location.href = 'contact_success_simple.php?name=Test'; }, 2000);</script>";
    echo "<p style='background: #fff3cd; padding: 10px; border-radius: 4px;'>⏳ Redirection dans 2 secondes...</p>";
    exit;
}

// Formulaire de test direct
echo "<h3>Test de redirection :</h3>";
echo "<a href='?test_redirect=1' style='background: #007bff; color: white; padding: 10px 20px; text-decoration: none; border-radius: 4px;'>🔗 Tester la redirection</a>";

echo "<h3>Test du formulaire complet :</h3>";
echo "<form method='POST' action='process_contact_fixed.php' style='background: #f8f9fa; padding: 20px; border-radius: 8px;'>
    <input type='text' name='name' value='Debug Test' required style='width: 100%; padding: 8px; margin: 5px 0; border: 1px solid #ddd; border-radius: 4px;'><br>
    <input type='email' name='email' value='debug@test.com' required style='width: 100%; padding: 8px; margin: 5px 0; border: 1px solid #ddd; border-radius: 4px;'><br>
    <select name='subject' required style='width: 100%; padding: 8px; margin: 5px 0; border: 1px solid #ddd; border-radius: 4px;'>
        <option value='ia' selected>IA</option>
    </select><br>
    <textarea name='message' required style='width: 100%; padding: 8px; margin: 5px 0; border: 1px solid #ddd; border-radius: 4px;'>Message de debug</textarea><br>
    <button type='submit' style='background: #28a745; color: white; padding: 10px 20px; border: none; border-radius: 4px;'>🚀 Test Formulaire</button>
</form>";

echo "<h3>Liens directs :</h3>";
echo "<p><a href='contact_success_simple.php?name=Test%20Direct' target='_blank' style='color: #007bff;'>🔗 Ouvrir page de succès directement</a></p>";
echo "<p><a href='contact.html' style='color: #007bff;'>← Retour au formulaire contact</a></p>";
?>

<style>
body {
    font-family: Arial, sans-serif;
    max-width: 800px;
    margin: 0 auto;
    padding: 20px;
    line-height: 1.6;
}
</style>
