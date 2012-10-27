<?php
/*
 * This file is part of NeutronContactBundle
 *
 * (c) Zender <azazen09@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */
namespace Neutron\Plugin\ContactBundle\Form\Backend\Type\ContactInfo;

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
class GeneralType extends AbstractType
{
    
    protected $contactInfoClass;
    
    protected $translationDomain;
    
    public function setContactInfoClass($contactInfoClass)
    {   
        $this->contactInfoClass = $contactInfoClass;
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
            ->add('phone', 'text', array(
                'label' => 'form.phone',
                'translation_domain' => $this->translationDomain
            ))
            ->add('fax', 'text', array(
                'label' => 'form.fax',
                'translation_domain' => $this->translationDomain
            ))
            ->add('email', 'text', array(
                'label' => 'form.email',
                'translation_domain' => $this->translationDomain
            ))
            ->add('address', 'text', array(
                'label' => 'form.address',
                'translation_domain' => $this->translationDomain
            ))
            ->add('postCode', 'text', array(
                'label' => 'form.postCode',
                'translation_domain' => $this->translationDomain
            ))
            ->add('city', 'text', array(
                'label' => 'form.city',
                'translation_domain' => $this->translationDomain
            ))
            ->add('country', 'text', array(
                'label' => 'form.country',
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
    }
    
    
    /**
     * (non-PHPdoc)
     * @see Symfony\Component\Form.AbstractType::setDefaultOptions()
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => $this->contactInfoClass,
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
        return 'neutron_backend_contact_info_general';
    }
}