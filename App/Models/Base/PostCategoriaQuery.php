<?php

namespace App\Models\Base;

use App\Models\PostCategoria as ChildPostCategoria;
use App\Models\PostCategoriaQuery as ChildPostCategoriaQuery;
use \Exception;
use \PDO;
use App\Models\Map\PostCategoriaTableMap;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\ModelCriteria;
use Propel\Runtime\ActiveQuery\ModelJoin;
use Propel\Runtime\Collection\ObjectCollection;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\Exception\PropelException;

/**
 * Base class that represents a query for the 'post_categoria' table.
 *
 *
 *
 * @method     ChildPostCategoriaQuery orderByIdpost($order = Criteria::ASC) Order by the idPost column
 * @method     ChildPostCategoriaQuery orderByIdcategoria($order = Criteria::ASC) Order by the idCategoria column
 *
 * @method     ChildPostCategoriaQuery groupByIdpost() Group by the idPost column
 * @method     ChildPostCategoriaQuery groupByIdcategoria() Group by the idCategoria column
 *
 * @method     ChildPostCategoriaQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method     ChildPostCategoriaQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method     ChildPostCategoriaQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method     ChildPostCategoriaQuery leftJoinWith($relation) Adds a LEFT JOIN clause and with to the query
 * @method     ChildPostCategoriaQuery rightJoinWith($relation) Adds a RIGHT JOIN clause and with to the query
 * @method     ChildPostCategoriaQuery innerJoinWith($relation) Adds a INNER JOIN clause and with to the query
 *
 * @method     ChildPostCategoriaQuery leftJoinCategoriaPost($relationAlias = null) Adds a LEFT JOIN clause to the query using the CategoriaPost relation
 * @method     ChildPostCategoriaQuery rightJoinCategoriaPost($relationAlias = null) Adds a RIGHT JOIN clause to the query using the CategoriaPost relation
 * @method     ChildPostCategoriaQuery innerJoinCategoriaPost($relationAlias = null) Adds a INNER JOIN clause to the query using the CategoriaPost relation
 *
 * @method     ChildPostCategoriaQuery joinWithCategoriaPost($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the CategoriaPost relation
 *
 * @method     ChildPostCategoriaQuery leftJoinWithCategoriaPost() Adds a LEFT JOIN clause and with to the query using the CategoriaPost relation
 * @method     ChildPostCategoriaQuery rightJoinWithCategoriaPost() Adds a RIGHT JOIN clause and with to the query using the CategoriaPost relation
 * @method     ChildPostCategoriaQuery innerJoinWithCategoriaPost() Adds a INNER JOIN clause and with to the query using the CategoriaPost relation
 *
 * @method     ChildPostCategoriaQuery leftJoinPost($relationAlias = null) Adds a LEFT JOIN clause to the query using the Post relation
 * @method     ChildPostCategoriaQuery rightJoinPost($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Post relation
 * @method     ChildPostCategoriaQuery innerJoinPost($relationAlias = null) Adds a INNER JOIN clause to the query using the Post relation
 *
 * @method     ChildPostCategoriaQuery joinWithPost($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the Post relation
 *
 * @method     ChildPostCategoriaQuery leftJoinWithPost() Adds a LEFT JOIN clause and with to the query using the Post relation
 * @method     ChildPostCategoriaQuery rightJoinWithPost() Adds a RIGHT JOIN clause and with to the query using the Post relation
 * @method     ChildPostCategoriaQuery innerJoinWithPost() Adds a INNER JOIN clause and with to the query using the Post relation
 *
 * @method     \CategoriaPostQuery|\PostQuery endUse() Finalizes a secondary criteria and merges it with its primary Criteria
 *
 * @method     ChildPostCategoria findOne(ConnectionInterface $con = null) Return the first ChildPostCategoria matching the query
 * @method     ChildPostCategoria findOneOrCreate(ConnectionInterface $con = null) Return the first ChildPostCategoria matching the query, or a new ChildPostCategoria object populated from the query conditions when no match is found
 *
 * @method     ChildPostCategoria findOneByIdpost(int $idPost) Return the first ChildPostCategoria filtered by the idPost column
 * @method     ChildPostCategoria findOneByIdcategoria(int $idCategoria) Return the first ChildPostCategoria filtered by the idCategoria column *

 * @method     ChildPostCategoria requirePk($key, ConnectionInterface $con = null) Return the ChildPostCategoria by primary key and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildPostCategoria requireOne(ConnectionInterface $con = null) Return the first ChildPostCategoria matching the query and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildPostCategoria requireOneByIdpost(int $idPost) Return the first ChildPostCategoria filtered by the idPost column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildPostCategoria requireOneByIdcategoria(int $idCategoria) Return the first ChildPostCategoria filtered by the idCategoria column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildPostCategoria[]|ObjectCollection find(ConnectionInterface $con = null) Return ChildPostCategoria objects based on current ModelCriteria
 * @method     ChildPostCategoria[]|ObjectCollection findByIdpost(int $idPost) Return ChildPostCategoria objects filtered by the idPost column
 * @method     ChildPostCategoria[]|ObjectCollection findByIdcategoria(int $idCategoria) Return ChildPostCategoria objects filtered by the idCategoria column
 * @method     ChildPostCategoria[]|\Propel\Runtime\Util\PropelModelPager paginate($page = 1, $maxPerPage = 10, ConnectionInterface $con = null) Issue a SELECT query based on the current ModelCriteria and uses a page and a maximum number of results per page to compute an offset and a limit
 *
 */
