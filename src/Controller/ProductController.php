<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Product;
use App\Form\ProductType;
use App\Repository\ProductRepository;
use Symfony\Component\Form\Forms;
use Symfony\Component\Form\Extension\HttpFoundation\HttpFoundationExtension;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\EntityManagerInterface;



class ProductController extends AbstractController
{
    /**
     * @Route("/product", name="product")
     */
    public function index(): Response
    {
        $repo =$this->getDoctrine()->getRepository(Product::class);
        $products =$repo->findAll();

        return $this->render('product/index.html.twig', [
            'controller_name' => 'ProductController',
            'products' => $products
        ]);
    }

    /**
     * @Route("/product/new", name="create")
     */
    public function create(Request $request, EntityManagerInterface $entityManager){

        $product= new Product();

        $form =$this->createForm(ProductType::class,$product);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid())
        {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($product);
            $entityManager->flush();
            
        $repo =$this->getDoctrine()->getRepository(Product::class);
        $products =$repo->findAll();

        return $this->render('product/index.html.twig', [
            'controller_name' => 'ProductController',
            'products' => $products
        ]);     
        }
     
        return $this->render('product/new.html.twig',[
            'formProduct' => $form->createView()
        ]);      
        
    }

    /**
     * @Route("/product/Delete/{id}" , name="delete")
     */
    public function delete(int $id): Response
    {
    $entityManager = $this->getDoctrine()->getManager();
    $product = $entityManager->getRepository(Product::class)->find($id);
    $entityManager->remove($product);
    $entityManager->flush();
    $repo=$this->getDoctrine()->getRepository(Product::class);
        $products=$repo->findAll();
    return $this->render('product/index.html.twig', ['products' =>
    $products]);
    
    }



    /**
     * @Route("/product/Edit/{id}", name="edit")
     */
    public function edit(Request $request, EntityManagerInterface $entityManager, int $id){
        $product = $this->getDoctrine()->getRepository(Product::class)->find($id);


        $form =$this->createForm(ProductType::class,$product);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid())
        {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($product);
            $entityManager->flush();
            
        $repo =$this->getDoctrine()->getRepository(Product::class);
        $products =$repo->findAll();

        return $this->render('product/index.html.twig', [
            'controller_name' => 'ProductController',
            'products' => $products
        ]);     
        }
     
        return $this->render('product/new.html.twig',[
            'formProduct' => $form->createView()
        ]);      
    }

}

