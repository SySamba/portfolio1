// Navigation mobile
const hamburger = document.querySelector('.hamburger');
const navMenu = document.querySelector('.nav-menu');

hamburger.addEventListener('click', () => {
    hamburger.classList.toggle('active');
    navMenu.classList.toggle('active');
});

// Fermer le menu mobile lors du clic sur un lien
document.querySelectorAll('.nav-link').forEach(n => n.addEventListener('click', () => {
    hamburger.classList.remove('active');
    navMenu.classList.remove('active');
}));

// Fonction pour mettre en évidence la page active
function highlightActivePage() {
    const currentPage = window.location.pathname.split('/').pop() || 'index.html';
    const navLinks = document.querySelectorAll('.nav-link');
    
    navLinks.forEach(link => {
        link.classList.remove('active');
        const href = link.getAttribute('href');
        
        // Vérifier si c'est la page d'accueil
        if ((currentPage === 'index.html' || currentPage === '') && 
            (href === 'index.html' || href === '#home' || href === '/')) {
            link.classList.add('active');
        }
        // Vérifier les autres pages
        else if (href && href.includes(currentPage)) {
            link.classList.add('active');
        }
        // Cas spécial pour les liens avec ancres sur la page d'accueil
        else if (currentPage === 'index.html' && href.startsWith('#')) {
            // Ne pas marquer comme actif les liens d'ancrage
        }
    });
}

// Appeler la fonction au chargement de la page
document.addEventListener('DOMContentLoaded', highlightActivePage);

// Effet 3D interactif pour l'image de profil
document.addEventListener('DOMContentLoaded', function() {
    const profileImage = document.querySelector('.profile-image-hero');
    const profileContainer = document.querySelector('.profile-container');
    
    if (profileImage && profileContainer) {
        // Effet de suivi de la souris
        profileContainer.addEventListener('mousemove', function(e) {
            const rect = profileContainer.getBoundingClientRect();
            const centerX = rect.left + rect.width / 2;
            const centerY = rect.top + rect.height / 2;
            
            const mouseX = e.clientX - centerX;
            const mouseY = e.clientY - centerY;
            
            const rotateX = (mouseY / rect.height) * 30;
            const rotateY = (mouseX / rect.width) * 30;
            
            profileImage.style.transform = `
                rotateX(${15 - rotateX}deg) 
                rotateY(${-15 + rotateY}deg) 
                scale(1.02)
            `;
        });
        
        // Retour à la position normale
        profileContainer.addEventListener('mouseleave', function() {
            profileImage.style.transform = 'rotateX(15deg) rotateY(-15deg) scale(1)';
        });
        
        // Effet de clic pour rotation complète
        profileImage.addEventListener('click', function() {
            profileImage.style.animation = 'none';
            profileImage.style.transform = 'rotateX(0deg) rotateY(360deg) scale(1.1)';
            
            setTimeout(() => {
                profileImage.style.animation = 'float3D 8s ease-in-out infinite, glow3D 4s ease-in-out infinite alternate';
                profileImage.style.transform = 'rotateX(15deg) rotateY(-15deg) scale(1)';
            }, 800);
        });
    }
});

// Animation des barres de compétences
const observerOptions = {
    threshold: 0.5,
    rootMargin: '0px 0px -100px 0px'
};

const skillsObserver = new IntersectionObserver((entries) => {
    entries.forEach(entry => {
        if (entry.isIntersecting) {
            const skillBars = entry.target.querySelectorAll('.skill-progress');
            skillBars.forEach(bar => {
                const width = bar.getAttribute('data-width');
                setTimeout(() => {
                    bar.style.width = width + '%';
                }, 200);
            });
        }
    });
}, observerOptions);

// Observer pour les compétences
const skillsSection = document.querySelector('.skills');
if (skillsSection) {
    skillsObserver.observe(skillsSection);
}

// Animation d'apparition des éléments
const fadeObserver = new IntersectionObserver((entries) => {
    entries.forEach(entry => {
        if (entry.isIntersecting) {
            entry.target.classList.add('fade-in-up');
        }
    });
}, {
    threshold: 0.1,
    rootMargin: '0px 0px -50px 0px'
});

