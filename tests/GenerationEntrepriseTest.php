<?php

use CerfaReceiptsGen\Controller\Config;
use CerfaReceiptsGen\Controller\Generator;
use mikehaertl\pdftk\Pdf;
use PHPUnit\Framework\TestCase;

final class GenerationEntrepriseTest extends TestCase {
    private static array $testData;
    private static string $tmpPath;

    public static function setUpBeforeClass(): void {
        $content = file_get_contents(__DIR__ . '/json/cerfa.test.json');
        self::$testData = json_decode($content, true)['generateEntreprise'];

        $tmpDirectoryPath = __DIR__ . '/tmp';
        if (!file_exists($tmpDirectoryPath)) mkdir($tmpDirectoryPath, 0777, true);
        self::$tmpPath = $tmpDirectoryPath;
    }

    public static function tearDownAfterClass(): void {
        $files = glob(self::$tmpPath . '/*');
        foreach ($files as $file) unlink($file);
    }

    public function testGenerateText(): void {
        $testData = self::$testData['text'];
        foreach ($testData as $key => $value) {
            $templatePath = Config::get('CERFA_ENTREPRISE_PATH');
            $data = [$key => $value];
            
            $expectedPdf = new Pdf($templatePath);
            $expectedTmpPath = self::$tmpPath . "/$key.expected.pdf";
            $expectedPdf->fillForm($data)->needAppearances()->saveAs($expectedTmpPath);
            $expectedTmpContent = file_get_contents($expectedTmpPath);

            $expected = base64_encode($expectedTmpContent);
            $actual = Generator::getInstance()->generate(Generator::CERFA_ENTREPRISE, json_encode($data));

            $this->assertEquals($expected, $actual);
        }
    }

    public function testNotGenerateText(): void {
        $testData = self::$testData['text'];
        foreach ($testData as $key => $value) {
            $templatePath = Config::get('CERFA_ENTREPRISE_PATH');
            $data = [$key => $value];
            
            $expectedPdf = new Pdf($templatePath);
            $expectedTmpPath = self::$tmpPath . "/$key.expected.pdf";
            $expectedPdf->fillForm($data)->needAppearances()->saveAs($expectedTmpPath);
            $expectedTmpContent = file_get_contents($expectedTmpPath);

            $expected = base64_encode($expectedTmpContent);
            $actual = Generator::getInstance()->generate(Generator::CERFA_ENTREPRISE, json_encode([$key => "not$value"]));

            $this->assertNotEquals($expected, $actual);
        }
    }

    public function testGenerateButton(): void {
        $testData = self::$testData['button'];
        foreach ($testData as $key => $value) {
            $templatePath = Config::get('CERFA_ENTREPRISE_PATH');
            $data = [$key => $value];
            
            $expectedPdf = new Pdf($templatePath);
            $expectedTmpPath = self::$tmpPath . "/$key.expected.pdf";
            $expectedPdf->fillForm($data)->needAppearances()->saveAs($expectedTmpPath);
            $expectedTmpContent = file_get_contents($expectedTmpPath);

            $expected = base64_encode($expectedTmpContent);
            $actual = Generator::getInstance()->generate(Generator::CERFA_ENTREPRISE, json_encode($data));

            $this->assertEquals($expected, $actual);
        }
    }

    public function testNotGenerateButton(): void {
        $testData = self::$testData['button'];
        foreach ($testData as $key => $value) {
            $templatePath = Config::get('CERFA_ENTREPRISE_PATH');
            $data = [$key => $value];
            
            $expectedPdf = new Pdf($templatePath);
            $expectedTmpPath = self::$tmpPath . "/$key.expected.pdf";
            $expectedPdf->fillForm($data)->needAppearances()->saveAs($expectedTmpPath);
            $expectedTmpContent = file_get_contents($expectedTmpPath);

            $expected = base64_encode($expectedTmpContent);
            $actual = Generator::getInstance()->generate(Generator::CERFA_ENTREPRISE, json_encode([$key => 'Off']));

            $this->assertNotEquals($expected, $actual);
        }
    }
}