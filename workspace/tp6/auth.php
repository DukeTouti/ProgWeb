<?php

class Auth {

	/**
	 * Redirige vers login.php si aucune session active.
	 */
	public static function requireLogin() : void {
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
	public static function requireRole(string $roleRequis) : void {
		if (session_status() === PHP_SESSION_NONE) {
			session_start();
		}

		$role = $_SESSION['role'] ?? 'visiteur';

		if ($role !== $roleRequis) {
			$_SESSION['erreur_acces'] = "Accès refusé : vous devez être $roleRequis pour effectuer cette action.";
			header('Location: catalogue.php');
			exit;
		}
	}

	/**
	 * Retourne true si l'utilisateur connecté est admin.
	 */
	public static function isAdmin() : bool {
		if (session_status() === PHP_SESSION_NONE) {
			session_start();
		}

		return isset($_SESSION['role']) && $_SESSION['role'] === 'admin';
	}
}
