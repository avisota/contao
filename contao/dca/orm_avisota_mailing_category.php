<?php

/**
 * Avisota newsletter and mailing system
 * Copyright (C) 2013 Tristan Lins
 *
 * PHP version 5
 *
 * @copyright  bit3 UG 2013
 * @author     Tristan Lins <tristan.lins@bit3.de>
 * @package    avisota
 * @license    LGPL
 * @filesource
 */


/**
 * Table orm_avisota_mailing_category
 * Entity Avisota\Contao:MailingCategory
 */
$GLOBALS['TL_DCA']['orm_avisota_mailing_category'] = array
(

	// Config
	'config'                => array
	(
		'dataContainer'    => 'Table',
		'ctable'           => array('orm_avisota_mailing'),
		'switchToEdit'     => true,
		'enableVersioning' => true,
		'onload_callback'  => array
		(
			array('Avisota\Contao\DataContainer\MailingCategory', 'checkPermission')
		)
	),
	// List
	'list'                  => array
	(
		'sorting'           => array
		(
			'mode'        => 1,
			'flag'        => 1,
			'fields'      => array('title'),
			'panelLayout' => 'search,limit'
		),
		'label'             => array
		(
			'fields' => array('title'),
			'format' => '%s'
		),
		'global_operations' => array
		(
			'all' => array
			(
				'label'      => &$GLOBALS['TL_LANG']['MSC']['all'],
				'href'       => 'act=select',
				'class'      => 'header_edit_all',
				'attributes' => 'onclick="Backend.getScrollOffset();" accesskey="e"'
			)
		),
		'operations'        => array
		(
			'edit'       => array
			(
				'label'      => &$GLOBALS['TL_LANG']['orm_avisota_mailing_category']['edit'],
				'href'       => 'table=orm_avisota_mailing',
				'icon'       => 'edit.gif',
			),
			'editheader' => array
			(
				'label'           => &$GLOBALS['TL_LANG']['orm_avisota_mailing_category']['editheader'],
				'href'            => 'act=edit',
				'icon'            => 'header.gif',
				'button_callback' => array('Avisota\Contao\DataContainer\MailingCategory', 'editHeader'),
			),
			'copy'       => array
			(
				'label'           => &$GLOBALS['TL_LANG']['orm_avisota_mailing_category']['copy'],
				'href'            => 'act=copy',
				'icon'            => 'copy.gif',
				'attributes'      => 'onclick="Backend.getScrollOffset();"',
				'button_callback' => array('Avisota\Contao\DataContainer\MailingCategory', 'copyCategory')
			),
			'delete'     => array
			(
				'label'           => &$GLOBALS['TL_LANG']['orm_avisota_mailing_category']['delete'],
				'href'            => 'act=delete',
				'icon'            => 'delete.gif',
				'attributes'      => 'onclick="if (!confirm(\'' . $GLOBALS['TL_LANG']['MSC']['deleteConfirm'] . '\')) return false; Backend.getScrollOffset();"',
				'button_callback' => array('Avisota\Contao\DataContainer\MailingCategory', 'deleteCategory')
			),
			'show'       => array
			(
				'label' => &$GLOBALS['TL_LANG']['orm_avisota_mailing_category']['show'],
				'href'  => 'act=show',
				'icon'  => 'show.gif'
			)
		),
	),
	// Palettes
	'palettes' => array(
		'__selector__' => array('boilerplates')
	),
	'metapalettes'          => array
	(
		'default' => array
		(
			'category'   => array('title', 'alias'),
			'recipients' => array('recipientsMode'),
			'theme'      => array('themeMode'),
			'transport'  => array('transportMode'),
			'queue'      => array('queueMode'),
			'expert'     => array(':hide', 'boilerplates', 'showInMenu'),
		),
		'boilerplates' => array
		(
			'category'   => array('title', 'alias'),
			'expert'     => array(':hide', 'boilerplates'),
		),
	),
	// Subpalettes
	'metasubpalettes'       => array
	(
		'showInMenu'        => array('useCustomMenuIcon'),
		'useCustomMenuIcon' => array('menuIcon'),
	),
	// Subselectpalettes
	'metasubselectpalettes' => array
	(
		'recipientsMode' => array
		(
			'byCategory'             => array('recipients'),
			'byMailingOrCategory' => array('recipients'),
		),
		'themeMode'      => array
		(
			'byCategory'             => array('theme'),
			'byMailingOrCategory' => array('theme')
		),
		'transportMode'  => array
		(
			'byCategory'             => array('transport'),
			'byMailingOrCategory' => array('transport')
		),
		'queueMode'      => array
		(
			'byCategory'             => array('queue'),
			'byMailingOrCategory' => array('queue')
		)
	),
	// Fields
	'fields'                => array
	(
		'id' => array(
			'field' => array(
				'id' => true,
				'type' => 'integer'
			)
		),
		'tstamp' => array(
			'field' => array(
				'type' => 'timestamp'
			)
		),
		'title'             => array
		(
			'label'     => &$GLOBALS['TL_LANG']['orm_avisota_mailing_category']['title'],
			'exclude'   => true,
			'search'    => true,
			'inputType' => 'text',
			'eval'      => array(
				'mandatory' => true,
				'maxlength' => 255,
				'tl_class'  => 'w50'
			)
		),
		'alias'             => array
		(
			'label'         => &$GLOBALS['TL_LANG']['orm_avisota_mailing_category']['alias'],
			'exclude'       => true,
			'search'        => true,
			'inputType'     => 'text',
			'eval'          => array(
				'rgxp'              => 'alnum',
				'unique'            => true,
				'spaceToUnderscore' => true,
				'maxlength'         => 128,
				'tl_class'          => 'w50'
			),
			'save_callback' => array
			(
				array('Avisota\Contao\DataContainer\MailingCategory', 'generateAlias')
			)
		),
		'recipientsMode'    => array
		(
			'label'     => &$GLOBALS['TL_LANG']['orm_avisota_mailing_category']['recipientsMode'],
			'default'   => 'byCategory',
			'inputType' => 'select',
			'options'   => array('byCategory', 'byMailingOrCategory', 'byMailing'),
			'reference' => &$GLOBALS['TL_LANG']['orm_avisota_mailing_category'],
			'eval'      => array(
				'mandatory'      => true,
				'submitOnChange' => true,
				'tl_class'       => 'w50'
			)
		),
		'recipients'        => array
		(
			'label'            => &$GLOBALS['TL_LANG']['orm_avisota_mailing_category']['recipients'],
			'inputType'        => 'checkbox',
			'options_callback' => array('Avisota\Contao\DataContainer\MailingCategory', 'getRecipients'),
			'eval'             => array(
				'mandatory' => true,
				'multiple'  => true,
				'tl_class'  => 'clr'
			)
		),
		'themeMode'         => array
		(
			'label'     => &$GLOBALS['TL_LANG']['orm_avisota_mailing_category']['themeMode'],
			'default'   => 'byCategory',
			'inputType' => 'select',
			'options'   => array('byCategory', 'byMailingOrCategory', 'byMailing'),
			'reference' => &$GLOBALS['TL_LANG']['orm_avisota_mailing_category'],
			'eval'      => array(
				'mandatory'      => true,
				'submitOnChange' => true,
				'tl_class'       => 'w50'
			)
		),
		'theme'             => array
		(
			'label'      => &$GLOBALS['TL_LANG']['orm_avisota_mailing_category']['theme'],
			'inputType'  => 'select',
			'foreignKey' => 'orm_avisota_theme.title',
			'eval'       => array(
				'mandatory'          => true,
				'includeBlankOption' => true,
				'tl_class'           => 'w50'
			)
		),
		'transportMode'     => array
		(
			'label'     => &$GLOBALS['TL_LANG']['orm_avisota_mailing_category']['transportMode'],
			'default'   => 'byCategory',
			'inputType' => 'select',
			'options'   => array('byCategory', 'byMailingOrCategory', 'byMailing'),
			'reference' => &$GLOBALS['TL_LANG']['orm_avisota_mailing_category'],
			'eval'      => array(
				'mandatory'      => true,
				'submitOnChange' => true,
				'tl_class'       => 'w50'
			)
		),
		'transport'         => array
		(
			'label'      => &$GLOBALS['TL_LANG']['orm_avisota_mailing_category']['transport'],
			'inputType'  => 'select',
			'foreignKey' => 'orm_avisota_transport.title',
			'eval'       => array(
				'mandatory'          => true,
				'includeBlankOption' => true,
				'tl_class'           => 'w50'
			)
		),
		'queueMode'         => array
		(
			'label'     => &$GLOBALS['TL_LANG']['orm_avisota_mailing_category']['queueMode'],
			'default'   => 'byCategory',
			'inputType' => 'select',
			'options'   => array('byCategory', 'byMailingOrCategory', 'byMailing'),
			'reference' => &$GLOBALS['TL_LANG']['orm_avisota_mailing_category'],
			'eval'      => array(
				'mandatory'      => true,
				'submitOnChange' => true,
				'tl_class'       => 'w50'
			)
		),
		'queue'             => array
		(
			'label'      => &$GLOBALS['TL_LANG']['orm_avisota_mailing_category']['queue'],
			'inputType'  => 'select',
			'foreignKey' => 'orm_avisota_queue.title',
			'eval'       => array(
				'mandatory'          => true,
				'includeBlankOption' => true,
				'tl_class'           => 'w50'
			)
		),
		'boilerplates'    => array
		(
			'label'     => &$GLOBALS['TL_LANG']['orm_avisota_mailing_category']['boilerplates'],
			'exclude'       => true,
			'filter'       => true,
			'inputType' => 'checkbox',
			'eval'      => array(
				'submitOnChange' => true,
				'tl_class'       => 'm12'
			)
		),
		'showInMenu'        => array
		(
			'label'     => &$GLOBALS['TL_LANG']['orm_avisota_mailing_category']['showInMenu'],
			'inputType' => 'checkbox',
			'eval'      => array(
				'submitOnChange' => true,
				'tl_class' => 'm12 w50'
			)
		),
		'useCustomMenuIcon' => array
		(
			'label'     => &$GLOBALS['TL_LANG']['orm_avisota_mailing_category']['useCustomMenuIcon'],
			'inputType' => 'checkbox',
			'eval'      => array('tl_class' => 'm12 w50', 'submitOnChange' => true)
		),
		'menuIcon'          => array
		(
			'label'     => &$GLOBALS['TL_LANG']['orm_avisota_mailing_category']['menuIcon'],
			'inputType' => 'fileTree',
			'eval'      => array(
				'tl_class'   => 'clr',
				'files'      => true,
				'filesOnly'  => true,
				'fieldType'  => 'radio',
				'extensions' => 'png,gif,jpg,jpeg'
			)
		)
	)
);
