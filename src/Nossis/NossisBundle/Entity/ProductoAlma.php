<?php

namespace Nossis\NossisBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * ProductoAlma
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="Nossis\NossisBundle\Entity\Repositorio\ProductoAlmaRepository")
 */
class ProductoAlma
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
     * @ORM\Column(name="codigoAlma", type="string", length=10)
     */
    private $codAlma;
    
    /**
     * @var
     * @ORM\Column(name="factorMult", type="decimal") 
     */
    private $factorMult;
    
    /**
     * @ORM\OneToOne(targetEntity="Producto", inversedBy="alma")
     * @ORM\JoinColumn(name="producto_id", referencedColumnName="id")
     */
    protected $producto;



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
     * Set codAlma
     *
     * @param string $codAlma
     * @return ProductoAlma
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
     * Set factorMult
     *
     * @param string $factorMult
     * @return ProductoAlma
     */
    public function setFactorMult($factorMult)
    {
        $this->factorMult = $factorMult;

        return $this;
    }

    /**
     * Get factorMult
     *
     * @return string 
     */
    public function getFactorMult()
    {
        return $this->factorMult;
    }

    /**
     * Set producto
     *
     * @param \Nossis\NossisBundle\Entity\Producto $producto
     * @return ProductoAlma
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
