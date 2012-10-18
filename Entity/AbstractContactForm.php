<?php
/*
 * This file is part of NeutronContactBundle
 *
 * (c) Zender <azazen09@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */
namespace Neutron\Plugin\ContactBundle\Entity;

use Neutron\Plugin\ContactBundle\Model\ContactFormInterface;

use Gedmo\Mapping\Annotation as Gedmo;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\MappedSuperclass
 * 
 */
class AbstractContactForm implements ContactFormInterface
{
    /**
     * @var integer 
     *
     * @ORM\Id @ORM\Column(name="id", type="integer")
     * 
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @var string 
     *
     * @ORM\Column(type="string", name="name", length=255, nullable=true, unique=false)
     */
    protected $name;
    
    /**
     * @var string 
     *
     * @ORM\Column(type="string", name="column_name", length=255, nullable=true, unique=false)
     */
    protected $mailSubject;
    
    /**
     * @var string 
     *
     * @ORM\Column(type="string", name="mail_template", length=255, nullable=true, unique=false)
     */
    protected $mailTemplate;
    
    /**
     * @var string 
     *
     * @ORM\Column(type="text", name="recipients", nullable=true)
     */
    protected $recipients;
    
    /**
     * @var string 
     *
     * @ORM\Column(type="string", name="form", length=255, nullable=true, unique=false)
     */
    protected $form;
    
    /**
     * @var boolean 
     *
     * @ORM\Column(type="boolean", name="enabled")
     */
    protected $enabled = false;
    
    public function getId ()
    {
        return $this->id;
    }
    
	public function getName ()
    {
        return $this->name;
    }

	public function setName ($name)
    {
        $this->name = $name;
    }

	public function getMailSubject ()
    {
        return $this->mailSubject;
    }

	public function setMailSubject ($mailSubject)
    {
        $this->mailSubject = $mailSubject;
    }

	public function getMailTemplate ()
    {
        return $this->mailTemplate;
    }

	public function setMailTemplate ($mailTemplate)
    {
        $this->mailTemplate = $mailTemplate;
    }

	public function getRecipients ()
    {
        return $this->recipients;
    }

	public function setRecipients ($recipients)
    {
        $this->recipients = $recipients;
    }

	public function getForm ()
    {
        return $this->form;
    }

	public function setForm ($form)
    {
        $this->form = $form;
    }

	public function getEnabled ()
    {
        return $this->enabled;
    }

	public function setEnabled ($enabled)
    {
        $this->enabled = $enabled;
    }

}
