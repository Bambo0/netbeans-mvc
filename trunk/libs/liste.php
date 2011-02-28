<?php
class Liste{

    protected $id;
    protected $type;//0: liste, 1:numéroté, 2:definition
    protected $values;
    protected $thermes;
    protected $definitions;

    public function __construct($id, $type = 0) {
        $this->id   = $id;
        $this->type = $type;

    }

    public function add_value($value){
        if ($this->type != 0 and $this->type != 1){
            throw new Exception("L'ajout de valeur par cette methode n'est pas autorisé
                dans ce type de la liste.");
        }
        $this->values[] = $value;
    }

    public function add_values($therme, $definition){
        if ($this->type != 2){
            throw new Exception("L'ajout de valeur par cette methode n'est pas autorisé
                dans ce type de la liste.");
        }
        $this->thermes[]     = $therme;
        $this->definitions[] = $definition;
    }

    public function __toString() {
        //$o = 'hop';
        switch ($this->type){
            case 0:
                $debut     = '<ul id="'.$this->id.'">';
                $fin       = '</ul>';
                $deb_ligne = '<li>';
                $fin_ligne = '</li>';
                break;
            case 1:
                $debut     = '<ol id="'.$this->id.'">';
                $fin       = '</ol>';
                $deb_ligne = '<li>';
                $fin_ligne = '</li>';
                break;
            case 2:
                $debut      = '<dl id="'.$this->id.'">';
                $fin        = '</dl>';
                $deb_therme = '<dt>';
                $fin_therme = '</dt>';
                $deb_def    = '<dd>';
                $fin_def    = '</dd>';
                break;
        }

        switch ($this->type){
            case 0:
            case 1:
                $o = $debut;
                foreach ($this->values as $value) {
                    $o .= $deb_ligne . $value . $fin_ligne;
                }
                $o .= $fin;
                break;
            case 2:
                $o = $debut;
                for ($i = 0; $i < count($this->thermes); $i++ ){
                    $o .= $deb_therme . $this->thermes[$i]     . $fin_therme;
                    $o .= $deb_def    . $this->definitions[$i] . $fin_def;
                }
                $o .= $fin;
                break;
        }

        return $o;
    }
}

?>
