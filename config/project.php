<?php

$prefixName = 'admin.';

return [
    'route_uri' => [
        'management' => [
            $prefixName.'customers.view',
            $prefixName.'projects-management.index',
            $prefixName.'products.index',
            $prefixName.'deployment_schedule.index',
            $prefixName.'contract.view',
            $prefixName.'products.index',
            $prefixName.'deployment_schedule.index',
            $prefixName.'quote.view',
        ],
        'user' => [
            $prefixName.'users.index',
            $prefixName.'roles.index',
        ],
        'declare' => [
            $prefixName.'statuses.view',
            $prefixName.'contract_type.view',
            $prefixName.'departments.index',
            $prefixName.'project_types.index',
            $prefixName.'banks.index',
            $prefixName.'units.index',
            $prefixName.'tax-fee-rates.index',
            $prefixName.'product_group.view',
            $prefixName.'eployment-records.index',
            $prefixName.'acceptance-records.index',
            $prefixName.'dispatches.index',
        ],
        'report' => [
            $prefixName.'reports.customers.index',
            $prefixName.'reports.projects.index',
            $prefixName.'reports.contracts.index',
            $prefixName.'reports.dispatches.index',
            $prefixName.'reports.payment-details.index',
            $prefixName.'reports.acceptance-records.index',
            $prefixName.'reports.deployment-records.index',
            $prefixName.'reports.payment-detail-projects.index',

        ]
    ]
];
