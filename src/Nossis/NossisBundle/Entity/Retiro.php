<?php

namespace Nossis\NossisBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use APY\DataGridBundle\Grid\Mapping as GRID;

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
     * @GRID\Column(title="Id", filterable=false)
     */
    private $id;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="fecha_salida", type="datetime")
     * @GRID\Column(title="Fecha Salida", filterable=true)
     */
    private $fechaSalida;

    /**
     * @var string
     *
     * @ORM\Column(name="nro_orden", type="string", length=255, nullable=true)
     * @GRID\Column(title="Numero Orden", filterable=true)
     */
    private $nroOrden;

    /**
     * @var string
     *
     * @ORM\Column(name="patente", type="string", length=255, nullable=true)
     * @GRID\Column(title="Patente", filterable=true)
     */
    private $patente;
    
    
     /**
     * @ORM\OneToMany(targetEntity="RetiroStock", mappedBy="retiro", cascade={"persist"})
     */
    protected $stocks;
    
    /**
     * @var string
     *
     * @ORM\Column(name="transportista", type="string", length=100)
     */
    private $transportista;
    
    /**
     * @ORM\ManyToOne(targetEntity="Cliente", inversedBy="retiros")
     * @ORM\JoinColumn(name="cliente", referencedColumnName="id")
     * @GRID\Column(title="Transportista", filterable=true, field="cliente.nombre")
     */
    private $cliente;
    
    /**
     * @ORM\ManyToOne(targetEntity="Empresa", inversedBy="retiros")
     * @ORM\JoinColumn(name="empresa", referencedColumnName="id")
     * @GRID\Column(title="Empresa", filterable=true, field="empresa.nombre")
     */
    private $empresa;
    
    /**
    * @var boolean
    * @ORM\Column(name="confirmado", type="boolean")
    * @GRID\Column(title="Confirmado?", values={"1"="SI","0"="NO"})
    */
    private $confirmado;
    
    public $codigo;


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
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->stocks = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add stocks
     *
     * @param \Nossis\NossisBundle\Entity\RetiroStock $stocks
     * @return Retiro
     */
    public function addStock(\Nossis\NossisBundle\Entity\RetiroStock $stocks)
    {
        $this->stocks[] = $stocks;

        return $this;
    }

    /**
     * Remove stocks
     *
     * @param \Nossis\NossisBundle\Entity\RetiroStock $stocks
     */
    public function removeStock(\Nossis\NossisBundle\Entity\RetiroStock $stocks)
    {
        $this->stocks->removeElement($stocks);
    }

    /**
     * Get stocks
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getStocks()
    {
        return $this->stocks;
    }

    /**
     * Set cliente
     *
     * @param \Nossis\NossisBundle\Entity\Cliente $cliente
     * @return Retiro
     */
    public function setCliente(\Nossis\NossisBundle\Entity\Cliente $cliente = null)
    {
        $this->cliente = $cliente;

        return $this;
    }

    /**
     * Get cliente
     *
     * @return \Nossis\NossisBundle\Entity\Cliente 
     */
    public function getCliente()
    {
        return $this->cliente;
    }
    
    

    /**
     * Set empresa
     *
     * @param \Nossis\NossisBundle\Entity\Empresa $empresa
     *
     * @return Retiro
     */
    public function setEmpresa(\Nossis\NossisBundle\Entity\Empresa $empresa = null)
    {
        $this->empresa = $empresa;

        return $this;
    }

    /**
     * Get empresa
     *
     * @return \Nossis\NossisBundle\Entity\Empresa 
     */
    public function getEmpresa()
    {
        return $this->empresa;
    }

    /**
     * Set confirmado
     *
     * @param boolean $confirmado
     *
     * @return Retiro
     */
    public function setConfirmado($confirmado)
    {
        $this->confirmado = $confirmado;

        return $this;
    }

    /**
     * Get confirmado
     *
     * @return boolean 
     */
    public function getConfirmado()
    {
        return $this->confirmado;
    }
    
    /**
     * Devuelve confirmado en formato SI o NO
     */
    public function getStringConfirmado()
    {
        if ($this->confirmado == 1){
            return "SI";
        }else{
            return "NO";
        }
        
    }

    /**
     * Set transportista.

     *
     * @param string $transportista
     *
     * @return Retiro
     */
    public function setTransportista($transportista)
    {
        $this->transportista = $transportista;

        return $this;
    }

    /**
     * Get transportista.

     *
     * @return string
     */
    public function getTransportista()
    {
        return $this->transportista;
    }
}
