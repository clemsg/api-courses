<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace ProduitsApi;

use Doctrine\DBAL\Connection;

/**
 * Description of ProduitDAO
 *
 * @author clems
 */
class ProduitsDAO {
    
    private $db;

    public function __construct(Connection $db)
    {
            $this->db = $db;
    }

    protected function getDb()
    {
            return $this->db;
    }

    public function findAll()
    {
            $sql = "SELECT * FROM produits";
            $result = $this->getDb()->fetchAll($sql);

            $entities = array();
            foreach ( $result as $row ) {
                    $id = $row['id'];
                    $entities[$id] = $this->buildDomainObjects($row);
            }

            return $entities;
    }

    public function find($id)
    {
            $sql = "SELECT * FROM produits WHERE id=?";
            $row = $this->getDb()->fetchAssoc($sql, array($id));

            if ($row) {
                    return $this->buildDomainObjects($row);
            } else {
                    return null;
            }
    }

    public function save(Produits $produits)
    {
            $produitsData = array(
                    'code_barre' => $produits->getCodeBarre(),
                    'nom' => $produits->getNom(),
                    'duree' => $produits->getDuree(),
                    'date' => $produits->getDate()
            );

            // TODO CHECK
            if ($produits->getId()) {
                    $this->getDb()->update('produits', $produitsData, array('id' => $produits->getId()));
            } else {
                    $this->getDb()->insert('produits', $produitsData);
                    $id = $this->getDb()->lastInsertId();
                    $produits->setId($id);
            }
    }

    public function delete($id)
    {
            $this->getDb()->delete('produits', array('id' => $id));
    }

    protected function buildDomainObjects($row)
    {
            $produits = new Produits();
            $produits->setId($row['id']);
            $produits->setCodeBarre($row['code_barre']);
            $produits->setNom($row['nom']);
            $produits->setDuree($row['duree']);

            return $produits;
    }
}
