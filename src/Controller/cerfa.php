<?php

namespace CerfaReceiptsGen\Controller;

use DateTime;
use Exception;
use mikehaertl\pdftk\Pdf;

class Cerfa {
    const TYPE_INDIVIDUAL = 'INDIVIDUAL';
    const TYPE_COMPANY = 'COMPANY';

    const TMP_PATH = __DIR__ . '/../../tmp';

    private array $entryData;
    private array $finalData;
    private string $type;

    public function __construct(string $json) {
        $this->entryData = json_decode($json, true);
        if (!file_exists(self::TMP_PATH)) mkdir(self::TMP_PATH, 0777, true);
    }

    private static function allTypes(): array {
        return [
            self::TYPE_INDIVIDUAL,
            self::TYPE_COMPANY
        ];
    }

    private function setType() {
        if (array_key_exists('donor', $this->entryData) && array_key_exists('type', $this->entryData['donor'])) {
            $donorType = $this->entryData['donor']['type'];
            if (!in_array($donorType, self::allTypes())) {
                throw new Exception('Bad donor type');
            }

            $this->type = $donorType;
        }
    }

    private function getFilePath(string $type) {
        return Config::get($type.'_'.$this->type.'_PATH');
    }

    private function getModelFileDatas() {
        $modelFilePath = $this->getFilePath('MODEL');

        return json_decode(file_get_contents($modelFilePath), true);
    }

    private function getTemplatePath() {
        return $this->getFilePath('CERFA');
    }

    private function parseEntryDataValue(string $field) {
        $value = $this->entryData;
        $tmpFields = explode('_', $field);
        foreach ($tmpFields as $fieldName) {
            $value = $value[$fieldName];
        }

        return $value;
    }

    private function fillPDF() {
        $dateTime = new DateTime();
        $timestamp = $dateTime->getTimestamp();
        $tmpPath = self::TMP_PATH . "/cerfa-$timestamp.pdf";

        $pdf = new Pdf($this->getTemplatePath());
        $pdf->fillForm($this->finalData)->needAppearances()->saveAs($tmpPath);
        
        $content = file_get_contents($tmpPath);
        // unlink($tmpPath);

        return base64_encode($content);
    }

    public function validate()
    {
        $result = [];
        $model = $this->getModelFileDatas();
        foreach($model as $field => $rules)
        {
            $value = $this->parseEntryDataValue($field);

            $mandatory = isset($rules['mandatory']) && $rules['mandatory'] === true && !$value;
            $dependency = isset($rules['dependency']) && (in_array($this->entryData[$rules['dependency']['field']], array_keys($rules['dependency']['values'])) && !$value);
            if ($mandatory || $dependency) {
                throw new \Exception("missing field '$field'");
            }
            if (isset($value)) {
                // if ($rules['type'] === 'date' && !isValidDate($value)) {
                //     throw new \Exception("incompatible date format for field '$field'");
                // }
                if ($rules['type'] !== 'date' && gettype($value) !== $rules['type']) {
                    throw new \Exception("incompatible type for field '$field'");
                }
                if (isset($rules['dependency'])) {
                    $dependency = $rules['dependency']['field'];
                    if (isset($rules['dependency']['values'][$this->parseEntryDataValue($dependency)]))
                        foreach ($rules['dependency']['values'][$this->parseEntryDataValue($dependency)] as $subfield => $subvalue) {
                            if ($rules['type'] === 'date') {
                                $dt = new DateTime();
                                $dt->setTimestamp($value);
                                $result[$subfield] = $dt->format('d/m/y');
                            } else {
                                $result[$subfield] = $subvalue;
                            }
                        }
                } else {
                    if ($rules['type'] === 'date') {
                        $dt = new DateTime();
                        $dt->setTimestamp($value);
                        $result[$rules['field']] = $dt->format('d/m/y');
                    } else $result[$rules['field']] = $value;
                }
            }
        }
        return $result;
    }

    public function generate(string $forceType = null) {
        if (!$forceType) {
            $this->setType();

            $validate = $this->validate();
            $this->finalData = $validate;
            Logger::getInstance()->info(json_encode($validate), ['validate']);
        } else {
            $this->type = $forceType;
            $this->finalData = $this->entryData;
        }

        return $this->fillPDF();
    }
}