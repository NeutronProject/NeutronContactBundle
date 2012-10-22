<?php
namespace Neutron\Plugin\ContactBundle\Form\Backend\Handler;

use Neutron\ComponentBundle\Form\Handler\AbstractFormHandler;

class ContactInfoHandler extends AbstractFormHandler
{    
    protected function onSuccess()
    {   
        $general = $this->form->get('general')->getData();
        $this->container->get('neutron_contact.contact_info_manager')->update($general, true);
    }
    
    protected function getRedirectUrl()
    {
        return $this->container->get('router')->generate('neutron_contact.backend.contact_info');
    }
}