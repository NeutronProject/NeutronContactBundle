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
        
        foreach (array('services', 'contact', 'contact_form') as $basename) {
            $loader->load(sprintf('%s.xml', $basename));
        }
        
        if ($config['enable'] === false){
            $container->getDefinition('neutron_contact.plugin')
                ->clearTag('neutron.plugin');
            return;
        }
        
        $this->loadGeneralConfigurations($config, $container);
        $this->loadContactConfigurations($config['contact'], $container);
        $this->loadWidgetContactFormConfigurations($config['widget_contact_form'], $container);
        //$this->loadWidgetContactBlockConfigurations($config['widget_contact_block'], $container);
        
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
    
    protected function loadWidgetContactFormConfigurations(array $config, ContainerBuilder $container)
    {
        
        if (false === $config['enable']){
            $container->getDefinition('neutron_contact.widget.contact_form')
                ->clearTag('neutron.widget');    
        }
        
        $container->setParameter('neutron_contact.widget.contact_form.enable', $config['enable']);
        $container->setParameter('neutron_contact.contact_form_class', $config['class']);
        $container->setAlias('neutron_contact.contact_form_manager', $config['manager']);
        $container->setAlias('neutron_contact.controller.backend.contact_form', $config['controller_backend']);
        $container->setAlias('neutron_contact.controller.frontend.contact_form', $config['controller_frontend']);
        $container->setParameter('neutron_contact.datagrid.contact_form_management', $config['datagrid']);
       
        $container->setAlias('neutron_contact.form.backend.handler.contact_form', $config['form']['handler']);
        $container->setParameter('neutron_contact.form.backend.type.contact_form', $config['form']['type']);
        $container->setParameter('neutron_contact.form.backend.name.contact_form', $config['form']['name']);
        
        
        $container->setParameter('neutron_contact.contact_form_choices', $config['form_choices']);
        $container->setParameter('neutron_contact.contact_form_templates', $config['templates']);
        
    }
    
    protected function loadWidgetContactBlockConfigurations(array $config, ContainerBuilder $container)
    {
        $container->setParameter('neutron_contact.contact_block_class', $config['block_class']);
        $container->setParameter('neutron_contact.widget_contact_block_class', $config['widget_class']);
        $container->setParameter('neutron_contact.contact_block_reference_class', $config['reference_class']);
        $container->setAlias('neutron_contact.contact_block_manager', $config['block_manager']);
        $container->setAlias('neutron_contact.widget_contact_block_manager', $config['widget_manager']);
        $container->setAlias('neutron_contact.controller.backend.contact_block', $config['block_controller_backend']);
        $container->setAlias('neutron_contact.controller.backend.widget_contact_block', $config['widget_controller_backend']);
        $container->setAlias('neutron_contact.controller.frontend.widget_contact_block', $config['widget_controller_frontend']);
       
        $container->setAlias('neutron_contact.form.backend.handler.contact_block', $config['block_form_backend']['handler']);
        $container->setParameter('neutron_contact.form.backend.type.contact_block', $config['block_form_backend']['type']);
        $container->setParameter('neutron_contact.form.backend.name.contact_block', $config['block_form_backend']['name']);
        
        $container->setAlias('neutron_contact.form.backend.handler.widget_contact_block', $config['widget_form_backend']['handler']);
        $container->setParameter('neutron_contact.form.backend.type.widget_contact_block', $config['widget_form_backend']['type']);
        $container->setParameter('neutron_contact.form.backend.name.widget_contact_block', $config['widget_form_backend']['name']);
        
        $container->setParameter('neutron_contact.datagrid.contact_block_management', $config['datagrid_block_management']);
        $container->setParameter('neutron_contact.datagrid.contact_block_management', $config['datagrid_widget_block_management']);
        $container->setParameter('neutron_contact.datagrid.contact_block_management', $config['datagrid_block_multi_select_sortable']);
        $container->setParameter('neutron_contact.widget_contact_info_templates', $config['widget_templates']);
    }
}
