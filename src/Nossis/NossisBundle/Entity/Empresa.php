<?php

namespace Nossis\NossisBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Empresa
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="Nossis\NossisBundle\Entity\Repositorio\EmpresaRepository")
 */
class Empresa
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
     * @ORM\ManyToOne(targetEntity="Ciudad", inversedBy="clientes")
     * @ORM\JoinColumn(name="ciudad", referencedColumnName="id")
     */
    private $ciudad;

    /**
     * @var string
     *
     * @ORM\Column(name="direccion", type="string", length=255)
     */
    private $direccion;

    /**
     * @var string
     *
     * @ORM\Column(name="telefono", type="string", length=255)
     */
    private $telefono;
    
    /**
     * @ORM\OneToMany(targetEntity="Retiro", mappedBy="empresa")
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
     *
     * @return Empresa
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
     * Set direccion
     *
     * @param string $direccion
     *
     * @return Empresa
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
     * Set telefono
     *
     * @param string $telefono
     *
     * @return Empresa
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
     * Set ciudad
     *
     * @param \Nossis\NossisBundle\Entity\Ciudad $ciudad
     *
     * @return Empresa
     */
    public function setCiudad(\Nossis\NossisBundle\Entity\Ciudad $ciudad = null)
    {
        $this->ciudad = $ciudad;

        return $this;
    }

    /**
     * Get ciudad
     *
     * @return \Nossis\NossisBundle\Entity\Ciudad 
     */
    public function getCiudad()
    {
        return $this->ciudad;
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
     *
     * @return Empresa
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
