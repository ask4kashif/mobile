<?php

namespace AppBundle\Controller;
use AppBundle\Entity\Brand;
use AppBundle\Entity\Category;
use AppBundle\Entity\Product;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;


class HomeController extends Controller
{
	/**
     * @Route("/", name="_homePage")
     */
    public function homeAction(Request $request)
    {
        
        $session=$request->getSession();
        
        $category=$this->getDoctrine()->getRepository(Category::class)
                    ->findAll();

        $brands=$this->getDoctrine()->getRepository(Brand::class)
        ->findAll();    

        $em = $this->getDoctrine()->getManager();
        
        $query = $em->createQuery(
        'SELECT p FROM AppBundle:Product p
         ORDER BY p.createdAt DESC'
         );
        
        $products=$query->setMaxResults(10)->getResult();


        $slider=$this->getDoctrine()->getRepository(Product::class)
                ->findSlider();
        if($session->has('cart'))
            $cart=$session->get('cart');
      else
        $cart = false;
        return $this->render('Home/home.html.twig',array(
        	'brands'=>$brands,
            'category'=>$category,  
            'products'=>$products,
            'slider'=>$slider,
            'cart'=>$cart,

        ));
    }
    
    public function countAction(Request $request)
    {
        $session=$request->getSession();
        if(!$session->has('cart'))
            $count=0;
        else
            $count=count($session->get('cart'));
            return new Response($count);

    }
    
}
