<?php

$cachedSettings = cache()->get('role_settings', []);

return [
    'client_role_cost' => $cachedSettings['client_role_cost'] ?? env('CLIENT_ROLE_COST', 0),
    'freelancer_role_cost' => $cachedSettings['freelancer_role_cost'] ?? env('FREELANCER_ROLE_COST', 10),
    'vendor_role_cost' => $cachedSettings['vendor_role_cost'] ?? env('VENDOR_ROLE_COST', 15),
    'require_approval_for_roles' => $cachedSettings['require_approval_for_roles'] ?? env('REQUIRE_APPROVAL_FOR_ROLES', false),
    'allow_free_roles' => $cachedSettings['allow_free_roles'] ?? env('ALLOW_FREE_ROLES', true),
];