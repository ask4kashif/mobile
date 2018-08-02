<?php

namespace AppBundle\Controller;
use AppBundle\Entity\Brand;
use AppBundle\Entity\Product;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;


class ProductListController extends Controller
{
	 /**
     * @Route("/brand/{slug}/mobile/", name="_productList")
     */
	public function productListAction(Request $request,$slug)
    {

      $session=$request->getSession();
      $a=$request->attributes->get('slug');
      $brand=$this->getDoctrine()->getRepository(Brand::class)
    			->findAll();
      $em = $this->getDoctrine()->getManager();
      $product = $em->createQuery(
        "SELECT p FROM AppBundle:Product p
        JOIN p.brand c
        Join p.category a
        WHERE (c.slug = :slug ) 
        AND a.name IN ('Mobile')  
        "
   		 )->setParameter('slug', $slug);
  
      /**
       * @var $paginator \Knp\Component\Pager\Paginator
       */
        
        $paginator  = $this->get('knp_paginator');
    	
    	$pagination = $paginator->paginate(
        $product, 
        $request->query->getInt('page', 1)/*page number*/,
        12/*limit per page*/

    );

      
      if($session->has('cart'))
        $cart=$session->get('cart');
      else
        $cart = false;
      

    	return $this->render('ProductList/productList.html.twig',array(
       'product'=>$pagination,
       'brands'=>$brand,
       'cart'=>$cart, 
       'a'=>$a,

  
  	));
    }
    // WHERE (c.slug = :slug ) AND a.name IN ('Mobile')


    /**
     * @Route("/brand/{slug}/tablet/", name="_tabletList")
     */
  public function tabletListAction(Request $request,$slug)
    {
      
      $a=$request->attributes->get('slug');
      $session=$request->getSession();
      $brand=$this->getDoctrine()->getRepository(Brand::class)
          ->findAll();
        
      $em = $this->getDoctrine()->getManager();
      $tablet = $em->createQuery(
        "SELECT p FROM AppBundle:Product p
        JOIN p.brand c
        Join p.category a
        WHERE (c.slug = :slug ) AND a.name IN ('Tablet')
        
        "
       )->setParameter('slug', $slug);
  
      /**
       * @var $paginator \Knp\Component\Pager\Paginator
       */
        
        $paginator  = $this->get('knp_paginator');
      
      $pagination = $paginator->paginate(
        $tablet, 
        $request->query->getInt('page', 1)/*page number*/,
        6/*limit per page*/

    );
      
      if($session->has('cart'))
        $cart=$session->get('cart');
      else
        $cart = false;

      return $this->render('ProductList/tabletList.html.twig',array(
       'brands'=>$brand,
       'cart'=>$cart, 
       'tablet'=>$pagination,
       'a'=>$a,
  
    ));
  }
   

}