<?php
declare(strict_types=1);

namespace Utils;

class DatabaseTableMapping
{
    public const OPPORTUNITY = 'opportunity';
    private const LS_OPPORTUNITY = 'opportunity';

    public const CONTACT = 'contact';
    private const LS_CONTACT = 'contact';

    public const VEHICLE_REGISTRY_ITEM = 'vehicle_registry_item';
    private const LS_VEHICLE_REGISTRY_ITEM = 'vehicle_registry_item';

    public static function getName(string $name)
    {
        switch ($name){
            case self::OPPORTUNITY: return self::LS_OPPORTUNITY;
            case self::CONTACT: return self::LS_CONTACT;
            case self::VEHICLE_REGISTRY_ITEM: return self::LS_VEHICLE_REGISTRY_ITEM;
        }
    }
}
