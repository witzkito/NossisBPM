<?php

namespace Nossis\NossisBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * EnvaseRetiro
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="Nossis\NossisBundle\Entity\Repositorio\EnvaseRetiroRepository")
 */
class EnvaseRetiro
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
     * @var integer
     *
     * @ORM\Column(name="cantidad", type="decimal", scale=2)
     */
    private $cantidad;
    
    /**
     *
     * @var string
     * @ORM\Column(name="lote_destino", type="string", length=100)
     */
    private $loteDestino;
    
    
    /**
     * @ORM\ManyToOne(targetEntity="Stock", inversedBy="envases")
     * @ORM\JoinColumn(name="stock", referencedColumnName="id")
     */
    private $stock;
    
    /**
     * @ORM\ManyToOne(targetEntity="EnvaseIngreso", inversedBy="retiros")
     * @ORM\JoinColumn(name="envase_ingreso", referencedColumnName="id")
     */
    private $envase;
    
    


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
     * @return EnvaseRetiro
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
     * Set cantidad
     *
     * @param integer $cantidad
     * @return EnvaseRetiro
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
     * @return EnvaseRetiro
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
     * Set envase
     *
     * @param \Nossis\NossisBundle\Entity\EnvaseIngreso $envase
     * @return EnvaseRetiro
     */
    public function setEnvase(\Nossis\NossisBundle\Entity\EnvaseIngreso $envase = null)
    {
        $this->envase = $envase;

        return $this;
    }

    /**
     * Get envase
     *
     * @return \Nossis\NossisBundle\Entity\EnvaseIngreso 
     */
    public function getEnvase()
    {
        return $this->envase;
    }

    /**
     * Set loteDestino
     *
     * @param string $loteDestino
     * @return EnvaseRetiro
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
