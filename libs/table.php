<?php

class Table{

    protected $caption;
    protected $lignes;
    protected $nbligne;

    protected $id;//string utilisable pour le css

    public function  __construct($id) {
        $this->caption = '';
        $this->lignes   = array();//["title","titre1"]["data","titre2"] : tableau de Table_Ligne
        $this->nbligne;
        $this->id = $id;

    }

    public function caption($caption){
        $this->caption = $caption;
    }
    public function add_new_row(){
        $array_args = func_get_args();
        
        $this->lignes[] = new Table_Ligne($array_args);
    }

    public function  __toString() {
        $o = '<table> </table>';
        return $o;
    }
}

class Table_Ligne{
    protected $ligne;
    public function __construct($cellules) {
        $this->ligne = array();
        foreach ($cellules as $cellule){
            $cellule = new Table_Cellule(   $cellule->getKey(),
                                            $cellule->getValue(),
                                            $cellule->getAttributs());
            $this->add_cell($cellule);
        }
    }
    public function add_cell($cellule){
        $this->ligne[] = $cellule;
    }

    public function __toString() {
        '<tr>'.$this->ligne.'</tr>';
    }
}

class Table_Cellule{
    protected $key;
    protected $value;
    protected $attributs;

    public function __construct($key, $value, $attributs = '') {
        $this->attributs = $attributs;
        $this->key       = $key;
        $this->value     = $value;
    }
    
    public function __toString() {
        //attributs a voir
        $o = '<'.$this->key.' '.$this->attributs.'>'.$this->value.'</'.$this->key.'>';
        
        return $o;
    }
    public function getKey(){
        return $this->key;
    }
    public function getValue(){
        return $this->value;
    }
    public function getAttributs(){
        return $this->attributs;
    }
}
?>
