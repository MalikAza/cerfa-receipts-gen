<?php

use CerfaReceiptsGen\Controller\Config;
use CerfaReceiptsGen\Controller\Generator;
use mikehaertl\pdftk\Pdf;
use PHPUnit\Framework\TestCase;

final class GenerationTest extends TestCase {
    private Pdf $pdfIndividual;
    private Pdf $pdfEntreprise;

    private static array $testData;
    private static string $tmpPath;

    public static function setUpBeforeClass(): void {
        $content = file_get_contents(__DIR__ . '/json/cerfa.test.json');
        self::$testData = json_decode($content, true);

        $tmpDirectoryPath = __DIR__ . '/tmp';
        if (!file_exists($tmpDirectoryPath)) mkdir($tmpDirectoryPath, 0777, true);
        self::$tmpPath = $tmpDirectoryPath;
    }

    public static function tearDownAfterClass(): void {
        $files = glob(self::$tmpPath . '/*');
        foreach ($files as $file) unlink($file);
    }

    protected function setUp(): void {
        $this->pdfIndividual = new Pdf(Config::get('CERFA_INDIVIDUAL_PATH'));
        $this->pdfEntreprise = new Pdf(Config::get('CERFA_ENTREPRISE_PATH'));
    }

    public function testGenerateIndividual(): void {
        $data = self::$testData['generate'];
        $dateTime = new DateTime();
        $timestamp = $dateTime->getTimestamp();
        
        $expectedTmpPath = self::$tmpPath . "/$timestamp.expected.pdf";
        $this->pdfIndividual->fillForm($data)->needAppearances()->saveAs($expectedTmpPath);
        $expectedTmpContent = file_get_contents($expectedTmpPath);

        $expected = base64_encode($expectedTmpContent);
        $actual = Generator::getInstance()->generate(Generator::CERFA_INDIVIDUAL, json_encode($data));

        $this->assertEquals($expected, $actual);
    }

    public function testNotGenerateIndividual(): void {
        $expectedData = self::$testData['generate'];
        $actualData = self::$testData['generateNot'];
        $dateTime = new DateTime();
        $timestamp = $dateTime->getTimestamp();
        
        $expectedTmpPath = self::$tmpPath . "/$timestamp.expected.pdf";
        $this->pdfIndividual->fillForm($expectedData)->needAppearances()->saveAs($expectedTmpPath);
        $expectedTmpContent = file_get_contents($expectedTmpPath);

        $expected = base64_encode($expectedTmpContent);
        $actual = Generator::getInstance()->generate(Generator::CERFA_INDIVIDUAL, json_encode($actualData));

        $this->assertNotEquals($expected, $actual);
    }

    public function testGenerateEntreprise(): void {
        $data = self::$testData['generate'];
        $dateTime = new DateTime();
        $timestamp = $dateTime->getTimestamp();
        
        $expectedTmpPath = self::$tmpPath . "/$timestamp.expected.pdf";
        $this->pdfEntreprise->fillForm($data)->needAppearances()->saveAs($expectedTmpPath);
        $expectedTmpContent = file_get_contents($expectedTmpPath);

        $expected = base64_encode($expectedTmpContent);
        $actual = Generator::getInstance()->generate(Generator::CERFA_ENTREPRISE, json_encode($data));

        $this->assertEquals($expected, $actual);
    }

    public function testNotGenerateEntreprise(): void {
        $expectedData = self::$testData['generate'];
        $actualData = self::$testData['generateNot'];
        $dateTime = new DateTime();
        $timestamp = $dateTime->getTimestamp();
        
        $expectedTmpPath = self::$tmpPath . "/$timestamp.expected.pdf";
        $this->pdfEntreprise->fillForm($expectedData)->needAppearances()->saveAs($expectedTmpPath);
        $expectedTmpContent = file_get_contents($expectedTmpPath);

        $expected = base64_encode($expectedTmpContent);
        $actual = Generator::getInstance()->generate(Generator::CERFA_ENTREPRISE, json_encode($actualData));

        $this->assertNotEquals($expected, $actual);
    }
}