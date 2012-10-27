<?php
namespace Neutron\Plugin\ContactBundle\Model;

interface WidgetContactInfoAwareInterface 
{
    public function setWidgetContactInfo(WidgetContactInfoInterface $widgetContactInfo);
    
    public function getWidgetContactInfo();
}

