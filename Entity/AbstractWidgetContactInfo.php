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

use Neutron\Bundle\FormBundle\Model\MultiSelectSortableReferenceInterface;

use Doctrine\Common\Collections\ArrayCollection;

use Neutron\Plugin\ContactBundle\Model\WidgetContactInfoInterface;

use Gedmo\Mapping\Annotation as Gedmo;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\MappedSuperclass
 * 
 */
class AbstractWidgetContactInfo implements WidgetContactInfoInterface
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
     * @Gedmo\Translatable
     * @ORM\Column(type="string", name="title", length=255, nullable=true, unique=false)
     */
    protected $title;
    
    /**
     * @var string
     *
     * @ORM\Column(type="string", name="template", length=255, nullable=true, unique=false)
     */
    protected $template;
    
    /**
     * @ORM\OneToMany(targetEntity="Neutron\Plugin\ContactBundle\Model\ContactInfoReferenceInterface", mappedBy="widget", cascade={"persist", "remove"})
     * @ORM\OrderBy({"position" = "ASC"})
     */
    protected $references;
    
    /**
     * @var boolean 
     *
     * @ORM\Column(type="boolean", name="enabled")
     */
    protected $enabled = true;
    
    /**
     * @Gedmo\Locale
     * Used locale to override Translation listener`s locale
     * this is not a mapped field of entity metadata, just a simple property
     */
    protected $locale;
    
    public function __construct()
    {
        $this->references = new ArrayCollection();
    }
    
    public function getId ()
    {
        return $this->id;
    }
    
    public function getTitle ()
    {
        return $this->title;
    }
    
    public function setTitle ($title)
    {
        $this->title = $title;
    }
    
    public function setTemplate($template)
    {
        $this->template = $template;
    }
    
    public function getTemplate()
    {
        return $this->template;
    }
    
    public function setTranslatableLocale($locale)
    {
        $this->locale = $locale;
    }
    
    public function getReferences()
    {
        return $this->references;
    }
    
    public function addReference(MultiSelectSortableReferenceInterface $reference)
    {
        if (!$this->references->contains($reference)){
            $this->references->add($reference);
            $reference->setWidget($this);
        }
    
        return $this;
    }
    
    public function removeReference(MultiSelectSortableReferenceInterface $reference)
    {
        if ($this->references->contains($reference)){
            $this->references->removeElement($reference);
        }
    
        return $this;
    }
    
    public function setEnabled($enabled)
    {
        $this->enabled = $enabled;
    }
    
    public function getEnabled()
    {
        return $this->enabled;
    }

}
