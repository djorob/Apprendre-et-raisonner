<?php

namespace App\Classe;

use App\Entity\Category;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use App\Entity\Product;
use Doctrine\ORM\EntityManagerInterface;

class Cart {

    private $session;
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager,  SessionInterface $session)
    
    {
        $this->session = $session;
        $this->entityManager = $entityManager;

    }

    public function add($id)
    { 
        // creating the cart variable  to search the cart session_interface
        $cart = $this->session->get('cart', []);

        // if you have a product already insert you can increment

        if (!empty($cart[$id])) {
            $cart[$id]++;
        } else {
            $cart[$id] = 1;
        }
    
        $this->session->set('cart', $cart);

    }

    public function get() {

        return $this->session->get('cart');

    }

    public function remove() {

        return $this->session->remove('cart');

    }

    public function delete($id)
     {

        $cart = $this->session->get('cart', []);

        unset($cart[$id]);

        
        // put again the session cart 
        return $this->session->set('cart', $cart);


    }

    public function decrease($id)
    {
        // pick up the cart cart

        $cart = $this->session->get('cart', []);
        // check if the quantity of our product is different of 1 

        if ($cart[$id] > 1) {
            // decrease my quantity
            $cart[$id]--;
        }else {
            // delete my product
            unset($cart[$id]); 

        }

         // put again the session cart 
         return $this->session->set('cart', $cart);

    }

    public function getFull() {

        if ($this->get()) {
            foreach ($this->get() as $id => $quantity) {
                $product_object = $this->entityManager->getRepository(Product::class)->findOneById($id);

                if (!$product_object) {
                    $this->delete($id);
                    continue;
                }
                $cartComplete[] = [
                    'product' => $product_object,
                    'quantity' => $quantity
    
                ];
            }
        }

        return $cartComplete;
    }
}