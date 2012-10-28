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
        
        if ($config['enable'] === false){
            $container->getDefinition('neutron_contact.plugin')
                ->clearTag('neutron.plugin');
            return;
        }
        
        $this->loadGeneralConfigurations($config, $container);
 
    }
    
    protected function loadGeneralConfigurations(array $config, ContainerBuilder $container)
    {
        $container->setParameter('neutron_contact.contact_class', $config['class']);
        $container->setAlias('neutron_contact.contact_manager', $config['manager']);
        $container->setAlias('neutron_contact.controller.backend.contact', $config['controller_backend']);
        $container->setAlias('neutron_contact.controller.frontend.contact', $config['controller_frontend']);
        
        $container->setAlias('neutron_contact.form.backend.handler.contact', $config['form']['handler']);
        $container->setParameter('neutron_contact.form.backend.type.contact', $config['form']['type']);
        $container->setParameter('neutron_contact.form.backend.name.contact', $config['form']['name']);
        
        $container->setParameter('neutron_contact.contact_templates', $config['templates']);
        $container->setParameter('neutron_contact.translation_domain', $config['translation_domain']);
    }
    
}
