<?php

namespace Base;

use \Post as ChildPost;
use \PostCategoria as ChildPostCategoria;
use \PostCategoriaQuery as ChildPostCategoriaQuery;
use \PostQuery as ChildPostQuery;
use \PostReport as ChildPostReport;
use \PostReportQuery as ChildPostReportQuery;
use \PostTags as ChildPostTags;
use \PostTagsQuery as ChildPostTagsQuery;
use \DateTime;
use \Exception;
use \PDO;
use Map\PostCategoriaTableMap;
use Map\PostReportTableMap;
use Map\PostTableMap;
use Map\PostTagsTableMap;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\ModelCriteria;
use Propel\Runtime\ActiveRecord\ActiveRecordInterface;
use Propel\Runtime\Collection\Collection;
use Propel\Runtime\Collection\ObjectCollection;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\Exception\BadMethodCallException;
use Propel\Runtime\Exception\LogicException;
use Propel\Runtime\Exception\PropelException;
use Propel\Runtime\Map\TableMap;
use Propel\Runtime\Parser\AbstractParser;
use Propel\Runtime\Util\PropelDateTime;

/**
 * Base class that represents a row from the 'post' table.
 *
 *
 *
 * @package    propel.generator..Base
 */
abstract class Post implements ActiveRecordInterface
{
    /**
     * TableMap class name
     */
    const TABLE_MAP = '\\Map\\PostTableMap';


    /**
     * attribute to determine if this object has previously been saved.
     * @var boolean
     */
    protected $new = true;

    /**
     * attribute to determine whether this object has been deleted.
     * @var boolean
     */
    protected $deleted = false;

    /**
     * The columns that have been modified in current object.
     * Tracking modified columns allows us to only update modified columns.
     * @var array
     */
    protected $modifiedColumns = array();

    /**
     * The (virtual) columns that are added at runtime
     * The formatters can add supplementary columns based on a resultset
     * @var array
     */
    protected $virtualColumns = array();

    /**
     * The value for the id field.
     *
     * @var        int
     */
    protected $id;

    /**
     * The value for the titulo field.
     *
     * @var        string
     */
    protected $titulo;

    /**
     * The value for the texto field.
     *
     * @var        string
     */
    protected $texto;

    /**
     * The value for the idusuario field.
     *
     * @var        int
     */
    protected $idusuario;

    /**
     * The value for the visualizacoes field.
     *
     * Note: this column has a database default value of: 0
     * @var        int
     */
    protected $visualizacoes;

    /**
     * The value for the datacriacao field.
     *
     * Note: this column has a database default value of: (expression) CURRENT_TIMESTAMP
     * @var        DateTime
     */
    protected $datacriacao;

    /**
     * The value for the status field.
     *
     * Note: this column has a database default value of: 'AGUARDANDO'
     * @var        string
     */
    protected $status;

    /**
     * The value for the capa field.
     *
     * @var        string
     */
    protected $capa;

    /**
     * @var        ObjectCollection|ChildPostCategoria[] Collection to store aggregation of ChildPostCategoria objects.
     */
    protected $collPostCategorias;
    protected $collPostCategoriasPartial;

    /**
     * @var        ObjectCollection|ChildPostReport[] Collection to store aggregation of ChildPostReport objects.
     */
    protected $collPostReports;
    protected $collPostReportsPartial;

    /**
     * @var        ObjectCollection|ChildPostTags[] Collection to store aggregation of ChildPostTags objects.
     */
    protected $collPostTagssRelatedByIdpost;
    protected $collPostTagssRelatedByIdpostPartial;

    /**
     * @var        ObjectCollection|ChildPostTags[] Collection to store aggregation of ChildPostTags objects.
     */
    protected $collPostTagssRelatedByIdtag;
    protected $collPostTagssRelatedByIdtagPartial;

    /**
     * Flag to prevent endless save loop, if this object is referenced
     * by another object which falls in this transaction.
     *
     * @var boolean
     */
    protected $alreadyInSave = false;

    /**
     * An array of objects scheduled for deletion.
     * @var ObjectCollection|ChildPostCategoria[]
     */
    protected $postCategoriasScheduledForDeletion = null;

    /**
     * An array of objects scheduled for deletion.
     * @var ObjectCollection|ChildPostReport[]
     */
    protected $postReportsScheduledForDeletion = null;

    /**
     * An array of objects scheduled for deletion.
     * @var ObjectCollection|ChildPostTags[]
     */
    protected $postTagssRelatedByIdpostScheduledForDeletion = null;

    /**
     * An array of objects scheduled for deletion.
     * @var ObjectCollection|ChildPostTags[]
     */
    protected $postTagssRelatedByIdtagScheduledForDeletion = null;

    /**
     * Applies default values to this object.
     * This method should be called from the object's constructor (or
     * equivalent initialization method).
     * @see __construct()
     */
    public function applyDefaultValues()
    {
        $this->visualizacoes = 0;
        $this->status = 'AGUARDANDO';
    }

    /**
     * Initializes internal state of Base\Post object.
     * @see applyDefaults()
     */
    public function __construct()
    {
        $this->applyDefaultValues();
    }

    /**
     * Returns whether the object has been modified.
     *
     * @return boolean True if the object has been modified.
     */
    public function isModified()
    {
        return !!$this->modifiedColumns;
    }

    /**
     * Has specified column been modified?
     *
     * @param  string  $col column fully qualified name (TableMap::TYPE_COLNAME), e.g. Book::AUTHOR_ID
     * @return boolean True if $col has been modified.
     */
    public function isColumnModified($col)
    {
        return $this->modifiedColumns && isset($this->modifiedColumns[$col]);
    }

    /**
     * Get the columns that have been modified in this object.
     * @return array A unique list of the modified column names for this object.
     */
    public function getModifiedColumns()
    {
        return $this->modifiedColumns ? array_keys($this->modifiedColumns) : [];
    }

    /**
     * Returns whether the object has ever been saved.  This will
     * be false, if the object was retrieved from storage or was created
     * and then saved.
     *
     * @return boolean true, if the object has never been persisted.
     */
    public function isNew()
    {
        return $this->new;
    }

    /**
     * Setter for the isNew attribute.  This method will be called
     * by Propel-generated children and objects.
     *
     * @param boolean $b the state of the object.
     */
    public function setNew($b)
    {
        $this->new = (boolean) $b;
    }

    /**
     * Whether this object has been deleted.
     * @return boolean The deleted state of this object.
     */
    public function isDeleted()
    {
        return $this->deleted;
    }

    /**
     * Specify whether this object has been deleted.
     * @param  boolean $b The deleted state of this object.
     * @return void
     */
    public function setDeleted($b)
    {
        $this->deleted = (boolean) $b;
    }

    /**
     * Sets the modified state for the object to be false.
     * @param  string $col If supplied, only the specified column is reset.
     * @return void
     */
    public function resetModified($col = null)
    {
        if (null !== $col) {
            if (isset($this->modifiedColumns[$col])) {
                unset($this->modifiedColumns[$col]);
            }
        } else {
            $this->modifiedColumns = array();
        }
    }

    /**
     * Compares this with another <code>Post</code> instance.  If
     * <code>obj</code> is an instance of <code>Post</code>, delegates to
     * <code>equals(Post)</code>.  Otherwise, returns <code>false</code>.
     *
     * @param  mixed   $obj The object to compare to.
     * @return boolean Whether equal to the object specified.
     */
    public function equals($obj)
    {
        if (!$obj instanceof static) {
            return false;
        }

        if ($this === $obj) {
            return true;
        }

        if (null === $this->getPrimaryKey() || null === $obj->getPrimaryKey()) {
            return false;
        }

        return $this->getPrimaryKey() === $obj->getPrimaryKey();
    }

    /**
     * Get the associative array of the virtual columns in this object
     *
     * @return array
     */
    public function getVirtualColumns()
    {
        return $this->virtualColumns;
    }

    /**
     * Checks the existence of a virtual column in this object
     *
     * @param  string  $name The virtual column name
     * @return boolean
     */
    public function hasVirtualColumn($name)
    {
        return array_key_exists($name, $this->virtualColumns);
    }

    /**
     * Get the value of a virtual column in this object
     *
     * @param  string $name The virtual column name
     * @return mixed
     *
     * @throws PropelException
     */
    public function getVirtualColumn($name)
    {
        if (!$this->hasVirtualColumn($name)) {
            throw new PropelException(sprintf('Cannot get value of inexistent virtual column %s.', $name));
        }

        return $this->virtualColumns[$name];
    }

    /**
     * Set the value of a virtual column in this object
     *
     * @param string $name  The virtual column name
     * @param mixed  $value The value to give to the virtual column
     *
     * @return $this|Post The current object, for fluid interface
     */
    public function setVirtualColumn($name, $value)
    {
        $this->virtualColumns[$name] = $value;

        return $this;
    }

    /**
     * Logs a message using Propel::log().
     *
     * @param  string  $msg
     * @param  int     $priority One of the Propel::LOG_* logging levels
     * @return boolean
     */
    protected function log($msg, $priority = Propel::LOG_INFO)
    {
        return Propel::log(get_class($this) . ': ' . $msg, $priority);
    }

    /**
     * Export the current object properties to a string, using a given parser format
     * <code>
     * $book = BookQuery::create()->findPk(9012);
     * echo $book->exportTo('JSON');
     *  => {"Id":9012,"Title":"Don Juan","ISBN":"0140422161","Price":12.99,"PublisherId":1234,"AuthorId":5678}');
     * </code>
     *
     * @param  mixed   $parser                 A AbstractParser instance, or a format name ('XML', 'YAML', 'JSON', 'CSV')
     * @param  boolean $includeLazyLoadColumns (optional) Whether to include lazy load(ed) columns. Defaults to TRUE.
     * @return string  The exported data
     */
    public function exportTo($parser, $includeLazyLoadColumns = true)
    {
        if (!$parser instanceof AbstractParser) {
            $parser = AbstractParser::getParser($parser);
        }

        return $parser->fromArray($this->toArray(TableMap::TYPE_PHPNAME, $includeLazyLoadColumns, array(), true));
    }

