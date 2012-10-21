<?php
namespace Neutron\Plugin\ContactBundle\Doctrine;

use Neutron\Plugin\ContactBundle\Model\ContactFormManagerInterface;

use Neutron\ComponentBundle\Doctrine\AbstractManager;

class ContactFormManager extends AbstractManager implements ContactFormManagerInterface
{
    public function getQueryBuilderForContactFormManagementDataGrid()
    {
        return $this->repository->getQueryBuilderForContactFormManagementDataGrid();
    }
    
    public function getQueryBuilderForContactFormChoices()
    {
        return $this->repository->getQueryBuilderForContactFormChoices();
    }
}