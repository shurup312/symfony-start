<?php

namespace App\Controller;

use App\Entity\Shop;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use App\Form\ShopType;

class FirstController extends AbstractController
{

    /**
     * @Route("/index", name="shop")
     */
    public function index(Request $request)
    {
        $entityManager = $this->getDoctrine()->getManager();
        $shop          = new Shop();
        $form          = $this->createForm(ShopType::class, $shop);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($shop);
            $entityManager->flush();
            return $this->redirectToRoute("shop");
        }
        $shops = $entityManager->getRepository(Shop::class)->findAll();
        return $this->render('first/index.html.twig', [
            'controller_name' => 'FirstController',
            'form'            => $form->createView(),
            'shops'           => $shops,
        ]);
    }

    /**
     * @Route("/remove/{shop}", name="shop_remove")
     */
    public function removeShop(Shop $shop, Request $request)
    {
        $em=$this->getDoctrine()->getManager();
        $em->remove($shop);
        $em->flush();

        return $this->redirectToRoute('shop');
    }
}
