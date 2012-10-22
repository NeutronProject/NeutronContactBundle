<?php

namespace Neutron\Plugin\ContactBundle\DependencyInjection;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;
use Symfony\Component\DependencyInjection\Loader;

/**
 * This is the class that loads and manages your bundle configuration
 *
 * To learn more see {@link http://symfony.com/doc/current/cookbook/bundles/extension.html}
 */
class NeutronContactExtension extends Extension
{
    /**
     * {@inheritDoc}
     */
    public function load(array $configs, ContainerBuilder $container)
    {
        $configuration = new Configuration();
        $config = $this->processConfiguration($configuration, $configs);

        $loader = new Loader\XmlFileLoader($container, new FileLocator(__DIR__.'/../Resources/config'));
        $loader->load('services.xml');
        //var_dump($config); die;
        
        foreach (array('services', 'contact', 'contact_form', 'contact_info') as $basename) {
            $loader->load(sprintf('%s.xml', $basename));
        }
        
        if ($config['enable'] === false){
            $container->getDefinition('neutron_contact.plugin')
                ->clearTag('neutron.plugin');
            return;
        }
        
        $this->loadGeneralConfigurations($config, $container);
        $this->loadContactConfigurations($config['contact'], $container);
        $this->loadContactFormConfigurations($config['contact_form'], $container);
        $this->loadContactInfoConfigurations($config['contact_info'], $container);
        
    }
    
    protected function loadGeneralConfigurations(array $config, ContainerBuilder $container)
    {
        $container->setParameter('neutron_contact.mail_recipients', $config['mail_recipients']);
        $container->setParameter('neutron_contact.mail_templates', $config['mail_templates']);
        $container->setAlias('neutron_contact.mailer', $config['mailer']);
        $container->setAlias('neutron_contact.form.frontend.handler.contact_form', $config['mail_handler']);
        $container->setParameter('neutron_contact.translation_domain', $config['translation_domain']);
    }
    
    protected function loadContactConfigurations(array $config, ContainerBuilder $container)
    {
        $container->setParameter('neutron_contact.contact_class', $config['class']);
        $container->setAlias('neutron_contact.contact_manager', $config['manager']);
        $container->setAlias('neutron_contact.controller.backend.contact', $config['controller_backend']);
        $container->setAlias('neutron_contact.controller.frontend.contact', $config['controller_frontend']);
        
        $container->setAlias('neutron_contact.form.backend.handler.contact', $config['form']['handler']);
        $container->setParameter('neutron_contact.form.backend.type.contact', $config['form']['type']);
        $container->setParameter('neutron_contact.form.backend.name.contact', $config['form']['name']);
        
        $container->setParameter('neutron_contact.contact_templates', $config['templates']);
        
    }
    
    protected function loadContactFormConfigurations(array $config, ContainerBuilder $container)
    {
        $container->setParameter('neutron_contact.contact_form_class', $config['class']);
        $container->setAlias('neutron_contact.contact_form_manager', $config['manager']);
        $container->setAlias('neutron_contact.controller.backend.contact_form', $config['controller_backend']);
        $container->setParameter('neutron_contact.datagrid.contact_form_management', $config['datagrid']);
       
        $container->setAlias('neutron_contact.form.backend.handler.contact_form', $config['form']['handler']);
        $container->setParameter('neutron_contact.form.backend.type.contact_form', $config['form']['type']);
        $container->setParameter('neutron_contact.form.backend.name.contact_form', $config['form']['name']);
        
        
        $container->setParameter('neutron_contact.contact_form_choices', $config['form_choices']);
        
    }
    
    protected function loadContactInfoConfigurations(array $config, ContainerBuilder $container)
    {
        $container->setParameter('neutron_contact.contact_info_class', $config['class']);
        $container->setAlias('neutron_contact.contact_info_manager', $config['manager']);
        $container->setAlias('neutron_contact.controller.backend.contact_info', $config['controller_backend']);
       
        $container->setAlias('neutron_contact.form.backend.handler.contact_info', $config['form_backend']['handler']);
        $container->setParameter('neutron_contact.form.backend.type.contact_info', $config['form_backend']['type']);
        $container->setParameter('neutron_contact.form.backend.name.contact_info', $config['form_backend']['name']);
        
        $container->setParameter('neutron_contact.datagrid.contact_info_management', $config['datagrid']);
    }
}
