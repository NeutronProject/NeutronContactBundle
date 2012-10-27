<?php
/*
 * This file is part of NeutronContactBundle
 *
 * (c) Zender <azazen09@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */
namespace Neutron\Plugin\ContactBundle\Entity\Repository;

use Gedmo\Translatable\Entity\Repository\TranslationRepository;

class ContactBlockRepository extends TranslationRepository
{
    public function getQueryBuilderForContactBlockManagementDataGrid()
    {
        $qb = $this->createQueryBuilder('b');
        $qb->select('b.id, b.title, b.phone, b.email, b.city, b.enabled');
        
        return $qb;
    }
    
    public function getQueryBuilderForContactBlockMultiSelectSortableDataGrid()
    {
        $qb = $this->createQueryBuilder('b');
        $qb->select('b.id, b.title, b.enabled');
        
        return $qb;
    }
}