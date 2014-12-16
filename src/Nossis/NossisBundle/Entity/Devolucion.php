<?php

namespace Nossis\NossisBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Devolucion
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="Nossis\NossisBundle\Entity\Repositorio\DevolucionRepository")
 */
class Devolucion
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
     * @var \DateTime
     *
     * @ORM\Column(name="fecha", type="datetime")
     */
    private $fecha;

    /**
     * @var string
     *
     * @ORM\Column(name="motivo", type="text")
     */
    private $motivo;
    
    /**
     * @var integer
     * @orm\Column(name="cantidad", type="integer")
     */
    private $cantidad;
    
    /**
     * @ORM\ManyToOne(targetEntity="RetiroStock", inversedBy="devoluciones")
     * @ORM\JoinColumn(name="stock", referencedColumnName="id")
     */
    private $retiroStock;
    
    


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
     * Set fecha
     *
     * @param \DateTime $fecha
     * @return Devolucion
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
     * Set motivo
     *
     * @param string $motivo
     * @return Devolucion
     */
    public function setMotivo($motivo)
    {
        $this->motivo = $motivo;

        return $this;
    }

    /**
     * Get motivo
     *
     * @return string 
     */
    public function getMotivo()
    {
        return $this->motivo;
    }

    /**
     * Set cantidad.

     *
     * @param integer $cantidad
     *
     * @return Devolucion
     */
    public function setCantidad($cantidad)
    {
        $this->cantidad = $cantidad;

        return $this;
    }

    /**
     * Get cantidad.

     *
     * @return integer
     */
    public function getCantidad()
    {
        return $this->cantidad;
    }

    /**
     * Set retiroStock.

     *
     * @param \Nossis\NossisBundle\Entity\RetiroStock $retiroStock
     *
     * @return Devolucion
     */
    public function setRetiroStock(\Nossis\NossisBundle\Entity\RetiroStock $retiroStock = null)
    {
        $this->retiroStock = $retiroStock;

        return $this;
    }

    /**
     * Get retiroStock.

     *
     * @return \Nossis\NossisBundle\Entity\RetiroStock
     */
    public function getRetiroStock()
    {
        return $this->retiroStock;
    }
}
