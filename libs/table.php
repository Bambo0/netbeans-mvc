<?php

class Table{

    protected $caption;
    protected $en_tete;//tableau de th
    protected $att_en_tete;//garde les attributs des en tetes
    protected $lignes;//tableau de Table_Ligne
    protected $alternance;
    // si = 0 non sinon alternance des id de ligne (ex css : blanc/gris)
    protected $ordre;
    //0 : normal, 1 : croissant premiere colonne, -1 decroissant premiere colone
    protected $ordreliste;//stock la colonne a trier
    protected $id;//string utilisable pour le css

    public function  __construct($id, $alternance = 0, $ordre = 0) {
        $this->caption    = '';
        $this->lignes     = array();
        $this->numLigne   = 0;
        $this->id         = $id;
        $this->alternance = $alternance;
        
        if (isset($_GET['numCol'])){
            $this->ordre  = $_GET['numCol'];
        } else {
            $this->ordre  = $ordre;
        }
        
    }
    
    public function add_en_tete(){
        $value_args = func_get_args();
        //creation des cellules
        $numCol = 0;
        foreach ($value_args as $value) {
            if ($this->ordre == 0){
                $tempCell = new Table_Cellule($value, 'th');
            } else {
                $tempCell = new Table_Cellule($value, 'th', 1, $numCol);
            }
            $tempCells[] = $tempCell;
            $numCol++;
        }
        $this->en_tete = new Table_Ligne($tempCells);
    }

    public function add_att_en_tete($numCol, $attributs){
        $this->en_tete->getCell($numCol-1)->setAttributs($attributs);
        //$this->att_en_tete[$numCol] = $attributs;
    }

    public function add_ligne(){
        $value_args = func_get_args();
        //creation des cellules
        $cptTri = 0;
        foreach ($value_args as $value) {
            //mise en place du tri
            if (abs($this->ordre) - 1 == $cptTri){
                $this->ordreliste[] = $value;
            }
            $tempCell    = new Table_Cellule($value);
            $tempCells[] = $tempCell;
            $cptTri++;
        }
        $this->lignes[] = new Table_Ligne($tempCells);
    }

    public function  __toString() {
        if ($this->ordre != 0){
            array_multisort($this->ordreliste, $this->lignes);
        }

        if ($this->ordre < 0){
            $this->lignes = array_reverse($this->lignes);
        }

        $o = '<table id="'.$this->id.'">'."\n";

        if (!empty($this->caption)){
            $o .= "\t".'<caption>'.
                            $this->caption.
                       '</caption>'."\n";
        }

        if (!empty($this->en_tete)){
            //ajouter attributs
            $o .= $this->en_tete;
        }
        $cptLigne = 0;
        foreach ($this->lignes as $value) {
            if ($this->alternance == 1){
                $o .= $this->mettreAlternance($value, $cptLigne);
                $cptLigne ++;
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

    public function caption($caption){
        $this->caption = $caption;
    }

    public function getLigneNumero($numLigne){
        return $this->lignes[$numLigne];
    }
}

class Table_Ligne{

    protected $ligne;
    protected $attributs;

    public function __construct($cellules) {
        $this->ligne     = array();
        $this->attributs = '';
        foreach ($cellules as $cellule){
            $this->add_cell($cellule);
        }
    }

    public function __toString() {
        $o = "\t".'<tr '.$this->attributs.'>'."\n";
        foreach ($this->ligne as $value) {
            $o .= $value;
        }
        $o .= "\t".'</tr>'."\n";
        return $o;
    }

    public function add_attributs($attributs){
        $this->attributs = $attributs;
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
    protected $balise;
    protected $value;
    protected $attributs;
    protected $fleche;
    protected $numCol;

    public function __construct($value, 
                                $balise = 'td',
                                $fleche = 0,
                                $numCol = 0) {
        
        $this->attributs = '';
        $this->balise    = $balise;
        $this->value     = $value;
        $this->fleche    = $fleche;
        $this->numCol    = $numCol;
    }
    
    public function __toString() {
        $o  = "\t"."\t".'<'.$this->balise.' '.$this->attributs.'>'.$this->value;
        if ($this->fleche != 0){
            $o .= '<a href="';
            $o .= recupereURLsansFleche($_SERVER['REQUEST_URI']);
            $o .= '&amp;numCol='.($this->numCol+1).'">'.
                        '<img src="'.CHEMIN_IMAGES.'flecheD.png"/>'.
                    '</a>';
            $o .= '<a href="';
            $o .= recupereURLsansFleche($_SERVER['REQUEST_URI']);
            $o .= '&amp;numCol=-'.($this->numCol+1).'">'.
                        '<img src="'.CHEMIN_IMAGES.'flecheC.png"/>'.
                    '</a>';
        }
        $o .= '</'.$this->balise.'>'."\n";

        return $o;
    }
    public function getBalise(){
        return $this->balise;
    }
    public function getValue(){
        return $this->value;
    }
    public function setAttributs($attributs){
        $this->attributs = $attributs;
    }
}

function recupereURLsansFleche($url) {
    include_once CHEMIN_LIB.'string.php';

    if (!contains('numCol=', $url)){
        $o2 = $url;
    } else {
        $tabExplode = explode('&', $url);
        //print_r($tabExplode);
        $o2 = $tabExplode[0];
        for ($index = 1; $index < count($tabExplode)-1; $index++) {
            $o2 .= '&amp;'.$tabExplode[$index];
        }
    }
    return $o2;
}
?>