abstract class PostCategoriaQuery extends ModelCriteria
{
    protected $entityNotFoundExceptionClass = '\\Propel\\Runtime\\Exception\\EntityNotFoundException';

    /**
     * Initializes internal state of \Base\PostCategoriaQuery object.
     *
     * @param     string $dbName The database name
     * @param     string $modelName The phpName of a model, e.g. 'Book'
     * @param     string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = 'default', $modelName = 'App\\Models\\PostCategoria', $modelAlias = null)
    {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new ChildPostCategoriaQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param     Criteria $criteria Optional Criteria to build the query from
     *
     * @return ChildPostCategoriaQuery
     */
    public static function create($modelAlias = null, Criteria $criteria = null)
    {
        if ($criteria instanceof ChildPostCategoriaQuery) {
            return $criteria;
        }
        $query = new ChildPostCategoriaQuery();
        if (null !== $modelAlias) {
            $query->setModelAlias($modelAlias);
        }
        if ($criteria instanceof Criteria) {
            $query->mergeWith($criteria);
        }

        return $query;
    }

    /**
     * Find object by primary key.
     * Propel uses the instance pool to skip the database if the object exists.
     * Go fast if the query is untouched.
     *
     * <code>
     * $obj = $c->findPk(array(12, 34), $con);
     * </code>
     *
     * @param array[$idPost, $idCategoria] $key Primary key to use for the query
     * @param ConnectionInterface $con an optional connection object
     *
     * @return ChildPostCategoria|array|mixed the result, formatted by the current formatter
     */
    public function findPk($key, ConnectionInterface $con = null)
    {
        if ($key === null) {
            return null;
        }

        if ($con === null) {
            $con = Propel::getServiceContainer()->getReadConnection(PostCategoriaTableMap::DATABASE_NAME);
        }

        $this->basePreSelect($con);

        if (
            $this->formatter || $this->modelAlias || $this->with || $this->select
            || $this->selectColumns || $this->asColumns || $this->selectModifiers
            || $this->map || $this->having || $this->joins
        ) {
            return $this->findPkComplex($key, $con);
        }

        if ((null !== ($obj = PostCategoriaTableMap::getInstanceFromPool(serialize([(null === $key[0] || is_scalar($key[0]) || is_callable([$key[0], '__toString']) ? (string) $key[0] : $key[0]), (null === $key[1] || is_scalar($key[1]) || is_callable([$key[1], '__toString']) ? (string) $key[1] : $key[1])]))))) {
            // the object is already in the instance pool
            return $obj;
        }

        return $this->findPkSimple($key, $con);
    }

