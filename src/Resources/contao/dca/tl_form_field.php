<?php

use Alnv\CatalogManagerFormOptionsBundle\Library\FormField;

$GLOBALS['TL_DCA']['tl_form_field']['palettes']['__selector__'][] = 'optionsType';
$GLOBALS['TL_DCA']['tl_form_field']['palettes']['radioOptionslist'] = '{type_legend},type,name,label;{fconfig_legend},mandatory;{options_legend},optionsType,includeBlankOption,blankOptionLabel;{expert_legend:hide},class;{template_legend:hide},customTpl;{invisible_legend:hide},invisible';
$GLOBALS['TL_DCA']['tl_form_field']['palettes']['checkboxOptionslist'] = '{type_legend},type,name,label;{fconfig_legend},mandatory;{options_legend},optionsType;{expert_legend:hide},class;{template_legend:hide},customTpl;{invisible_legend:hide},invisible';
$GLOBALS['TL_DCA']['tl_form_field']['palettes']['selectOptionslist'] = '{type_legend},type,name,label;{fconfig_legend},mandatory,multiple;{options_legend},optionsType,includeBlankOption,blankOptionLabel;{expert_legend:hide},class,accesskey,tabindex;{template_legend:hide},customTpl;{invisible_legend:hide},invisible';
$GLOBALS['TL_DCA']['tl_form_field']['subpalettes']['optionsType_useOptions'] = 'dbOptions';
$GLOBALS['TL_DCA']['tl_form_field']['subpalettes']['optionsType_useDbOptions'] = 'dbTable,dbTableKey,dbTableValue,dbTaxonomy,dbOrderBy,dbIgnoreEmptyValues';
$GLOBALS['TL_DCA']['tl_form_field']['subpalettes']['optionsType_useActiveDbOptions'] = 'dbTable,dbColumn,dbTaxonomy,dbOrderBy,dbIgnoreEmptyValues';

$GLOBALS['TL_DCA']['tl_form_field']['fields']['optionsType'] = [
    'inputType' => 'radio',
    'default' => 'useOptions',
    'eval' => [
        'maxlength' => 18,
        'mandatory' => true,
        'tl_class' => 'clr',
        'submitOnChange' => true
    ],
    'options' => ['useOptions', 'useDbOptions', 'useActiveDbOptions'],
    'reference' => &$GLOBALS['TL_LANG']['tl_form_field']['reference']['optionsType'],
    'exclude' => true,
    'sql' => "varchar(18) NOT NULL default ''"
];

$GLOBALS['TL_DCA']['tl_form_field']['fields']['dbOptions'] = [
    'inputType' => 'keyValueWizard',
    'exclude' => true,
    'eval' => [
        'mandatory' => true
    ],
    'sql' => "blob NULL"
];

$GLOBALS['TL_DCA']['tl_form_field']['fields']['dbColumn'] = [
    'inputType' => 'select',
    'eval' => [
        'chosen' => true,
        'maxlength' => 128,
        'tl_class' => 'w50',
        'mandatory' => true
    ],
    'options_callback' => [FormField::class, 'getTableColumns'],
    'exclude' => true,
    'sql' => "varchar(128) NOT NULL default ''"
];

$GLOBALS['TL_DCA']['tl_form_field']['fields']['dbTableKey'] = [
    'inputType' => 'select',
    'eval' => [
        'chosen' => true,
        'maxlength' => 128,
        'tl_class' => 'w50',
        'mandatory' => true
    ],
    'options_callback' => [FormField::class, 'getColumns'],
    'exclude' => true,
    'sql' => "varchar(128) NOT NULL default ''"
];

$GLOBALS['TL_DCA']['tl_form_field']['fields']['dbTableValue'] = [
    'inputType' => 'select',
    'eval' => [
        'chosen' => true,
        'maxlength' => 128,
        'tl_class' => 'w50',
        'mandatory' => true
    ],
    'options_callback' => [FormField::class, 'getColumns'],
    'exclude' => true,
    'sql' => "varchar(128) NOT NULL default ''"
];

$GLOBALS['TL_DCA']['tl_form_field']['fields']['dbTable'] = [
    'inputType' => 'select',
    'eval' => [
        'chosen' => true,
        'maxlength' => 128,
        'tl_class' => 'w50',
        'mandatory' => true,
        'submitOnChange' => true,
        'blankOptionLabel' => '-',
        'includeBlankOption' => true,
    ],
    'options_callback' => [FormField::class, 'getTables'],
    'exclude' => true,
    'sql' => "varchar(128) NOT NULL default ''"
];

$GLOBALS['TL_DCA']['tl_form_field']['fields']['dbTaxonomy'] = [
    'inputType' => 'catalogTaxonomyWizard',
    'eval' => [
        'tl_class' => 'clr',
        'dcTable' => 'tl_form_field',
        'taxonomyTable' => [FormField::class, 'getTable'],
        'taxonomyEntities' => [FormField::class, 'getFields']
    ],
    'exclude' => true,
    'sql' => "blob NULL"
];

$GLOBALS['TL_DCA']['tl_form_field']['fields']['dbOrderBy'] = [
    'label' => &$GLOBALS['TL_LANG']['tl_form_field']['dbOrderBy'],
    'inputType' => 'catalogDuplexSelectWizard',
    'eval' => [
        'chosen' => true,
        'blankOptionLabel' => '-',
        'includeBlankOption' => true,
        'mainLabel' => 'catalogManagerFields',
        'dependedLabel' => 'catalogManagerOrder',
        'mainOptions' => ['CatalogManager\OrderByHelper', 'getSortableFields'],
        'dependedOptions' => ['CatalogManager\OrderByHelper', 'getOrderByItems']
    ],
    'exclude' => true,
    'sql' => "blob NULL"
];

$GLOBALS['TL_DCA']['tl_form_field']['fields']['dbIgnoreEmptyValues'] = [
    'inputType' => 'checkbox',
    'eval' => [
        'tl_class' => 'w50 m12',
    ],
    'exclude' => true,
    'sql' => "char(1) NOT NULL default ''"
];

$GLOBALS['TL_DCA']['tl_form_field']['fields']['includeBlankOption'] = [
    'inputType' => 'checkbox',
    'eval' => [
        'tl_class' => 'w50 m12',
    ],
    'exclude' => true,
    'sql' => "char(1) NOT NULL default ''"
];

$GLOBALS['TL_DCA']['tl_form_field']['fields']['blankOptionLabel'] = [
    'inputType' => 'text',
    'eval' => [
        'maxlength' => 64,
        'tl_class' => 'w50',
    ],
    'exclude' => true,
    'sql' => "varchar(64) NOT NULL default ''"
];