// Appliquer l'animation aux cartes de service et projets
document.querySelectorAll('.service-card, .project-card, .skill-category').forEach(el => {
    fadeObserver.observe(el);
});

// Effet de parallaxe pour le hero
window.addEventListener('scroll', () => {
    const scrolled = window.pageYOffset;
    const parallax = document.querySelector('.ai-visual');
    if (parallax) {
        const speed = scrolled * 0.5;
        parallax.style.transform = `translateY(${speed}px)`;
    }
});

// Navigation smooth scroll
document.querySelectorAll('a[href^="#"]').forEach(anchor => {
    anchor.addEventListener('click', function (e) {
        e.preventDefault();
        const target = document.querySelector(this.getAttribute('href'));
        if (target) {
            target.scrollIntoView({
                behavior: 'smooth',
                block: 'start'
            });
        }
    });
});

// Effet de typing pour le titre
function typeWriter(element, text, speed = 100) {
    let i = 0;
    element.innerHTML = '';
    
    function type() {
        if (i < text.length) {
            element.innerHTML += text.charAt(i);
            i++;
            setTimeout(type, speed);
        }
    }
    type();
}

// Initialiser l'effet de typing au chargement
window.addEventListener('load', () => {
    const heroTitle = document.querySelector('.hero-title');
    if (heroTitle) {
        const originalText = heroTitle.textContent;
        typeWriter(heroTitle, originalText, 50);
    }
});

// Effet de particules animées
class ParticleSystem {
    constructor(canvas) {
        this.canvas = canvas;
        this.ctx = canvas.getContext('2d');
        this.particles = [];
        this.particleCount = 50;
        
        this.resize();
        this.init();
        this.animate();
        
        window.addEventListener('resize', () => this.resize());
    }
    
    resize() {
        this.canvas.width = window.innerWidth;
        this.canvas.height = window.innerHeight;
    }
    
    init() {
        for (let i = 0; i < this.particleCount; i++) {
            this.particles.push({
                x: Math.random() * this.canvas.width,
                y: Math.random() * this.canvas.height,
                vx: (Math.random() - 0.5) * 0.5,
                vy: (Math.random() - 0.5) * 0.5,
                size: Math.random() * 2 + 1,
                opacity: Math.random() * 0.5 + 0.2
            });
        }
    }
    
    animate() {
        this.ctx.clearRect(0, 0, this.canvas.width, this.canvas.height);
        
        this.particles.forEach(particle => {
            particle.x += particle.vx;
            particle.y += particle.vy;
            
            if (particle.x < 0 || particle.x > this.canvas.width) particle.vx *= -1;
            if (particle.y < 0 || particle.y > this.canvas.height) particle.vy *= -1;
            
            this.ctx.beginPath();
            this.ctx.arc(particle.x, particle.y, particle.size, 0, Math.PI * 2);
            this.ctx.fillStyle = `rgba(99, 102, 241, ${particle.opacity})`;
            this.ctx.fill();
        });
        
        requestAnimationFrame(() => this.animate());
    }
}

// Initialiser le système de particules si canvas existe
document.addEventListener('DOMContentLoaded', () => {
    const canvas = document.getElementById('particles');
    if (canvas) {
        new ParticleSystem(canvas);
    }
});

// Effet de survol pour les cartes de projet
document.querySelectorAll('.project-card').forEach(card => {
    card.addEventListener('mouseenter', function() {
        this.style.transform = 'translateY(-10px) scale(1.02)';
    });
    
    card.addEventListener('mouseleave', function() {
        this.style.transform = 'translateY(0) scale(1)';
    });
});

// Animation des statistiques du hero
function animateStats() {
    const stats = document.querySelectorAll('.stat h3');
    stats.forEach(stat => {
        const finalValue = stat.textContent;
        if (!isNaN(finalValue)) {
            let currentValue = 0;
            const increment = finalValue / 50;
            const timer = setInterval(() => {
                currentValue += increment;
                if (currentValue >= finalValue) {
                    currentValue = finalValue;
                    clearInterval(timer);
                }
                stat.textContent = Math.floor(currentValue) + '+';
            }, 50);
        }
    });
}

