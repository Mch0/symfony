<?php

namespace tgw\BlogBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Article
 */
class Article
{
    /**
     * @var integer
     */
    private $id;

    /**
     * @var string
     */
    private $articleTitre;

    /**
     * @var \DateTime
     */
    private $articleDate;

    /**
     * @var string
     */
    private $articleSynopsis;

    /**
     * @var string
     */
    private $articleContenu;

    /**
     * @ORM\ManyToOne(targetEntity="Auteur", inversedBy="Article")
     * @ORM\JoinColumn(name="articleAuteur", referencedColumnName="id")
     */
    private $articleAuteur;

    /**
     * @var boolean
     */
    private $articlePublie;

    /**
     * @var \stdClass
     */
    private $articleCategorie;

    /**
     * @var string
     */
    private $articleVignette;

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
     * Set articleTitre
     *
     * @param string $articleTitre
     * @return Article
     */
    public function setArticleTitre($articleTitre)
    {
        $this->articleTitre = $articleTitre;

        return $this;
    }

    /**
     * Get articleTitre
     *
     * @return string 
     */
    public function getArticleTitre()
    {
        return $this->articleTitre;
    }


    public function getArticleVignette()
    {
        return $this->articleVignette;
    }

    public function setArticleVignette($articleVignette)
    {
        $this->articleVignette = $articleVignette;
        return $this;
    }

    /**
     * Set articleDate
     *
     * @param \DateTime $articleDate
     * @return Article
     */
    public function setArticleDate($articleDate)
    {
        $this->articleDate = $articleDate;

        return $this;
    }

    /**
     * Get articleDate
     *
     * @return \DateTime 
     */
    public function getArticleDate()
    {
        return $this->articleDate;
    }

    /**
     * Set articleSynopsis
     *
     * @param string $articleSynopsis
     * @return Article
     */
    public function setArticleSynopsis($articleSynopsis)
    {
        $this->articleSynopsis = $articleSynopsis;

        return $this;
    }

    /**
     * Get articleSynopsis
     *
     * @return string 
     */
    public function getArticleSynopsis()
    {
        return $this->articleSynopsis;
    }

    /**
     * Set articleContenu
     *
     * @param string $articleContenu
     * @return Article
     */
    public function setArticleContenu($articleContenu)
    {
        $this->articleContenu = $articleContenu;

        return $this;
    }

    /**
     * Get articleContenu
     *
     * @return string 
     */
    public function getArticleContenu()
    {
        return $this->articleContenu;
    }

    /**
     * Set articleAuteur
     *
     * @param string $articleAuteur
     * @return Article
     */
    public function setArticleAuteur($articleAuteur)
    {
        $this->articleAuteur = $articleAuteur;

        return $this;
    }

    /**
     * Get articleAuteur
     *
     * @return string 
     */
    public function getArticleAuteur()
    {
        return $this->articleAuteur;
    }

    /**
     * Set articlePublie
     *
     * @param boolean $articlePublie
     * @return Article
     */
    public function setArticlePublie($articlePublie)
    {
        $this->articlePublie = $articlePublie;

        return $this;
    }

    /**
     * Get articlePublie
     *
     * @return boolean 
     */
    public function getArticlePublie()
    {
        return $this->articlePublie;
    }

    /**
     * Set articleCategorie
     *
     * @param \stdClass $articleCategorie
     * @return Article
     */
    public function setArticleCategorie($articleCategorie)
    {
        $this->articleCategorie = $articleCategorie;

        return $this;
    }

    /**
     * Get articleCategorie
     *
     * @return \stdClass 
     */
    public function getArticleCategorie()
    {
        return $this->articleCategorie;
    }
}