    /**
     * Clean up internal collections prior to serializing
     * Avoids recursive loops that turn into segmentation faults when serializing
     */
    public function __sleep()
    {
        $this->clearAllReferences();

        $cls = new \ReflectionClass($this);
        $propertyNames = [];
        $serializableProperties = array_diff($cls->getProperties(), $cls->getProperties(\ReflectionProperty::IS_STATIC));

        foreach($serializableProperties as $property) {
            $propertyNames[] = $property->getName();
        }

        return $propertyNames;
    }

    /**
     * Get the [id] column value.
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Get the [titulo] column value.
     *
     * @return string
     */
    public function getTitulo()
    {
        return $this->titulo;
    }

    /**
     * Get the [texto] column value.
     *
     * @return string
     */
    public function getTexto()
    {
        return $this->texto;
    }

    /**
     * Get the [idusuario] column value.
     *
     * @return int
     */
    public function getIdusuario()
    {
        return $this->idusuario;
    }

    /**
     * Get the [visualizacoes] column value.
     *
     * @return int
     */
    public function getVisualizacoes()
    {
        return $this->visualizacoes;
    }

    /**
     * Get the [optionally formatted] temporal [datacriacao] column value.
     *
     *
     * @param      string|null $format The date/time format string (either date()-style or strftime()-style).
     *                            If format is NULL, then the raw DateTime object will be returned.
     *
     * @return string|DateTime Formatted date/time value as string or DateTime object (if format is NULL), NULL if column is NULL, and 0 if column value is 0000-00-00 00:00:00
     *
     * @throws PropelException - if unable to parse/validate the date/time value.
     */
    public function getDatacriacao($format = NULL)
    {
        if ($format === null) {
            return $this->datacriacao;
        } else {
            return $this->datacriacao instanceof \DateTimeInterface ? $this->datacriacao->format($format) : null;
        }
    }

    /**
     * Get the [status] column value.
     *
     * @return string
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * Get the [capa] column value.
     *
     * @return string
     */
    public function getCapa()
    {
        return $this->capa;
    }

    /**
     * Set the value of [id] column.
     *
     * @param int $v new value
     * @return $this|\Post The current object (for fluent API support)
     */
    public function setId($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->id !== $v) {
            $this->id = $v;
            $this->modifiedColumns[PostTableMap::COL_ID] = true;
        }

