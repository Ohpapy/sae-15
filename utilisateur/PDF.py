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
    SELECT
        bp.num_bp,
        bp.test_bp,
        p.nom_prog,
        ph.nom_phase
    FROM
        bonnespratique bp
    INNER JOIN
        appartenance a ON bp.num_bp = a.num_bp
    INNER JOIN
        programme p ON a.num_prog = p.num_prog
    INNER JOIN
        phase ph ON a.num_phase = ph.num_phase
    WHERE bp.num_bp = {args}
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