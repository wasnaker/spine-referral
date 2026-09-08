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

    'profile_tabs' => [
        [
            'slug'       => 'my-referral',
            'label'      => 'My Referral',
            'icon'       => '🔗',
            'href'       => '/profile/my-referral',
            'position'   => 60,
            'permission' => 'referral:view',
        ],
    ],

    'settings' => [
        [
            'slug'     => 'referral',
            'label'    => 'Referral',
            'icon'     => '🔗',
            'position' => 50,
            'fields'   => [
                [
                    'key'     => 'referral_start_number',
                    'label'   => 'Start Number',
                    'type'    => 'number',
                    'default' => '90104',
                ],
                [
                    'key'     => 'referral_code_length',
                    'label'   => 'Code Length',
                    'type'    => 'number',
                    'default' => '4',
                ],
                [
                    'key'     => 'referral_user_start_number',
                    'label'   => 'User Start Number',
                    'type'    => 'number',
                    'default' => '44444',
                ],
                [
                    'key'     => 'referral_commission_percent',
                    'label'   => 'Komisi Default (%)',
                    'type'    => 'number',
                    'default' => '10',
                ],
                [
                    'key'     => 'referral_commission_fixed',
                    'label'   => 'Komisi Flat (Rp)',
                    'type'    => 'number',
                    'default' => '25000',
                ],
                [
                    'key'     => 'referral_hold_days',
                    'label'   => 'Hold Period (hari)',
                    'type'    => 'number',
                    'default' => '7',
                ],
                [
                    'key'     => 'referral_min_withdrawal',
                    'label'   => 'Minimal Pencairan (Rp)',
                    'type'    => 'number',
                    'default' => '50000',
                ],
                [
                    'key'     => 'referral_commission_type',
                    'label'   => 'Tipe Komisi Default',
                    'type'    => 'select',
                    'options' => [
                        ['value' => 'percentage', 'label' => 'Persentase'],
                        ['value' => 'fixed',      'label' => 'Nominal Tetap'],
                    ],
                    'default' => 'percentage',
                ],
            ],
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
            'staff'            => ['referral:view'],
            'customer'         => ['referral:view'],
            'surveyor'         => ['referral:view'],
            'association'      => ['referral:view'],
            'agency'           => ['referral:view'],
            'referral-admin'   => ['referral:view'],
            'platform-admin'   => ['referral:view'],
        ],
    ],
];