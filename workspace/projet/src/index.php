<?php
session_start();

require_once 'src/auth.php';
require_once 'src/controller.php';

$page = $_GET['page'] ?? 'dashboard';

switch ($page) {

	case 'login':
	case 'logout':
		require_once 'controllers/authController.php';
		$ctrl = new AuthController();
		$ctrl->handle($page);
		break;

	case 'dashboard':
		require_once 'controllers/adminController.php';
		$ctrl = new AdminController();
		$ctrl->dashboard();
		break;

	case 'products':
	case 'product-add':
	case 'product-edit':
	case 'product-delete':
		require_once 'controllers/productController.php';
		$ctrl = new ProductController();
		$ctrl->handle($page);
		break;

	case 'caisse':
	case 'sale-validate':
	case 'history':
		require_once 'controllers/saleController.php';
		$ctrl = new SaleController();
		$ctrl->handle($page);
		break;

	case 'users':
	case 'user-add':
	case 'user-edit':
	case 'user-delete':
	case 'suppliers':
	case 'supplier-add':
	case 'supplier-edit':
	case 'supplier-delete':
		require_once 'controllers/adminController.php';
		$ctrl = new AdminController();
		$ctrl->handle($page);
		break;

	default:
		require_once 'controllers/adminController.php';
		$ctrl = new AdminController();
		$ctrl->dashboard();
		break;
}

?>
