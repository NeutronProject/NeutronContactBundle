<?php
/*
 * This file is part of NeutronContactBundle
 *
 * (c) Zender <azazen09@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */
namespace Neutron\Plugin\ContactBundle\Form\Backend\Type\Contact;

use Neutron\Widget\ContactFormBundle\Model\ContactFormManagerInterface;

use Neutron\Widget\ContactBlockBundle\Model\WidgetContactBlockManagerInterface;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;

use Doctrine\ORM\EntityRepository;

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
class ContentType extends AbstractType
{
    
    protected $contactFormManager;
    
    protected $widgetContactBlockManager;
    
    protected $contactClass;
    
    protected $templates;
    
    protected $allowedRoles = array('ROLE_SUPER_ADMIN');
    
    protected $eventSubscriber;
    
    protected $translationDomain;
    
    public function setContactFormManager(ContactFormManagerInterface $contactFormManager)
    {
        $this->contactFormManager = $contactFormManager;
    }
    
    public function setWidgetContactBlockManager(WidgetContactBlockManagerInterface $widgetContactBlockManager)
    {
        $this->widgetContactBlockManager = $widgetContactBlockManager;
    }
    
    public function setContactClass($contactClass)
    {
        $this->contactClass = $contactClass;
    }
    
    public function setTemplates($templates)
    {
        $this->templates = $templates;
    }
    
    public function setEventSubscriber(EventSubscriberInterface $eventSubscriber)
    {
        $this->eventSubscriber = $eventSubscriber;
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
            ->add('title', 'text', array(
                'label' => 'form.title',
                'translation_domain' => $this->translationDomain
            ))
            ->add('content', 'neutron_tinymce', array(
                'label' => 'form.content',
                'security' => $this->allowedRoles,
                'translation_domain' => $this->translationDomain,
                'configs' => array(
                    'theme' => 'advanced', //simple
                    'skin'  => 'o2k7',
                    'skin_variant' => 'black',
                    //'width' => '60%',
                    'height' => 300,
                    'dialog_type' => 'modal',
                    'readOnly' => false,
                ),
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
            ->add('contactForm', 'entity', array(
                'multiple' => false,
                'attr' => array('class' => 'uniform'),
                'label' => 'form.contactForm',
                'empty_value' => 'form.empty_value',
                'class' => $this->contactFormManager->getClassName(),
                'property' => 'name',
                'query_builder' => $this->contactFormManager->getQueryBuilderForContactFormChoices(),
                'translation_domain' => $this->translationDomain
            ))
            ->add('widgetContactBlock', 'entity', array(
                'multiple' => false,
                'attr' => array('class' => 'uniform'),
                'label' => 'form.widgetContactBlock',
                'empty_value' => 'form.empty_value',
                'class' => $this->widgetContactBlockManager->getClassName(),
                'property' => 'title',
                'query_builder' => $this->widgetContactBlockManager->getQueryBuilderForFormChoices(),
                'translation_domain' => $this->translationDomain
            ))
        ;
        
        //$builder->addEventSubscriber($this->eventSubscriber);
    }
    
    
    /**
     * (non-PHPdoc)
     * @see Symfony\Component\Form.AbstractType::setDefaultOptions()
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => $this->contactClass,
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
        return 'neutron_backend_contact_content';
    }
}