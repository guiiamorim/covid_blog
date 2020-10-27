<?php

namespace Base;

use \CategoriaPost as ChildCategoriaPost;
use \CategoriaPostQuery as ChildCategoriaPostQuery;
use \Exception;
use \PDO;
use Map\CategoriaPostTableMap;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\ModelCriteria;
use Propel\Runtime\ActiveQuery\ModelJoin;
use Propel\Runtime\Collection\ObjectCollection;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\Exception\PropelException;

/**
 * Base class that represents a query for the 'categoria_post' table.
 *
 *
 *
 * @method     ChildCategoriaPostQuery orderById($order = Criteria::ASC) Order by the id column
 * @method     ChildCategoriaPostQuery orderByNome($order = Criteria::ASC) Order by the nome column
 * @method     ChildCategoriaPostQuery orderByDescricao($order = Criteria::ASC) Order by the descricao column
 *
 * @method     ChildCategoriaPostQuery groupById() Group by the id column
 * @method     ChildCategoriaPostQuery groupByNome() Group by the nome column
 * @method     ChildCategoriaPostQuery groupByDescricao() Group by the descricao column
 *
 * @method     ChildCategoriaPostQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method     ChildCategoriaPostQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method     ChildCategoriaPostQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method     ChildCategoriaPostQuery leftJoinWith($relation) Adds a LEFT JOIN clause and with to the query
 * @method     ChildCategoriaPostQuery rightJoinWith($relation) Adds a RIGHT JOIN clause and with to the query
 * @method     ChildCategoriaPostQuery innerJoinWith($relation) Adds a INNER JOIN clause and with to the query
 *
 * @method     ChildCategoriaPostQuery leftJoinPostCategoria($relationAlias = null) Adds a LEFT JOIN clause to the query using the PostCategoria relation
 * @method     ChildCategoriaPostQuery rightJoinPostCategoria($relationAlias = null) Adds a RIGHT JOIN clause to the query using the PostCategoria relation
 * @method     ChildCategoriaPostQuery innerJoinPostCategoria($relationAlias = null) Adds a INNER JOIN clause to the query using the PostCategoria relation
 *
 * @method     ChildCategoriaPostQuery joinWithPostCategoria($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the PostCategoria relation
 *
 * @method     ChildCategoriaPostQuery leftJoinWithPostCategoria() Adds a LEFT JOIN clause and with to the query using the PostCategoria relation
 * @method     ChildCategoriaPostQuery rightJoinWithPostCategoria() Adds a RIGHT JOIN clause and with to the query using the PostCategoria relation
 * @method     ChildCategoriaPostQuery innerJoinWithPostCategoria() Adds a INNER JOIN clause and with to the query using the PostCategoria relation
 *
 * @method     \PostCategoriaQuery endUse() Finalizes a secondary criteria and merges it with its primary Criteria
 *
 * @method     ChildCategoriaPost findOne(ConnectionInterface $con = null) Return the first ChildCategoriaPost matching the query
 * @method     ChildCategoriaPost findOneOrCreate(ConnectionInterface $con = null) Return the first ChildCategoriaPost matching the query, or a new ChildCategoriaPost object populated from the query conditions when no match is found
 *
 * @method     ChildCategoriaPost findOneById(int $id) Return the first ChildCategoriaPost filtered by the id column
 * @method     ChildCategoriaPost findOneByNome(string $nome) Return the first ChildCategoriaPost filtered by the nome column
 * @method     ChildCategoriaPost findOneByDescricao(string $descricao) Return the first ChildCategoriaPost filtered by the descricao column *

 * @method     ChildCategoriaPost requirePk($key, ConnectionInterface $con = null) Return the ChildCategoriaPost by primary key and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildCategoriaPost requireOne(ConnectionInterface $con = null) Return the first ChildCategoriaPost matching the query and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildCategoriaPost requireOneById(int $id) Return the first ChildCategoriaPost filtered by the id column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildCategoriaPost requireOneByNome(string $nome) Return the first ChildCategoriaPost filtered by the nome column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildCategoriaPost requireOneByDescricao(string $descricao) Return the first ChildCategoriaPost filtered by the descricao column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildCategoriaPost[]|ObjectCollection find(ConnectionInterface $con = null) Return ChildCategoriaPost objects based on current ModelCriteria
 * @method     ChildCategoriaPost[]|ObjectCollection findById(int $id) Return ChildCategoriaPost objects filtered by the id column
 * @method     ChildCategoriaPost[]|ObjectCollection findByNome(string $nome) Return ChildCategoriaPost objects filtered by the nome column
 * @method     ChildCategoriaPost[]|ObjectCollection findByDescricao(string $descricao) Return ChildCategoriaPost objects filtered by the descricao column
 * @method     ChildCategoriaPost[]|\Propel\Runtime\Util\PropelModelPager paginate($page = 1, $maxPerPage = 10, ConnectionInterface $con = null) Issue a SELECT query based on the current ModelCriteria and uses a page and a maximum number of results per page to compute an offset and a limit
 *
 */
