<?php

class Product {

	// Attributs 
	private int $id;
	private string $nom;
	private string $description;
	private float $prixAchat;
	private float $prixVente;
	private int $quantiteStock;
	private int $seuilAlerte;
	private int $idCategorie;
	private int $idFournisseur;

	// Constructeur
	public function __construct(string $nom, string $description = '', float $prixAchat = 0.0, float $prixVente = 0.0, int $quantiteStock = 0,
				    int $seuilAlerte = 5, int $idCategorie = 0,	int $idFournisseur = 0, int $id = 0) {
		$this->nom = $nom;
		$this->description = $description;
		$this->prixAchat = $prixAchat;
		$this->prixVente = $prixVente;
		$this->quantiteStock = $quantiteStock;
		$this->seuilAlerte = $seuilAlerte;
		$this->idCategorie = $idCategorie;
		$this->idFournisseur = $idFournisseur;
		$this->id = $id;
	}

	// Getters et Setters
	public function getId() {
		return $this->id;
	}
	
	public function getNom() {
		return $this->nom;
	}
	
	public function setNom(string $nom) {
		$this->nom = $nom;           
	}
	
	public function getDescription() {
		return $this->description;
	}
	
	public function setDescription(string $desc) {
		$this->description = $desc;
	}
	
	public function getPrixAchat() {
		return $this->prixAchat;
	}
	
	public function setPrixAchat(float $prix) {
		$this->prixAchat = $prix;          
	}
	
	public function getPrixVente() {
		return $this->prixVente;
	}
	
	public function setPrixVente(float $prix) {
		$this->prixVente = $prix;          
	}
	
	public function getQuantiteStock() {
		return $this->quantiteStock;
	}
	
	public function setQuantiteStock(int $qty) {
		$this->quantiteStock = $qty;
	}
	
	public function getSeuilAlerte() {
		return $this->seuilAlerte;
	}
	
	public function setSeuilAlerte(int $seuil) {
		$this->seuilAlerte = $seuil;
	}
	
	public function getIdCategorie() {
		return $this->idCategorie;
	}
	
	public function setIdCategorie(int $idCat) {
		$this->idCategorie = $idCat;
	}
	
	public function getIdFournisseur() {
		return $this->idFournisseur;
	}
	
	public function setIdFournisseur(int $idFourn) {
		$this->idFournisseur = $idFourn;
	}

	// Méthode métier
	public function isLowStock() : bool {
		return $this->quantiteStock <= $this->seuilAlerte;
	}

	public function updateStock(PDO $pdo, int $quantite) : bool {
		$sql = "UPDATE products SET quantite_stock = quantite_stock - ? WHERE id = ?";

		$stmt = $pdo->prepare($sql);
		$stmt->bindValue(1, $quantite, PDO::PARAM_INT);
		$stmt->bindValue(2, $this->id, PDO::PARAM_INT);

		return $stmt->execute();
	}

	// Méthodes PDO
	public function save(PDO $pdo) : bool {
		$sql = "INSERT INTO products (nom, description, prix_achat, prix_vente, quantite_stock, seuil_alerte, id_categorie, id_fournisseur)
				VALUES (?, ?, ?, ?, ?, ?, ?, ?)";

		$stmt = $pdo->prepare($sql);
		$stmt->bindValue(1, $this->nom, PDO::PARAM_STR);
		$stmt->bindValue(2, $this->description, PDO::PARAM_STR);
		$stmt->bindValue(3, $this->prixAchat, PDO::PARAM_STR);
		$stmt->bindValue(4, $this->prixVente, PDO::PARAM_STR);
		$stmt->bindValue(5, $this->quantiteStock, PDO::PARAM_INT);
		$stmt->bindValue(6, $this->seuilAlerte, PDO::PARAM_INT);
		$stmt->bindValue(7, $this->idCategorie > 0 ? $this->idCategorie : null, PDO::PARAM_INT);
		$stmt->bindValue(8, $this->idFournisseur > 0 ? $this->idFournisseur : null, PDO::PARAM_INT);

		return $stmt->execute();
	}

	public function update(PDO $pdo) : bool {
		$sql = "UPDATE products
			SET nom = ?, description = ?, prix_achat = ?, prix_vente = ?, quantite_stock = ?, seuil_alerte = ?, id_categorie = ?,
				id_fournisseur = ?
			WHERE id = ?";

		$stmt = $pdo->prepare($sql);
		$stmt->bindValue(1, $this->nom, PDO::PARAM_STR);
		$stmt->bindValue(2, $this->description, PDO::PARAM_STR);
		$stmt->bindValue(3, $this->prixAchat, PDO::PARAM_STR);
		$stmt->bindValue(4, $this->prixVente, PDO::PARAM_STR);
		$stmt->bindValue(5, $this->quantiteStock, PDO::PARAM_INT);
		$stmt->bindValue(6, $this->seuilAlerte, PDO::PARAM_INT);
		$stmt->bindValue(7, $this->idCategorie > 0 ? $this->idCategorie : null, PDO::PARAM_INT);
		$stmt->bindValue(8, $this->idFournisseur > 0 ? $this->idFournisseur : null, PDO::PARAM_INT);
		$stmt->bindValue(9, $this->id, PDO::PARAM_INT);

		return $stmt->execute();
	}

