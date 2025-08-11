<?php

    if (!function_exists('getRoleNameById')) {
        function getRoleNameById($roleId)
        {
            $roles = [
                '1' => 'manager',
                '2' => 'teacher',
                '3' => 'DO',
            ];
            return $roles[$roleId] ?? null;
        }
    }