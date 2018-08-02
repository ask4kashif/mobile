<?php
namespace AppBundle\Controller;
use AppBundle\Entity\Product;
use AppBundle\Entity\User;
use AppBundle\Form\AddressType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use AppBundle\Entity\Address;
use Stripe\Stripe;
use Stripe\Charge;



class CheckOutController extends Controller
{
	// /**
	//  * @Route("/checkout/",name="_checkoutPage",methods={"GET"})
	//  */
	// public function getAction(Request $request)
	// {
		
	// 	if ($this->get('security.authorization_checker')->isGranted('IS_AUTHENTICATED_FULLY')){
 //    		$session=$request->getSession();
	// 		$cart=$session->get('cart');
	// 		if($cart==null)
	// 			{
	// 				return $this->redirectToRoute('_homePage');
	// 			}
			
 //    		$em=$this->getDoctrine()->getManager();
 //    		$product=$em->getRepository(Product::class)
	// 		->findArray(array_keys($session->get('cart')));
			
 //    		return $this->render('CheckOut/checkout.html.twig',array(
 //    			'product'=>$product,
 //    			'cart'=>$cart,
 //    		));
	// 	}
	// 	else
	// 		return $this->redirectToRoute('fos_user_registration_register');
	// }
	/**
	 * @Route("/checkout/",name="_checkPage",methods="POST")
	 */
	// public function postAction(Request $request)
	// {
	// // {
	// // 	if ($this->get('security.authorization_checker')->isGranted('IS_AUTHENTICATED_FULLY')){
 // //    		$session=$request->getSession();
	// // 		$cart=$session->get('cart');
	// // 		if($cart==null)
	// // 			{
	// // 				return $this->redirectToRoute('_homePage');
	// // 			}
	// // 	}


	// // 	Stripe::setApiKey('sk_test_ruJMb6VtkOPClZgw5sqySWoZ');
	// // 	try{
	// // 		Charge::create(array(
	// // 			"amount"=>1*100,
	// // 			"currency"=>"usd",
	// // 			"source"=>'tok_mastercard',
	// // 			"description"=>"Test Charge"
	// // 		));
	// // 	}catch(\Exception $e){
	// // 		return $this->redirectToRoute('_checkPage',array(
	// // 			'error'=>$e->getMessage(),
	// // 		));
	// // 	}
	// // 	$session=$request->getSession();
	// // 	$cart=$session->get('cart');
		
	// // 		$session->clear($cart);
		
	// 	// $this->addFlash('notice', 'went wrong');
	// 	return $this->redirectToRoute('_homePage');
	// }
	 


	 /**
	  * @Route("/checkout/", name="_checkoutPage")
	  */
	public function deliveryAction(Request $request)
	{
				
			$user=$this->get('security.token_storage')->getToken()->getUser();
			$entity=new Address();
			$form=$this->createForm(AddressType::class, $entity);
			if($request->isMethod('POST'))
			{
				$form->handleRequest($request);
				$session=$request->getSession();
				$cart=$session->get('cart');
	 			if($cart==null)
	 				{
	 					return $this->redirectToRoute('_homePage');
	 				}

				if(! $form->isValid() && ! $form->isSubmitted())
				{					
					return $this->redirect($this->generateUrl('_checkoutPage'));	
				}
					$em=$this->getDoctrine()->getManager();
					$entity->setUser($user);
					$em->persist($entity);
					$em->flush();
					$this->addFlash(
            		'notice',
            		'Record Added'
          			);
					return $this->redirect($this->generateUrl('_checkoutPage'));					
			}
		return $this->render('CheckOut/checkout.html.twig',array(
			'user'=>$user,
			'form'=>$form->createView(),
		));
	}

	/**
	 * @Route("/delivery/address/delete/{id}",name="_deleteAddressPage")
	 */
	public function deleteAction(Request $request,$id)
	{
		$em=$this->getDoctrine()->getManager();
		$entity=$em->getRepository(Address::class)->find($id);
		if($this->get('security.token_storage')->getToken()->getUser() 
			!= $entity->getUser() || !$entity)
			return ($this->redirect($this->generateUrl('_checkoutPage')));
		$em->remove($entity);
		$em->flush();
		$this->addFlash(
            'notice',
            'Record Deleted'
          );
		return ($this->redirect($this->generateUrl('_checkoutPage')));
	}

	public function setDeliveryOnSession(Request $request)
	{
		$session=$this->get('session');
		if(!$session->has('address')) $session->set('address',array());
		$address = $session->get('address');
		
	
		if($request->get('delivery')!= null)
		{
			$address['delivery'] = $request->get('delivery');
			
		}
		else{
			return $this->redirect($this->generateUrl('validation'));
		}
		$session->set('address',$address);
		return $this->redirect($this->generateUrl('validation'));
	}

	/**
	 * @Route("/checkout/validation/",name="validation")
	 */
	public function validationAction(Request $request)
	{
			$session=$request->getSession();
			$cart=$session->get('cart');
	 		if($cart==null)
	 			{
	 				return $this->redirectToRoute('_homePage');
	 			}
		if($request->isMethod('POST'))
			$this->setDeliveryOnSession($request);
		
		$em=$this->getDoctrine()->getManager();
		$session=$request->getSession();
		$address = $session->get('address');
		
		$product=$em->getRepository(Product::class)->findArray(array_keys($session->get('cart')));
		$delivery=$em->getRepository(Address::class)->find($address['delivery']);
		
		return $this->render('Validation/validation.html.twig',array(
			'product'=>$product,
			'delivery'=>$delivery,
			'cart'=>$session->get('cart'),
		));
	}	
	
}