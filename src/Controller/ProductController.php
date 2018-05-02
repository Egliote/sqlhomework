<?php

namespace App\Controller;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use App\Entity\Category;
use App\Entity\Product;
use Symfony\Component\HttpFoundation\Response;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;

class ProductController extends Controller
{
    /**
     * @Route("/product/new/{id}", name="product_add")
     */
    public function saveAction()
    {
        $entityManager = $this->getDoctrine()->getManager();
        $category = new Category();
        $category->setTitle('Computer Peripherals');

        $product = new Product();
        $product->setTitle('Keyboard');
        $product->setPrice(19.99);
        $product->setActive(1);

        // relates this product to the category
        $product->setCategory($category);

        //$entityManager->persist($category);
        $entityManager->persist($product);
        $entityManager->flush();
        return new Response('Check out this great product: '.$product->getTitle().', id: '.$product->getId());
    }

/**
* @Route("/product/deleted/{id}", name="product_delete")
*/
    public function deleteProductAction()
    {
        $entityManager = $this->getDoctrine()->getManager();
        $id=1;
        $product = $entityManager->getRepository(Product::class)->find($id);

        if (!$product) {
            throw $this->createNotFoundException(
                'No product found for id '.$id
            );
        }

        $entityManager->remove($product);
        $entityManager->flush();
        return new Response('Product deleted, id: '.$id);
    }

    /**
     * @Route("/product/show/{id}", name="product_show")
     */
    public function showAction($id)
    {
        $product = $this->getDoctrine()
            ->getRepository(Product::class)
            ->find($id);

        if (!$product) {
            throw $this->createNotFoundException(
                'No product found for id '.$id
            );
        }

        return new Response('Check out this great product: '.$product->getTitle());
    }
}
