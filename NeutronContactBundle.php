<?php

namespace Neutron\Plugin\ContactBundle;

use Neutron\Plugin\ContactBundle\DependencyInjection\Compiler\DependencyCheckPass;

use Symfony\Component\DependencyInjection\ContainerBuilder;

use Symfony\Component\HttpKernel\Bundle\Bundle;

class NeutronContactBundle extends Bundle
{
    public function build(ContainerBuilder $container)
    {
        parent::build($container);
        $container->addCompilerPass(new DependencyCheckPass());
    }
}
