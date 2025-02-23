<?php

declare(strict_types=1);

test('debugs not to be used in the codebase')
    ->expect(['dd', 'dump', 'var_dump'])
    ->not->toBeUsed();

test('application uses strict typing')
    ->expect('App')
    ->toUseStrictTypes();

test('controllers have Controller suffix')
    ->expect('App\Http\Controllers')
    ->toHaveSuffix('Controller');

test('models should not be used directly in controllers')
    ->expect('App\Models')
    ->not->toBeUsedIn('App\Http\Controllers');