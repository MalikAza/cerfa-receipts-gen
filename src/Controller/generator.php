<?php

namespace CerfaReceiptsGen\Controller;

use DateTime;
use Exception;
use mikehaertl\pdftk\Pdf;

class Generator {
    const CERFA_INDIVIDUAL = 'individual';
    const CERFA_ENTREPRISE = 'entreprise';

    private static $instance;
    private string $tmpPath;

    private function __construct() {
        $tmpPath = __DIR__ . '/../../tmp';
        if (!file_exists($tmpPath)) mkdir($tmpPath, 0777, true);

        $this->tmpPath = $tmpPath;
    }

    public static function getInstance(): Generator {
        if (!isset(self::$instance)) self::$instance = new Generator();

        return self::$instance;
    }

    private function fillPDF(string $path, array $data) {
        $dateTime = new DateTime();
        $timestamp = $dateTime->getTimestamp();
        $tmpPath = $this->tmpPath . "/cerfa-$timestamp.pdf";

        $pdf = new Pdf($path);
        $pdf->fillForm($data)->needAppearances()->saveAs($tmpPath);
        
        $content = file_get_contents($tmpPath);
        unlink($tmpPath);

        return base64_encode($content);
    }

    public function generate(string $type, string $json) {
        $data = json_decode($json, true);
        switch ($type) {
            case self::CERFA_INDIVIDUAL:
                $b64 = self::fillPDF(Config::get('CERFA_INDIVIDUAL_PATH'), $data);
                break;
            
            case self::CERFA_ENTREPRISE:
                $b64 = self::fillPDF(Config::get('CERFA_ENTREPRISE_PATH'), $data);
                break;

            default:
                throw new Exception('Bad cerfa type');
                break;
        }

        return $b64;
    }
}