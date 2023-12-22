<?php

namespace CerfaReceiptsGen\Controller;

use DateTime;
use Exception;
use mikehaertl\pdftk\Pdf;

class Cerfa {
    const TYPE_INDIVIDUAL = 'INDIVIDUAL';
    const TYPE_COMPANY = 'COMPANY';

    private string $tmpPath;
    private array $data;
    private string $path;

    public function __construct(string $json) {
        $this->data = json_decode($json, true);

        $tmpPath = __DIR__ . '/../../tmp';
        if (!file_exists($tmpPath)) mkdir($tmpPath, 0777, true);
        $this->tmpPath = $tmpPath;
    }

    private function setPath() {
        if (array_key_exists('donor', $this->data) && array_key_exists('type', $this->data['donor'])) {
            switch ($this->data['donor']['type']) {
                case self::TYPE_COMPANY:
                    Config::get('CERFA_COMPANY_PATH');
                    break;

                case self::TYPE_INDIVIDUAL:
                    Config::get('CERFA_INDIVIDUAL_PATH');
                    break;

                default:
                    throw new Exception('Bad donor type');
                    break;
            }
        }
    }

    private function fillPDF() {
        $dateTime = new DateTime();
        $timestamp = $dateTime->getTimestamp();
        $tmpPath = $this->tmpPath . "/cerfa-$timestamp.pdf";

        $pdf = new Pdf($this->path);
        $pdf->fillForm($this->data)->needAppearances()->saveAs($tmpPath);
        
        $content = file_get_contents($tmpPath);
        unlink($tmpPath);

        return base64_encode($content);
    }

    private function mapDatas() {
        throw new Exception('Not implemented');
    }

    public function generate($forcePath = false) {
        if (!$forcePath) {
            $this->mapDatas();
            $this->setPath();
        } else $this->path = $forcePath;

        return $this->fillPDF();
    }
}