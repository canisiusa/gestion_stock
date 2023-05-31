<?php

namespace App\Controllers;

require_once __DIR__ . '/../Domain/Services/OrderService.php';
require_once __DIR__ . '/../Core/Validator.php';

use Core\Validator;
use App\Domain\Services\OrderService;
use Exception;

class OrderController
{

  protected $orderService;

  public function __construct()
  {
    $this->orderService = new OrderService();
  }
  public function showMyOrdersPage()
  {
    session_start();
    if ($_SESSION['user']) {
      $orders = $this->orderService->getMyOrders();
      require_once __DIR__ . '/../Views/myorders.php';
    } else {
      header('Location: /connexion');
    }
  }

  public function showOrdersPage()
  {
    session_start();
    if ($_SESSION['user']) {
      $orders = $this->orderService->getSupplierOrders();
      require_once __DIR__ . '/../Views/receivedorders.php';
    } else {
      header('Location: /connexion');
    }
  }

  public function createOrder()
  {
    try {
      session_start();
      $validator = new Validator($_POST);
      $errors = [];
      $rules = [
        'product_id' => 'required',
        'quantity' => 'required|numeric',
        'shipping_address' => 'required',
      ];

      $quantity = $_POST['quantity'];
      $shipping_address = $_POST['shipping_address'];
      $product_id = $_POST['product_id'];
      $customer_id = $_SESSION['user']->getId();

      if (!$validator->validate($rules)) {
        $errors = array_merge($errors, $validator->getErrors());
      }

      if (!empty($errors)) {
        $_SESSION['errors_message'] = $errors;
        header('Location: ' . $_SERVER['HTTP_REFERER']);
        exit;
      }

      $result = $this->orderService->createOrder(
        $quantity,
        $shipping_address,
        $product_id,
        $customer_id,
      );
      header('Location: /mescommandes');
      exit();
    } catch (\Throwable $th) {
      throw new \Exception($th);
    }
  }

  public function processOrder()
  {
    try {
      session_start();
      if ($_SESSION['user']) {
        $orderId = $_POST['order_id'];
        $this->orderService->processOrder($orderId);
        header('Location: /commandes_recues');
      } else {
        header('Location: /connexion');
      }
    } catch (\Throwable $th) {
      throw new Exception($th);
    }
  }
  public function completeOrder()
  {
    try {
      session_start();
      if ($_SESSION['user']) {
        $orderId = $_POST['order_id'];
        $this->orderService->completeOrder($orderId);
        header('Location: /commandes_recues');
      } else {
        header('Location: /connexion');
      }
    } catch (\Throwable $th) {
      throw new Exception($th);
    }
  }
}
