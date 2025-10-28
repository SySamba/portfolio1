# 📧 Système PHP de Formulaires - Portfolio Samba SY

## 🎯 Vue d'ensemble

Ce système PHP permet de traiter les formulaires de contact et de devis du portfolio, en envoyant automatiquement les informations par email à **sambasy837@gmail.com**.

## 📁 Fichiers créés

### Fichiers PHP principaux
- `process_contact.php` - Traitement du formulaire de contact
- `process_devis.php` - Traitement du formulaire de devis
- `config.php` - Configuration centralisée
- `contact_success.php` - Page de confirmation contact
- `devis_success.php` - Page de confirmation devis

### Fichiers modifiés
- `contact.html` - Formulaire configuré pour PHP
- `devis.html` - Formulaire configuré pour PHP

## ⚙️ Configuration requise

### Serveur web
- **PHP 7.4+** (recommandé PHP 8.0+)
- **Fonction mail()** activée
- **Sessions PHP** activées
- **Écriture** dans le dossier `logs/` (créé automatiquement)

### Hébergement recommandé
- **Hostinger** (support PHP complet)
- **OVH** (hébergement français)
- **1&1 IONOS** (support technique)
- **SiteGround** (performance optimisée)

## 🚀 Installation

### 1. Upload des fichiers
```bash
# Uploader tous les fichiers PHP sur votre serveur web
# Structure recommandée :
/public_html/
├── index.html
├── contact.html
├── devis.html
├── process_contact.php
├── process_devis.php
├── contact_success.php
├── devis_success.php
├── config.php
└── logs/ (créé automatiquement)
```

### 2. Configuration email
Ouvrir `config.php` et vérifier :
```php
define('EMAIL_TO', 'sambasy837@gmail.com');           // ✅ Déjà configuré
define('EMAIL_FROM_ADDRESS', 'noreply@sambasy.com');  // À adapter selon votre domaine
```

### 3. Test de la fonction mail()
Créer un fichier `test_mail.php` :
```php
<?php
if (mail('sambasy837@gmail.com', 'Test', 'Email de test')) {
    echo "✅ Email envoyé avec succès !";
} else {
    echo "❌ Erreur d'envoi email";
}
?>
```

## 🔧 Fonctionnalités

### Formulaire de Contact
- ✅ Validation côté serveur
- ✅ Protection anti-spam (honeypot)
- ✅ Email HTML formaté
- ✅ Page de confirmation
- ✅ Logging des soumissions

### Formulaire de Devis
- ✅ Validation avancée
- ✅ Email prioritaire
- ✅ Informations projet détaillées
- ✅ Page de confirmation animée
- ✅ Protection CSRF

### Sécurité
- 🛡️ **Honeypot** anti-spam
- 🛡️ **Validation** des données
- 🛡️ **Échappement HTML** 
- 🛡️ **Logging** des tentatives
- 🛡️ **Limitation** de taille

## 📧 Format des emails

### Email de Contact
```
📧 Nouveau Message de Contact
Portfolio Samba SY

👤 Nom : [Nom du visiteur]
📧 Email : [Email du visiteur]
📱 Téléphone : [Téléphone]
🏢 Entreprise : [Entreprise]
📋 Sujet : [Sujet sélectionné]
💰 Budget : [Budget estimé]
⏰ Délai : [Délai souhaité]
💬 Message : [Message complet]

Message reçu le [Date/Heure]
```

### Email de Devis
```
🎯 Nouvelle Demande de Devis
Portfolio Samba SY - Expert Data Science & IA

👤 Informations Client
Nom : [Nom complet]
Email : [Email]
Téléphone : [Téléphone]
Entreprise : [Entreprise ou Particulier]

🎯 Détails du Projet
Type : [Type de projet avec emoji]
Budget estimé : [Gamme de budget]
Délai souhaité : [Délai]

📝 Description du Projet
[Description complète]

⚡ Actions Recommandées
1. Répondre dans les 24h
2. Programmer un appel de découverte
3. Préparer une proposition détaillée
4. Envoyer des exemples de projets similaires
```

## 🐛 Dépannage

### Email non reçu
1. **Vérifier les spams** dans sambasy837@gmail.com
2. **Tester la fonction mail()** avec `test_mail.php`
3. **Vérifier les logs** dans `logs/submissions_YYYY-MM.log`
4. **Contacter l'hébergeur** pour la configuration SMTP

### Erreurs courantes
```php
// Erreur : Headers already sent
// Solution : Pas d'espaces avant <?php

// Erreur : Permission denied logs/
// Solution : chmod 755 sur le dossier logs/

// Erreur : mail() function disabled
// Solution : Activer mail() dans php.ini ou utiliser SMTP
```

### Configuration SMTP (alternative)
Si `mail()` ne fonctionne pas, utiliser PHPMailer :
```php
// Installer PHPMailer via Composer
composer require phpmailer/phpmailer

// Configuration SMTP dans config.php
define('SMTP_HOST', 'smtp.gmail.com');
define('SMTP_USERNAME', 'sambasy837@gmail.com');
define('SMTP_PASSWORD', 'mot_de_passe_app');
define('SMTP_PORT', 587);
```

## 📊 Monitoring

### Logs automatiques
- Fichier : `logs/submissions_YYYY-MM.log`
- Format : JSON avec timestamp, IP, user-agent
- Rotation : Mensuelle automatique

### Statistiques
```bash
# Compter les soumissions du mois
grep -c "contact" logs/submissions_2025-01.log
grep -c "devis" logs/submissions_2025-01.log
```

## 🔒 Sécurité en production

### Recommandations
1. **Désactiver** `display_errors` en production
2. **Limiter** les tentatives par IP
3. **Utiliser HTTPS** obligatoire
4. **Sauvegarder** les logs régulièrement
5. **Mettre à jour** PHP régulièrement

### Protection avancée
```php
// Dans .htaccess
<Files "config.php">
    Order allow,deny
    Deny from all
</Files>

<Files "logs/*">
    Order allow,deny
    Deny from all
</Files>
```

## 📞 Support

### Contact technique
- **Email** : sambasy837@gmail.com
- **Téléphone** : +221 77 378 48 14
- **LinkedIn** : [Samba SY](https://www.linkedin.com/in/samba-sy/)

### Ressources
- [Documentation PHP mail()](https://www.php.net/manual/fr/function.mail.php)
- [Guide sécurité PHP](https://www.php.net/manual/fr/security.php)
- [PHPMailer GitHub](https://github.com/PHPMailer/PHPMailer)

---

**✅ Système prêt à l'emploi !**  
Les formulaires sont maintenant opérationnels et enverront automatiquement les informations à **sambasy837@gmail.com** avec un design professionnel et une sécurité renforcée.
