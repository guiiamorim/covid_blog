<?php

namespace Base;

use \Report as ChildReport;
use \ReportQuery as ChildReportQuery;
use \Exception;
use \PDO;
use Map\ReportTableMap;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\ModelCriteria;
use Propel\Runtime\ActiveQuery\ModelJoin;
use Propel\Runtime\Collection\ObjectCollection;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\Exception\PropelException;

/**
 * Base class that represents a query for the 'report' table.
 *
 *
 *
 * @method     ChildReportQuery orderById($order = Criteria::ASC) Order by the id column
 * @method     ChildReportQuery orderByIdusuario($order = Criteria::ASC) Order by the idUsuario column
 * @method     ChildReportQuery orderByComentario($order = Criteria::ASC) Order by the comentario column
 * @method     ChildReportQuery orderByIdcategoria($order = Criteria::ASC) Order by the idCategoria column
 *
 * @method     ChildReportQuery groupById() Group by the id column
 * @method     ChildReportQuery groupByIdusuario() Group by the idUsuario column
 * @method     ChildReportQuery groupByComentario() Group by the comentario column
 * @method     ChildReportQuery groupByIdcategoria() Group by the idCategoria column
 *
 * @method     ChildReportQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method     ChildReportQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method     ChildReportQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method     ChildReportQuery leftJoinWith($relation) Adds a LEFT JOIN clause and with to the query
 * @method     ChildReportQuery rightJoinWith($relation) Adds a RIGHT JOIN clause and with to the query
 * @method     ChildReportQuery innerJoinWith($relation) Adds a INNER JOIN clause and with to the query
 *
 * @method     ChildReportQuery leftJoinCategoriaReport($relationAlias = null) Adds a LEFT JOIN clause to the query using the CategoriaReport relation
 * @method     ChildReportQuery rightJoinCategoriaReport($relationAlias = null) Adds a RIGHT JOIN clause to the query using the CategoriaReport relation
 * @method     ChildReportQuery innerJoinCategoriaReport($relationAlias = null) Adds a INNER JOIN clause to the query using the CategoriaReport relation
 *
 * @method     ChildReportQuery joinWithCategoriaReport($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the CategoriaReport relation
 *
 * @method     ChildReportQuery leftJoinWithCategoriaReport() Adds a LEFT JOIN clause and with to the query using the CategoriaReport relation
 * @method     ChildReportQuery rightJoinWithCategoriaReport() Adds a RIGHT JOIN clause and with to the query using the CategoriaReport relation
 * @method     ChildReportQuery innerJoinWithCategoriaReport() Adds a INNER JOIN clause and with to the query using the CategoriaReport relation
 *
 * @method     ChildReportQuery leftJoinPostReport($relationAlias = null) Adds a LEFT JOIN clause to the query using the PostReport relation
 * @method     ChildReportQuery rightJoinPostReport($relationAlias = null) Adds a RIGHT JOIN clause to the query using the PostReport relation
 * @method     ChildReportQuery innerJoinPostReport($relationAlias = null) Adds a INNER JOIN clause to the query using the PostReport relation
 *
 * @method     ChildReportQuery joinWithPostReport($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the PostReport relation
 *
 * @method     ChildReportQuery leftJoinWithPostReport() Adds a LEFT JOIN clause and with to the query using the PostReport relation
 * @method     ChildReportQuery rightJoinWithPostReport() Adds a RIGHT JOIN clause and with to the query using the PostReport relation
 * @method     ChildReportQuery innerJoinWithPostReport() Adds a INNER JOIN clause and with to the query using the PostReport relation
 *
 * @method     \CategoriaReportQuery|\PostReportQuery endUse() Finalizes a secondary criteria and merges it with its primary Criteria
 *
 * @method     ChildReport findOne(ConnectionInterface $con = null) Return the first ChildReport matching the query
 * @method     ChildReport findOneOrCreate(ConnectionInterface $con = null) Return the first ChildReport matching the query, or a new ChildReport object populated from the query conditions when no match is found
 *
 * @method     ChildReport findOneById(int $id) Return the first ChildReport filtered by the id column
 * @method     ChildReport findOneByIdusuario(int $idUsuario) Return the first ChildReport filtered by the idUsuario column
 * @method     ChildReport findOneByComentario(string $comentario) Return the first ChildReport filtered by the comentario column
 * @method     ChildReport findOneByIdcategoria(int $idCategoria) Return the first ChildReport filtered by the idCategoria column *

 * @method     ChildReport requirePk($key, ConnectionInterface $con = null) Return the ChildReport by primary key and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildReport requireOne(ConnectionInterface $con = null) Return the first ChildReport matching the query and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildReport requireOneById(int $id) Return the first ChildReport filtered by the id column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildReport requireOneByIdusuario(int $idUsuario) Return the first ChildReport filtered by the idUsuario column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildReport requireOneByComentario(string $comentario) Return the first ChildReport filtered by the comentario column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildReport requireOneByIdcategoria(int $idCategoria) Return the first ChildReport filtered by the idCategoria column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildReport[]|ObjectCollection find(ConnectionInterface $con = null) Return ChildReport objects based on current ModelCriteria
 * @method     ChildReport[]|ObjectCollection findById(int $id) Return ChildReport objects filtered by the id column
 * @method     ChildReport[]|ObjectCollection findByIdusuario(int $idUsuario) Return ChildReport objects filtered by the idUsuario column
 * @method     ChildReport[]|ObjectCollection findByComentario(string $comentario) Return ChildReport objects filtered by the comentario column
 * @method     ChildReport[]|ObjectCollection findByIdcategoria(int $idCategoria) Return ChildReport objects filtered by the idCategoria column
 * @method     ChildReport[]|\Propel\Runtime\Util\PropelModelPager paginate($page = 1, $maxPerPage = 10, ConnectionInterface $con = null) Issue a SELECT query based on the current ModelCriteria and uses a page and a maximum number of results per page to compute an offset and a limit
 *
 */
