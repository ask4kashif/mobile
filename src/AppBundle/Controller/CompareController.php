<?php

namespace AppBundle\Controller;
use AppBundle\Entity\Spec;
use AppBundle\Entity\Compare;
use AppBundle\Entity\Brand;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Doctrine\ORM\EntityRepository;

class CompareController extends Controller
{
	/**
     * @Route("/home/compare/", name="comparePage",options={"expose"=true})
     */
    public function indexAction(Request $request)
    {
        $brands=$this->getDoctrine()->getRepository(Brand::class)
        ->findAll();
    	$compare = new Compare();
        $form = $this->createFormBuilder($compare)
            ->add('compareTo', EntityType::class, array(
            	'placeholder'=>'Choose an Option',
            	'label'=>'Compare To',
    			 'class' => 'AppBundle:Spec',
    			 'query_builder' => function (EntityRepository $er) {
        			return $er->createQueryBuilder('u')
            		->orderBy('u.name', 'ASC');
    			},
        	))

        	->add('compareWith',  EntityType::class, array(
            	'placeholder'=>'Choose an Option',
            	'label'=>'Compare With',
    			 'class' => 'AppBundle:Spec',
    			 
    			 'query_builder' => function (EntityRepository $er) {
        			return $er->createQueryBuilder('u')
            		->orderBy('u.name', 'ASC');
    			},
        	))

             ->add('save', SubmitType::class, array(
             	'label' => 'Compare',
             	'attr'=>array(
             		'class'=>'btn btn-success'
             	)))
             ->getForm();
            $form->handleRequest($request);
            if ($form->isSubmitted() && $form->isValid()) {        
            	$compareTo=$form['compareTo']->getData();
            	$compareWith=$form['compareWith']->getData();

            	$spec1=$this->getDoctrine()->getRepository(Spec::class)
        			->findOneById($compareTo);
        			

        		$spec2=$this->getDoctrine()->getRepository(Spec::class)
        			->findOneById($compareWith);
            	
            	return $this->render('Compare/compareResult.html.twig',array(
            		'form'=>$form->createView(),    		
            		'spec1'=>$spec1,
            		'spec2'=>$spec2,
            	));
            
            }

        	return $this->render('Compare/compare.html.twig',array(
    		'form'=>$form->createView(),
            'brands'=>$brands		
        ));
    }
    
}