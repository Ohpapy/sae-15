import openpyxl
import mysql.connector
import sys
import textwrap
from datetime import datetime

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

def export_to_excel(liste_bp, creator_name):
    # Création d'un nouveau classeur
    wb = openpyxl.Workbook()
    ws = wb.active
    ws.title = "Bonnes pratiques"

    # Création de l'en-tête
    headers = ["ID", "Nom de la bonne pratique", "Programme", "Phase", "Coché"]
    ws.append(headers)

    # Ajout des données
    for bp in liste_bp:
        wrapped_test_bp = textwrap.fill(bp['test_bp'], width=50)  # Ajustez la largeur si nécessaire
        row = [bp['num_bp'], wrapped_test_bp, bp['nom_prog'], bp['nom_phase'], "Coché"]
        ws.append(row)

    # Ajustement de la largeur des colonnes pour mieux afficher les données
    for col in ws.columns:
        max_length = 0
        column = col[0].column_letter  # Get the column name
        for cell in col:
            try:
                if len(str(cell.value)) > max_length:
                    max_length = len(cell.value)
            except:
                pass
        adjusted_width = (max_length + 2)
        ws.column_dimensions[column].width = adjusted_width

    # Ajout du texte en bas du fichier
    creation_date = datetime.now().strftime("%Y-%m-%d %H:%M:%S")
    ws.append([])  # Ajout d'une ligne vide
    ws.append([f"Créé par: {creator_name}"])
    ws.append([f"Date de création: {creation_date}"])

    # Enregistrement du fichier Excel
    wb.save("bonnes_pratiques.xlsx")
    print("Excel généré avec succès !")

# Nom du créateur (à remplacer par le nom réel)
creator_name = "Mathis"

export_to_excel(liste_bp, creator_name)
