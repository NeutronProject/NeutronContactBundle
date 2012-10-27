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

use Neutron\Plugin\ContactBundle\Model\ContactInfoReferenceInterface;

use Neutron\Plugin\ContactBundle\Model\ContactInfoInterface;

use Gedmo\Mapping\Annotation as Gedmo;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\MappedSuperclass
 * 
 */
class AbstractContactInfoReference implements ContactInfoReferenceInterface
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
     * @var integer
     *
     * @ORM\Column(type="integer", name="position", length=10, nullable=false, unique=false)
     */
    protected $position = 0;
    
    /**
     * @ORM\ManyToOne(targetEntity="Neutron\Plugin\ContactBundle\Model\WidgetContactInfoInterface", inversedBy="references")
     * @ORM\JoinColumn(onDelete="CASCADE")
     */
    protected $widget;
    
    /**
     * @ORM\ManyToOne(targetEntity="Neutron\Plugin\ContactBundle\Model\ContactInfoInterface",  fetch="EAGER")
     * @ORM\JoinColumn(onDelete="CASCADE")
     */
    protected $inversed;
    
    public function getId()
    {
        return $this->id;
    }
    
    public function getLabel()
    {
        return $this->inversed->getTitle();
    }
    
    public function setPosition($position)
    {
        $this->position = $position;
    }
    
    public function getPosition()
    {
        return $this->position;
    }
    
    public function getWidget ()
    {
        return $this->widget;
    }
    
    public function setWidget ($widget)
    {
        $this->widget = $widget;
    }
    
    public function getInversed ()
    {
        return $this->inversed;
    }
    
    public function setInversed ($inversed)
    {
        if (!$inversed instanceof ContactInfoInterface){
            throw new \InvalidArgumentException('Reference must be instance of ContactInfoInterface');
        }
    
        $this->inversed = $inversed;
    }
}
