<?php

namespace AppBundle\Event;

use Doctrine\ORM\Event\LoadClassMetadataEventArgs;
use Doctrine\ORM\Mapping\ClassMetadata;
// https://symfony.com/doc/current/doctrine/event_listeners_subscribers.html
class TablePrefixSubscriber
{
    protected $prefix = '';

    public function __construct($prefix)
    {
        $this->prefix = (string)$prefix."_";
    }

    public function loadClassMetadata(LoadClassMetadataEventArgs $args)
    {
        /**
         * @var $classMetadata ClassMetadata
         */
        $classMetadata = $args->getClassMetadata();
        if ($classMetadata->isInheritanceTypeSingleTable() && !$classMetadata->isRootEntity()) {
            // if we are in an inheritance hierarchy, only apply this once
            return;
        }

        $classMetadata->setTableName($this->prefix . $classMetadata->getTableName());

        foreach ($classMetadata->getAssociationMappings() as $fieldName => $mapping) {
            if ($mapping['type'] == \Doctrine\ORM\Mapping\ClassMetadataInfo::MANY_TO_MANY
                && array_key_exists('name', $classMetadata->associationMappings[$fieldName]['joinTable']) ) {     // Check if "joinTable" exists, it can be null if this field is the reverse side of a ManyToMany relationship
                $mappedTableName = $classMetadata->associationMappings[$fieldName]['joinTable']['name'];
                $classMetadata->associationMappings[$fieldName]['joinTable']['name'] = $this->prefix . $mappedTableName;
            }
        }
    }
}