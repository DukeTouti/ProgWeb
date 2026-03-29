<?php
// Exécuter une seule fois dans le navigateur pour obtenir le hash
// Copier le résultat dans la requête INSERT de setup_tp6.sql
echo password_hash("cinema2025", PASSWORD_DEFAULT);
