# Guide du dépôt grav-theme-no-js

- En français. Ne jamais versionner de secret ni de configuration réelle de site.
- Déploiement : à chaque push sur `main`, `.github/workflows/deploy.yml` envoie le dépôt par rsync sur SSH (secrets
  `FTP_SERVER`, `FTP_USERNAME`, `FTP_PASSWORD`) vers `<home>/shared/grav-2/user/themes/no-js/`.
  Le dossier du serveur est un miroir du dépôt (fichiers en trop supprimés) ; tout fichier remplacé ou supprimé est
  d'abord gardé dans `<home>/tmp/deploy-backups/grav-theme-no-js/<date>/`. Exclus : `.git`, `.github`, `.gitignore`, `AGENTS.md`.
- Utilisé par tous les sites Grav 2 de l'hébergement : tester avant de pousser.
- La tâche planifiée de mise à jour (php-global-page-router) ne touche jamais cette extension (« github.com/flavi1 »).
- Thème sombre (23/10/2026) : `css/classless-dark.css` (no-js) et `css/custom-dark.css` (thème enfant, facultatif) sont des
  feuilles à part, sans `@media` interne, chargées en dernier avec `media="(prefers-color-scheme: dark)"`
  (`templates/partials/assets.html.twig`). Forcer plus tard sans JavaScript : définir `dark_css_media` ('all' = toujours
  sombre, 'not all' = jamais) avant l'include. Favicon sombre : `images/favicon-dark.ico` du thème, s'il existe.