// Observer pour déclencher l'animation des stats
const statsObserver = new IntersectionObserver((entries) => {
    entries.forEach(entry => {
        if (entry.isIntersecting) {
            animateStats();
            statsObserver.unobserve(entry.target);
        }
    });
}, { threshold: 0.5 });

const heroStats = document.querySelector('.hero-stats');
if (heroStats) {
    statsObserver.observe(heroStats);
}

// Effet de glow sur les boutons
document.querySelectorAll('.btn-primary, .btn-secondary').forEach(btn => {
    btn.addEventListener('mouseenter', function() {
        this.style.boxShadow = '0 0 30px rgba(99, 102, 241, 0.5)';
    });
    
    btn.addEventListener('mouseleave', function() {
        this.style.boxShadow = '';
    });
});

// Navbar transparente au scroll
let lastScrollTop = 0;
window.addEventListener('scroll', () => {
    const navbar = document.querySelector('.navbar');
    const scrollTop = window.pageYOffset || document.documentElement.scrollTop;
    
    if (scrollTop > lastScrollTop && scrollTop > 100) {
        // Scroll vers le bas
        navbar.style.transform = 'translateY(-100%)';
    } else {
        // Scroll vers le haut
        navbar.style.transform = 'translateY(0)';
    }
    
    // Changer l'opacité selon la position
    if (scrollTop > 50) {
        navbar.style.background = 'rgba(15, 15, 35, 0.98)';
    } else {
        navbar.style.background = 'rgba(15, 15, 35, 0.95)';
    }
    
    lastScrollTop = scrollTop;
});

// Formulaire de contact (pour les pages futures)
function handleContactForm() {
    const form = document.getElementById('contact-form');
    if (form) {
        form.addEventListener('submit', function(e) {
            e.preventDefault();
            
            // Animation de soumission
            const submitBtn = form.querySelector('button[type="submit"]');
            const originalText = submitBtn.textContent;
            
            submitBtn.textContent = 'Envoi en cours...';
            submitBtn.disabled = true;
            
            // Simuler l'envoi (remplacer par vraie logique)
            setTimeout(() => {
                submitBtn.textContent = 'Message envoyé !';
                submitBtn.style.background = '#10b981';
                
                setTimeout(() => {
                    submitBtn.textContent = originalText;
                    submitBtn.disabled = false;
                    submitBtn.style.background = '';
                    form.reset();
                }, 2000);
            }, 1500);
        });
    }
}

// Initialiser le formulaire
document.addEventListener('DOMContentLoaded', handleContactForm);

// Effet de machine à écrire pour les descriptions
function typeWriterEffect(element, text, speed = 50) {
    element.textContent = '';
    let i = 0;
    
    function type() {
        if (i < text.length) {
            element.textContent += text.charAt(i);
            i++;
            setTimeout(type, speed);
        }
    }
    
    type();
}

// Appliquer l'effet aux éléments visibles
const typeObserver = new IntersectionObserver((entries) => {
    entries.forEach(entry => {
        if (entry.isIntersecting && !entry.target.classList.contains('typed')) {
            const text = entry.target.getAttribute('data-text') || entry.target.textContent;
            typeWriterEffect(entry.target, text);
            entry.target.classList.add('typed');
        }
    });
}, { threshold: 0.5 });

// Observer les éléments avec classe .type-effect
document.querySelectorAll('.type-effect').forEach(el => {
    typeObserver.observe(el);
});

// Preloader
window.addEventListener('load', () => {
    const preloader = document.querySelector('.preloader');
    if (preloader) {
        preloader.style.opacity = '0';
        setTimeout(() => {
            preloader.style.display = 'none';
        }, 500);
    }
});

// Effet de cursor personnalisé
document.addEventListener('mousemove', (e) => {
    const cursor = document.querySelector('.custom-cursor');
    if (cursor) {
        cursor.style.left = e.clientX + 'px';
        cursor.style.top = e.clientY + 'px';
    }
});

