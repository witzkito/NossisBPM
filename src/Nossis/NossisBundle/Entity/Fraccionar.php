<?php

namespace Nossis\NossisBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Fraccionar
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="Nossis\NossisBundle\Entity\Repositorio\FraccionarRepository")
 */
class Fraccionar
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
     * @var \DateTime
     *
     * @ORM\Column(name="fecha", type="datetime")
     */
    private $fecha;
    
    /**
     * @ORM\ManyToOne(targetEntity="Stock", inversedBy="fraccionados")
     * @ORM\JoinColumn(name="stock_id", referencedColumnName="id")
     */
    private $stock;
    
    /** 
     * @ORM\OneToOne(targetEntity="Stock") 
     */
    private $stockDestino;
    
    public $producto;


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
     *
     * @return Fraccionar
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
     * Set fecha
     *
     * @param \DateTime $fecha
     *
     * @return Fraccionar
     */
    public function setFecha($fecha)
    {
        $this->fecha = $fecha;

        return $this;
    }

    /**
     * Get fecha
     *
     * @return \DateTime
     */
    public function getFecha()
    {
        return $this->fecha;
    }

    /**
     * Set stock
     *
     * @param \Nossis\NossisBundle\Entity\Stock $stock
     *
     * @return Fraccionar
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
     * Set stockDestino
     *
     * @param \Nossis\NossisBundle\Entity\Stock $stockDestino
     *
     * @return Fraccionar
     */
    public function setStockDestino(\Nossis\NossisBundle\Entity\Stock $stockDestino = null)
    {
        $this->stockDestino = $stockDestino;

        return $this;
    }

    /**
     * Get stockDestino
     *
     * @return \Nossis\NossisBundle\Entity\Stock
     */
    public function getStockDestino()
    {
        return $this->stockDestino;
    }
    
    
}
