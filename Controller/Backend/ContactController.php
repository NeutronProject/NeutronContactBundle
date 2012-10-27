<?php
namespace Neutron\Plugin\ContactBundle\Controller\Backend;

use Neutron\Plugin\ContactBundle\Model\WidgetContactInfoAwareInterface;

use Neutron\Plugin\ContactBundle\Model\WidgetContactInfoInterface;

use Neutron\SeoBundle\Model\SeoAwareInterface;

use Neutron\MvcBundle\Model\Category\CategoryInterface;

use Neutron\SeoBundle\Model\SeoInterface;

use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

use Symfony\Component\Security\Acl\Domain\ObjectIdentity;

use Neutron\Plugin\ContactBundle\Model\ContactInterface;

use Symfony\Component\HttpFoundation\RedirectResponse;

use Symfony\Component\HttpFoundation\Response;

use Symfony\Component\DependencyInjection\ContainerAware;

class ContactController extends ContainerAware
{
    public function updateAction($id)
    {
        $form = $this->container->get('neutron_contact.form.backend.contact');
        $handler = $this->container->get('neutron_contact.form.backend.handler.contact');
        $form->setData($this->getData($id));
    
        if (null !== $handler->process()){
            return new Response(json_encode($handler->getResult()));
        }
    
        $template = $this->container->get('templating')->render(
            'NeutronContactBundle:Backend\Contact:update.html.twig', array(
                'form' => $form->createView(),
                'translationDomain' => $this->container->getParameter('neutron_contact.translation_domain')
            )
        );
    
        return  new Response($template);
    }
    
    public function deleteAction($id)
    {
        $category = $this->getCategory($id);
        $entity = $this->getEntity($category);
    
        if ($this->container->get('request')->getMethod() == 'POST'){
            $this->doDelete($entity);
            $redirectUrl = $this->container->get('router')->generate('neutron_mvc.category.management');
            return new RedirectResponse($redirectUrl);
        }
    
        $template = $this->container->get('templating')->render(
            'NeutronContactBundle:Backend\Contact:delete.html.twig', array(
                'entity' => $entity,
                'translationDomain' => $this->container->getParameter('neutron_contact.translation_domain')
            )
        );
    
        return  new Response($template);
    }
    
    protected function doDelete(ContactInterface $entity)
    {
        $this->container->get('neutron_admin.acl.manager')
            ->deleteObjectPermissions(ObjectIdentity::fromDomainObject($entity->getCategory()));
    
        $this->container->get('neutron_contact.contact_manager')->delete($entity, true);
    }
    
    protected function getCategory($id)
    {
        $treeManager = $this->container->get('neutron_tree.manager.factory')
            ->getManagerForClass($this->container->getParameter('neutron_mvc.category.category_class'));
    
        $category = $treeManager->findNodeBy(array('id' => $id));
    
        if (!$category){
            throw new NotFoundHttpException();
        }
    
        return $category;
    }
    
    protected function getEntity(CategoryInterface $category)
    {
        $manager = $this->container->get('neutron_contact.contact_manager');
        $entity = $manager->findOneBy(array('category' => $category));
    
        if (!$entity){
            throw new NotFoundHttpException();
        }
    
        return $entity;
    }
    
    
    protected function getWidgetContactInfo(WidgetContactInfoAwareInterface $entity)
    {
    
        if(!$entity->getWidgetContactInfo() instanceof WidgetContactInfoInterface){
            $entity->setWidgetContactInfo(
                $this->container->get('neutron_contact.widget_contact_info_manager')->create()
            );
        }
    
        return $entity->getWidgetContactInfo();
    }
    
    protected function getSeo(SeoAwareInterface $entity)
    {
    
        if(!$entity->getSeo() instanceof SeoInterface){
            $entity->setSeo($this->container->get('neutron_seo.manager')->createSeo());
        }
    
        return $entity->getSeo();
    }
    
    protected function getData($id)
    {
        $category = $this->getCategory($id);
        $entity = $this->getEntity($category);
        $seo = $this->getSeo($entity);
    
        return array(
            'general' => $category,
            'content' => $entity,
            'widget_contact_info' => $this->getWidgetContactInfo($entity),
            'seo'     => $seo,
            'acl' => $this->container->get('neutron_admin.acl.manager')
                ->getPermissions(ObjectIdentity::fromDomainObject($category))
        );
    }
}