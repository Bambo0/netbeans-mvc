<?php

class Table{

    protected $caption;
    protected $lignes;
    protected $numLigne;
    protected $alternance;
    // si = 0 non sinon alternance des id de ligne (ex css : blanc/gris)
    protected $id;//string utilisable pour le css

    public function  __construct($id, $alternance = 0) {
        $this->caption    = '';
        $this->lignes     = array();
        //array("title","titre1"), array("data","titre2") : tableau de Table_Ligne
        $this->numLigne   = 0;
        $this->id         = $id;
        $this->alternance = $alternance;
    }
    
    public function add_new_row(){
        $array_args = func_get_args();
        foreach ($array_args as $value) {
            if (count($value) == 3){
                $tempCell = new Table_Cellule($value[0], $value[1], $value[2]);
            } else {
                $tempCell = new Table_Cellule($value[0], $value[1]);
            }
            $tempCells[] = $tempCell;
        }
        if ($this->alternance == 0){
            $this->lignes[] = new Table_Ligne($tempCells);
        } else {
            $this->lignes[] = new Table_Ligne($tempCells, $this->numLigne);
        }
        $this->numLigne ++;
    }

    public function  __toString() {
        $o = '<table id="'.$this->id.'">';

        if (!empty($this->caption)){
            $o .= '<caption>'.$this->caption.'</caption>';
        }

        foreach ($this->lignes as $value) {
            $o .= $value;
        }

        $o .= '</table>';
        return $o;
    }

    public function caption($caption){
        $this->caption = $caption;
    }
}

class Table_Ligne{

    protected $ligne;
    protected $numLigne;

    public function __construct($cellules, $numLigne = -1) {
        $this->numLigne = $numLigne;
        $this->ligne    = array();

        foreach ($cellules as $cellule){
            $celluleTmp = new Table_Cellule($cellule->getKey(),
                                            $cellule->getValue(),
                                            $cellule->getAttributs());
            $this->add_cell($celluleTmp);
        }
    }

    public function __toString() {
        if ($this->numLigne == -1){
            $o = '<tr>';
        } else if (($this->numLigne%2) == 0){
            $o = '<tr class="ligneP">';
        } else {
            $o = '<tr class="ligneI">';
        }

        foreach ($this->ligne as $value) {
            $o .= $value;
        }

        $o .= '</tr>';
        return $o;
    }
    
    public function add_cell($cellule){
        $this->ligne[] = $cellule;
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
