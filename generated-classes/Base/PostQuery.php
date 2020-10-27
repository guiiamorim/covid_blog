<?php

namespace Base;

use \Post as ChildPost;
use \PostQuery as ChildPostQuery;
use \Exception;
use \PDO;
use Map\PostTableMap;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\ModelCriteria;
use Propel\Runtime\ActiveQuery\ModelJoin;
use Propel\Runtime\Collection\ObjectCollection;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\Exception\PropelException;

/**
 * Base class that represents a query for the 'post' table.
 *
 *
 *
 * @method     ChildPostQuery orderById($order = Criteria::ASC) Order by the id column
 * @method     ChildPostQuery orderByTitulo($order = Criteria::ASC) Order by the titulo column
 * @method     ChildPostQuery orderByTexto($order = Criteria::ASC) Order by the texto column
 * @method     ChildPostQuery orderByIdusuario($order = Criteria::ASC) Order by the idUsuario column
 * @method     ChildPostQuery orderByVisualizacoes($order = Criteria::ASC) Order by the visualizacoes column
 * @method     ChildPostQuery orderByDatacriacao($order = Criteria::ASC) Order by the dataCriacao column
 * @method     ChildPostQuery orderByStatus($order = Criteria::ASC) Order by the status column
 * @method     ChildPostQuery orderByCapa($order = Criteria::ASC) Order by the capa column
 *
 * @method     ChildPostQuery groupById() Group by the id column
 * @method     ChildPostQuery groupByTitulo() Group by the titulo column
 * @method     ChildPostQuery groupByTexto() Group by the texto column
 * @method     ChildPostQuery groupByIdusuario() Group by the idUsuario column
 * @method     ChildPostQuery groupByVisualizacoes() Group by the visualizacoes column
 * @method     ChildPostQuery groupByDatacriacao() Group by the dataCriacao column
 * @method     ChildPostQuery groupByStatus() Group by the status column
 * @method     ChildPostQuery groupByCapa() Group by the capa column
 *
 * @method     ChildPostQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method     ChildPostQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method     ChildPostQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method     ChildPostQuery leftJoinWith($relation) Adds a LEFT JOIN clause and with to the query
 * @method     ChildPostQuery rightJoinWith($relation) Adds a RIGHT JOIN clause and with to the query
 * @method     ChildPostQuery innerJoinWith($relation) Adds a INNER JOIN clause and with to the query
 *
 * @method     ChildPostQuery leftJoinPostCategoria($relationAlias = null) Adds a LEFT JOIN clause to the query using the PostCategoria relation
 * @method     ChildPostQuery rightJoinPostCategoria($relationAlias = null) Adds a RIGHT JOIN clause to the query using the PostCategoria relation
 * @method     ChildPostQuery innerJoinPostCategoria($relationAlias = null) Adds a INNER JOIN clause to the query using the PostCategoria relation
 *
 * @method     ChildPostQuery joinWithPostCategoria($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the PostCategoria relation
 *
 * @method     ChildPostQuery leftJoinWithPostCategoria() Adds a LEFT JOIN clause and with to the query using the PostCategoria relation
 * @method     ChildPostQuery rightJoinWithPostCategoria() Adds a RIGHT JOIN clause and with to the query using the PostCategoria relation
 * @method     ChildPostQuery innerJoinWithPostCategoria() Adds a INNER JOIN clause and with to the query using the PostCategoria relation
 *
 * @method     ChildPostQuery leftJoinPostReport($relationAlias = null) Adds a LEFT JOIN clause to the query using the PostReport relation
 * @method     ChildPostQuery rightJoinPostReport($relationAlias = null) Adds a RIGHT JOIN clause to the query using the PostReport relation
 * @method     ChildPostQuery innerJoinPostReport($relationAlias = null) Adds a INNER JOIN clause to the query using the PostReport relation
 *
 * @method     ChildPostQuery joinWithPostReport($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the PostReport relation
 *
 * @method     ChildPostQuery leftJoinWithPostReport() Adds a LEFT JOIN clause and with to the query using the PostReport relation
 * @method     ChildPostQuery rightJoinWithPostReport() Adds a RIGHT JOIN clause and with to the query using the PostReport relation
 * @method     ChildPostQuery innerJoinWithPostReport() Adds a INNER JOIN clause and with to the query using the PostReport relation
 *
 * @method     ChildPostQuery leftJoinPostTagsRelatedByIdpost($relationAlias = null) Adds a LEFT JOIN clause to the query using the PostTagsRelatedByIdpost relation
 * @method     ChildPostQuery rightJoinPostTagsRelatedByIdpost($relationAlias = null) Adds a RIGHT JOIN clause to the query using the PostTagsRelatedByIdpost relation
 * @method     ChildPostQuery innerJoinPostTagsRelatedByIdpost($relationAlias = null) Adds a INNER JOIN clause to the query using the PostTagsRelatedByIdpost relation
 *
 * @method     ChildPostQuery joinWithPostTagsRelatedByIdpost($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the PostTagsRelatedByIdpost relation
 *
 * @method     ChildPostQuery leftJoinWithPostTagsRelatedByIdpost() Adds a LEFT JOIN clause and with to the query using the PostTagsRelatedByIdpost relation
 * @method     ChildPostQuery rightJoinWithPostTagsRelatedByIdpost() Adds a RIGHT JOIN clause and with to the query using the PostTagsRelatedByIdpost relation
 * @method     ChildPostQuery innerJoinWithPostTagsRelatedByIdpost() Adds a INNER JOIN clause and with to the query using the PostTagsRelatedByIdpost relation
 *
 * @method     ChildPostQuery leftJoinPostTagsRelatedByIdtag($relationAlias = null) Adds a LEFT JOIN clause to the query using the PostTagsRelatedByIdtag relation
 * @method     ChildPostQuery rightJoinPostTagsRelatedByIdtag($relationAlias = null) Adds a RIGHT JOIN clause to the query using the PostTagsRelatedByIdtag relation
 * @method     ChildPostQuery innerJoinPostTagsRelatedByIdtag($relationAlias = null) Adds a INNER JOIN clause to the query using the PostTagsRelatedByIdtag relation
 *
 * @method     ChildPostQuery joinWithPostTagsRelatedByIdtag($joinType = Criteria::INNER_JOIN) Adds a join clause and with to the query using the PostTagsRelatedByIdtag relation
 *
 * @method     ChildPostQuery leftJoinWithPostTagsRelatedByIdtag() Adds a LEFT JOIN clause and with to the query using the PostTagsRelatedByIdtag relation
 * @method     ChildPostQuery rightJoinWithPostTagsRelatedByIdtag() Adds a RIGHT JOIN clause and with to the query using the PostTagsRelatedByIdtag relation
 * @method     ChildPostQuery innerJoinWithPostTagsRelatedByIdtag() Adds a INNER JOIN clause and with to the query using the PostTagsRelatedByIdtag relation
 *
 * @method     \PostCategoriaQuery|\PostReportQuery|\PostTagsQuery endUse() Finalizes a secondary criteria and merges it with its primary Criteria
 *
 * @method     ChildPost findOne(ConnectionInterface $con = null) Return the first ChildPost matching the query
 * @method     ChildPost findOneOrCreate(ConnectionInterface $con = null) Return the first ChildPost matching the query, or a new ChildPost object populated from the query conditions when no match is found
 *
 * @method     ChildPost findOneById(int $id) Return the first ChildPost filtered by the id column
 * @method     ChildPost findOneByTitulo(string $titulo) Return the first ChildPost filtered by the titulo column
 * @method     ChildPost findOneByTexto(string $texto) Return the first ChildPost filtered by the texto column
 * @method     ChildPost findOneByIdusuario(int $idUsuario) Return the first ChildPost filtered by the idUsuario column
 * @method     ChildPost findOneByVisualizacoes(int $visualizacoes) Return the first ChildPost filtered by the visualizacoes column
 * @method     ChildPost findOneByDatacriacao(string $dataCriacao) Return the first ChildPost filtered by the dataCriacao column
 * @method     ChildPost findOneByStatus(string $status) Return the first ChildPost filtered by the status column
 * @method     ChildPost findOneByCapa(string $capa) Return the first ChildPost filtered by the capa column *

 * @method     ChildPost requirePk($key, ConnectionInterface $con = null) Return the ChildPost by primary key and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildPost requireOne(ConnectionInterface $con = null) Return the first ChildPost matching the query and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildPost requireOneById(int $id) Return the first ChildPost filtered by the id column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildPost requireOneByTitulo(string $titulo) Return the first ChildPost filtered by the titulo column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildPost requireOneByTexto(string $texto) Return the first ChildPost filtered by the texto column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildPost requireOneByIdusuario(int $idUsuario) Return the first ChildPost filtered by the idUsuario column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildPost requireOneByVisualizacoes(int $visualizacoes) Return the first ChildPost filtered by the visualizacoes column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildPost requireOneByDatacriacao(string $dataCriacao) Return the first ChildPost filtered by the dataCriacao column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildPost requireOneByStatus(string $status) Return the first ChildPost filtered by the status column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildPost requireOneByCapa(string $capa) Return the first ChildPost filtered by the capa column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildPost[]|ObjectCollection find(ConnectionInterface $con = null) Return ChildPost objects based on current ModelCriteria
 * @method     ChildPost[]|ObjectCollection findById(int $id) Return ChildPost objects filtered by the id column
 * @method     ChildPost[]|ObjectCollection findByTitulo(string $titulo) Return ChildPost objects filtered by the titulo column
 * @method     ChildPost[]|ObjectCollection findByTexto(string $texto) Return ChildPost objects filtered by the texto column
 * @method     ChildPost[]|ObjectCollection findByIdusuario(int $idUsuario) Return ChildPost objects filtered by the idUsuario column
 * @method     ChildPost[]|ObjectCollection findByVisualizacoes(int $visualizacoes) Return ChildPost objects filtered by the visualizacoes column
 * @method     ChildPost[]|ObjectCollection findByDatacriacao(string $dataCriacao) Return ChildPost objects filtered by the dataCriacao column
 * @method     ChildPost[]|ObjectCollection findByStatus(string $status) Return ChildPost objects filtered by the status column
 * @method     ChildPost[]|ObjectCollection findByCapa(string $capa) Return ChildPost objects filtered by the capa column
 * @method     ChildPost[]|\Propel\Runtime\Util\PropelModelPager paginate($page = 1, $maxPerPage = 10, ConnectionInterface $con = null) Issue a SELECT query based on the current ModelCriteria and uses a page and a maximum number of results per page to compute an offset and a limit
 *
 */
