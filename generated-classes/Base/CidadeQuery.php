<?php

namespace Base;

use \Cidade as ChildCidade;
use \CidadeQuery as ChildCidadeQuery;
use \Exception;
use \PDO;
use Map\CidadeTableMap;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\ModelCriteria;
use Propel\Runtime\ActiveQuery\ModelJoin;
use Propel\Runtime\Collection\ObjectCollection;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\Exception\PropelException;

/**
 * Base class that represents a query for the 'cidade' table.
 *
 *
 *
 * @method     ChildCidadeQuery orderById($order = Criteria::ASC) Order by the id column
 * @method     ChildCidadeQuery orderByNome($order = Criteria::ASC) Order by the nome column
 * @method     ChildCidadeQuery orderByUf($order = Criteria::ASC) Order by the uf column
 *
 * @method     ChildCidadeQuery groupById() Group by the id column
 * @method     ChildCidadeQuery groupByNome() Group by the nome column
 * @method     ChildCidadeQuery groupByUf() Group by the uf column
 *
 * @method     ChildCidadeQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method     ChildCidadeQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method     ChildCidadeQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method     ChildCidadeQuery leftJoinWith($relation) Adds a LEFT JOIN clause and with to the query
 * @method     ChildCidadeQuery rightJoinWith($relation) Adds a RIGHT JOIN clause and with to the query
 * @method     ChildCidadeQuery innerJoinWith($relation) Adds a INNER JOIN clause and with to the query
 *
 * @method     ChildCidadeQuery leftJoinComunidade($relationAlias = null) Adds a LEFT JOIN clause to the query using the Comunidade relation
 * @method     ChildCidadeQuery rightJoinComunidade($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Comunidade relation
 * @method     ChildCidadeQuery innerJoinComunidade($relationAlias = null) Adds a INNER JOIN clause to the query using the Comunidade relation
 *
 * @method     ChildCidadeQuery joinWithComunidade($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the Comunidade relation
 *
 * @method     ChildCidadeQuery leftJoinWithComunidade() Adds a LEFT JOIN clause and with to the query using the Comunidade relation
 * @method     ChildCidadeQuery rightJoinWithComunidade() Adds a RIGHT JOIN clause and with to the query using the Comunidade relation
 * @method     ChildCidadeQuery innerJoinWithComunidade() Adds a INNER JOIN clause and with to the query using the Comunidade relation
 *
 * @method     \ComunidadeQuery endUse() Finalizes a secondary criteria and merges it with its primary Criteria
 *
 * @method     ChildCidade findOne(ConnectionInterface $con = null) Return the first ChildCidade matching the query
 * @method     ChildCidade findOneOrCreate(ConnectionInterface $con = null) Return the first ChildCidade matching the query, or a new ChildCidade object populated from the query conditions when no match is found
 *
 * @method     ChildCidade findOneById(int $id) Return the first ChildCidade filtered by the id column
 * @method     ChildCidade findOneByNome(string $nome) Return the first ChildCidade filtered by the nome column
 * @method     ChildCidade findOneByUf(string $uf) Return the first ChildCidade filtered by the uf column *

 * @method     ChildCidade requirePk($key, ConnectionInterface $con = null) Return the ChildCidade by primary key and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildCidade requireOne(ConnectionInterface $con = null) Return the first ChildCidade matching the query and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildCidade requireOneById(int $id) Return the first ChildCidade filtered by the id column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildCidade requireOneByNome(string $nome) Return the first ChildCidade filtered by the nome column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildCidade requireOneByUf(string $uf) Return the first ChildCidade filtered by the uf column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildCidade[]|ObjectCollection find(ConnectionInterface $con = null) Return ChildCidade objects based on current ModelCriteria
 * @method     ChildCidade[]|ObjectCollection findById(int $id) Return ChildCidade objects filtered by the id column
 * @method     ChildCidade[]|ObjectCollection findByNome(string $nome) Return ChildCidade objects filtered by the nome column
 * @method     ChildCidade[]|ObjectCollection findByUf(string $uf) Return ChildCidade objects filtered by the uf column
 * @method     ChildCidade[]|\Propel\Runtime\Util\PropelModelPager paginate($page = 1, $maxPerPage = 10, ConnectionInterface $con = null) Issue a SELECT query based on the current ModelCriteria and uses a page and a maximum number of results per page to compute an offset and a limit
 *
 */
abstract class CidadeQuery extends ModelCriteria
{
    protected $entityNotFoundExceptionClass = '\\Propel\\Runtime\\Exception\\EntityNotFoundException';

