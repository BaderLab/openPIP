<?php

/*
 * This file is part of the FOSUserBundle package.
 *
 * (c) FriendsOfSymfony <http://friendsofsymfony.github.com/>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace UserBundle\Controller;

use FOS\UserBundle\Event\FilterUserResponseEvent;
use FOS\UserBundle\Event\FormEvent;
use FOS\UserBundle\Event\GetResponseUserEvent;
use FOS\UserBundle\Form\Factory\FactoryInterface;
use FOS\UserBundle\FOSUserEvents;
use FOS\UserBundle\Model\UserInterface;
use FOS\UserBundle\Model\UserManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use AppBundle\Entity\Interaction_Network;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
/**
 * Controller managing the user profile.
 *
 * @author Christophe Coevoet <stof@notk.org>
 */
class ProfileController extends Controller
{
	/**
	 * Show the user.
	 */
	public function showAction(Request $request)
	{
		
		
		$user = $this->getUser();
		if (!is_object($user) || !$user instanceof UserInterface) {
			throw new AccessDeniedException('This user does not have access to this section.');
		}
		
		$user_id = $user->getId();
		
		$interaction_network_array = self::getUserInteractionNetworks($user_id);
		
		foreach($interaction_network_array as $interaction_network){
			$interaction_network_name = $interaction_network->getName();
			$interaction_network->setName(substr($interaction_network_name,0,20) . '...');
		}
		
		
		$dataset_array = self::getUserDatasets($user_id);
		
		
		$form = self::createProfileForm($user, $interaction_network_array, $dataset_array);
		
		
		$form->handleRequest($request);
		
		if ($form->isSubmitted()) {
			
			$add_network_name = $form["add_network_name"]->getData();
			$add_network_query = $form["add_network_query"]->getData();
			
			if($add_network_query){
				self::addNewUserInteractionNetwrork();
			}
			
			self::updateUserInteractionNetworks($form, $interaction_network_array);
			self::updateUserDatasets($form, $dataset_array);
			
			return $this->redirectToRoute('fos_user_profile_show');
			
		}
		
		
		
		$admin_settings = $this->getDoctrine()
		->getRepository('AppBundle:Admin_Settings')
		->find(1);
		
		$title = $admin_settings->getTitle();
		$short_title = $admin_settings->getShortTitle();
		$footer = $admin_settings->getFooter();
		$main_color_scheme = $admin_settings->getMainColorScheme();
		$header_color_scheme = $admin_settings->getHeaderColorScheme();
		$logo_color_scheme = $admin_settings->getLogoColorScheme();
		$button_color_scheme = $admin_settings->getButtonColorScheme();
		$home_page = $admin_settings->getHomePage();
		$url = $admin_settings->getUrl();
		
		$login_status = false;
		
		$is_fully_authenticated = $this->get('security.context')
		->isGranted('IS_AUTHENTICATED_FULLY');
		
		if($is_fully_authenticated){
			$login_status =  true;
		}
		
		$admin_status = false;
		
		if ($this->get('security.authorization_checker')->isGranted('ROLE_ADMIN')) {
			$admin_status = true;
		}
		
		return $this->render('FOSUserBundle:Profile:show.html.twig', array(
				'user' => $user,
				'form' => $form->createView(),
				'title' => $title,
				'home_page' => $home_page,
				'main_color_scheme' => $main_color_scheme,
				'header_color_scheme' => $header_color_scheme,
				'logo_color_scheme' => $logo_color_scheme,
				'button_color_scheme' => $button_color_scheme,
				'short_title' => $short_title,
				'footer' => $footer,
				'login_status' => $login_status,
				'interaction_network_array' => $interaction_network_array,
				'url' => $url,
				'dataset_array' => $dataset_array,
				'admin_status' => $admin_status
		));
	}
	
	
	
	
	