abstract class PostQuery extends ModelCriteria
{
    protected $entityNotFoundExceptionClass = '\\Propel\\Runtime\\Exception\\EntityNotFoundException';

    /**
     * Initializes internal state of \Base\PostQuery object.
     *
     * @param     string $dbName The database name
     * @param     string $modelName The phpName of a model, e.g. 'Book'
     * @param     string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = 'default', $modelName = '\\Post', $modelAlias = null)
    {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new ChildPostQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param     Criteria $criteria Optional Criteria to build the query from
     *
     * @return ChildPostQuery
     */
    public static function create($modelAlias = null, Criteria $criteria = null)
    {
        if ($criteria instanceof ChildPostQuery) {
            return $criteria;
        }
        $query = new ChildPostQuery();
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
     * @return ChildPost|array|mixed the result, formatted by the current formatter
     */
    public function findPk($key, ConnectionInterface $con = null)
    {
        if ($key === null) {
            return null;
        }

        if ($con === null) {
            $con = Propel::getServiceContainer()->getReadConnection(PostTableMap::DATABASE_NAME);
        }

        $this->basePreSelect($con);

        if (
            $this->formatter || $this->modelAlias || $this->with || $this->select
            || $this->selectColumns || $this->asColumns || $this->selectModifiers
            || $this->map || $this->having || $this->joins
        ) {
            return $this->findPkComplex($key, $con);
        }

        if ((null !== ($obj = PostTableMap::getInstanceFromPool(null === $key || is_scalar($key) || is_callable([$key, '__toString']) ? (string) $key : $key)))) {
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
     * @return ChildPost A model object, or null if the key is not found
     */
    protected function findPkSimple($key, ConnectionInterface $con)
    {
        $sql = 'SELECT id, titulo, texto, idUsuario, visualizacoes, dataCriacao, status, capa FROM post WHERE id = :p0';
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
            /** @var ChildPost $obj */
            $obj = new ChildPost();
            $obj->hydrate($row);
            PostTableMap::addInstanceToPool($obj, null === $key || is_scalar($key) || is_callable([$key, '__toString']) ? (string) $key : $key);
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
     * @return ChildPost|array|mixed the result, formatted by the current formatter
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
     * @return $this|ChildPostQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {

        return $this->addUsingAlias(PostTableMap::COL_ID, $key, Criteria::EQUAL);
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return $this|ChildPostQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {

        return $this->addUsingAlias(PostTableMap::COL_ID, $keys, Criteria::IN);
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
     * @return $this|ChildPostQuery The current query, for fluid interface
     */
    public function filterById($id = null, $comparison = null)
    {
        if (is_array($id)) {
            $useMinMax = false;
            if (isset($id['min'])) {
                $this->addUsingAlias(PostTableMap::COL_ID, $id['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($id['max'])) {
                $this->addUsingAlias(PostTableMap::COL_ID, $id['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(PostTableMap::COL_ID, $id, $comparison);
    }

    /**
     * Filter the query on the titulo column
     *
     * Example usage:
     * <code>
     * $query->filterByTitulo('fooValue');   // WHERE titulo = 'fooValue'
     * $query->filterByTitulo('%fooValue%', Criteria::LIKE); // WHERE titulo LIKE '%fooValue%'
     * </code>
     *
     * @param     string $titulo The value to use as filter.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildPostQuery The current query, for fluid interface
     */
    public function filterByTitulo($titulo = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($titulo)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(PostTableMap::COL_TITULO, $titulo, $comparison);
    }

    /**
     * Filter the query on the texto column
     *
     * Example usage:
     * <code>
     * $query->filterByTexto('fooValue');   // WHERE texto = 'fooValue'
     * $query->filterByTexto('%fooValue%', Criteria::LIKE); // WHERE texto LIKE '%fooValue%'
     * </code>
     *
     * @param     string $texto The value to use as filter.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildPostQuery The current query, for fluid interface
     */
    public function filterByTexto($texto = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($texto)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(PostTableMap::COL_TEXTO, $texto, $comparison);
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
     * @return $this|ChildPostQuery The current query, for fluid interface
     */
    public function filterByIdusuario($idusuario = null, $comparison = null)
    {
        if (is_array($idusuario)) {
            $useMinMax = false;
            if (isset($idusuario['min'])) {
                $this->addUsingAlias(PostTableMap::COL_IDUSUARIO, $idusuario['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($idusuario['max'])) {
                $this->addUsingAlias(PostTableMap::COL_IDUSUARIO, $idusuario['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(PostTableMap::COL_IDUSUARIO, $idusuario, $comparison);
    }

    /**
     * Filter the query on the visualizacoes column
     *
     * Example usage:
     * <code>
     * $query->filterByVisualizacoes(1234); // WHERE visualizacoes = 1234
     * $query->filterByVisualizacoes(array(12, 34)); // WHERE visualizacoes IN (12, 34)
     * $query->filterByVisualizacoes(array('min' => 12)); // WHERE visualizacoes > 12
     * </code>
     *
     * @param     mixed $visualizacoes The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildPostQuery The current query, for fluid interface
     */
    public function filterByVisualizacoes($visualizacoes = null, $comparison = null)
    {
        if (is_array($visualizacoes)) {
            $useMinMax = false;
            if (isset($visualizacoes['min'])) {
                $this->addUsingAlias(PostTableMap::COL_VISUALIZACOES, $visualizacoes['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($visualizacoes['max'])) {
                $this->addUsingAlias(PostTableMap::COL_VISUALIZACOES, $visualizacoes['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(PostTableMap::COL_VISUALIZACOES, $visualizacoes, $comparison);
    }

    /**
     * Filter the query on the dataCriacao column
     *
     * Example usage:
     * <code>
     * $query->filterByDatacriacao('2011-03-14'); // WHERE dataCriacao = '2011-03-14'
     * $query->filterByDatacriacao('now'); // WHERE dataCriacao = '2011-03-14'
     * $query->filterByDatacriacao(array('max' => 'yesterday')); // WHERE dataCriacao > '2011-03-13'
     * </code>
     *
     * @param     mixed $datacriacao The value to use as filter.
     *              Values can be integers (unix timestamps), DateTime objects, or strings.
     *              Empty strings are treated as NULL.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildPostQuery The current query, for fluid interface
     */
    public function filterByDatacriacao($datacriacao = null, $comparison = null)
    {
        if (is_array($datacriacao)) {
            $useMinMax = false;
            if (isset($datacriacao['min'])) {
                $this->addUsingAlias(PostTableMap::COL_DATACRIACAO, $datacriacao['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($datacriacao['max'])) {
                $this->addUsingAlias(PostTableMap::COL_DATACRIACAO, $datacriacao['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(PostTableMap::COL_DATACRIACAO, $datacriacao, $comparison);
    }

    /**
     * Filter the query on the status column
     *
     * Example usage:
     * <code>
     * $query->filterByStatus('fooValue');   // WHERE status = 'fooValue'
     * $query->filterByStatus('%fooValue%', Criteria::LIKE); // WHERE status LIKE '%fooValue%'
     * </code>
     *
     * @param     string $status The value to use as filter.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildPostQuery The current query, for fluid interface
     */
    public function filterByStatus($status = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($status)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(PostTableMap::COL_STATUS, $status, $comparison);
    }

    /**
     * Filter the query on the capa column
     *
     * Example usage:
     * <code>
     * $query->filterByCapa('fooValue');   // WHERE capa = 'fooValue'
     * $query->filterByCapa('%fooValue%', Criteria::LIKE); // WHERE capa LIKE '%fooValue%'
     * </code>
     *
     * @param     string $capa The value to use as filter.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildPostQuery The current query, for fluid interface
     */
    public function filterByCapa($capa = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($capa)) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(PostTableMap::COL_CAPA, $capa, $comparison);
    }

    /**
     * Filter the query by a related \PostCategoria object
     *
     * @param \PostCategoria|ObjectCollection $postCategoria the related object to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildPostQuery The current query, for fluid interface
     */
    public function filterByPostCategoria($postCategoria, $comparison = null)
    {
        if ($postCategoria instanceof \PostCategoria) {
            return $this
                ->addUsingAlias(PostTableMap::COL_ID, $postCategoria->getIdpost(), $comparison);
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
     * @return $this|ChildPostQuery The current query, for fluid interface
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
     * Filter the query by a related \PostReport object
     *
     * @param \PostReport|ObjectCollection $postReport the related object to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildPostQuery The current query, for fluid interface
     */
    public function filterByPostReport($postReport, $comparison = null)
    {
        if ($postReport instanceof \PostReport) {
            return $this
                ->addUsingAlias(PostTableMap::COL_ID, $postReport->getIdpost(), $comparison);
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
     * @return $this|ChildPostQuery The current query, for fluid interface
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
     * Filter the query by a related \PostTags object
     *
     * @param \PostTags|ObjectCollection $postTags the related object to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildPostQuery The current query, for fluid interface
     */
    public function filterByPostTagsRelatedByIdpost($postTags, $comparison = null)
    {
        if ($postTags instanceof \PostTags) {
            return $this
                ->addUsingAlias(PostTableMap::COL_ID, $postTags->getIdpost(), $comparison);
        } elseif ($postTags instanceof ObjectCollection) {
            return $this
                ->usePostTagsRelatedByIdpostQuery()
                ->filterByPrimaryKeys($postTags->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterByPostTagsRelatedByIdpost() only accepts arguments of type \PostTags or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the PostTagsRelatedByIdpost relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildPostQuery The current query, for fluid interface
     */
    public function joinPostTagsRelatedByIdpost($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('PostTagsRelatedByIdpost');

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
            $this->addJoinObject($join, 'PostTagsRelatedByIdpost');
        }

        return $this;
    }

    /**
     * Use the PostTagsRelatedByIdpost relation PostTags object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \PostTagsQuery A secondary query class using the current class as primary query
     */
    public function usePostTagsRelatedByIdpostQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinPostTagsRelatedByIdpost($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'PostTagsRelatedByIdpost', '\PostTagsQuery');
    }

    /**
     * Filter the query by a related \PostTags object
     *
     * @param \PostTags|ObjectCollection $postTags the related object to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildPostQuery The current query, for fluid interface
     */
    public function filterByPostTagsRelatedByIdtag($postTags, $comparison = null)
    {
        if ($postTags instanceof \PostTags) {
            return $this
                ->addUsingAlias(PostTableMap::COL_ID, $postTags->getIdtag(), $comparison);
        } elseif ($postTags instanceof ObjectCollection) {
            return $this
                ->usePostTagsRelatedByIdtagQuery()
                ->filterByPrimaryKeys($postTags->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterByPostTagsRelatedByIdtag() only accepts arguments of type \PostTags or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the PostTagsRelatedByIdtag relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildPostQuery The current query, for fluid interface
     */
    public function joinPostTagsRelatedByIdtag($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('PostTagsRelatedByIdtag');

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
            $this->addJoinObject($join, 'PostTagsRelatedByIdtag');
        }

        return $this;
    }

    /**
     * Use the PostTagsRelatedByIdtag relation PostTags object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \PostTagsQuery A secondary query class using the current class as primary query
     */
    public function usePostTagsRelatedByIdtagQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinPostTagsRelatedByIdtag($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'PostTagsRelatedByIdtag', '\PostTagsQuery');
    }

    /**
     * Exclude object from result
     *
     * @param   ChildPost $post Object to remove from the list of results
     *
     * @return $this|ChildPostQuery The current query, for fluid interface
     */
    public function prune($post = null)
    {
        if ($post) {
            $this->addUsingAlias(PostTableMap::COL_ID, $post->getId(), Criteria::NOT_EQUAL);
        }

        return $this;
    }

    /**
     * Deletes all rows from the post table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public function doDeleteAll(ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(PostTableMap::DATABASE_NAME);
        }

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con) {
            $affectedRows = 0; // initialize var to track total num of affected rows
            $affectedRows += parent::doDeleteAll($con);
            // Because this db requires some delete cascade/set null emulation, we have to
            // clear the cached instance *after* the emulation has happened (since
            // instances get re-added by the select statement contained therein).
            PostTableMap::clearInstancePool();
            PostTableMap::clearRelatedInstancePool();

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
            $con = Propel::getServiceContainer()->getWriteConnection(PostTableMap::DATABASE_NAME);
        }

        $criteria = $this;

        // Set the correct dbName
        $criteria->setDbName(PostTableMap::DATABASE_NAME);

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con, $criteria) {
            $affectedRows = 0; // initialize var to track total num of affected rows

            PostTableMap::removeInstanceFromPool($criteria);

            $affectedRows += ModelCriteria::delete($con);
            PostTableMap::clearRelatedInstancePool();

            return $affectedRows;
        });
    }

} // PostQuery
