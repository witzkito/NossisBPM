<?php

namespace Nossis\NossisBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Transportista
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="Nossis\NossisBundle\Entity\Repositorio\TransportistaRepository")
 */
class Transportista
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
     * @ORM\Column(name="telefono", type="string", length=255)
     */
    private $telefono;

    /**
     * @var string
     *
     * @ORM\Column(name="direccion", type="string", length=255)
     */
    private $direccion;
    
     /**
     * @ORM\OneToMany(targetEntity="Retiro", mappedBy="transportista")
     */
    protected $retiros;


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
     * @return Transportista
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
     * Set telefono
     *
     * @param string $telefono
     * @return Transportista
     */
    public function setTelefono($telefono)
    {
        $this->telefono = $telefono;

        return $this;
    }

    /**
     * Get telefono
     *
     * @return string 
     */
    public function getTelefono()
    {
        return $this->telefono;
    }

    /**
     * Set direccion
     *
     * @param string $direccion
     * @return Transportista
     */
    public function setDireccion($direccion)
    {
        $this->direccion = $direccion;

        return $this;
    }

    /**
     * Get direccion
     *
     * @return string 
     */
    public function getDireccion()
    {
        return $this->direccion;
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
     * @param \Nossis\NossisBundle\Entity\Retiro $retiros
     * @return Transportista
     */
    public function addRetiro(\Nossis\NossisBundle\Entity\Retiro $retiros)
    {
        $this->retiros[] = $retiros;

        return $this;
    }

    /**
     * Remove retiros
     *
     * @param \Nossis\NossisBundle\Entity\Retiro $retiros
     */
    public function removeRetiro(\Nossis\NossisBundle\Entity\Retiro $retiros)
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
        return $this->nombre;
    }
}
