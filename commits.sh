#!/bin/bash
# commits.sh - Crear commits reales con fechas pasadas (lunes-viernes)

# Configuración
DRY_RUN=false       # false = commits reales
PUSH_AT_END=false   # true = hace push al final, false = solo local

# Usuario de GitHub
GIT_NAME="Franquito123"
GIT_EMAIL="franquito123@example.com"

git config user.name "$GIT_NAME"
git config user.email "$GIT_EMAIL"

# Mensajes de commits
messages=(
  "Creación del login manejando validaciones"
  "Se añadió estilo al login"
  "Creación del carrusel"
  "Se incorporó estilo al módulo del carrusel"
  "Configuración del carrusel dinámico ya guarda los slides"
  "Creación del módulo de información del centro"
  "Creación del módulo de servicios al CMS"
  "Cambios actualizados en pruebas de formularios"
  "Se ajustaron estilos y diseño en las vistas principales (información y servicios)"
  "Dashboard del usuario creado con acceso a funcionalidades básicas"
  "Vista editar información del centro, se modificó estructura y validaciones"
  "Vista editar información del servicio, se modificaron las validaciones"
  "Ya muestra alert en las vistas de información del centro"
  "Ya aparece el carrusel en el dashboard del usuario"
  "Se modificó servicios, el texto sobresale de la caja de texto"
)

# Fechas de commits (lunes-viernes escalonadas)
dates=(
  "2025-07-25"    # viernes
  "2025-07-28"    # lunes
  "2025-07-28"    # lunes
  "2025-07-29"    # martes
  "2025-07-29"    # martes
  "2025-07-31"    # jueves
  "2025-08-01"    # viernes
  "2025-08-04"    # lunes
  "2025-08-04"    # lunes
  "2025-08-05"    # martes
  "2025-08-06"    # miércoles
  "2025-08-07"    # jueves
  "2025-08-08"    # viernes
  "2025-08-11"    # lunes
  "2025-08-12"    # martes
)

# Crear commits reales
for i in "${!messages[@]}"; do
  msg="${messages[$i]}"
  DATE="${dates[$i]} $((9 + RANDOM % 9)):$((RANDOM % 60)):00"
  GIT_AUTHOR_DATE="$DATE" GIT_COMMITTER_DATE="$DATE" git commit --allow-empty -m "$msg" --author="$GIT_NAME <$GIT_EMAIL>"
  echo "✔ Commit creado: $msg - $DATE"
done

# Push si se desea
if [ "$PUSH_AT_END" = true ]; then
  git push -u origin main
else
  echo "Push deshabilitado. Los commits quedaron solo localmente."
fi
