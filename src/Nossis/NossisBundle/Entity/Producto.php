<?php

namespace Nossis\NossisBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Producto
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="Nossis\NossisBundle\Entity\Repositorio\ProductoRepository")
 */
class Producto
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;
    
    /** @var integer
     *
     * @ORM\Column(name="orde ", type="integer")
    **/ 
    private $orden;

    /**
     * @var string
     *
     * @ORM\Column(name="nombre", type="string", length=255)
     */
    private $nombre;

    /**
     * @var string
     *
     * @ORM\Column(name="codigo", type="string", length=255)
     */
    private $codigo;
    
    /**
     * @var string
     *
     * @ORM\Column(name="codigoAlma", type="string", length=10)
     */
    private $codAlma;
    
    /**
     * @ORM\OneToMany(targetEntity="Stock", mappedBy="producto")
     */
    protected $stocks;
    
    /**
     * @ORM\OneToMany(targetEntity="Envase", mappedBy="producto")
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
     * @return Producto
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
     * Set codigo
     *
     * @param string $codigo
     * @return Producto
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
     * @return Producto
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
    
    public function getTotal(){
        $total = 0;
        foreach ($this->getStocks() as $stock){
            $total = $total + $stock->getActual();
        }
        return $total;
    }
    
    public function getTotalPalets(){
        $palets = 0;
        foreach ($this->getStocks() as $stock){
            if ($stock->getActual() != 0){
                $palets = $palets + 1;
            }
        }
        return $palets;
    }

    /**
     * Set orden
     *
     * @param integer $orden
     * @return Producto
     */
    public function setOrden($orden)
    {
        $this->orden = $orden;

        return $this;
    }

    /**
     * Get orden
     *
     * @return integer 
     */
    public function getOrden()
    {
        return $this->orden;
    }

    /**
     * Set codAlma
     *
     * @param string $codAlma
     * @return Producto
     */
    public function setCodAlma($codAlma)
    {
        $this->codAlma = $codAlma;

        return $this;
    }

    /**
     * Get codAlma
     *
     * @return string 
     */
    public function getCodAlma()
    {
        return $this->codAlma;
    }

    /**
     * Add envases
     *
     * @param \Nossis\NossisBundle\Entity\Envase $envases
     * @return Producto
     */
    public function addEnvase(\Nossis\NossisBundle\Entity\Envase $envases)
    {
        $this->envases[] = $envases;

        return $this;
    }

    /**
     * Remove envases
     *
     * @param \Nossis\NossisBundle\Entity\Envase $envases
     */
    public function removeEnvase(\Nossis\NossisBundle\Entity\Envase $envases)
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
}