abstract class CategoriaPostQuery extends ModelCriteria
{
    protected $entityNotFoundExceptionClass = '\\Propel\\Runtime\\Exception\\EntityNotFoundException';

    /**
     * Initializes internal state of \Base\CategoriaPostQuery object.
     *
     * @param     string $dbName The database name
     * @param     string $modelName The phpName of a model, e.g. 'Book'
     * @param     string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = 'default', $modelName = '\\CategoriaPost', $modelAlias = null)
    {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new ChildCategoriaPostQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param     Criteria $criteria Optional Criteria to build the query from
     *
     * @return ChildCategoriaPostQuery
     */
    public static function create($modelAlias = null, Criteria $criteria = null)
    {
        if ($criteria instanceof ChildCategoriaPostQuery) {
            return $criteria;
        }
        $query = new ChildCategoriaPostQuery();
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
     * $obj  = $c->findPk(12, $con);
     * </code>
     *
     * @param mixed $key Primary key to use for the query
     * @param ConnectionInterface $con an optional connection object
     *
     * @return ChildCategoriaPost|array|mixed the result, formatted by the current formatter
     */
    public function findPk($key, ConnectionInterface $con = null)
    {
        if ($key === null) {
            return null;
        }

        if ($con === null) {
            $con = Propel::getServiceContainer()->getReadConnection(CategoriaPostTableMap::DATABASE_NAME);
        }

        $this->basePreSelect($con);

        if (
            $this->formatter || $this->modelAlias || $this->with || $this->select
            || $this->selectColumns || $this->asColumns || $this->selectModifiers
            || $this->map || $this->having || $this->joins
        ) {
            return $this->findPkComplex($key, $con);
        }

        if ((null !== ($obj = CategoriaPostTableMap::getInstanceFromPool(null === $key || is_scalar($key) || is_callable([$key, '__toString']) ? (string) $key : $key)))) {
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
     * @return ChildCategoriaPost A model object, or null if the key is not found
     */
    protected function findPkSimple($key, ConnectionInterface $con)
    {
        $sql = 'SELECT id, nome, descricao FROM categoria_post WHERE id = :p0';
        try {
            $stmt = $con->prepare($sql);
            $stmt->bindValue(':p0', $key, PDO::PARAM_INT);
            $stmt->execute();
        } catch (Exception $e) {
            Propel::log($e->getMessage(), Propel::LOG_ERR);
            throw new PropelException(sprintf('Unable to execute SELECT statement [%s]', $sql), 0, $e);
        }
        $obj = null;
        if ($row = $stmt->fetch(\PDO::FETCH_NUM)) {
            /** @var ChildCategoriaPost $obj */
            $obj = new ChildCategoriaPost();
            $obj->hydrate($row);
            CategoriaPostTableMap::addInstanceToPool($obj, null === $key || is_scalar($key) || is_callable([$key, '__toString']) ? (string) $key : $key);
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
     * @return ChildCategoriaPost|array|mixed the result, formatted by the current formatter
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
     * $objs = $c->findPks(array(12, 56, 832), $con);
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
     * @return $this|ChildCategoriaPostQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {

        return $this->addUsingAlias(CategoriaPostTableMap::COL_ID, $key, Criteria::EQUAL);
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return $this|ChildCategoriaPostQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {

        return $this->addUsingAlias(CategoriaPostTableMap::COL_ID, $keys, Criteria::IN);
    }

    /**
     * Filter the query on the id column
     *
     * Example usage:
     * <code>
     * $query->filterById(1234); // WHERE id = 1234
     * $query->filterById(array(12, 34)); // WHERE id IN (12, 34)
     * $query->filterById(array('min' => 12)); // WHERE id > 12
     * </code>
     *
     * @param     mixed $id The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildCategoriaPostQuery The current query, for fluid interface
     */
    public function filterById($id = null, $comparison = null)
    {
        if (is_array($id)) {
            $useMinMax = false;
            if (isset($id['min'])) {
                $this->addUsingAlias(CategoriaPostTableMap::COL_ID, $id['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($id['max'])) {
                $this->addUsingAlias(CategoriaPostTableMap::COL_ID, $id['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(CategoriaPostTableMap::COL_ID, $id, $comparison);
    }

    /**
     * Filter the query on the nome column
     *
     * Example usage:
     * <code>
     * $query->filterByNome('fooValue');   // WHERE nome = 'fooValue'
     * $query->filterByNome('%fooValue%', Criteria::LIKE); // WHERE nome LIKE '%fooValue%'
     * </code>
     *
     * @param     string $nome The value to use as filter.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildCategoriaPostQuery The current query, for fluid interface
     */
    public function filterByNome($nome = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($nome)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(CategoriaPostTableMap::COL_NOME, $nome, $comparison);
    }

    /**
     * Filter the query on the descricao column
     *
     * Example usage:
     * <code>
     * $query->filterByDescricao('fooValue');   // WHERE descricao = 'fooValue'
     * $query->filterByDescricao('%fooValue%', Criteria::LIKE); // WHERE descricao LIKE '%fooValue%'
     * </code>
     *
     * @param     string $descricao The value to use as filter.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildCategoriaPostQuery The current query, for fluid interface
     */
    public function filterByDescricao($descricao = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($descricao)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(CategoriaPostTableMap::COL_DESCRICAO, $descricao, $comparison);
    }

    /**
     * Filter the query by a related \PostCategoria object
     *
     * @param \PostCategoria|ObjectCollection $postCategoria the related object to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildCategoriaPostQuery The current query, for fluid interface
     */
    public function filterByPostCategoria($postCategoria, $comparison = null)
    {
        if ($postCategoria instanceof \PostCategoria) {
            return $this
                ->addUsingAlias(CategoriaPostTableMap::COL_ID, $postCategoria->getIdcategoria(), $comparison);
        } elseif ($postCategoria instanceof ObjectCollection) {
            return $this
                ->usePostCategoriaQuery()
                ->filterByPrimaryKeys($postCategoria->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterByPostCategoria() only accepts arguments of type \PostCategoria or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the PostCategoria relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildCategoriaPostQuery The current query, for fluid interface
     */
    public function joinPostCategoria($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('PostCategoria');

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
            $this->addJoinObject($join, 'PostCategoria');
        }

        return $this;
    }

    /**
     * Use the PostCategoria relation PostCategoria object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \PostCategoriaQuery A secondary query class using the current class as primary query
     */
    public function usePostCategoriaQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinPostCategoria($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'PostCategoria', '\PostCategoriaQuery');
    }

    /**
     * Exclude object from result
     *
     * @param   ChildCategoriaPost $categoriaPost Object to remove from the list of results
     *
     * @return $this|ChildCategoriaPostQuery The current query, for fluid interface
     */
    public function prune($categoriaPost = null)
    {
        if ($categoriaPost) {
            $this->addUsingAlias(CategoriaPostTableMap::COL_ID, $categoriaPost->getId(), Criteria::NOT_EQUAL);
        }

        return $this;
    }

    /**
     * Deletes all rows from the categoria_post table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public function doDeleteAll(ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(CategoriaPostTableMap::DATABASE_NAME);
        }

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con) {
            $affectedRows = 0; // initialize var to track total num of affected rows
            $affectedRows += parent::doDeleteAll($con);
            // Because this db requires some delete cascade/set null emulation, we have to
            // clear the cached instance *after* the emulation has happened (since
            // instances get re-added by the select statement contained therein).
            CategoriaPostTableMap::clearInstancePool();
            CategoriaPostTableMap::clearRelatedInstancePool();

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
            $con = Propel::getServiceContainer()->getWriteConnection(CategoriaPostTableMap::DATABASE_NAME);
        }

        $criteria = $this;

        // Set the correct dbName
        $criteria->setDbName(CategoriaPostTableMap::DATABASE_NAME);

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con, $criteria) {
            $affectedRows = 0; // initialize var to track total num of affected rows

            CategoriaPostTableMap::removeInstanceFromPool($criteria);

            $affectedRows += ModelCriteria::delete($con);
            CategoriaPostTableMap::clearRelatedInstancePool();

            return $affectedRows;
        });
    }

} // CategoriaPostQuery
