<?php
namespace Neutron\Plugin\ContactBundle\Model;

interface ContactInfoManagerInterface 
{
    public function getQueryBuilderForContactInfoManagementDataGrid();
}

