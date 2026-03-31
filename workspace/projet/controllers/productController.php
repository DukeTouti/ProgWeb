<?php

class ProductController extends Controller {

	public function handle(string $page) : void {
		Auth::requireLogin();

		switch ($page) {
			case 'products':
				$this->index();
				break;
			case 'product-add':
				Auth::requireRole('admin');
				$this->add();
				break;
			case 'product-edit':
				Auth::requireRole('admin');
				$this->edit();
				break;
			case 'product-delete':
				Auth::requireRole('admin');
				$this->delete();
				break;
			default:
				$this->index();
				break;
		}
	}

	private function index() : void {
		require_once 'models/product.php';
		require_once 'models/category.php';
		require_once 'models/supplier.php';

		$p = new Product('');

		$nom = trim($_GET['nom'] ?? '');
		$idCategorie = (int)($_GET['id_categorie'] ?? 0);
		$idFournisseur = (int)($_GET['id_fournisseur'] ?? 0);

		if ($nom !== '' || $idCategorie > 0 || $idFournisseur > 0) {
			$products = $p->search($this->pdo, $nom, $idCategorie, $idFournisseur);
		} else {
			$products = $p->getAll($this->pdo);
		}

		$lowStock = $p->getLowStock($this->pdo);
		$stats = $p->getStats($this->pdo);
		$categories = (new Category(''))->getAll($this->pdo);
		$suppliers = (new Supplier(''))->getAll($this->pdo);

		if (Auth::isFournisseur()) {
			$supplier = (new Supplier(''))->findByUserId($this->pdo, $_SESSION['id']);

			if ($supplier) {
				$products = $p->getByFournisseur($this->pdo, $supplier->getId());
				$lowStock = array_filter($products, fn($prod) => $prod->isLowStock());
			}
		}

		$erreurAcces = '';
		if (isset($_SESSION['erreur_acces'])) {
			$erreurAcces = $_SESSION['erreur_acces'];
			unset($_SESSION['erreur_acces']);
		}

		$this->render('products/index', [
			'products' => $products,
			'lowStock' => $lowStock,
			'stats' => $stats,
			'categories' => $categories,
			'suppliers' => $suppliers,
			'nom' => $nom,
			'idCategorie' => $idCategorie,
			'idFournisseur' => $idFournisseur,
			'erreurAcces' => $erreurAcces,
		]);
	}

	private function add() : void {
		require_once 'models/product.php';
		require_once 'models/category.php';
		require_once 'models/supplier.php';

		$message = '';
		$erreur = false;
		$categories = (new Category(''))->getAll($this->pdo);
		$suppliers = (new Supplier(''))->getAll($this->pdo);

		if ($_SERVER['REQUEST_METHOD'] === 'POST') {
			$nom = trim($_POST['nom'] ?? '');
			$description = trim($_POST['description'] ?? '');
			$prixAchat = (float)($_POST['prix_achat'] ?? 0);
			$prixVente = (float)($_POST['prix_vente'] ?? 0);
			$quantiteStock = (int)($_POST['quantite_stock'] ?? 0);
			$seuilAlerte = (int)($_POST['seuil_alerte'] ?? 5);
			$idCategorie = (int)($_POST['id_categorie'] ?? 0);
			$idFournisseur = (int)($_POST['id_fournisseur'] ?? 0);

			$product = new Product($nom, $description, $prixAchat, $prixVente, $quantiteStock, $seuilAlerte, $idCategorie,
					       $idFournisseur);

			if ($product->save($this->pdo)) {
				$message = "Produit \"$nom\" ajouté avec succès.";
			} else {
				$message = "Erreur lors de l'ajout du produit.";
				$erreur = true;
			}
		}

		$this->render('products/form', ['mode' => 'add', 'message' => $message, 'erreur' => $erreur, 'categories' => $categories,
						'suppliers' => $suppliers, 'product' => null]);
	}

	private function edit() : void {
		require_once 'models/product.php';
		require_once 'models/category.php';
		require_once 'models/supplier.php';

		$id = (int)($_GET['id'] ?? $_POST['id'] ?? 0);
		$message = '';
		$erreur = false;
		$categories = (new Category(''))->getAll($this->pdo);
		$suppliers = (new Supplier(''))->getAll($this->pdo);
		$product = null;

		if ($_SERVER['REQUEST_METHOD'] === 'POST') {
			$nom = trim($_POST['nom'] ?? '');
			$description = trim($_POST['description'] ?? '');
			$prixAchat = (float)($_POST['prix_achat'] ?? 0);
			$prixVente = (float)($_POST['prix_vente'] ?? 0);
			$quantiteStock = (int)($_POST['quantite_stock'] ?? 0);
			$seuilAlerte = (int)($_POST['seuil_alerte'] ?? 5);
			$idCategorie = (int)($_POST['id_categorie'] ?? 0);
			$idFournisseur = (int)($_POST['id_fournisseur'] ?? 0);

			$product = new Product($nom, $description, $prixAchat, $prixVente, $quantiteStock, $seuilAlerte, $idCategorie,
					       $idFournisseur, $id);

			if ($product->update($this->pdo)) {
				$this->redirect('products');
			} else {
				$message = "Erreur lors de la mise à jour.";
				$erreur = true;
			}
		}

		if ($product === null) {
			$product = (new Product(''))->findById($this->pdo, $id);
		}

		$this->render('products/form', ['mode' => 'edit', 'message' => $message, 'erreur' => $erreur, 'categories' => $categories,
						'suppliers' => $suppliers, 'product' => $product]);
	}

	private function delete() : void {
		require_once 'models/product.php';

		$id = (int)($_GET['id'] ?? 0);
		$message = '';
		$erreur = false;

		if ($id <= 0) {
			$message = "Identifiant invalide.";
			$erreur = true;
		} else {
			$p = new Product('');

			if ($p->delete($this->pdo, $id)) {
				$message = "Produit supprimé avec succès.";
			} else {
				$message = "Erreur lors de la suppression.";
				$erreur = true;
			}
		}

		$this->render('products/delete', ['message' => $message, 'erreur' => $erreur]);
	}
}

?>
