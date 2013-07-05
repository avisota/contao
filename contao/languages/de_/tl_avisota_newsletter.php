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
 * Fields
 */
$GLOBALS['TL_LANG']['orm_avisota_mailing']['subject']              = array(
	'Betreff',
	'Bitte geben Sie den Betreff des Newsletters ein.'
);
$GLOBALS['TL_LANG']['orm_avisota_mailing']['alias']                = array(
	'Newsletteralias',
	'Der Newsletteralias ist eine eindeutige Referenz, die anstelle der numerischen Newsletter-Id aufgerufen werden kann.'
);
$GLOBALS['TL_LANG']['orm_avisota_mailing']['addFile']              = array(
	'Dateien anhängen',
	'Dem Newsletter eine oder mehrere Dateien anhängen.'
);
$GLOBALS['TL_LANG']['orm_avisota_mailing']['files']                = array(
	'Dateianhänge',
	'Bitte wählen Sie die anzuhängenden Dateien aus der Dateiübersicht.'
);
$GLOBALS['TL_LANG']['orm_avisota_mailing']['setRecipients']        = array(
	'Empfänger zuweisen',
	'Wählen Sie für diesen Newsletter eine neue Liste von Empfängern aus.'
);
$GLOBALS['TL_LANG']['orm_avisota_mailing']['recipients']           = array(
	'Empfänger',
	'Wählen Sie hier die Empfänger aus.'
);
$GLOBALS['TL_LANG']['orm_avisota_mailing']['setTheme']             = array(
	'Layout zuweisen',
	'Wählen Sie für diesen Newsletter ein neues Layout aus.'
);
$GLOBALS['TL_LANG']['orm_avisota_mailing']['theme']                = array(
	'Layout',
	'Wählen Sie hier das Layouts aus.'
);
$GLOBALS['TL_LANG']['orm_avisota_mailing']['setTransport']         = array(
	'Transportmodul zuweisen',
	'Wählen Sie für diesen Newsletter ein neues Transportmodul aus.'
);
$GLOBALS['TL_LANG']['orm_avisota_mailing']['transport']            = array(
	'Transportmodul',
	'Wählen Sie hier das Transportmodul aus.'
);
$GLOBALS['TL_LANG']['orm_avisota_mailing']['tstamp']               = array(
	'Änderungsdatum',
	'Datum und Uhrzeit der letzten Änderung'
);
$GLOBALS['TL_LANG']['orm_avisota_mailing']['sendPreviewToUser']    = array(
	'Testsendung an Benutzer',
	'Die Testsendung des Newsletters an diesen Benutzer versenden.'
);
$GLOBALS['TL_LANG']['orm_avisota_mailing']['sendPreviewToEmail']   = array(
	'Testsendung an E-Mail',
	'Die Testsendung des Newsletters an diese E-Mail-Adresse versenden. Geben Sie hier eine E-Mail Adresse an, wird der Versand an die Benutzerauswahl ignoriert.'
);
$GLOBALS['TL_LANG']['orm_avisota_mailing']['preview_mode']         = array(
	'Vorschaumodus',
	'Den Vorschaumodus wechseln.',
	'HTML Vorschau',
	'Plain Text Vorschau'
);
$GLOBALS['TL_LANG']['orm_avisota_mailing']['preview_personalized'] = array(
	'Personalisieren',
	'Die Vorschau personalisieren.',
	'Keine',
	'Anonym',
	'Persönlich'
);


/**
 * Legends
 */
$GLOBALS['TL_LANG']['orm_avisota_mailing']['newsletter_legend'] = 'Newsletter';
$GLOBALS['TL_LANG']['orm_avisota_mailing']['recipient_legend']  = 'Empfänger';
$GLOBALS['TL_LANG']['orm_avisota_mailing']['theme_legend']      = 'Layout-Einstellungen';
$GLOBALS['TL_LANG']['orm_avisota_mailing']['transport_legend']  = 'Transport-Einstellungen';
$GLOBALS['TL_LANG']['orm_avisota_mailing']['attachment_legend'] = 'Dateianhänge';
$GLOBALS['TL_LANG']['orm_avisota_mailing']['headline']          = 'Newsletter ansehen und versenden';
$GLOBALS['TL_LANG']['orm_avisota_mailing']['from']              = 'Absender';
$GLOBALS['TL_LANG']['orm_avisota_mailing']['live']              = 'Vorschau aktualisieren';
$GLOBALS['TL_LANG']['orm_avisota_mailing']['preview']           = 'Testsendung';
$GLOBALS['TL_LANG']['orm_avisota_mailing']['unsubscribe']       = 'vom Newsletter abmelden';
$GLOBALS['TL_LANG']['orm_avisota_mailing']['salutation']        = 'Sehr geehrte/-r {fullname}';
$GLOBALS['TL_LANG']['orm_avisota_mailing']['salutation_male']   = 'Sehr geehrter Herr {fullname}';
$GLOBALS['TL_LANG']['orm_avisota_mailing']['salutation_female'] = 'Sehr geehrte Frau {fullname}';

