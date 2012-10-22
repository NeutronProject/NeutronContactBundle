<?php
namespace Neutron\Plugin\ContactBundle\Form\Frontend\Handler;

use Neutron\Plugin\ContactBundle\Model\ContactFormInterface;

use Neutron\ComponentBundle\Form\Handler\AbstractFormHandler;

class ContactFormHandler extends AbstractFormHandler
{    
    
    protected $contactFormEntity;
    
    public function setContactFormEntity(ContactFormInterface $contactFormEntity)
    {
        $this->contactFormEntity = $contactFormEntity;
    }
    
    protected function onSuccess()
    {   
        $context = $this->form->getData();
        $contactMailer = $this->container->get('neutron_contact.mailer');
        $contactMailer->sendMessage($this->contactFormEntity, $context);
    }
}