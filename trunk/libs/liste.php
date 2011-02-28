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
        if ($this->type != 0 or $this->type != 1){
            throw new Exception('Pas Cool');
        }
        $values[] = $value;
    }

    public function add_values($therme, $definition){
        $thermes[]     = $therme;
        $definitions[] = $definition;
    }

    public function __toString() {
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


        return $o;
    }
}

?>
