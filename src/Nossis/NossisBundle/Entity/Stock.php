<?php

namespace Nossis\NossisBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use APY\DataGridBundle\Grid\Mapping as GRID;

/**
 * Stock
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="Nossis\NossisBundle\Entity\Repositorio\StockRepository")
 */
class Stock
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @GRID\Column(title="Nro.",filterable=true, visible=false)
     */
    private $id;
    
    /**
     * @var string
     *
     * @ORM\Column(name="numero", type="string", length=20, nullable=true)
     * @GRID\Column(title="Nro.",filterable=true, visible=true)
     */
    private $numero;

    /**
     * @var string
     *
     * @ORM\Column(name="lote", type="string", length=10)
     * @GRID\Column(title="Lote",filterable=true)
     */
    private $lote;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="fecha_ingreso", type="datetime")
     * @GRID\Column(title="Fecha Ingreos",filterable=true)
     */
    private $fechaIngreso;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="fecha_envasado", type="datetime")
     * @GRID\Column(title="Fecha Envasado", visible=false)
     */
    private $fechaEnvasado;

    /**
     * @var string
     *
     * @ORM\Column(name="codigo", type="string", length=255)
     * @GRID\Column(title="Codigo",visible=false)
     */
    private $codigo;

    /**
     * @var string
     *
     * @ORM\Column(name="palet", type="string", length=10)
     * @GRID\Column(title="Palet",filterable=true)
     */
    private $palet;

    /**
     * @var string
     *
     * @ORM\Column(name="turno", type="string", length=10)
     * @GRID\Column(title="Turno",filterable=true)
     */
    private $turno;
    
    /**
     * @ORM\ManyToOne(targetEntity="Producto", inversedBy="producto")
     * @ORM\JoinColumn(name="producto", referencedColumnName="id")
     * @GRID\Column(title="Producto", field="producto.nombre", filterable=true)
     */
    private $producto;
    
    /**
     * @var integer
     * @orm\Column(name="ingresado", type="decimal", scale=1)
     * @GRID\Column(title="Cant. Ingresada",filterable=true)
     */
    private $ingresado;
    
    /**
     * @var integer
     * @orm\Column(name="actual", type="decimal" , scale=1)
     * @GRID\Column(title="Cant. Actual",filterable=true)
     */
    private $actual;
    
    /**
     * @ORM\ManyToOne(targetEntity="Area", inversedBy="area")
     * @ORM\JoinColumn(name="area", referencedColumnName="id")
     * @GRID\Column(title="Area", field="area.nombre", filterable=true)
     */
    private $area;
    
     /**
     * @ORM\OneToMany(targetEntity="RetiroStock", mappedBy="stock")
     */
    protected $retiros;
    
    /**
     * @ORM\OneToMany(targetEntity="Trazlado", mappedBy="stock")
     */
    protected $trazlados;
    
    /**
     * @ORM\OneToMany(targetEntity="EstadoStock", mappedBy="stock")
     */
    private $estados;
    
    /**
     * @ORM\OneToMany(targetEntity="Fraccionar", mappedBy="stock", cascade={"remove"})
     */
    private $fraccionados;
    
    /**
     * @ORM\OneToOne(targetEntity="Fraccionar")
     * @ORM\JoinColumn(name="es_fracciondo", referencedColumnName="id")
     */
    private $origenFraccionado;
    
    /**
     * @ORM\OneToMany(targetEntity="Baja", mappedBy="stock")
     */
    protected $bajas;
    
     /**
     * @ORM\OneToMany(targetEntity="EnvaseRetiro", mappedBy="stock")
     */
    protected $envases;
    
    /**
     * @ORM\OneToMany(targetEntity="Destruccion", mappedBy="stock")
     */
    protected $destrucciones;
    
    public $motivoEdicion;
    
    


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
     * @return Stock
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
     * Set fechaIngreso
     *
     * @param \DateTime $fechaIngreso
     * @return Stock
     */
    public function setFechaIngreso($fechaIngreso)
    {
        $this->fechaIngreso = $fechaIngreso;

        return $this;
    }

    /**
     * Get fechaIngreso
     *
     * @return \DateTime 
     */
    public function getFechaIngreso()
    {
        return $this->fechaIngreso;
    }

    /**
     * Set fechaEnvasado
     *
     * @param \DateTime $fechaEnvasado
     * @return Stock
     */
    public function setFechaEnvasado($fechaEnvasado)
    {
        $this->fechaEnvasado = $fechaEnvasado;

        return $this;
    }

    /**
     * Get fechaEnvasado
     *
     * @return \DateTime 
     */
    public function getFechaEnvasado()
    {
        return $this->fechaEnvasado;
    }

    /**
     * Set codigo
     *
     * @param string $codigo
     * @return Stock
     */
    public function setCodigo($codigo)
    {
        $this->codigo = $codigo;

        return $this;
    }

    /**
     * Get codigo
     *
     * @return string 
     */
    public function getCodigo()
    {
        return $this->codigo;
    }

    /**
     * Set palet
     *
     * @param string $palet
     * @return Stock
     */
    public function setPalet($palet)
    {
        $this->palet = $palet;

        return $this;
    }

    /**
     * Get palet
     *
     * @return string 
     */
    public function getPalet()
    {
        return $this->palet;
    }

    /**
     * Set turno
     *
     * @param string $turno
     * @return Stock
     */
    public function setTurno($turno)
    {
        $this->turno = $turno;

        return $this;
    }

    /**
     * Get turno
     *
     * @return string 
     */
    public function getTurno()
    {
        return $this->turno;
    }

    /**
     * Set area
     *
     * @param \Nossis\NossisBundle\Entity\Area $area
     * @return Stock
     */
    public function setArea(\Nossis\NossisBundle\Entity\Area $area = null)
    {
        $this->area = $area;

        return $this;
    }

    /**
     * Get area
     *
     * @return \Nossis\NossisBundle\Entity\Area 
     */
    public function getArea()
    {
        return $this->area;
    }

    
    /**
     * Set producto
     *
     * @param \Nossis\NossisBundle\Entity\Producto $producto
     * @return Stock
     */
    public function setProducto(\Nossis\NossisBundle\Entity\Producto $producto = null)
    {
        $this->producto = $producto;

        return $this;
    }

    /**
     * Get producto
     *
     * @return \Nossis\NossisBundle\Entity\Producto 
     */
    public function getProducto()
    {
        return $this->producto;
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
     * @return Stock
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

    /**
     * Set transportista
     *
     * @param \Nossis\NossisBundle\Entity\Transportista $transportista
     * @return Stock
     */
    public function setTransportista(\Nossis\NossisBundle\Entity\Transportista $transportista = null)
    {
        $this->transportista = $transportista;

        return $this;
    }

    /**
     * Get transportista
     *
     * @return \Nossis\NossisBundle\Entity\Transportista 
     */
    public function getTransportista()
    {
        return $this->transportista;
    }
    
    public function __toString() {
        return $this->getId() . " - " . $this->getProducto()->getNombre();
    }
    
    public function actualizarStock($anterior, $actualizar)
    {
        $this->actual = ($this->actual + $anterior - $actualizar);
        
    }
    
    public function retirarStock($cantidad)
    {
        $this->actual = $this->actual - $cantidad;
    }

    /**
     * Add trazlados
     *
     * @param \Nossis\NossisBundle\Entity\Trazlado $trazlados
     *
     * @return Stock
     */
    public function addTrazlado(\Nossis\NossisBundle\Entity\Trazlado $trazlados)
    {
        $this->trazlados[] = $trazlados;

        return $this;
    }

    /**
     * Remove trazlados
     *
     * @param \Nossis\NossisBundle\Entity\Trazlado $trazlados
     */
    public function removeTrazlado(\Nossis\NossisBundle\Entity\Trazlado $trazlados)
    {
        $this->trazlados->removeElement($trazlados);
    }

    /**
     * Get trazlados
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getTrazlados()
    {
        return $this->trazlados;
    }

    /**
     * Set ingresado
     *
     * @param integer $ingresado
     *
     * @return Stock
     */
    public function setIngresado($ingresado)
    {
        $this->ingresado = $ingresado;

        return $this;
    }

    /**
     * Get ingresado
     *
     * @return integer 
     */
    public function getIngresado()
    {
        return $this->ingresado;
    }

    /**
     * Set actual
     *
     * @param integer $actual
     *
     * @return Stock
     */
    public function setActual($actual)
    {
        $this->actual = $actual;

        return $this;
    }

    /**
     * Get actual
     *
     * @return integer 
     */
    public function getActual()
    {
        return $this->actual;
    }

    /**
     * Add estados
     *
     * @param \Nossis\NossisBundle\Entity\EstadoStock $estados
     *
     * @return Stock
     */
    public function addEstado(\Nossis\NossisBundle\Entity\EstadoStock $estados)
    {
        $this->estados[] = $estados;

        return $this;
    }

    /**
     * Remove estados
     *
     * @param \Nossis\NossisBundle\Entity\EstadoStock $estados
     */
    public function removeEstado(\Nossis\NossisBundle\Entity\EstadoStock $estados)
    {
        $this->estados->removeElement($estados);
    }

    /**
     * Get estados
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getEstados()
    {
        return $this->estados;
    }

    /**
     * Add fraccionados
     *
     * @param \Nossis\NossisBundle\Entity\Fraccionar $fraccionados
     *
     * @return Stock
     */
    public function addFraccionado(\Nossis\NossisBundle\Entity\Fraccionar $fraccionados)
    {
        $this->fraccionados[] = $fraccionados;

        return $this;
    }

    /**
     * Remove fraccionados
     *
     * @param \Nossis\NossisBundle\Entity\Fraccionar $fraccionados
     */
    public function removeFraccionado(\Nossis\NossisBundle\Entity\Fraccionar $fraccionados)
    {
        $this->fraccionados->removeElement($fraccionados);
    }

    /**
     * Get fraccionados
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getFraccionados()
    {
        return $this->fraccionados;
    }
    

    /**
     * Set origenFraccionado
     *
     * @param \Nossis\NossisBundle\Entity\Fraccionar $origenFraccionado
     *
     * @return Stock
     */
    public function setOrigenFraccionado(\Nossis\NossisBundle\Entity\Fraccionar $origenFraccionado = null)
    {
        $this->origenFraccionado = $origenFraccionado;

        return $this;
    }

    /**
     * Get origenFraccionado
     *
     * @return \Nossis\NossisBundle\Entity\Fraccionar
     */
    public function getOrigenFraccionado()
    {
        return $this->origenFraccionado;
    }

    /**
     * Set numero.

     *
     * @param string $numero
     *
     * @return Stock
     */
    public function setNumero($numero)
    {
        $this->numero = $numero;

        return $this;
    }

    /**
     * Get numero.

     *
     * @return string
     */
    public function getNumero()
    {
        return $this->numero;
    }
    
    public function retirar($cantidad)
    {
        $this->actual = $this->actual - $cantidad;
        return $this;
    }
    
    public function devolver($cantidad)
    {
        $this->actual = $this->actual + $cantidad;
        return $this;
    }

    /**
     * Add devolucione.

     *
     * @param \Nossis\NossisBundle\Entity\Devolucion $devolucione
     *
     * @return Stock
     */
    public function addDevolucione(\Nossis\NossisBundle\Entity\Devolucion $devolucione)
    {
        $this->devoluciones[] = $devolucione;

        return $this;
    }

    /**
     * Remove devolucione.

     *
     * @param \Nossis\NossisBundle\Entity\Devolucion $devolucione
     */
    public function removeDevolucione(\Nossis\NossisBundle\Entity\Devolucion $devolucione)
    {
        $this->devoluciones->removeElement($devolucione);
    }

    /**
     * Get devoluciones.

     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getDevoluciones()
    {
        return $this->devoluciones;
    }

    /**
     * Add bajas
     *
     * @param \Nossis\NossisBundle\Entity\Baja $bajas
     * @return Stock
     */
    public function addBaja(\Nossis\NossisBundle\Entity\Baja $bajas)
    {
        $this->bajas[] = $bajas;

        return $this;
    }

    /**
     * Remove bajas
     *
     * @param \Nossis\NossisBundle\Entity\Baja $bajas
     */
    public function removeBaja(\Nossis\NossisBundle\Entity\Baja $bajas)
    {
        $this->bajas->removeElement($bajas);
    }

    /**
     * Get bajas
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getBajas()
    {
        return $this->bajas;
    }

    /**
     * Add envases
     *
     * @param \Nossis\NossisBundle\Entity\EnvaseRetiro $envases
     * @return Stock
     */
    public function addEnvase(\Nossis\NossisBundle\Entity\EnvaseRetiro $envases)
    {
        $this->envases[] = $envases;

        return $this;
    }

    /**
     * Remove envases
     *
     * @param \Nossis\NossisBundle\Entity\EnvaseRetiro $envases
     */
    public function removeEnvase(\Nossis\NossisBundle\Entity\EnvaseRetiro $envases)
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

    /**
     * Add destrucciones
     *
     * @param \Nossis\NossisBundle\Entity\Destruccion $destrucciones
     * @return Stock
     */
    public function addDestruccione(\Nossis\NossisBundle\Entity\Destruccion $destrucciones)
    {
        $this->destrucciones[] = $destrucciones;

        return $this;
    }

    /**
     * Remove destrucciones
     *
     * @param \Nossis\NossisBundle\Entity\Destruccion $destrucciones
     */
    public function removeDestruccione(\Nossis\NossisBundle\Entity\Destruccion $destrucciones)
    {
        $this->destrucciones->removeElement($destrucciones);
    }

    /**
     * Get destrucciones
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getDestrucciones()
    {
        return $this->destrucciones;
    }
}
