<?php
namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use AppBundle\Entity\Product;

class CartController extends Controller
{
	
	/**
	 * @Route("/cart",name="cart")
	 */
	public function indexAction(Request $request)
	{
		$session=$request->getSession();

		if(!$session->has('cart')) $session->set('cart',array());
		$em=$this->getDoctrine()->getManager();
		$product=$em->getRepository(Product::class)
			->findArray(array_keys($session->get('cart')));
		return $this->render('Cart/cart.html.twig',array(
			'product'=>$product,
			'cart'=>$session->get('cart'),

		));	
	}
	/**
	 * @Route("/add/{id}",name="_cartAddPage")
	 */
	public function addAction(Request $request,$id)
	{				
 		$session = $request->getSession();
 		if(!$session->has('cart'))   $session->set('cart',array());
		$cart=$session->get('cart');		
		
		if(array_key_exists($id, $cart))
		{
			if($request->query->get('qte')!=null) $cart[$id]=$request->query->get('qte');

		}
		else
		{
			if($request->query->get('qte')!=null)
				$cart[$id]=$request->query->get('qte');
			else
				$cart[$id]=1;
		}
		$session->set('cart',$cart);

		return $this->redirectToRoute('cart');
	}
	/**
	 * @Route("/remove/{id}",name="_cartRemovePage")
	 */
	public function removeAction(Request $request,$id)
	{		
		$session=$request->getSession();
		$cart=$session->get('cart');
		if(array_key_exists($id, $cart)){
			unset($cart[$id]);
			$session->set('cart',$cart);
		}
		return $this->redirectToRoute('cart');
	}
}