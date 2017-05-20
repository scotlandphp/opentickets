<?php

declare(strict_types=1);

return [
    'view_manager' => [
        'template_map' => [
            'layout/layout' => __DIR__ . '/../view/layout/layout.phtml',
            'error/404' => __DIR__ . '/../view/error/404.phtml',
            'error/index' => __DIR__ . '/../view/error/index.phtml',
            'tickets/ticket/select-tickets' => __DIR__ . '/../view/tickets/ticket/select-tickets.phtml',
            'tickets/ticket/complete' => __DIR__ . '/../view/tickets/ticket/complete.phtml',
            'tickets/ticket/manage' => __DIR__ . '/../view/tickets/ticket/manage.phtml',
            'tickets/ticket/purchase' => __DIR__ . '/../view/tickets/ticket/purchase.phtml',
        ],
    ],
];
