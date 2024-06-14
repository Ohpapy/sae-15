import openpyxl
from openpyxl.styles import Alignment
import mysql.connector
import sys
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

    # Nombre de colonnes vides à ajouter pour centrer les données
    empty_columns_each_side = 10

    # Indice de départ pour les données réelles
    data_start_col = empty_columns_each_side + 1

    # Création de l'en-tête
    headers = ["ID", "Nom de la bonne pratique", "Programme", "Phase", "Coché"]
    for i, header in enumerate(headers):
        cell = ws.cell(row=1, column=data_start_col + i)
        cell.value = header
        cell.alignment = Alignment(horizontal='center', vertical='center')

    # Ajout des données
    for row_index, bp in enumerate(liste_bp, start=2):
        wrapped_test_bp = bp['test_bp']
        row = [bp['num_bp'], wrapped_test_bp, bp['nom_prog'], bp['nom_phase'], " "]
        for col_index, cell_value in enumerate(row):
            cell = ws.cell(row=row_index, column=data_start_col + col_index)
            cell.value = cell_value
            cell.alignment = Alignment(horizontal='center', vertical='center', wrap_text=True)

    # Ajustement de la largeur des colonnes pour mieux afficher les données
    for i in range(len(headers)):
        ws.column_dimensions[openpyxl.utils.get_column_letter(data_start_col + i)].width = 30

    # Ajuster automatiquement la hauteur des lignes pour afficher tout le texte
    for row in ws.iter_rows(min_row=2, max_row=ws.max_row):
        max_height = 0
        for cell in row:
            if cell.value:
                lines = str(cell.value).split('\n')
                max_height = max(max_height, len(lines) * 15)  # Ajuster la taille selon le texte
        ws.row_dimensions[row[0].row].height = max_height

    # Ajout du texte en bas du fichier
    creation_date = datetime.now().strftime("%Y-%m-%d %H:%M:%S")
    footer_row1 = [f"Créé par: {creator_name}"] + [""] * (len(headers) - 1)
    footer_row2 = [f"Date de création: {creation_date}"] + [""] * (len(headers) - 1)
    ws.append([""] * (empty_columns_each_side + len(headers)))  # Ligne vide
    ws.append(footer_row1)
    ws.append(footer_row2)

    # Centrer le contenu des cellules du pied de page
    for row in ws.iter_rows(min_row=ws.max_row - 1, max_row=ws.max_row, min_col=data_start_col, max_col=data_start_col + len(headers) - 1):
        for cell in row:
            cell.alignment = Alignment(horizontal='center', vertical='center')

    # Enregistrement du fichier Excel
    wb.save("bonnes_pratiques.xlsx")
    print("Excel généré avec succès !")

# Nom du créateur (à remplacer par le nom réel)
creator_name = "Mathis"

export_to_excel(liste_bp, creator_name)









