<?php

namespace App\Controllers;

require_once __DIR__ . '/../Domain/Services/ProductService.php';
require_once __DIR__ . '/../Domain/Services/CategoryService.php';
require_once __DIR__ . '/../Core/Validator.php';

use Core\Validator;
use App\Domain\Services\ProductService;
use App\Domain\Services\CategoryService;

class ProductController
{

  protected $productService;
  protected $categoryService;

  public function __construct()
  {
    $this->productService = new ProductService();
    $this->categoryService = new CategoryService();
  }


  public function showProductPage()
  {


    session_start();
    if ($_SESSION['user']) {
      $searchTerm = $_GET['q'];
      if ($searchTerm == null || empty($searchTerm)) {
        header('Location: /');
        exit();
      }
      $product = $this->productService->getProduct($searchTerm);
      require_once __DIR__ . '/../Views/product.php';
    } else {
      header('Location: /connexion');
    }
    unset($_SESSION['errors_message']);
  }

  public function showStockPage()
  {
    session_start();
    if ($_SESSION['user'] && $_SESSION['user']->getRole()->getName() == 'supplier') {
      $categories = $this->categoryService->getCategories();
      $products = $this->productService->getSupplierProducts($_SESSION['user']->getId());
      $targetDirectory = __DIR__ . '/../../storage';
      require_once __DIR__ . '/../Views/stock.php';
    } else {
      header('Location: /');
    }
    unset($_SESSION['errors_message']);
  }

  public function addProduct()
  {
    try {
      session_start();
      $validator = new Validator($_POST);
      $errors = [];
      $rules = [
        'name' => 'required',
        'price' => 'required|numeric|min:1',
        'quantity' => 'required|numeric',
        'category' => 'required',
        //'website' => 'required|url'
      ];

      $imageName = time() . '.' . $_FILES['image']['name'];
      $targetDirectory = __DIR__ . '/../../storage';
      $targetPath = $targetDirectory . '/' . $imageName;

      $name = $_POST['name'];
      $price = $_POST['price'];
      $quantity = $_POST['quantity'];
      $description = $_POST['description'];
      $category_id = $_POST['category'];
      $supplier_id = $_SESSION['user']->getId();

      $result = $validator->isValidImage($_FILES['image']);
      if ($result !== true) {
        $errors['image'] = $result;
      }

      if (!$validator->validate($rules)) {
        $errors = array_merge($errors, $validator->getErrors());
      }

      if (!empty($errors)) {
        $_SESSION['errors_message'] = $errors;
        header('Location: /monstock');
        exit();
      }

      $imagePath = '';
      if (move_uploaded_file($_FILES['image']['tmp_name'], $targetPath)) {
        $imagePath = $imageName;
      }

      $result = $this->productService->createProduct($name, $description, $imagePath, $price, $quantity, $category_id, $supplier_id);
      header('Location: /monstock');
      exit();
    } catch (\Throwable $th) {
      throw new \Exception($th);
    }
  }

  public function deleteProduct()
  {
    try {
      // Vérifier si l'ID du produit à supprimer est présent dans la requête
      if (isset($_POST['product_id'])) {
        $productId = $_POST['product_id'];
        $this->productService->deleteProduct($productId);
      }
      header('Location: /monstock');
    } catch (\Throwable $th) {
      throw new \Exception($th);
    }
  }

  public function updateProduct()
  {
    try {
      session_start();
      $validator = new Validator($_POST);
      $errors = [];
      $rules = [
        'name' => 'required',
        'price' => 'required|numeric|min:1',
        'quantity' => 'required|numeric',
        'category' => 'required',
        'product_id' => 'required'
      ];

      $name = $_POST['name'];
      $id = $_POST['product_id'];
      $price = $_POST['price'];
      $quantity = $_POST['quantity'];
      $description = $_POST['description'];
      $category_id = $_POST['category'];
      $supplier_id = $_SESSION['user']->getId();


      if (!$validator->validate($rules)) {
        $errors = array_merge($errors, $validator->getErrors());
      }

      if (!empty($errors)) {
        $_SESSION['errors_message'] = $errors;
        header('Location: /monstock');
        exit();
      }

      $result = $this->productService->updateProduct($id, $name, $description, $price, $quantity, $category_id, $supplier_id);
      header('Location: /monstock');
      exit();
    } catch (\Throwable $th) {
      throw new \Exception($th);
    }
  }
}
