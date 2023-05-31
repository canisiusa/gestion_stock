<?php

namespace App\Domain\Services;

require_once __DIR__ . '/../../Repositories/UserRepository.php';
require_once __DIR__ . '/../../Repositories/ProductRepository.php';
require_once __DIR__ . '/../../Repositories/CategoryRepository.php';
require_once __DIR__ . '/../../Domain/Entities/User.php';

use App\Domain\Entities\Product;
use App\Domain\Entities\User;
use App\Repositories\UserRepository;
use App\Repositories\ProductRepository;
use App\Repositories\CategoryRepository;

class ProductService
{
    protected $userRepository;
    protected $productRepository;
    protected $categoryRepository;



    public function __construct()
    {
        $this->userRepository = new UserRepository();
        $this->productRepository = new ProductRepository();
        $this->categoryRepository = new CategoryRepository();
    }

    public function getProduct(int $id)
    {
        return $this->productRepository->findById($id);
    }


    public function createProduct(string $name, string $description, string $image, float $price, int $quantity, int $category_id, int $supplier_id)
    {
        $user = $this->userRepository->findById($supplier_id);
        if (!$user) {
            throw new \Exception("L'utilisateur n'existe n'existe pas.");
        }

        $cat = $this->categoryRepository->findById($category_id);
        if (!$cat) {
            throw new \Exception("La catégorie n'existe n'existe pas.");
        }


        // Création de l'utilisateur
        $product = new Product(
            name: $name,
            image: $image,
            description: $description,
            price: $price,
            quantity: $quantity,
        );
        $product->setCategory($cat);
        $product->setSupplier($user);

        // Enregistrement en base de données
        $this->productRepository->save($product);

        return $user;
    }

    public function getSupplierProducts(int $supplier_id)
    {
        return $this->productRepository->findBySupplierId($supplier_id);
    }

    public function getHomeProducts(?string $searchTerm = "")
    {
        if (empty($searchTerm)) {
            return $this->productRepository->findAllInStock();
        } else {
            return $this->productRepository->searchProducts($searchTerm);
        }
    }

    public function deleteProduct($product_id)
    {
        return $this->productRepository->delete($product_id);
    }

    public function updateProduct(int $id, string $name, string $description, float $price, int $quantity, int $category_id)
    {
        $cat = $this->categoryRepository->findById($category_id);
        if (!$cat) {
            throw new \Exception("La catégorie n'existe n'existe pas.");
        }

        // Création de l'utilisateur
        $product = new Product(
            id: $id,
            name: $name,
            description: $description,
            price: $price,
            quantity: $quantity,
        );
        $product->setCategory($cat);

        // Enregistrement en base de données
        $resp = $this->productRepository->update($product);

        return $resp;
    }
}