// Gestion des liens externes
document.querySelectorAll('a[href^="http"]').forEach(link => {
    link.setAttribute('target', '_blank');
    link.setAttribute('rel', 'noopener noreferrer');
});

// Animation des icônes au survol
document.querySelectorAll('.service-icon, .social-links a').forEach(icon => {
    icon.addEventListener('mouseenter', function() {
        this.style.transform = 'scale(1.1) rotate(5deg)';
    });
    
    icon.addEventListener('mouseleave', function() {
        this.style.transform = 'scale(1) rotate(0deg)';
    });
});

// Lazy loading pour les images
const imageObserver = new IntersectionObserver((entries) => {
    entries.forEach(entry => {
        if (entry.isIntersecting) {
            const img = entry.target;
            img.src = img.dataset.src;
            img.classList.remove('lazy');
            imageObserver.unobserve(img);
        }
    });
});

document.querySelectorAll('img[data-src]').forEach(img => {
    imageObserver.observe(img);
});

// Fonction utilitaire pour débouncer les événements
function debounce(func, wait) {
    let timeout;
    return function executedFunction(...args) {
        const later = () => {
            clearTimeout(timeout);
            func(...args);
        };
        clearTimeout(timeout);
        timeout = setTimeout(later, wait);
    };
}

// Optimiser le scroll
const optimizedScroll = debounce(() => {
    // Logique de scroll optimisée
}, 10);

window.addEventListener('scroll', optimizedScroll);

// Chat Widget Functionality
class ChatBot {
    constructor() {
        this.chatToggle = document.getElementById('chat-toggle');
        this.chatWindow = document.getElementById('chat-window');
        this.chatClose = document.getElementById('chat-close');
        this.chatMessages = document.getElementById('chat-messages');
        this.chatInput = document.getElementById('chat-input');
        this.chatSend = document.getElementById('chat-send');
        this.chatNotification = document.getElementById('chat-notification');
        this.quickBtns = document.querySelectorAll('.quick-btn');
        
        this.responses = {
            greeting: [
                "Salut ! 👋 Comment puis-je vous aider aujourd'hui ?",
                "Bonjour ! Je suis là pour répondre à vos questions sur les services de Samba SY.",
                "Hello ! Que puis-je faire pour vous ?"
            ],
            services: [
                "Samba SY propose plusieurs services :\n🤖 Intelligence Artificielle & Machine Learning\n☁️ Solutions Cloud AWS & DevOps\n📊 Data Analytics & Business Intelligence\n💻 Développement Full Stack\n\nQuel service vous intéresse le plus ?",
                "Nos expertises couvrent l'IA, le Cloud, l'analyse de données et le développement web. Souhaitez-vous plus de détails sur un domaine particulier ?"
            ],
            ia: [
                "En Intelligence Artificielle, Samba SY développe :\n• Modèles de Machine Learning personnalisés\n• Solutions de Computer Vision\n• Systèmes de NLP et chatbots\n• Analyses prédictives\n• Systèmes de recommandation\n\nAvez-vous un projet IA en tête ?",
                "L'expertise IA inclut le développement de modèles ML/DL, la vision par ordinateur, et le traitement du langage naturel. Quel type de solution IA recherchez-vous ?"
            ],
            cloud: [
                "Pour le Cloud & DevOps :\n• Architecture cloud AWS\n• Migration vers le cloud\n• CI/CD et automatisation\n• Infrastructure as Code\n• Containerisation Docker/Kubernetes\n• Monitoring et sécurité\n\nBesoin d'aide pour votre infrastructure ?",
                "Les services Cloud incluent l'architecture AWS, la migration, l'automatisation CI/CD et la containerisation. Quel est votre défi cloud actuel ?"
            ],
            data: [
                "En Data Analytics :\n• Tableaux de bord interactifs\n• Analyse prédictive\n• ETL et pipelines de données\n• Data Warehouse\n• Visualisation avancée\n• Business Intelligence\n\nQuelles données souhaitez-vous analyser ?",
                "L'expertise data couvre la BI, les tableaux de bord, l'analyse prédictive et les pipelines ETL. Quel type d'analyse vous intéresse ?"
            ],
            devis: [
                "Pour un devis personnalisé :\n1. Décrivez votre projet\n2. Précisez vos besoins techniques\n3. Indiquez votre timeline\n\n📧 Contact : sambasy837@gmail.com\n📱 WhatsApp : +221 77 378 48 14\n\nOu utilisez le formulaire de devis sur le site !",
                "Je peux vous orienter vers la page de devis ! Vous y trouverez un formulaire détaillé pour décrire votre projet. Samba SY vous répondra rapidement avec une proposition personnalisée."
            ],
            projets: [
                "Quelques projets phares de Samba SY :\n🔍 Détection de Fake News avec IA\n📊 Prédiction du Diabète (ML)\n📈 Dashboard COVID-19 interactif\n🌐 Sites web e-commerce\n☁️ Solutions cloud AWS\n\nVoulez-vous plus de détails sur un projet ?",
                "Le portfolio inclut des projets d'IA, d'analyse de données, de développement web et de solutions cloud. Quel type de projet vous inspire ?"
            ],
            contact: [
                "Contactez Samba SY :\n📧 Email : sambasy837@gmail.com\n📱 Téléphone : +221 77 378 48 14\n📍 Localisation : Dakar, Sénégal\n💼 LinkedIn : linkedin.com/in/samba-sy\n\nN'hésitez pas à prendre contact !",
                "Vous pouvez joindre Samba SY par email, téléphone ou via les réseaux sociaux. Il répond rapidement aux demandes de collaboration !"
            ],
            default: [
                "Intéressant ! Pouvez-vous me donner plus de détails ? Je peux vous aider avec les services IA, Cloud, Data ou développement.",
                "Je ne suis pas sûr de comprendre. Voulez-vous en savoir plus sur les services d'IA, Cloud, Data Analytics ou développement ?",
                "Pouvez-vous reformuler votre question ? Je suis spécialisé dans l'IA, le Cloud, l'analyse de données et le développement."
            ]
        };
        
        this.init();
    }
    
