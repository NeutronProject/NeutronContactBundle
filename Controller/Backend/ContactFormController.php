<?php
namespace Neutron\Plugin\ContactBundle\Controller\Backend;

use Neutron\Plugin\ContactBundle\ContactPlugin;

use Symfony\Component\HttpFoundation\RedirectResponse;

use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

use Symfony\Component\HttpFoundation\Response;

use Symfony\Component\DependencyInjection\ContainerAware;

class ContactFormController extends ContainerAware
{
    public function indexAction()
    {
        $datagrid = $this->container->get('neutron.datagrid')
            ->get($this->container->getParameter('neutron_contact.datagrid.contact_form_management'));
    
        $template = $this->container->get('templating')->render(
            'NeutronContactBundle:Backend\ContactForm:index.html.twig', array(
                'datagrid' => $datagrid,
                'translationDomain' => 
                    $this->container->getParameter('neutron_contact.translation_domain')
            )
        );
    
        return  new Response($template);
    }
    
    public function updateAction($id)
    {   
        $plugin = $this->container->get('neutron_mvc.plugin_provider')
            ->get(ContactPlugin::IDENTIFIER);
        $form = $this->container->get('neutron_contact.form.backend.contact_form');
        $handler = $this->container->get('neutron_contact.form.backend.handler.contact_form');
        $form->setData($this->getData($id));

        if (null !== $handler->process()){
            return new Response(json_encode($handler->getResult()));
        }

        $template = $this->container->get('templating')->render(
            'NeutronContactBundle:Backend\ContactForm:update.html.twig', array(
                'form' => $form->createView(),
                'plugin' => $plugin,
                'translationDomain' => 
                    $this->container->getParameter('neutron_contact.translation_domain')
            )
        );
    
        return  new Response($template);
    }
    
    public function deleteAction($id)
    {
        $plugin = $this->container->get('neutron_mvc.plugin_provider')
            ->get(ContactPlugin::IDENTIFIER);
        
        $entity = $this->getEntity($id);
    
        if ($this->container->get('request')->getMethod() == 'POST'){
            $this->container->get('neutron_contact.contact_form_manager')
                ->delete($entity, true);
            $redirectUrl = $this->container->get('router')
                ->generate('neutron_contact.backend.contact_form');
            return new RedirectResponse($redirectUrl);
        }
    
        $template = $this->container->get('templating')
            ->render('NeutronContactBundle:Backend\ContactForm:delete.html.twig', array(
                'entity' => $entity,
                'plugin' => $plugin,
                'translationDomain' =>
                    $this->container->getParameter('neutron_contact.translation_domain')
            )
        );
    
        return  new Response($template); 
    }
    
    public function getData($id)
    {
        $entity = $this->getEntity($id);
        
        return array('general' => $entity);
    }
    
    protected function getEntity($id)
    {

        $manager = $this->container->get('neutron_contact.contact_form_manager');
        
        if ($id){
            $entity = $manager->findOneBy(array('id' => $id));
        } else {
            $entity = $manager->create();
        }
        
        if (!$entity){
            throw new NotFoundHttpException();
        }
        
        return $entity;
    }
}
