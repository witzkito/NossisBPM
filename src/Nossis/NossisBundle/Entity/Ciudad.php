<?php

namespace Nossis\NossisBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Ciudad
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="Nossis\NossisBundle\Entity\CiudadRepository")
 */
class Ciudad
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
     * @ORM\Column(name="nombre", type="string", length=150)
     */
    private $nombre;
    
    /**
     * @var string
     *
     * @ORM\Column(name="cp", type="string", length=10)
     */
    private $codigopostal;
    
    /**
     * @var string
     *
     * @ORM\Column(name="provincia", type="string", length=100)
     */
    private $provincia;

    /**
     * @var float
     *
     * @ORM\Column(name="latitud", type="float")
     */
    private $latitud;

    /**
     * @var float
     *
     * @ORM\Column(name="longitud", type="float")
     */
    private $longitud;
    
    /**
     * @ORM\ManyToOne(targetEntity="Pais", inversedBy="ciudades")
     * @ORM\JoinColumn(name="pais", referencedColumnName="id")
     */
    private $pais;
    
    /**
     * @ORM\OneToMany(targetEntity="Cliente", mappedBy="clientes")
     */
    protected $clientes;


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
     * @return Ciudad
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
     * Set latitud
     *
     * @param float $latitud
     * @return Ciudad
     */
    public function setLatitud($latitud)
    {
        $this->latitud = $latitud;

        return $this;
    }

    /**
     * Get latitud
     *
     * @return float 
     */
    public function getLatitud()
    {
        return $this->latitud;
    }

    /**
     * Set longitud
     *
     * @param float $longitud
     * @return Ciudad
     */
    public function setLongitud($longitud)
    {
        $this->longitud = $longitud;

        return $this;
    }

    /**
     * Get longitud
     *
     * @return float 
     */
    public function getLongitud()
    {
        return $this->longitud;
    }

    /**
     * Set pais
     *
     * @param \Nossis\NossisBundle\Entity\Pais $pais
     * @return Ciudad
     */
    public function setPais(\Nossis\NossisBundle\Entity\Pais $pais = null)
    {
        $this->pais = $pais;

        return $this;
    }

    /**
     * Get pais
     *
     * @return \Nossis\NossisBundle\Entity\Pais 
     */
    public function getPais()
    {
        return $this->pais;
    }

    /**
     * Set codigopostal
     *
     * @param string $codigopostal
     * @return Ciudad
     */
    public function setCodigopostal($codigopostal)
    {
        $this->codigopostal = $codigopostal;

        return $this;
    }

    /**
     * Get codigopostal
     *
     * @return string 
     */
    public function getCodigopostal()
    {
        return $this->codigopostal;
    }

    /**
     * Set provincia
     *
     * @param string $provincia
     * @return Ciudad
     */
    public function setProvincia($provincia)
    {
        $this->provincia = $provincia;

        return $this;
    }

    /**
     * Get provincia
     *
     * @return string 
     */
    public function getProvincia()
    {
        return $this->provincia;
    }
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->clientes = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add clientes
     *
     * @param \Nossis\NossisBundle\Entity\Cliente $clientes
     * @return Ciudad
     */
    public function addCliente(\Nossis\NossisBundle\Entity\Cliente $clientes)
    {
        $this->clientes[] = $clientes;

        return $this;
    }

    /**
     * Remove clientes
     *
     * @param \Nossis\NossisBundle\Entity\Cliente $clientes
     */
    public function removeCliente(\Nossis\NossisBundle\Entity\Cliente $clientes)
    {
        $this->clientes->removeElement($clientes);
    }

    /**
     * Get clientes
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getClientes()
    {
        return $this->clientes;
    }
    
    public function __toString() {
        return $this->nombre ." - ". $this->provincia." - ".$this->pais;
    }
}
