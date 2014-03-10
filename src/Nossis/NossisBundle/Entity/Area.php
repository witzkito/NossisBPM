<?php

namespace Nossis\NossisBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Area
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="Nossis\NossisBundle\Entity\AreaRepository")
 */
class Area
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
     * @ORM\Column(name="nombre", type="string", length=255)
     */
    private $nombre;

    /**
     * @var boolean
     *
     * @ORM\Column(name="salida", type="boolean")
     */
    private $salida;
    
    /**
     * @var integer
     * @ORM\Column(name="capacidad", type="integer") 
     */
    private $capacidad;
    
     /**
     * @ORM\ManyToOne(targetEntity="Almacen", inversedBy="areas")
     * @ORM\JoinColumn(name="almacen", referencedColumnName="id")
     */
    private $almacen;
    


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
     * Set nombre
     *
     * @param string $nombre
     * @return Area
     */
    public function setNombre($nombre)
    {
        $this->nombre = $nombre;

        return $this;
    }

    /**
     * Get nombre
     *
     * @return string 
     */
    public function getNombre()
    {
        return $this->nombre;
    }

    /**
     * Set salida
     *
     * @param boolean $salida
     * @return Area
     */
    public function setSalida($salida)
    {
        $this->salida = $salida;

        return $this;
    }

    /**
     * Get salida
     *
     * @return boolean 
     */
    public function getSalida()
    {
        return $this->salida;
    }

    /**
     * Set capacidad
     *
     * @param integer $capacidad
     * @return Area
     */
    public function setCapacidad($capacidad)
    {
        $this->capacidad = $capacidad;

        return $this;
    }

    /**
     * Get capacidad
     *
     * @return integer 
     */
    public function getCapacidad()
    {
        return $this->capacidad;
    }

    /**
     * Set almacen
     *
     * @param \Nossis\NossisBundle\Entity\Almacen $almacen
     * @return Area
     */
    public function setAlmacen(\Nossis\NossisBundle\Entity\Almacen $almacen = null)
    {
        $this->almacen = $almacen;

        return $this;
    }

    /**
     * Get almacen
     *
     * @return \Nossis\NossisBundle\Entity\Almacen 
     */
    public function getAlmacen()
    {
        return $this->almacen;
    }
}
