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


use Neutron\Widget\ContactBlockBundle\Model\WidgetContactBlockAwareInterface;

use Neutron\Widget\ContactBlockBundle\Model\WidgetContactBlockInterface;

use Neutron\SeoBundle\Model\SeoAwareInterface;

use Neutron\MvcBundle\Model\CategoryAwareInterface;

use Neutron\MvcBundle\Model\Category\CategoryInterface;

use Neutron\SeoBundle\Model\SeoInterface;

use Neutron\Plugin\ContactBundle\Model\ContactFormInterface;

use Neutron\Plugin\ContactBundle\Model\ContactInterface;

use Gedmo\Mapping\Annotation as Gedmo;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\MappedSuperclass
 * 
 */
class AbstractContact implements ContactInterface, CategoryAwareInterface, 
    SeoAwareInterface, WidgetContactBlockAwareInterface
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
     * @Gedmo\Translatable
     * @ORM\Column(type="text", name="content", nullable=true)
     */
    protected $content;

    /**
     * @var string 
     *
     * @ORM\Column(type="string", name="template", length=255, nullable=true, unique=false)
     */
    protected $template;
    
    /**
     * @ORM\ManyToOne(targetEntity="Neutron\Plugin\ContactBundle\Model\ContactFormInterface", fetch="EAGER")
     * @ORM\JoinColumn(onDelete="SET NULL")
     */
    protected $contactForm;
    
    /**
     * @ORM\ManyToOne(targetEntity="Neutron\Widget\ContactBlockBundle\Model\WidgetContactBlockInterface", fetch="EAGER")
     * @ORM\JoinColumn(onDelete="SET NULL")
     */
    protected $widgetContactBlock;
    
    
    /**
     * @Gedmo\Locale
     * Used locale to override Translation listener`s locale
     * this is not a mapped field of entity metadata, just a simple property
     */
    protected $locale;
    
    /**
     * @ORM\OneToOne(targetEntity="Neutron\MvcBundle\Model\Category\CategoryInterface", cascade={"all"}, orphanRemoval=true)
     * @ORM\JoinColumn(onDelete="CASCADE")
     */
    protected $category;
    
    /**
     * @ORM\OneToOne(targetEntity="Neutron\SeoBundle\Entity\Seo", cascade={"all"}, orphanRemoval=true, fetch="EAGER")
     * @ORM\JoinColumn(onDelete="CASCADE")
     */
    protected $seo;
  

    public function getId()
    {
        return $this->id;
    }

    public function getTitle()
    {
        return $this->title;
    }

    public function setTitle($title)
    {
        $this->title = $title;
    }

    public function getContent()
    {
        return $this->content;
    }

    public function setContent($content)
    {
        $this->content = $content;
    }

    public function getTemplate()
    {
        return $this->template;
    }

    public function setTemplate($template)
    {
        $this->template = $template;
    }

    public function getContactForm()
    {
        return $this->contactForm;
    }

    public function setContactForm(ContactFormInterface $contactForm = null)
    {
        $this->contactForm = $contactForm;
    }
    
    public function setWidgetContactBlock(WidgetContactBlockInterface $widgetContactBlock)
    {
        $this->widgetContactBlock = $widgetContactBlock;
    }
    
    public function getWidgetContactBlock()
    {
        return $this->widgetContactBlock;
    }
    
    public function setCategory(CategoryInterface $category)
    {
        $this->category = $category;
        return $this;
    }
    
    public function getCategory()
    {
        return $this->category;
    }
    
    public function setSeo(SeoInterface $seo)
    {
        $this->seo = $seo;
        return $this;
    }
    
    public function getSeo()
    {
        return $this->seo;
    }
    
    public function setTranslatableLocale($locale)
    {
        $this->locale = $locale;
    }

}
