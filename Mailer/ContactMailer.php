<?php
namespace Neutron\Plugin\ContactBundle\Mailer;

use Neutron\Plugin\ContactBundle\Model\ContactFormInterface;

use Symfony\Component\DependencyInjection\ContainerAware;

class ContactMailer extends ContainerAware implements ContactMailerInterface
{

    public function sendMessage(ContactFormInterface $entity, array $context)
    {
        $template = $this->container->get('twig')->loadTemplate($entity->getMailTemplate());
        $subject = $entity->getMailSubject();
        $htmlBody = $template->renderBlock('body_html', $context);
    
        $message = \Swift_Message::newInstance()
            ->setSubject($entity->getMailSubject())
            ->setFrom($context['email'], $context['name'])
            ->setTo($entity->getRecipients())
            ->setBody($htmlBody, 'text/html')
        ;
    
        $this->container->get('mailer')->send($message);
    }
}