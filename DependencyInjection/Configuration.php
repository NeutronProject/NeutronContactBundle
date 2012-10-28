<?php

namespace Neutron\Plugin\ContactBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\ArrayNodeDefinition;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

/**
 * This is the class that validates and merges configuration from your app/config files
 *
 * To learn more see {@link http://symfony.com/doc/current/cookbook/bundles/extension.html#cookbook-bundles-extension-config-class}
 */
class Configuration implements ConfigurationInterface
{
    /**
     * {@inheritDoc}
     */
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        $rootNode = $treeBuilder->root('neutron_contact');
        
        $this->addGeneralConfigurations($rootNode);
        $this->addContactConfigurations($rootNode);
        $this->addWidgetContactFormConfigurations($rootNode);


        return $treeBuilder;
    }
    
    private function addGeneralConfigurations(ArrayNodeDefinition $node)
    {
        $node
            ->addDefaultsIfNotSet()
            ->children()
                ->booleanNode('enable')->defaultFalse()->end()
                ->arrayNode('mail_recipients')
                    ->useAttributeAsKey('name')
                        ->prototype('scalar')
                    ->end() 
                    ->cannotBeOverwritten()
                    ->isRequired()
                    ->cannotBeEmpty()
                ->end()
                ->arrayNode('mail_templates')
                    ->useAttributeAsKey('name')
                        ->prototype('scalar')
                    ->end() 
                    ->cannotBeOverwritten()
                    ->isRequired()
                    ->cannotBeEmpty()
                ->end()
                ->scalarNode('mailer')->defaultValue('neutron_contact.mailer.default')->end()
                ->scalarNode('mail_handler')->defaultValue('neutron_contact.form.frontend.handler.contact_form.default')->end()
                ->scalarNode('translation_domain')->defaultValue('NeutronContactBundle')->end()
            ->end()
        ;
    }
    
    private function addContactConfigurations(ArrayNodeDefinition $node)
    {
        $node
            ->children()
                 ->arrayNode('contact')
                    ->addDefaultsIfNotSet()
                        ->children()
                            ->scalarNode('class')->isRequired()->cannotBeEmpty()->end()
                            ->scalarNode('controller_backend')->defaultValue('neutron_contact.controller.backend.contact.default')->end()
                            ->scalarNode('controller_frontend')->defaultValue('neutron_contact.controller.frontend.contact.default')->end()
                            ->scalarNode('manager')->defaultValue('neutron_contact.doctrine.contact_manager.default')->end()
                            ->arrayNode('form')
                            ->addDefaultsIfNotSet()
                                ->children()
                                    ->scalarNode('type')->defaultValue('neutron_backend_contact')->end()
                                    ->scalarNode('handler')->defaultValue('neutron_contact.form.backend.handler.contact.default')->end()
                                    ->scalarNode('name')->defaultValue('neutron_backend_contact')->end()
                                ->end()
                            ->end()
                            ->arrayNode('templates')
                                ->useAttributeAsKey('name')
                                    ->prototype('scalar')
                                ->end() 
                                ->cannotBeOverwritten()
                                ->isRequired()
                                ->cannotBeEmpty()
                            ->end()
                        ->end()
                    ->end()
                ->end()
            ->end()
        ;
    }
    
    private function addWidgetContactFormConfigurations(ArrayNodeDefinition $node)
    {
        $node
            ->children()
                 ->arrayNode('widget_contact_form')
                    ->addDefaultsIfNotSet()
                        ->children()
                            ->booleanNode('enable')->defaultFalse()->end()
                            ->scalarNode('class')->isRequired()->cannotBeEmpty()->end()
                            ->scalarNode('controller_backend')->defaultValue('neutron_contact.controller.backend.contact_form.default')->end()
                            ->scalarNode('controller_frontend')->defaultValue('neutron_contact.controller.frontend.contact_form.default')->end()
                            ->scalarNode('manager')->defaultValue('neutron_contact.doctrine.contact_form_manager.default')->end()
                            ->scalarNode('datagrid')->defaultValue('neutron_contact_form_management')->end()
                            ->arrayNode('form')
                            ->addDefaultsIfNotSet()
                                ->children()
                                    ->scalarNode('type')->defaultValue('neutron_backend_contact_form')->end()
                                    ->scalarNode('handler')->defaultValue('neutron_contact.form.backend.handler.contact_form.default')->end()
                                    ->scalarNode('name')->defaultValue('neutron_backend_contact_form')->end()
                                ->end()
                            ->end()
                            ->arrayNode('form_choices')
                                ->useAttributeAsKey('name')
                                    ->prototype('scalar')
                                ->end() 
                                ->cannotBeOverwritten()
                                ->isRequired()
                                ->cannotBeEmpty()
                            ->end()
                            ->arrayNode('templates')
                                ->useAttributeAsKey('name')
                                    ->prototype('scalar')
                                ->end() 
                                ->cannotBeOverwritten()
                                ->isRequired()
                                ->cannotBeEmpty()
                            ->end()
                        ->end()
                    ->end()
                ->end()
            ->end()
        ;
    }
    


}
