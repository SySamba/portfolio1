<?php
// Version ultra-simple qui fonctionne - comme le test qui marchait
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    // Récupérer les données
    $name = htmlspecialchars(trim($_POST['name'] ?? ''));
    $email = htmlspecialchars(trim($_POST['email'] ?? ''));
    $phone = htmlspecialchars(trim($_POST['phone'] ?? ''));
    $company = htmlspecialchars(trim($_POST['company'] ?? ''));
    $subject = htmlspecialchars(trim($_POST['subject'] ?? ''));
    $budget = htmlspecialchars(trim($_POST['budget'] ?? ''));
    $timeline = htmlspecialchars(trim($_POST['timeline'] ?? ''));
    $message = htmlspecialchars(trim($_POST['message'] ?? ''));
    
    // Validation simple
    if (!empty($name) && !empty($email) && !empty($subject) && !empty($message) && filter_var($email, FILTER_VALIDATE_EMAIL)) {
        
        // Email EXACTEMENT comme le test qui fonctionnait
        $to = "sambasy837@gmail.com";
        $email_subject = "Contact Portfolio - " . $name;
        $email_body = "
NOUVEAU MESSAGE DE CONTACT
Portfolio Samba SY

Nom : $name
Email : $email
Téléphone : $phone
Entreprise : $company
Sujet : $subject
Budget : $budget
Délai : $timeline

Message :
$message

Date : " . date('d/m/Y H:i:s') . "
        ";
        
        // Headers EXACTEMENT comme le test qui fonctionnait
        $headers = "From: Portfolio Samba SY <sambasy837@gmail.com>\r\n";
        $headers .= "Reply-To: $email\r\n";
        $headers .= "Content-Type: text/plain; charset=UTF-8\r\n";
        
        // Envoyer
        $result = mail($to, $email_subject, $email_body, $headers);
        
        // Redirection
        header("Location: contact_success_simple.php?name=" . urlencode($name));
        exit();
    }
}

// Redirection par défaut
header("Location: contact.html");
exit();
?>
