<?php
class AkquisesController extends AppController {
	public $helpers = array ('Html','Form','Price','Hours','Akquise');
	public $name = 'Akquises';
	public $components = array('Session', 'RequestHandler');


	/**
	* Zeitraum als Parameter in URL im Format "2013-04"
	* @param string
	*/ 
	public function index($zeitraum = null){
	
	$whereclause = '';
	
	if($zeitraum != null){
		$zeitraum_array = explode('-',$zeitraum);
		$firstdaymonth = date("Y-m-d H:i:s",mktime(0, 0, 0, $zeitraum_array[1], 1, $zeitraum_array[0]));
		$whereclause = 'WHERE erstkontaktdatum between "'.$firstdaymonth.'" AND LAST_DAY("'.$firstdaymonth.'")';
		$this->set('zeitraum', $zeitraum_array[0].'-'.$zeitraum_array[1]);
	}	


	$sql = 'SELECT kontaktmedium as id,COUNT(*) as summe FROM akquises '.$whereclause.' GROUP BY kontaktmedium';
	$this->set('kontaktmediums', $this->Akquise->query($sql));
	
	$sql = 'SELECT kundentypologie as id,COUNT(*) as summe FROM akquises '.$whereclause.' GROUP BY kundentypologie';
	$this->set('kundentypologies', $this->Akquise->query($sql));
	
	$sql = 'SELECT shopsystem as id,COUNT(*) as summe FROM akquises '.$whereclause.' GROUP BY shopsystem';
	$this->set('shopsystems', $this->Akquise->query($sql));

	$sql = 'SELECT arbeitsinhalt as id,COUNT(*) as summe FROM akquises '.$whereclause.' GROUP BY arbeitsinhalt';
	$this->set('arbeitsinhalts', $this->Akquise->query($sql));		
	
	$sql = 'SELECT resultat as id,COUNT(*) as summe FROM akquises '.$whereclause.' GROUP BY resultat';
	$this->set('resultats', $this->Akquise->query($sql));	

	$sql = 'SELECT absagegrund as id,COUNT(*) as summe FROM akquises '.$whereclause.' GROUP BY absagegrund';
	$this->set('absagegrunds', $this->Akquise->query($sql));	

	$sql = 'SELECT gender as id,COUNT(*) as summe FROM akquises '.$whereclause.' GROUP BY gender';
	$this->set('genders', $this->Akquise->query($sql));
		
	$sql = 'SELECT COUNT(*) as summe FROM akquises '.$whereclause.' ';
	$this->set('totalcount', $this->Akquise->query($sql));		

	
	}
	
	public function view($id = null) {
		$this->Akquise->id = $id;

		
		$this->set('Akquise', $this->Akquise->read());
	}
	
	public function add($id = null) {
	
		
		if($this->data && !empty($this->data["Akquise"]["kundenemail"])){
			$validateEmail = $this->Akquise->findAllBykundenemail($this->data["Akquise"]["kundenemail"]);
			
			if(count($validateEmail) >0){
				$this->Session->setFlash('Kundendaten für diese Email-Adresse schon eingegeben');
				$this->redirect(array('action'=>'add'));		
			}
		
		}
		
		if(!empty($id)){
		$this->set('id', $id);
		} else {
		$id = '';
		}
        $this->Akquise->id = $id;
        if (empty($this->data)) {
            //$this->data = $this->Akquise->read();
        } else {
			if ($this->Akquise->save($this->data)) {
				$this->Session->setFlash('Akquise gespeichert.');
				$this->redirect(array('action'=>'add'));
			}
		}
		
	}
	
	   	   
}