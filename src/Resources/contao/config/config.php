<?php

use Contao\SelectMenu;
use Contao\RadioButton;
use Contao\CheckBox;
use Alnv\CatalogManagerFormOptionsBundle\Library\OptionsGetter;

$GLOBALS['TL_HOOKS']['compileFormFields'][] = [OptionsGetter::class, 'parse'];

$GLOBALS['TL_FFL']['selectOptionslist'] = SelectMenu::class;
$GLOBALS['TL_FFL']['radioOptionslist'] = RadioButton::class;
$GLOBALS['TL_FFL']['checkboxOptionslist'] = CheckBox::class;