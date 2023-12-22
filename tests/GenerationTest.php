<?php

use CerfaReceiptsGen\Controller\Cerfa;
use CerfaReceiptsGen\Controller\Config;
use mikehaertl\pdftk\Pdf;
use PHPUnit\Framework\TestCase;

final class GenerationTest extends TestCase {
    private Pdf $pdfIndividual;
    private Pdf $pdfCompany;

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
        $this->pdfCompany = new Pdf(Config::get('CERFA_COMPANY_PATH'));
    }

    public function testGenerateTextIndividual(): void {
        $data = self::$testData['generateText'];
        $dateTime = new DateTime();
        $timestamp = $dateTime->getTimestamp();
        
        $expectedTmpPath = self::$tmpPath . "/$timestamp.expected.pdf";
        $this->pdfIndividual->fillForm($data)->needAppearances()->saveAs($expectedTmpPath);
        $expectedTmpContent = file_get_contents($expectedTmpPath);

        $expected = base64_encode($expectedTmpContent);
        $actual_cerfa = new Cerfa(json_encode($data));
        $actual = $actual_cerfa->generate(Config::get('CERFA_INDIVIDUAL_PATH'));

        $this->assertEquals($expected, $actual);
    }

    public function testNotGenerateTextIndividual(): void {
        $expectedData = self::$testData['generateText'];
        $actualData = self::$testData['generateNotText'];
        $dateTime = new DateTime();
        $timestamp = $dateTime->getTimestamp();
        
        $expectedTmpPath = self::$tmpPath . "/$timestamp.expected.pdf";
        $this->pdfIndividual->fillForm($expectedData)->needAppearances()->saveAs($expectedTmpPath);
        $expectedTmpContent = file_get_contents($expectedTmpPath);

        $expected = base64_encode($expectedTmpContent);
        $actual_cerfa = new Cerfa(json_encode($actualData));
        $actual = $actual_cerfa->generate(Config::get('CERFA_INDIVIDUAL_PATH'));

        $this->assertNotEquals($expected, $actual);
    }

    public function testGenerateTextCompany(): void {
        $data = self::$testData['generateText'];
        $dateTime = new DateTime();
        $timestamp = $dateTime->getTimestamp();
        
        $expectedTmpPath = self::$tmpPath . "/$timestamp.expected.pdf";
        $this->pdfCompany->fillForm($data)->needAppearances()->saveAs($expectedTmpPath);
        $expectedTmpContent = file_get_contents($expectedTmpPath);

        $expected = base64_encode($expectedTmpContent);
        $actual_cerfa = new Cerfa(json_encode($data));
        $actual = $actual_cerfa->generate(Config::get('CERFA_COMPANY_PATH'));

        $this->assertEquals($expected, $actual);
    }

    public function testNotGenerateTextCompany(): void {
        $expectedData = self::$testData['generateText'];
        $actualData = self::$testData['generateNotText'];
        $dateTime = new DateTime();
        $timestamp = $dateTime->getTimestamp();
        
        $expectedTmpPath = self::$tmpPath . "/$timestamp.expected.pdf";
        $this->pdfCompany->fillForm($expectedData)->needAppearances()->saveAs($expectedTmpPath);
        $expectedTmpContent = file_get_contents($expectedTmpPath);

        $expected = base64_encode($expectedTmpContent);
        $actual_cerfa = new Cerfa(json_encode($actualData));
        $actual = $actual_cerfa->generate(Config::get('CERFA_COMPANY_PATH'));

        $this->assertNotEquals($expected, $actual);
    }

    public function testGenerateButtonIndividual(): void {
        $data = self::$testData['generateButton'];
        $dateTime = new DateTime();
        $timestamp = $dateTime->getTimestamp();
        
        $expectedTmpPath = self::$tmpPath . "/$timestamp.expected.pdf";
        $this->pdfIndividual->fillForm($data)->needAppearances()->saveAs($expectedTmpPath);
        $expectedTmpContent = file_get_contents($expectedTmpPath);

        $expected = base64_encode($expectedTmpContent);
        $actual_cerfa = new Cerfa(json_encode($data));
        $actual = $actual_cerfa->generate(Config::get('CERFA_INDIVIDUAL_PATH'));

        $this->assertEquals($expected, $actual);
    }

    public function testNotGenerateButtonIndividual(): void {
        $expectedData = self::$testData['generateButton'];
        $actualData = self::$testData['generateNotButton'];
        $dateTime = new DateTime();
        $timestamp = $dateTime->getTimestamp();
        
        $expectedTmpPath = self::$tmpPath . "/$timestamp.expected.pdf";
        $this->pdfIndividual->fillForm($expectedData)->needAppearances()->saveAs($expectedTmpPath);
        $expectedTmpContent = file_get_contents($expectedTmpPath);

        $expected = base64_encode($expectedTmpContent);
        $actual_cerfa = new Cerfa(json_encode($actualData));
        $actual = $actual_cerfa->generate(Config::get('CERFA_INDIVIDUAL_PATH'));

        $this->assertNotEquals($expected, $actual);
    }

    public function testGenerateButtonCompany(): void {
        $data = self::$testData['generateButton'];
        $dateTime = new DateTime();
        $timestamp = $dateTime->getTimestamp();
        
        $expectedTmpPath = self::$tmpPath . "/$timestamp.expected.pdf";
        $this->pdfCompany->fillForm($data)->needAppearances()->saveAs($expectedTmpPath);
        $expectedTmpContent = file_get_contents($expectedTmpPath);

        $expected = base64_encode($expectedTmpContent);
        $actual_cerfa = new Cerfa(json_encode($data));
        $actual = $actual_cerfa->generate(Config::get('CERFA_COMPANY_PATH'));

        $this->assertEquals($expected, $actual);
    }

    public function testNotGenerateButtonCompany(): void {
        $expectedData = self::$testData['generateButton'];
        $actualData = self::$testData['generateNotButton'];
        $dateTime = new DateTime();
        $timestamp = $dateTime->getTimestamp();
        
        $expectedTmpPath = self::$tmpPath . "/$timestamp.expected.pdf";
        $this->pdfCompany->fillForm($expectedData)->needAppearances()->saveAs($expectedTmpPath);
        $expectedTmpContent = file_get_contents($expectedTmpPath);

        $expected = base64_encode($expectedTmpContent);
        $actual_cerfa = new Cerfa(json_encode($actualData));
        $actual = $actual_cerfa->generate(Config::get('CERFA_COMPANY_PATH'));

        $this->assertNotEquals($expected, $actual);
    }
}