    init() {
        // Toggle chat window
        this.chatToggle.addEventListener('click', () => this.toggleChat());
        this.chatClose.addEventListener('click', () => this.closeChat());
        
        // Send message
        this.chatSend.addEventListener('click', () => this.sendMessage());
        this.chatInput.addEventListener('keypress', (e) => {
            if (e.key === 'Enter') this.sendMessage();
        });
        
        // Quick action buttons
        this.quickBtns.forEach(btn => {
            btn.addEventListener('click', () => {
                const message = btn.getAttribute('data-message');
                this.chatInput.value = message;
                this.sendMessage();
            });
        });
        
        // Hide notification after first interaction
        this.chatToggle.addEventListener('click', () => {
            this.chatNotification.style.display = 'none';
        });
    }
    
    toggleChat() {
        this.chatWindow.classList.toggle('active');
        if (this.chatWindow.classList.contains('active')) {
            this.chatInput.focus();
        }
    }
    
    closeChat() {
        this.chatWindow.classList.remove('active');
    }
    
    sendMessage() {
        const message = this.chatInput.value.trim();
        if (!message) return;
        
        // Add user message
        this.addMessage(message, 'user');
        this.chatInput.value = '';
        
        // Generate bot response
        setTimeout(() => {
            const response = this.generateResponse(message);
            this.addMessage(response, 'bot');
        }, 500 + Math.random() * 1000);
    }
    
    addMessage(text, sender) {
        const messageDiv = document.createElement('div');
        messageDiv.className = `message ${sender}-message`;
        
        const avatar = document.createElement('div');
        avatar.className = 'message-avatar';
        avatar.innerHTML = sender === 'bot' ? '<i class="fas fa-robot"></i>' : '<i class="fas fa-user"></i>';
        
        const content = document.createElement('div');
        content.className = 'message-content';
        
        // Handle line breaks and formatting
        const formattedText = text.replace(/\n/g, '<br>');
        content.innerHTML = `<p>${formattedText}</p>`;
        
        messageDiv.appendChild(avatar);
        messageDiv.appendChild(content);
        
        this.chatMessages.appendChild(messageDiv);
        this.chatMessages.scrollTop = this.chatMessages.scrollHeight;
    }
    
