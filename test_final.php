<?php
/**
 * Test final du formulaire de contact
 */
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Test Final - Formulaire de Contact</title>
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
            border-left: 4px solid #667eea;
        }
        .form-group {
            margin-bottom: 20px;
        }
        .form-group label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
            color: #374151;
        }
        .form-group input,
        .form-group select,
        .form-group textarea {
            width: 100%;
            padding: 12px;
            border: 1px solid #d1d5db;
            border-radius: 6px;
            font-size: 16px;
            box-sizing: border-box;
        }
        .form-group input:focus,
        .form-group select:focus,
        .form-group textarea:focus {
            outline: none;
            border-color: #667eea;
            box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
        }
        .btn-submit {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 15px 30px;
            border: none;
            border-radius: 8px;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
        }
        .btn-submit:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(102, 126, 234, 0.3);
        }
        .status {
            padding: 15px;
            border-radius: 8px;
            margin-bottom: 20px;
        }
        .status.success {
            background: #d1f2eb;
            color: #0f5132;
            border-left: 4px solid #198754;
        }
        .status.info {
            background: #cff4fc;
            color: #055160;
            border-left: 4px solid #0dcaf0;
        }
        h1, h2, h3 {
            color: #1f2937;
        }
        .required {
            color: #dc3545;
        }
    </style>
</head>
<body>
    <div class="test-container">
        <h1>🧪 Test Final - Formulaire de Contact</h1>
        
        <div class="status success">
            <strong>✅ Statut des tests précédents :</strong><br>
            • Fonction mail() : ✅ Fonctionne<br>
            • Réception emails : ✅ Confirmée (inbox + spam)<br>
            • Page de succès : ✅ Opérationnelle
        </div>
        
        <div class="status info">
            <strong>🎯 Test final :</strong><br>
            Ce formulaire utilise maintenant <code>process_contact_fixed.php</code> - version corrigée et simplifiée.<br>
            Après soumission, vous devriez être redirigé vers la page de succès ET recevoir l'email.
        </div>
        
        <h2>Formulaire de Test</h2>
        <div class="test-form">
            <form action="process_contact_fixed.php" method="POST">
                <div class="form-group">
                    <label for="name">Nom Complet <span class="required">*</span></label>
                    <input type="text" id="name" name="name" value="Test Final User" required>
                </div>
                
                <div class="form-group">
                    <label for="email">Email <span class="required">*</span></label>
                    <input type="email" id="email" name="email" value="test.final@example.com" required>
                </div>
                
                <div class="form-group">
                    <label for="phone">Téléphone</label>
                    <input type="tel" id="phone" name="phone" value="+221 77 123 45 67">
                </div>
                
                <div class="form-group">
                    <label for="company">Entreprise</label>
                    <input type="text" id="company" name="company" value="Test Company Final">
                </div>
                
                <div class="form-group">
                    <label for="subject">Sujet <span class="required">*</span></label>
                    <select id="subject" name="subject" required>
                        <option value="">Sélectionnez un sujet</option>
                        <option value="ia" selected>Projet Intelligence Artificielle</option>
                        <option value="cloud">Solution Cloud & DevOps</option>
                        <option value="data">Data Analytics & BI</option>
                        <option value="web">Développement Web</option>
                        <option value="consultation">Consultation</option>
                        <option value="autre">Autre</option>
                    </select>
                </div>
                
                <div class="form-group">
                    <label for="budget">Budget Estimé</label>
                    <select id="budget" name="budget">
                        <option value="">Sélectionnez votre budget</option>
                        <option value="< 500k">Moins de 500 000 FCFA</option>
                        <option value="500k-1M" selected>500 000 - 1 000 000 FCFA</option>
                        <option value="1M-2M">1 000 000 - 2 000 000 FCFA</option>
                        <option value="2M-5M">2 000 000 - 5 000 000 FCFA</option>
                        <option value="> 5M">Plus de 5 000 000 FCFA</option>
                    </select>
                </div>
                
                <div class="form-group">
                    <label for="timeline">Délai Souhaité</label>
                    <select id="timeline" name="timeline">
                        <option value="">Sélectionnez un délai</option>
                        <option value="urgent">Urgent (< 1 mois)</option>
                        <option value="court" selected>Court terme (1-3 mois)</option>
                        <option value="moyen">Moyen terme (3-6 mois)</option>
                        <option value="long">Long terme (> 6 mois)</option>
                    </select>
                </div>
                
                <div class="form-group">
                    <label for="message">Message <span class="required">*</span></label>
                    <textarea id="message" name="message" rows="6" required>Ceci est un message de test final pour vérifier que le formulaire de contact fonctionne parfaitement. 

Je souhaite développer une solution d'intelligence artificielle pour mon entreprise et j'aimerais discuter des possibilités avec vous.

Merci pour votre temps et votre expertise !</textarea>
                </div>
                
                <button type="submit" class="btn-submit">
                    🚀 Envoyer le Message de Test Final
                </button>
            </form>
        </div>
        
        <h3>Résultat attendu :</h3>
        <ul>
            <li>✅ Redirection vers <code>contact_success_simple.php</code></li>
            <li>✅ Page de succès avec animation</li>
            <li>✅ Email reçu dans sambasy837@gmail.com (ou spam)</li>
            <li>✅ Email avec design professionnel et toutes les informations</li>
        </ul>
        
        <p><a href="contact.html" style="color: #667eea; text-decoration: none;">← Retour au formulaire de contact réel</a></p>
    </div>
</body>
</html>
