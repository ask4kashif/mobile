<?php
namespace AppBundle\Controller;

use AppBundle\Entity\Contact;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class ContactController extends Controller
{
	/**
	 * @Route("/home/contact",name="_contactPage")
	 */
	public function indexAction(Request $request)
	{
		
		$contact=new Contact();
		$form=$this->createFormBuilder()
			->add('name',TextType::class,array(
				'label'=>false,
				'required'=>true,
				'attr'=>array(
					'placeholder'=>'Name',
					'class'=>'form-control',					
				)
			))
			->add('email',EmailType::class,array(
				'label'=>false,
				'required'=>true,
				'attr'=>array(
					'placeholder'=>'Email',
					'class'=>'form-control'
				)
			))
			->add('subject',TextType::class,array(
				'label'=>false,
				'required'=>true,
				'attr'=>array(
					'placeholder'=>'Subject',
					'class'=>'form-control'
				)
			))
			->add('message',TextareaType::class,array(
				'label'=>false,
				'required'=>true,
				'attr'=>array(
					'placeholder'=>'Your Message Here',
					'rows'=>"8",
				)
			))
			->add('submit',SubmitType::class,array(
				'attr'=>array(
					'class'=>'btn btn-primary pull-right'
				)
			))
			->getForm();
		
		$form->handleRequest($request); // the new line
		
		if($form->isSubmitted() && $form->isValid())
        {
			$name=$form['name']->getData();        	  
        	$email=$form['email']->getData();
        	$subject=$form['subject']->getData();
        	$msg=$form['message']->getData();  
        	
        	$message = \Swift_Message::newInstance()
                ->setSubject($subject)
                ->setFrom($email,$name)
                ->setTo("symfonytest009@gmail.com")
                ->setBody($form->getData()['message'],'text/html')
            ;

            $this->get('mailer')->send($message);
            
            $this->addFlash('success', 'Your message has send');
	
        return $this->redirectToRoute('_contactPage');
        }

		return $this->render('Contact/contact.html.twig',array(
			'form'=>$form->createView(),
		));
	}

}