	public function getUserInteractionNetworks($user_id){
		
		$em = $this->getDoctrine()->getManager();
		$interaction_repository = $em->getRepository('AppBundle:Interaction_Network');
		$qb = $interaction_repository->createQueryBuilder('i');
		$qb->select('i');
		$qb->join('i.users', 'u');
		$qb->where('u.id = :user_id');
		
		
		$qb->setParameter('user_id', $user_id);
		
		$query = $qb->getQuery();
		
		$interaction_network_array = $query->getResult();
		
		return $interaction_network_array;
		
	}
	
	public function getUserDatasets($user_id){
		
		
		$em = $this->getDoctrine()->getManager();
		$dataset_repository = $em->getRepository('AppBundle:Dataset');
		$qb = $dataset_repository->createQueryBuilder('d');
		$qb->select('d');
		$qb->join('d.users', 'u');
		$qb->where('u.id = :user_id');
		
		
		$qb->setParameter('user_id', $user_id);
		
		$query = $qb->getQuery();
		
		$dataset_array = $query->getResult();
		
		return $dataset_array;
	}
	
	
	public function createProfileForm($user, $interaction_network_array, $dataset_array){
		
		
		$formFactory = $this->get('fos_user.profile.form.factory');
		
		$form = $formFactory->createForm();
		$form->setData($user);
		
		
		foreach($interaction_network_array as $interaction_network){
			
			$interaction_network_id = $interaction_network->getId();
			$interaction_network_query_string = $interaction_network->getInteractorQueryString();
			$interaction_network_name = $interaction_network->getName();
			$interaction_network_name = $interaction_network_name.substr(1, 10);
			
			$form ->add("interaction_network_checkbox_id_$interaction_network_id", CheckboxType::class, array(
					'mapped'=> false,
					'required' => false,
					'label' => false,
					'attr' => array('value' => $interaction_network_query_string, 'checked' => 'checked')));
			
			$form ->add("interaction_network_name_$interaction_network_id", TextType::class, array(
					'mapped'=> false,
					'required' => false,
					'label' => "$interaction_network_name",
					'attr' => array('value' => $interaction_network_name)));
		}
		
		
		foreach($dataset_array as $dataset){
			$dataset_name = $dataset->getName();
			$form ->add($dataset_name, CheckboxType::class, array(
					'mapped'=> false,
					'required' => false,
					'label' => "$dataset_name",
					'attr' => array('value' => $dataset_name, 'checked' => 'checked')));
		}
		
		
		
		$form ->add('add_network_name', TextType::class, array(
				'mapped'=> false,
				'required' => false,
				'attr' => array('style' => "width: 50%;")
				
		));
		
		$form->add('add_network_query', TextareaType::class, array(
				'mapped'=> false,
				'required' => false,
				'attr' => array('style' => "min-height: 20px; height: 100px; width: 50%; resize: vertical;")
				
		));
		
		return $form;
		
	}
	
	public function addNewUserInteractionNetwrork(){
		
		
		$doctrine_manager = $this->getDoctrine()->getManager();
		
		$interaction_network = new Interaction_Network();
		
		$interaction_network->setName($add_network_name);
		$interaction_network->setInteractorQueryString($add_network_query);
		
		
		$SearchController = $this->get('app.search');
		
		$search_term_array = explode(",",$add_network_query);
		
		$query_protein_array = $SearchController->getProteinQueryArray($search_term_array);
		
		foreach($query_protein_array as  $query_protein){
			
			$interactions = $SearchController->getInteractionsMySQL($query_protein);
			
			
			
			if($interactions){
				foreach($interactions as $interaction){
					
					$interactor_array[] = $interaction['interactor_A'];
					$interactor_array[] = $interaction['interactor_B'];
					
					
				}}
		}
		
		$functions = $this->get('app.functions');
		
		$interactor_array = $functions->removeDuplicates($interactor_array);
		
		$node_array = $SearchController->interactorsToNodes($interactor_array);
		
		$interaction_array = $SearchController->getInteractionsInList($interactor_array);
		
		$interaction_array = $SearchController->removeTwoWayInteractions($interaction_array);
		
		
		foreach($interaction_array as $interaction_row){
			
			
			$interaction_id = $interaction_row['id'];
			
			$interaction = $this->getDoctrine()
			->getRepository('AppBundle:Interaction')
			->find($interaction_id);
			
			
			$interaction->addInteractionNetwork($interaction_network);
			$interaction_network->addInteraction($interaction);
			
			
		}
		
		$interaction_network->addUser($user);
		$user->addInteractionNetwork($interaction_network);
		
		$doctrine_manager->persist($user);
		$doctrine_manager->persist($interaction_network);
		
		$doctrine_manager->flush();
		
	}
	
