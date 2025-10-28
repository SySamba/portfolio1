<?php
/**
 * Fichier de diagnostic pour le formulaire de contact
 */

echo "<h2>🔍 Diagnostic du formulaire de contact</h2>";

// 1. Vérifier la fonction mail()
echo "<h3>1. Test de la fonction mail()</h3>";
if (function_exists('mail')) {
    echo "✅ La fonction mail() est disponible<br>";
    
    // Test d'envoi simple
    $test_result = mail('sambasy837@gmail.com', 'Test diagnostic', 'Email de test depuis le diagnostic');
    if ($test_result) {
        echo "✅ Test d'envoi réussi<br>";
    } else {
        echo "❌ Échec du test d'envoi<br>";
    }
} else {
    echo "❌ La fonction mail() n'est pas disponible<br>";
}

// 2. Vérifier les permissions
echo "<h3>2. Permissions des fichiers</h3>";
$files_to_check = [
    'process_contact.php',
    'contact_success.php',
    'contact.html'
];

foreach ($files_to_check as $file) {
    if (file_exists($file)) {
        echo "✅ $file existe<br>";
        if (is_readable($file)) {
            echo "✅ $file est lisible<br>";
        } else {
            echo "❌ $file n'est pas lisible<br>";
        }
    } else {
        echo "❌ $file n'existe pas<br>";
    }
}

// 3. Vérifier la configuration PHP
echo "<h3>3. Configuration PHP</h3>";
echo "Version PHP : " . phpversion() . "<br>";
echo "SMTP : " . ini_get('SMTP') . "<br>";
echo "smtp_port : " . ini_get('smtp_port') . "<br>";
echo "sendmail_path : " . ini_get('sendmail_path') . "<br>";

// 4. Test avec données réelles
echo "<h3>4. Test avec données réelles</h3>";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    echo "<strong>Données reçues :</strong><br>";
    foreach ($_POST as $key => $value) {
        echo "$key: " . htmlspecialchars($value) . "<br>";
    }
    
    // Inclure le traitement
    echo "<hr><strong>Résultat du traitement :</strong><br>";
    ob_start();
    include 'process_contact.php';
    $output = ob_get_clean();
    
    if (empty($output)) {
        echo "✅ Traitement réussi - Redirection vers contact_success.php<br>";
    } else {
        echo "❌ Erreur dans le traitement :<br>";
        echo "<pre>$output</pre>";
    }
} else {
    // Formulaire de test
    echo '<form method="POST" style="background: #f9f9f9; padding: 20px; border-radius: 8px; margin: 20px 0;">
        <h4>Formulaire de test</h4>
        <input type="text" name="name" placeholder="Nom" value="Test User" required><br><br>
        <input type="email" name="email" placeholder="Email" value="test@example.com" required><br><br>
        <input type="tel" name="phone" placeholder="Téléphone" value="+221 77 123 45 67"><br><br>
        <input type="text" name="company" placeholder="Entreprise" value="Test Company"><br><br>
        <select name="subject" required>
            <option value="">Sélectionnez un sujet</option>
            <option value="ia" selected>Projet Intelligence Artificielle</option>
            <option value="cloud">Solution Cloud & DevOps</option>
            <option value="data">Data Analytics & BI</option>
        </select><br><br>
        <select name="budget">
            <option value="">Budget</option>
            <option value="500k-1M" selected>500 000 - 1 000 000 FCFA</option>
        </select><br><br>
        <select name="timeline">
            <option value="">Délai</option>
            <option value="court" selected>Court terme (1-3 mois)</option>
        </select><br><br>
        <textarea name="message" placeholder="Message" required>Ceci est un message de test pour diagnostiquer le formulaire de contact.</textarea><br><br>
        <button type="submit">🧪 Tester le formulaire</button>
    </form>';
}

// 5. Vérifier les logs d'erreur
echo "<h3>5. Logs d'erreur PHP</h3>";
$error_log = ini_get('error_log');
if ($error_log && file_exists($error_log)) {
    echo "Fichier de log : $error_log<br>";
    $recent_errors = tail($error_log, 10);
    if ($recent_errors) {
        echo "<pre style='background: #ffe6e6; padding: 10px; border-radius: 4px;'>$recent_errors</pre>";
    }
} else {
    echo "Aucun fichier de log d'erreur configuré<br>";
}

function tail($filename, $lines = 10) {
    if (!file_exists($filename)) return false;
    $data = file($filename);
    return implode("", array_slice($data, -$lines));
}

?>

<style>
body {
    font-family: Arial, sans-serif;
    max-width: 900px;
    margin: 0 auto;
    padding: 20px;
    line-height: 1.6;
}
h2, h3 {
    color: #333;
    border-bottom: 2px solid #eee;
    padding-bottom: 5px;
}
form input, form select, form textarea {
    width: 100%;
    padding: 8px;
    margin: 5px 0;
    border: 1px solid #ddd;
    border-radius: 4px;
}
form button {
    background: #667eea;
    color: white;
    padding: 10px 20px;
    border: none;
    border-radius: 4px;
    cursor: pointer;
}
form button:hover {
    background: #5a67d8;
}
</style>
