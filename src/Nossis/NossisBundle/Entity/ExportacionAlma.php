<?php

namespace Nossis\NossisBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * ExportacionAlma
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="Nossis\NossisBundle\Entity\Repositorio\ExportacionAlmaRepository")
 */
class ExportacionAlma
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
     * @ORM\Column(name="fechaInicio", type="datetime")
     */
    private $fechaInicio;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="fechaFin", type="datetime")
     */
    private $fechaFin;
    
    /**
     * @var boolean
     * @ORM\Column(name="automatico", type="boolean") 
     */
    private $automatico;
    
    /**
     * @ORM\OneToMany(targetEntity="ItemExportacionAlma", mappedBy="exportacion")
     */
    protected $items;


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
     * Set fechaInicio
     *
     * @param \DateTime $fechaInicio
     * @return ExportacionAlma
     */
    public function setFechaInicio($fechaInicio)
    {
        $this->fechaInicio = $fechaInicio;

        return $this;
    }

    /**
     * Get fechaInicio
     *
     * @return \DateTime 
     */
    public function getFechaInicio()
    {
        return $this->fechaInicio;
    }

    /**
     * Set fechaFin
     *
     * @param \DateTime $fechaFin
     * @return ExportacionAlma
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
     * Constructor
     */
    public function __construct()
    {
        $this->items = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add items
     *
     * @param \Nossis\NossisBundle\Entity\ItemExportacionAlma $items
     * @return ExportacionAlma
     */
    public function addItem(\Nossis\NossisBundle\Entity\ItemExportacionAlma $items)
    {
        $this->items[] = $items;

        return $this;
    }

    /**
     * Remove items
     *
     * @param \Nossis\NossisBundle\Entity\ItemExportacionAlma $items
     */
    public function removeItem(\Nossis\NossisBundle\Entity\ItemExportacionAlma $items)
    {
        $this->items->removeElement($items);
    }

    /**
     * Get items
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getItems()
    {
        return $this->items;
    }

    /**
     * Set automatico
     *
     * @param boolean $automatico
     * @return ExportacionAlma
     */
    public function setAutomatico($automatico)
    {
        $this->automatico = $automatico;

        return $this;
    }

    /**
     * Get automatico
     *
     * @return boolean 
     */
    public function getAutomatico()
    {
        return $this->automatico;
    }
}
