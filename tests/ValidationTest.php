<?php

use CerfaReceiptsGen\Controller\Cerfa;
use CerfaReceiptsGen\Controller\Config;
use CerfaReceiptsGen\Controller\Logger;
use mikehaertl\pdftk\Pdf;
use PHPUnit\Framework\TestCase;

class ValidationTest extends TestCase {
    private static array $testData;
    private static string $tmpPath;

    public static function setUpBeforeClass(): void {
        $content = file_get_contents(__DIR__ . '/json/cerfa.test.json');
        self::$testData = json_decode($content, true)['validate'];

        $tmpDirectoryPath = __DIR__ . '/tmp';
        if (!file_exists($tmpDirectoryPath)) mkdir($tmpDirectoryPath, 0777, true);
        self::$tmpPath = $tmpDirectoryPath;
    }

    public static function tearDownAfterClass(): void {
        $files = glob(self::$tmpPath . '/*');
        foreach ($files as $file) unlink($file);
    }

    public function testValidation(): void {
        $cerfa = new Cerfa(json_encode(self::$testData));
        $cerfa->generate();
    }
}