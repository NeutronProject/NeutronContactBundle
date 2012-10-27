<?php
namespace Neutron\Plugin\ContactBundle\Model;

interface WidgetContactBlockAwareInterface 
{
    public function setWidgetContactBlock(WidgetContactBlockInterface $widgetContactBlock);
    
    public function getWidgetContactBlock();
}

