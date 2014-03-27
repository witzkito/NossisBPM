<?php

namespace Nossis\NossisBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Retiro
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="Nossis\NossisBundle\Entity\Repositorio\RetiroRepository")
 */
class Retiro
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
     * @ORM\Column(name="fecha_salida", type="datetime")
     */
    private $fechaSalida;

    /**
     * @var string
     *
     * @ORM\Column(name="nro_orden", type="string", length=255)
     */
    private $nroOrden;

    /**
     * @var string
     *
     * @ORM\Column(name="patente", type="string", length=255)
     */
    private $patente;


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
     * Set fechaSalida
     *
     * @param \DateTime $fechaSalida
     * @return Retiro
     */
    public function setFechaSalida($fechaSalida)
    {
        $this->fechaSalida = $fechaSalida;

        return $this;
    }

    /**
     * Get fechaSalida
     *
     * @return \DateTime 
     */
    public function getFechaSalida()
    {
        return $this->fechaSalida;
    }

    /**
     * Set nroOrden
     *
     * @param string $nroOrden
     * @return Retiro
     */
    public function setNroOrden($nroOrden)
    {
        $this->nroOrden = $nroOrden;

        return $this;
    }

    /**
     * Get nroOrden
     *
     * @return string 
     */
    public function getNroOrden()
    {
        return $this->nroOrden;
    }

    /**
     * Set patente
     *
     * @param string $patente
     * @return Retiro
     */
    public function setPatente($patente)
    {
        $this->patente = $patente;

        return $this;
    }

    /**
     * Get patente
     *
     * @return string 
     */
    public function getPatente()
    {
        return $this->patente;
    }
}
