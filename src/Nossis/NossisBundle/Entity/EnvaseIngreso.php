<?php

namespace Nossis\NossisBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * EnvaseIngreso
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="Nossis\NossisBundle\Entity\Repositorio\EnvaseIngresoRepository")
 */
class EnvaseIngreso
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
     * @var string
     *
     * @ORM\Column(name="lote", type="string", length=100)
     */
    private $lote;

    /**
     * @var integer
     *
     * @ORM\Column(name="cantidad", type="integer")
     */
    private $cantidad;
    
    /**
     * @ORM\ManyToOne(targetEntity="Envase", inversedBy="ingresos")
     * @ORM\JoinColumn(name="envase", referencedColumnName="id")
     */
    private $envase;
    
    /**
     * @var datetime
     *
     * @ORM\Column(name="fecha", type="datetime")
     */
    private $fecha;
    
    /**
     * @ORM\OneToMany(targetEntity="EnvaseRetiro", mappedBy="envase")
     */
    private $retiros;


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
     * Set lote
     *
     * @param string $lote
     * @return EnvaseIngreso
     */
    public function setLote($lote)
    {
        $this->lote = $lote;

        return $this;
    }

    /**
     * Get lote
     *
     * @return string 
     */
    public function getLote()
    {
        return $this->lote;
    }

    /**
     * Set cantidad
     *
     * @param integer $cantidad
     * @return EnvaseIngreso
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
     * Set envase
     *
     * @param \Nossis\NossisBundle\Entity\Envase $envase
     * @return EnvaseIngreso
     */
    public function setEnvase(\Nossis\NossisBundle\Entity\Envase $envase = null)
    {
        $this->envase = $envase;

        return $this;
    }

    /**
     * Get envase
     *
     * @return \Nossis\NossisBundle\Entity\Envase 
     */
    public function getEnvase()
    {
        return $this->envase;
    }

    /**
     * Set fecha
     *
     * @param \DateTime $fecha
     * @return EnvaseIngreso
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
     * Constructor
     */
    public function __construct()
    {
        $this->retiros = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add retiros
     *
     * @param \Nossis\NossisBundle\Entity\EnvaseRetiro $retiros
     * @return EnvaseIngreso
     */
    public function addRetiro(\Nossis\NossisBundle\Entity\EnvaseRetiro $retiros)
    {
        $this->retiros[] = $retiros;

        return $this;
    }

    /**
     * Remove retiros
     *
     * @param \Nossis\NossisBundle\Entity\EnvaseRetiro $retiros
     */
    public function removeRetiro(\Nossis\NossisBundle\Entity\EnvaseRetiro $retiros)
    {
        $this->retiros->removeElement($retiros);
    }

    /**
     * Get retiros
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getRetiros()
    {
        return $this->retiros;
    }
    
    public function __toString() {
        return $this->getLote();
    }
    
    /**
     * Devuelve el total de envases actuales
     * @return integer
     */
    public function getTotal()
    {
        $cantidad = $this->cantidad;
        foreach ($this->getRetiros() as $retiro){
            $cantidad = $cantidad - $retiro->getCantidad();
        }
        return $cantidad;
    }
}
