<?php

namespace Base;

use \Customer as ChildCustomer;
use \CustomerQuery as ChildCustomerQuery;
use \Exception;
use \PDO;
use Map\CustomerTableMap;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\ModelCriteria;
use Propel\Runtime\ActiveQuery\ModelJoin;
use Propel\Runtime\Collection\ObjectCollection;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\Exception\PropelException;

/**
 * Base class that represents a query for the 'customer' table.
 *
 *
 *
 * @method     ChildCustomerQuery orderById($order = Criteria::ASC) Order by the id column
 * @method     ChildCustomerQuery orderByPassword($order = Criteria::ASC) Order by the password column
 * @method     ChildCustomerQuery orderByLastlogin($order = Criteria::ASC) Order by the lastlogin column
 * @method     ChildCustomerQuery orderByLastaccess($order = Criteria::ASC) Order by the lastaccess column
 * @method     ChildCustomerQuery orderByLastpage($order = Criteria::ASC) Order by the lastpage column
 * @method     ChildCustomerQuery orderByLastip($order = Criteria::ASC) Order by the lastip column
 * @method     ChildCustomerQuery orderByStatus($order = Criteria::ASC) Order by the status column
 *
 * @method     ChildCustomerQuery groupById() Group by the id column
 * @method     ChildCustomerQuery groupByPassword() Group by the password column
 * @method     ChildCustomerQuery groupByLastlogin() Group by the lastlogin column
 * @method     ChildCustomerQuery groupByLastaccess() Group by the lastaccess column
 * @method     ChildCustomerQuery groupByLastpage() Group by the lastpage column
 * @method     ChildCustomerQuery groupByLastip() Group by the lastip column
 * @method     ChildCustomerQuery groupByStatus() Group by the status column
 *
 * @method     ChildCustomerQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method     ChildCustomerQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method     ChildCustomerQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method     ChildCustomerQuery leftJoinPeople($relationAlias = null) Adds a LEFT JOIN clause to the query using the People relation
 * @method     ChildCustomerQuery rightJoinPeople($relationAlias = null) Adds a RIGHT JOIN clause to the query using the People relation
 * @method     ChildCustomerQuery innerJoinPeople($relationAlias = null) Adds a INNER JOIN clause to the query using the People relation
 *
 * @method     \PeopleQuery endUse() Finalizes a secondary criteria and merges it with its primary Criteria
 *
 * @method     ChildCustomer findOne(ConnectionInterface $con = null) Return the first ChildCustomer matching the query
 * @method     ChildCustomer findOneOrCreate(ConnectionInterface $con = null) Return the first ChildCustomer matching the query, or a new ChildCustomer object populated from the query conditions when no match is found
 *
 * @method     ChildCustomer findOneById(int $id) Return the first ChildCustomer filtered by the id column
 * @method     ChildCustomer findOneByPassword(string $password) Return the first ChildCustomer filtered by the password column
 * @method     ChildCustomer findOneByLastlogin(string $lastlogin) Return the first ChildCustomer filtered by the lastlogin column
 * @method     ChildCustomer findOneByLastaccess(string $lastaccess) Return the first ChildCustomer filtered by the lastaccess column
 * @method     ChildCustomer findOneByLastpage(string $lastpage) Return the first ChildCustomer filtered by the lastpage column
 * @method     ChildCustomer findOneByLastip(string $lastip) Return the first ChildCustomer filtered by the lastip column
 * @method     ChildCustomer findOneByStatus(int $status) Return the first ChildCustomer filtered by the status column *

 * @method     ChildCustomer requirePk($key, ConnectionInterface $con = null) Return the ChildCustomer by primary key and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildCustomer requireOne(ConnectionInterface $con = null) Return the first ChildCustomer matching the query and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildCustomer requireOneById(int $id) Return the first ChildCustomer filtered by the id column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildCustomer requireOneByPassword(string $password) Return the first ChildCustomer filtered by the password column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildCustomer requireOneByLastlogin(string $lastlogin) Return the first ChildCustomer filtered by the lastlogin column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildCustomer requireOneByLastaccess(string $lastaccess) Return the first ChildCustomer filtered by the lastaccess column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildCustomer requireOneByLastpage(string $lastpage) Return the first ChildCustomer filtered by the lastpage column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildCustomer requireOneByLastip(string $lastip) Return the first ChildCustomer filtered by the lastip column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildCustomer requireOneByStatus(int $status) Return the first ChildCustomer filtered by the status column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildCustomer[]|ObjectCollection find(ConnectionInterface $con = null) Return ChildCustomer objects based on current ModelCriteria
 * @method     ChildCustomer[]|ObjectCollection findById(int $id) Return ChildCustomer objects filtered by the id column
 * @method     ChildCustomer[]|ObjectCollection findByPassword(string $password) Return ChildCustomer objects filtered by the password column
 * @method     ChildCustomer[]|ObjectCollection findByLastlogin(string $lastlogin) Return ChildCustomer objects filtered by the lastlogin column
 * @method     ChildCustomer[]|ObjectCollection findByLastaccess(string $lastaccess) Return ChildCustomer objects filtered by the lastaccess column
 * @method     ChildCustomer[]|ObjectCollection findByLastpage(string $lastpage) Return ChildCustomer objects filtered by the lastpage column
 * @method     ChildCustomer[]|ObjectCollection findByLastip(string $lastip) Return ChildCustomer objects filtered by the lastip column
 * @method     ChildCustomer[]|ObjectCollection findByStatus(int $status) Return ChildCustomer objects filtered by the status column
 * @method     ChildCustomer[]|\Propel\Runtime\Util\PropelModelPager paginate($page = 1, $maxPerPage = 10, ConnectionInterface $con = null) Issue a SELECT query based on the current ModelCriteria and uses a page and a maximum number of results per page to compute an offset and a limit
 *
 */
