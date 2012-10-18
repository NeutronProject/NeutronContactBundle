<?php
/*
 * This file is part of NeutronContactBundle
 *
 * (c) Zender <azazen09@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */
namespace Neutron\Plugin\ContactBundle\Form\Type\Contact;

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
    
    protected $contactClass;
    
    protected $contactFormClass;
    
    protected $templates;
    
    protected $allowedRoles = array('ROLE_SUPER_ADMIN');
    
    protected $translationDomain;
    
    public function setContactClass($contactClass)
    {
        $this->contactClass = $contactClass;
    }
    
    public function setContactFormClass($contactFormClass)
    {
        $this->contactFormClass = $contactFormClass;
    }
    
    public function setTemplates($templates)
    {
        $this->templates = $templates;
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
            ->add('name', 'choice', array(
                'choices' => $this->templates,
                'multiple' => false,
                'expanded' => false,
                'attr' => array('class' => 'uniform'),
                'label' => 'Label',
                'empty_value' => 'form.empty_value',
                'translation_domain' => $this->translationDomain
            ))
            ->add('contactForm', 'entity', array(
                'class' => $this->contactFormClass,
                'property' => 'f.name',
                'query_builder' => function(EntityRepository $er) {
                return $er->createQueryBuilder('f')
                    ->select('f.name')
                    ->where('f.enabled = ?1')
                    ->orderBy('f.name', 'ASC')
                    ->setParameters(array(1 => true));
                },
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
        return 'neutron_contact_content';
    }
}