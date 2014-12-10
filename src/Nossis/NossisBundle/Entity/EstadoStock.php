<?php

namespace Nossis\NossisBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * RetiroStock
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="Nossis\NossisBundle\Entity\Repositorio\EstadoStockRepository")
 */
class EstadoStock
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
     * @ORM\Column(name="descripcion", type="text")
     */
    private $descripcion;
    
    /**
     * @var \DateTime
     *
     * @ORM\Column(name="fecha", type="datetime")
     */
    private $fecha;
    
    /**
     * @ORM\ManyToOne(targetEntity="Stock", inversedBy="estados")
     * @ORM\JoinColumn(name="stock", referencedColumnName="id")
     */
    private $stock;
    
    /**
     * @ORM\Column(name="estado", type="text")
     */
    private $estado;


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

    /**
     * Set descripcion
     *
     * @param string $descripcion
     *
     * @return EstadoStock
     */
    public function setDescripcion($descripcion)
    {
        $this->descripcion = $descripcion;

        return $this;
    }

    /**
     * Get descripcion
     *
     * @return string 
     */
    public function getDescripcion()
    {
        return $this->descripcion;
    }

    
    /**
     * Set fecha
     *
     * @param \DateTime $fecha
     *
     * @return EstadoStock
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
     * Set estado.

     *
     * @param string $estado
     *
     * @return EstadoStock
     */
    public function setEstado($estado)
    {
        $this->estado = $estado;

        return $this;
    }

    /**
     * Get estado.

     *
     * @return string
     */
    public function getEstado()
    {
        return $this->estado;
    }
}
