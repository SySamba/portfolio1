#!/usr/bin/env python3
# -*- coding: utf-8 -*-
"""
Générateur de CV PDF professionnel pour Samba SY
Inclut photo de profil et QR code vers le portfolio
"""

from reportlab.lib.pagesizes import A4
from reportlab.lib import colors
from reportlab.lib.units import cm, inch
from reportlab.platypus import SimpleDocTemplate, Paragraph, Spacer, Image, Table, TableStyle
from reportlab.lib.styles import getSampleStyleSheet, ParagraphStyle
from reportlab.lib.enums import TA_LEFT, TA_CENTER, TA_RIGHT, TA_JUSTIFY
from reportlab.pdfgen import canvas
from reportlab.graphics.shapes import Drawing, Rect
import qrcode
from PIL import Image as PILImage
import os
import io

class CVGenerator:
    def __init__(self):
        self.width, self.height = A4
        self.margin = 2*cm
        self.styles = getSampleStyleSheet()
        self.setup_custom_styles()
        
    def setup_custom_styles(self):
        """Configuration des styles personnalisés avec couleurs IA du portfolio"""
        # Style pour le nom avec gradient IA
        self.styles.add(ParagraphStyle(
            name='CVName',
            parent=self.styles['Heading1'],
            fontSize=26,
            textColor=colors.HexColor('#4f46e5'),
            spaceAfter=8,
            alignment=TA_CENTER,
            fontName='Helvetica-Bold'
        ))
        
        # Style pour le titre professionnel
        self.styles.add(ParagraphStyle(
            name='CVTitle',
            parent=self.styles['Normal'],
            fontSize=16,
            textColor=colors.HexColor('#06b6d4'),
            spaceAfter=15,
            alignment=TA_CENTER,
            fontName='Helvetica-Bold'
        ))
        
        # Style pour les sections avec couleurs IA
        self.styles.add(ParagraphStyle(
            name='SectionHeader',
            parent=self.styles['Heading2'],
            fontSize=18,
            textColor=colors.HexColor('#6366f1'),
            spaceAfter=10,
            spaceBefore=18,
            fontName='Helvetica-Bold',
            borderWidth=2,
            borderColor=colors.HexColor('#8b5cf6'),
            borderPadding=6
        ))
        
        # Style pour le contenu
        self.styles.add(ParagraphStyle(
            name='Content',
            parent=self.styles['Normal'],
            fontSize=11,
            textColor=colors.black,
            spaceAfter=6,
            alignment=TA_JUSTIFY,
            fontName='Helvetica'
        ))
        
        # Style pour les sous-titres
        self.styles.add(ParagraphStyle(
            name='SubTitle',
            parent=self.styles['Normal'],
            fontSize=13,
            textColor=colors.HexColor('#7c3aed'),
            spaceAfter=6,
            fontName='Helvetica-Bold'
        ))

    def generate_qr_code(self, url, size=(2*cm, 2*cm)):
        """Génère un QR code pour l'URL du portfolio"""
        qr = qrcode.QRCode(
            version=1,
            error_correction=qrcode.constants.ERROR_CORRECT_L,
            box_size=10,
            border=4,
        )
        qr.add_data(url)
        qr.make(fit=True)
        
        # Créer l'image QR
        qr_img = qr.make_image(fill_color="black", back_color="white")
        
        # Sauvegarder temporairement
        qr_path = "temp_qr.png"
        qr_img.save(qr_path)
        
        return qr_path

    def create_header(self, canvas, doc):
        """Crée l'en-tête avec photo et informations de contact"""
        canvas.saveState()
        
        # Ligne de séparation en haut
        canvas.setStrokeColor(colors.HexColor('#2a5298'))
        canvas.setLineWidth(3)
        canvas.line(self.margin, self.height - self.margin, 
                   self.width - self.margin, self.height - self.margin)
        
        canvas.restoreState()

    def create_cv_content(self):
        """Crée le contenu principal du CV"""
        story = []
        
        # En-tête avec photo et nom
        header_data = []
        
        # Vérifier si l'image existe
        photo_path = "image.jpg"
        if os.path.exists(photo_path):
            try:
                # Redimensionner la photo
                photo = Image(photo_path, width=3*cm, height=3*cm)
            except:
                photo = Paragraph("Photo non disponible", self.styles['Content'])
        else:
            photo = Paragraph("Photo non disponible", self.styles['Content'])
        
        # Informations personnelles
        contact_info = [
            Paragraph("<b>SAMBA SY</b>", self.styles['CVName']),
            Paragraph("DATA SCIENTIST | CLOUD & DEVOPS | DÉVELOPPEUR IA", self.styles['CVTitle']),
            Spacer(1, 0.3*cm),
            Paragraph("<b>Contact:</b>", self.styles['SubTitle']),
            Paragraph("📞 +221 773784814", self.styles['Content']),
            Paragraph("✉️ sambasy837@gmail.com", self.styles['Content']),
            Paragraph("📍 Dakar, Sénégal", self.styles['Content']),
        ]
        
        # QR Code
        qr_path = self.generate_qr_code("https://sambasy.teranganumerique.com/")
        qr_code = Image(qr_path, width=2.5*cm, height=2.5*cm)
        
        # Table pour l'en-tête
        header_table = Table([
            [photo, contact_info, qr_code]
        ], colWidths=[4*cm, 10*cm, 3*cm])
        
        header_table.setStyle(TableStyle([
            ('ALIGN', (0, 0), (-1, -1), 'CENTER'),
            ('VALIGN', (0, 0), (-1, -1), 'MIDDLE'),
            ('LEFTPADDING', (0, 0), (-1, -1), 6),
            ('RIGHTPADDING', (0, 0), (-1, -1), 6),
        ]))
        
        story.append(header_table)
        story.append(Spacer(1, 0.5*cm))
        
        # Ligne de séparation
        story.append(Paragraph('<para borderWidth="1" borderColor="#2a5298"><br/></para>', self.styles['Content']))
        
        # Résumé professionnel
        story.append(Paragraph("RÉSUMÉ PROFESSIONNEL", self.styles['SectionHeader']))
        story.append(Paragraph(
            "Data Scientist passionné par l'Intelligence Artificielle et expert en solutions cloud innovantes. "
            "Spécialisé en Machine Learning, Deep Learning, NLP et Computer Vision avec une expertise avancée en AWS Cloud et DevOps. "
            "Créateur d'applications IA révolutionnaires incluant des systèmes de détection de fake news, prédiction médicale et dashboards interactifs. "
            "Maîtrise complète de Python, R, TensorFlow, Docker/Kubernetes et développement Full Stack pour transformer les données en valeur business.",
            self.styles['Content']
        ))
        story.append(Spacer(1, 0.3*cm))
        
        # Expérience professionnelle
        story.append(Paragraph("EXPÉRIENCE PROFESSIONNELLE", self.styles['SectionHeader']))
        
        experiences = [
            {
                "poste": "Data Scientist & Développeur IA",
                "entreprise": "Porokhane Digital Consulting",
                "periode": "2023 - Présent",
                "description": [
                    "• Développement d'un système IA de détection de fake news (NLP avancé, déployé sur Azure)",
                    "• Création de modèles prédictifs médicaux (diabète) avec 92% de précision",
                    "• Architecture et déploiement de solutions cloud AWS (EC2, S3, Lambda, RDS)",
                    "• Développement Full Stack de plateformes digitales (React, Django, PostgreSQL)"
                ]
            },
            {
                "poste": "Analyste de Données",
                "entreprise": "Aéroport International Blaise Diagne",
                "periode": "2022 - 2023",
                "description": [
                    "• Analyse des flux de passagers et optimisation des opérations",
                    "• Création de tableaux de bord avec Power BI et Tableau",
                    "• Développement de scripts d'automatisation en Python",
                    "• Gestion de bases de données SQL Server et Oracle"
                ]
            },
            {
                "poste": "Développeur Web Junior",
                "entreprise": "Webgram Agency",
                "periode": "2021 - 2022",
                "description": [
                    "• Développement d'applications web avec PHP/MySQL",
                    "• Intégration de designs responsive (HTML5, CSS3, JavaScript)",
                    "• Optimisation SEO et performance des sites web",
                    "• Maintenance et mise à jour de sites e-commerce"
                ]
            }
        ]
        
        for exp in experiences:
            story.append(Paragraph(f"<b>{exp['poste']}</b>", self.styles['SubTitle']))
            story.append(Paragraph(f"{exp['entreprise']} | {exp['periode']}", self.styles['Content']))
            for desc in exp['description']:
                story.append(Paragraph(desc, self.styles['Content']))
            story.append(Spacer(1, 0.2*cm))
        
        # Formation
        story.append(Paragraph("FORMATION", self.styles['SectionHeader']))
        
        formations = [
            {
                "diplome": "Master en Intelligence Artificielle et Big Data",
                "etablissement": "Université Cheikh Anta Diop de Dakar",
                "periode": "2024 - 2025",
                "description": "Expertise avancée en analyse de données massives, modèles prédictifs, apprentissage automatique et traitement du langage naturel."
            },
            {
                "diplome": "Licence en Technicien Informatique",
                "etablissement": "Université Cheikh Anta Diop de Dakar",
                "periode": "2021 - 2022",
                "description": "Maîtrise des concepts en programmation informatique, modélisation mathématique et développement logiciel."
            },
            {
                "diplome": "Baccalauréat Scientifique",
                "etablissement": "Lycée de Thiès",
                "periode": "2017",
                "description": "Spécialisation en mathématiques et sciences physiques."
            }
        ]
        
        for formation in formations:
            story.append(Paragraph(f"<b>{formation['diplome']}</b>", self.styles['SubTitle']))
            story.append(Paragraph(f"{formation['etablissement']} | {formation['periode']}", self.styles['Content']))
            story.append(Paragraph(formation['description'], self.styles['Content']))
            story.append(Spacer(1, 0.2*cm))
        
        # Compétences techniques
        story.append(Paragraph("COMPÉTENCES TECHNIQUES", self.styles['SectionHeader']))
        
        competences_data = [
            ["Intelligence Artificielle", "Python, TensorFlow, PyTorch, Scikit-learn, OpenCV, NLP, Computer Vision"],
            ["Cloud & DevOps", "AWS (EC2, S3, Lambda, RDS), Azure, Docker, Kubernetes, Terraform, CI/CD"],
            ["Data Science & Analytics", "Machine Learning, Deep Learning, R, Pandas, NumPy, Matplotlib, Seaborn"],
            ["Développement Full Stack", "React, Django, Node.js, PHP, HTML5, CSS3, JavaScript, Bootstrap"],
            ["Bases de Données", "PostgreSQL, MySQL, MongoDB, SQL Server, Oracle, Redis"],
            ["Visualisation & BI", "Power BI, Tableau, Streamlit, Plotly, D3.js, Excel Avancé"]
        ]
        
        competences_table = Table(competences_data, colWidths=[4*cm, 11*cm])
        competences_table.setStyle(TableStyle([
            ('BACKGROUND', (0, 0), (0, -1), colors.HexColor('#f0f8ff')),
            ('TEXTCOLOR', (0, 0), (0, -1), colors.HexColor('#4f46e5')),
            ('ALIGN', (0, 0), (-1, -1), 'LEFT'),
            ('FONTNAME', (0, 0), (0, -1), 'Helvetica-Bold'),
            ('FONTNAME', (1, 0), (1, -1), 'Helvetica'),
            ('FONTSIZE', (0, 0), (-1, -1), 10),
            ('GRID', (0, 0), (-1, -1), 1, colors.HexColor('#8b5cf6')),
            ('VALIGN', (0, 0), (-1, -1), 'MIDDLE'),
            ('LEFTPADDING', (0, 0), (-1, -1), 8),
            ('RIGHTPADDING', (0, 0), (-1, -1), 8),
            ('TOPPADDING', (0, 0), (-1, -1), 6),
            ('BOTTOMPADDING', (0, 0), (-1, -1), 6),
        ]))
        
        story.append(competences_table)
        story.append(Spacer(1, 0.3*cm))
        
        # Certifications
        story.append(Paragraph("CERTIFICATIONS", self.styles['SectionHeader']))
        
        certifications = [
            "• AWS Certified Solutions Architect - Associate (2024)",
            "• Google Cloud Professional Data Engineer (2024)",
            "• Microsoft Azure AI Fundamentals (2023)",
            "• TensorFlow Developer Certificate (2023)",
            "• Certified Kubernetes Administrator (CKA) (2024)",
            "• Oracle Database SQL Certified Associate (2023)"
        ]
        
        for cert in certifications:
            story.append(Paragraph(cert, self.styles['Content']))
        
        story.append(Spacer(1, 0.3*cm))
        
        # Langues
        story.append(Paragraph("LANGUES", self.styles['SectionHeader']))
        
        langues_data = [
            ["Français", "Natif"],
            ["Anglais", "Professionnel (B2)"],
            ["Wolof", "Natif"],
            ["Arabe", "Notions de base"]
        ]
        
        langues_table = Table(langues_data, colWidths=[6*cm, 6*cm])
        langues_table.setStyle(TableStyle([
            ('ALIGN', (0, 0), (-1, -1), 'LEFT'),
            ('FONTNAME', (0, 0), (0, -1), 'Helvetica-Bold'),
            ('FONTNAME', (1, 0), (1, -1), 'Helvetica'),
            ('FONTSIZE', (0, 0), (-1, -1), 11),
            ('GRID', (0, 0), (-1, -1), 1, colors.HexColor('#8b5cf6')),
            ('BACKGROUND', (0, 0), (0, -1), colors.HexColor('#f0f8ff')),
            ('TEXTCOLOR', (0, 0), (0, -1), colors.HexColor('#4f46e5')),
            ('VALIGN', (0, 0), (-1, -1), 'MIDDLE'),
            ('LEFTPADDING', (0, 0), (-1, -1), 8),
            ('RIGHTPADDING', (0, 0), (-1, -1), 8),
            ('TOPPADDING', (0, 0), (-1, -1), 4),
            ('BOTTOMPADDING', (0, 0), (-1, -1), 4),
        ]))
        
        story.append(langues_table)
        
        # Pied de page avec QR code info
        story.append(Spacer(1, 0.5*cm))
        story.append(Paragraph(
            '<para alignment="center" fontSize="9" textColor="#666666">'
            'Scannez le QR code ci-dessus pour accéder à mon portfolio en ligne : '
            '<b>https://sambasy.teranganumerique.com/</b>'
            '</para>',
            self.styles['Content']
        ))
        
        return story

    def generate_cv(self, filename="CV_Samba_SY_IA_Portfolio.pdf"):
        """Génère le CV PDF complet"""
        doc = SimpleDocTemplate(
            filename,
            pagesize=A4,
            rightMargin=self.margin,
            leftMargin=self.margin,
            topMargin=self.margin + 1*cm,
            bottomMargin=self.margin
        )
        
        # Créer le contenu
        story = self.create_cv_content()
        
        # Construire le PDF
        doc.build(story, onFirstPage=self.create_header, onLaterPages=self.create_header)
        
        # Nettoyer les fichiers temporaires
        if os.path.exists("temp_qr.png"):
            os.remove("temp_qr.png")
        
        print(f"CV généré avec succès : {filename}")
        return filename

if __name__ == "__main__":
    # Créer le générateur de CV
    cv_gen = CVGenerator()
    
    # Générer le CV
    cv_filename = cv_gen.generate_cv()
    
    print(f"CV PDF cree : {cv_filename}")
    print("Le CV inclut :")
    print("   - Photo de profil (image.jpg)")
    print("   - QR code vers le portfolio")
    print("   - Informations completes de Samba SY")
    print("   - Design professionnel moderne")