abstract class ReportQuery extends ModelCriteria
{
    protected $entityNotFoundExceptionClass = '\\Propel\\Runtime\\Exception\\EntityNotFoundException';

    /**
     * Initializes internal state of \Base\ReportQuery object.
     *
     * @param     string $dbName The database name
     * @param     string $modelName The phpName of a model, e.g. 'Book'
     * @param     string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = 'default', $modelName = '\\Report', $modelAlias = null)
    {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new ChildReportQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param     Criteria $criteria Optional Criteria to build the query from
     *
     * @return ChildReportQuery
     */
    public static function create($modelAlias = null, Criteria $criteria = null)
    {
        if ($criteria instanceof ChildReportQuery) {
            return $criteria;
        }
        $query = new ChildReportQuery();
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
     * @return ChildReport|array|mixed the result, formatted by the current formatter
     */
    public function findPk($key, ConnectionInterface $con = null)
    {
        if ($key === null) {
            return null;
        }

        if ($con === null) {
            $con = Propel::getServiceContainer()->getReadConnection(ReportTableMap::DATABASE_NAME);
        }

        $this->basePreSelect($con);

        if (
            $this->formatter || $this->modelAlias || $this->with || $this->select
            || $this->selectColumns || $this->asColumns || $this->selectModifiers
            || $this->map || $this->having || $this->joins
        ) {
            return $this->findPkComplex($key, $con);
        }

        if ((null !== ($obj = ReportTableMap::getInstanceFromPool(null === $key || is_scalar($key) || is_callable([$key, '__toString']) ? (string) $key : $key)))) {
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
     * @return ChildReport A model object, or null if the key is not found
     */
    protected function findPkSimple($key, ConnectionInterface $con)
    {
        $sql = 'SELECT id, idUsuario, comentario, idCategoria FROM report WHERE id = :p0';
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
            /** @var ChildReport $obj */
            $obj = new ChildReport();
            $obj->hydrate($row);
            ReportTableMap::addInstanceToPool($obj, null === $key || is_scalar($key) || is_callable([$key, '__toString']) ? (string) $key : $key);
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
     * @return ChildReport|array|mixed the result, formatted by the current formatter
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
     * @return $this|ChildReportQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {

        return $this->addUsingAlias(ReportTableMap::COL_ID, $key, Criteria::EQUAL);
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return $this|ChildReportQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {

        return $this->addUsingAlias(ReportTableMap::COL_ID, $keys, Criteria::IN);
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
     * @return $this|ChildReportQuery The current query, for fluid interface
     */
    public function filterById($id = null, $comparison = null)
    {
        if (is_array($id)) {
            $useMinMax = false;
            if (isset($id['min'])) {
                $this->addUsingAlias(ReportTableMap::COL_ID, $id['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($id['max'])) {
                $this->addUsingAlias(ReportTableMap::COL_ID, $id['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(ReportTableMap::COL_ID, $id, $comparison);
    }

    /**
     * Filter the query on the idUsuario column
     *
     * Example usage:
     * <code>
     * $query->filterByIdusuario(1234); // WHERE idUsuario = 1234
     * $query->filterByIdusuario(array(12, 34)); // WHERE idUsuario IN (12, 34)
     * $query->filterByIdusuario(array('min' => 12)); // WHERE idUsuario > 12
     * </code>
     *
     * @param     mixed $idusuario The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildReportQuery The current query, for fluid interface
     */
    public function filterByIdusuario($idusuario = null, $comparison = null)
    {
        if (is_array($idusuario)) {
            $useMinMax = false;
            if (isset($idusuario['min'])) {
                $this->addUsingAlias(ReportTableMap::COL_IDUSUARIO, $idusuario['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($idusuario['max'])) {
                $this->addUsingAlias(ReportTableMap::COL_IDUSUARIO, $idusuario['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(ReportTableMap::COL_IDUSUARIO, $idusuario, $comparison);
    }

    /**
     * Filter the query on the comentario column
     *
     * Example usage:
     * <code>
     * $query->filterByComentario('fooValue');   // WHERE comentario = 'fooValue'
     * $query->filterByComentario('%fooValue%', Criteria::LIKE); // WHERE comentario LIKE '%fooValue%'
     * </code>
     *
     * @param     string $comentario The value to use as filter.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildReportQuery The current query, for fluid interface
     */
    public function filterByComentario($comentario = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($comentario)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(ReportTableMap::COL_COMENTARIO, $comentario, $comparison);
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
     * @see       filterByCategoriaReport()
     *
     * @param     mixed $idcategoria The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildReportQuery The current query, for fluid interface
     */
    public function filterByIdcategoria($idcategoria = null, $comparison = null)
    {
        if (is_array($idcategoria)) {
            $useMinMax = false;
            if (isset($idcategoria['min'])) {
                $this->addUsingAlias(ReportTableMap::COL_IDCATEGORIA, $idcategoria['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($idcategoria['max'])) {
                $this->addUsingAlias(ReportTableMap::COL_IDCATEGORIA, $idcategoria['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(ReportTableMap::COL_IDCATEGORIA, $idcategoria, $comparison);
    }

    /**
     * Filter the query by a related \CategoriaReport object
     *
     * @param \CategoriaReport|ObjectCollection $categoriaReport The related object(s) to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @throws \Propel\Runtime\Exception\PropelException
     *
     * @return ChildReportQuery The current query, for fluid interface
     */
    public function filterByCategoriaReport($categoriaReport, $comparison = null)
    {
        if ($categoriaReport instanceof \CategoriaReport) {
            return $this
                ->addUsingAlias(ReportTableMap::COL_IDCATEGORIA, $categoriaReport->getId(), $comparison);
        } elseif ($categoriaReport instanceof ObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(ReportTableMap::COL_IDCATEGORIA, $categoriaReport->toKeyValue('PrimaryKey', 'Id'), $comparison);
        } else {
            throw new PropelException('filterByCategoriaReport() only accepts arguments of type \CategoriaReport or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the CategoriaReport relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildReportQuery The current query, for fluid interface
     */
    public function joinCategoriaReport($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('CategoriaReport');

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
            $this->addJoinObject($join, 'CategoriaReport');
        }

        return $this;
    }

    /**
     * Use the CategoriaReport relation CategoriaReport object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \CategoriaReportQuery A secondary query class using the current class as primary query
     */
    public function useCategoriaReportQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinCategoriaReport($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'CategoriaReport', '\CategoriaReportQuery');
    }

    /**
     * Filter the query by a related \PostReport object
     *
     * @param \PostReport|ObjectCollection $postReport the related object to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildReportQuery The current query, for fluid interface
     */
    public function filterByPostReport($postReport, $comparison = null)
    {
        if ($postReport instanceof \PostReport) {
            return $this
                ->addUsingAlias(ReportTableMap::COL_ID, $postReport->getIdreport(), $comparison);
        } elseif ($postReport instanceof ObjectCollection) {
            return $this
                ->usePostReportQuery()
                ->filterByPrimaryKeys($postReport->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterByPostReport() only accepts arguments of type \PostReport or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the PostReport relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildReportQuery The current query, for fluid interface
     */
    public function joinPostReport($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('PostReport');

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
            $this->addJoinObject($join, 'PostReport');
        }

        return $this;
    }

    /**
     * Use the PostReport relation PostReport object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \PostReportQuery A secondary query class using the current class as primary query
     */
    public function usePostReportQuery($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        return $this
            ->joinPostReport($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'PostReport', '\PostReportQuery');
    }

    /**
     * Exclude object from result
     *
     * @param   ChildReport $report Object to remove from the list of results
     *
     * @return $this|ChildReportQuery The current query, for fluid interface
     */
    public function prune($report = null)
    {
        if ($report) {
            $this->addUsingAlias(ReportTableMap::COL_ID, $report->getId(), Criteria::NOT_EQUAL);
        }

        return $this;
    }

    /**
     * Deletes all rows from the report table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public function doDeleteAll(ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(ReportTableMap::DATABASE_NAME);
        }

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con) {
            $affectedRows = 0; // initialize var to track total num of affected rows
            $affectedRows += parent::doDeleteAll($con);
            // Because this db requires some delete cascade/set null emulation, we have to
            // clear the cached instance *after* the emulation has happened (since
            // instances get re-added by the select statement contained therein).
            ReportTableMap::clearInstancePool();
            ReportTableMap::clearRelatedInstancePool();

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
            $con = Propel::getServiceContainer()->getWriteConnection(ReportTableMap::DATABASE_NAME);
        }

        $criteria = $this;

        // Set the correct dbName
        $criteria->setDbName(ReportTableMap::DATABASE_NAME);

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con, $criteria) {
            $affectedRows = 0; // initialize var to track total num of affected rows

            ReportTableMap::removeInstanceFromPool($criteria);

            $affectedRows += ModelCriteria::delete($con);
            ReportTableMap::clearRelatedInstancePool();

            return $affectedRows;
        });
    }

} // ReportQuery