        return $this;
    } // setId()

    /**
     * Set the value of [titulo] column.
     *
     * @param string $v new value
     * @return $this|\Post The current object (for fluent API support)
     */
    public function setTitulo($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->titulo !== $v) {
            $this->titulo = $v;
            $this->modifiedColumns[PostTableMap::COL_TITULO] = true;
        }

        return $this;
    } // setTitulo()

    /**
     * Set the value of [texto] column.
     *
     * @param string $v new value
     * @return $this|\Post The current object (for fluent API support)
     */
    public function setTexto($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->texto !== $v) {
            $this->texto = $v;
            $this->modifiedColumns[PostTableMap::COL_TEXTO] = true;
        }

        return $this;
    } // setTexto()

    /**
     * Set the value of [idusuario] column.
     *
     * @param int $v new value
     * @return $this|\Post The current object (for fluent API support)
     */
    public function setIdusuario($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->idusuario !== $v) {
            $this->idusuario = $v;
            $this->modifiedColumns[PostTableMap::COL_IDUSUARIO] = true;
        }

        return $this;
    } // setIdusuario()

    /**
     * Set the value of [visualizacoes] column.
     *
     * @param int $v new value
     * @return $this|\Post The current object (for fluent API support)
     */
    public function setVisualizacoes($v)
    {
        if ($v !== null) {
            $v = (int) $v;
        }

        if ($this->visualizacoes !== $v) {
            $this->visualizacoes = $v;
            $this->modifiedColumns[PostTableMap::COL_VISUALIZACOES] = true;
        }

        return $this;
    } // setVisualizacoes()

    /**
     * Sets the value of [datacriacao] column to a normalized version of the date/time value specified.
     *
     * @param  mixed $v string, integer (timestamp), or \DateTimeInterface value.
     *               Empty strings are treated as NULL.
     * @return $this|\Post The current object (for fluent API support)
     */
    public function setDatacriacao($v)
    {
        $dt = PropelDateTime::newInstance($v, null, 'DateTime');
        if ($this->datacriacao !== null || $dt !== null) {
            if ($this->datacriacao === null || $dt === null || $dt->format("Y-m-d H:i:s.u") !== $this->datacriacao->format("Y-m-d H:i:s.u")) {
                $this->datacriacao = $dt === null ? null : clone $dt;
                $this->modifiedColumns[PostTableMap::COL_DATACRIACAO] = true;
            }
        } // if either are not null

        return $this;
    } // setDatacriacao()

    /**
     * Set the value of [status] column.
     *
     * @param string $v new value
     * @return $this|\Post The current object (for fluent API support)
     */
    public function setStatus($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->status !== $v) {
            $this->status = $v;
            $this->modifiedColumns[PostTableMap::COL_STATUS] = true;
        }

        return $this;
    } // setStatus()

    /**
     * Set the value of [capa] column.
     *
     * @param string $v new value
     * @return $this|\Post The current object (for fluent API support)
     */
    public function setCapa($v)
    {
        if ($v !== null) {
            $v = (string) $v;
        }

        if ($this->capa !== $v) {
            $this->capa = $v;
            $this->modifiedColumns[PostTableMap::COL_CAPA] = true;
        }

        return $this;
    } // setCapa()

    /**
     * Indicates whether the columns in this object are only set to default values.
     *
     * This method can be used in conjunction with isModified() to indicate whether an object is both
     * modified _and_ has some values set which are non-default.
     *
     * @return boolean Whether the columns in this object are only been set with default values.
     */
    public function hasOnlyDefaultValues()
    {
            if ($this->visualizacoes !== 0) {
                return false;
            }

            if ($this->status !== 'AGUARDANDO') {
                return false;
            }

        // otherwise, everything was equal, so return TRUE
        return true;
    } // hasOnlyDefaultValues()

    /**
     * Hydrates (populates) the object variables with values from the database resultset.
     *
     * An offset (0-based "start column") is specified so that objects can be hydrated
     * with a subset of the columns in the resultset rows.  This is needed, for example,
     * for results of JOIN queries where the resultset row includes columns from two or
     * more tables.
     *
     * @param array   $row       The row returned by DataFetcher->fetch().
     * @param int     $startcol  0-based offset column which indicates which restultset column to start with.
     * @param boolean $rehydrate Whether this object is being re-hydrated from the database.
     * @param string  $indexType The index type of $row. Mostly DataFetcher->getIndexType().
                                  One of the class type constants TableMap::TYPE_PHPNAME, TableMap::TYPE_CAMELNAME
     *                            TableMap::TYPE_COLNAME, TableMap::TYPE_FIELDNAME, TableMap::TYPE_NUM.
     *
     * @return int             next starting column
     * @throws PropelException - Any caught Exception will be rewrapped as a PropelException.
     */
    public function hydrate($row, $startcol = 0, $rehydrate = false, $indexType = TableMap::TYPE_NUM)
    {
        try {

            $col = $row[TableMap::TYPE_NUM == $indexType ? 0 + $startcol : PostTableMap::translateFieldName('Id', TableMap::TYPE_PHPNAME, $indexType)];
            $this->id = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 1 + $startcol : PostTableMap::translateFieldName('Titulo', TableMap::TYPE_PHPNAME, $indexType)];
            $this->titulo = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 2 + $startcol : PostTableMap::translateFieldName('Texto', TableMap::TYPE_PHPNAME, $indexType)];
            $this->texto = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 3 + $startcol : PostTableMap::translateFieldName('Idusuario', TableMap::TYPE_PHPNAME, $indexType)];
            $this->idusuario = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 4 + $startcol : PostTableMap::translateFieldName('Visualizacoes', TableMap::TYPE_PHPNAME, $indexType)];
            $this->visualizacoes = (null !== $col) ? (int) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 5 + $startcol : PostTableMap::translateFieldName('Datacriacao', TableMap::TYPE_PHPNAME, $indexType)];
            if ($col === '0000-00-00 00:00:00') {
                $col = null;
            }
            $this->datacriacao = (null !== $col) ? PropelDateTime::newInstance($col, null, 'DateTime') : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 6 + $startcol : PostTableMap::translateFieldName('Status', TableMap::TYPE_PHPNAME, $indexType)];
            $this->status = (null !== $col) ? (string) $col : null;

            $col = $row[TableMap::TYPE_NUM == $indexType ? 7 + $startcol : PostTableMap::translateFieldName('Capa', TableMap::TYPE_PHPNAME, $indexType)];
            $this->capa = (null !== $col) ? (string) $col : null;
            $this->resetModified();

            $this->setNew(false);

            if ($rehydrate) {
                $this->ensureConsistency();
            }

            return $startcol + 8; // 8 = PostTableMap::NUM_HYDRATE_COLUMNS.

        } catch (Exception $e) {
            throw new PropelException(sprintf('Error populating %s object', '\\Post'), 0, $e);
        }
    }

    /**
     * Checks and repairs the internal consistency of the object.
     *
     * This method is executed after an already-instantiated object is re-hydrated
     * from the database.  It exists to check any foreign keys to make sure that
     * the objects related to the current object are correct based on foreign key.
     *
     * You can override this method in the stub class, but you should always invoke
     * the base method from the overridden method (i.e. parent::ensureConsistency()),
     * in case your model changes.
     *
     * @throws PropelException
     */
    public function ensureConsistency()
    {
    } // ensureConsistency

    /**
     * Reloads this object from datastore based on primary key and (optionally) resets all associated objects.
     *
     * This will only work if the object has been saved and has a valid primary key set.
     *
     * @param      boolean $deep (optional) Whether to also de-associated any related objects.
     * @param      ConnectionInterface $con (optional) The ConnectionInterface connection to use.
     * @return void
     * @throws PropelException - if this object is deleted, unsaved or doesn't have pk match in db
     */
    public function reload($deep = false, ConnectionInterface $con = null)
    {
        if ($this->isDeleted()) {
            throw new PropelException("Cannot reload a deleted object.");
        }

        if ($this->isNew()) {
            throw new PropelException("Cannot reload an unsaved object.");
        }

        if ($con === null) {
            $con = Propel::getServiceContainer()->getReadConnection(PostTableMap::DATABASE_NAME);
        }

        // We don't need to alter the object instance pool; we're just modifying this instance
        // already in the pool.

        $dataFetcher = ChildPostQuery::create(null, $this->buildPkeyCriteria())->setFormatter(ModelCriteria::FORMAT_STATEMENT)->find($con);
        $row = $dataFetcher->fetch();
        $dataFetcher->close();
        if (!$row) {
            throw new PropelException('Cannot find matching row in the database to reload object values.');
        }
        $this->hydrate($row, 0, true, $dataFetcher->getIndexType()); // rehydrate

        if ($deep) {  // also de-associate any related objects?

            $this->collPostCategorias = null;

            $this->collPostReports = null;

            $this->collPostTagssRelatedByIdpost = null;

            $this->collPostTagssRelatedByIdtag = null;

        } // if (deep)
    }

    /**
     * Removes this object from datastore and sets delete attribute.
     *
     * @param      ConnectionInterface $con
     * @return void
     * @throws PropelException
     * @see Post::setDeleted()
     * @see Post::isDeleted()
     */
    public function delete(ConnectionInterface $con = null)
    {
        if ($this->isDeleted()) {
            throw new PropelException("This object has already been deleted.");
        }

        if ($con === null) {
            $con = Propel::getServiceContainer()->getWriteConnection(PostTableMap::DATABASE_NAME);
        }

        $con->transaction(function () use ($con) {
            $deleteQuery = ChildPostQuery::create()
                ->filterByPrimaryKey($this->getPrimaryKey());
            $ret = $this->preDelete($con);
            if ($ret) {
                $deleteQuery->delete($con);
                $this->postDelete($con);
                $this->setDeleted(true);
            }
        });
    }

    /**
     * Persists this object to the database.
     *
     * If the object is new, it inserts it; otherwise an update is performed.
     * All modified related objects will also be persisted in the doSave()
     * method.  This method wraps all precipitate database operations in a
     * single transaction.
     *
     * @param      ConnectionInterface $con
     * @return int             The number of rows affected by this insert/update and any referring fk objects' save() operations.
     * @throws PropelException
     * @see doSave()
     */
    public function save(ConnectionInterface $con = null)
    {
        if ($this->isDeleted()) {
            throw new PropelException("You cannot save an object that has been deleted.");
        }

        if ($this->alreadyInSave) {
            return 0;
        }

        if ($con === null) {
            $con = Propel::getServiceContainer()->getWriteConnection(PostTableMap::DATABASE_NAME);
        }

        return $con->transaction(function () use ($con) {
            $ret = $this->preSave($con);
            $isInsert = $this->isNew();
            if ($isInsert) {
                $ret = $ret && $this->preInsert($con);
            } else {
                $ret = $ret && $this->preUpdate($con);
            }
            if ($ret) {
                $affectedRows = $this->doSave($con);
                if ($isInsert) {
                    $this->postInsert($con);
                } else {
                    $this->postUpdate($con);
                }
                $this->postSave($con);
                PostTableMap::addInstanceToPool($this);
            } else {
                $affectedRows = 0;
            }

            return $affectedRows;
        });
    }

    /**
     * Performs the work of inserting or updating the row in the database.
     *
     * If the object is new, it inserts it; otherwise an update is performed.
     * All related objects are also updated in this method.
     *
     * @param      ConnectionInterface $con
     * @return int             The number of rows affected by this insert/update and any referring fk objects' save() operations.
     * @throws PropelException
     * @see save()
     */
    protected function doSave(ConnectionInterface $con)
    {
        $affectedRows = 0; // initialize var to track total num of affected rows
        if (!$this->alreadyInSave) {
            $this->alreadyInSave = true;

            if ($this->isNew() || $this->isModified()) {
                // persist changes
                if ($this->isNew()) {
                    $this->doInsert($con);
                    $affectedRows += 1;
                } else {
                    $affectedRows += $this->doUpdate($con);
                }
                $this->resetModified();
            }

            if ($this->postCategoriasScheduledForDeletion !== null) {
                if (!$this->postCategoriasScheduledForDeletion->isEmpty()) {
                    \PostCategoriaQuery::create()
                        ->filterByPrimaryKeys($this->postCategoriasScheduledForDeletion->getPrimaryKeys(false))
                        ->delete($con);
                    $this->postCategoriasScheduledForDeletion = null;
                }
            }

            if ($this->collPostCategorias !== null) {
                foreach ($this->collPostCategorias as $referrerFK) {
                    if (!$referrerFK->isDeleted() && ($referrerFK->isNew() || $referrerFK->isModified())) {
                        $affectedRows += $referrerFK->save($con);
                    }
                }
            }

            if ($this->postReportsScheduledForDeletion !== null) {
                if (!$this->postReportsScheduledForDeletion->isEmpty()) {
                    \PostReportQuery::create()
                        ->filterByPrimaryKeys($this->postReportsScheduledForDeletion->getPrimaryKeys(false))
                        ->delete($con);
                    $this->postReportsScheduledForDeletion = null;
                }
            }

            if ($this->collPostReports !== null) {
                foreach ($this->collPostReports as $referrerFK) {
                    if (!$referrerFK->isDeleted() && ($referrerFK->isNew() || $referrerFK->isModified())) {
                        $affectedRows += $referrerFK->save($con);
                    }
                }
            }

            if ($this->postTagssRelatedByIdpostScheduledForDeletion !== null) {
                if (!$this->postTagssRelatedByIdpostScheduledForDeletion->isEmpty()) {
                    \PostTagsQuery::create()
                        ->filterByPrimaryKeys($this->postTagssRelatedByIdpostScheduledForDeletion->getPrimaryKeys(false))
                        ->delete($con);
                    $this->postTagssRelatedByIdpostScheduledForDeletion = null;
                }
            }

            if ($this->collPostTagssRelatedByIdpost !== null) {
                foreach ($this->collPostTagssRelatedByIdpost as $referrerFK) {
                    if (!$referrerFK->isDeleted() && ($referrerFK->isNew() || $referrerFK->isModified())) {
                        $affectedRows += $referrerFK->save($con);
                    }
                }
            }

            if ($this->postTagssRelatedByIdtagScheduledForDeletion !== null) {
                if (!$this->postTagssRelatedByIdtagScheduledForDeletion->isEmpty()) {
                    \PostTagsQuery::create()
                        ->filterByPrimaryKeys($this->postTagssRelatedByIdtagScheduledForDeletion->getPrimaryKeys(false))
                        ->delete($con);
                    $this->postTagssRelatedByIdtagScheduledForDeletion = null;
                }
            }

            if ($this->collPostTagssRelatedByIdtag !== null) {
                foreach ($this->collPostTagssRelatedByIdtag as $referrerFK) {
                    if (!$referrerFK->isDeleted() && ($referrerFK->isNew() || $referrerFK->isModified())) {
                        $affectedRows += $referrerFK->save($con);
                    }
                }
            }

            $this->alreadyInSave = false;

        }

        return $affectedRows;
    } // doSave()

    /**
     * Insert the row in the database.
     *
     * @param      ConnectionInterface $con
     *
     * @throws PropelException
     * @see doSave()
     */
    protected function doInsert(ConnectionInterface $con)
    {
        $modifiedColumns = array();
        $index = 0;

        $this->modifiedColumns[PostTableMap::COL_ID] = true;
        if (null !== $this->id) {
            throw new PropelException('Cannot insert a value for auto-increment primary key (' . PostTableMap::COL_ID . ')');
        }

         // check the columns in natural order for more readable SQL queries
        if ($this->isColumnModified(PostTableMap::COL_ID)) {
            $modifiedColumns[':p' . $index++]  = 'id';
        }
        if ($this->isColumnModified(PostTableMap::COL_TITULO)) {
            $modifiedColumns[':p' . $index++]  = 'titulo';
        }
        if ($this->isColumnModified(PostTableMap::COL_TEXTO)) {
            $modifiedColumns[':p' . $index++]  = 'texto';
        }
        if ($this->isColumnModified(PostTableMap::COL_IDUSUARIO)) {
            $modifiedColumns[':p' . $index++]  = 'idUsuario';
        }
        if ($this->isColumnModified(PostTableMap::COL_VISUALIZACOES)) {
            $modifiedColumns[':p' . $index++]  = 'visualizacoes';
        }
        if ($this->isColumnModified(PostTableMap::COL_DATACRIACAO)) {
            $modifiedColumns[':p' . $index++]  = 'dataCriacao';
        }
        if ($this->isColumnModified(PostTableMap::COL_STATUS)) {
            $modifiedColumns[':p' . $index++]  = 'status';
        }
        if ($this->isColumnModified(PostTableMap::COL_CAPA)) {
            $modifiedColumns[':p' . $index++]  = 'capa';
        }

        $sql = sprintf(
            'INSERT INTO post (%s) VALUES (%s)',
            implode(', ', $modifiedColumns),
            implode(', ', array_keys($modifiedColumns))
        );

        try {
            $stmt = $con->prepare($sql);
            foreach ($modifiedColumns as $identifier => $columnName) {
                switch ($columnName) {
                    case 'id':
                        $stmt->bindValue($identifier, $this->id, PDO::PARAM_INT);
                        break;
                    case 'titulo':
                        $stmt->bindValue($identifier, $this->titulo, PDO::PARAM_STR);
                        break;
                    case 'texto':
                        $stmt->bindValue($identifier, $this->texto, PDO::PARAM_STR);
                        break;
                    case 'idUsuario':
                        $stmt->bindValue($identifier, $this->idusuario, PDO::PARAM_INT);
                        break;
                    case 'visualizacoes':
                        $stmt->bindValue($identifier, $this->visualizacoes, PDO::PARAM_INT);
                        break;
                    case 'dataCriacao':
                        $stmt->bindValue($identifier, $this->datacriacao ? $this->datacriacao->format("Y-m-d H:i:s.u") : null, PDO::PARAM_STR);
                        break;
                    case 'status':
                        $stmt->bindValue($identifier, $this->status, PDO::PARAM_STR);
                        break;
                    case 'capa':
                        $stmt->bindValue($identifier, $this->capa, PDO::PARAM_STR);
                        break;
                }
            }
            $stmt->execute();
        } catch (Exception $e) {
            Propel::log($e->getMessage(), Propel::LOG_ERR);
            throw new PropelException(sprintf('Unable to execute INSERT statement [%s]', $sql), 0, $e);
        }

        try {
            $pk = $con->lastInsertId();
        } catch (Exception $e) {
            throw new PropelException('Unable to get autoincrement id.', 0, $e);
        }
        $this->setId($pk);

        $this->setNew(false);
    }

    /**
     * Update the row in the database.
     *
     * @param      ConnectionInterface $con
     *
     * @return Integer Number of updated rows
     * @see doSave()
     */
    protected function doUpdate(ConnectionInterface $con)
    {
        $selectCriteria = $this->buildPkeyCriteria();
        $valuesCriteria = $this->buildCriteria();

        return $selectCriteria->doUpdate($valuesCriteria, $con);
    }

    /**
     * Retrieves a field from the object by name passed in as a string.
     *
     * @param      string $name name
     * @param      string $type The type of fieldname the $name is of:
     *                     one of the class type constants TableMap::TYPE_PHPNAME, TableMap::TYPE_CAMELNAME
     *                     TableMap::TYPE_COLNAME, TableMap::TYPE_FIELDNAME, TableMap::TYPE_NUM.
     *                     Defaults to TableMap::TYPE_PHPNAME.
     * @return mixed Value of field.
     */
    public function getByName($name, $type = TableMap::TYPE_PHPNAME)
    {
        $pos = PostTableMap::translateFieldName($name, $type, TableMap::TYPE_NUM);
        $field = $this->getByPosition($pos);

        return $field;
    }

    /**
     * Retrieves a field from the object by Position as specified in the xml schema.
     * Zero-based.
     *
     * @param      int $pos position in xml schema
     * @return mixed Value of field at $pos
     */
    public function getByPosition($pos)
    {
        switch ($pos) {
            case 0:
                return $this->getId();
                break;
            case 1:
                return $this->getTitulo();
                break;
            case 2:
                return $this->getTexto();
                break;
            case 3:
                return $this->getIdusuario();
                break;
            case 4:
                return $this->getVisualizacoes();
                break;
            case 5:
                return $this->getDatacriacao();
                break;
            case 6:
                return $this->getStatus();
                break;
            case 7:
                return $this->getCapa();
                break;
            default:
                return null;
                break;
        } // switch()
    }

    /**
     * Exports the object as an array.
     *
     * You can specify the key type of the array by passing one of the class
     * type constants.
     *
     * @param     string  $keyType (optional) One of the class type constants TableMap::TYPE_PHPNAME, TableMap::TYPE_CAMELNAME,
     *                    TableMap::TYPE_COLNAME, TableMap::TYPE_FIELDNAME, TableMap::TYPE_NUM.
     *                    Defaults to TableMap::TYPE_PHPNAME.
     * @param     boolean $includeLazyLoadColumns (optional) Whether to include lazy loaded columns. Defaults to TRUE.
     * @param     array $alreadyDumpedObjects List of objects to skip to avoid recursion
     * @param     boolean $includeForeignObjects (optional) Whether to include hydrated related objects. Default to FALSE.
     *
     * @return array an associative array containing the field names (as keys) and field values
     */
    public function toArray($keyType = TableMap::TYPE_PHPNAME, $includeLazyLoadColumns = true, $alreadyDumpedObjects = array(), $includeForeignObjects = false)
    {

        if (isset($alreadyDumpedObjects['Post'][$this->hashCode()])) {
            return '*RECURSION*';
        }
        $alreadyDumpedObjects['Post'][$this->hashCode()] = true;
        $keys = PostTableMap::getFieldNames($keyType);
        $result = array(
            $keys[0] => $this->getId(),
            $keys[1] => $this->getTitulo(),
            $keys[2] => $this->getTexto(),
            $keys[3] => $this->getIdusuario(),
            $keys[4] => $this->getVisualizacoes(),
            $keys[5] => $this->getDatacriacao(),
            $keys[6] => $this->getStatus(),
            $keys[7] => $this->getCapa(),
        );
        if ($result[$keys[5]] instanceof \DateTimeInterface) {
            $result[$keys[5]] = $result[$keys[5]]->format('c');
        }

        $virtualColumns = $this->virtualColumns;
        foreach ($virtualColumns as $key => $virtualColumn) {
            $result[$key] = $virtualColumn;
        }

        if ($includeForeignObjects) {
            if (null !== $this->collPostCategorias) {

                switch ($keyType) {
                    case TableMap::TYPE_CAMELNAME:
                        $key = 'postCategorias';
                        break;
                    case TableMap::TYPE_FIELDNAME:
                        $key = 'post_categorias';
                        break;
                    default:
                        $key = 'PostCategorias';
                }

                $result[$key] = $this->collPostCategorias->toArray(null, false, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
            }
            if (null !== $this->collPostReports) {

                switch ($keyType) {
                    case TableMap::TYPE_CAMELNAME:
                        $key = 'postReports';
                        break;
                    case TableMap::TYPE_FIELDNAME:
                        $key = 'post_reports';
                        break;
                    default:
                        $key = 'PostReports';
                }

                $result[$key] = $this->collPostReports->toArray(null, false, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
            }
            if (null !== $this->collPostTagssRelatedByIdpost) {

                switch ($keyType) {
                    case TableMap::TYPE_CAMELNAME:
                        $key = 'postTagss';
                        break;
                    case TableMap::TYPE_FIELDNAME:
                        $key = 'post_tagss';
                        break;
                    default:
                        $key = 'PostTagss';
                }

                $result[$key] = $this->collPostTagssRelatedByIdpost->toArray(null, false, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
            }
            if (null !== $this->collPostTagssRelatedByIdtag) {

                switch ($keyType) {
                    case TableMap::TYPE_CAMELNAME:
                        $key = 'postTagss';
                        break;
                    case TableMap::TYPE_FIELDNAME:
                        $key = 'post_tagss';
                        break;
                    default:
                        $key = 'PostTagss';
                }

                $result[$key] = $this->collPostTagssRelatedByIdtag->toArray(null, false, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
            }
        }

        return $result;
    }

    /**
     * Sets a field from the object by name passed in as a string.
     *
     * @param  string $name
     * @param  mixed  $value field value
     * @param  string $type The type of fieldname the $name is of:
     *                one of the class type constants TableMap::TYPE_PHPNAME, TableMap::TYPE_CAMELNAME
     *                TableMap::TYPE_COLNAME, TableMap::TYPE_FIELDNAME, TableMap::TYPE_NUM.
     *                Defaults to TableMap::TYPE_PHPNAME.
     * @return $this|\Post
     */
    public function setByName($name, $value, $type = TableMap::TYPE_PHPNAME)
    {
        $pos = PostTableMap::translateFieldName($name, $type, TableMap::TYPE_NUM);

        return $this->setByPosition($pos, $value);
    }

    /**
     * Sets a field from the object by Position as specified in the xml schema.
     * Zero-based.
     *
     * @param  int $pos position in xml schema
     * @param  mixed $value field value
     * @return $this|\Post
     */
    public function setByPosition($pos, $value)
    {
        switch ($pos) {
            case 0:
                $this->setId($value);
                break;
            case 1:
                $this->setTitulo($value);
                break;
            case 2:
                $this->setTexto($value);
                break;
            case 3:
                $this->setIdusuario($value);
                break;
            case 4:
                $this->setVisualizacoes($value);
                break;
            case 5:
                $this->setDatacriacao($value);
                break;
            case 6:
                $this->setStatus($value);
                break;
            case 7:
                $this->setCapa($value);
                break;
        } // switch()

        return $this;
    }

    /**
     * Populates the object using an array.
     *
     * This is particularly useful when populating an object from one of the
     * request arrays (e.g. $_POST).  This method goes through the column
     * names, checking to see whether a matching key exists in populated
     * array. If so the setByName() method is called for that column.
     *
     * You can specify the key type of the array by additionally passing one
     * of the class type constants TableMap::TYPE_PHPNAME, TableMap::TYPE_CAMELNAME,
     * TableMap::TYPE_COLNAME, TableMap::TYPE_FIELDNAME, TableMap::TYPE_NUM.
     * The default key type is the column's TableMap::TYPE_PHPNAME.
     *
     * @param      array  $arr     An array to populate the object from.
     * @param      string $keyType The type of keys the array uses.
     * @return void
     */
    public function fromArray($arr, $keyType = TableMap::TYPE_PHPNAME)
    {
        $keys = PostTableMap::getFieldNames($keyType);

        if (array_key_exists($keys[0], $arr)) {
            $this->setId($arr[$keys[0]]);
        }
        if (array_key_exists($keys[1], $arr)) {
            $this->setTitulo($arr[$keys[1]]);
        }
        if (array_key_exists($keys[2], $arr)) {
            $this->setTexto($arr[$keys[2]]);
        }
        if (array_key_exists($keys[3], $arr)) {
            $this->setIdusuario($arr[$keys[3]]);
        }
        if (array_key_exists($keys[4], $arr)) {
            $this->setVisualizacoes($arr[$keys[4]]);
        }
        if (array_key_exists($keys[5], $arr)) {
            $this->setDatacriacao($arr[$keys[5]]);
        }
        if (array_key_exists($keys[6], $arr)) {
            $this->setStatus($arr[$keys[6]]);
        }
        if (array_key_exists($keys[7], $arr)) {
            $this->setCapa($arr[$keys[7]]);
        }
    }

     /**
     * Populate the current object from a string, using a given parser format
     * <code>
     * $book = new Book();
     * $book->importFrom('JSON', '{"Id":9012,"Title":"Don Juan","ISBN":"0140422161","Price":12.99,"PublisherId":1234,"AuthorId":5678}');
     * </code>
     *
     * You can specify the key type of the array by additionally passing one
     * of the class type constants TableMap::TYPE_PHPNAME, TableMap::TYPE_CAMELNAME,
     * TableMap::TYPE_COLNAME, TableMap::TYPE_FIELDNAME, TableMap::TYPE_NUM.
     * The default key type is the column's TableMap::TYPE_PHPNAME.
     *
     * @param mixed $parser A AbstractParser instance,
     *                       or a format name ('XML', 'YAML', 'JSON', 'CSV')
     * @param string $data The source data to import from
     * @param string $keyType The type of keys the array uses.
     *
     * @return $this|\Post The current object, for fluid interface
     */
    public function importFrom($parser, $data, $keyType = TableMap::TYPE_PHPNAME)
    {
        if (!$parser instanceof AbstractParser) {
            $parser = AbstractParser::getParser($parser);
        }

        $this->fromArray($parser->toArray($data), $keyType);

        return $this;
    }

    /**
     * Build a Criteria object containing the values of all modified columns in this object.
     *
     * @return Criteria The Criteria object containing all modified values.
     */
    public function buildCriteria()
    {
        $criteria = new Criteria(PostTableMap::DATABASE_NAME);

        if ($this->isColumnModified(PostTableMap::COL_ID)) {
            $criteria->add(PostTableMap::COL_ID, $this->id);
        }
        if ($this->isColumnModified(PostTableMap::COL_TITULO)) {
            $criteria->add(PostTableMap::COL_TITULO, $this->titulo);
        }
        if ($this->isColumnModified(PostTableMap::COL_TEXTO)) {
            $criteria->add(PostTableMap::COL_TEXTO, $this->texto);
        }
        if ($this->isColumnModified(PostTableMap::COL_IDUSUARIO)) {
            $criteria->add(PostTableMap::COL_IDUSUARIO, $this->idusuario);
        }
        if ($this->isColumnModified(PostTableMap::COL_VISUALIZACOES)) {
            $criteria->add(PostTableMap::COL_VISUALIZACOES, $this->visualizacoes);
        }
        if ($this->isColumnModified(PostTableMap::COL_DATACRIACAO)) {
            $criteria->add(PostTableMap::COL_DATACRIACAO, $this->datacriacao);
        }
        if ($this->isColumnModified(PostTableMap::COL_STATUS)) {
            $criteria->add(PostTableMap::COL_STATUS, $this->status);
        }
        if ($this->isColumnModified(PostTableMap::COL_CAPA)) {
            $criteria->add(PostTableMap::COL_CAPA, $this->capa);
        }

        return $criteria;
    }

    /**
     * Builds a Criteria object containing the primary key for this object.
     *
     * Unlike buildCriteria() this method includes the primary key values regardless
     * of whether or not they have been modified.
     *
     * @throws LogicException if no primary key is defined
     *
     * @return Criteria The Criteria object containing value(s) for primary key(s).
     */
    public function buildPkeyCriteria()
    {
        $criteria = ChildPostQuery::create();
        $criteria->add(PostTableMap::COL_ID, $this->id);

        return $criteria;
    }

    /**
     * If the primary key is not null, return the hashcode of the
     * primary key. Otherwise, return the hash code of the object.
     *
     * @return int Hashcode
     */
    public function hashCode()
    {
        $validPk = null !== $this->getId();

        $validPrimaryKeyFKs = 0;
        $primaryKeyFKs = [];

        if ($validPk) {
            return crc32(json_encode($this->getPrimaryKey(), JSON_UNESCAPED_UNICODE));
        } elseif ($validPrimaryKeyFKs) {
            return crc32(json_encode($primaryKeyFKs, JSON_UNESCAPED_UNICODE));
        }

        return spl_object_hash($this);
    }

    /**
     * Returns the primary key for this object (row).
     * @return int
     */
    public function getPrimaryKey()
    {
        return $this->getId();
    }

    /**
     * Generic method to set the primary key (id column).
     *
     * @param       int $key Primary key.
     * @return void
     */
    public function setPrimaryKey($key)
    {
        $this->setId($key);
    }

    /**
     * Returns true if the primary key for this object is null.
     * @return boolean
     */
    public function isPrimaryKeyNull()
    {
        return null === $this->getId();
    }

    /**
     * Sets contents of passed object to values from current object.
     *
     * If desired, this method can also make copies of all associated (fkey referrers)
     * objects.
     *
     * @param      object $copyObj An object of \Post (or compatible) type.
     * @param      boolean $deepCopy Whether to also copy all rows that refer (by fkey) to the current row.
     * @param      boolean $makeNew Whether to reset autoincrement PKs and make the object new.
     * @throws PropelException
     */
    public function copyInto($copyObj, $deepCopy = false, $makeNew = true)
    {
        $copyObj->setTitulo($this->getTitulo());
        $copyObj->setTexto($this->getTexto());
        $copyObj->setIdusuario($this->getIdusuario());
        $copyObj->setVisualizacoes($this->getVisualizacoes());
        $copyObj->setDatacriacao($this->getDatacriacao());
        $copyObj->setStatus($this->getStatus());
        $copyObj->setCapa($this->getCapa());

        if ($deepCopy) {
            // important: temporarily setNew(false) because this affects the behavior of
            // the getter/setter methods for fkey referrer objects.
            $copyObj->setNew(false);

            foreach ($this->getPostCategorias() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addPostCategoria($relObj->copy($deepCopy));
                }
            }

            foreach ($this->getPostReports() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addPostReport($relObj->copy($deepCopy));
                }
            }

            foreach ($this->getPostTagssRelatedByIdpost() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addPostTagsRelatedByIdpost($relObj->copy($deepCopy));
                }
            }

            foreach ($this->getPostTagssRelatedByIdtag() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addPostTagsRelatedByIdtag($relObj->copy($deepCopy));
                }
            }

        } // if ($deepCopy)

        if ($makeNew) {
            $copyObj->setNew(true);
            $copyObj->setId(NULL); // this is a auto-increment column, so set to default value
        }
    }

    /**
     * Makes a copy of this object that will be inserted as a new row in table when saved.
     * It creates a new object filling in the simple attributes, but skipping any primary
     * keys that are defined for the table.
     *
     * If desired, this method can also make copies of all associated (fkey referrers)
     * objects.
     *
     * @param  boolean $deepCopy Whether to also copy all rows that refer (by fkey) to the current row.
     * @return \Post Clone of current object.
     * @throws PropelException
     */
    public function copy($deepCopy = false)
    {
        // we use get_class(), because this might be a subclass
        $clazz = get_class($this);
        $copyObj = new $clazz();
        $this->copyInto($copyObj, $deepCopy);

        return $copyObj;
    }


    /**
     * Initializes a collection based on the name of a relation.
     * Avoids crafting an 'init[$relationName]s' method name
     * that wouldn't work when StandardEnglishPluralizer is used.
     *
     * @param      string $relationName The name of the relation to initialize
     * @return void
     */
    public function initRelation($relationName)
    {
        if ('PostCategoria' == $relationName) {
            $this->initPostCategorias();
            return;
        }
        if ('PostReport' == $relationName) {
            $this->initPostReports();
            return;
        }
        if ('PostTagsRelatedByIdpost' == $relationName) {
            $this->initPostTagssRelatedByIdpost();
            return;
        }
        if ('PostTagsRelatedByIdtag' == $relationName) {
            $this->initPostTagssRelatedByIdtag();
            return;
        }
    }

    /**
     * Clears out the collPostCategorias collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return void
     * @see        addPostCategorias()
     */
    public function clearPostCategorias()
    {
        $this->collPostCategorias = null; // important to set this to NULL since that means it is uninitialized
    }

    /**
     * Reset is the collPostCategorias collection loaded partially.
     */
    public function resetPartialPostCategorias($v = true)
    {
        $this->collPostCategoriasPartial = $v;
    }

    /**
     * Initializes the collPostCategorias collection.
     *
     * By default this just sets the collPostCategorias collection to an empty array (like clearcollPostCategorias());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param      boolean $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initPostCategorias($overrideExisting = true)
    {
        if (null !== $this->collPostCategorias && !$overrideExisting) {
            return;
        }

        $collectionClassName = PostCategoriaTableMap::getTableMap()->getCollectionClassName();

        $this->collPostCategorias = new $collectionClassName;
        $this->collPostCategorias->setModel('\PostCategoria');
    }

    /**
     * Gets an array of ChildPostCategoria objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this ChildPost is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @return ObjectCollection|ChildPostCategoria[] List of ChildPostCategoria objects
     * @throws PropelException
     */
    public function getPostCategorias(Criteria $criteria = null, ConnectionInterface $con = null)
    {
        $partial = $this->collPostCategoriasPartial && !$this->isNew();
        if (null === $this->collPostCategorias || null !== $criteria  || $partial) {
            if ($this->isNew() && null === $this->collPostCategorias) {
                // return empty collection
                $this->initPostCategorias();
            } else {
                $collPostCategorias = ChildPostCategoriaQuery::create(null, $criteria)
                    ->filterByPost($this)
                    ->find($con);

                if (null !== $criteria) {
                    if (false !== $this->collPostCategoriasPartial && count($collPostCategorias)) {
                        $this->initPostCategorias(false);

                        foreach ($collPostCategorias as $obj) {
                            if (false == $this->collPostCategorias->contains($obj)) {
                                $this->collPostCategorias->append($obj);
                            }
                        }

                        $this->collPostCategoriasPartial = true;
                    }

                    return $collPostCategorias;
                }

                if ($partial && $this->collPostCategorias) {
                    foreach ($this->collPostCategorias as $obj) {
                        if ($obj->isNew()) {
                            $collPostCategorias[] = $obj;
                        }
                    }
                }

                $this->collPostCategorias = $collPostCategorias;
                $this->collPostCategoriasPartial = false;
            }
        }

        return $this->collPostCategorias;
    }

    /**
     * Sets a collection of ChildPostCategoria objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param      Collection $postCategorias A Propel collection.
     * @param      ConnectionInterface $con Optional connection object
     * @return $this|ChildPost The current object (for fluent API support)
     */
    public function setPostCategorias(Collection $postCategorias, ConnectionInterface $con = null)
    {
        /** @var ChildPostCategoria[] $postCategoriasToDelete */
        $postCategoriasToDelete = $this->getPostCategorias(new Criteria(), $con)->diff($postCategorias);


        //since at least one column in the foreign key is at the same time a PK
        //we can not just set a PK to NULL in the lines below. We have to store
        //a backup of all values, so we are able to manipulate these items based on the onDelete value later.
        $this->postCategoriasScheduledForDeletion = clone $postCategoriasToDelete;

        foreach ($postCategoriasToDelete as $postCategoriaRemoved) {
            $postCategoriaRemoved->setPost(null);
        }

        $this->collPostCategorias = null;
        foreach ($postCategorias as $postCategoria) {
            $this->addPostCategoria($postCategoria);
        }

        $this->collPostCategorias = $postCategorias;
        $this->collPostCategoriasPartial = false;

        return $this;
    }

    /**
     * Returns the number of related PostCategoria objects.
     *
     * @param      Criteria $criteria
     * @param      boolean $distinct
     * @param      ConnectionInterface $con
     * @return int             Count of related PostCategoria objects.
     * @throws PropelException
     */
    public function countPostCategorias(Criteria $criteria = null, $distinct = false, ConnectionInterface $con = null)
    {
        $partial = $this->collPostCategoriasPartial && !$this->isNew();
        if (null === $this->collPostCategorias || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collPostCategorias) {
                return 0;
            }

            if ($partial && !$criteria) {
                return count($this->getPostCategorias());
            }

            $query = ChildPostCategoriaQuery::create(null, $criteria);
            if ($distinct) {
                $query->distinct();
            }

            return $query
                ->filterByPost($this)
                ->count($con);
        }

        return count($this->collPostCategorias);
    }

    /**
     * Method called to associate a ChildPostCategoria object to this object
     * through the ChildPostCategoria foreign key attribute.
     *
     * @param  ChildPostCategoria $l ChildPostCategoria
     * @return $this|\Post The current object (for fluent API support)
     */
    public function addPostCategoria(ChildPostCategoria $l)
    {
        if ($this->collPostCategorias === null) {
            $this->initPostCategorias();
            $this->collPostCategoriasPartial = true;
        }

        if (!$this->collPostCategorias->contains($l)) {
            $this->doAddPostCategoria($l);

            if ($this->postCategoriasScheduledForDeletion and $this->postCategoriasScheduledForDeletion->contains($l)) {
                $this->postCategoriasScheduledForDeletion->remove($this->postCategoriasScheduledForDeletion->search($l));
            }
        }

        return $this;
    }

    /**
     * @param ChildPostCategoria $postCategoria The ChildPostCategoria object to add.
     */
    protected function doAddPostCategoria(ChildPostCategoria $postCategoria)
    {
        $this->collPostCategorias[]= $postCategoria;
        $postCategoria->setPost($this);
    }

    /**
     * @param  ChildPostCategoria $postCategoria The ChildPostCategoria object to remove.
     * @return $this|ChildPost The current object (for fluent API support)
     */
    public function removePostCategoria(ChildPostCategoria $postCategoria)
    {
        if ($this->getPostCategorias()->contains($postCategoria)) {
            $pos = $this->collPostCategorias->search($postCategoria);
            $this->collPostCategorias->remove($pos);
            if (null === $this->postCategoriasScheduledForDeletion) {
                $this->postCategoriasScheduledForDeletion = clone $this->collPostCategorias;
                $this->postCategoriasScheduledForDeletion->clear();
            }
            $this->postCategoriasScheduledForDeletion[]= clone $postCategoria;
            $postCategoria->setPost(null);
        }

        return $this;
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this Post is new, it will return
     * an empty collection; or if this Post has previously
     * been saved, it will retrieve related PostCategorias from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in Post.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @param      string $joinBehavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return ObjectCollection|ChildPostCategoria[] List of ChildPostCategoria objects
     */
    public function getPostCategoriasJoinCategoriaPost(Criteria $criteria = null, ConnectionInterface $con = null, $joinBehavior = Criteria::LEFT_JOIN)
    {
        $query = ChildPostCategoriaQuery::create(null, $criteria);
        $query->joinWith('CategoriaPost', $joinBehavior);

        return $this->getPostCategorias($query, $con);
    }

    /**
     * Clears out the collPostReports collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return void
     * @see        addPostReports()
     */
    public function clearPostReports()
    {
        $this->collPostReports = null; // important to set this to NULL since that means it is uninitialized
    }

    /**
     * Reset is the collPostReports collection loaded partially.
     */
    public function resetPartialPostReports($v = true)
    {
        $this->collPostReportsPartial = $v;
    }

    /**
     * Initializes the collPostReports collection.
     *
     * By default this just sets the collPostReports collection to an empty array (like clearcollPostReports());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param      boolean $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initPostReports($overrideExisting = true)
    {
        if (null !== $this->collPostReports && !$overrideExisting) {
            return;
        }

        $collectionClassName = PostReportTableMap::getTableMap()->getCollectionClassName();

        $this->collPostReports = new $collectionClassName;
        $this->collPostReports->setModel('\PostReport');
    }

    /**
     * Gets an array of ChildPostReport objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this ChildPost is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @return ObjectCollection|ChildPostReport[] List of ChildPostReport objects
     * @throws PropelException
     */
    public function getPostReports(Criteria $criteria = null, ConnectionInterface $con = null)
    {
        $partial = $this->collPostReportsPartial && !$this->isNew();
        if (null === $this->collPostReports || null !== $criteria  || $partial) {
            if ($this->isNew() && null === $this->collPostReports) {
                // return empty collection
                $this->initPostReports();
            } else {
                $collPostReports = ChildPostReportQuery::create(null, $criteria)
                    ->filterByPost($this)
                    ->find($con);

                if (null !== $criteria) {
                    if (false !== $this->collPostReportsPartial && count($collPostReports)) {
                        $this->initPostReports(false);

                        foreach ($collPostReports as $obj) {
                            if (false == $this->collPostReports->contains($obj)) {
                                $this->collPostReports->append($obj);
                            }
                        }

                        $this->collPostReportsPartial = true;
                    }

                    return $collPostReports;
                }

                if ($partial && $this->collPostReports) {
                    foreach ($this->collPostReports as $obj) {
                        if ($obj->isNew()) {
                            $collPostReports[] = $obj;
                        }
                    }
                }

                $this->collPostReports = $collPostReports;
                $this->collPostReportsPartial = false;
            }
        }

        return $this->collPostReports;
    }

    /**
     * Sets a collection of ChildPostReport objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param      Collection $postReports A Propel collection.
     * @param      ConnectionInterface $con Optional connection object
     * @return $this|ChildPost The current object (for fluent API support)
     */
    public function setPostReports(Collection $postReports, ConnectionInterface $con = null)
    {
        /** @var ChildPostReport[] $postReportsToDelete */
        $postReportsToDelete = $this->getPostReports(new Criteria(), $con)->diff($postReports);


        $this->postReportsScheduledForDeletion = $postReportsToDelete;

        foreach ($postReportsToDelete as $postReportRemoved) {
            $postReportRemoved->setPost(null);
        }

        $this->collPostReports = null;
        foreach ($postReports as $postReport) {
            $this->addPostReport($postReport);
        }

        $this->collPostReports = $postReports;
        $this->collPostReportsPartial = false;

        return $this;
    }

    /**
     * Returns the number of related PostReport objects.
     *
     * @param      Criteria $criteria
     * @param      boolean $distinct
     * @param      ConnectionInterface $con
     * @return int             Count of related PostReport objects.
     * @throws PropelException
     */
    public function countPostReports(Criteria $criteria = null, $distinct = false, ConnectionInterface $con = null)
    {
        $partial = $this->collPostReportsPartial && !$this->isNew();
        if (null === $this->collPostReports || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collPostReports) {
                return 0;
            }

            if ($partial && !$criteria) {
                return count($this->getPostReports());
            }

            $query = ChildPostReportQuery::create(null, $criteria);
            if ($distinct) {
                $query->distinct();
            }

            return $query
                ->filterByPost($this)
                ->count($con);
        }

        return count($this->collPostReports);
    }

    /**
     * Method called to associate a ChildPostReport object to this object
     * through the ChildPostReport foreign key attribute.
     *
     * @param  ChildPostReport $l ChildPostReport
     * @return $this|\Post The current object (for fluent API support)
     */
    public function addPostReport(ChildPostReport $l)
    {
        if ($this->collPostReports === null) {
            $this->initPostReports();
            $this->collPostReportsPartial = true;
        }

        if (!$this->collPostReports->contains($l)) {
            $this->doAddPostReport($l);

            if ($this->postReportsScheduledForDeletion and $this->postReportsScheduledForDeletion->contains($l)) {
                $this->postReportsScheduledForDeletion->remove($this->postReportsScheduledForDeletion->search($l));
            }
        }

        return $this;
    }

    /**
     * @param ChildPostReport $postReport The ChildPostReport object to add.
     */
    protected function doAddPostReport(ChildPostReport $postReport)
    {
        $this->collPostReports[]= $postReport;
        $postReport->setPost($this);
    }

    /**
     * @param  ChildPostReport $postReport The ChildPostReport object to remove.
     * @return $this|ChildPost The current object (for fluent API support)
     */
    public function removePostReport(ChildPostReport $postReport)
    {
        if ($this->getPostReports()->contains($postReport)) {
            $pos = $this->collPostReports->search($postReport);
            $this->collPostReports->remove($pos);
            if (null === $this->postReportsScheduledForDeletion) {
                $this->postReportsScheduledForDeletion = clone $this->collPostReports;
                $this->postReportsScheduledForDeletion->clear();
            }
            $this->postReportsScheduledForDeletion[]= $postReport;
            $postReport->setPost(null);
        }

        return $this;
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this Post is new, it will return
     * an empty collection; or if this Post has previously
     * been saved, it will retrieve related PostReports from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in Post.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @param      string $joinBehavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return ObjectCollection|ChildPostReport[] List of ChildPostReport objects
     */
    public function getPostReportsJoinReport(Criteria $criteria = null, ConnectionInterface $con = null, $joinBehavior = Criteria::LEFT_JOIN)
    {
        $query = ChildPostReportQuery::create(null, $criteria);
        $query->joinWith('Report', $joinBehavior);

        return $this->getPostReports($query, $con);
    }

    /**
     * Clears out the collPostTagssRelatedByIdpost collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return void
     * @see        addPostTagssRelatedByIdpost()
     */
    public function clearPostTagssRelatedByIdpost()
    {
        $this->collPostTagssRelatedByIdpost = null; // important to set this to NULL since that means it is uninitialized
    }

    /**
     * Reset is the collPostTagssRelatedByIdpost collection loaded partially.
     */
    public function resetPartialPostTagssRelatedByIdpost($v = true)
    {
        $this->collPostTagssRelatedByIdpostPartial = $v;
    }

    /**
     * Initializes the collPostTagssRelatedByIdpost collection.
     *
     * By default this just sets the collPostTagssRelatedByIdpost collection to an empty array (like clearcollPostTagssRelatedByIdpost());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param      boolean $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initPostTagssRelatedByIdpost($overrideExisting = true)
    {
        if (null !== $this->collPostTagssRelatedByIdpost && !$overrideExisting) {
            return;
        }

        $collectionClassName = PostTagsTableMap::getTableMap()->getCollectionClassName();

        $this->collPostTagssRelatedByIdpost = new $collectionClassName;
        $this->collPostTagssRelatedByIdpost->setModel('\PostTags');
    }

    /**
     * Gets an array of ChildPostTags objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this ChildPost is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @return ObjectCollection|ChildPostTags[] List of ChildPostTags objects
     * @throws PropelException
     */
    public function getPostTagssRelatedByIdpost(Criteria $criteria = null, ConnectionInterface $con = null)
    {
        $partial = $this->collPostTagssRelatedByIdpostPartial && !$this->isNew();
        if (null === $this->collPostTagssRelatedByIdpost || null !== $criteria  || $partial) {
            if ($this->isNew() && null === $this->collPostTagssRelatedByIdpost) {
                // return empty collection
                $this->initPostTagssRelatedByIdpost();
            } else {
                $collPostTagssRelatedByIdpost = ChildPostTagsQuery::create(null, $criteria)
                    ->filterByPostRelatedByIdpost($this)
                    ->find($con);

                if (null !== $criteria) {
                    if (false !== $this->collPostTagssRelatedByIdpostPartial && count($collPostTagssRelatedByIdpost)) {
                        $this->initPostTagssRelatedByIdpost(false);

                        foreach ($collPostTagssRelatedByIdpost as $obj) {
                            if (false == $this->collPostTagssRelatedByIdpost->contains($obj)) {
                                $this->collPostTagssRelatedByIdpost->append($obj);
                            }
                        }

                        $this->collPostTagssRelatedByIdpostPartial = true;
                    }

                    return $collPostTagssRelatedByIdpost;
                }

                if ($partial && $this->collPostTagssRelatedByIdpost) {
                    foreach ($this->collPostTagssRelatedByIdpost as $obj) {
                        if ($obj->isNew()) {
                            $collPostTagssRelatedByIdpost[] = $obj;
                        }
                    }
                }

                $this->collPostTagssRelatedByIdpost = $collPostTagssRelatedByIdpost;
                $this->collPostTagssRelatedByIdpostPartial = false;
            }
        }

        return $this->collPostTagssRelatedByIdpost;
    }

    /**
     * Sets a collection of ChildPostTags objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param      Collection $postTagssRelatedByIdpost A Propel collection.
     * @param      ConnectionInterface $con Optional connection object
     * @return $this|ChildPost The current object (for fluent API support)
     */
    public function setPostTagssRelatedByIdpost(Collection $postTagssRelatedByIdpost, ConnectionInterface $con = null)
    {
        /** @var ChildPostTags[] $postTagssRelatedByIdpostToDelete */
        $postTagssRelatedByIdpostToDelete = $this->getPostTagssRelatedByIdpost(new Criteria(), $con)->diff($postTagssRelatedByIdpost);


        //since at least one column in the foreign key is at the same time a PK
        //we can not just set a PK to NULL in the lines below. We have to store
        //a backup of all values, so we are able to manipulate these items based on the onDelete value later.
        $this->postTagssRelatedByIdpostScheduledForDeletion = clone $postTagssRelatedByIdpostToDelete;

        foreach ($postTagssRelatedByIdpostToDelete as $postTagsRelatedByIdpostRemoved) {
            $postTagsRelatedByIdpostRemoved->setPostRelatedByIdpost(null);
        }

        $this->collPostTagssRelatedByIdpost = null;
        foreach ($postTagssRelatedByIdpost as $postTagsRelatedByIdpost) {
            $this->addPostTagsRelatedByIdpost($postTagsRelatedByIdpost);
        }

        $this->collPostTagssRelatedByIdpost = $postTagssRelatedByIdpost;
        $this->collPostTagssRelatedByIdpostPartial = false;

        return $this;
    }

    /**
     * Returns the number of related PostTags objects.
     *
     * @param      Criteria $criteria
     * @param      boolean $distinct
     * @param      ConnectionInterface $con
     * @return int             Count of related PostTags objects.
     * @throws PropelException
     */
    public function countPostTagssRelatedByIdpost(Criteria $criteria = null, $distinct = false, ConnectionInterface $con = null)
    {
        $partial = $this->collPostTagssRelatedByIdpostPartial && !$this->isNew();
        if (null === $this->collPostTagssRelatedByIdpost || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collPostTagssRelatedByIdpost) {
                return 0;
            }

            if ($partial && !$criteria) {
                return count($this->getPostTagssRelatedByIdpost());
            }

            $query = ChildPostTagsQuery::create(null, $criteria);
            if ($distinct) {
                $query->distinct();
            }

            return $query
                ->filterByPostRelatedByIdpost($this)
                ->count($con);
        }

        return count($this->collPostTagssRelatedByIdpost);
    }

    /**
     * Method called to associate a ChildPostTags object to this object
     * through the ChildPostTags foreign key attribute.
     *
     * @param  ChildPostTags $l ChildPostTags
     * @return $this|\Post The current object (for fluent API support)
     */
    public function addPostTagsRelatedByIdpost(ChildPostTags $l)
    {
        if ($this->collPostTagssRelatedByIdpost === null) {
            $this->initPostTagssRelatedByIdpost();
            $this->collPostTagssRelatedByIdpostPartial = true;
        }

        if (!$this->collPostTagssRelatedByIdpost->contains($l)) {
            $this->doAddPostTagsRelatedByIdpost($l);

            if ($this->postTagssRelatedByIdpostScheduledForDeletion and $this->postTagssRelatedByIdpostScheduledForDeletion->contains($l)) {
                $this->postTagssRelatedByIdpostScheduledForDeletion->remove($this->postTagssRelatedByIdpostScheduledForDeletion->search($l));
            }
        }

        return $this;
    }

    /**
     * @param ChildPostTags $postTagsRelatedByIdpost The ChildPostTags object to add.
     */
    protected function doAddPostTagsRelatedByIdpost(ChildPostTags $postTagsRelatedByIdpost)
    {
        $this->collPostTagssRelatedByIdpost[]= $postTagsRelatedByIdpost;
        $postTagsRelatedByIdpost->setPostRelatedByIdpost($this);
    }

    /**
     * @param  ChildPostTags $postTagsRelatedByIdpost The ChildPostTags object to remove.
     * @return $this|ChildPost The current object (for fluent API support)
     */
    public function removePostTagsRelatedByIdpost(ChildPostTags $postTagsRelatedByIdpost)
    {
        if ($this->getPostTagssRelatedByIdpost()->contains($postTagsRelatedByIdpost)) {
            $pos = $this->collPostTagssRelatedByIdpost->search($postTagsRelatedByIdpost);
            $this->collPostTagssRelatedByIdpost->remove($pos);
            if (null === $this->postTagssRelatedByIdpostScheduledForDeletion) {
                $this->postTagssRelatedByIdpostScheduledForDeletion = clone $this->collPostTagssRelatedByIdpost;
                $this->postTagssRelatedByIdpostScheduledForDeletion->clear();
            }
            $this->postTagssRelatedByIdpostScheduledForDeletion[]= clone $postTagsRelatedByIdpost;
            $postTagsRelatedByIdpost->setPostRelatedByIdpost(null);
        }

        return $this;
    }

    /**
     * Clears out the collPostTagssRelatedByIdtag collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return void
     * @see        addPostTagssRelatedByIdtag()
     */
    public function clearPostTagssRelatedByIdtag()
    {
        $this->collPostTagssRelatedByIdtag = null; // important to set this to NULL since that means it is uninitialized
    }

    /**
     * Reset is the collPostTagssRelatedByIdtag collection loaded partially.
     */
    public function resetPartialPostTagssRelatedByIdtag($v = true)
    {
        $this->collPostTagssRelatedByIdtagPartial = $v;
    }

    /**
     * Initializes the collPostTagssRelatedByIdtag collection.
     *
     * By default this just sets the collPostTagssRelatedByIdtag collection to an empty array (like clearcollPostTagssRelatedByIdtag());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param      boolean $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initPostTagssRelatedByIdtag($overrideExisting = true)
    {
        if (null !== $this->collPostTagssRelatedByIdtag && !$overrideExisting) {
            return;
        }

        $collectionClassName = PostTagsTableMap::getTableMap()->getCollectionClassName();

        $this->collPostTagssRelatedByIdtag = new $collectionClassName;
        $this->collPostTagssRelatedByIdtag->setModel('\PostTags');
    }

    /**
     * Gets an array of ChildPostTags objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this ChildPost is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param      Criteria $criteria optional Criteria object to narrow the query
     * @param      ConnectionInterface $con optional connection object
     * @return ObjectCollection|ChildPostTags[] List of ChildPostTags objects
     * @throws PropelException
     */
    public function getPostTagssRelatedByIdtag(Criteria $criteria = null, ConnectionInterface $con = null)
    {
        $partial = $this->collPostTagssRelatedByIdtagPartial && !$this->isNew();
        if (null === $this->collPostTagssRelatedByIdtag || null !== $criteria  || $partial) {
            if ($this->isNew() && null === $this->collPostTagssRelatedByIdtag) {
                // return empty collection
                $this->initPostTagssRelatedByIdtag();
            } else {
                $collPostTagssRelatedByIdtag = ChildPostTagsQuery::create(null, $criteria)
                    ->filterByPostRelatedByIdtag($this)
                    ->find($con);

                if (null !== $criteria) {
                    if (false !== $this->collPostTagssRelatedByIdtagPartial && count($collPostTagssRelatedByIdtag)) {
                        $this->initPostTagssRelatedByIdtag(false);

                        foreach ($collPostTagssRelatedByIdtag as $obj) {
                            if (false == $this->collPostTagssRelatedByIdtag->contains($obj)) {
                                $this->collPostTagssRelatedByIdtag->append($obj);
                            }
                        }

                        $this->collPostTagssRelatedByIdtagPartial = true;
                    }

                    return $collPostTagssRelatedByIdtag;
                }

                if ($partial && $this->collPostTagssRelatedByIdtag) {
                    foreach ($this->collPostTagssRelatedByIdtag as $obj) {
                        if ($obj->isNew()) {
                            $collPostTagssRelatedByIdtag[] = $obj;
                        }
                    }
                }

                $this->collPostTagssRelatedByIdtag = $collPostTagssRelatedByIdtag;
                $this->collPostTagssRelatedByIdtagPartial = false;
            }
        }

        return $this->collPostTagssRelatedByIdtag;
    }

    /**
     * Sets a collection of ChildPostTags objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param      Collection $postTagssRelatedByIdtag A Propel collection.
     * @param      ConnectionInterface $con Optional connection object
     * @return $this|ChildPost The current object (for fluent API support)
     */
    public function setPostTagssRelatedByIdtag(Collection $postTagssRelatedByIdtag, ConnectionInterface $con = null)
    {
        /** @var ChildPostTags[] $postTagssRelatedByIdtagToDelete */
        $postTagssRelatedByIdtagToDelete = $this->getPostTagssRelatedByIdtag(new Criteria(), $con)->diff($postTagssRelatedByIdtag);


        //since at least one column in the foreign key is at the same time a PK
        //we can not just set a PK to NULL in the lines below. We have to store
        //a backup of all values, so we are able to manipulate these items based on the onDelete value later.
        $this->postTagssRelatedByIdtagScheduledForDeletion = clone $postTagssRelatedByIdtagToDelete;

        foreach ($postTagssRelatedByIdtagToDelete as $postTagsRelatedByIdtagRemoved) {
            $postTagsRelatedByIdtagRemoved->setPostRelatedByIdtag(null);
        }

        $this->collPostTagssRelatedByIdtag = null;
        foreach ($postTagssRelatedByIdtag as $postTagsRelatedByIdtag) {
            $this->addPostTagsRelatedByIdtag($postTagsRelatedByIdtag);
        }

        $this->collPostTagssRelatedByIdtag = $postTagssRelatedByIdtag;
        $this->collPostTagssRelatedByIdtagPartial = false;

        return $this;
    }

    /**
     * Returns the number of related PostTags objects.
     *
     * @param      Criteria $criteria
     * @param      boolean $distinct
     * @param      ConnectionInterface $con
     * @return int             Count of related PostTags objects.
     * @throws PropelException
     */
    public function countPostTagssRelatedByIdtag(Criteria $criteria = null, $distinct = false, ConnectionInterface $con = null)
    {
        $partial = $this->collPostTagssRelatedByIdtagPartial && !$this->isNew();
        if (null === $this->collPostTagssRelatedByIdtag || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collPostTagssRelatedByIdtag) {
                return 0;
            }

            if ($partial && !$criteria) {
                return count($this->getPostTagssRelatedByIdtag());
            }

            $query = ChildPostTagsQuery::create(null, $criteria);
            if ($distinct) {
                $query->distinct();
            }

            return $query
                ->filterByPostRelatedByIdtag($this)
                ->count($con);
        }

        return count($this->collPostTagssRelatedByIdtag);
    }

    /**
     * Method called to associate a ChildPostTags object to this object
     * through the ChildPostTags foreign key attribute.
     *
     * @param  ChildPostTags $l ChildPostTags
     * @return $this|\Post The current object (for fluent API support)
     */
    public function addPostTagsRelatedByIdtag(ChildPostTags $l)
    {
        if ($this->collPostTagssRelatedByIdtag === null) {
            $this->initPostTagssRelatedByIdtag();
            $this->collPostTagssRelatedByIdtagPartial = true;
        }

        if (!$this->collPostTagssRelatedByIdtag->contains($l)) {
            $this->doAddPostTagsRelatedByIdtag($l);

            if ($this->postTagssRelatedByIdtagScheduledForDeletion and $this->postTagssRelatedByIdtagScheduledForDeletion->contains($l)) {
                $this->postTagssRelatedByIdtagScheduledForDeletion->remove($this->postTagssRelatedByIdtagScheduledForDeletion->search($l));
            }
        }

        return $this;
    }

    /**
     * @param ChildPostTags $postTagsRelatedByIdtag The ChildPostTags object to add.
     */
    protected function doAddPostTagsRelatedByIdtag(ChildPostTags $postTagsRelatedByIdtag)
    {
        $this->collPostTagssRelatedByIdtag[]= $postTagsRelatedByIdtag;
        $postTagsRelatedByIdtag->setPostRelatedByIdtag($this);
    }

    /**
     * @param  ChildPostTags $postTagsRelatedByIdtag The ChildPostTags object to remove.
     * @return $this|ChildPost The current object (for fluent API support)
     */
    public function removePostTagsRelatedByIdtag(ChildPostTags $postTagsRelatedByIdtag)
    {
        if ($this->getPostTagssRelatedByIdtag()->contains($postTagsRelatedByIdtag)) {
            $pos = $this->collPostTagssRelatedByIdtag->search($postTagsRelatedByIdtag);
            $this->collPostTagssRelatedByIdtag->remove($pos);
            if (null === $this->postTagssRelatedByIdtagScheduledForDeletion) {
                $this->postTagssRelatedByIdtagScheduledForDeletion = clone $this->collPostTagssRelatedByIdtag;
                $this->postTagssRelatedByIdtagScheduledForDeletion->clear();
            }
            $this->postTagssRelatedByIdtagScheduledForDeletion[]= clone $postTagsRelatedByIdtag;
            $postTagsRelatedByIdtag->setPostRelatedByIdtag(null);
        }

        return $this;
    }

    /**
     * Clears the current object, sets all attributes to their default values and removes
     * outgoing references as well as back-references (from other objects to this one. Results probably in a database
     * change of those foreign objects when you call `save` there).
     */
    public function clear()
    {
        $this->id = null;
        $this->titulo = null;
        $this->texto = null;
        $this->idusuario = null;
        $this->visualizacoes = null;
        $this->datacriacao = null;
        $this->status = null;
        $this->capa = null;
        $this->alreadyInSave = false;
        $this->clearAllReferences();
        $this->applyDefaultValues();
        $this->resetModified();
        $this->setNew(true);
        $this->setDeleted(false);
    }

    /**
     * Resets all references and back-references to other model objects or collections of model objects.
     *
     * This method is used to reset all php object references (not the actual reference in the database).
     * Necessary for object serialisation.
     *
     * @param      boolean $deep Whether to also clear the references on all referrer objects.
     */
    public function clearAllReferences($deep = false)
    {
        if ($deep) {
            if ($this->collPostCategorias) {
                foreach ($this->collPostCategorias as $o) {
                    $o->clearAllReferences($deep);
                }
            }
            if ($this->collPostReports) {
                foreach ($this->collPostReports as $o) {
                    $o->clearAllReferences($deep);
                }
            }
            if ($this->collPostTagssRelatedByIdpost) {
                foreach ($this->collPostTagssRelatedByIdpost as $o) {
                    $o->clearAllReferences($deep);
                }
            }
            if ($this->collPostTagssRelatedByIdtag) {
                foreach ($this->collPostTagssRelatedByIdtag as $o) {
                    $o->clearAllReferences($deep);
                }
            }
        } // if ($deep)

        $this->collPostCategorias = null;
        $this->collPostReports = null;
        $this->collPostTagssRelatedByIdpost = null;
        $this->collPostTagssRelatedByIdtag = null;
    }

    /**
     * Return the string representation of this object
     *
     * @return string
     */
    public function __toString()
    {
        return (string) $this->exportTo(PostTableMap::DEFAULT_STRING_FORMAT);
    }

    /**
     * Code to be run before persisting the object
     * @param  ConnectionInterface $con
     * @return boolean
     */
    public function preSave(ConnectionInterface $con = null)
    {
                return true;
    }

    /**
     * Code to be run after persisting the object
     * @param ConnectionInterface $con
     */
    public function postSave(ConnectionInterface $con = null)
    {
            }

    /**
     * Code to be run before inserting to database
     * @param  ConnectionInterface $con
     * @return boolean
     */
    public function preInsert(ConnectionInterface $con = null)
    {
                return true;
    }

    /**
     * Code to be run after inserting to database
     * @param ConnectionInterface $con
     */
    public function postInsert(ConnectionInterface $con = null)
    {
            }

    /**
     * Code to be run before updating the object in database
     * @param  ConnectionInterface $con
     * @return boolean
     */
    public function preUpdate(ConnectionInterface $con = null)
    {
                return true;
    }

    /**
     * Code to be run after updating the object in database
     * @param ConnectionInterface $con
     */
    public function postUpdate(ConnectionInterface $con = null)
    {
            }

    /**
     * Code to be run before deleting the object in database
     * @param  ConnectionInterface $con
     * @return boolean
     */
    public function preDelete(ConnectionInterface $con = null)
    {
                return true;
    }

    /**
     * Code to be run after deleting the object in database
     * @param ConnectionInterface $con
     */
    public function postDelete(ConnectionInterface $con = null)
    {
            }


    /**
     * Derived method to catches calls to undefined methods.
     *
     * Provides magic import/export method support (fromXML()/toXML(), fromYAML()/toYAML(), etc.).
     * Allows to define default __call() behavior if you overwrite __call()
     *
     * @param string $name
     * @param mixed  $params
     *
     * @return array|string
     */
    public function __call($name, $params)
    {
        if (0 === strpos($name, 'get')) {
            $virtualColumn = substr($name, 3);
            if ($this->hasVirtualColumn($virtualColumn)) {
                return $this->getVirtualColumn($virtualColumn);
            }

            $virtualColumn = lcfirst($virtualColumn);
            if ($this->hasVirtualColumn($virtualColumn)) {
                return $this->getVirtualColumn($virtualColumn);
            }
        }

        if (0 === strpos($name, 'from')) {
            $format = substr($name, 4);

            return $this->importFrom($format, reset($params));
        }

        if (0 === strpos($name, 'to')) {
            $format = substr($name, 2);
            $includeLazyLoadColumns = isset($params[0]) ? $params[0] : true;

            return $this->exportTo($format, $includeLazyLoadColumns);
        }

        throw new BadMethodCallException(sprintf('Call to undefined method: %s.', $name));
    }

}
