<?php
namespace Neutron\Plugin\ContactBundle\DataGrid;

use Neutron\Plugin\ContactBundle\Model\ContactBlockManagerInterface;

use Symfony\Bundle\FrameworkBundle\Routing\Router;

use Symfony\Bundle\FrameworkBundle\Translation\Translator;

use Neutron\Bundle\DataGridBundle\DataGrid\FactoryInterface;

class ContactBlockManagementDataGrid
{

    const IDENTIFIER = 'neutron_contact_block_management';
    
    protected $factory;
    
    protected $translator;
    
    protected $router;
    
    protected $manager;
    
    protected $translationDomain;
   

    public function __construct (FactoryInterface $factory, Translator $translator, Router $router, 
             ContactBlockManagerInterface $manager, $translationDomain)
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
                $this->translator->trans('grid.contact_block_management.title',  array(), $this->translationDomain)
            )
            ->setAutoWidth(true)
            ->setColNames(array(
                $this->translator->trans('grid.contact_block_management.title',  array(), $this->translationDomain),
                $this->translator->trans('grid.contact_block_management.phone',  array(), $this->translationDomain),
                $this->translator->trans('grid.contact_block_management.email',  array(), $this->translationDomain),
                $this->translator->trans('grid.contact_block_management.city',  array(), $this->translationDomain),
                $this->translator->trans('grid.contact_block_management.enabled',  array(), $this->translationDomain),
            ))
            ->setColModel(array(
                array(
                    'name' => 'b.title', 'index' => 'b.title', 'width' => 200, 
                    'align' => 'left', 'sortable' => true, 'search' => true,
                ), 
                array(
                    'name' => 'b.phone', 'index' => 'b.phone', 'width' => 200, 
                    'align' => 'left', 'sortable' => true, 'search' => true,
                ), 
                array(
                    'name' => 'b.email', 'index' => 'b.email', 'width' => 200, 
                    'align' => 'left', 'sortable' => true, 'search' => true,
                ), 
                array(
                    'name' => 'b.city', 'index' => 'b.city', 'width' => 200, 
                    'align' => 'left', 'sortable' => true, 'search' => true,
                ), 
                array(
                    'name' => 'b.enabled', 'index' => 'b.enabled', 'width' => 200, 
                    'align' => 'left', 'sortable' => true, 'search' => true,
                    'formatter' => 'checkbox',  'search' => true, 'stype' => 'select',
                    'searchoptions' => array('value' => array(
                        1 => $this->translator->trans('grid.enabled', array(), $this->translationDomain), 
                        0 => $this->translator->trans('grid.disabled', array(), $this->translationDomain), 
                    ))
                ), 

            ))
            ->setQueryBuilder($this->manager->getQueryBuilderForContactBlockManagementDataGrid())
            ->setSortName('b.title')
            ->setSortOrder('asc')
            ->enablePager(true)
            ->enableViewRecords(true)
            ->enableSearchButton(true)
            ->enableAddButton(true)
            ->setAddBtnUri($this->router->generate('neutron_contact.backend.contact_block.update', array(), true))
            ->enableEditButton(true)
            ->setEditBtnUri($this->router->generate('neutron_contact.backend.contact_block.update', array('id' => '{id}'), true))
            ->enableDeleteButton(true)
            ->setDeleteBtnUri($this->router->generate('neutron_contact.backend.contact_block.delete', array('id' => '{id}'), true))
        ;

        return $dataGrid;
    }



}