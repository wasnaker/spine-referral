<?php

declare(strict_types=1);

/**
 * MANIFEST modul Referral — kode referral + relasi + aturan komisi.
 *
 * @return array{menu: list<array{slug: string, label: string, icon: string, href: string, position: int, permission?: string}>, widgets: list<array{id: string, area: string, title: string, api: string}>, detail_tabs: list<array{slug: string, label: string, icon: string, api: string, position: int, permission?: string}>, rbac: array{permissions: list<string>, roles: list<array{name: string, label?: string, permissions: list<string>}>, grants: array<string, list<string>>}}
 */
return [
    'menu' => [
        [
            'slug'       => 'referrals',
            'label'      => 'Referrals',
            'icon'       => '🔗',
            'href'       => '/referrals',
            'position'   => 45,
            'permission' => 'referral:view',
        ],
    ],

    'widgets' => [],

    'detail_tabs' => [
        [
            'slug'       => 'overview',
            'label'      => 'Overview',
            'icon'       => '👁️',
            'api'        => '',
            'position'   => 10,
            'permission' => 'referral:view',
        ],
        [
            'slug'       => 'referrals',
            'label'      => 'Referrals',
            'icon'       => '👥',
            'api'        => '/api/v1/referrals',
            'position'   => 20,
            'permission' => 'referral:view',
        ],
    ],

    'rbac' => [
        'permissions' => [
            'referral:view',
            'referral:manage',
        ],
        'roles' => [
            ['name' => 'referral-admin', 'label' => 'Referral Admin',
             'permissions' => ['referral:*']],
        ],
        'grants' => [
            'staff' => ['referral:view'],
        ],
    ],
];