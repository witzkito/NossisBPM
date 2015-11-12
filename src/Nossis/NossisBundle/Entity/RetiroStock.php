<?php

namespace Nossis\NossisBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * RetiroStock
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="Nossis\NossisBundle\Entity\Repositorio\RetiroStockRepository")
 */
class RetiroStock
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
     * @var integer
     *
     * @ORM\Column(name="cantidad", type="decimal", scale=2)
     */
    private $cantidad;
    
    /**
     * @ORM\ManyToOne(targetEntity="Stock", inversedBy="retiros")
     * @ORM\JoinColumn(name="stock", referencedColumnName="id")
     */
    private $stock;
    
    /**
     * @ORM\ManyToOne(targetEntity="Retiro", inversedBy="stocks")
     * @ORM\JoinColumn(name="retiro", referencedColumnName="id")
     */
    private $retiro;
    
    /**
     * @ORM\OneToMany(targetEntity="Devolucion", mappedBy="retiroStock")
     */
    protected $devoluciones;
    
    /**
     * @ORM\ManyToOne(targetEntity="Cliente", inversedBy="retiros")
     * @ORM\JoinColumn(name="cliente_id", referencedColumnName="id")
     */
    private $cliente;


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
     * Set cantidad
     *
     * @param integer $cantidad
     * @return RetiroStock
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
     * Set stock
     *
     * @param \Nossis\NossisBundle\Entity\Stock $stock
     * @return RetiroStock
     */
    public function setStock(\Nossis\NossisBundle\Entity\Stock $stock = null)
    {
        $this->stock = $stock;

        return $this;
    }

    /**
     * Get stock
     *
     * @return \Nossis\NossisBundle\Entity\Stock 
     */
    public function getStock()
    {
        return $this->stock;
    }

    /**
     * Set retiro
     *
     * @param \Nossis\NossisBundle\Entity\Retiro $retiro
     * @return RetiroStock
     */
    public function setRetiro(\Nossis\NossisBundle\Entity\Retiro $retiro = null)
    {
        $this->retiro = $retiro;

        return $this;
    }

    /**
     * Get retiro
     *
     * @return \Nossis\NossisBundle\Entity\Retiro 
     */
    public function getRetiro()
    {
        return $this->retiro;
    }
    
    public function __toString() {
        return "NO ESTOY RETORNANDO BIEN!!";
    }
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->devoluciones = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add devolucione.

     *
     * @param \Nossis\NossisBundle\Entity\Devolucion $devolucione
     *
     * @return RetiroStock
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
     * Set cliente
     *
     * @param \Nossis\NossisBundle\Entity\Cliente $cliente
     * @return RetiroStock
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
}
