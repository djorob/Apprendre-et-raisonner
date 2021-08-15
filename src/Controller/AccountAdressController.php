<?php

namespace App\Controller;

use App\Classe\Cart;
use App\Form\AdressType;
use App\Entity\Adress;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AccountAdressController extends AbstractController
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager) {

        $this->entityManager = $entityManager;
    }
    /**
     * @Route("/compte/adresses", name="account_adress")
     */
    public function index(): Response
    {
        return $this->render('account/adress.html.twig');
    }

   /**
     * @Route("/compte/ajouter-une-adresse", name="account_adress_add")
     */
    public function add( Cart $cart, Request $request): Response
    {
        $adress = new Adress();
        $form = $this->createForm(AdressType::class, $adress);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            // the adress need to be releable with a User
            $adress->setUser($this->getUser());
            $this->entityManager->persist($adress);
            $this->entityManager->flush();
            // if I got product in my panier
            if ($cart->get()) {
                // I want to be redirect to order 

                return $this->redirectToRoute('order');
            }else {
                // if not redirect to my account adress
            // when it's finish we have to be redirect to my account
            return $this->redirectToRoute('account_adress');
        } 

            
        }

        return $this->render('account/adress_form.html.twig', [
            'form' => $form->createView(),
        ]);
    }

     /**
     * @Route("/compte/modifier-une-adresse/{id}", name="account_adress_edit")
     */
    public function edit(Request $request, $id)
    {
        // we must search the adress we want to modify

        $adress = $this->entityManager->getRepository(Adress::class)->findOneById($id);

        if (!$adress || $adress->getUser() != $this->getUser()) {
            return $this->redirectToRoute('account_adress');
        }
        $form = $this->createForm(AdressType::class, $adress);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            
        
            $this->entityManager->flush();

            // when it's finish we have to be redirect to my account
            return $this->redirectToRoute('account_adress');

            
        }

        return $this->render('account/adress_form.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/compte/supprimer-une-adresse/{id}", name="account_adress_delete")
     */
    public function delete($id)
    {

        $adress = $this->entityManager->getRepository(Adress::class)->findOneById($id);

        if ($adress  && $adress->getUser() == $this->getUser()) {
            $this->entityManager->remove($adress);
            $this->entityManager->flush();


        }
        

            // when it's finish we have to be redirect to my account
            return $this->redirectToRoute('account_adress');

            
        

        
    }
}

