<?php
// Récupérer le nom depuis l'URL
$name = isset($_GET['name']) ? htmlspecialchars($_GET['name']) : 'Visiteur';
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Message Envoyé - Samba SY</title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/pages.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        .success-container {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            padding: 20px;
        }
        .success-card {
            background: white;
            border-radius: 20px;
            padding: 60px 40px;
            text-align: center;
            max-width: 600px;
            width: 100%;
            box-shadow: 0 20px 60px rgba(0,0,0,0.1);
            position: relative;
            overflow: hidden;
        }
        .success-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 5px;
            background: linear-gradient(90deg, #667eea, #764ba2, #667eea);
            background-size: 200% 100%;
            animation: gradient 3s ease infinite;
        }
        @keyframes gradient {
            0%, 100% { background-position: 0% 50%; }
            50% { background-position: 100% 50%; }
        }
        .success-icon {
            font-size: 5rem;
            color: #10b981;
            margin-bottom: 30px;
            animation: bounce 2s infinite;
        }
        @keyframes bounce {
            0%, 20%, 50%, 80%, 100% { transform: translateY(0); }
            40% { transform: translateY(-10px); }
            60% { transform: translateY(-5px); }
        }
        .success-title {
            font-size: 2.5rem;
            color: #1f2937;
            margin-bottom: 20px;
            font-weight: 700;
        }
        .success-message {
            font-size: 1.2rem;
            color: #6b7280;
            margin-bottom: 40px;
            line-height: 1.6;
        }
        .success-details {
            background: #f8fafc;
            border-radius: 12px;
            padding: 30px;
            margin-bottom: 40px;
            border-left: 5px solid #10b981;
        }
        .detail-item {
            display: flex;
            align-items: center;
            margin-bottom: 15px;
            font-size: 1.1rem;
        }
        .detail-item:last-child {
            margin-bottom: 0;
        }
        .detail-icon {
            color: #667eea;
            margin-right: 15px;
            width: 20px;
        }
        .btn-group {
            display: flex;
            gap: 20px;
            justify-content: center;
            flex-wrap: wrap;
        }
        .btn {
            display: inline-flex;
            align-items: center;
            gap: 10px;
            padding: 15px 30px;
            border-radius: 10px;
            text-decoration: none;
            font-weight: 600;
            transition: all 0.3s ease;
            font-size: 1.1rem;
        }
        .btn-primary {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
        }
        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 25px rgba(102, 126, 234, 0.3);
        }
        .btn-secondary {
            background: white;
            color: #667eea;
            border: 2px solid #667eea;
        }
        .btn-secondary:hover {
            background: #667eea;
            color: white;
            transform: translateY(-2px);
        }
        .contact-info {
            margin-top: 40px;
            padding-top: 30px;
            border-top: 1px solid #e5e7eb;
        }
        .contact-info h4 {
            color: #374151;
            margin-bottom: 15px;
        }
        .contact-links {
            display: flex;
            justify-content: center;
            gap: 20px;
            flex-wrap: wrap;
        }
        .contact-link {
            display: flex;
            align-items: center;
            gap: 8px;
            color: #6b7280;
            text-decoration: none;
            transition: color 0.3s;
        }
        .contact-link:hover {
            color: #667eea;
        }
        @media (max-width: 768px) {
            .success-card {
                padding: 40px 20px;
            }
            .success-title {
                font-size: 2rem;
            }
            .btn-group {
                flex-direction: column;
                align-items: center;
            }
            .btn {
                width: 100%;
                max-width: 300px;
                justify-content: center;
            }
        }
    </style>
</head>
<body>
    <div class="success-container">
        <div class="success-card">
            <div class="success-icon">
                <i class="fas fa-check-circle"></i>
            </div>
            
            <h1 class="success-title">Message Envoyé !</h1>
            
            <p class="success-message">
                Merci <strong><?php echo $name; ?></strong> pour votre message. 
                Je l'ai bien reçu et je vous répondrai dans les plus brefs délais.
            </p>
            
            <div class="success-details">
                <div class="detail-item">
                    <i class="fas fa-clock detail-icon"></i>
                    <span><strong>Délai de réponse :</strong> Sous 24 heures</span>
                </div>
                <div class="detail-item">
                    <i class="fas fa-envelope detail-icon"></i>
                    <span><strong>Réponse par :</strong> Email</span>
                </div>
                <div class="detail-item">
                    <i class="fas fa-shield-alt detail-icon"></i>
                    <span><strong>Confidentialité :</strong> Vos données sont protégées</span>
                </div>
            </div>
            
            <div class="btn-group">
                <a href="index.html" class="btn btn-primary">
                    <i class="fas fa-home"></i>
                    Retour à l'Accueil
                </a>
                <a href="devis.html" class="btn btn-secondary">
                    <i class="fas fa-calculator"></i>
                    Demander un Devis
                </a>
            </div>
            
            <div class="contact-info">
                <h4>Besoin d'une réponse urgente ?</h4>
                <div class="contact-links">
                    <a href="tel:+221773784814" class="contact-link">
                        <i class="fas fa-phone"></i>
                        +221 77 378 48 14
                    </a>
                    <a href="mailto:sambasy837@gmail.com" class="contact-link">
                        <i class="fas fa-envelope"></i>
                        sambasy837@gmail.com
                    </a>
                </div>
            </div>
        </div>
    </div>
    
    <script>
        // Animation d'entrée
        document.addEventListener('DOMContentLoaded', function() {
            const card = document.querySelector('.success-card');
            card.style.opacity = '0';
            card.style.transform = 'translateY(30px)';
            
            setTimeout(() => {
                card.style.transition = 'all 0.6s ease';
                card.style.opacity = '1';
                card.style.transform = 'translateY(0)';
            }, 100);
        });
        
        // Redirection automatique après 30 secondes (optionnel)
        setTimeout(() => {
            if (confirm('Souhaitez-vous être redirigé vers la page d\'accueil ?')) {
                window.location.href = 'index.html';
            }
        }, 30000);
    </script>
</body>
</html>