    /**
     * Find object by primary key using raw SQL to go fast.
     * Bypass doSelect() and the object formatter by using generated code.
     *
     * @param     mixed $key Primary key to use for the query
     * @param     ConnectionInterface $con A connection object
     *
     * @throws \Propel\Runtime\Exception\PropelException
     *
     * @return ChildPostCategoria A model object, or null if the key is not found
     */
    protected function findPkSimple($key, ConnectionInterface $con)
    {
        $sql = 'SELECT idPost, idCategoria FROM post_categoria WHERE idPost = :p0 AND idCategoria = :p1';
        try {
            $stmt = $con->prepare($sql);
            $stmt->bindValue(':p0', $key[0], PDO::PARAM_INT);
            $stmt->bindValue(':p1', $key[1], PDO::PARAM_INT);
            $stmt->execute();
        } catch (Exception $e) {
            Propel::log($e->getMessage(), Propel::LOG_ERR);
            throw new PropelException(sprintf('Unable to execute SELECT statement [%s]', $sql), 0, $e);
        }
        $obj = null;
        if ($row = $stmt->fetch(\PDO::FETCH_NUM)) {
            /** @var ChildPostCategoria $obj */
            $obj = new ChildPostCategoria();
            $obj->hydrate($row);
            PostCategoriaTableMap::addInstanceToPool($obj, serialize([(null === $key[0] || is_scalar($key[0]) || is_callable([$key[0], '__toString']) ? (string) $key[0] : $key[0]), (null === $key[1] || is_scalar($key[1]) || is_callable([$key[1], '__toString']) ? (string) $key[1] : $key[1])]));
        }
        $stmt->closeCursor();

        return $obj;
    }

    /**
     * Find object by primary key.
     *
     * @param     mixed $key Primary key to use for the query
     * @param     ConnectionInterface $con A connection object
     *
     * @return ChildPostCategoria|array|mixed the result, formatted by the current formatter
     */
    protected function findPkComplex($key, ConnectionInterface $con)
    {
        // As the query uses a PK condition, no limit(1) is necessary.
        $criteria = $this->isKeepQuery() ? clone $this : $this;
        $dataFetcher = $criteria
            ->filterByPrimaryKey($key)
            ->doSelect($con);

        return $criteria->getFormatter()->init($criteria)->formatOne($dataFetcher);
    }

    /**
     * Find objects by primary key
     * <code>
     * $objs = $c->findPks(array(array(12, 56), array(832, 123), array(123, 456)), $con);
     * </code>
     * @param     array $keys Primary keys to use for the query
     * @param     ConnectionInterface $con an optional connection object
     *
     * @return ObjectCollection|array|mixed the list of results, formatted by the current formatter
     */
    public function findPks($keys, ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getReadConnection($this->getDbName());
        }
        $this->basePreSelect($con);
        $criteria = $this->isKeepQuery() ? clone $this : $this;
        $dataFetcher = $criteria
            ->filterByPrimaryKeys($keys)
            ->doSelect($con);

