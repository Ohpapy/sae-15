import fpdf
import mysql.connector
import sys




db = mysql.connector.connect(
    host="localhost",
    user="root",
    password="root",
    database="rp09"
)

liste_bp = []
cursor = db.cursor()
args = sys.argv[1:]
for arg in args:
    cursor.execute(f"""
            SELECT bonnespratique.num_bp, bonnespratique.test_bp, programme.nom_prog, phase.nom_phase
            FROM appartenance
            JOIN bonnespratique ON appartenance.num_bp = bonnespratique.num_bp
            JOIN programme ON appartenance.num_prog = programme.num_prog
            JOIN phase ON appartenance.num_phase = phase.num_phase
            WHERE bonnespratique.num_bp = {arg}
        """)
    data = cursor.fetchall()
    liste_bp.append(data)

cursor.close()
db.close()

def export_to_pdf(liste_bp):
    pdf = fpdf.FPDF()

    pdf.add_page()

    pdf.set_font("Arial", size=12)

    pdf.cell(0, 10, "Bonnes pratiques", 1, 1, "C")
    pdf.ln(10)

    pdf.cell(30, 10, "ID", 1, 0, "C")
    pdf.cell(50, 10, "Nom de la bonne pratique", 1, 0, "C")
    pdf.cell(50, 10, "Programme", 1, 0, "C")
    pdf.cell(50, 10, "Phase", 1, 1, "C")
    pdf.ln(10)

    for bp in liste_bp:
        pdf.cell(30, 10, str(bp['num_bp']), 1, 0, "C")
        pdf.cell(50, 10, bp['test_bp'], 1, 0, "C")
        pdf.cell(50, 10, bp['nom_prog'], 1, 0, "C")
        pdf.cell(50, 10, bp['nom_phase'], 1, 1, "C")
        pdf.ln(10)

    pdf.output("bonnes_pratiques.pdf", "F")

    print("PDF généré avec succès !")