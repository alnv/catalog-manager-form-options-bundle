<?php

namespace Alnv\CatalogManagerFormOptionsBundle\Library;

use Alnv\CatalogManagerBundle\OptionsGetter as CMOptionGetter;

class OptionsGetter
{

    public function parse($arrFields)
    {

        foreach ($arrFields as $objField) {

            $arrOptions = $this->getOptions($objField->type, $objField);

            if ($arrOptions == null) {
                continue;
            }

            $objField->options = \serialize($arrOptions);
        }

        return $arrFields;
    }


    protected function getOptions($strType, $objField)
    {

        switch ($strType) {
            case 'radioOptionslist':
            case 'selectOptionslist':
            case 'checkboxOptionslist':
                $arrField = $objField->row();
                $arrField['options'] = $arrField['dbOptions']; // rename options
                unset($arrField['dbOptions']); // delete db options
                $objOptionGetter = new CMOptionGetter($arrField);
                return $this->parseOptions($objOptionGetter->getOptions(), $objField->includeBlankOption, ($objField->blankOptionLabel ?: '-'));
        }


        return null;
    }


    protected function parseOptions($arrOptions, $strIncludeBlankOption, $strBlankOptionLabel)
    {

        $arrReturn = [];

        if (!\is_array($arrOptions) || empty($arrOptions)) {
            return [];
        }

        if ($strIncludeBlankOption) {
            $arrReturn[] = [
                'value' => '',
                'label' => $strBlankOptionLabel
            ];
        }

        foreach ($arrOptions as $strFieldname => $strValue) {
            $arrReturn[] = [
                'value' => $strFieldname,
                'label' => $strValue
            ];
        }

        return $arrReturn;
    }
}