    generateResponse(message) {
        const lowerMessage = message.toLowerCase();
        
        // Greeting patterns
        if (lowerMessage.match(/^(salut|bonjour|hello|hi|hey)/)) {
            return this.getRandomResponse('greeting');
        }
        
        // Service-related keywords
        if (lowerMessage.includes('service') || lowerMessage.includes('que faites-vous') || lowerMessage.includes('quoi')) {
            return this.getRandomResponse('services');
        }
        
        // IA keywords
        if (lowerMessage.match(/(ia|intelligence artificielle|machine learning|ml|deep learning|ai)/)) {
            return this.getRandomResponse('ia');
        }
        
        // Cloud keywords
        if (lowerMessage.match(/(cloud|aws|devops|docker|kubernetes|ci\/cd)/)) {
            return this.getRandomResponse('cloud');
        }
        
        // Data keywords
        if (lowerMessage.match(/(data|données|analytics|tableau|dashboard|bi|business intelligence)/)) {
            return this.getRandomResponse('data');
        }
        
        // Quote/Devis keywords
        if (lowerMessage.match(/(devis|prix|coût|tarif|quote)/)) {
            return this.getRandomResponse('devis');
        }
        
        // Projects keywords
        if (lowerMessage.match(/(projet|portfolio|réalisation|travaux)/)) {
            return this.getRandomResponse('projets');
        }
        
        // Contact keywords
        if (lowerMessage.match(/(contact|email|téléphone|joindre|appeler)/)) {
            return this.getRandomResponse('contact');
        }
        
        // Default response
        return this.getRandomResponse('default');
    }
    
    getRandomResponse(category) {
        const responses = this.responses[category];
        return responses[Math.floor(Math.random() * responses.length)];
    }
}

// Theme Toggle Functionality
class ThemeToggle {
    constructor() {
        this.themeToggleBtn = document.getElementById('theme-toggle-btn');
        this.themeIcon = document.getElementById('theme-icon');
        this.currentTheme = localStorage.getItem('theme') || 'dark';
        
        this.init();
    }
    
    init() {
        // Set initial theme
        this.setTheme(this.currentTheme);
        
        // Add click event listener
        if (this.themeToggleBtn) {
            this.themeToggleBtn.addEventListener('click', () => this.toggleTheme());
        }
    }
    
    toggleTheme() {
        const newTheme = this.currentTheme === 'dark' ? 'light' : 'dark';
        this.setTheme(newTheme);
    }
    
    setTheme(theme) {
        this.currentTheme = theme;
        document.documentElement.setAttribute('data-theme', theme);
        localStorage.setItem('theme', theme);
        
        // Update icon
        if (this.themeIcon) {
            if (theme === 'light') {
                this.themeIcon.className = 'fas fa-moon';
            } else {
                this.themeIcon.className = 'fas fa-sun';
            }
        }
        
        // Update navbar background for light theme
        const navbar = document.querySelector('.navbar');
        if (navbar) {
            if (theme === 'light') {
                navbar.style.background = 'rgba(248, 250, 252, 0.98)';
            } else {
                navbar.style.background = 'rgba(15, 15, 35, 0.98)';
            }
        }
    }
}

// Initialize theme toggle and chat when DOM is loaded
document.addEventListener('DOMContentLoaded', () => {
    // Initialize theme toggle
    new ThemeToggle();
    
    // Initialize chat widget
    if (document.getElementById('chat-widget')) {
        new ChatBot();
    }
});

