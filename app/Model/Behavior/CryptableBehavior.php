<?php
/**
 * Class CryptableBehavior
 */
class CryptableBehavior extends ModelBehavior { 
    public $settings = array(); 

    public function setup(Model $model, $settings = array()) {
        if (!isset($this->settings[$model->alias])) {
            $this->settings[$model->alias] = array(
                'fields' => array() 
            ); 
        } 

        $this->settings[$model->alias] = array_merge($this->settings[$model->alias], $settings);
    }

    public function beforeFind(Model $model, $queryData) { 
        foreach ($this->settings[$model->alias]['fields'] AS $field) { 
            if (isset($queryData['conditions'][$model->alias.'.'.$field])) { 
                $queryData['conditions'][$model->alias.'.'.$field] = $this->encrypt($queryData['conditions'][$model->alias.'.'.$field]); 
            } 
        } 
        return $queryData; 
    }

    public function afterFind(Model $model, $results, $primary = false) {
        foreach ($this->settings[$model->alias]['fields'] AS $field) { 
            if ($primary) { 
                foreach ($results AS $key => $value) { 
                    if (isset($value[$model->alias][$field])) { 
                        $results[$key][$model->alias][$field] = $this->decrypt($value[$model->alias][$field]); 
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

    public function beforeSave(Model $model, $options = array()) {
        foreach ($this->settings[$model->alias]['fields'] AS $field) { 
            if (isset($model->data[$model->alias][$field])) { 
                $model->data[$model->alias]['cleartext_'.$field] = $model->data[$model->alias][$field]; 
                $model->data[$model->alias][$field] = $this->encrypt($model->data[$model->alias][$field]); 
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