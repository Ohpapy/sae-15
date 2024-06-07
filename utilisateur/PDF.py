import fpdf
import mysql.connector
import sys




db = mysql.connector.connect(
    host="localhost",
    user="root",
    password="root",
    database="rp09"
)


cursor = db.cursor()
args = sys.argv[1:]

cursor.execute(f"""
    SELECT DISTINCT appartenance.num_bp, bonnespratique.test_bp, bonnespratique.utilisation_bp, programme.nom_prog, phase.nom_phase
        FROM appartenance
        JOIN bonnespratique ON appartenance.num_bp = bonnespratique.num_bp
        JOIN programme ON appartenance.num_prog = programme.num_prog
        JOIN phase ON appartenance.num_phase = phase.num_phase
        JOIN bp_motcles ON appartenance.num_bp = bp_motcles.num_bp
        JOIN motcles ON bp_motcles.num_cles = motcles.num_cles WHERE 1=1
    """)


data = cursor.fetchall()


cursor.close()
db.close()




for arg in args:
    bp_id, programme, phase = arg.split(",")


def export_to_pdf(data):
    
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

    
    for row in data:
        pdf.cell(30, 10, str(row[0]), 1, 0, "C")
        pdf.cell(50, 10, row[1], 1, 0, "C")
        pdf.cell(50, 10, row[2], 1, 0, "C")
        pdf.cell(50, 10, row[3], 1, 1, "C")
        pdf.ln(10)

    
    pdf.output("bonnes_pratiques.pdf", "F")

    print("PDF généré avec succès !")


export_to_pdf(data)