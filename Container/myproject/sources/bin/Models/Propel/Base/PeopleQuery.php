<?php

namespace Base;

use \People as ChildPeople;
use \PeopleQuery as ChildPeopleQuery;
use \Exception;
use \PDO;
use Map\PeopleTableMap;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\ModelCriteria;
use Propel\Runtime\ActiveQuery\ModelJoin;
use Propel\Runtime\Collection\ObjectCollection;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\Exception\PropelException;

/**
 * Base class that represents a query for the 'people' table.
 *
 *
 *
 * @method     ChildPeopleQuery orderById($order = Criteria::ASC) Order by the id column
 * @method     ChildPeopleQuery orderByTitle($order = Criteria::ASC) Order by the title column
 * @method     ChildPeopleQuery orderByLastname($order = Criteria::ASC) Order by the lastname column
 * @method     ChildPeopleQuery orderByFirstname($order = Criteria::ASC) Order by the firstname column
 * @method     ChildPeopleQuery orderByEmail($order = Criteria::ASC) Order by the email column
 * @method     ChildPeopleQuery orderByEmail2($order = Criteria::ASC) Order by the email2 column
 * @method     ChildPeopleQuery orderByAddress($order = Criteria::ASC) Order by the address column
 * @method     ChildPeopleQuery orderByZip($order = Criteria::ASC) Order by the zip column
 * @method     ChildPeopleQuery orderByCity($order = Criteria::ASC) Order by the city column
 * @method     ChildPeopleQuery orderByState($order = Criteria::ASC) Order by the state column
 * @method     ChildPeopleQuery orderByLatitude($order = Criteria::ASC) Order by the latitude column
 * @method     ChildPeopleQuery orderByLongitude($order = Criteria::ASC) Order by the longitude column
 * @method     ChildPeopleQuery orderByPhone($order = Criteria::ASC) Order by the phone column
 * @method     ChildPeopleQuery orderByLang($order = Criteria::ASC) Order by the lang column
 * @method     ChildPeopleQuery orderByMailinglist($order = Criteria::ASC) Order by the mailinglist column
 *
 * @method     ChildPeopleQuery groupById() Group by the id column
 * @method     ChildPeopleQuery groupByTitle() Group by the title column
 * @method     ChildPeopleQuery groupByLastname() Group by the lastname column
 * @method     ChildPeopleQuery groupByFirstname() Group by the firstname column
 * @method     ChildPeopleQuery groupByEmail() Group by the email column
 * @method     ChildPeopleQuery groupByEmail2() Group by the email2 column
 * @method     ChildPeopleQuery groupByAddress() Group by the address column
 * @method     ChildPeopleQuery groupByZip() Group by the zip column
 * @method     ChildPeopleQuery groupByCity() Group by the city column
 * @method     ChildPeopleQuery groupByState() Group by the state column
 * @method     ChildPeopleQuery groupByLatitude() Group by the latitude column
 * @method     ChildPeopleQuery groupByLongitude() Group by the longitude column
 * @method     ChildPeopleQuery groupByPhone() Group by the phone column
 * @method     ChildPeopleQuery groupByLang() Group by the lang column
 * @method     ChildPeopleQuery groupByMailinglist() Group by the mailinglist column
 *
 * @method     ChildPeopleQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method     ChildPeopleQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method     ChildPeopleQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method     ChildPeopleQuery leftJoinCustomer($relationAlias = null) Adds a LEFT JOIN clause to the query using the Customer relation
 * @method     ChildPeopleQuery rightJoinCustomer($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Customer relation
 * @method     ChildPeopleQuery innerJoinCustomer($relationAlias = null) Adds a INNER JOIN clause to the query using the Customer relation
 *
 * @method     \CustomerQuery endUse() Finalizes a secondary criteria and merges it with its primary Criteria
 *
 * @method     ChildPeople findOne(ConnectionInterface $con = null) Return the first ChildPeople matching the query
 * @method     ChildPeople findOneOrCreate(ConnectionInterface $con = null) Return the first ChildPeople matching the query, or a new ChildPeople object populated from the query conditions when no match is found
 *
 * @method     ChildPeople findOneById(int $id) Return the first ChildPeople filtered by the id column
 * @method     ChildPeople findOneByTitle(string $title) Return the first ChildPeople filtered by the title column
 * @method     ChildPeople findOneByLastname(string $lastname) Return the first ChildPeople filtered by the lastname column
 * @method     ChildPeople findOneByFirstname(string $firstname) Return the first ChildPeople filtered by the firstname column
 * @method     ChildPeople findOneByEmail(string $email) Return the first ChildPeople filtered by the email column
 * @method     ChildPeople findOneByEmail2(string $email2) Return the first ChildPeople filtered by the email2 column
 * @method     ChildPeople findOneByAddress(string $address) Return the first ChildPeople filtered by the address column
 * @method     ChildPeople findOneByZip(string $zip) Return the first ChildPeople filtered by the zip column
 * @method     ChildPeople findOneByCity(string $city) Return the first ChildPeople filtered by the city column
 * @method     ChildPeople findOneByState(string $state) Return the first ChildPeople filtered by the state column
 * @method     ChildPeople findOneByLatitude(double $latitude) Return the first ChildPeople filtered by the latitude column
 * @method     ChildPeople findOneByLongitude(double $longitude) Return the first ChildPeople filtered by the longitude column
 * @method     ChildPeople findOneByPhone(string $phone) Return the first ChildPeople filtered by the phone column
 * @method     ChildPeople findOneByLang(string $lang) Return the first ChildPeople filtered by the lang column
 * @method     ChildPeople findOneByMailinglist(boolean $mailinglist) Return the first ChildPeople filtered by the mailinglist column *

 * @method     ChildPeople requirePk($key, ConnectionInterface $con = null) Return the ChildPeople by primary key and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildPeople requireOne(ConnectionInterface $con = null) Return the first ChildPeople matching the query and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildPeople requireOneById(int $id) Return the first ChildPeople filtered by the id column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildPeople requireOneByTitle(string $title) Return the first ChildPeople filtered by the title column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildPeople requireOneByLastname(string $lastname) Return the first ChildPeople filtered by the lastname column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildPeople requireOneByFirstname(string $firstname) Return the first ChildPeople filtered by the firstname column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildPeople requireOneByEmail(string $email) Return the first ChildPeople filtered by the email column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildPeople requireOneByEmail2(string $email2) Return the first ChildPeople filtered by the email2 column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildPeople requireOneByAddress(string $address) Return the first ChildPeople filtered by the address column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildPeople requireOneByZip(string $zip) Return the first ChildPeople filtered by the zip column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildPeople requireOneByCity(string $city) Return the first ChildPeople filtered by the city column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildPeople requireOneByState(string $state) Return the first ChildPeople filtered by the state column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildPeople requireOneByLatitude(double $latitude) Return the first ChildPeople filtered by the latitude column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildPeople requireOneByLongitude(double $longitude) Return the first ChildPeople filtered by the longitude column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildPeople requireOneByPhone(string $phone) Return the first ChildPeople filtered by the phone column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildPeople requireOneByLang(string $lang) Return the first ChildPeople filtered by the lang column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 * @method     ChildPeople requireOneByMailinglist(boolean $mailinglist) Return the first ChildPeople filtered by the mailinglist column and throws \Propel\Runtime\Exception\EntityNotFoundException when not found
 *
 * @method     ChildPeople[]|ObjectCollection find(ConnectionInterface $con = null) Return ChildPeople objects based on current ModelCriteria
 * @method     ChildPeople[]|ObjectCollection findById(int $id) Return ChildPeople objects filtered by the id column
 * @method     ChildPeople[]|ObjectCollection findByTitle(string $title) Return ChildPeople objects filtered by the title column
 * @method     ChildPeople[]|ObjectCollection findByLastname(string $lastname) Return ChildPeople objects filtered by the lastname column
 * @method     ChildPeople[]|ObjectCollection findByFirstname(string $firstname) Return ChildPeople objects filtered by the firstname column
 * @method     ChildPeople[]|ObjectCollection findByEmail(string $email) Return ChildPeople objects filtered by the email column
 * @method     ChildPeople[]|ObjectCollection findByEmail2(string $email2) Return ChildPeople objects filtered by the email2 column
 * @method     ChildPeople[]|ObjectCollection findByAddress(string $address) Return ChildPeople objects filtered by the address column
 * @method     ChildPeople[]|ObjectCollection findByZip(string $zip) Return ChildPeople objects filtered by the zip column
 * @method     ChildPeople[]|ObjectCollection findByCity(string $city) Return ChildPeople objects filtered by the city column
 * @method     ChildPeople[]|ObjectCollection findByState(string $state) Return ChildPeople objects filtered by the state column
 * @method     ChildPeople[]|ObjectCollection findByLatitude(double $latitude) Return ChildPeople objects filtered by the latitude column
 * @method     ChildPeople[]|ObjectCollection findByLongitude(double $longitude) Return ChildPeople objects filtered by the longitude column
 * @method     ChildPeople[]|ObjectCollection findByPhone(string $phone) Return ChildPeople objects filtered by the phone column
 * @method     ChildPeople[]|ObjectCollection findByLang(string $lang) Return ChildPeople objects filtered by the lang column
 * @method     ChildPeople[]|ObjectCollection findByMailinglist(boolean $mailinglist) Return ChildPeople objects filtered by the mailinglist column
 * @method     ChildPeople[]|\Propel\Runtime\Util\PropelModelPager paginate($page = 1, $maxPerPage = 10, ConnectionInterface $con = null) Issue a SELECT query based on the current ModelCriteria and uses a page and a maximum number of results per page to compute an offset and a limit
 *
 */
