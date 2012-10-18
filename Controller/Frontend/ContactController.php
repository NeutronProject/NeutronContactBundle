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
        $plugin = $this->container->get('neutron_mvc.plugin_provider')->get(ContactPlugin::IDENTIFIER);
        $contactManager = $this->container->get($plugin->getManagerServiceId());
        $entity = $contactManager->findOneBy(array('category' => $category));
        
        if (null === $entity){
            throw new NotFoundHttpException();
        }

       
        $template = $this->container->get('templating')
            ->render($entity->getTemplate(), array(
                'entity'   => $entity,     
                'plugin' => $plugin   
            )
        );
    
        return  new Response($template);
    }
  
}
