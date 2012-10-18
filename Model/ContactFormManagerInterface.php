<?php
namespace Neutron\Plugin\ContactBundle\Model;

interface ContactFormManagerInterface
{
    public function getQueryBuilderForContactFormManagementDataGrid();
}

