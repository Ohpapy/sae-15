import fpdf
import mysql.connector
import sys
import textwrap

# Connexion à la base de données
db = mysql.connector.connect(
    host="localhost",
    user="root",
    password="root",
    database="rp09"
)

liste_bp = []
cursor = db.cursor(dictionary=True)  # Utilisation du curseur avec dictionnaire pour un accès par clé

# Récupération des arguments de la ligne de commande
args = sys.argv[1:]

for arg in args:
    cursor.execute("""
            SELECT bonnespratique.num_bp, bonnespratique.test_bp, programme.nom_prog, phase.nom_phase
            FROM appartenance
            JOIN bonnespratique ON appartenance.num_bp = bonnespratique.num_bp
            JOIN programme ON appartenance.num_prog = programme.num_prog
            JOIN phase ON appartenance.num_phase = phase.num_phase
            WHERE bonnespratique.num_bp = %s
        """, (arg,))
    data = cursor.fetchall()
    liste_bp.extend(data)  # Ajout des résultats à la liste

cursor.close()
db.close()

def export_to_pdf(liste_bp, creator_name):
    pdf = fpdf.FPDF()
    pdf.add_page()
    pdf.set_font("Arial", size=12)

    pdf.cell(0, 7, "Bonnes pratiques", 1, 1, "C")
    pdf.ln(10)

    pdf.cell(30, 7, "ID", 1, 0, "C")
    pdf.cell(50, 7, "Nom de la bonne pratique", 1, 0, "C")
    pdf.cell(30, 7, "Programme", 1, 0, "C")
    pdf.cell(30, 7, "Phase", 1, 0, "C")
    pdf.cell(50, 7, "Coché", 1, 1, "C")  # Ajout de la colonne "Coché"
    pdf.ln(10)

    for bp in liste_bp:
        shortened_test_bp = textwrap.shorten(bp['test_bp'], width=30, placeholder="...")  # Ajustez la largeur si nécessaire
        
        pdf.cell(30, 10, str(bp['num_bp']), 1, 0, "C")
        pdf.cell(50, 10, shortened_test_bp, 1, 0, "C")
        pdf.cell(30, 10, bp['nom_prog'], 1, 0, "C")
        pdf.cell(30, 10, bp['nom_phase'], 1, 0, "C")
        pdf.cell(50, 10, "Coché", 1, 1, "C")
        pdf.ln(10)

    # Ajout du texte en bas du fichier
    pdf.ln(20)
    pdf.cell(0, 10, f"Créé par: {creator_name}", 0, 1, "C")

    pdf.output("bonnes_pratiques.pdf", "F")

    print("PDF généré avec succès !")

# Nom du créateur (à remplacer par le nom réel)
creator_name = "Mathis"

export_to_pdf(liste_bp, creator_name)



























