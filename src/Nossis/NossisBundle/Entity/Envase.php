<?php

namespace Nossis\NossisBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Producto
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="Nossis\NossisBundle\Entity\Repositorio\EnvaseRepository")
 */
class Envase
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
     * @ORM\Column(name="identificador", type="string", length=255)
     */
    private $identificador;
    
    /**
     * @ORM\ManyToOne(targetEntity="Producto", inversedBy="envases")
     * @ORM\JoinColumn(name="producto", referencedColumnName="id")
     */
    private $producto;
    
    /**
     * @ORM\OneToMany(targetEntity="EnvaseIngreso", mappedBy="envase")
     */
    protected $ingresos;

    

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
     * @return Paquete
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
     * Set identificador
     *
     * @param string $identificador
     * @return Envase
     */
    public function setIdentificador($identificador)
    {
        $this->identificador = $identificador;

        return $this;
    }

    /**
     * Get identificador
     *
     * @return string 
     */
    public function getIdentificador()
    {
        return $this->identificador;
    }

    /**
     * Set producto
     *
     * @param \Nossis\NossisBundle\Entity\Producto $producto
     * @return Envase
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
        $this->ingresos = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add ingresos
     *
     * @param \Nossis\NossisBundle\Entity\EnvaseIngreso $ingresos
     * @return Envase
     */
    public function addIngreso(\Nossis\NossisBundle\Entity\EnvaseIngreso $ingresos)
    {
        $this->ingresos[] = $ingresos;

        return $this;
    }

    /**
     * Remove ingresos
     *
     * @param \Nossis\NossisBundle\Entity\EnvaseIngreso $ingresos
     */
    public function removeIngreso(\Nossis\NossisBundle\Entity\EnvaseIngreso $ingresos)
    {
        $this->ingresos->removeElement($ingresos);
    }

    /**
     * Get ingresos
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getIngresos()
    {
        return $this->ingresos;
    }
    
    public function __toString()
    {
        return $this->nombre;
    }
    
    /**
     * Retornar la cantidad actual de envases
     * @return integer
     */
    public function getCantidad()
    {
        $cantidad = 0;
        foreach ($this->ingresos as $ingreso){
            $cantidad = $cantidad + $ingreso->getCantidad();
            foreach ($ingreso->getRetiros() as $retiro){
                $cantidad = $cantidad - $retiro->getCantidad();
            }
        }
        return $cantidad;
    }
}
