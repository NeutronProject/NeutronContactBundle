<?php
namespace Neutron\Plugin\ContactBundle\Doctrine;

use Neutron\Plugin\ContactBundle\Model\ContactInfoManagerInterface;

use Neutron\ComponentBundle\Doctrine\AbstractManager;

class ContactInfoManager extends AbstractManager implements ContactInfoManagerInterface
{
    public function getQueryBuilderForContactInfoManagementDataGrid()
    {
        return $this->repository->getQueryBuilderForContactInfoManagementDataGrid();
    }
    
    public function getQueryBuilderForContactInfoMultiSelectSortableDataGrid()
    {
        return $this->repository->getQueryBuilderForContactInfoMultiSelectSortableDataGrid();
    }
}