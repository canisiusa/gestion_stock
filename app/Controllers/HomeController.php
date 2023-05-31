<?php

namespace App\Controllers;

require_once __DIR__ . '/../Domain/Services/ProductService.php';


use App\Domain\Services\ProductService;


class HomeController
{

    protected $productService;

    public function __construct()
    {
        $this->productService = new ProductService();
    }

    public function showHomePage()
    {
        session_start();
        if ($_SESSION['user']) {
            $searchTerm = $_GET['search'];
            $products = $this->productService->getHomeProducts($searchTerm);
             require_once __DIR__ . '/../Views/home.php';
        } else {
            header('Location: /connexion');
        }
    }
}