abstract class PeopleQuery extends ModelCriteria
{
    protected $entityNotFoundExceptionClass = '\\Propel\\Runtime\\Exception\\EntityNotFoundException';

    /**
     * Initializes internal state of \Base\PeopleQuery object.
     *
     * @param     string $dbName The database name
     * @param     string $modelName The phpName of a model, e.g. 'Book'
     * @param     string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = 'pfw', $modelName = '\\People', $modelAlias = null)
    {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new ChildPeopleQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param     Criteria $criteria Optional Criteria to build the query from
     *
     * @return ChildPeopleQuery
     */
    public static function create($modelAlias = null, Criteria $criteria = null)
    {
        if ($criteria instanceof ChildPeopleQuery) {
            return $criteria;
        }
        $query = new ChildPeopleQuery();
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
     * @return ChildPeople|array|mixed the result, formatted by the current formatter
     */
    public function findPk($key, ConnectionInterface $con = null)
    {
        if ($key === null) {
            return null;
        }
        if ((null !== ($obj = PeopleTableMap::getInstanceFromPool((string) $key))) && !$this->formatter) {
            // the object is already in the instance pool
            return $obj;
        }
        if ($con === null) {
            $con = Propel::getServiceContainer()->getReadConnection(PeopleTableMap::DATABASE_NAME);
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
     * @return ChildPeople A model object, or null if the key is not found
     */
    protected function findPkSimple($key, ConnectionInterface $con)
    {
        $sql = 'SELECT id, title, lastname, firstname, email, email2, address, zip, city, state, latitude, longitude, phone, lang, mailinglist FROM people WHERE id = :p0';
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
            /** @var ChildPeople $obj */
            $obj = new ChildPeople();
            $obj->hydrate($row);
            PeopleTableMap::addInstanceToPool($obj, (string) $key);
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
     * @return ChildPeople|array|mixed the result, formatted by the current formatter
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
     * @return $this|ChildPeopleQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {

        return $this->addUsingAlias(PeopleTableMap::COL_ID, $key, Criteria::EQUAL);
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return $this|ChildPeopleQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {

        return $this->addUsingAlias(PeopleTableMap::COL_ID, $keys, Criteria::IN);
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
     * @return $this|ChildPeopleQuery The current query, for fluid interface
     */
    public function filterById($id = null, $comparison = null)
    {
        if (is_array($id)) {
            $useMinMax = false;
            if (isset($id['min'])) {
                $this->addUsingAlias(PeopleTableMap::COL_ID, $id['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($id['max'])) {
                $this->addUsingAlias(PeopleTableMap::COL_ID, $id['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(PeopleTableMap::COL_ID, $id, $comparison);
    }

    /**
     * Filter the query on the title column
     *
     * Example usage:
     * <code>
     * $query->filterByTitle('fooValue');   // WHERE title = 'fooValue'
     * $query->filterByTitle('%fooValue%'); // WHERE title LIKE '%fooValue%'
     * </code>
     *
     * @param     string $title The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildPeopleQuery The current query, for fluid interface
     */
    public function filterByTitle($title = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($title)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $title)) {
                $title = str_replace('*', '%', $title);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(PeopleTableMap::COL_TITLE, $title, $comparison);
    }

    /**
     * Filter the query on the lastname column
     *
     * Example usage:
     * <code>
     * $query->filterByLastname('fooValue');   // WHERE lastname = 'fooValue'
     * $query->filterByLastname('%fooValue%'); // WHERE lastname LIKE '%fooValue%'
     * </code>
     *
     * @param     string $lastname The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildPeopleQuery The current query, for fluid interface
     */
    public function filterByLastname($lastname = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($lastname)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $lastname)) {
                $lastname = str_replace('*', '%', $lastname);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(PeopleTableMap::COL_LASTNAME, $lastname, $comparison);
    }

    /**
     * Filter the query on the firstname column
     *
     * Example usage:
     * <code>
     * $query->filterByFirstname('fooValue');   // WHERE firstname = 'fooValue'
     * $query->filterByFirstname('%fooValue%'); // WHERE firstname LIKE '%fooValue%'
     * </code>
     *
     * @param     string $firstname The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildPeopleQuery The current query, for fluid interface
     */
    public function filterByFirstname($firstname = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($firstname)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $firstname)) {
                $firstname = str_replace('*', '%', $firstname);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(PeopleTableMap::COL_FIRSTNAME, $firstname, $comparison);
    }

    /**
     * Filter the query on the email column
     *
     * Example usage:
     * <code>
     * $query->filterByEmail('fooValue');   // WHERE email = 'fooValue'
     * $query->filterByEmail('%fooValue%'); // WHERE email LIKE '%fooValue%'
     * </code>
     *
     * @param     string $email The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildPeopleQuery The current query, for fluid interface
     */
    public function filterByEmail($email = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($email)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $email)) {
                $email = str_replace('*', '%', $email);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(PeopleTableMap::COL_EMAIL, $email, $comparison);
    }

    /**
     * Filter the query on the email2 column
     *
     * Example usage:
     * <code>
     * $query->filterByEmail2('fooValue');   // WHERE email2 = 'fooValue'
     * $query->filterByEmail2('%fooValue%'); // WHERE email2 LIKE '%fooValue%'
     * </code>
     *
     * @param     string $email2 The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildPeopleQuery The current query, for fluid interface
     */
    public function filterByEmail2($email2 = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($email2)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $email2)) {
                $email2 = str_replace('*', '%', $email2);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(PeopleTableMap::COL_EMAIL2, $email2, $comparison);
    }

    /**
     * Filter the query on the address column
     *
     * Example usage:
     * <code>
     * $query->filterByAddress('fooValue');   // WHERE address = 'fooValue'
     * $query->filterByAddress('%fooValue%'); // WHERE address LIKE '%fooValue%'
     * </code>
     *
     * @param     string $address The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildPeopleQuery The current query, for fluid interface
     */
    public function filterByAddress($address = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($address)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $address)) {
                $address = str_replace('*', '%', $address);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(PeopleTableMap::COL_ADDRESS, $address, $comparison);
    }

    /**
     * Filter the query on the zip column
     *
     * Example usage:
     * <code>
     * $query->filterByZip('fooValue');   // WHERE zip = 'fooValue'
     * $query->filterByZip('%fooValue%'); // WHERE zip LIKE '%fooValue%'
     * </code>
     *
     * @param     string $zip The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildPeopleQuery The current query, for fluid interface
     */
    public function filterByZip($zip = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($zip)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $zip)) {
                $zip = str_replace('*', '%', $zip);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(PeopleTableMap::COL_ZIP, $zip, $comparison);
    }

    /**
     * Filter the query on the city column
     *
     * Example usage:
     * <code>
     * $query->filterByCity('fooValue');   // WHERE city = 'fooValue'
     * $query->filterByCity('%fooValue%'); // WHERE city LIKE '%fooValue%'
     * </code>
     *
     * @param     string $city The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildPeopleQuery The current query, for fluid interface
     */
    public function filterByCity($city = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($city)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $city)) {
                $city = str_replace('*', '%', $city);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(PeopleTableMap::COL_CITY, $city, $comparison);
    }

    /**
     * Filter the query on the state column
     *
     * Example usage:
     * <code>
     * $query->filterByState('fooValue');   // WHERE state = 'fooValue'
     * $query->filterByState('%fooValue%'); // WHERE state LIKE '%fooValue%'
     * </code>
     *
     * @param     string $state The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildPeopleQuery The current query, for fluid interface
     */
    public function filterByState($state = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($state)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $state)) {
                $state = str_replace('*', '%', $state);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(PeopleTableMap::COL_STATE, $state, $comparison);
    }

    /**
     * Filter the query on the latitude column
     *
     * Example usage:
     * <code>
     * $query->filterByLatitude(1234); // WHERE latitude = 1234
     * $query->filterByLatitude(array(12, 34)); // WHERE latitude IN (12, 34)
     * $query->filterByLatitude(array('min' => 12)); // WHERE latitude > 12
     * </code>
     *
     * @param     mixed $latitude The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildPeopleQuery The current query, for fluid interface
     */
    public function filterByLatitude($latitude = null, $comparison = null)
    {
        if (is_array($latitude)) {
            $useMinMax = false;
            if (isset($latitude['min'])) {
                $this->addUsingAlias(PeopleTableMap::COL_LATITUDE, $latitude['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($latitude['max'])) {
                $this->addUsingAlias(PeopleTableMap::COL_LATITUDE, $latitude['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(PeopleTableMap::COL_LATITUDE, $latitude, $comparison);
    }

    /**
     * Filter the query on the longitude column
     *
     * Example usage:
     * <code>
     * $query->filterByLongitude(1234); // WHERE longitude = 1234
     * $query->filterByLongitude(array(12, 34)); // WHERE longitude IN (12, 34)
     * $query->filterByLongitude(array('min' => 12)); // WHERE longitude > 12
     * </code>
     *
     * @param     mixed $longitude The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildPeopleQuery The current query, for fluid interface
     */
    public function filterByLongitude($longitude = null, $comparison = null)
    {
        if (is_array($longitude)) {
            $useMinMax = false;
            if (isset($longitude['min'])) {
                $this->addUsingAlias(PeopleTableMap::COL_LONGITUDE, $longitude['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($longitude['max'])) {
                $this->addUsingAlias(PeopleTableMap::COL_LONGITUDE, $longitude['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(PeopleTableMap::COL_LONGITUDE, $longitude, $comparison);
    }

    /**
     * Filter the query on the phone column
     *
     * Example usage:
     * <code>
     * $query->filterByPhone('fooValue');   // WHERE phone = 'fooValue'
     * $query->filterByPhone('%fooValue%'); // WHERE phone LIKE '%fooValue%'
     * </code>
     *
     * @param     string $phone The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildPeopleQuery The current query, for fluid interface
     */
    public function filterByPhone($phone = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($phone)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $phone)) {
                $phone = str_replace('*', '%', $phone);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(PeopleTableMap::COL_PHONE, $phone, $comparison);
    }

    /**
     * Filter the query on the lang column
     *
     * Example usage:
     * <code>
     * $query->filterByLang('fooValue');   // WHERE lang = 'fooValue'
     * $query->filterByLang('%fooValue%'); // WHERE lang LIKE '%fooValue%'
     * </code>
     *
     * @param     string $lang The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildPeopleQuery The current query, for fluid interface
     */
    public function filterByLang($lang = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($lang)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $lang)) {
                $lang = str_replace('*', '%', $lang);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(PeopleTableMap::COL_LANG, $lang, $comparison);
    }

    /**
     * Filter the query on the mailinglist column
     *
     * Example usage:
     * <code>
     * $query->filterByMailinglist(true); // WHERE mailinglist = true
     * $query->filterByMailinglist('yes'); // WHERE mailinglist = true
     * </code>
     *
     * @param     boolean|string $mailinglist The value to use as filter.
     *              Non-boolean arguments are converted using the following rules:
     *                * 1, '1', 'true',  'on',  and 'yes' are converted to boolean true
     *                * 0, '0', 'false', 'off', and 'no'  are converted to boolean false
     *              Check on string values is case insensitive (so 'FaLsE' is seen as 'false').
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return $this|ChildPeopleQuery The current query, for fluid interface
     */
    public function filterByMailinglist($mailinglist = null, $comparison = null)
    {
        if (is_string($mailinglist)) {
            $mailinglist = in_array(strtolower($mailinglist), array('false', 'off', '-', 'no', 'n', '0', '')) ? false : true;
        }

        return $this->addUsingAlias(PeopleTableMap::COL_MAILINGLIST, $mailinglist, $comparison);
    }

    /**
     * Filter the query by a related \Customer object
     *
     * @param \Customer|ObjectCollection $customer the related object to use as filter
     * @param string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChildPeopleQuery The current query, for fluid interface
     */
    public function filterByCustomer($customer, $comparison = null)
    {
        if ($customer instanceof \Customer) {
            return $this
                ->addUsingAlias(PeopleTableMap::COL_ID, $customer->getId(), $comparison);
        } elseif ($customer instanceof ObjectCollection) {
            return $this
                ->useCustomerQuery()
                ->filterByPrimaryKeys($customer->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterByCustomer() only accepts arguments of type \Customer or Collection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the Customer relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return $this|ChildPeopleQuery The current query, for fluid interface
     */
    public function joinCustomer($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('Customer');

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
            $this->addJoinObject($join, 'Customer');
        }

        return $this;
    }

    /**
     * Use the Customer relation Customer object
     *
     * @see useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return \CustomerQuery A secondary query class using the current class as primary query
     */
    public function useCustomerQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinCustomer($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'Customer', '\CustomerQuery');
    }

    /**
     * Exclude object from result
     *
     * @param   ChildPeople $people Object to remove from the list of results
     *
     * @return $this|ChildPeopleQuery The current query, for fluid interface
     */
    public function prune($people = null)
    {
        if ($people) {
            $this->addUsingAlias(PeopleTableMap::COL_ID, $people->getId(), Criteria::NOT_EQUAL);
        }

        return $this;
    }

    /**
     * Deletes all rows from the people table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public function doDeleteAll(ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(PeopleTableMap::DATABASE_NAME);
        }

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con) {
            $affectedRows = 0; // initialize var to track total num of affected rows
            $affectedRows += parent::doDeleteAll($con);
            // Because this db requires some delete cascade/set null emulation, we have to
            // clear the cached instance *after* the emulation has happened (since
            // instances get re-added by the select statement contained therein).
            PeopleTableMap::clearInstancePool();
            PeopleTableMap::clearRelatedInstancePool();

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
            $con = Propel::getServiceContainer()->getWriteConnection(PeopleTableMap::DATABASE_NAME);
        }

        $criteria = $this;

        // Set the correct dbName
        $criteria->setDbName(PeopleTableMap::DATABASE_NAME);

        // use transaction because $criteria could contain info
        // for more than one table or we could emulating ON DELETE CASCADE, etc.
        return $con->transaction(function () use ($con, $criteria) {
            $affectedRows = 0; // initialize var to track total num of affected rows

            PeopleTableMap::removeInstanceFromPool($criteria);

            $affectedRows += ModelCriteria::delete($con);
            PeopleTableMap::clearRelatedInstancePool();

            return $affectedRows;
        });
    }

} // PeopleQuery