	public function delete(PDO $pdo, int $id) : bool {
		$sql = "DELETE FROM products WHERE id = ?";

		$stmt = $pdo->prepare($sql);
		$stmt->bindValue(1, $id, PDO::PARAM_INT);

		return $stmt->execute();
	}

	public function getAll(PDO $pdo) : array {
		$sql = "SELECT p.*, c.nom AS nom_categorie, s.nom AS nom_fournisseur
			FROM products p
			LEFT JOIN categories c ON p.id_categorie   = c.id
			LEFT JOIN suppliers  s ON p.id_fournisseur = s.id
			ORDER BY p.nom ASC";

		$stmt = $pdo->query($sql);

		return $this->hydrateAll($stmt);
	}

	public function findById(PDO $pdo, int $id) : ?Product {
		$sql = "SELECT p.*, c.nom AS nom_categorie, s.nom AS nom_fournisseur
			FROM products p
			LEFT JOIN categories c ON p.id_categorie   = c.id
			LEFT JOIN suppliers  s ON p.id_fournisseur = s.id
			WHERE p.id = ?";

		$stmt = $pdo->prepare($sql);
		$stmt->bindValue(1, $id, PDO::PARAM_INT);
		$stmt->execute();

		$row = $stmt->fetch(PDO::FETCH_ASSOC);

		if ($row === false) {
			return null;
		}

		return $this->hydrate($row);
	}

	public function search(PDO $pdo, string $nom = '', int $idCategorie = 0, int $idFournisseur = 0) : array {
		$sql = "SELECT p.*, c.nom AS nom_categorie, s.nom AS nom_fournisseur
			   FROM products p
			   LEFT JOIN categories c ON p.id_categorie   = c.id
			   LEFT JOIN suppliers  s ON p.id_fournisseur = s.id
			   WHERE 1=1";
			   
		$params = [];

		if ($nom !== '') {
			$sql .= " AND p.nom LIKE ?";
			$params[] = '%' . $nom . '%';
		}

		if ($idCategorie > 0) {
			$sql .= " AND p.id_categorie = ?";
			$params[] = $idCategorie;
		}

		if ($idFournisseur > 0) {
			$sql .= " AND p.id_fournisseur = ?";
			$params[] = $idFournisseur;
		}

		$sql .= " ORDER BY p.nom ASC";

		$stmt = $pdo->prepare($sql);

		foreach ($params as $i => $val) {
			$stmt->bindValue($i + 1, $val, PDO::PARAM_STR);
		}

		$stmt->execute();

		return $this->hydrateAll($stmt);
	}

	public function getLowStock(PDO $pdo) : array {
		$sql = "SELECT p.*, c.nom AS nom_categorie, s.nom AS nom_fournisseur
			FROM products p
			LEFT JOIN categories c ON p.id_categorie   = c.id
			LEFT JOIN suppliers  s ON p.id_fournisseur = s.id
			WHERE p.quantite_stock <= p.seuil_alerte
			ORDER BY p.quantite_stock ASC";

		$stmt = $pdo->query($sql);

		return $this->hydrateAll($stmt);
	}

	public function getByFournisseur(PDO $pdo, int $idFournisseur) : array {
		$sql = "SELECT p.*, c.nom AS nom_categorie, s.nom AS nom_fournisseur
			FROM products p
			LEFT JOIN categories c ON p.id_categorie   = c.id
			LEFT JOIN suppliers  s ON p.id_fournisseur = s.id
			WHERE p.id_fournisseur = ?
			ORDER BY p.nom ASC";

		$stmt = $pdo->prepare($sql);
		$stmt->bindValue(1, $idFournisseur, PDO::PARAM_INT);
		$stmt->execute();

		return $this->hydrateAll($stmt);
	}

	// Statistiques (dashboard admin)
	public function getStats(PDO $pdo) : array {
		$sql = "SELECT
				COUNT(*) AS total_produits,
				SUM(quantite_stock) AS total_stock,
				SUM(quantite_stock * prix_vente) AS valeur_stock,
				SUM(quantite_stock <= seuil_alerte) AS alertes
			FROM products";

		$stmt = $pdo->query($sql);
		$row  = $stmt->fetch(PDO::FETCH_ASSOC);

		return ['total_produits' => (int)$row['total_produits'], 'total_stock' => (int)$row['total_stock'],
		        'valeur_stock' => (float)$row['valeur_stock'], 'alertes' => (int)$row['alertes'],
		];
	}

	// Helpers privés
	private function hydrate(array $row) : Product {
		$p = new Product($row['nom'], $row['description'], (float)$row['prix_achat'], (float)$row['prix_vente'],
				 (int)$row['quantite_stock'], (int)$row['seuil_alerte'], (int)$row['id_categorie'], (int)$row['id_fournisseur'],
				 (int)$row['id']);

		// Données jointes dispo dans la vue sans requête supplémentaire
		$p->nomCategorie   = $row['nom_categorie'] ?? '';
		$p->nomFournisseur = $row['nom_fournisseur'] ?? '';

		return $p;
	}

	private function hydrateAll(PDOStatement $stmt) : array {
		$products = [];

		while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
			$products[] = $this->hydrate($row);
		}

		return $products;
	}
}

?>
