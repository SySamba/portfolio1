<?php
// Version simplifiée de la page de succès
$name = isset($_GET['name']) ? htmlspecialchars($_GET['name']) : 'Visiteur';
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Message Envoyé - Samba SY</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            margin: 0;
            padding: 20px;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .success-card {
            background: white;
            border-radius: 15px;
            padding: 40px;
            text-align: center;
            max-width: 500px;
            width: 100%;
            box-shadow: 0 20px 40px rgba(0,0,0,0.1);
        }
        .success-icon {
            font-size: 4rem;
            color: #10b981;
            margin-bottom: 20px;
            animation: bounce 2s infinite;
        }
        @keyframes bounce {
            0%, 20%, 50%, 80%, 100% { transform: translateY(0); }
            40% { transform: translateY(-10px); }
            60% { transform: translateY(-5px); }
        }
        .success-title {
            font-size: 2rem;
            color: #1f2937;
            margin-bottom: 15px;
            font-weight: 700;
        }
        .success-message {
            font-size: 1.1rem;
            color: #6b7280;
            margin-bottom: 30px;
            line-height: 1.6;
        }
        .info-box {
            background: #f8fafc;
            border-radius: 10px;
            padding: 20px;
            margin-bottom: 30px;
            border-left: 4px solid #10b981;
        }
        .info-item {
            display: flex;
            align-items: center;
            margin-bottom: 10px;
            font-size: 1rem;
        }
        .info-item:last-child {
            margin-bottom: 0;
        }
        .info-icon {
            color: #667eea;
            margin-right: 10px;
            width: 20px;
        }
        .btn-group {
            display: flex;
            gap: 15px;
            justify-content: center;
            flex-wrap: wrap;
        }
        .btn {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 12px 24px;
            border-radius: 8px;
            text-decoration: none;
            font-weight: 600;
            transition: all 0.3s ease;
        }
        .btn-primary {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
        }
        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(102, 126, 234, 0.3);
        }
        .btn-secondary {
            background: white;
            color: #667eea;
            border: 2px solid #667eea;
        }
        .btn-secondary:hover {
            background: #667eea;
            color: white;
        }
        .contact-info {
            margin-top: 30px;
            padding-top: 20px;
            border-top: 1px solid #e5e7eb;
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
            gap: 5px;
            color: #6b7280;
            text-decoration: none;
            transition: color 0.3s;
        }
        .contact-link:hover {
            color: #667eea;
        }
        @media (max-width: 768px) {
            .success-card {
                padding: 30px 20px;
            }
            .success-title {
                font-size: 1.5rem;
            }
            .btn-group {
                flex-direction: column;
                align-items: center;
            }
            .btn {
                width: 100%;
                max-width: 250px;
                justify-content: center;
            }
        }
    </style>
</head>
<body>
    <div class="success-card">
        <div class="success-icon">✅</div>
        
        <h1 class="success-title">Message Envoyé !</h1>
        
        <p class="success-message">
            Merci <strong><?php echo $name; ?></strong> pour votre message.<br>
            Je l'ai bien reçu et je vous répondrai dans les plus brefs délais.
        </p>
        
        <div class="info-box">
            <div class="info-item">
                <span class="info-icon">⏰</span>
                <span><strong>Délai de réponse :</strong> Sous 24 heures</span>
            </div>
            <div class="info-item">
                <span class="info-icon">📧</span>
                <span><strong>Réponse par :</strong> Email</span>
            </div>
            <div class="info-item">
                <span class="info-icon">🔒</span>
                <span><strong>Confidentialité :</strong> Vos données sont protégées</span>
            </div>
        </div>
        
        <div class="btn-group">
            <a href="index.html" class="btn btn-primary">
                🏠 Retour à l'Accueil
            </a>
            <a href="devis.html" class="btn btn-secondary">
                💰 Demander un Devis
            </a>
        </div>
        
        <div class="contact-info">
            <h4 style="color: #374151; margin-bottom: 15px;">Besoin d'une réponse urgente ?</h4>
            <div class="contact-links">
                <a href="tel:+221773784814" class="contact-link">
                    📱 +221 77 378 48 14
                </a>
                <a href="mailto:sambasy837@gmail.com" class="contact-link">
                    📧 sambasy837@gmail.com
                </a>
            </div>
        </div>
    </div>
    
    <script>
        // Animation d'entrée
        document.addEventListener('DOMContentLoaded', function() {
            const card = document.querySelector('.success-card');
            card.style.opacity = '0';
            card.style.transform = 'translateY(20px)';
            
            setTimeout(() => {
                card.style.transition = 'all 0.5s ease';
                card.style.opacity = '1';
                card.style.transform = 'translateY(0)';
            }, 100);
        });
    </script>
</body>
</html>
