<?php

class Field
{
    const TYPE_STRING = 'string';
    const TYPE_HTML = 'html';
    const TYPE_TEXT = 'text';
    const TYPE_FILE = 'file';
    const TYPE_COLOR = 'color';
    const TYPE_LIST = 'list';
    const TYPE_BOOLEAN = 'boolean';

    private $prop;
    private $id;
    private $name;
    private $hint;
    private $isMultiple;
    private $value;
    private $type;
    private $typeTemplate;


    public function __construct($prop)
    {
        $this->prop = $prop;
        $this->id = $prop['ID'];
        $this->code = !empty($prop['CODE']) ? $prop['CODE'] : $prop['ID'];
        $this->name = $this->prop['NAME'];
        $this->setType();
        $this->isMultiple = $this->prop['MULTIPLE'] === 'Y';

        $this->setValue();

        $this->hint = $this->prop['HINT'];
    }

    private function setType()
    {
        $type = $this->prop['PROPERTY_TYPE'];
        $userType = $this->prop['USER_TYPE'];


        switch ($type) {
            case 'F':
                $this->type = self::TYPE_FILE;
                break;
            case 'S':
                switch ($userType) {
                    case 'HTML':
                        $this->type = self::TYPE_HTML;
                        break;
                    case 'STRANKE_COLOR':
                        $this->type = self::TYPE_COLOR;
                        $this->colors = [
                            '#1abc9c', '#16a085', '#2ecc71', '#27ae60',
                            '#3498db', '#2980b9', '#9b59b6', '#8e44ad',
                            '#34495e', '#2c3e50', '#f1c40f', '#f39c12',
                            '#e67e22' ,'#d35400', '#e74c3c', '#c0392b',
                            '#95a5a6', '#7f8c8d',
                        ];
                        break;
                    default:
                        $this->type = self::TYPE_STRING;
                }
                break;
            case 'L':
                $this->type = self::TYPE_LIST;
                if ($this->isBoolean()) {
                    $this->type = self::TYPE_BOOLEAN;
                }
                break;
            default:
                $this->type = self::TYPE_STRING;
        }

        $this->typeTemplate = 'field_' . $this->type . '.php';
    }

    private function setValue()
    {
        $prop = $this->prop;

        switch ($this->type) {
            case self::TYPE_HTML:
                $this->value = !empty($prop['~VALUE']['TEXT']) ? $prop['~VALUE']['TEXT'] : '';
                break;
            case self::TYPE_FILE:
                $this->value = CFile::GetFileArray($prop['VALUE']);
                break;
            case self::TYPE_BOOLEAN:
                $this->isChecked = $this->prop['VALUE'] == 'Y';
                $this->value = $this->prop['ENUM'][0]['ID'];
                break;
            case self::TYPE_COLOR:
                if (!empty($prop['VALUE'])) {
                    $this->value = $prop['VALUE'];
                } else if (!empty($prop['DEFAULT_VALUE'])) {
                    $this->value = $prop['DEFAULT_VALUE'];
                }
                break;
            default:
                $this->value = $prop['VALUE'];
        }

        if (empty($this->value)) {
            $this->value = '';
        }
    }

    private function isBoolean()
    {
        if ($this->prop['PROPERTY_TYPE'] !== 'L') {
            return false;
        }

        if ($this->prop['LIST_TYPE'] !== 'C') {
            return false;
        }

        if (empty($this->prop['ENUM']) || count($this->prop['ENUM']) > 1) {
            return false;
        }

        if ($this->prop['ENUM'][0]['VALUE'] !== 'Y') {
            return false;
        }

        return true;
    }


    public function render()
    {
        include(dirname(__DIR__).'/views/field.php');
    }
}