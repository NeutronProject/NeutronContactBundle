<?php

namespace Neutron\Plugin\ContactBundle\DependencyInjection;

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

        return $treeBuilder;
    }
    
    private function addGeneralConfigurations(ArrayNodeDefinition $node)
    {
        $node
            ->addDefaultsIfNotSet()
            ->children()
                ->booleanNode('enable')->defaultFalse()->end()
                ->scalarNode('contact_class')->isRequired()->cannotBeEmpty()->end()
                ->scalarNode('contact_form_class')->isRequired()->cannotBeEmpty()->end()
                ->scalarNode('contact_controller_backend')->defaultValue('neutron_contact.controller.backend.contact.default')->end()
                ->scalarNode('contact_controller_frontend')->defaultValue('neutron_contact.controller.frontend.contact.default')->end()
                ->scalarNode('contact_form_controller_backend')->defaultValue('neutron_contact.controller.backend.contact_form.default')->end()
                ->scalarNode('contact_manager')->defaultValue('neutron_contact.doctrine.contact_manager.default')->end()
                ->scalarNode('contact_form_manager')->defaultValue('neutron_contact.doctrine.contact_form_manager.default')->end()
                ->scalarNode('translation_domain')->defaultValue('NeutronContactBundle')->end()
            ->end()
        ;
    }
    
    private function addFormConfigurations(ArrayNodeDefinition $node)
    {
        $node
            ->children()
                 ->arrayNode('form')
                    ->addDefaultsIfNotSet()
                        ->children()
                            ->scalarNode('type')->defaultValue('neutron_contact')->end()
                            ->scalarNode('handler')->defaultValue('neutron_contact.form.handler.contact.default')->end()
                            ->scalarNode('name')->defaultValue('neutron_contact')->end()
                        ->end()
                    ->end()
                ->end()
            ->end()
        ;
    }
    
    private function addContactFormConfigurations(ArrayNodeDefinition $node)
    {
        $node
            ->children()
                 ->arrayNode('contact_form')
                    ->addDefaultsIfNotSet()
                        ->children()
                            ->scalarNode('type')->defaultValue('neutron_contact_form')->end()
                            ->scalarNode('handler')->defaultValue('neutron_contact.form.handler.contact_form.default')->end()
                            ->scalarNode('name')->defaultValue('neutron_contact_form')->end()
                        ->end()
                    ->end()
                ->end()
            ->end()
        ;
    }
    
    private function addContactTemplatesConfigurations(ArrayNodeDefinition $node)
    {
        $node
            ->children()
                ->arrayNode('contact_templates')->isRequired()
                ->validate()
                    ->ifTrue(function($v){return empty($v);})
                    ->thenInvalid('You should provide at least one template.')
                ->end()
                ->useAttributeAsKey('name')
                    ->prototype('scalar')
                ->end() 
                ->cannotBeOverwritten()
                ->isRequired()
                ->cannotBeEmpty()
            ->end()
        ;
    }
    
    private function addContactFormTemplatesConfigurations(ArrayNodeDefinition $node)
    {
        $node
            ->children()
                ->arrayNode('contact_form_templates')->isRequired()
                ->validate()
                    ->ifTrue(function($v){return empty($v);})
                    ->thenInvalid('You should provide at least one template.')
                ->end()
                ->useAttributeAsKey('name')
                    ->prototype('scalar')
                ->end() 
                ->cannotBeOverwritten()
                ->isRequired()
                ->cannotBeEmpty()
            ->end()
        ;
    }
}