        return $criteria->getFormatter()->init($criteria)->format($dataFetcher);
    }

    /**
     * Filter the query by primary key
     *
     * @param     mixed $key Primary key to use for the query
     *
     * @return $this|ChildPostCategoriaQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {
        $this->addUsingAlias(PostCategoriaTableMap::COL_IDPOST, $key[0], Criteria::EQUAL);
        $this->addUsingAlias(PostCategoriaTableMap::COL_IDCATEGORIA, $key[1], Criteria::EQUAL);

        return $this;
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return $this|ChildPostCategoriaQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {
        if (empty($keys)) {
            return $this->add(null, '1<>1', Criteria::CUSTOM);
        }
        foreach ($keys as $key) {
            $cton0 = $this->getNewCriterion(PostCategoriaTableMap::COL_IDPOST, $key[0], Criteria::EQUAL);
            $cton1 = $this->getNewCriterion(PostCategoriaTableMap::COL_IDCATEGORIA, $key[1], Criteria::EQUAL);
            $cton0->addAnd($cton1);
            $this->addOr($cton0);
        }

        return $this;
    }

    /**
     * Filter the query on the idPost column
     *
     * Example usage:
     * <code>
     * $query->filterByIdpost(1234); // WHERE idPost = 1234
     * $query->filterByIdpost(array(12, 34)); // WHERE idPost IN (12, 34)
     * $query->filterByIdpost(array('min' => 12)); // WHERE idPost > 12
     * </code>
     *
     * @see       filterByPost()
     *
     * @param     mixed $idpost The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildPostCategoriaQuery The current query, for fluid interface
     */
    public function filterByIdpost($idpost = null, $comparison = null)
    {
        if (is_array($idpost)) {
            $useMinMax = false;
            if (isset($idpost['min'])) {
                $this->addUsingAlias(PostCategoriaTableMap::COL_IDPOST, $idpost['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($idpost['max'])) {
                $this->addUsingAlias(PostCategoriaTableMap::COL_IDPOST, $idpost['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(PostCategoriaTableMap::COL_IDPOST, $idpost, $comparison);
    }

    /**
     * Filter the query on the idCategoria column
     *
     * Example usage:
     * <code>
     * $query->filterByIdcategoria(1234); // WHERE idCategoria = 1234
     * $query->filterByIdcategoria(array(12, 34)); // WHERE idCategoria IN (12, 34)
     * $query->filterByIdcategoria(array('min' => 12)); // WHERE idCategoria > 12
     * </code>
     *
     * @see       filterByCategoriaPost()
     *
     * @param     mixed $idcategoria The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildPostCategoriaQuery The current query, for fluid interface
     */
    public function filterByIdcategoria($idcategoria = null, $comparison = null)
    {
        if (is_array($idcategoria)) {
            $useMinMax = false;
            if (isset($idcategoria['min'])) {
                $this->addUsingAlias(PostCategoriaTableMap::COL_IDCATEGORIA, $idcategoria['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($idcategoria['max'])) {
                $this->addUsingAlias(PostCategoriaTableMap::COL_IDCATEGORIA, $idcategoria['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(PostCategoriaTableMap::COL_IDCATEGORIA, $idcategoria, $comparison);
    }

    /**
     * Filter the query by a related \CategoriaPost object
     *
     * @param \CategoriaPost|ObjectCollection $categoriaPost The related object(s) to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @throws \Propel\Runtime\Exception\PropelException
     *
     * @return ChildPostCategoriaQuery The current query, for fluid interface
     */
    public function filterByCategoriaPost($categoriaPost, $comparison = null)
    {
        if ($categoriaPost instanceof \CategoriaPost) {
            return $this
                ->addUsingAlias(PostCategoriaTableMap::COL_IDCATEGORIA, $categoriaPost->getId(), $comparison);
        } elseif ($categoriaPost instanceof ObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(PostCategoriaTableMap::COL_IDCATEGORIA, $categoriaPost->toKeyValue('PrimaryKey', 'Id'), $comparison);
        } else {
            throw new PropelException('filterByCategoriaPost() only accepts arguments of type \CategoriaPost or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the CategoriaPost relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildPostCategoriaQuery The current query, for fluid interface
     */
    public function joinCategoriaPost($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('CategoriaPost');

        // create a ModelJoin object for this join
        $join = new ModelJoin();
        $join->setJoinType($joinType);
        $join->setRelationMap($relationMap, $this->useAliasInSQL ? $this->getModelAlias() : null, $relationAlias);
        if ($previousJoin = $this->getPreviousJoin()) {
            $join->setPreviousJoin($previousJoin);
        }

        // add the ModelJoin to the current object
        if ($relationAlias) {
            $this->addAlias($relationAlias, $relationMap->getRightTable()->getName());
            $this->addJoinObject($join, $relationAlias);
        } else {
            $this->addJoinObject($join, 'CategoriaPost');
        }

        return $this;
    }

    /**
     * Use the CategoriaPost relation CategoriaPost object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \CategoriaPostQuery A secondary query class using the current class as primary query
     */
    public function useCategoriaPostQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinCategoriaPost($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'CategoriaPost', '\CategoriaPostQuery');
    }

    /**
     * Filter the query by a related \Post object
     *
     * @param \Post|ObjectCollection $post The related object(s) to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @throws \Propel\Runtime\Exception\PropelException
     *
     * @return ChildPostCategoriaQuery The current query, for fluid interface
     */
    public function filterByPost($post, $comparison = null)
    {
        if ($post instanceof \App\Models\Post) {
            return $this
                ->addUsingAlias(PostCategoriaTableMap::COL_IDPOST, $post->getId(), $comparison);
        } elseif ($post instanceof ObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(PostCategoriaTableMap::COL_IDPOST, $post->toKeyValue('PrimaryKey', 'Id'), $comparison);
        } else {
            throw new PropelException('filterByPost() only accepts arguments of type \Post or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the Post relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildPostCategoriaQuery The current query, for fluid interface
     */
    public function joinPost($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('Post');

        // create a ModelJoin object for this join
        $join = new ModelJoin();
        $join->setJoinType($joinType);
        $join->setRelationMap($relationMap, $this->useAliasInSQL ? $this->getModelAlias() : null, $relationAlias);
        if ($previousJoin = $this->getPreviousJoin()) {
            $join->setPreviousJoin($previousJoin);
        }

        // add the ModelJoin to the current object
        if ($relationAlias) {
            $this->addAlias($relationAlias, $relationMap->getRightTable()->getName());
            $this->addJoinObject($join, $relationAlias);
        } else {
            $this->addJoinObject($join, 'Post');
        }

        return $this;
    }

    /**
     * Use the Post relation Post object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \PostQuery A secondary query class using the current class as primary query
     */
    public function usePostQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinPost($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'Post', '\PostQuery');
    }

    /**
     * Exclude object from result
     *
     * @param   ChildPostCategoria $postCategoria Object to remove from the list of results
     *
     * @return $this|ChildPostCategoriaQuery The current query, for fluid interface
     */
    public function prune($postCategoria = null)
    {
        if ($postCategoria) {
            $this->addCond('pruneCond0', $this->getAliasedColName(PostCategoriaTableMap::COL_IDPOST), $postCategoria->getIdpost(), Criteria::NOT_EQUAL);
            $this->addCond('pruneCond1', $this->getAliasedColName(PostCategoriaTableMap::COL_IDCATEGORIA), $postCategoria->getIdcategoria(), Criteria::NOT_EQUAL);
            $this->combine(array('pruneCond0', 'pruneCond1'), Criteria::LOGICAL_OR);
        }

        return $this;
    }

    /**
     * Deletes all rows from the post_categoria table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public function doDeleteAll(ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(PostCategoriaTableMap::DATABASE_NAME);
        }

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con) {
            $affectedRows = 0; // initialize var to track total num of affected rows
            $affectedRows += parent::doDeleteAll($con);
            // Because this db requires some delete cascade/set null emulation, we have to
            // clear the cached instance *after* the emulation has happened (since
            // instances get re-added by the select statement contained therein).
            PostCategoriaTableMap::clearInstancePool();
            PostCategoriaTableMap::clearRelatedInstancePool();

            return $affectedRows;
        });
    }

    /**
     * Performs a DELETE on the database based on the current ModelCriteria
     *
     * @param ConnectionInterface $con the connection to use
     * @return int             The number of affected rows (if supported by underlying database driver).  This includes CASCADE-related rows
     *                         if supported by native driver or if emulated using Propel.
     * @throws PropelException Any exceptions caught during processing will be
     *                         rethrown wrapped into a PropelException.
     */
    public function delete(ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(PostCategoriaTableMap::DATABASE_NAME);
        }

        $criteria = $this;

        // Set the correct dbName
        $criteria->setDbName(PostCategoriaTableMap::DATABASE_NAME);

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con, $criteria) {
            $affectedRows = 0; // initialize var to track total num of affected rows

            PostCategoriaTableMap::removeInstanceFromPool($criteria);

            $affectedRows += ModelCriteria::delete($con);
            PostCategoriaTableMap::clearRelatedInstancePool();

            return $affectedRows;
        });
    }

} // PostCategoriaQuery
