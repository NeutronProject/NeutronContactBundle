<?php
namespace Neutron\Plugin\ContactBundle\Controller\Frontend;

use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

use Neutron\Plugin\ContactBundle\Model\ContactFormInterface;

use Symfony\Component\DependencyInjection\ContainerAware;

use Symfony\Component\HttpFoundation\Response;


class ContactFormController extends ContainerAware
{   
    public function renderAction(ContactFormInterface $widget = null)
    {   
        if (null === $widget || 
                !$this->container->getParameter('neutron_contact.widget.contact_form.enable')){
            return  new Response();
        }
        
        $form = $this->container->get('form.factory')
            ->createNamed('contact', $widget->getForm());

        $template = $this->container->get('templating')
            ->render($widget->getTemplate(), array(
                'widget' => $widget,  
                'form' => $form->createView()  
            )
        );
    
        return  new Response($template);
    }
    
    public function handleAction($id)
    { 
        $manager = $this->container->get('neutron_contact.contact_form_manager');
        $contactForm = $manager->findOneBy(array('id' => $id, 'enabled' => true));
        
        if (null === $contactForm || 
                !$this->container->getParameter('neutron_contact.widget.contact_form.enable')){
            throw new NotFoundHttpException();
        }
        
        $form = $this->container->get('form.factory')
            ->createNamed('contact', $contactForm->getForm());
        
        $handler = $this->container->get('neutron_contact.form.frontend.handler.contact_form');
        $handler->setForm($form);
        $handler->setContactFormEntity($contactForm);
        $handler->process();
        
        return new Response(json_encode($handler->getResult()));
    }

}
