<?php
namespace Neutron\Plugin\ContactBundle\Controller\Frontend;

use Neutron\Plugin\ContactBundle\Model\WidgetContactInfoInterface;

use Symfony\Component\DependencyInjection\ContainerAware;

use Symfony\Component\HttpFoundation\Response;


class WidgetContactInfoController extends ContainerAware
{   
    public function renderAction(WidgetContactInfoInterface $widget)
    {   
        $widgetContactInfoManager = $this->container
                ->get('neutron_contact.widget_contact_info_manager');
        //$entity = $widgetContactInfoManager->findOneBy(array('category' => $category));
        
        $template = $this->container->get('templating')
            ->render($widget->getTemplate(), array(
                'widget' => $widget,    
            )
        );
    
        return  new Response($template);
    }

}