abstract class CustomerQuery extends ModelCriteria
{
    protected $entityNotFoundExceptionClass = '\\Propel\\Runtime\\Exception\\EntityNotFoundException';

    /**
     * Initializes internal state of \Base\CustomerQuery object.
     *
     * @param     string $dbName The database name
     * @param     string $modelName The phpName of a model, e.g. 'Book'
     * @param     string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = 'pfw', $modelName = '\\Customer', $modelAlias = null)
    {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new ChildCustomerQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param     Criteria $criteria Optional Criteria to build the query from
     *
     * @return ChildCustomerQuery
     */
    public static function create($modelAlias = null, Criteria $criteria = null)
    {
        if ($criteria instanceof ChildCustomerQuery) {
            return $criteria;
        }
        $query = new ChildCustomerQuery();
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
     * @return ChildCustomer|array|mixed the result, formatted by the current formatter
     */
    public function findPk($key, ConnectionInterface $con = null)
    {
        if ($key === null) {
            return null;
        }
        if ((null !== ($obj = CustomerTableMap::getInstanceFromPool((string) $key))) && !$this->formatter) {
            // the object is already in the instance pool
            return $obj;
        }
        if ($con === null) {
            $con = Propel::getServiceContainer()->getReadConnection(CustomerTableMap::DATABASE_NAME);
        }
        $this->basePreSelect($con);
        if ($this->formatter || $this->modelAlias || $this->with || $this->select
         || $this->selectColumns || $this->asColumns || $this->selectModifiers
         || $this->map || $this->having || $this->joins) {
            return $this->findPkComplex($key, $con);
        } else {
            return $this->findPkSimple($key, $con);
        }
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
     * @return ChildCustomer A model object, or null if the key is not found
     */
    protected function findPkSimple($key, ConnectionInterface $con)
    {
        $sql = 'SELECT id, password, lastlogin, lastaccess, lastpage, lastip, status FROM customer WHERE id = :p0';
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
            /** @var ChildCustomer $obj */
            $obj = new ChildCustomer();
            $obj->hydrate($row);
            CustomerTableMap::addInstanceToPool($obj, (string) $key);
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
     * @return ChildCustomer|array|mixed the result, formatted by the current formatter
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
     * @return $this|ChildCustomerQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {

        return $this->addUsingAlias(CustomerTableMap::COL_ID, $key, Criteria::EQUAL);
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return $this|ChildCustomerQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {

        return $this->addUsingAlias(CustomerTableMap::COL_ID, $keys, Criteria::IN);
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
     * @see       filterByPeople()
     *
     * @param     mixed $id The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildCustomerQuery The current query, for fluid interface
     */
    public function filterById($id = null, $comparison = null)
    {
        if (is_array($id)) {
            $useMinMax = false;
            if (isset($id['min'])) {
                $this->addUsingAlias(CustomerTableMap::COL_ID, $id['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($id['max'])) {
                $this->addUsingAlias(CustomerTableMap::COL_ID, $id['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(CustomerTableMap::COL_ID, $id, $comparison);
    }

    /**
     * Filter the query on the password column
     *
     * Example usage:
     * <code>
     * $query->filterByPassword('fooValue');   // WHERE password = 'fooValue'
     * $query->filterByPassword('%fooValue%'); // WHERE password LIKE '%fooValue%'
     * </code>
     *
     * @param     string $password The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildCustomerQuery The current query, for fluid interface
     */
    public function filterByPassword($password = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($password)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $password)) {
                $password = str_replace('*', '%', $password);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(CustomerTableMap::COL_PASSWORD, $password, $comparison);
    }

    /**
     * Filter the query on the lastlogin column
     *
     * Example usage:
     * <code>
     * $query->filterByLastlogin('2011-03-14'); // WHERE lastlogin = '2011-03-14'
     * $query->filterByLastlogin('now'); // WHERE lastlogin = '2011-03-14'
     * $query->filterByLastlogin(array('max' => 'yesterday')); // WHERE lastlogin > '2011-03-13'
     * </code>
     *
     * @param     mixed $lastlogin The value to use as filter.
     *              Values can be integers (unix timestamps), DateTime objects, or strings.
     *              Empty strings are treated as NULL.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildCustomerQuery The current query, for fluid interface
     */
    public function filterByLastlogin($lastlogin = null, $comparison = null)
    {
        if (is_array($lastlogin)) {
            $useMinMax = false;
            if (isset($lastlogin['min'])) {
                $this->addUsingAlias(CustomerTableMap::COL_LASTLOGIN, $lastlogin['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($lastlogin['max'])) {
                $this->addUsingAlias(CustomerTableMap::COL_LASTLOGIN, $lastlogin['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(CustomerTableMap::COL_LASTLOGIN, $lastlogin, $comparison);
    }

    /**
     * Filter the query on the lastaccess column
     *
     * Example usage:
     * <code>
     * $query->filterByLastaccess('2011-03-14'); // WHERE lastaccess = '2011-03-14'
     * $query->filterByLastaccess('now'); // WHERE lastaccess = '2011-03-14'
     * $query->filterByLastaccess(array('max' => 'yesterday')); // WHERE lastaccess > '2011-03-13'
     * </code>
     *
     * @param     mixed $lastaccess The value to use as filter.
     *              Values can be integers (unix timestamps), DateTime objects, or strings.
     *              Empty strings are treated as NULL.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildCustomerQuery The current query, for fluid interface
     */
    public function filterByLastaccess($lastaccess = null, $comparison = null)
    {
        if (is_array($lastaccess)) {
            $useMinMax = false;
            if (isset($lastaccess['min'])) {
                $this->addUsingAlias(CustomerTableMap::COL_LASTACCESS, $lastaccess['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($lastaccess['max'])) {
                $this->addUsingAlias(CustomerTableMap::COL_LASTACCESS, $lastaccess['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(CustomerTableMap::COL_LASTACCESS, $lastaccess, $comparison);
    }

    /**
     * Filter the query on the lastpage column
     *
     * Example usage:
     * <code>
     * $query->filterByLastpage('fooValue');   // WHERE lastpage = 'fooValue'
     * $query->filterByLastpage('%fooValue%'); // WHERE lastpage LIKE '%fooValue%'
     * </code>
     *
     * @param     string $lastpage The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildCustomerQuery The current query, for fluid interface
     */
    public function filterByLastpage($lastpage = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($lastpage)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $lastpage)) {
                $lastpage = str_replace('*', '%', $lastpage);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(CustomerTableMap::COL_LASTPAGE, $lastpage, $comparison);
    }

    /**
     * Filter the query on the lastip column
     *
     * Example usage:
     * <code>
     * $query->filterByLastip('fooValue');   // WHERE lastip = 'fooValue'
     * $query->filterByLastip('%fooValue%'); // WHERE lastip LIKE '%fooValue%'
     * </code>
     *
     * @param     string $lastip The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildCustomerQuery The current query, for fluid interface
     */
    public function filterByLastip($lastip = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($lastip)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $lastip)) {
                $lastip = str_replace('*', '%', $lastip);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(CustomerTableMap::COL_LASTIP, $lastip, $comparison);
    }

    /**
     * Filter the query on the status column
     *
     * Example usage:
     * <code>
     * $query->filterByStatus(1234); // WHERE status = 1234
     * $query->filterByStatus(array(12, 34)); // WHERE status IN (12, 34)
     * $query->filterByStatus(array('min' => 12)); // WHERE status > 12
     * </code>
     *
     * @param     mixed $status The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildCustomerQuery The current query, for fluid interface
     */
    public function filterByStatus($status = null, $comparison = null)
    {
        if (is_array($status)) {
            $useMinMax = false;
            if (isset($status['min'])) {
                $this->addUsingAlias(CustomerTableMap::COL_STATUS, $status['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($status['max'])) {
                $this->addUsingAlias(CustomerTableMap::COL_STATUS, $status['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(CustomerTableMap::COL_STATUS, $status, $comparison);
    }

    /**
     * Filter the query by a related \People object
     *
     * @param \People|ObjectCollection $people The related object(s) to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @throws \Propel\Runtime\Exception\PropelException
     *
     * @return ChildCustomerQuery The current query, for fluid interface
     */
    public function filterByPeople($people, $comparison = null)
    {
        if ($people instanceof \People) {
            return $this
                ->addUsingAlias(CustomerTableMap::COL_ID, $people->getId(), $comparison);
        } elseif ($people instanceof ObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(CustomerTableMap::COL_ID, $people->toKeyValue('PrimaryKey', 'Id'), $comparison);
        } else {
            throw new PropelException('filterByPeople() only accepts arguments of type \People or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the People relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildCustomerQuery The current query, for fluid interface
     */
    public function joinPeople($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('People');

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
            $this->addJoinObject($join, 'People');
        }

        return $this;
    }

    /**
     * Use the People relation People object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \PeopleQuery A secondary query class using the current class as primary query
     */
    public function usePeopleQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinPeople($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'People', '\PeopleQuery');
    }

    /**
     * Exclude object from result
     *
     * @param   ChildCustomer $customer Object to remove from the list of results
     *
     * @return $this|ChildCustomerQuery The current query, for fluid interface
     */
    public function prune($customer = null)
    {
        if ($customer) {
            $this->addUsingAlias(CustomerTableMap::COL_ID, $customer->getId(), Criteria::NOT_EQUAL);
        }

        return $this;
    }

    /**
     * Deletes all rows from the customer table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public function doDeleteAll(ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(CustomerTableMap::DATABASE_NAME);
        }

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con) {
            $affectedRows = 0; // initialize var to track total num of affected rows
            $affectedRows += parent::doDeleteAll($con);
            // Because this db requires some delete cascade/set null emulation, we have to
            // clear the cached instance *after* the emulation has happened (since
            // instances get re-added by the select statement contained therein).
            CustomerTableMap::clearInstancePool();
            CustomerTableMap::clearRelatedInstancePool();

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
            $con = Propel::getServiceContainer()->getWriteConnection(CustomerTableMap::DATABASE_NAME);
        }

        $criteria = $this;

        // Set the correct dbName
        $criteria->setDbName(CustomerTableMap::DATABASE_NAME);

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con, $criteria) {
            $affectedRows = 0; // initialize var to track total num of affected rows

            CustomerTableMap::removeInstanceFromPool($criteria);

            $affectedRows += ModelCriteria::delete($con);
            CustomerTableMap::clearRelatedInstancePool();

            return $affectedRows;
        });
    }

} // CustomerQuery
