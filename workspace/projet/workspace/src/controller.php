<?php

abstract class Controller {

	protected PDO $pdo;

	public function __construct() {
		require_once __DIR__ . '/../config.php';
		$this->pdo = getConnexion();
	}

	protected function render(string $vue, array $data = []) : void {
		extract($data);
		require_once __DIR__ . '/../views/layout.php';
	}

	protected function redirect(string $page, array $params = []) : void {
		$url = 'index.php?page=' . $page;

		foreach ($params as $key => $val) {
			$url .= '&' . urlencode($key) . '=' . urlencode($val);
		}

		header('Location: ' . $url);
		exit;
	}
}

?>
