<?php
/**
 * Application level View Helper
 *
 * This file is application-wide helper file. You can put all
 * application-wide helper-related methods here.
 *
 * PHP 5
 *
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright 2005-2012, Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright 2005-2012, Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @package       app.View.Helper
 * @since         CakePHP(tm) v 0.2.9
 * @license       MIT License (http://www.opensource.org/licenses/mit-license.php)
 */

App::uses('Helper', 'View');

/**
 * Application helper
 *
 * Add your application-wide methods in the class below, your helpers
 * will inherit them.
 *
 * @package       app.View.Helper
 */
class AkquiseHelper extends Helper {


	public function getKontaktmediumValues(){
		$values = array("Email","Kontaktformular","Anruf","Sonstige","Eigenansprache");
		return $values;
	}
	
	
	public function getKundentypologieValues(){
		$values = array(
		"Kleidung / Mode",
		"Autoteile",
		"Elektrogeräte",
		"esmoke",
		"Spiele",
		"Haushaltswaren",
		"Möbel",
		"Fahrräder",
		"Chemie",
		"Pharma",
		"Industrie",
		"Lebensmittel",
		"Agentur klein",
		"Agentur groß",
		"Schmuck",
		"Digitale Güter",
		"Sonstige",
		"nicht bekannt"
		);
		return $values;
	}
	
	
	public function getShopsystemValues(){
		$values = array(
		"Shopware 3.5",
		"Shopware 4",
		"Magento",
		"xt:commerce",
		"Veyton",
		"osCommerce",
		"Gambio",
		"xtcmodified",
		"Jtl shop",
		"Plenty",
		"Wordpress",
		"Sonstige",
		);
	return $values;
	}
	
	public function getArbeitsinhaltValues(){
		$values = array(
		"Individualprogrammierung < 5h",
		"Individualprogrammierung > 5h",
		"Schnittstellenprogrammierung",
		"Komplettes Shopprojekt",
		"Weiterentwicklung Shop",
		"Templating only",
		"Relaunch Shop",
		"Firmenwebsite",
		"Installation Software",
		"Support",
		"sonstiges",
		"Bestehender Shop hat Bugs",
		);
	return $values;
	}
	
	public function getGenderValues(){
		$values = array(
		"unbekannt",
		"Mann",
		"Frau",
		);
	return $values;
	}	
	
	public function getResultatValues(){
		$values = array(
		"Absage ich",
		"Absage Kunde",
		"Im Nichts verschwunden",
		"Läuft noch",
		"Erfolg"
		);
	return $values;
	}
	
	public function getAbsagegrundValues(){
		$values = array(
		"-",
		"Unrealistische Preisvorstellung Kunde",
		"Falsche Arbeitsinhalte",
		"Agentur sucht Sklaven",
		"Ich war zu zögerlich",
		"Kunde unseriös",
		"Kunde zu klein",
		"Mein Angebot war Kunde zu teuer",
		"sonstige",
		"Projektgröße zu klein",
		"Keine Zeit mich darum zu kümmern",
		"Kunde emotional schräg drauf",
		"Kunde weiß nicht was er will",
		"Kunde passt nicht zu mir",
		"Projektgröße zu groß",
		);
	return $values;
	}
	
	/**
	* Gibt HTML zurück für die Statistikblöcke, immer gleich aufgebaut und formatiert mit Name - Value - Paar.
	* @return string
	*/
	public function buildStataHTML($blockname = "",$values){
	
		$names = call_user_func(array($this, 'get'.$blockname.'Values'));
		
		$html = '<div class="akquise_stata_block">';
		$html .= '<div class="akquise_stata_headline">'.$blockname .'</div>';
		
		foreach($values as $value){
			$html .= '<span class="akquise_stata_desc">'.$names[$value['akquises']['id']].'</span><span class="akquise_stata_value">'.$value[0]['summe'].'</span>';	
		}
		
		$html .= '</div>';
	
	return $html;

}
	
	/**
	* Alle Monate, in denen Statistik vorliegt seit Implementierung und Datenerhebung
	* @return array
	*/
	public function getZeitraumValues(){
		
		$min_date = strtotime('2013-03-01');
		$max_date = strtotime('now');
		$max_date = strtotime("-1 MONTH",$max_date);
		
		while ($min_date  < $max_date) {
			$min_date = strtotime("+1 MONTH", $min_date);
			$values[] = date('Y-m',$min_date);
		}		
		
		return $values;
	}				
}