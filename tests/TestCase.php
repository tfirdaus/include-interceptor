<?php
/**
 * Copyright (c) 2015 Robin Appelman <icewind@owncloud.com>
 * This file is licensed under the Licensed under the MIT license:
 * http://opensource.org/licenses/MIT
 */

namespace Nikic\IncludeInterceptor\Tests;

abstract class TestCase extends \PHPUnit\Framework\TestCase {
    private $tmpFiles = [];

    public function tearDown(): void {
        parent::tearDown();
        foreach ($this->tmpFiles as $file) {
            if (is_file($file)) {
                unlink($file);
            }
        }
    }

    protected function tempNam($postFix = '') {
        $id = uniqid();
        $file = tempnam(sys_get_temp_dir(), $id . $postFix);
        $tmpFiles[] = $file;
        return $file;
    }

    /**
     * @param resource $stream
     * @return callable
     */
    protected function loadCode($stream) {
        $file = $this->tempNam('.php');
        file_put_contents($file, $stream);
        try {
            return include $file;
        } finally {
            unlink($file);
        }
    }
}
