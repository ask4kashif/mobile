<?php

namespace AppBundle\Controller;
use AppBundle\Entity\Brand;
use AppBundle\Entity\Product;
use AppBundle\Entity\Spec;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

class ProductController extends Controller
{
	/**
     * @Route("/home/brand/product/{id}",name="_show")
     */
    public function showAction(Request $request,$id)
    {
        $session=$request->getSession();
    	$brand=$this->getDoctrine()->getRepository(Brand::class)
    		->findAll();
    	$product=$this->getDoctrine()->getRepository(Product::class)
    	->findOneById($id);
    		
        if($session->has('cart'))
            $cart=$session->get('cart');
      else
        $cart = false;

     $em = $this->getDoctrine()->getManager();
      $query = $em->createQuery(
        "SELECT c.name FROM AppBundle:Product p
        JOIN p.spec c
        where c.description LIKE '%Memory%' 
        "
        );
      $spec=$query->getResult();
        return $this->render('Product/product.html.twig',array(
    		'product'=>$product,
    		'brands'=>$brand,
            'cart'=>$cart,
    		
    	));
    }
}