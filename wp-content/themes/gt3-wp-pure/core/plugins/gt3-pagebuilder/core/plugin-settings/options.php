<?php

$tabs = new Tabs();

$tabs->add(new Tab(array(
    'name' => 'General',
    'desc' => '',
    'icon' => 'general.png',
    'icon_active' => 'general_active.png',
    'icon_hover' => 'general_hover.png'
), array(
    new UploadOption(array(
        'name' => 'Header logo',
        'id' => 'logo',
        'desc' => 'Default: 101px x 112px',
        'default' => '/img/logo.png'
    )),
    new textOption(array(
        'name' => 'Header logo width',
        'id' => 'header_logo_standart_width',
        'not_empty' => true,
        'width' => '100px',
        'textalign' => 'center',
        'default' => '101'
    )),
    new SelectOption(array(
        'name' => 'Header type',
        'id' => 'header_type',
        'desc' => '',
        'default' => 'head_type1',
        'options' => array(
            'head_type1' => 'Default',
            'head_type2' => 'Type 2',
            'head_type3' => 'Type 3',
            'head_type4' => 'Type 4',
            'head_type5' => 'Type 5'
        )
    )),
    new TextareaOption(array(
        'name' => 'Custom CSS',
        'id' => 'custom_css',
        'default' => ''
    )),
    new ColorOption(array(
        'name' => 'Theme color',
        'id' => 'theme_color1',
        'desc' => '',
        'not_empty' => 'true',
        'default' => '0aa4ca'
    )),
)));

?>