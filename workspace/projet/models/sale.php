<?php

class Sale {

	// Attributs
	private int $id;
	private int $idVendeur;
	private float $totalTtc;
	private string $dateVente;

	// Constructeur
	public function __construct(int $idVendeur, float $totalTtc = 0.0, string $dateVente = '', int $id = 0) {
		$this->idVendeur = $idVendeur;
		$this->totalTtc = $totalTtc;
		$this->dateVente = $dateVente;
		$this->id = $id;
	}

	// Getters et Setters
	public function getId() {
		return $this->id;
	}
	
	public function getIdVendeur() {
		return $this->idVendeur;
	}
	
	public function getTotalTtc() {
		return $this->totalTtc;
	}
	
	public function setTotalTtc(float $total) {
		$this->totalTtc = $total;
	}
	
	public function getDateVente() {
		return $this->dateVente;
	}

	public function setDateVente(string $date) {
		$this->dateVente = $date;
	}

	// Méthodes PDO
	public function save(PDO $pdo) : int {
		$sql = "INSERT INTO sales (id_vendeur, total_ttc) VALUES (?, ?)";

		$stmt = $pdo->prepare($sql);
		$stmt->bindValue(1, $this->idVendeur, PDO::PARAM_INT);
		$stmt->bindValue(2, $this->totalTtc, PDO::PARAM_STR);
		$stmt->execute();

		// Retourne l'id de la vente créée pour insérer les SaleItems
		return (int)$pdo->lastInsertId();
	}

	public function getAll(PDO $pdo) : array {
		$sql = "SELECT s.*, u.nom, u.prenom
			FROM sales s
			JOIN users u ON s.id_vendeur = u.id
			ORDER BY s.date_vente DESC";

		$stmt = $pdo->query($sql);

		return $this->hydrateAll($stmt);
	}

	public function getByVendeur(PDO $pdo, int $idVendeur) : array {
		$sql = "SELECT s.*, u.nom, u.prenom
			FROM sales s
			JOIN users u ON s.id_vendeur = u.id
			WHERE s.id_vendeur = ?
			ORDER BY s.date_vente DESC";

		$stmt = $pdo->prepare($sql);
		$stmt->bindValue(1, $idVendeur, PDO::PARAM_INT);
		$stmt->execute();

		return $this->hydrateAll($stmt);
	}

	public function findById(PDO $pdo, int $id) : ?Sale {
		$sql = "SELECT s.*, u.nom, u.prenom
			FROM sales s
			JOIN users u ON s.id_vendeur = u.id
			WHERE s.id = ?";

		$stmt = $pdo->prepare($sql);
		$stmt->bindValue(1, $id, PDO::PARAM_INT);
		$stmt->execute();

		$row = $stmt->fetch(PDO::FETCH_ASSOC);

		if ($row === false) {
			return null;
		}

		return $this->hydrate($row);
	}

	// Dashboard admin
	public function getCA(PDO $pdo) : array {
		$sql = "SELECT
				COUNT(*) AS total_ventes,
				SUM(total_ttc) AS chiffre_affaires,
				AVG(total_ttc) AS panier_moyen
			FROM sales";

		$stmt = $pdo->query($sql);
		$row  = $stmt->fetch(PDO::FETCH_ASSOC);

		return ['total_ventes' => (int)$row['total_ventes'], 'chiffre_affaires' => (float)$row['chiffre_affaires'],
			'panier_moyen' => (float)$row['panier_moyen']];
	}

	// Helpers privés
	private function hydrate(array $row) : Sale {
		$s = new Sale((int)$row['id_vendeur'], (float)$row['total_ttc'], $row['date_vente'], (int)$row['id']);

		$s->nomVendeur = $row['nom'] . ' ' . $row['prenom'];

		return $s;
	}

	private function hydrateAll(PDOStatement $stmt) : array {
		$sales = [];

		while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
			$sales[] = $this->hydrate($row);
		}

		return $sales;
	}
}

?>
