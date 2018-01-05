<?php

namespace Nod4\RpsAdminBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * History
 *
 * @ORM\Table(name="history")
 * @ORM\Entity(repositoryClass="Nod4\RpsAdminBundle\Entity\Repository\HistoryRepository")
 */
class History
{


    /**
     * @var
     */
    protected  $totalViews;



    /**
     * @var
     */
    protected $percent;
    /**
     * @var string
     *
     * @ORM\Column(name="platform", type="string", length=30, nullable=false)
     */
    private $platform;

    /**
     * @var string
     *
     * @ORM\Column(name="browser", type="string", length=100, nullable=false)
     */
    private $browser;

    /**
     * @var string
     *
     * @ORM\Column(name="ver", type="string", length=30, nullable=false)
     */
    private $ver;

    /**
     * @var integer
     *
     * @ORM\Column(name="view", type="integer", nullable=false)
     */
    private $view;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date_update", type="datetime", nullable=false)
     */
    private $dateUpdate;

    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;



    /**
     * Set platform
     *
     * @param string $platform
     * @return History
     */
    public function setPlatform($platform)
    {
        $this->platform = $platform;
    
        return $this;
    }

    /**
     * Get platform
     *
     * @return string 
     */
    public function getPlatform()
    {
        return $this->platform;
    }

    /**
     * Set browser
     *
     * @param string $browser
     * @return History
     */
    public function setBrowser($browser)
    {
        $this->browser = $browser;
    
        return $this;
    }

    /**
     * Get browser
     *
     * @return string 
     */
    public function getBrowser()
    {
        return $this->browser;
    }

    /**
     * Set ver
     *
     * @param string $ver
     * @return History
     */
    public function setVer($ver)
    {
        $this->ver = $ver;
    
        return $this;
    }

    /**
     * Get ver
     *
     * @return string 
     */
    public function getVer()
    {
        return $this->ver;
    }

    /**
     * Set view
     *
     * @param integer $view
     * @return History
     */
    public function setView($view)
    {
        $this->view = $view;
    
        return $this;
    }

    /**
     * Get view
     *
     * @return integer 
     */
    public function getView()
    {
        return $this->view;
    }

    /**
     * Set dateUpdate
     *
     * @param \DateTime $dateUpdate
     * @return History
     */
    public function setDateUpdate($dateUpdate)
    {
        $this->dateUpdate = $dateUpdate;
    
        return $this;
    }

    /**
     * Get dateUpdate
     *
     * @return \DateTime 
     */
    public function getDateUpdate()
    {
        return $this->dateUpdate;
    }

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
     * @return mixed
     */
    public function getTotalViews()
    {
        return $this->totalViews;
    }

    /**
     * @param mixed $totalViews
     * @return History
     */
    public function setTotalViews($totalViews)
    {
        $this->totalViews = $totalViews;
        $this->calculatePercentTotalViews($totalViews,$this->view);

        return $this;
    }

    /**
     * @return mixed
     */
    public function getPercent()
    {
        return $this->percent;
    }


    /**
     * @param $totalViews
     * @param $view
     */
    public function calculatePercentTotalViews($totalViews, $view){
        $percent = ROUND($view/$totalViews*100,0);
        $this->setPercent($percent);
    }

    /**
     * @param mixed $percentTotalViews
     * @return History
     */
    public function setPercent($percentTotalViews)
    {
        $this->percent = $percentTotalViews;
        return $this;
    }

}
