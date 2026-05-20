<?php
// Auth.php - Classe utilitaire pour la gestion de l'authentification et des roles
// Devoir : implementation complete

class Auth
{
    /**
     * Redirige vers login.php si aucune session active.
     */
    public static function requireLogin(): void
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        if (!isset($_SESSION['utilisateur'])) {
            header('Location: login.php');
            exit;
        }
    }

    /**
     * Redirige vers catalogue.php avec un message d'erreur
     * si le role en session ne correspond pas a $roleRequis.
     */
    public static function requireRole(string $roleRequis): void
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        $roleActuel = $_SESSION['role'] ?? 'visiteur';
        if ($roleActuel !== $roleRequis) {
            // Stocker le message d'erreur en session pour l'afficher dans catalogue.php
            $_SESSION['erreur_acces'] = "Accès refusé : action réservée aux administrateurs.";
            header('Location: catalogue.php');
            exit;
        }
    }

    /**
     * Retourne true si l'utilisateur connecte est admin.
     */
    public static function isAdmin(): bool
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        return isset($_SESSION['role']) && $_SESSION['role'] === 'admin';
    }
}
