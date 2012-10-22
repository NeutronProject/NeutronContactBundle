<?php
namespace Neutron\Plugin\ContactBundle\Mailer;

use Neutron\Plugin\ContactBundle\Model\ContactFormInterface;

interface ContactMailerInterface
{
    public function sendMessage(ContactFormInterface $entity, array $context);
}