<?php
// Test simple identique au test qui fonctionne
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    $name = htmlspecialchars(trim($_POST['name'] ?? 'Test Contact'));
    $email = htmlspecialchars(trim($_POST['email'] ?? 'test@example.com'));
    $subject = htmlspecialchars(trim($_POST['subject'] ?? 'ia'));
    $message = htmlspecialchars(trim($_POST['message'] ?? 'Message de test'));
    
    // Email IDENTIQUE au test qui fonctionne
    $to = "sambasy837@gmail.com";
    $email_subject = "TEST CONTACT - Portfolio Contact";
    $email_message = "
TEST D'ENVOI EMAIL - FORMULAIRE CONTACT

Ceci est un email du formulaire de contact.

Détails du formulaire :
- Nom : $name
- Email : $email  
- Sujet : $subject
- Message : $message
- Date : " . date('d/m/Y H:i:s') . "
- Serveur : " . ($_SERVER['SERVER_NAME'] ?? 'localhost') . "

Si vous recevez cet email, le formulaire de contact fonctionne.
    ";
    
    // Headers IDENTIQUES au test qui fonctionne
    $headers = "From: Portfolio Debug <debug@sambasy.com>\r\n";
    $headers .= "Reply-To: $email\r\n";
    $headers .= "Content-Type: text/plain; charset=UTF-8\r\n";
    
    $result = mail($to, $email_subject, $email_message, $headers);
    
    if ($result) {
        echo "<!DOCTYPE html>
<html>
<head><meta charset='UTF-8'><title>Test Envoyé</title></head>
<body style='font-family: Arial; text-align: center; padding: 50px;'>
    <h2 style='color: green;'>✅ Email de test envoyé !</h2>
    <p>Vérifiez votre boîte email : sambasy837@gmail.com</p>
    <p><a href='contact.html'>← Retour au formulaire</a></p>
    <script>
        setTimeout(function() {
            window.location.href = 'contact_success_simple.php?name=" . urlencode($name) . "';
        }, 3000);
    </script>
</body>
</html>";
    } else {
        echo "❌ Échec de l'envoi";
    }
    exit();
}
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Test Contact Simple</title>
    <style>
        body { font-family: Arial; max-width: 500px; margin: 50px auto; padding: 20px; }
        .form-group { margin-bottom: 15px; }
        label { display: block; margin-bottom: 5px; font-weight: bold; }
        input, select, textarea { width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 4px; box-sizing: border-box; }
        button { background: #007bff; color: white; padding: 12px 24px; border: none; border-radius: 4px; cursor: pointer; width: 100%; }
    </style>
</head>
<body>
    <h2>🧪 Test Contact Simple</h2>
    <p>Ce test utilise exactement les mêmes paramètres que le test qui fonctionne.</p>
    
    <form method="POST">
        <div class="form-group">
            <label>Nom :</label>
            <input type="text" name="name" value="Test Simple" required>
        </div>
        
        <div class="form-group">
            <label>Email :</label>
            <input type="email" name="email" value="test.simple@example.com" required>
        </div>
        
        <div class="form-group">
            <label>Sujet :</label>
            <select name="subject" required>
                <option value="ia" selected>IA</option>
                <option value="cloud">Cloud</option>
            </select>
        </div>
        
        <div class="form-group">
            <label>Message :</label>
            <textarea name="message" required>Test simple du formulaire de contact avec les mêmes paramètres que le test qui fonctionne.</textarea>
        </div>
        
        <button type="submit">🚀 Envoyer Test Simple</button>
    </form>
    
    <p><a href="contact.html">← Retour au formulaire normal</a></p>
</body>
</html>
