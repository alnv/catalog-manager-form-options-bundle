<?php

$GLOBALS['TL_HOOKS']['compileFormFields'][] = [ 'Alnv\CatalogManagerFormOptionsBundle\Library\OptionsGetter', 'parse' ];

$GLOBALS['TL_FFL']['selectOptionslist'] = 'Contao\FormSelectMenu';
$GLOBALS['TL_FFL']['radioOptionslist'] = 'Contao\FormRadioButton';
$GLOBALS['TL_FFL']['checkboxOptionslist'] = 'Contao\FormCheckBox';