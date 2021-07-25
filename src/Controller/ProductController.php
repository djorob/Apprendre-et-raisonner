<?php

namespace App\Controller;

use App\Classe\Search;
use App\Entity\Product;
use App\Form\SearchType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Form\FormView;
use Symfony\Component\HttpFoundation\Request;

class ProductController extends AbstractController
{
    // dependancy injection

    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }
    /**
     * 
     * @Route("/nos-produits", name="products")
     */
    public function index(Request $request): Response
    {
        $products = $this->entityManager->getRepository(Product::class)->findAll();
        // creating the instance
        $search = new Search();

        // linking to the form
        $form = $this->createForm(SearchType::class, $search);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // get the data with the reasearch
            $search = $form->getData();
            // creating a new funtion in the repository 
            $products = $this->entityManager->getRepository(Product::class)->findWithSearch($search);
            
        }


        return $this->render('product/index.html.twig', [
            'products' => $products,
            'form' => $form->createView()
        ]);
    }


      /**
     * 
     * @Route("/produit/{slug}", name="product")
     */
    public function show($slug): Response
    {
        $product = $this->entityManager->getRepository(Product::class)->findOneBySlug($slug);
        // if you don't find the product  redirect me to all products
        if (!$product) {
            return $this->redirectToRoute('products');
        }


        return $this->render('product/show.html.twig', [
            'product' => $product,
            
        ]);
    }
}