	public function updateUserInteractionNetworks($form, $interaction_network_array){
		
		
		foreach($interaction_network_array as $interaction_network){
			
			$interaction_network_id = $interaction_network->getId();
			$interaction_network_query_string = $interaction_network->getInteractorQueryString();
			$interaction_network_name = $interaction_network->getName();
			
			//
			$interaction_network_checkbox_form = $form["interaction_network_checkbox_id_$interaction_network_id"]->getData();
			
			$interaction_network_name_form = $form["interaction_network_name_$interaction_network_id"]->getData();
			
			$doctrine_manager = $this->getDoctrine()->getManager();
			
			if($interaction_network_checkbox_form == 1){
				
				$interaction_network->setName($interaction_network_name_form);
				$doctrine_manager->persist($interaction_network);
				$doctrine_manager->flush();
				
			}else{
				
				$user = $this->get('security.token_storage')->getToken()->getUser();
				$user->removeInteractionNetwork($interaction_network);
				$interaction_network->removeUser($user);
				$doctrine_manager->persist($user);
				$doctrine_manager->persist($interaction_network);
				$doctrine_manager->flush();
			}
			
		}
		
	}
	
	
	public function updateUserDatasets($form, $dataset_array){
		
		
		foreach($dataset_array as $dataset){
			
			$dataset_name = $dataset->getName();
			
			$dataset_selected = $form["$dataset_name"]->getData();
			
			if($dataset_selected == 1){
				
				
			}else{
				
				$doctrine_manager = $this->getDoctrine()->getManager();
				$user->removeDataset($dataset);
				$dataset->removeUser($user);
				$doctrine_manager->persist($user);
				$doctrine_manager->persist($dataset);
				$doctrine_manager->flush();
			}
			
		}
		
	}
	
	
	
	
	/**
	 * Edit the user.
	 *
	 * @param Request $request
	 *
	 * @return Response
	 */
	public function editAction(Request $request)
	{
		$user = $this->getUser();
		if (!is_object($user) || !$user instanceof UserInterface) {
			throw new AccessDeniedException('This user does not have access to this section.');
		}
		
		/** @var $dispatcher EventDispatcherInterface */
		$dispatcher = $this->get('event_dispatcher');
		
		$event = new GetResponseUserEvent($user, $request);
		$dispatcher->dispatch(FOSUserEvents::PROFILE_EDIT_INITIALIZE, $event);
		
		if (null !== $event->getResponse()) {
			return $event->getResponse();
		}
		
		/** @var $formFactory FactoryInterface */
		$formFactory = $this->get('fos_user.profile.form.factory');
		
		$form = $formFactory->createForm();
		$form->setData($user);
		
		$form->handleRequest($request);
		
		if ($form->isValid()) {
			/** @var $userManager UserManagerInterface */
			$userManager = $this->get('fos_user.user_manager');
			
			$event = new FormEvent($form, $request);
			$dispatcher->dispatch(FOSUserEvents::PROFILE_EDIT_SUCCESS, $event);
			
			$userManager->updateUser($user);
			
			if (null === $response = $event->getResponse()) {
				$url = $this->generateUrl('fos_user_profile_show');
				$response = new RedirectResponse($url);
			}
			
			$dispatcher->dispatch(FOSUserEvents::PROFILE_EDIT_COMPLETED, new FilterUserResponseEvent($user, $request, $response));
			
			return $response;
		}
		
		return $this->render('FOSUserBundle:Profile:edit.html.twig', array(
				'form' => $form->createView(),
		));
	}
}
