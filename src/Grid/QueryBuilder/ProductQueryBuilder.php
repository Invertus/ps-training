<?php

namespace Invertus\PsTraining\Grid\QueryBuilder;

use Doctrine\DBAL\Connection;
use Doctrine\DBAL\Query\QueryBuilder;
use PrestaShop\PrestaShop\Core\Grid\Query\AbstractDoctrineQueryBuilder;
use PrestaShop\PrestaShop\Core\Grid\Search\SearchCriteriaInterface;

final class ProductQueryBuilder extends AbstractDoctrineQueryBuilder
{
    /**
     * @var int
     */
    private $contextLangId;

    /**
     * @var int
     */
    private $contextShopId;

    /**
     * @param Connection $connection
     * @param string $dbPrefix
     * @param int $contextLangId
     * @param int $contextShopId
     */
    public function __construct(Connection $connection, $dbPrefix, $contextLangId, $contextShopId)
    {
        parent::__construct($connection, $dbPrefix);

        $this->contextLangId = $contextLangId;
        $this->contextShopId = $contextShopId;
    }

    /**
     * {@inheritdoc}
     */
    public function getSearchQueryBuilder(SearchCriteriaInterface $searchCriteria)
    {
        $quantitiesQuery = $this->connection
            ->createQueryBuilder()
            ->select('id_product, SUM(quantity) as quantity')
            ->from($this->dbPrefix.'stock_available', 'sa')
            ->groupBy('id_product');

        $qb = $this->getBaseQuery($searchCriteria->getFilters());
        $qb->select('p.id_product, pl.name, q.quantity')
            ->leftJoin(
                'p',
                sprintf('(%s)', $quantitiesQuery->getSQL()),
                'q',
                'p.id_product = q.id_product'
            )
            ->leftJoin(
                'p',
                $this->dbPrefix . 'product_shop',
                'ps',
                'ps.id_product = p.id_product AND ps.id_shop = :context_shop_id'
            )
            ->setParameter('context_shop_id', $this->contextShopId)
            ->orderBy(
                $searchCriteria->getOrderBy(),
                $searchCriteria->getOrderWay()
            )
            ->setFirstResult($searchCriteria->getOffset())
            ->setMaxResults($searchCriteria->getLimit())
        ;

        return $qb;
    }

    /**
     * {@inheritdoc}
     */
    public function getCountQueryBuilder(SearchCriteriaInterface $searchCriteria)
    {
        $qb = $this->getBaseQuery($searchCriteria->getFilters());
        $qb->select('COUNT(p.id_product)');

        return $qb;
    }

    /**
     * Base query is the same for both searching and counting
     *
     * @param array $filters
     *
     * @return QueryBuilder
     */
    private function getBaseQuery(array $filters)
    {
        $qb = $this->connection
            ->createQueryBuilder()
            ->from($this->dbPrefix.'product', 'p')
            ->leftJoin(
                'p',
                $this->dbPrefix.'product_lang',
                'pl',
                'p.id_product = pl.id_product AND pl.id_lang = :context_lang_id AND pl.id_shop = :context_shop_id'
            )
            ->setParameter('context_lang_id', $this->contextLangId)
            ->setParameter('context_shop_id', $this->contextShopId)
        ;

        foreach ($filters as $filterName => $filterValue) {
            if ('in_stock' === $filterName) {
                (bool) $filterValue ?
                    $qb->where('q.quantity > 0') :
                    $qb->where('q.quantity <= 0');

                continue;
            }

            if ('id_product' === $filterName) {
                $qb->andWhere("p.id_product = :$filterName");
                $qb->setParameter($filterName, $filterValue);

                continue;
            }

            $qb->andWhere("$filterName LIKE :$filterName");
            $qb->setParameter($filterName, '%'.$filterValue.'%');
        }

        return $qb;
    }
}
