<?php

class SaleItem {

	// Attributs
	private int $id;
	private int $idVente;
	private int $idProduit;
	private int $quantite;
	private float $prixUnitaire;

	// Constructeur
	public function __construct(int $idVente, int $idProduit, int $quantite, float $prixUnitaire, int $id = 0) {
		$this->idVente = $idVente;
		$this->idProduit = $idProduit;
		$this->quantite = $quantite;
		$this->prixUnitaire = $prixUnitaire;
		$this->id = $id;
	}

	// Getters et Setters
	public function getId() {
		return $this->id;
	}
	
	public function getIdVente() {
		return $this->idVente;
	}
	
	public function getIdProduit() {
		return $this->idProduit;
	}
	
	public function getQuantite() {
		return $this->quantite;
	}
	
	public function getPrixUnitaire() {
		return $this->prixUnitaire;
	}

	// Sous-total de la ligne
	public function getSousTotal() : float {
		return $this->quantite * $this->prixUnitaire;
	}

	// Méthodes PDO

	public function save(PDO $pdo) : bool {
		$sql = "INSERT INTO sale_items (id_vente, id_produit, quantite, prix_unitaire)
				VALUES (?, ?, ?, ?)";

		$stmt = $pdo->prepare($sql);
		$stmt->bindValue(1, $this->idVente, PDO::PARAM_INT);
		$stmt->bindValue(2, $this->idProduit, PDO::PARAM_INT);
		$stmt->bindValue(3, $this->quantite, PDO::PARAM_INT);
		$stmt->bindValue(4, $this->prixUnitaire, PDO::PARAM_STR);

		return $stmt->execute();
	}

	public function getBySale(PDO $pdo, int $idVente) : array {
		$sql = "SELECT si.*, p.nom AS nom_produit
				FROM sale_items si
				JOIN products p ON si.id_produit = p.id
				WHERE si.id_vente = ?";

		$stmt = $pdo->prepare($sql);
		$stmt->bindValue(1, $idVente, PDO::PARAM_INT);
		$stmt->execute();

		$items = [];

		while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
			$item = new SaleItem((int)$row['id_vente'], (int)$row['id_produit'], (int)$row['quantite'], (float)$row['prix_unitaire'],
					     (int)$row['id']);

			$item->nomProduit = $row['nom_produit'];
			$items[] = $item;
		}

		return $items;
	}
}

?>
