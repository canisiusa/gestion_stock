<?php

namespace App\Domain\Services;

require_once __DIR__ . '/../../Repositories/UserRepository.php';
require_once __DIR__ . '/../../Repositories/ProductRepository.php';
require_once __DIR__ . '/../../Repositories/CategoryRepository.php';
require_once __DIR__ . '/../../Repositories/OrderRepository.php';
require_once __DIR__ . '/../../Domain/Entities/User.php';
require_once __DIR__ . '/../../Domain/Entities/Order.php';

use App\Domain\Entities\Product;
use App\Domain\Entities\Order;
use App\Domain\Entities\User;
use App\Repositories\UserRepository;
use App\Repositories\OrderRepository;
use App\Repositories\ProductRepository;
use App\Repositories\CategoryRepository;

class OrderService
{
    protected $userRepository;
    protected $productRepository;
    protected $categoryRepository;
    private $orderRepository;



    public function __construct()
    {
        $this->userRepository = new UserRepository();
        $this->productRepository = new ProductRepository();
        $this->categoryRepository = new CategoryRepository();
        $this->orderRepository = new OrderRepository();
    }

    public function createOrder(
        int $quantity,
        string $shipping_address,
        int $product_id,
        int $customer_id,
    ) {
        $user = $this->userRepository->findById($customer_id);
        if (!$user) {
            throw new \Exception("L'utilisateur n'existe n'existe pas.");
        }

        $prod = $this->productRepository->findById($product_id);
        if (!$prod) {
            throw new \Exception("Le produit n'existe n'existe pas.");
        }


        // Création de l'utilisateur
        $order = new Order(
            customer: $user,
            ordered_at: date("Y-m-d H:i:s"),
            amount: $quantity * $prod->getPrice(),
            status: 'pending',
            shipping_address: $shipping_address,
            product: $prod,
            quantity: $quantity,
        );

        // Enregistrement en base de données
        $this->orderRepository->save($order);

        return $user;
    }

    public function getMyOrders()
    {
        $user = $_SESSION["user"];
        return $this->orderRepository->findCustomerOrders($user->getId());
    }
    public function getSupplierOrders()
    {
        $user = $_SESSION["user"];
        return $this->orderRepository->findSupplierOrders($user->getId());
    }

    public function processOrder($order_id)
    {
        $order =  $this->orderRepository->findById($order_id);
        if (!$order) {
            throw new \Exception("La commande n'existe pas.");
        }
        $this->orderRepository->changeStatus($order_id, 'processing');
        return;
    }
    public function completeOrder($order_id)
    {
        $order =  $this->orderRepository->findById($order_id);
        if (!$order) {
            throw new \Exception("La commande n'existe pas.");
        }
        $product =  $this->productRepository->findById($order->getProduct()->getId());
        if ($product->getQuantity() < $order->getQuantity()) {
            die("Quantité en stock insuffisante.");
        } else {
            $product->setQuantity($product->getQuantity() - $order->getQuantity());
        }
        $this->orderRepository->changeStatus($order_id, 'completed');
        $this->productRepository->update($product);
        return;
    }
}
