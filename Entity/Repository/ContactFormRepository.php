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

class ContactFormRepository extends TranslationRepository
{
    public function getQueryBuilderForContactFormManagementDataGrid()
    {
        return $this->createQueryBuilder('f');
    }
}