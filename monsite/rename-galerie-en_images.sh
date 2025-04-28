#!/bin/bash

# 1. Renommer les dossiers (en profondeur)
find . -depth -type d \( -iname "*images*" -o -iname "*images*" \) | while read dir; do
    newdir=$(echo "$dir" | sed -E 's/[Gg]aleries?/images/g')
    echo "Renommage dossier : $dir -> $newdir"
    mv "$dir" "$newdir"
done

# 2. Renommer les fichiers contenant images/images dans leur nom
find . -type f \( -iname "*images*" -o -iname "*images*" \) | while read file; do
    newfile=$(echo "$file" | sed -E 's/[Gg]aleries?/images/g')
    echo "Renommage fichier : $file -> $newfile"
    mv "$file" "$newfile"
done

# 3. Remplacer dans le contenu des fichiers
find . -type f -exec sed -i -E '
    s/\b[Gg]aleries\b/images/g;
    s/\b[Gg]alerie\b/images/g
' {} +

echo "✅ Tous les dossiers, fichiers et contenus ont été mis à jour vers « images »."
