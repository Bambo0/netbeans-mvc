<?php

class Table{

    protected $caption;
    protected $lignes;
    protected $numLigne;
    protected $alternance;
    // si = 0 non sinon alternance des id de ligne (ex css : blanc/gris)
    protected $ordre;
    //0 : normal, 1 : croissant premiere colonne, -1 decroissant premiere colone
    protected $ordreliste;//stock la colonne a trier
    protected $id;//string utilisable pour le css

    public function  __construct($id, $alternance = 0, $ordre = 0) {
        $this->caption    = '';
        $this->lignes     = array();
        //array("title","titre1"), array("data","titre2") : tableau de Table_Ligne
        $this->numLigne   = 0;
        $this->id         = $id;
        $this->alternance = $alternance;
        $this->ordre      = $ordre;
    }
    
    public function add_new_row(){
        $array_args = func_get_args();
        //creation des cellules
        $cptTri = 0;
        foreach ($array_args as $value) {
            //mise en place du tri
            if (abs($this->ordre) - 1 == $cptTri){
                $this->ordreliste[] = $value[1];
            }
            if (count($value) == 3){
                $tempCell = new Table_Cellule($value[0], $value[1], $value[2]);
            } else {
                $tempCell = new Table_Cellule($value[0], $value[1]);
            }
            $tempCells[] = $tempCell;
            $cptTri++;
        }
        $this->lignes[] = new Table_Ligne($tempCells);
    }

    public function  __toString() {
        //tri du tableau
        include_once CHEMIN_LIB.'string.php';
        //if (contains($string, $content))
        /////-----------------------------------------------------
        print_r($this->ligneNumero(0)->getCell(0)->getKey());
        /////-----------------------------------------------------
        if ($this->ordre != 0){
            array_multisort($this->ordreliste, $this->lignes);
        }
        if ($this->ordre < 0){
            $this->lignes = array_reverse($this->lignes);
        }
        $o = '<table id="'.$this->id.'">'."\n";

        if (!empty($this->caption)){
            $o .= "\t".'<caption>'.$this->caption.'</caption>'."\n";
        }

        foreach ($this->lignes as $value) {
            if ($this->alternance == 1){
                $o .= $this->mettreAlternance($value, $this->numLigne);
                $this->numLigne ++;
            } else {
                $o .= $value;
            }
            
        }

        $o .= '</table>'."\n";
        return $o;
    }

    public function mettreAlternance($value, $numLigne){
        //mettre en place id="" aprés <tr [...] >
            $retour = substr($value, 0, 4);
            if ($numLigne%2 == 0){
                $retour .= ' class="ligneP"';
            } else {
                $retour .= ' class="ligneI"';
            }
            $retour .= substr($value, 4);
            return $retour;
    }

    public function ligneNumero($numLigne){
        return $this->lignes[$numLigne];
    }

    public function caption($caption){
        $this->caption = $caption;
    }
}

class Table_Ligne{

    protected $ligne;

    public function __construct($cellules) {
        $this->ligne    = array();

        foreach ($cellules as $cellule){
            $celluleTmp = new Table_Cellule($cellule->getKey(),
                                            $cellule->getValue(),
                                            $cellule->getAttributs());
            $this->add_cell($celluleTmp);
        }
    }

    public function __toString() {
        $o = "\t".'<tr>'."\n";

        foreach ($this->ligne as $value) {
            $o .= $value;
        }

        $o .= "\t".'</tr>'."\n";
        return $o;
    }
    
    public function add_cell($cellule){
        $this->ligne[] = $cellule;
    }
    public function getLine(){
        return $this->ligne;
    }
    public function getCell($numCell){
        return $this->ligne[$numCell];
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
        $o = "\t"."\t".'<'.$this->key.' '.$this->attributs.'>'.$this->value.
                        '</'.$this->key.'>'."\n";
        
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
