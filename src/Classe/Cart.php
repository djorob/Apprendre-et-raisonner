<?php

namespace App\Classe;

use App\Entity\Category;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

class Cart {

    private $session;

    public function __construct(SessionInterface $session)
    
    {
        $this->session = $session;

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
}