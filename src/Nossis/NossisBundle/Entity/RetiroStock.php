<?php

namespace Nossis\NossisBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * RetiroStock
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="Nossis\NossisBundle\Entity\Repositorio\RetiroStockRepository")
 */
class RetiroStock
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var integer
     *
     * @ORM\Column(name="cantidad", type="integer")
     */
    private $cantidad;
    
    /**
     * @ORM\ManyToOne(targetEntity="Stock", inversedBy="retiros")
     * @ORM\JoinColumn(name="stock", referencedColumnName="id")
     */
    private $stock;
    
    /**
     * @ORM\ManyToOne(targetEntity="Retiro", inversedBy="stocks")
     * @ORM\JoinColumn(name="retiro", referencedColumnName="id")
     */
    private $retiro;


    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set cantidad
     *
     * @param integer $cantidad
     * @return RetiroStock
     */
    public function setCantidad($cantidad)
    {
        $this->cantidad = $cantidad;

        return $this;
    }

    /**
     * Get cantidad
     *
     * @return integer 
     */
    public function getCantidad()
    {
        return $this->cantidad;
    }

    /**
     * Set stock
     *
     * @param \Nossis\NossisBundle\Entity\Stock $stock
     * @return RetiroStock
     */
    public function setStock(\Nossis\NossisBundle\Entity\Stock $stock = null)
    {
        $this->stock = $stock;

        return $this;
    }

    /**
     * Get stock
     *
     * @return \Nossis\NossisBundle\Entity\Stock 
     */
    public function getStock()
    {
        return $this->stock;
    }

    /**
     * Set retiro
     *
     * @param \Nossis\NossisBundle\Entity\Retiro $retiro
     * @return RetiroStock
     */
    public function setRetiro(\Nossis\NossisBundle\Entity\Retiro $retiro = null)
    {
        $this->retiro = $retiro;

        return $this;
    }

    /**
     * Get retiro
     *
     * @return \Nossis\NossisBundle\Entity\Retiro 
     */
    public function getRetiro()
    {
        return $this->retiro;
    }
    
    public function __toString() {
        return "NO ESTOY RETORNANDO BIEN!!";
    }
}
