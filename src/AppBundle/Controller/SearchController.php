<?php
namespace AppBundle\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use AppBundle\Entity\Product;
use AppBundle\Entity\ModelName;
use AppBundle\Entity\Brand;
use AppBundle\Entity\Category;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SearchType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Doctrine\ORM\EntityRepository;



class SearchController extends Controller
{
	/**
	 * @Route("/home/search/",name="_searchPage")
	 */
	public function searchAction(Request $request)
	{
		$session=$request->getSession();
		
		$brand=$this->getDoctrine()->getRepository(Brand::class)
    		->findAll();
    	
    	if($session->has('cart'))
            $cart=$session->get('cart');
      	else
        $cart = false;
		
		$form=$this->createFormBuilder(null)
			 ->add('search', EntityType::class, array(
            	'placeholder'=>'Search',
    			 'class' => 'AppBundle:Product',
    			 'query_builder' => function (EntityRepository $er) {
        			return $er->createQueryBuilder('u')
            		->orderBy('u.description', 'ASC');
    			},
        	))
			->add('save', SubmitType::class, array(
             	'label' => 'Search',
             	'attr'=>array(
             		'class'=>'btn btn-primary'
             	)))
			->getForm();
		$form->handleRequest($request);
		if(! $form->isSubmitted() || ! $form->isValid())
		{
				return $this->redirectToRoute('_homePage');
		}
			$text=$form['search']->getData();
					
			$em = $this->getDoctrine()->getManager();
       		$search = $this->getDoctrine()->getRepository(Product::class)
        			->findOneById($text);
        			
       		return $this->render('Search/searchResult.html.twig',array(
       				'search'=>$search,
       				'brands'=>$brand,
            		'cart'=>$cart,
       			));
		
		}

		public function searchBarAction()
		{
			$form=$this->createFormBuilder(null)

			 ->add('search', EntityType::class, array(
            	'placeholder'=>'Search',
            	'label'=>'Search',
    			 'class' => 'AppBundle:Product',
    			 'query_builder' => function (EntityRepository $er) {
        			return $er->createQueryBuilder('u')
            		->orderBy('u.description', 'ASC');
    			},
        	))
			
			->add('save', SubmitType::class, array(
             	'label' => 'Search',
             	'attr'=>array(
             		'class'=>'btn btn-primary'
             	)))
			->getForm();
			return $this->render('Search/search.html.twig',array(
				'form'=>$form->createView(),
			));
		}	
}