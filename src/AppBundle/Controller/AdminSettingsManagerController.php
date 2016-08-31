<?php
namespace AppBundle\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use AppBundle\Entity\Identifier;
use AppBundle\Form\IdentifierType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use AppBundle\Entity\Protein;
use AppBundle\Entity\Interaction;
use Symfony\Component\HttpFoundation\JsonResponse;
use AppBundle\Form\ChoiceList\ArrayChoiceList;
use AppBundle\Entity\Admin_Settings;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
/**
 * Admin Settings Controller
 */
class AdminSettingsManagerController extends Controller
{
    /**
     * Admin Settings
     *
     * @Route("/admin/settings/", name="admin_settings")
     * @Method({"GET", "POST"})
     */
    public function adminSettingsManagerAction(Request $request)
    {
        $admin_settings = $this->getDoctrine()
        ->getRepository('AppBundle:Admin_Settings')
        ->find(1);

        $title = $admin_settings->getTitle();
        $home_page = $admin_settings->getHomePage();
        $about = $admin_settings->getAbout();
        $color_scheme = $admin_settings->getColorScheme();
        $short_title = $admin_settings->getShortTitle();

        $form = $this->createForm('AppBundle\Form\Admin_SettingsType', $admin_settings);
        $form->add('submit', SubmitType::class, array(
                'label' => 'Update',
                'attr'  => array('class' => 'btn btn-success')
        ));
        $form->handleRequest($request);
         
        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $admin_settings = $form->getData();
            $title = $admin_settings->getTitle();
            $home_page = $admin_settings->getHomePage();
            $about = $admin_settings->getAbout();
            $color_scheme = $admin_settings->getColorScheme();
            $em->persist($admin_settings);
            $em->flush();
        }

        return $this->render('admin_settings.html.twig', array(
                'form' => $form->createView(),
                'title' => $title,
                'home_page' => $home_page,
                'about' => $about,
                'color_scheme' => $color_scheme,
                'short_title' => $short_title

        ));
    }

}
?>