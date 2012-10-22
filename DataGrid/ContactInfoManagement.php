<?php
namespace Neutron\Plugin\ContactBundle\DataGrid;

use Neutron\Plugin\ContactBundle\Model\ContactInfoManagerInterface;

use Symfony\Bundle\FrameworkBundle\Routing\Router;

use Symfony\Bundle\FrameworkBundle\Translation\Translator;

use Neutron\Bundle\DataGridBundle\DataGrid\FactoryInterface;

class ContactInfoManagement
{

    const IDENTIFIER = 'neutron_contact_info_management';
    
    protected $factory;
    
    protected $translator;
    
    protected $router;
    
    protected $manager;
    
    protected $translationDomain;
   

    public function __construct (FactoryInterface $factory, Translator $translator, Router $router, 
             ContactInfoManagerInterface $manager, $translationDomain)
    {
        $this->factory = $factory;
        $this->translator = $translator;
        $this->router = $router;
        $this->manager = $manager;
        $this->translationDomain = $translationDomain;
    }

    public function build ()
    {
        
        $dataGrid = $this->factory->createDataGrid(self::IDENTIFIER);
        $dataGrid
            ->setCaption(
                $this->translator->trans('grid.contact_info_management.title',  array(), $this->translationDomain)
            )
            ->setAutoWidth(true)
            ->setColNames(array(
                $this->translator->trans('grid.contact_info_management.name',  array(), $this->translationDomain),
                $this->translator->trans('grid.contact_info_management.phone',  array(), $this->translationDomain),
                $this->translator->trans('grid.contact_info_management.email',  array(), $this->translationDomain),
                $this->translator->trans('grid.contact_info_management.city',  array(), $this->translationDomain),
                $this->translator->trans('grid.contact_info_management.enabled',  array(), $this->translationDomain),
            ))
            ->setColModel(array(
                array(
                    'name' => 'i.name', 'index' => 'i.email', 'width' => 200, 
                    'align' => 'left', 'sortable' => true, 'search' => true,
                ), 
                array(
                    'name' => 'i.phone', 'index' => 'i.phone', 'width' => 200, 
                    'align' => 'left', 'sortable' => true, 'search' => true,
                ), 
                array(
                    'name' => 'i.email', 'index' => 'i.email', 'width' => 200, 
                    'align' => 'left', 'sortable' => true, 'search' => true,
                ), 
                array(
                    'name' => 'i.city', 'index' => 'i.city', 'width' => 200, 
                    'align' => 'left', 'sortable' => true, 'search' => true,
                ), 
                array(
                    'name' => 'i.enabled', 'index' => 'i.enabled', 'width' => 200, 
                    'align' => 'left', 'sortable' => true, 'search' => true,
                    'formatter' => 'checkbox',  'search' => true, 'stype' => 'select',
                    'searchoptions' => array('value' => array(
                        1 => $this->translator->trans('grid.enabled', array(), $this->translationDomain), 
                        0 => $this->translator->trans('grid.disabled', array(), $this->translationDomain), 
                    ))
                ), 

            ))
            ->setQueryBuilder($this->manager->getQueryBuilderForContactInfoManagementDataGrid())
            ->setSortName('i.name')
            ->setSortOrder('asc')
            ->enablePager(true)
            ->enableViewRecords(true)
            ->enableSearchButton(true)
            ->enableAddButton(true)
            ->setAddBtnUri($this->router->generate('neutron_contact.backend.contact_info.update', array(), true))
            ->enableEditButton(true)
            ->setEditBtnUri($this->router->generate('neutron_contact.backend.contact_info.update', array('id' => '{id}'), true))
            ->enableDeleteButton(true)
            ->setDeleteBtnUri($this->router->generate('neutron_contact.backend.contact_info.delete', array('id' => '{id}'), true))
        ;

        return $dataGrid;
    }



}