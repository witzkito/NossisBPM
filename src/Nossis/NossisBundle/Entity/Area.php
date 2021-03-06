<?php

namespace Nossis\NossisBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Area
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="Nossis\NossisBundle\Entity\Repositorio\AreaRepository")
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
     * @ORM\Column(name="salida", type="boolean", nullable=true)
     */
    private $salida;
    
    /**
     * @var boolean
     *
     * @ORM\Column(name="destruccion", type="boolean", nullable=true)
     */
    private $destruccion;
    
    /**
     * @var integer
     * @ORM\Column(name="capacidad", type="integer") 
     */
    private $capacidad;
    
     /**
     * @ORM\ManyToOne(targetEntity="Almacen", inversedBy="almacen")
     * @ORM\JoinColumn(name="almacen", referencedColumnName="id")
     */
    private $almacen;
    
    /**
     * @ORM\OneToMany(targetEntity="Stock", mappedBy="area")
     */
    protected $stocks;
    
    /**
     * @ORM\OneToMany(targetEntity="Trazlado", mappedBy="area")
     */
    protected $trazlados;
    


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
     * @param \Nossis\NossisBundle\Entity\Stock $stocks
     * @return Area
     */
    public function addStock(\Nossis\NossisBundle\Entity\Stock $stocks)
    {
        $this->stocks[] = $stocks;

        return $this;
    }

    /**
     * Remove stocks
     *
     * @param \Nossis\NossisBundle\Entity\Stock $stocks
     */
    public function removeStock(\Nossis\NossisBundle\Entity\Stock $stocks)
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
    
    public function __toString() {
        return $this->nombre;
    }

    /**
     * Add trazlados
     *
     * @param \Nossis\NossisBundle\Entity\Trazlado $trazlados
     *
     * @return Area
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
     * Devuelve una matriz de Stock > 0 por lote
     * @return type
     */
    public function getLotesStock(){
        $lote = array();
        foreach($this->stocks as $stock){
           if ($stock->getActual() > 0){
            $lote[$stock->getLote()][$stock->getFechaEnvasado()->getTimestamp()][$stock->getId()] = $stock;
           }
        }
        return $lote;
    }

    /**
     * Set destruccion.

     *
     * @param boolean $destruccion
     *
     * @return Area
     */
    public function setDestruccion($destruccion)
    {
        $this->destruccion = $destruccion;

        return $this;
    }

    /**
     * Get destruccion.

     *
     * @return boolean
     */
    public function getDestruccion()
    {
        return $this->destruccion;
    }
}
