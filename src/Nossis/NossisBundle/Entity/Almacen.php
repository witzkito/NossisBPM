<?php

namespace Nossis\NossisBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Almacen
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="Nossis\NossisBundle\Entity\Repositorio\AlmacenRepository")
 */
class Almacen
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
     * @var string
     *
     * @ORM\Column(name="ubicacion", type="string", length=255)
     */
    private $ubicacion;
    
     /**
     * @ORM\OneToMany(targetEntity="Area", mappedBy="almacen")
     */
    protected $areas;


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
     * @return Almacen
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
     * Set ubicacion
     *
     * @param string $ubicacion
     * @return Almacen
     */
    public function setUbicacion($ubicacion)
    {
        $this->ubicacion = $ubicacion;

        return $this;
    }

    /**
     * Get ubicacion
     *
     * @return string 
     */
    public function getUbicacion()
    {
        return $this->ubicacion;
    }
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->areas = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add areas
     *
     * @param \Nossis\NossisBundle\Entity\Area $areas
     * @return Almacen
     */
    public function addArea(\Nossis\NossisBundle\Entity\Area $areas)
    {
        $this->areas[] = $areas;

        return $this;
    }

    /**
     * Remove areas
     *
     * @param \Nossis\NossisBundle\Entity\Area $areas
     */
    public function removeArea(\Nossis\NossisBundle\Entity\Area $areas)
    {
        $this->areas->removeElement($areas);
    }

    /**
     * Get areas
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getAreas()
    {
        return $this->areas;
    }
    
    public function __toString(){
        return $this->getNombre();
    }
}