    /**
     * Initializes internal state of \Base\CidadeQuery object.
     *
     * @param     string $dbName The database name
     * @param     string $modelName The phpName of a model, e.g. 'Book'
     * @param     string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = 'default', $modelName = '\\Cidade', $modelAlias = null)
    {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new ChildCidadeQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param     Criteria $criteria Optional Criteria to build the query from
     *
     * @return ChildCidadeQuery
     */
    public static function create($modelAlias = null, Criteria $criteria = null)
    {
        if ($criteria instanceof ChildCidadeQuery) {
            return $criteria;
        }
        $query = new ChildCidadeQuery();
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
     * @return ChildCidade|array|mixed the result, formatted by the current formatter
     */
    public function findPk($key, ConnectionInterface $con = null)
    {
        if ($key === null) {
            return null;
        }

        if ($con === null) {
            $con = Propel::getServiceContainer()->getReadConnection(CidadeTableMap::DATABASE_NAME);
        }

        $this->basePreSelect($con);

        if (
            $this->formatter || $this->modelAlias || $this->with || $this->select
            || $this->selectColumns || $this->asColumns || $this->selectModifiers
            || $this->map || $this->having || $this->joins
        ) {
            return $this->findPkComplex($key, $con);
        }

        if ((null !== ($obj = CidadeTableMap::getInstanceFromPool(null === $key || is_scalar($key) || is_callable([$key, '__toString']) ? (string) $key : $key)))) {
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
     * @return ChildCidade A model object, or null if the key is not found
     */
    protected function findPkSimple($key, ConnectionInterface $con)
    {
        $sql = 'SELECT id, nome, uf FROM cidade WHERE id = :p0';
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
            /** @var ChildCidade $obj */
            $obj = new ChildCidade();
            $obj->hydrate($row);
            CidadeTableMap::addInstanceToPool($obj, null === $key || is_scalar($key) || is_callable([$key, '__toString']) ? (string) $key : $key);
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
     * @return ChildCidade|array|mixed the result, formatted by the current formatter
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
     * @return $this|ChildCidadeQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {

        return $this->addUsingAlias(CidadeTableMap::COL_ID, $key, Criteria::EQUAL);
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return $this|ChildCidadeQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {

        return $this->addUsingAlias(CidadeTableMap::COL_ID, $keys, Criteria::IN);
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
     * @return $this|ChildCidadeQuery The current query, for fluid interface
     */
    public function filterById($id = null, $comparison = null)
    {
        if (is_array($id)) {
            $useMinMax = false;
            if (isset($id['min'])) {
                $this->addUsingAlias(CidadeTableMap::COL_ID, $id['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($id['max'])) {
                $this->addUsingAlias(CidadeTableMap::COL_ID, $id['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(CidadeTableMap::COL_ID, $id, $comparison);
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
     * @return $this|ChildCidadeQuery The current query, for fluid interface
     */
    public function filterByNome($nome = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($nome)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(CidadeTableMap::COL_NOME, $nome, $comparison);
    }

    /**
     * Filter the query on the uf column
     *
     * Example usage:
     * <code>
     * $query->filterByUf('fooValue');   // WHERE uf = 'fooValue'
     * $query->filterByUf('%fooValue%', Criteria::LIKE); // WHERE uf LIKE '%fooValue%'
     * </code>
     *
     * @param     string $uf The value to use as filter.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildCidadeQuery The current query, for fluid interface
     */
    public function filterByUf($uf = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($uf)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(CidadeTableMap::COL_UF, $uf, $comparison);
    }

    /**
     * Filter the query by a related \Comunidade object
     *
     * @param \Comunidade|ObjectCollection $comunidade the related object to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildCidadeQuery The current query, for fluid interface
     */
    public function filterByComunidade($comunidade, $comparison = null)
    {
        if ($comunidade instanceof \Comunidade) {
            return $this
                ->addUsingAlias(CidadeTableMap::COL_ID, $comunidade->getIdcidade(), $comparison);
        } elseif ($comunidade instanceof ObjectCollection) {
            return $this
                ->useComunidadeQuery()
                ->filterByPrimaryKeys($comunidade->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterByComunidade() only accepts arguments of type \Comunidade or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the Comunidade relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildCidadeQuery The current query, for fluid interface
     */
    public function joinComunidade($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('Comunidade');

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
            $this->addJoinObject($join, 'Comunidade');
        }

        return $this;
    }

    /**
     * Use the Comunidade relation Comunidade object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \ComunidadeQuery A secondary query class using the current class as primary query
     */
    public function useComunidadeQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinComunidade($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'Comunidade', '\ComunidadeQuery');
    }

    /**
     * Exclude object from result
     *
     * @param   ChildCidade $cidade Object to remove from the list of results
     *
     * @return $this|ChildCidadeQuery The current query, for fluid interface
     */
    public function prune($cidade = null)
    {
        if ($cidade) {
            $this->addUsingAlias(CidadeTableMap::COL_ID, $cidade->getId(), Criteria::NOT_EQUAL);
        }

        return $this;
    }

    /**
     * Deletes all rows from the cidade table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public function doDeleteAll(ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(CidadeTableMap::DATABASE_NAME);
        }

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con) {
            $affectedRows = 0; // initialize var to track total num of affected rows
            $affectedRows += parent::doDeleteAll($con);
            // Because this db requires some delete cascade/set null emulation, we have to
            // clear the cached instance *after* the emulation has happened (since
            // instances get re-added by the select statement contained therein).
            CidadeTableMap::clearInstancePool();
            CidadeTableMap::clearRelatedInstancePool();

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
            $con = Propel::getServiceContainer()->getWriteConnection(CidadeTableMap::DATABASE_NAME);
        }

        $criteria = $this;

        // Set the correct dbName
        $criteria->setDbName(CidadeTableMap::DATABASE_NAME);

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con, $criteria) {
            $affectedRows = 0; // initialize var to track total num of affected rows

            CidadeTableMap::removeInstanceFromPool($criteria);

            $affectedRows += ModelCriteria::delete($con);
            CidadeTableMap::clearRelatedInstancePool();

            return $affectedRows;
        });
    }

} // CidadeQuery
