<?php
/*
 * This file is part of NeutronContactBundle
 *
 * (c) Zender <azazen09@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */
namespace Neutron\Plugin\ContactBundle\Form\Type\ContactForm;

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
    
    protected $contactFormClass;
    
    protected $mailTemplates;
    
    protected $recipients;
    
    protected $formChoices;
    
    protected $translationDomain;
    
    public function setContactFormClass($contactFormClass)
    {
        $this->contactFormClass = $contactFormClass;
    }
    
    public function setMailTemplates(array $mailTemplates)
    {
        $this->mailTemplates = $mailTemplates;
    }
    
    public function setRecipients(array $recipients)
    {
        $data = array();
        
        foreach ($recipients as $recipient){
            $data[$recipient] = $recipient;
        }
        
        $this->recipients = $data;
    }
    
    public function setFormChoices(array $formChoices)
    {
        $this->formChoices = $formChoices;
    }
    
    protected function setTranslationDomain($translationDomain)
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
            ->add('name', 'text', array(
                'label' => 'form.title',
                'translation_domain' => $this->translationDomain
            ))
            ->add('mailSubject', 'text', array(
                'label' => 'form.mailSubject',
                'translation_domain' => $this->translationDomain
            ))
            ->add('mailTemplate', 'choice', array(
                'choices' => $this->mailTemplates,
                'multiple' => false,
                'expanded' => false,
                'attr' => array('class' => 'uniform'),
                'label' => 'Label',
                'empty_value' => 'form.empty_value',
                'translation_domain' => $this->translationDomain
            ))
            ->add('recipients', 'neutron_select', array(
                'label' => 'form.roles',
                'multiple' => true,
                'choices' => $this->recipients,
                'configs' => array('filter' => true),
                'translation_domain' => $this->translationDomain
            ))
            ->add('form', 'choice', array(
                'choices' => $this->formChoices,
                'multiple' => false,
                'expanded' => false,
                'attr' => array('class' => 'uniform'),
                'label' => 'form.form',
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
    }
    
    
    /**
     * (non-PHPdoc)
     * @see Symfony\Component\Form.AbstractType::setDefaultOptions()
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => $this->contactFormClass,
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
        return 'neutron_contact_form_general';
    }
}