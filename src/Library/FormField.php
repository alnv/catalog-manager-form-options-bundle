<?php

namespace Alnv\CatalogManagerFormOptionsBundle\Library;


class FormField {


    protected $objDatabase = null;


    public function __construct() {

        if ( $this->objDatabase == null ) {

            $this->objDatabase = \Database::getInstance();
        }
    }

    public function getTables() {

        return $this->objDatabase->listTables( null );
    }


    public function getTableColumns() {

        $arrReturn = [];
        $arrFields = $this->getTableColumnsByTablename( $this->getTablename(), [ 'upload' ], true );

        if ( empty( $arrFields ) || !is_array( $arrFields ) ) return $arrReturn;

        foreach ( $arrFields as $strFieldname => $arrField ) {

            $arrReturn[ $strFieldname ] = $arrField['label'][0] ? $arrField['label'][0] : $strFieldname;
        }

        return $arrReturn;
    }


    public function getColumns( \DataContainer $dc ) {

        $arrReturn = [];
        $strTablename = $dc->activeRecord->dbTable;

        if ( $strTablename && $this->objDatabase->tableExists( $strTablename ) ) {

            $objCatalogFieldBuilder = new \CatalogManager\CatalogFieldBuilder();
            $objCatalogFieldBuilder->initialize( $strTablename );
            $arrFields = $objCatalogFieldBuilder->getCatalogFields( true, null );

            foreach ( $arrFields as $strFieldname => $arrField ) {

                if ( !$this->objDatabase->fieldExists( $strFieldname, $strTablename ) ) continue;

                $arrReturn[ $strFieldname ] = \CatalogManager\Toolkit::getLabelValue( $arrField['_dcFormat']['label'], $strFieldname );
            }
        }

        return $arrReturn;
    }


    public function getTable( \DataContainer $dc ) {

        return $dc->activeRecord->dbTable ? $dc->activeRecord->dbTable : '';
    }


    public function getFields( \DataContainer $dc, $strTablename ) {

        return $this->getTableColumnsByTablename( $strTablename, [ 'upload', 'textarea' ], true );
    }


    protected function getTableColumnsByTablename( $strTablename, $arrForbiddenTypes = [], $blnFullContext = false ) {

        $arrReturn = [];

        if ( !$strTablename ) {

            return $arrReturn;
        }

        $objCatalogFieldBuilder = new \CatalogManager\CatalogFieldBuilder();
        $objCatalogFieldBuilder->initialize( $strTablename );
        $arrFields = $objCatalogFieldBuilder->getCatalogFields( true, null );

        foreach ( $arrFields as $strFieldname => $arrField ) {

            if ( in_array( $arrField['type'], \CatalogManager\Toolkit::excludeFromDc() ) ) {

                continue;
            }

            if ( in_array( $arrField['type'], $arrForbiddenTypes ) ) {

                continue;
            }

            $strTitle = $arrField['title'] ? $arrField['title'] : $strFieldname;
            $varValue = $blnFullContext ? $arrField['_dcFormat'] : $strTitle;
            $arrReturn[ $strFieldname ] = $varValue;
        }

        return $arrReturn;
    }


    protected function getTablename() {

        $objFormField = $this->objDatabase->prepare( 'SELECT * FROM tl_form_field WHERE id = ?' )->limit(1)->execute( \Input::get('id') );

        if ( $objFormField->numRows ) {

            return $objFormField->dbTable;
        }

        return null;
    }
}