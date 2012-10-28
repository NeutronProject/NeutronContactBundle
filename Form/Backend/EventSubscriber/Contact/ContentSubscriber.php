<?php 
/*
 * This file is part of NeutronContactBundle
 *
 * (c) Zender <azazen09@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */
namespace Neutron\Plugin\ContactBundle\Form\Backend\EventSubscriber\Contact;

use Symfony\Component\Form\FormEvent;

use Symfony\Component\Form\FormEvents;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;

/**
 * From event subscriber
 *
 * @author Nikolay Georgiev <azazen09@gmail.com>
 * @since 1.0
 */
class ContentSubscriber implements EventSubscriberInterface
{   
    protected $widgetContactFormEnabled;
    
    protected $widgetContactBlockEnabled;
    
    public function __construct($widgetContactFormEnabled, $widgetContactBlockEnabled)
    {
        $this->widgetContactFormEnabled = $widgetContactFormEnabled;
        $this->widgetContactBlockEnabled = $widgetContactBlockEnabled;
    }
    
    public function preSetData(FormEvent $event)
    {  
        $form = $event->getForm();
        $data = $event->getData();
        
        if (empty($data)) {
            return;
        }
        
        if (!$this->widgetContactFormEnabled){
            $form->remove('contactForm');
        }
        
        if (!$this->widgetContactBlockEnabled){
            $form->remove('widgetContactBlock');
        }
    }
    
    /**
     * Subscription for Form Events
     */
    static function getSubscribedEvents()
    {
        return array(
            FormEvents::PRE_SET_DATA => 'preSetData',
        );
    }

}