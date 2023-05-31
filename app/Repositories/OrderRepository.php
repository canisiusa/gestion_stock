<?php

namespace App\Repositories;

use PDO;
use Core\Database;

require_once __DIR__ . '/../Domain/Entities/Product.php';
require_once __DIR__ . '/../Domain/Entities/User.php';
require_once __DIR__ . '/../Domain/Entities/Order.php';

use App\Domain\Entities\Product;
use App\Domain\Entities\Order;
use App\Domain\Entities\User;

class OrderRepository
{
    private $pdo;

    public function __construct()
    {
        $this->pdo = Database::getInstance()->getConnection();
    }


    public function save(Order $order): void
    {
        $stmt = $this->pdo->prepare('INSERT INTO orders (
        customer_id,
        ordered_at,
        amount,
        status,
        shipping_address,
        product_id,
        quantity
    ) VALUES (?,?,?,?,?,?,?)');

        $stmt->execute([
            $order->getCustomer()->getId(),
            $order->getOrderDate(),
            $order->getAmount(),
            $order->getStatus(),
            $order->getShippingAddress(),
            $order->getProduct()->getId(),
            $order->getQuantity(),
        ]);
    }

    public function findCustomerOrders($customer_id): array
    {

        $stmt = $this->pdo->prepare(
            'SELECT o.*, p.name AS product_name, u.name AS user_name
            FROM orders o
            JOIN products p ON o.product_id = p.id
            JOIN users u ON o.customer_id = u.id
            WHERE o.customer_id = ?'
        );

        $stmt->execute([$customer_id]);
        $data = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $orders = [];

        // Traiter les résultats
        foreach ($data as $order) {
            $orderId = $order['id'];
            $amount = $order['amount'];
            $status = $order['status'];
            $shippingAddress = $order['shipping_address'];

            $orders[] = new Order(
                id: $orderId,
                amount: $amount,
                status: $status,
                shipping_address: $shippingAddress,
                quantity: $order['quantity'],
                customer: new User(id: $order['customer_id'], name: $order['user_name']),
                product: new Product(id: $order['product_id'], name: $order['product_name']),
                created_at: $order['created_at'],
                updated_at: $order['updated_at'],
                ordered_at: $order['ordered_at'],
            );
        }
        return $orders;
    }

    public function findSupplierOrders($supplier_id): array
    {

        $stmt = $this->pdo->prepare(
            'SELECT o.*, p.name AS product_name, u.name AS user_name
            FROM orders o
            JOIN products p ON o.product_id = p.id
            JOIN users u ON o.customer_id = u.id
            WHERE p.supplier_id = ?'
        );

        $stmt->execute([$supplier_id]);
        $data = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $orders = [];

        // Traiter les résultats
        foreach ($data as $order) {
            $orderId = $order['id'];
            $amount = $order['amount'];
            $status = $order['status'];
            $shippingAddress = $order['shipping_address'];

            $orders[] = new Order(
                id: $orderId,
                amount: $amount,
                status: $status,
                shipping_address: $shippingAddress,
                quantity: $order['quantity'],
                customer: new User(id: $order['customer_id'], name: $order['user_name']),
                product: new Product(id: $order['product_id'], name: $order['product_name']),
                created_at: $order['created_at'],
                updated_at: $order['updated_at'],
                ordered_at: $order['ordered_at'],
            );
        }
        return $orders;
    }

    public function findById(int $orderId): ?Order
    {

        $stmt = $this->pdo->prepare(
            'SELECT o.*, p.name AS product_name, u.name AS user_name
            FROM orders o
            JOIN products p ON o.product_id = p.id
            JOIN users u ON o.customer_id = u.id
            WHERE o.id = ?'
        );

        $stmt->execute([$orderId]);
        $order = $stmt->fetch(PDO::FETCH_ASSOC);


        $orderId = $order['id'];
        $amount = $order['amount'];
        $status = $order['status'];
        $shippingAddress = $order['shipping_address'];

        return $order ? new Order(
            id: $orderId,
            amount: $amount,
            status: $status,
            shipping_address: $shippingAddress,
            quantity: $order['quantity'],
            customer: new User(id: $order['customer_id'], name: $order['user_name']),
            product: new Product(id: $order['product_id'], name: $order['product_name']),
            created_at: $order['created_at'],
            updated_at: $order['updated_at'],
            ordered_at: $order['ordered_at'],
        ) : null;
    }

    public function changeStatus(int $orderId, string $status): void
    {
        $stmt = $this->pdo->prepare('UPDATE orders SET status = :status WHERE id = :id');
        $stmt->bindParam(':status', $status);
        $stmt->bindParam(':id', $orderId);
        $stmt->execute();
    }
}
