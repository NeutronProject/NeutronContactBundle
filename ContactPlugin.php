<?php
namespace Neutron\Plugin\ContactBundle;

use Symfony\Component\EventDispatcher\EventDispatcher;

use Neutron\MvcBundle\Plugin\PluginFactoryInterface;

use Symfony\Component\Translation\TranslatorInterface;

use Symfony\Component\Routing\RouterInterface;

use Neutron\MvcBundle\MvcEvents;

use Neutron\MvcBundle\Event\ConfigurePluginEvent;

class ContactPlugin
{
    const IDENTIFIER = 'neutron.plugin.contact';
    
    protected $dispatcher;
    
    protected $factory;
    
    protected $router;
    
    protected $translator;
    
    protected $translationDomain;
    
    public function __construct(EventDispatcher $dispatcher, PluginFactoryInterface $factory, 
            RouterInterface $router, TranslatorInterface $translator, $translationDomain)
    {
        $this->dispatcher = $dispatcher;
        $this->factory = $factory;
        $this->router = $router;
        $this->translator = $translator;
        $this->translationDomain = $translationDomain;
        
    }
    
    public function build()
    {
        $plugin = $this->factory->createPlugin(self::IDENTIFIER);
        $plugin
            ->setLabel($this->translator->trans('plugin.contact.label', array(), $this->translationDomain))
            ->setDescription($this->translator->trans('plugin.contact.description', array(), $this->translationDomain))
            ->setFrontController('neutron_contact.controller.frontend.contact:indexAction')
            ->setUpdateRoute('neutron_contact.backend.contact.update')
            ->setDeleteRoute('neutron_contact.backend.contact.delete')
            ->setManagerServiceId('neutron_contact.contact_manager')
            ->setTreeOptions(array(
                'children_strategy' => 'none',
            ))
        ;
        
        $this->dispatcher->dispatch(
            MvcEvents::onPluginConfigure, 
            new ConfigurePluginEvent($this->factory, $plugin)
        );
        
        return $plugin;
    }
    
}