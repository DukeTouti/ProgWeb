<?php

class Auth {

	public static function requireLogin() : void {
		if (session_status() === PHP_SESSION_NONE) {
			session_start();
		}

		if (!isset($_SESSION['user'])) {
			header('Location: index.php?page=login');
			exit;
		}
	}

	public static function requireRole(string $roleRequis) : void {
		if (session_status() === PHP_SESSION_NONE) {
			session_start();
		}

		$role = $_SESSION['role'] ?? 'vendeur';

		if ($role !== $roleRequis) {
			$_SESSION['erreur_acces'] = "Accès refusé : vous devez être $roleRequis.";
			header('Location: index.php?page=dashboard');
			exit;
		}
	}

	public static function isAdmin() : bool {
		if (session_status() === PHP_SESSION_NONE) {
			session_start();
		}

		return isset($_SESSION['role']) && $_SESSION['role'] === 'admin';
	}

	public static function isVendeur() : bool {
		if (session_status() === PHP_SESSION_NONE) {
			session_start();
		}

		return isset($_SESSION['role']) && $_SESSION['role'] === 'vendeur';
	}

	public static function isFournisseur() : bool {
		if (session_status() === PHP_SESSION_NONE) {
			session_start();
		}

		return isset($_SESSION['role']) && $_SESSION['role'] === 'fournisseur';
	}

	public static function getCurrentUser() : array {
		if (session_status() === PHP_SESSION_NONE) {
			session_start();
		}

		return ['login' => $_SESSION['user'] ?? '', 'role' => $_SESSION['role'] ?? '', 'id' => $_SESSION['id'] ?? 0, 'nom' => $_SESSION['nom'] ?? ''];
	}
}

?>