// Popup galerie pour le projet Trafic Aérien
function initAirTrafficGalleryPopup() {
    const galleryTargets = document.querySelectorAll('.project-gallery[data-gallery="air-traffic"]');
    const triggerLinks = document.querySelectorAll('a[data-open-gallery="air-traffic"]');
    const triggerCards = document.querySelectorAll('.project-card[data-open-gallery="air-traffic"]');
    if (!galleryTargets.length && !triggerLinks.length && !triggerCards.length) return;

    const images = [
        'images/1.png',
        'images/2.png',
        'images/3.png',
        'images/4.png',
        'images/5.jpg',
        'images/6.jpg',
        'images/7.png'
    ];

    const modal = document.createElement('div');
    modal.className = 'gallery-modal';
    modal.setAttribute('aria-hidden', 'true');
    modal.innerHTML = `
        <div class="gallery-modal-content" role="dialog" aria-modal="true" aria-label="Galerie Trafic Aérien">
            <div class="gallery-modal-header">
                <h3>Dashboard Trafic Aérien - 7 captures</h3>
                <button class="gallery-close-btn" type="button" aria-label="Fermer la galerie">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <div class="gallery-slider">
                <button class="gallery-nav-btn gallery-prev-btn" type="button" aria-label="Image précédente">
                    <i class="fas fa-chevron-left"></i>
                </button>
                <img class="gallery-main-image" src="${images[0]}" alt="Capture tableau de bord trafic aérien 1">
                <button class="gallery-nav-btn gallery-next-btn" type="button" aria-label="Image suivante">
                    <i class="fas fa-chevron-right"></i>
                </button>
            </div>
            <div class="gallery-slider-footer">
                <span class="gallery-counter">1 / ${images.length}</span>
            </div>
            <div class="gallery-thumbs">
                ${images.map((src, i) => `<button class="gallery-thumb-btn${i === 0 ? ' active' : ''}" type="button" data-index="${i}" aria-label="Afficher l'image ${i + 1}"><img src="${src}" alt="Miniature capture ${i + 1}" loading="lazy"></button>`).join('')}
            </div>
        </div>
    `;

    const closeBtn = modal.querySelector('.gallery-close-btn');
    const prevBtn = modal.querySelector('.gallery-prev-btn');
    const nextBtn = modal.querySelector('.gallery-next-btn');
    const mainImage = modal.querySelector('.gallery-main-image');
    const counter = modal.querySelector('.gallery-counter');
    const thumbBtns = modal.querySelectorAll('.gallery-thumb-btn');
    let currentIndex = 0;

    const renderSlide = (index) => {
        currentIndex = (index + images.length) % images.length;
        mainImage.style.opacity = '0';
        setTimeout(() => {
            mainImage.src = images[currentIndex];
            mainImage.alt = `Capture tableau de bord trafic aérien ${currentIndex + 1}`;
            counter.textContent = `${currentIndex + 1} / ${images.length}`;
            thumbBtns.forEach((btn) => {
                btn.classList.toggle('active', Number(btn.dataset.index) === currentIndex);
            });
            mainImage.style.opacity = '1';
        }, 120);
    };

    const openModal = () => {
        modal.classList.add('active');
        modal.setAttribute('aria-hidden', 'false');
        document.body.style.overflow = 'hidden';
    };
    const closeModal = () => {
        modal.classList.remove('active');
        modal.setAttribute('aria-hidden', 'true');
        document.body.style.overflow = '';
    };

    galleryTargets.forEach((gallery) => {
        gallery.querySelectorAll('img').forEach((img) => {
            img.addEventListener('click', openModal);
        });
    });

    triggerLinks.forEach((link) => {
        link.addEventListener('click', (event) => {
            event.preventDefault();
            openModal();
        });
    });

    triggerCards.forEach((card) => {
        card.addEventListener('click', (event) => {
            if (event.target.closest('a, button')) return;
            openModal();
        });
    });

    prevBtn.addEventListener('click', () => renderSlide(currentIndex - 1));
    nextBtn.addEventListener('click', () => renderSlide(currentIndex + 1));
    thumbBtns.forEach((btn) => {
        btn.addEventListener('click', () => renderSlide(Number(btn.dataset.index)));
    });

    closeBtn.addEventListener('click', closeModal);
    modal.addEventListener('click', (event) => {
        if (event.target === modal) closeModal();
    });
    document.addEventListener('keydown', (event) => {
        if (!modal.classList.contains('active')) return;
        if (event.key === 'Escape' && modal.classList.contains('active')) {
            closeModal();
        }
        if (event.key === 'ArrowLeft') renderSlide(currentIndex - 1);
        if (event.key === 'ArrowRight') renderSlide(currentIndex + 1);
    });

    document.body.appendChild(modal);
}

