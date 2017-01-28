<?php

namespace ProduitsApi;

class Produits {
    
    /**
    * @var integer
    */
    private $id;

   /**
    * @var string
    */
    private $codeBarre;

    /**
     * @var string
     */
    private $nom;
    
    private $duree;
    
    private $date;
    
    public function __construct() {
        $date = new \DateTime();
        $this->date = $date->format('Y-m-d \\ H:i:s');
    }


    /**
     * @return int
     */
    public function getId() {
            return $this->id;
    }

    /**
     * @param int $id
     */
    public function setId( $id ) {
            $this->id = $id;
    }

    /**
     * @return string
     */
    public function getCodeBarre() {
            return $this->codeBarre;
    }

    /**
     * @param string $firstname
     */
    public function setCodeBarre( $codeBarre ) {
            $this->codeBarre = $codeBarre;
    }

    /**
     * @return string
     */
    public function getNom() {
            return $this->nom;
    }

    /**
     * @param string $lastname
     */
    public function setNom( $nom ) {
            $this->nom = $nom;
    }
    
    public function getDuree(){
        return $this->duree;
    }
    
    public function setDuree($duree){
        
        $this->duree = $duree;
    }
    
    public function getDate(){
        return $this->date;
    }
    
    public function setDate($date){
        $this->date = $date;
    }
    
}
