<?php

namespace Alnv\CatalogManagerFormOptionsBundle\Library;

use Contao\Database;
use Contao\Input;
use Contao\DataContainer;
use Alnv\CatalogManagerBundle\Toolkit;
use Alnv\CatalogManagerBundle\CatalogFieldBuilder;

class FormField
{

    protected $objDatabase = null;

    public function __construct()
    {

        if ($this->objDatabase == null) {

            $this->objDatabase = Database::getInstance();
        }
    }

    public function getTables():array
    {
        return $this->objDatabase->listTables();
    }

    public function getTableColumns(): array
    {

        $arrReturn = [];
        $arrFields = $this->getTableColumnsByTablename($this->getTablename(), ['upload'], true);

        if (empty($arrFields) || \is_array($arrFields)) return $arrReturn;

        foreach ($arrFields as $strFieldname => $arrField) {

            $arrReturn[$strFieldname] = ($arrField['label'][0]  ?? '') ?: $strFieldname;
        }

        return $arrReturn;
    }

    public function getColumns(DataContainer $dc): array
    {

        $arrReturn = [];
        $strTablename = $dc->activeRecord->dbTable;

        if ($strTablename && $this->objDatabase->tableExists($strTablename)) {

            $objCatalogFieldBuilder = new CatalogFieldBuilder();
            $objCatalogFieldBuilder->initialize($strTablename);
            $arrFields = $objCatalogFieldBuilder->getCatalogFields(true, null);

            foreach ($arrFields as $strFieldname => $arrField) {

                if (!$this->objDatabase->fieldExists($strFieldname, $strTablename)) continue;

                $arrReturn[$strFieldname] = Toolkit::getLabelValue($arrField['_dcFormat']['label'], $strFieldname);
            }
        }

        return $arrReturn;
    }

    public function getTable(DataContainer $dc): string
    {
        return ($dc->getCurrentRecord()['dbTable'] ?? '') ?: '';
    }

    public function getFields(DataContainer $dc, $strTablename): array
    {
        return $this->getTableColumnsByTablename($strTablename, ['upload', 'textarea'], true);
    }

    protected function getTableColumnsByTablename($strTablename, $arrForbiddenTypes = [], $blnFullContext = false)
    {

        $arrReturn = [];

        if (!$strTablename) {
            return $arrReturn;
        }

        $objCatalogFieldBuilder = new CatalogFieldBuilder();
        $objCatalogFieldBuilder->initialize($strTablename);
        $arrFields = $objCatalogFieldBuilder->getCatalogFields(true, null);

        foreach ($arrFields as $strFieldname => $arrField) {

            if (\in_array($arrField['type'], Toolkit::excludeFromDc())) {

                continue;
            }

            if (\in_array($arrField['type'], $arrForbiddenTypes)) {
                continue;
            }

            $strTitle = ($arrField['title'] ?? '') ?: $strFieldname;
            $varValue = $blnFullContext ? $arrField['_dcFormat'] : $strTitle;
            $arrReturn[$strFieldname] = $varValue;
        }

        return $arrReturn;
    }

    protected function getTablename(): string
    {

        $objFormField = $this->objDatabase->prepare('SELECT * FROM tl_form_field WHERE id = ?')->limit(1)->execute(Input::get('id'));

        if ($objFormField->numRows) {
            return $objFormField->dbTable ?: '';
        }

        return '';
    }
}