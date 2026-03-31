<?php

class SaleController extends Controller {

	public function handle(string $page) : void {
		Auth::requireLogin();

		switch ($page) {
			case 'caisse':
				Auth::requireRole('vendeur');
				$this->caisse();
				break;
			case 'sale-validate':
				Auth::requireRole('vendeur');
				$this->validate();
				break;
			case 'history':
				$this->history();
				break;
			default:
				$this->caisse();
				break;
		}
	}

	private function caisse() : void {
		require_once 'models/product.php';

		$p = new Product('');
		$products = $p->getAll($this->pdo);
		$message = '';

		if (isset($_SESSION['erreur_acces'])) {
			$message = $_SESSION['erreur_acces'];
			unset($_SESSION['erreur_acces']);
		}

		$this->render('sales/caisse', ['products' => $products, 'message' => $message]);
	}

	private function validate() : void {
		require_once 'models/product.php';
		require_once 'models/sale.php';
		require_once 'models/saleitem.php';

		if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
			$this->redirect('caisse');
		}

		$panier = $_POST['panier'] ?? [];

		if (empty($panier)) {
			$_SESSION['erreur_acces'] = "Le panier est vide.";
			$this->redirect('caisse');
		}

		$totalTtc = 0.0;
		$lignes = [];
		$p = new Product('');

		foreach ($panier as $idProduit => $quantite) {
			$idProduit = (int)$idProduit;
			$quantite = (int)$quantite;

			if ($quantite <= 0) {
				continue;
			}

			$product = $p->findById($this->pdo, $idProduit);

			if (!$product) {
				continue;
			}

			if ($product->getQuantiteStock() < $quantite) {
				$_SESSION['erreur_acces'] = "Stock insuffisant pour : " . $product->getNom();
				$this->redirect('caisse');
			}

			$totalTtc += $product->getPrixVente() * $quantite;
			$lignes[] = ['product' => $product, 'quantite' => $quantite];
		}

		if (empty($lignes)) {
			$this->redirect('caisse');
		}

		$sale = new Sale($_SESSION['id'], $totalTtc);
		$idVente = $sale->save($this->pdo);

		foreach ($lignes as $ligne) {
			$item = new SaleItem($idVente, $ligne['product']->getId(), $ligne['quantite'], $ligne['product']->getPrixVente());
			$item->save($this->pdo);
			$ligne['product']->updateStock($this->pdo, $ligne['quantite']);
		}

		$this->render('sales/confirmation', ['totalTtc' => $totalTtc, 'lignes' => $lignes]);
	}

	private function history() : void {
		require_once 'models/sale.php';

		$s = new Sale(0);

		if (Auth::isAdmin()) {
			$sales = $s->getAll($this->pdo);
		} else {
			$sales = $s->getByVendeur($this->pdo, $_SESSION['id']);
		}

		$this->render('sales/history', ['sales' => $sales]);
	}
}

?>