/**
 * Reference
 */
$GLOBALS['TL_LANG']['orm_avisota_mailing']['created_from_draft']  = 'Newsletter wurde erstellt.';
$GLOBALS['TL_LANG']['orm_avisota_mailing']['view']                = array(
	'Ansehen und Versenden',
	'Den Newsletter ansehen und versenden.'
);
$GLOBALS['TL_LANG']['orm_avisota_mailing']['view_only']           = array('Ansehen', 'Den Newsletter ansehen.');
$GLOBALS['TL_LANG']['orm_avisota_mailing']['send']                = array('Versenden', 'Den Newsletter versenden.');
$GLOBALS['TL_LANG']['orm_avisota_mailing']['sended']              = 'versendet am %s';
$GLOBALS['TL_LANG']['orm_avisota_mailing']['confirm']             = 'Der Newsletter wurde an alle Empfänger versendet.';
$GLOBALS['TL_LANG']['orm_avisota_mailing']['confirmPreview']      = 'Die Testsendung wurde an %s versendet.';
$GLOBALS['TL_LANG']['orm_avisota_mailing']['online']              = 'Probleme mit der Darstellung? Den Newsletter Online ansehen.';
$GLOBALS['TL_LANG']['orm_avisota_mailing']['list']                = 'Verteiler';
$GLOBALS['TL_LANG']['orm_avisota_mailing']['member']              = 'Mitglieder';
$GLOBALS['TL_LANG']['orm_avisota_mailing']['mgroup']              = 'Mitgliedergruppe';
$GLOBALS['TL_LANG']['orm_avisota_mailing']['notSend']             = 'noch nicht versendet';
$GLOBALS['TL_LANG']['orm_avisota_mailing']['inheritFromCategory'] = '- von Kategorie übernehmen -';
$GLOBALS['TL_LANG']['orm_avisota_mailing']['fallback']            = '(fallback)';

/**
 * Buttons
 */
$GLOBALS['TL_LANG']['orm_avisota_mailing']['new']               = array(
	'Neuer Newsletter',
	'Einen neuen Newsletter erstellen'
);
$GLOBALS['TL_LANG']['orm_avisota_mailing']['create_from_draft'] = array(
	'Neuer Newsletter aus Vorlage',
	'Einen neuen Newsletter aus Vorlage erstellen'
);
$GLOBALS['TL_LANG']['orm_avisota_mailing']['show']              = array(
	'Newsletterdetails',
	'Details des Newsletter ID %s anzeigen'
);
$GLOBALS['TL_LANG']['orm_avisota_mailing']['copy']              = array(
	'Newsletter duplizieren',
	'Newsletter ID %s duplizieren'
);
$GLOBALS['TL_LANG']['orm_avisota_mailing']['delete']            = array(
	'Newsletter löschen',
	'Newsletter ID %s löschen'
);
$GLOBALS['TL_LANG']['orm_avisota_mailing']['edit']              = array(
	'Newsletter bearbeiten',
	'Newsletter ID %s bearbeiten'
);
$GLOBALS['TL_LANG']['orm_avisota_mailing']['editheader']        = array(
	'Newslettereinstellungen bearbeiten',
	'Einstellungen des Newsletter ID %s bearbeiten'
);


/**
 * Personalisation
 */
$GLOBALS['TL_LANG']['orm_avisota_mailing']['anonymous']['salutation'] = 'Sehr geehrte/-r {fullname}';
$GLOBALS['TL_LANG']['orm_avisota_mailing']['anonymous']['name']       = 'Abonnent/-in';
$GLOBALS['TL_LANG']['orm_avisota_mailing']['anonymous']['fullname']   = 'Abonnent/-in';
$GLOBALS['TL_LANG']['orm_avisota_mailing']['anonymous']['shortname']  = 'Abonnent/-in';


/**
 * Errors
 */
$GLOBALS['TL_LANG']['orm_avisota_mailing']['transport_error'] = 'Beim Versand ist ein Fehler aufgetreten, der noch nicht weiter analysiert wurde.<br>
Bitte übermitteln Sie folgende Meldung an den Entwickler.<br/>
&mdash; via <a href="http://contao-forge.org/projects/avisota/issues" onclick="window.open(this.href); return false;">Contao Forge</a><br/>
&mdash; via <a href="http://www.contao-community.de/forumdisplay.php?121-Avisota" onclick="window.open(this.href); return false;">Contao Community Forum</a><br/>
&mdash; via <a href="mailto:info@infinitysoft.de">E-Mail</a>';