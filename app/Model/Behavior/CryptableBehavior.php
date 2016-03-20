<?php 
class CryptableBehavior extends ModelBehavior { 
    public $settings = array(); 

    public function setup(Model $Model, $settings = array()) { 
        if (!isset($this->settings[$Model->alias])) { 
            $this->settings[$Model->alias] = array( 
                'fields' => array() 
            ); 
        } 

        $this->settings[$Model->alias] = array_merge($this->settings[$Model->alias], $settings); 
    } 
	

    public function beforeFind(Model $Model, $queryData) { 
        foreach ($this->settings[$Model->alias]['fields'] AS $field) { 
            if (isset($queryData['conditions'][$Model->alias.'.'.$field])) { 
                $queryData['conditions'][$Model->alias.'.'.$field] = $this->encrypt($queryData['conditions'][$Model->alias.'.'.$field]); 
            } 
        } 
        return $queryData; 
    } 

    public function afterFind(Model $Model, $results, $primary) { 
        foreach ($this->settings[$Model->alias]['fields'] AS $field) { 
            if ($primary) { 
                foreach ($results AS $key => $value) { 
                    if (isset($value[$Model->alias][$field])) { 
                        $results[$key][$Model->alias][$field] = $this->decrypt($value[$Model->alias][$field]); 
                    } 
                } 
            } else { 
                if (isset($results[$field])) { 
                    $results[$field] = $this->decrypt($results[$field]); 
                } 
            } 
        } 

        return $results; 
    } 

    public function beforeSave(Model $Model) { 
        foreach ($this->settings[$Model->alias]['fields'] AS $field) { 
            if (isset($Model->data[$Model->alias][$field])) { 
                $Model->data[$Model->alias]['cleartext_'.$field] = $Model->data[$Model->alias][$field]; 
                $Model->data[$Model->alias][$field] = $this->encrypt($Model->data[$Model->alias][$field]); 
            } 
        } 
        return true; 
    } 

public function encrypt($data) { 
    if ($data !== '') { 
        $td = mcrypt_module_open('tripledes', '', 'ecb', ''); 
        mcrypt_generic_init($td, Configure::read('Cryptable.key'), Configure::read('Cryptable.iv')); 
        $encrypted_data = mcrypt_generic($td, $data); 
        mcrypt_generic_deinit($td); 
        mcrypt_module_close($td); 
        return base64_encode($encrypted_data); 
    } else { 
        return ''; 
    } 
} 

public function decrypt($data, $data2 = null) { 
    if (is_object($data)) { 
        unset($data); 
        $data = $data2; 
    } 
     
    if ($data != '') { 
        $td = mcrypt_module_open(Configure::read('Cryptable.cipher'), '', 'ecb', ''); 
        mcrypt_generic_init($td, Configure::read('Cryptable.key'), Configure::read('Cryptable.iv')); 
        $decrypted_data = mdecrypt_generic($td, base64_decode($data)); 
        mcrypt_generic_deinit($td); 
        mcrypt_module_close($td); 
        return trim($decrypted_data); 
    } else { 
        return ''; 
    } 
} 
} 