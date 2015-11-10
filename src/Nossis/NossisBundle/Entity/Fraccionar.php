<?php

namespace Nossis\NossisBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use APY\DataGridBundle\Grid\Mapping as GRID;

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
     * @GRID\Column(title="Nro.",filterable=false)
     */
    private $id;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="fecha", type="datetime")
     * @GRID\Column(title="Fecha",filterable=true)
     */
    private $fecha;
    
    /**
     * @ORM\ManyToOne(targetEntity="Stock", inversedBy="fraccionados")
     * @ORM\JoinColumn(name="stock_id", referencedColumnName="id")
     * @GRID\Column(title="Stock", field="stock.producto.nombre", filterable=true)
     */
    private $stock;
    
     /**
     * @var integer
     *
     * @ORM\Column(name="cantidad", type="decimal", scale=2)
     * @GRID\Column(title="Cantidad",filterable=true)
     */
    private $cantidad;
    
    /**
     * @var integer
     *
     * @ORM\Column(name="lotedestino", type="string", nullable=true)
     */
    private $loteDestino;
        
    /** 
     * @ORM\OneToOne(targetEntity="Stock") 
     * @GRID\Column(title="Stock Destino", field="stockDestino.producto.nombre", filterable=true)
     */
    private $stockDestino;
    
    /**
     * @GRID\Column(title="Cantidad Destino", field="stockDestino.ingresado", filterable=true)
     */
    private $cantidadStockDestino;
    
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
    
    

    /**
     * Set loteDestino
     *
     * @param string $loteDestino
     * @return Fraccionar
     */
    public function setLoteDestino($loteDestino)
    {
        $this->loteDestino = $loteDestino;

        return $this;
    }

    /**
     * Get loteDestino
     *
     * @return string 
     */
    public function getLoteDestino()
    {
        return $this->loteDestino;
    }
}
