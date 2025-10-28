<?php
/**
 * Fichier de test pour le formulaire de contact
 * À supprimer après les tests
 */

// Simuler une soumission de formulaire de contact
$_POST = [
    'name' => 'Test Utilisateur',
    'email' => 'test@example.com',
    'phone' => '+221 77 123 45 67',
    'company' => 'Entreprise Test',
    'subject' => 'ia',
    'budget' => '500k-1M',
    'timeline' => 'court',
    'message' => 'Ceci est un message de test pour vérifier que le formulaire de contact fonctionne correctement. Je souhaite développer une solution d\'intelligence artificielle pour mon entreprise.'
];

$_SERVER["REQUEST_METHOD"] = "POST";

echo "<h2>🧪 Test du formulaire de contact</h2>";
echo "<p><strong>Données de test :</strong></p>";
echo "<pre>" . print_r($_POST, true) . "</pre>";

echo "<hr>";
echo "<p><strong>Résultat du traitement :</strong></p>";

// Inclure le fichier de traitement
ob_start();
include 'process_contact.php';
$output = ob_get_clean();

if (empty($output)) {
    echo "✅ <strong style='color: green;'>Succès !</strong> Le formulaire a été traité sans erreur.";
    echo "<br>📧 L'email devrait être envoyé à sambasy837@gmail.com";
} else {
    echo "❌ <strong style='color: red;'>Erreur détectée :</strong>";
    echo "<div style='background: #f8f8f8; padding: 10px; border-left: 4px solid #ff0000; margin: 10px 0;'>";
    echo $output;
    echo "</div>";
}

echo "<hr>";
echo "<p><a href='contact.html'>← Retour au formulaire de contact</a></p>";
?>

<style>
body {
    font-family: Arial, sans-serif;
    max-width: 800px;
    margin: 0 auto;
    padding: 20px;
    line-height: 1.6;
}
pre {
    background: #f4f4f4;
    padding: 15px;
    border-radius: 5px;
    overflow-x: auto;
}
hr {
    border: none;
    border-top: 2px solid #eee;
    margin: 20px 0;
}
</style>
