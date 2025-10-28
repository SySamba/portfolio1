<?php
// Récupérer les informations depuis l'URL
$name = isset($_GET['name']) ? htmlspecialchars($_GET['name']) : 'Visiteur';
$project = isset($_GET['project']) ? htmlspecialchars($_GET['project']) : 'votre projet';

// Mapper les types de projets
$project_types = [
    'web' => '🌐 Site Web / E-commerce',
    'data' => '📊 Analyse de Données / BI',
    'ai' => '🤖 Intelligence Artificielle',
    'cloud' => '☁️ Cloud / DevOps',
    'mobile' => '📱 Application Mobile',
    'other' => '🔧 Autre'
];

$project_display = isset($project_types[$project]) ? $project_types[$project] : '🔧 ' . $project;
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Devis Demandé - Samba SY</title>
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
            background: linear-gradient(135deg, #4f46e5 0%, #06b6d4 100%);
            padding: 20px;
        }
        .success-card {
            background: white;
            border-radius: 20px;
            padding: 60px 40px;
            text-align: center;
            max-width: 700px;
            width: 100%;
            box-shadow: 0 25px 70px rgba(0,0,0,0.15);
            position: relative;
            overflow: hidden;
        }
        .success-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 6px;
            background: linear-gradient(90deg, #4f46e5, #06b6d4, #8b5cf6, #4f46e5);
            background-size: 300% 100%;
            animation: gradient 4s ease infinite;
        }
        @keyframes gradient {
            0%, 100% { background-position: 0% 50%; }
            50% { background-position: 100% 50%; }
        }
        .success-icon {
            font-size: 5.5rem;
            background: linear-gradient(135deg, #10b981, #059669);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            margin-bottom: 30px;
            animation: pulse 2s infinite;
        }
        @keyframes pulse {
            0%, 100% { transform: scale(1); }
            50% { transform: scale(1.05); }
        }
        .success-title {
            font-size: 2.8rem;
            background: linear-gradient(135deg, #1f2937, #374151);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            margin-bottom: 20px;
            font-weight: 800;
        }
        .success-subtitle {
            font-size: 1.3rem;
            color: #6b7280;
            margin-bottom: 40px;
            line-height: 1.6;
        }
        .project-info {
            background: linear-gradient(135deg, #f8fafc 0%, #e2e8f0 100%);
            border-radius: 15px;
            padding: 30px;
            margin-bottom: 40px;
            border-left: 6px solid #4f46e5;
            position: relative;
        }
        .project-info::before {
            content: '🎯';
            position: absolute;
            top: -10px;
            right: 20px;
            font-size: 2rem;
            background: white;
            padding: 5px 10px;
            border-radius: 50%;
            box-shadow: 0 4px 12px rgba(0,0,0,0.1);
        }
        .project-title {
            font-size: 1.4rem;
            color: #1f2937;
            margin-bottom: 15px;
            font-weight: 700;
        }
        .project-type {
            font-size: 1.5rem;
            color: #4f46e5;
            font-weight: 600;
            margin-bottom: 20px;
        }
        .timeline-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 20px;
            margin-bottom: 40px;
        }
        .timeline-item {
            background: white;
            padding: 25px 20px;
            border-radius: 12px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.08);
            border-top: 4px solid #10b981;
            transition: transform 0.3s ease;
        }
        .timeline-item:hover {
            transform: translateY(-5px);
        }
        .timeline-icon {
            font-size: 2rem;
            color: #4f46e5;
            margin-bottom: 15px;
        }
        .timeline-title {
            font-weight: 700;
            color: #1f2937;
            margin-bottom: 8px;
        }
        .timeline-desc {
            color: #6b7280;
            font-size: 0.95rem;
        }
        .btn-group {
            display: flex;
            gap: 20px;
            justify-content: center;
            flex-wrap: wrap;
            margin-bottom: 40px;
        }
        .btn {
            display: inline-flex;
            align-items: center;
            gap: 12px;
            padding: 16px 32px;
            border-radius: 12px;
            text-decoration: none;
            font-weight: 700;
            transition: all 0.3s ease;
            font-size: 1.1rem;
            position: relative;
            overflow: hidden;
        }
        .btn::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255,255,255,0.2), transparent);
            transition: left 0.5s;
        }
        .btn:hover::before {
            left: 100%;
        }
        .btn-primary {
            background: linear-gradient(135deg, #4f46e5 0%, #06b6d4 100%);
            color: white;
            box-shadow: 0 8px 25px rgba(79, 70, 229, 0.3);
        }
        .btn-primary:hover {
            transform: translateY(-3px);
            box-shadow: 0 12px 35px rgba(79, 70, 229, 0.4);
        }
        .btn-secondary {
            background: white;
            color: #4f46e5;
            border: 2px solid #4f46e5;
            box-shadow: 0 4px 15px rgba(0,0,0,0.1);
        }
        .btn-secondary:hover {
            background: #4f46e5;
            color: white;
            transform: translateY(-3px);
        }
        .contact-section {
            background: #f8fafc;
            border-radius: 15px;
            padding: 30px;
            border: 1px solid #e2e8f0;
        }
        .contact-title {
            color: #374151;
            margin-bottom: 20px;
            font-weight: 700;
        }
        .contact-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 20px;
        }
        .contact-item {
            display: flex;
            align-items: center;
            gap: 15px;
            padding: 15px;
            background: white;
            border-radius: 10px;
            transition: all 0.3s ease;
            text-decoration: none;
            color: inherit;
        }
        .contact-item:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(0,0,0,0.1);
        }
        .contact-icon {
            width: 50px;
            height: 50px;
            background: linear-gradient(135deg, #4f46e5, #06b6d4);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 1.2rem;
        }
        .contact-info h5 {
            margin: 0 0 5px 0;
            color: #1f2937;
            font-weight: 600;
        }
        .contact-info p {
            margin: 0;
            color: #6b7280;
            font-size: 0.95rem;
        }
        @media (max-width: 768px) {
            .success-card {
                padding: 40px 20px;
            }
            .success-title {
                font-size: 2.2rem;
            }
            .timeline-grid {
                grid-template-columns: 1fr;
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
                <i class="fas fa-rocket"></i>
            </div>
            
            <h1 class="success-title">Demande Reçue !</h1>
            
            <p class="success-subtitle">
                Merci <strong><?php echo $name; ?></strong> ! Votre demande de devis a été envoyée avec succès.
                Je vais analyser votre projet et vous proposer une solution sur mesure.
            </p>
            
            <div class="project-info">
                <div class="project-title">Votre Projet</div>
                <div class="project-type"><?php echo $project_display; ?></div>
                <p style="color: #6b7280; margin: 0;">
                    Je vais étudier attentivement votre demande et vous envoyer une proposition détaillée 
                    avec un devis personnalisé dans les plus brefs délais.
                </p>
            </div>
            
            <div class="timeline-grid">
                <div class="timeline-item">
                    <div class="timeline-icon">
                        <i class="fas fa-search"></i>
                    </div>
                    <div class="timeline-title">Analyse</div>
                    <div class="timeline-desc">Étude de vos besoins et faisabilité</div>
                </div>
                <div class="timeline-item">
                    <div class="timeline-icon">
                        <i class="fas fa-lightbulb"></i>
                    </div>
                    <div class="timeline-title">Conception</div>
                    <div class="timeline-desc">Élaboration de la solution optimale</div>
                </div>
                <div class="timeline-item">
                    <div class="timeline-icon">
                        <i class="fas fa-calculator"></i>
                    </div>
                    <div class="timeline-title">Devis</div>
                    <div class="timeline-desc">Proposition détaillée sous 24h</div>
                </div>
            </div>
            
            <div class="btn-group">
                <a href="index.html" class="btn btn-primary">
                    <i class="fas fa-home"></i>
                    Retour à l'Accueil
                </a>
                <a href="projects.html" class="btn btn-secondary">
                    <i class="fas fa-eye"></i>
                    Voir mes Projets
                </a>
            </div>
            
            <div class="contact-section">
                <h4 class="contact-title">Restons en Contact</h4>
                <div class="contact-grid">
                    <a href="tel:+221773784814" class="contact-item">
                        <div class="contact-icon">
                            <i class="fas fa-phone"></i>
                        </div>
                        <div class="contact-info">
                            <h5>Téléphone</h5>
                            <p>+221 77 378 48 14</p>
                        </div>
                    </a>
                    <a href="mailto:sambasy837@gmail.com" class="contact-item">
                        <div class="contact-icon">
                            <i class="fas fa-envelope"></i>
                        </div>
                        <div class="contact-info">
                            <h5>Email</h5>
                            <p>sambasy837@gmail.com</p>
                        </div>
                    </a>
                </div>
            </div>
        </div>
    </div>
    
    <script>
        // Animation d'entrée
        document.addEventListener('DOMContentLoaded', function() {
            const card = document.querySelector('.success-card');
            const items = document.querySelectorAll('.timeline-item');
            
            card.style.opacity = '0';
            card.style.transform = 'translateY(40px)';
            
            setTimeout(() => {
                card.style.transition = 'all 0.8s ease';
                card.style.opacity = '1';
                card.style.transform = 'translateY(0)';
            }, 100);
            
            // Animation des éléments timeline
            items.forEach((item, index) => {
                item.style.opacity = '0';
                item.style.transform = 'translateY(20px)';
                
                setTimeout(() => {
                    item.style.transition = 'all 0.6s ease';
                    item.style.opacity = '1';
                    item.style.transform = 'translateY(0)';
                }, 600 + (index * 200));
            });
        });
        
        // Confetti effect (optionnel)
        function createConfetti() {
            const colors = ['#4f46e5', '#06b6d4', '#10b981', '#f59e0b', '#ef4444'];
            for (let i = 0; i < 50; i++) {
                const confetti = document.createElement('div');
                confetti.style.position = 'fixed';
                confetti.style.left = Math.random() * 100 + 'vw';
                confetti.style.top = '-10px';
                confetti.style.width = '10px';
                confetti.style.height = '10px';
                confetti.style.backgroundColor = colors[Math.floor(Math.random() * colors.length)];
                confetti.style.pointerEvents = 'none';
                confetti.style.zIndex = '9999';
                confetti.style.borderRadius = '50%';
                
                document.body.appendChild(confetti);
                
                const animation = confetti.animate([
                    { transform: 'translateY(0) rotate(0deg)', opacity: 1 },
                    { transform: `translateY(100vh) rotate(${Math.random() * 360}deg)`, opacity: 0 }
                ], {
                    duration: Math.random() * 3000 + 2000,
                    easing: 'cubic-bezier(0.25, 0.46, 0.45, 0.94)'
                });
                
                animation.onfinish = () => confetti.remove();
            }
        }
        
        // Lancer les confettis après 1 seconde
        setTimeout(createConfetti, 1000);
    </script>
</body>
</html>
