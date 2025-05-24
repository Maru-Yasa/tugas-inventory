<?php

namespace Maru\Inventory\Data;

class SidebarData
{
    public static function data(): array
    {
        return [
            [
                'type' => 'item',
                'icon' => 'fa-tachometer-alt',
                'label' => 'Dashboard',
                'link' => '/'
            ],
            [
                'type' => 'item',
                'icon' => 'fa-cart-shopping',
                'label' => 'POS',
                'link' => '/pos'
            ],
            [
                'type' => 'label',
                'label' => 'Master Data'
            ],
            [
                'type' => 'item',
                'icon' => 'fa-tachometer-alt',
                'label' => 'Inventory',
                'link' => '/inventory'
            ],
        ];
    }
}
