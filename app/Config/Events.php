<?php

namespace Config;

use CodeIgniter\Events\Events;
use CodeIgniter\Exceptions\FrameworkException;
use CodeIgniter\HotReloader\HotReloader;

/*
 * --------------------------------------------------------------------
 * Application Events
 * --------------------------------------------------------------------
 * Events allow you to tap into the execution of the program without
 * modifying or extending core files. This file provides a central
 * location to define your events, though they can always be added
 * at run-time, also, if needed.
 *
 * You create code that can execute by subscribing to events with
 * the 'on()' method. This accepts any form of callable, including
 * Closures, that will be executed when the event is triggered.
 *
 * Example:
 *      Events::on('create', [$myInstance, 'myMethod']);
 */

Events::on('pre_system', static function (): void {
    if (ENVIRONMENT !== 'testing') {
        if (ini_get('zlib.output_compression')) {
            throw FrameworkException::forEnabledZlibOutputCompression();
        }

        while (ob_get_level() > 0) {
            ob_end_flush();
        }

        ob_start(static fn ($buffer) => $buffer);
    }

    /*
     * --------------------------------------------------------------------
     * Debug Toolbar Listeners.
     * --------------------------------------------------------------------
     * If you delete, they will no longer be collected.
     */
    if (CI_DEBUG && ! is_cli()) {
        Events::on('DBQuery', 'CodeIgniter\Debug\Toolbar\Collectors\Database::collect');
        service('toolbar')->respond();
        // Hot Reload route - for framework use on the hot reloader.
        if (ENVIRONMENT === 'development') {
            service('routes')->get('__hot-reload', static function (): void {
                (new HotReloader())->run();
            });
        }
    }
});

/*
 * --------------------------------------------------------------------
 * Auto Database Backup on Write Operations
 * --------------------------------------------------------------------
 * Trigger backup setiap kali ada HTTP POST/PUT/DELETE request.
 * Script berjalan di background (non-blocking) agar tidak
 * memperlambat response ke user.
 * Backup lama otomatis dihapus oleh script backup_db.sh.
 */
Events::on('post_system', static function (): void {
    // Hanya trigger pada request yang mengubah data (bukan GET/HEAD)
    $method = strtoupper($_SERVER['REQUEST_METHOD'] ?? 'GET');
    if (! in_array($method, ['POST', 'PUT', 'PATCH', 'DELETE'], true)) {
        return;
    }

    // Abaikan AJAX read-only endpoints yang tidak mengubah data
    $uri = $_SERVER['REQUEST_URI'] ?? '';
    $readOnlyPatterns = [
        '/getGajiUraian',
        '/penugasan-badge',
        '/ajax_detail_pensiun',
        '/login_load',  // login bukan perubahan data DB utama
    ];
    foreach ($readOnlyPatterns as $pattern) {
        if (str_contains($uri, $pattern)) {
            return;
        }
    }

    $script = ROOTPATH . 'scripts/backup_db.sh';
    if (! is_file($script)) {
        return;
    }

    // Jalankan di background — exec() dengan redirect output agar non-blocking
    if (function_exists('exec')) {
        exec('bash ' . escapeshellarg($script) . ' > /dev/null 2>&1 &');
    }
});