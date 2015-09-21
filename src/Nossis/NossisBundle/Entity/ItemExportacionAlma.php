<?php

namespace Nossis\NossisBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * ItemExportacionAlma
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="Nossis\NossisBundle\Entity\Repositorio\ItemExportacionAlmaRepository")
 */
class ItemExportacionAlma
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
     * @var \DateTime
     *
     * @ORM\Column(name="fechaFin", type="datetime")
     */
    private $fechaFin;

    /**
     * @var string
     *
     * @ORM\Column(name="codigo", type="string", length=10)
     */
    private $codigo;

    /**
     * @var string
     *
     * @ORM\Column(name="cantidad", type="string", length=10)
     */
    private $cantidad;
    
    /**
     * @ORM\ManyToOne(targetEntity="ExportacionAlma", inversedBy="items")
     * @ORM\JoinColumn(name="id_exportacion", referencedColumnName="id")
     */
    private $exportacion;


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
     * Set fechaFin
     *
     * @param \DateTime $fechaFin
     * @return ItemExportacionAlma
     */
    public function setFechaFin($fechaFin)
    {
        $this->fechaFin = $fechaFin;

        return $this;
    }

    /**
     * Get fechaFin
     *
     * @return \DateTime 
     */
    public function getFechaFin()
    {
        return $this->fechaFin;
    }

    /**
     * Set codigo
     *
     * @param string $codigo
     * @return ItemExportacionAlma
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
     * Set cantidad
     *
     * @param string $cantidad
     * @return ItemExportacionAlma
     */
    public function setCantidad($cantidad)
    {
        $this->cantidad = $cantidad;

        return $this;
    }

    /**
     * Get cantidad
     *
     * @return string 
     */
    public function getCantidad()
    {
        return $this->cantidad;
    }

    /**
     * Set exportacion
     *
     * @param \Nossis\NossisBundle\Entity\ExportacionAlma $exportacion
     * @return ItemExportacionAlma
     */
    public function setExportacion(\Nossis\NossisBundle\Entity\ExportacionAlma $exportacion = null)
    {
        $this->exportacion = $exportacion;

        return $this;
    }

    /**
     * Get exportacion
     *
     * @return \Nossis\NossisBundle\Entity\ExportacionAlma 
     */
    public function getExportacion()
    {
        return $this->exportacion;
    }
}