document.addEventListener('DOMContentLoaded', initAirTrafficGalleryPopup);

// Popup de details pour les projets IA sur l'accueil
function initProjectDetailPopups() {
    const detailTriggers = document.querySelectorAll('[data-open-project]');
    if (!detailTriggers.length) return;

    const projectContent = {
        'fake-news': {
            title: 'Detection Fake News',
            subtitle: 'IA, NLP, Docker, Azure',
            description: "Application IA capable d'analyser textes et contenus video pour estimer leur veracite, avec une approche orientee usage reel.",
            points: [
                "Conception du pipeline NLP pour nettoyer, vectoriser et classifier les contenus.",
                "Traitement de textes et scenarios video avec scoring de credibilite interpretable.",
                "Containerisation complete avec Docker pour des deploiements reproductibles.",
                "Mise en production cloud sur Azure avec supervision des performances."
            ],
            tech: ['Python', 'NLP', 'Azure', 'Docker', 'Machine Learning']
        },
        diabetes: {
            title: 'Prediction du Diabete',
            subtitle: 'Machine Learning clinique',
            description: "Solution predictive pour estimer le risque de diabete a partir de donnees cliniques, avec un focus sur la precision et la simplicite d'usage.",
            points: [
                "Preparation et normalisation des donnees medicales pour la robustesse du modele.",
                "Entrainement et comparaison de modeles Scikit-learn avec validation croisee.",
                "Interpretation des variables les plus impactantes pour aider a la decision.",
                "Industrialisation de la solution avec logique de deploiement cloud."
            ],
            tech: ['Machine Learning', 'Python', 'Scikit-learn', 'Azure', 'Data Science']
        }
    };

    const modal = document.createElement('div');
    modal.className = 'project-detail-modal';
    modal.setAttribute('aria-hidden', 'true');
    modal.innerHTML = `
        <div class="project-detail-content" role="dialog" aria-modal="true" aria-label="Details du projet">
            <div class="project-detail-header">
                <div>
                    <h3 class="project-detail-title"></h3>
                    <p class="project-detail-subtitle"></p>
                </div>
                <button class="project-detail-close" type="button" aria-label="Fermer les details">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <p class="project-detail-description"></p>
            <ul class="project-detail-points"></ul>
            <div class="project-detail-tech"></div>
        </div>
    `;

    const titleEl = modal.querySelector('.project-detail-title');
    const subtitleEl = modal.querySelector('.project-detail-subtitle');
    const descriptionEl = modal.querySelector('.project-detail-description');
    const pointsEl = modal.querySelector('.project-detail-points');
    const techEl = modal.querySelector('.project-detail-tech');
    const closeBtn = modal.querySelector('.project-detail-close');

    const openModal = (projectKey) => {
        const data = projectContent[projectKey];
        if (!data) return;

        titleEl.textContent = data.title;
        subtitleEl.textContent = data.subtitle;
        descriptionEl.textContent = data.description;
        pointsEl.innerHTML = data.points.map((point) => `<li>${point}</li>`).join('');
        techEl.innerHTML = data.tech.map((item) => `<span>${item}</span>`).join('');

        modal.classList.add('active');
        modal.setAttribute('aria-hidden', 'false');
        document.body.style.overflow = 'hidden';
    };

    const closeModal = () => {
        modal.classList.remove('active');
        modal.setAttribute('aria-hidden', 'true');
        document.body.style.overflow = '';
    };

    detailTriggers.forEach((trigger) => {
        trigger.addEventListener('click', (event) => {
            const projectKey = trigger.getAttribute('data-open-project');
            if (!projectKey) return;
            event.preventDefault();
            openModal(projectKey);
        });
    });

    closeBtn.addEventListener('click', closeModal);
    modal.addEventListener('click', (event) => {
        if (event.target === modal) closeModal();
    });

    document.addEventListener('keydown', (event) => {
        if (event.key === 'Escape' && modal.classList.contains('active')) {
            closeModal();
        }
    });

    document.body.appendChild(modal);
}

document.addEventListener('DOMContentLoaded', initProjectDetailPopups);
