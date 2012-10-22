<?php
namespace Neutron\Plugin\ContactBundle\Controller\Frontend;

use Neutron\Plugin\ContactBundle\ContactPlugin;

use Neutron\MvcBundle\Provider\PluginProvider;

use Neutron\MvcBundle\Model\Category\CategoryInterface;

use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

use Symfony\Component\DependencyInjection\ContainerAware;

use Symfony\Component\HttpFoundation\Response;


class ContactController extends ContainerAware
{   
    public function indexAction(CategoryInterface $category)
    {   
        $contactManager = $this->container->get('neutron_contact.contact_manager');
        $entity = $contactManager->findOneBy(array('category' => $category));
        
        if (null === $entity){
            throw new NotFoundHttpException();
        }

       
        $form = $this->container->get('form.factory')
            ->createNamed('contact', $entity->getContactForm()->getForm());
        
        $handler = $this->container->get('neutron_contact.form.frontend.handler.contact_form');
        $handler->setForm($form);
        $handler->setContactFormEntity($entity->getContactForm());
        
        if (null !== $handler->process()){
            return new Response(json_encode($handler->getResult()));
        }

        $template = $this->container->get('templating')
            ->render($entity->getTemplate(), array(
                'entity'   => $entity,   
                'form' => $form->createView(),  
            )
        );
    
        return  new Response($template);
    }

}
