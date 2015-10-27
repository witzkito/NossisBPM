<?php

namespace Nossis\NossisBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * EnvaseEmpresa
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="Nossis\NossisBundle\Entity\Repository\EnvaseEmpresaRepositorio")
 */
class EnvaseEmpresa
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
     * @ORM\Column(name="direccion", type="string", length=255, nullable = true)
     */
    private $direccion;

    /**
     * @var string
     *
     * @ORM\Column(name="telefono", type="string", length=255, nullable = true)
     */
    private $telefono;

    /**
     * @ORM\ManyToOne(targetEntity="Ciudad", inversedBy="clientes")
     * @ORM\JoinColumn(name="ciudad", referencedColumnName="id")
     */
    private $ciudad;
    
    /**
     * @ORM\OneToMany(targetEntity="EnvaseIngreso", mappedBy="empresa")
     */
    protected $envases;


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
     * @return EnvaseEmpresa
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
     * Constructor
     */
    public function __construct()
    {
        $this->emvases = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Set direccion
     *
     * @param string $direccion
     * @return EnvaseEmpresa
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
     * @return EnvaseEmpresa
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
     * @return EnvaseEmpresa
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
     * Add envases
     *
     * @param \Nossis\NossisBundle\Entity\EnvaseIngresa $envases
     * @return EnvaseEmpresa
     */
    public function addEnvase(\Nossis\NossisBundle\Entity\EnvaseIngreso $envases)
    {
        $this->envases[] = $envases;

        return $this;
    }

    /**
     * Remove envases
     *
     * @param \Nossis\NossisBundle\Entity\EnvaseIngresa $envases
     */
    public function removeEnvase(\Nossis\NossisBundle\Entity\EnvaseIngreso $envases)
    {
        $this->envases->removeElement($envases);
    }

    /**
     * Get envases
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getEnvases()
    {
        return $this->envases;
    }
    
    public function __toString()
    {
        return $this->nombre;
    }
}
