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
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use AppBundle\Entity\Country;
class AddressController extends Controller
{
	/**
	 * @Route("/address/show/",name="_addressPage")
	 */
	public function indexAction(Request $request)
	{	
				
			$user=$this->get('security.token_storage')->getToken()->getUser();
			$entity=new Address();
			$form=$this->createForm(AddressType::class, $entity);
			if($request->isMethod('POST'))
			{
				$form->handleRequest($request);
				if(! $form->isValid() && ! $form->isSubmitted())
				{					
					return $this->redirect($this->generateUrl('_addressPage'));	
				}
					$em=$this->getDoctrine()->getManager();
					$entity->setUser($user);
					$em->persist($entity);
					$em->flush();
					$this->addFlash(
            			'notice',
            			'Record Added'
          			);
					return $this->redirect($this->generateUrl('_addressPage'));					
			}
		return $this->render('Address/address.html.twig',array(
			'user'=>$user,
			'form'=>$form->createView(),
		));
	}
	
	/**
	 * @Route("/address/delete/{id}",name="_delAddressPage")
	 */
	public function deleteAction(Request $request,$id)
	{
		$em=$this->getDoctrine()->getManager();
		$entity=$em->getRepository(Address::class)->find($id);
		if($this->get('security.token_storage')->getToken()->getUser() 
			!= $entity->getUser() || !$entity)
			return ($this->redirect($this->generateUrl('_addressPage')));
		$em->remove($entity);
		$em->flush();
		$this->addFlash(
            'notice',
            'Record Deleted'
          );
		return ($this->redirect($this->generateUrl('_addressPage')));
	}

	/**
	 * @Route("/address/{id}/edit/",name="_editAddressPage")
	 */
	public function editAction(Request $request,$id)
	{		  
		$user=$this->get('security.token_storage')->getToken()->getUser();
		$em=$this->getDoctrine()->getManager();
		$address=$em->getRepository(Address::class)->find($id);		 
        
        $address->setName($address->getName());
        $address->setSurname($address->getSurname());
        $address->setTelephone($address->getTelephone());
        $address->setAddress($address->getAddress());
		$address->setCountry($address->getCountry());        
		$address->setCity($address->getCity());        
		$address->setCp($address->getCp());   
		// $form=$this->createForm(AddressType::class,$address);
        $form = $this->createFormBuilder($address)
            ->add('name', TextType::class,array(
            	'attr'=>array('class'=>'form-control','style'=>'margin-bottom:15px')))
         	->add('surname', TextType::class,array(
         		'attr'=>array('class'=>'form-control','style'=>'margin-bottom:15px')))
          	->add('telephone', TextType::class,array('attr'=>array('class'=>'form-control','style'=>'margin-bottom:15px')))
           	->add('address', TextType::class,array('attr'=>array('class'=>'form-control','style'=>'margin-bottom:15px')))            
            ->add('country',EntityType::class, array(
            	'class' => Country::class,
         		// 'choice_label' => 'name',
            	'attr'=>array('class'=>'form-control','style'=>'margin-bottom:15px'
            	// 'query_builder' => function (EntityRepository $er) {
             //    return $er->createQueryBuilder('u');
                    // ->orderBy('u.name', 'ASC');
      
            // 'choice_label' => 'name',
        )))
            ->add('city', TextType::class,array('attr'=>array('class'=>'form-control','style'=>'margin-bottom:15px')))
            ->add('cp', TextType::class,array('label'=>'Postal Code','attr'=>array('class'=>'form-control','style'=>'margin-bottom:15px')))
            ->add('update', SubmitType::class, array('attr'=>array('label' => 'Update','class'=>'btn btn-primary','style' => 'float: left')))
            ->getForm();

        $form->handleRequest($request);

      if ($form->isSubmitted() && $form->isValid()) 
      {          
          $name=$form['name']->getData();
          $surname=$form['surname']->getData();
          $telephone=$form['telephone']->getData();
          $addres=$form['address']->getData();
          $country=$form['country']->getData();
          $city=$form['city']->getData();
          $cp=$form['cp']->getData();

          $address=$em->getRepository(Address::class)->find($id);
          $address->setName($name);
          $address->setSurname($surname);
          $address->setTelephone($telephone);
          $address->setAddress($addres);
          $address->setCountry($country);
          $address->setCity($city);
          $address->setCp($cp);
          $em->flush();
          $this->addFlash(
            'notice',
            'Record Updated'
          );
          return $this->redirectToRoute("_addressPage");
    }
         return $this->render('Address/edit.html.twig',array(
            'edit'=>$address,
            'form'=>$form->createView()
          ));
	}
}