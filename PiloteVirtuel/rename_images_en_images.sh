#!/bin/bash

# 1. Renommer les dossiers (en profondeur)
find . -depth -type d -iname "*images*" | while read dir; do
    newdir=$(echo "$dir" | sed -E 's/[Ii][Mm][Aa][Gg][Ee][Ss]/images/g')
    echo "Renommage dossier : $dir -> $newdir"
    mv "$dir" "$newdir"
done

# 2. Renommer les fichiers
find . -type f -iname "*images*" | while read file; do
    newfile=$(echo "$file" | sed -E 's/[Ii][Mm][Aa][Gg][Ee][Ss]/images/g')
    echo "Renommage fichier : $file -> $newfile"
    mv "$file" "$newfile"
done

# 3. Remplacer dans le contenu
find . -type f -exec sed -i -E '
    s/\b[Ii][Mm][Aa][Gg][Ee][Ss]\b/images/g
' {} +

echo "✅ Tous les noms et contenus avec « images » ont été remplacés par « images »."
