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

test('facades should not be used in the services', function () {
    $servicesPath = dirname(__DIR__, 2).'/app/Services';

    if (! is_dir($servicesPath)) {
        $this->markTestSkipped('No Services directory found.');
    }

    foreach (scandir($servicesPath) as $file) {
        if (str_ends_with($file, '.php')) {
            $content = file_get_contents($servicesPath.'/'.$file);
            expect($content)->not->toContain('Illuminate\Support\Facades');
        }
    }
});
