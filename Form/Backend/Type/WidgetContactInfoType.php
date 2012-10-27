<?php
/*
 * This file is part of NeutronContactBundleBundle
 *
 * (c) Zender <azazen09@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */
namespace Neutron\Plugin\ContactBundle\Form\Backend\Type;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;

use Symfony\Component\Form\FormView;

use Symfony\Component\Form\FormInterface;

use Symfony\Component\OptionsResolver\OptionsResolverInterface;

use Symfony\Component\Form\FormBuilderInterface;

use Symfony\Component\Form\AbstractType;

/**
 * Short description
 *
 * @author Zender <azazen09@gmail.com>
 * @since 1.0
 */
class WidgetContactInfoType extends AbstractType
{
    
    protected $dataGrid;
    
    protected $eventSubscriber;
    
    protected $widgetContactInfoClass;
    
    protected $contactInfoClass;
    
    protected $contactInfoReferenceClass;
    
    protected $templates;
    
    protected $translationDomain;
    
    public function setDataGrid($dataGrid)
    {
        $this->dataGrid = $dataGrid;
    }
    
    public function setEventSubscriber(EventSubscriberInterface $eventSubscriber)
    {
        $this->eventSubscriber = $eventSubscriber;
    }
    
    public function setWidgetContactInfoClass($widgetContactInfoClass)
    {
        $this->widgetContactInfoClass = $widgetContactInfoClass;
    }
    
    public function setContactInfoClass($contactInfoClass)
    {
        $this->contactInfoClass = $contactInfoClass;
    }
    
    public function setContactInfoReferenceClass($contactInfoReferenceClass)
    {
        $this->contactInfoReferenceClass = $contactInfoReferenceClass;
    }
    
    public function setTemplates(array $templates)
    {
        $this->templates = $templates;
    }


    public function setTranslationDomain($translationDomain)
    {
        $this->translationDomain = $translationDomain;
    }
    
    /**
     * (non-PHPdoc)
     * @see Symfony\Component\Form.AbstractType::buildForm()
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('references', 'neutron_multi_select_sortable_collection', array(
                'grid' => $this->dataGrid,
                'options' => array(
                    'data_class' => $this->contactInfoReferenceClass,
                    'inversed_class' => $this->contactInfoClass
                )
            
            ))
            ->add('template', 'choice', array(
                'choices' => $this->templates,
                'multiple' => false,
                'expanded' => false,
                'attr' => array('class' => 'uniform'),
                'label' => 'form.template',
                'empty_value' => 'form.empty_value',
                'translation_domain' => $this->translationDomain
            ))
            ->add('enabled', 'checkbox', array(
                'label' => 'form.enabled', 
                'value' => true,
                'required' => false,
                'attr' => array('class' => 'uniform'),
                'translation_domain' => $this->translationDomain
            ))
        
        ;
        
        $builder->addEventSubscriber($this->eventSubscriber);
    }
    
    /**
     * (non-PHPdoc)
     * @see Symfony\Component\Form.AbstractType::setDefaultOptions()
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => $this->widgetContactInfoClass,
            'validation_groups' => function(FormInterface $form){
                return 'default';
            },
        ));
    }
    
    /**
     * (non-PHPdoc)
     * @see Symfony\Component\Form.FormTypeInterface::getName()
     */
    public function getName()
    {
        return 'neutron_backend_widget_contact_info';
    }
}