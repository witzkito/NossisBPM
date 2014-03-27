<?php

namespace Nossis\NossisBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

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
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="lote", type="string", length=10)
     */
    private $lote;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="fecha_ingreso", type="datetime")
     */
    private $fechaIngreso;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="fecha_envasado", type="datetime")
     */
    private $fechaEnvasado;

    /**
     * @var string
     *
     * @ORM\Column(name="codigo", type="string", length=255)
     */
    private $codigo;

    /**
     * @var string
     *
     * @ORM\Column(name="palet", type="string", length=10)
     */
    private $palet;

    /**
     * @var string
     *
     * @ORM\Column(name="turno", type="string", length=10)
     */
    private $turno;
    
    /**
     * @ORM\ManyToOne(targetEntity="Producto", inversedBy="producto")
     * @ORM\JoinColumn(name="producto", referencedColumnName="id")
     */
    private $producto;
    
    /**
     * @var integer
     * @orm\Column(name="cantidad", type="integer")
     */
    private $cantidad;
    
    /**
     * @ORM\ManyToOne(targetEntity="Area", inversedBy="area")
     * @ORM\JoinColumn(name="area", referencedColumnName="id")
     */
    private $area;


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
     * Set cantidad
     *
     * @param integer $cantidad
     * @return Stock
     */
    public function setCantidad($cantidad)
    {
        $this->cantidad = $cantidad;

        return $this;
    }

    /**
     * Get cantidad
     *
     * @return integer 
     */
    public function getCantidad()
    {
        return $this->cantidad;
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
}
