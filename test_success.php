<?php
/**
 * Test de la page de succès
 */

echo "<h2>🧪 Test de la page de succès</h2>";

// Test 1: Vérifier que contact_success.php existe
if (file_exists('contact_success.php')) {
    echo "<p style='color: green;'>✅ Le fichier contact_success.php existe</p>";
    
    // Test 2: Vérifier qu'il est lisible
    if (is_readable('contact_success.php')) {
        echo "<p style='color: green;'>✅ Le fichier contact_success.php est lisible</p>";
    } else {
        echo "<p style='color: red;'>❌ Le fichier contact_success.php n'est pas lisible</p>";
    }
} else {
    echo "<p style='color: red;'>❌ Le fichier contact_success.php n'existe pas</p>";
}

// Test 3: Simuler l'accès à la page de succès
echo "<h3>Test d'accès à la page de succès :</h3>";
echo "<p><a href='contact_success.php?name=Test%20User' target='_blank' style='background: #007bff; color: white; padding: 10px 20px; text-decoration: none; border-radius: 4px;'>🔗 Ouvrir contact_success.php</a></p>";

// Test 4: Vérifier les CSS
$css_files = ['css/style.css', 'css/pages.css'];
echo "<h3>Vérification des fichiers CSS :</h3>";
foreach ($css_files as $css) {
    if (file_exists($css)) {
        echo "<p style='color: green;'>✅ $css existe</p>";
    } else {
        echo "<p style='color: orange;'>⚠️ $css n'existe pas (optionnel)</p>";
    }
}

// Test 5: Simuler le processus complet
echo "<h3>Test du processus complet :</h3>";
echo "<form method='POST' style='background: #f8f9fa; padding: 20px; border-radius: 8px;'>
    <h4>Formulaire de test rapide</h4>
    <input type='text' name='name' placeholder='Votre nom' value='Test User' required style='width: 100%; padding: 8px; margin: 5px 0; border: 1px solid #ddd; border-radius: 4px;'><br>
    <input type='email' name='email' placeholder='Votre email' value='test@example.com' required style='width: 100%; padding: 8px; margin: 5px 0; border: 1px solid #ddd; border-radius: 4px;'><br>
    <select name='subject' required style='width: 100%; padding: 8px; margin: 5px 0; border: 1px solid #ddd; border-radius: 4px;'>
        <option value=''>Sélectionnez un sujet</option>
        <option value='ia' selected>Projet Intelligence Artificielle</option>
        <option value='cloud'>Solution Cloud & DevOps</option>
    </select><br>
    <textarea name='message' placeholder='Votre message' required style='width: 100%; padding: 8px; margin: 5px 0; border: 1px solid #ddd; border-radius: 4px; height: 80px;'>Message de test pour vérifier le formulaire de contact.</textarea><br>
    <button type='submit' style='background: #28a745; color: white; padding: 10px 20px; border: none; border-radius: 4px; cursor: pointer;'>🚀 Tester le formulaire</button>
</form>";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    echo "<hr><h3>Résultat du test :</h3>";
    
    // Rediriger vers process_contact.php avec les données
    $post_data = http_build_query($_POST);
    
    echo "<p style='background: #d1ecf1; padding: 15px; border-radius: 4px;'>";
    echo "<strong>Données envoyées :</strong><br>";
    foreach ($_POST as $key => $value) {
        echo "$key: " . htmlspecialchars($value) . "<br>";
    }
    echo "</p>";
    
    echo "<p><strong>Le formulaire va maintenant être traité par process_contact.php...</strong></p>";
    
    // Créer un formulaire auto-submit vers process_contact.php
    echo "<form id='autoSubmit' method='POST' action='process_contact.php'>";
    foreach ($_POST as $key => $value) {
        echo "<input type='hidden' name='" . htmlspecialchars($key) . "' value='" . htmlspecialchars($value) . "'>";
    }
    echo "</form>";
    
    echo "<script>
        setTimeout(function() {
            document.getElementById('autoSubmit').submit();
        }, 2000);
    </script>";
    
    echo "<p style='color: #856404; background: #fff3cd; padding: 10px; border-radius: 4px;'>⏳ Redirection automatique dans 2 secondes...</p>";
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
</style>

<p><a href="contact.html">← Retour au formulaire de contact</a></p>
