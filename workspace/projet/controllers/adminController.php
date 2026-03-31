<?php

class AdminController extends Controller {

	public function dashboard() : void {
		Auth::requireLogin();

		require_once 'models/product.php';
		require_once 'models/sale.php';
		require_once 'models/user.php';

		$statsVentes = (new Sale(0))->getCA($this->pdo);
		$statsProduits = (new Product(''))->getStats($this->pdo);
		$lowStock = (new Product(''))->getLowStock($this->pdo);

		if (!Auth::isAdmin()) {
			$statsVentes = [];
		}

		$erreurAcces = '';
		if (isset($_SESSION['erreur_acces'])) {
			$erreurAcces = $_SESSION['erreur_acces'];
			unset($_SESSION['erreur_acces']);
		}

		$this->render('dashboard', ['statsVentes' => $statsVentes, 'statsProduits' => $statsProduits, 'lowStock' => $lowStock,
					    'erreurAcces' => $erreurAcces]);
	}

	public function handle(string $page) : void {
		Auth::requireLogin();
		Auth::requireRole('admin');

		switch ($page) {
			case 'users':
				$this->users();
				break;
			case 'user-add':
				$this->userAdd();
				break;
			case 'user-edit':
				$this->userEdit();
				break;
			case 'user-delete':
				$this->userDelete();
				break;
			case 'suppliers':
				$this->suppliers();
				break;
			case 'supplier-add':
				$this->supplierAdd();
				break;
			case 'supplier-edit':
				$this->supplierEdit();
				break;
			case 'supplier-delete':
				$this->supplierDelete();
				break;
			default:
				$this->dashboard();
				break;
		}
	}

	private function users() : void {
		require_once 'models/user.php';

		$users = (new User('', '', '', ''))->getAll($this->pdo);

		$this->render('admin/users', ['users' => $users]);
	}

	private function userAdd() : void {
		require_once 'models/user.php';

		$message = '';
		$erreur = false;

		if ($_SERVER['REQUEST_METHOD'] === 'POST') {
			$nom = trim($_POST['nom'] ?? '');
			$prenom = trim($_POST['prenom'] ?? '');
			$login = trim($_POST['login'] ?? '');
			$password = trim($_POST['password'] ?? '');
			$role = trim($_POST['role'] ?? 'vendeur');

			$hash = password_hash($password, PASSWORD_DEFAULT);
			$user = new User($nom, $prenom, $login, $hash, $role);

			if ($user->save($this->pdo)) {
				$message = "Utilisateur \"$login\" créé avec succès.";
			} else {
				$message = "Erreur lors de la création.";
				$erreur = true;
			}
		}

		$this->render('admin/user_form', ['mode' => 'add', 'message' => $message, 'erreur' => $erreur, 'user' => null]);
	}

	private function userEdit() : void {
		require_once 'models/user.php';

		$id = (int)($_GET['id'] ?? $_POST['id'] ?? 0);
		$message = '';
		$erreur = false;
		$user = null;

		if ($_SERVER['REQUEST_METHOD'] === 'POST') {
			$nom = trim($_POST['nom'] ?? '');
			$prenom = trim($_POST['prenom'] ?? '');
			$login = trim($_POST['login'] ?? '');
			$role = trim($_POST['role'] ?? 'vendeur');

			$user = new User($nom, $prenom, $login, '', $role, $id);

			if ($user->update($this->pdo)) {
				$this->redirect('users');
			} else {
				$message = "Erreur lors de la mise à jour.";
				$erreur = true;
			}
		}

		if ($user === null) {
			$user = (new User('', '', '', ''))->findById($this->pdo, $id);
		}

		$this->render('admin/user_form', ['mode' => 'edit', 'message' => $message, 'erreur' => $erreur,	'user' => $user]);
	}

	private function userDelete() : void {
		require_once 'models/user.php';

		$id = (int)($_GET['id'] ?? 0);
		$message = '';
		$erreur = false;

		if ($id <= 0) {
			$message = "Identifiant invalide.";
			$erreur = true;
		} else {
			if ((new User('', '', '', ''))->delete($this->pdo, $id)) {
				$message = "Utilisateur supprimé avec succès.";
			} else {
				$message = "Erreur lors de la suppression.";
				$erreur = true;
			}
		}

		$this->render('admin/delete', ['message' => $message, 'erreur' => $erreur, 'retour' => 'users']);
	}

	private function suppliers() : void {
		require_once 'models/supplier.php';

		$suppliers = (new Supplier(''))->getAll($this->pdo);

		$this->render('admin/suppliers', ['suppliers' => $suppliers]);
	}

	private function supplierAdd() : void {
		require_once 'models/supplier.php';
		require_once 'models/user.php';

		$message = '';
		$erreur = false;
		$users = (new User('', '', '', ''))->getAll($this->pdo);

		if ($_SERVER['REQUEST_METHOD'] === 'POST') {
			$nom = trim($_POST['nom'] ?? '');
			$email = trim($_POST['email'] ?? '');
			$telephone = trim($_POST['telephone'] ?? '');
			$idUser = (int)($_POST['id_user'] ?? 0);

			$supplier = new Supplier($nom, $email, $telephone, $idUser);

			if ($supplier->save($this->pdo)) {
				$message = "Fournisseur \"$nom\" ajouté avec succès.";
			} else {
				$message = "Erreur lors de l'ajout.";
				$erreur = true;
			}
		}

		$this->render('admin/supplier_form', ['mode' => 'add', 'message' => $message, 'erreur' => $erreur, 'supplier' => null,
						      'users' => $users]);
	}

	private function supplierEdit() : void {
		require_once 'models/supplier.php';
		require_once 'models/user.php';

		$id = (int)($_GET['id'] ?? $_POST['id'] ?? 0);
		$message = '';
		$erreur = false;
		$supplier = null;
		$users = (new User('', '', '', ''))->getAll($this->pdo);

		if ($_SERVER['REQUEST_METHOD'] === 'POST') {
			$nom = trim($_POST['nom'] ?? '');
			$email = trim($_POST['email'] ?? '');
			$telephone = trim($_POST['telephone'] ?? '');
			$idUser = (int)($_POST['id_user'] ?? 0);

			$supplier = new Supplier($nom, $email, $telephone, $idUser, $id);

			if ($supplier->update($this->pdo)) {
				$this->redirect('suppliers');
			} else {
				$message = "Erreur lors de la mise à jour.";
				$erreur = true;
			}
		}

		if ($supplier === null) {
			$supplier = (new Supplier(''))->findById($this->pdo, $id);
		}

		$this->render('admin/supplier_form', ['mode' => 'edit', 'message' => $message, 'erreur' => $erreur, 'supplier' => $supplier,
						      'users' => $users]);
	}

	private function supplierDelete() : void {
		require_once 'models/supplier.php';

		$id = (int)($_GET['id'] ?? 0);
		$message = '';
		$erreur = false;

		if ($id <= 0) {
			$message = "Identifiant invalide.";
			$erreur = true;
		} else {
			if ((new Supplier(''))->delete($this->pdo, $id)) {
				$message = "Fournisseur supprimé avec succès.";
			} else {
				$message = "Erreur lors de la suppression.";
				$erreur = true;
			}
		}

		$this->render('admin/delete', ['message' => $message, 'erreur' => $erreur, 'retour' => 'suppliers']);
	}
}

?>
