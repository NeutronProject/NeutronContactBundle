<?php
namespace Neutron\Plugin\ContactBundle\DependencyInjection\Compiler;

use Symfony\Component\DependencyInjection\ContainerBuilder;

use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;


class DependencyCheckPass implements CompilerPassInterface
{

    /**
     * (non-PHPdoc)
     * @see Symfony\Component\DependencyInjection\Compiler.CompilerPassInterface::process()
     */
    public function process(ContainerBuilder $container)
    {  
        if (!$container->hasDefinition('neutron_contact_form.widget')) {
            throw new \RuntimeException('NeutronContactFormBundle is not installed.');
        }
        
        if (!$container->hasDefinition('neutron_contact_block.widget')) {
            throw new \RuntimeException('NeutronContactBlockBundle is not installed.');
        }
    }
}
