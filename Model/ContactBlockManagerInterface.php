<?php
namespace Neutron\Plugin\ContactBundle\Model;

interface ContactBlockManagerInterface 
{
    public function getQueryBuilderForContactBlockManagementDataGrid();
    
    public function getQueryBuilderForContactBlockMultiSelectSortableDataGrid();
}

