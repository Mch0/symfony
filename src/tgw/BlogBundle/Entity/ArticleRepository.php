<?php

namespace tgw\BlogBundle\Entity;

use Doctrine\ORM\EntityRepository;

/**
 * ArticleRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class ArticleRepository extends EntityRepository
{

    /**
     *
     * Retourne les articles publiés
     * @return array
     *
     */
    public function findAllPublished()
    {
        return $this->getEntityManager()->createQuery("SELECT a from tgwBlogBundle:Article a where a.articlePublie = 1")->getResult();
    }
}
