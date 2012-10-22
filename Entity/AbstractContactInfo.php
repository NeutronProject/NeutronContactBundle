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

use Neutron\Plugin\ContactBundle\Model\ContactInfoInterface;

use Gedmo\Mapping\Annotation as Gedmo;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\MappedSuperclass
 * 
 */
class AbstractContactInfo implements ContactInfoInterface
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
     * @ORM\Column(type="string", name="name", length=50, nullable=false, unique=true)
     */
    protected $name;
    
    /**
     * @var string 
     *
     * @ORM\Column(type="string", name="phone", length=50, nullable=true, unique=false)
     */
    protected $phone;
    
    /**
     * @var string 
     *
     * @ORM\Column(type="string", name="fax", length=50, nullable=true, unique=false)
     */
    protected $fax;
    
    /**
     * @var string 
     *
     * @ORM\Column(type="string", name="email", length=100, nullable=true, unique=false)
     */
    protected $email;
    
    /**
     * @var string 
     *
     * @ORM\Column(type="string", name="address", length=255, nullable=true, unique=false)
     */
    protected $address;
    
    /**
     * @var string 
     *
     * @ORM\Column(type="string", name="post_code", length=50, nullable=true, unique=false)
     */
    protected $postCode;
    
    /**
     * @var string 
     *
     * @ORM\Column(type="string", name="city", length=100, nullable=true, unique=false)
     */
    protected $city;
    
    /**
     * @var string 
     *
     * @ORM\Column(type="string", name="country", length=50, nullable=true, unique=false)
     */
    protected $country;
    
    /**
     * @var boolean 
     *
     * @ORM\Column(type="boolean", name="enabled")
     */
    protected $enabled = false;
    
    /**
     * @Gedmo\Locale
     * Used locale to override Translation listener`s locale
     * this is not a mapped field of entity metadata, just a simple property
     */
    protected $locale;
    
    public function getId ()
    {
        return $this->id;
    }
    
    public function setName($name)
    {
        $this->name = $name;
    }
    
    public function getName()
    {
        return $this->name;
    }

	public function getPhone ()
    {
        return $this->phone;
    }

	public function setPhone ($phone)
    {
        $this->phone = $phone;
    }

	public function getFax ()
    {
        return $this->fax;
    }

	public function setFax ($fax)
    {
        $this->fax = $fax;
    }

	public function getEmail ()
    {
        return $this->email;
    }

	public function setEmail ($email)
    {
        $this->email = $email;
    }

	public function getAddress ()
    {
        return $this->address;
    }

	public function setAddress ($address)
    {
        $this->address = $address;
    }

	public function getPostCode ()
    {
        return $this->postCode;
    }

	public function setPostCode ($postCode)
    {
        $this->postCode = $postCode;
    }

	public function getCity ()
    {
        return $this->city;
    }

	public function setCity ($city)
    {
        $this->city = $city;
    }

	public function getCountry ()
    {
        return $this->country;
    }

	public function setCountry ($country)
    {
        $this->country = $country;
    }
    
    public function setEnabled($enabled)
    {
        $this->enabled = $enabled;
    }
    
    public function getEnabled()
    {
        return $this->enabled;
    }

	public function setTranslatableLocale($locale)
    {
        $this->locale = $locale;
    }

}
