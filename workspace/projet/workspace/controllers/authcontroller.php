<?php

class AuthController extends Controller {

	public function handle(string $page) : void {
		if ($page === 'logout') {
			$this->logout();
		} else {
			$this->login();
		}
	}

	private function login() : void {
		if (isset($_SESSION['user'])) {
			$this->redirect('dashboard');
		}

		$erreur = '';

		if ($_SERVER['REQUEST_METHOD'] === 'POST') {
			$login = trim($_POST['login'] ?? '');
			$password = trim($_POST['password'] ?? '');

			require_once 'models/user.php';

			$u = new User('', '', '', '');
			$user = $u->findByLogin($this->pdo, $login);

			if ($user && password_verify($password, $user->getPassword())) {
				$_SESSION['user'] = $user->getLogin();
				$_SESSION['role'] = $user->getRole();
				$_SESSION['id'] = $user->getId();
				$_SESSION['nom'] = $user->getNom() . ' ' . $user->getPrenom();

				setcookie('derniere_connexion', date('d/m/Y H:i'), time() + 30 * 24 * 3600, '/');

				$this->redirect('dashboard');
			} else {
				$erreur = "Identifiants incorrects. Veuillez réessayer.";
			}
		}

		$this->render('login', ['erreur' => $erreur]);
	}

	private function logout() : void {
		session_unset();
		session_destroy();

		header('Location: index.php?page=login');
		exit;
	}
}

?>
