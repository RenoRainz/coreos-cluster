<?php

namespace Map;

use \People;
use \PeopleQuery;
use Propel\Runtime\Propel;
use Propel\Runtime\ActiveQuery\Criteria;
use Propel\Runtime\ActiveQuery\InstancePoolTrait;
use Propel\Runtime\Connection\ConnectionInterface;
use Propel\Runtime\DataFetcher\DataFetcherInterface;
use Propel\Runtime\Exception\PropelException;
use Propel\Runtime\Map\RelationMap;
use Propel\Runtime\Map\TableMap;
use Propel\Runtime\Map\TableMapTrait;


/**
 * This class defines the structure of the 'people' table.
 *
 *
 *
 * This map class is used by Propel to do runtime db structure discovery.
 * For example, the createSelectSql() method checks the type of a given column used in an
 * ORDER BY clause to know whether it needs to apply SQL to make the ORDER BY case-insensitive
 * (i.e. if it's a text column type).
 *
 */
class PeopleTableMap extends TableMap
{
    use InstancePoolTrait;
    use TableMapTrait;

    /**
     * The (dot-path) name of this class
     */
    const CLASS_NAME = '.Map.PeopleTableMap';

    /**
     * The default database name for this class
     */
    const DATABASE_NAME = 'pfw';

    /**
     * The table name for this class
     */
    const TABLE_NAME = 'people';

    /**
     * The related Propel class for this table
     */
    const OM_CLASS = '\\People';

    /**
     * A class that can be returned by this tableMap
     */
    const CLASS_DEFAULT = 'People';

    /**
     * The total number of columns
     */
    const NUM_COLUMNS = 16;

    /**
     * The number of lazy-loaded columns
     */
    const NUM_LAZY_LOAD_COLUMNS = 0;

    /**
     * The number of columns to hydrate (NUM_COLUMNS - NUM_LAZY_LOAD_COLUMNS)
     */
    const NUM_HYDRATE_COLUMNS = 16;

    /**
     * the column name for the id field
     */
    const COL_ID = 'people.id';

    /**
     * the column name for the cUserId field
     */
    const COL_CUSERID = 'people.cUserId';

    /**
     * the column name for the mUserId field
     */
    const COL_MUSERID = 'people.mUserId';

    /**
     * the column name for the title field
     */
    const COL_TITLE = 'people.title';

    /**
     * the column name for the lastName field
     */
    const COL_LASTNAME = 'people.lastName';

    /**
     * the column name for the firstName field
     */
    const COL_FIRSTNAME = 'people.firstName';

    /**
     * the column name for the email field
     */
    const COL_EMAIL = 'people.email';

    /**
     * the column name for the address field
     */
    const COL_ADDRESS = 'people.address';

    /**
     * the column name for the zipCode field
     */
    const COL_ZIPCODE = 'people.zipCode';

    /**
     * the column name for the city field
     */
    const COL_CITY = 'people.city';

    /**
     * the column name for the state field
     */
    const COL_STATE = 'people.state';

    /**
     * the column name for the latitude field
     */
    const COL_LATITUDE = 'people.latitude';

    /**
     * the column name for the longitude field
     */
    const COL_LONGITUDE = 'people.longitude';

    /**
     * the column name for the phone field
     */
    const COL_PHONE = 'people.phone';

    /**
     * the column name for the lang field
     */
    const COL_LANG = 'people.lang';

    /**
     * the column name for the mailingList field
     */
    const COL_MAILINGLIST = 'people.mailingList';

    /**
     * The default string format for model objects of the related table
     */
    const DEFAULT_STRING_FORMAT = 'YAML';

    /**
     * holds an array of fieldnames
     *
     * first dimension keys are the type constants
     * e.g. self::$fieldNames[self::TYPE_PHPNAME][0] = 'Id'
     */
    protected static $fieldNames = array (
        self::TYPE_PHPNAME       => array('Id', 'Cuserid', 'Muserid', 'Title', 'Lastname', 'Firstname', 'Email', 'Address', 'Zipcode', 'City', 'State', 'Latitude', 'Longitude', 'Phone', 'Lang', 'Mailinglist', ),
        self::TYPE_CAMELNAME     => array('id', 'cuserid', 'muserid', 'title', 'lastname', 'firstname', 'email', 'address', 'zipcode', 'city', 'state', 'latitude', 'longitude', 'phone', 'lang', 'mailinglist', ),
        self::TYPE_COLNAME       => array(PeopleTableMap::COL_ID, PeopleTableMap::COL_CUSERID, PeopleTableMap::COL_MUSERID, PeopleTableMap::COL_TITLE, PeopleTableMap::COL_LASTNAME, PeopleTableMap::COL_FIRSTNAME, PeopleTableMap::COL_EMAIL, PeopleTableMap::COL_ADDRESS, PeopleTableMap::COL_ZIPCODE, PeopleTableMap::COL_CITY, PeopleTableMap::COL_STATE, PeopleTableMap::COL_LATITUDE, PeopleTableMap::COL_LONGITUDE, PeopleTableMap::COL_PHONE, PeopleTableMap::COL_LANG, PeopleTableMap::COL_MAILINGLIST, ),
        self::TYPE_FIELDNAME     => array('id', 'cUserId', 'mUserId', 'title', 'lastName', 'firstName', 'email', 'address', 'zipCode', 'city', 'state', 'latitude', 'longitude', 'phone', 'lang', 'mailingList', ),
        self::TYPE_NUM           => array(0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, )
    );

    /**
     * holds an array of keys for quick access to the fieldnames array
     *
     * first dimension keys are the type constants
     * e.g. self::$fieldKeys[self::TYPE_PHPNAME]['Id'] = 0
     */
    protected static $fieldKeys = array (
        self::TYPE_PHPNAME       => array('Id' => 0, 'Cuserid' => 1, 'Muserid' => 2, 'Title' => 3, 'Lastname' => 4, 'Firstname' => 5, 'Email' => 6, 'Address' => 7, 'Zipcode' => 8, 'City' => 9, 'State' => 10, 'Latitude' => 11, 'Longitude' => 12, 'Phone' => 13, 'Lang' => 14, 'Mailinglist' => 15, ),
        self::TYPE_CAMELNAME     => array('id' => 0, 'cuserid' => 1, 'muserid' => 2, 'title' => 3, 'lastname' => 4, 'firstname' => 5, 'email' => 6, 'address' => 7, 'zipcode' => 8, 'city' => 9, 'state' => 10, 'latitude' => 11, 'longitude' => 12, 'phone' => 13, 'lang' => 14, 'mailinglist' => 15, ),
        self::TYPE_COLNAME       => array(PeopleTableMap::COL_ID => 0, PeopleTableMap::COL_CUSERID => 1, PeopleTableMap::COL_MUSERID => 2, PeopleTableMap::COL_TITLE => 3, PeopleTableMap::COL_LASTNAME => 4, PeopleTableMap::COL_FIRSTNAME => 5, PeopleTableMap::COL_EMAIL => 6, PeopleTableMap::COL_ADDRESS => 7, PeopleTableMap::COL_ZIPCODE => 8, PeopleTableMap::COL_CITY => 9, PeopleTableMap::COL_STATE => 10, PeopleTableMap::COL_LATITUDE => 11, PeopleTableMap::COL_LONGITUDE => 12, PeopleTableMap::COL_PHONE => 13, PeopleTableMap::COL_LANG => 14, PeopleTableMap::COL_MAILINGLIST => 15, ),
        self::TYPE_FIELDNAME     => array('id' => 0, 'cUserId' => 1, 'mUserId' => 2, 'title' => 3, 'lastName' => 4, 'firstName' => 5, 'email' => 6, 'address' => 7, 'zipCode' => 8, 'city' => 9, 'state' => 10, 'latitude' => 11, 'longitude' => 12, 'phone' => 13, 'lang' => 14, 'mailingList' => 15, ),
        self::TYPE_NUM           => array(0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, )
    );

    /**
     * Initialize the table attributes and columns
     * Relations are not initialized by this method since they are lazy loaded
     *
     * @return void
     * @throws PropelException
     */
    public function initialize()
    {
        // attributes
        $this->setName('people');
        $this->setPhpName('People');
        $this->setIdentifierQuoting(false);
        $this->setClassName('\\People');
        $this->setPackage('');
        $this->setUseIdGenerator(true);
        // columns
        $this->addPrimaryKey('id', 'Id', 'INTEGER', true, null, null);
        $this->addColumn('cUserId', 'Cuserid', 'INTEGER', false, null, null);
        $this->addColumn('mUserId', 'Muserid', 'INTEGER', false, null, null);
        $this->addColumn('title', 'Title', 'VARCHAR', false, 4, null);
        $this->addColumn('lastName', 'Lastname', 'VARCHAR', false, 100, null);
        $this->addColumn('firstName', 'Firstname', 'VARCHAR', false, 100, null);
        $this->addColumn('email', 'Email', 'VARCHAR', false, 255, null);
        $this->addColumn('address', 'Address', 'VARCHAR', false, 400, null);
        $this->addColumn('zipCode', 'Zipcode', 'VARCHAR', false, 5, null);
        $this->addColumn('city', 'City', 'VARCHAR', false, 200, null);
        $this->addColumn('state', 'State', 'VARCHAR', false, 100, null);
        $this->addColumn('latitude', 'Latitude', 'FLOAT', false, null, null);
        $this->addColumn('longitude', 'Longitude', 'FLOAT', false, null, null);
        $this->addColumn('phone', 'Phone', 'VARCHAR', false, 10, null);
        $this->addColumn('lang', 'Lang', 'VARCHAR', false, 6, null);
        $this->addColumn('mailingList', 'Mailinglist', 'BOOLEAN', false, 1, null);
    } // initialize()

    /**
     * Build the RelationMap objects for this table relationships
     */
    public function buildRelations()
    {
        $this->addRelation('User', '\\User', RelationMap::ONE_TO_ONE, array('id' => 'id', ), 'CASCADE', null);
    } // buildRelations()
    /**
     * Method to invalidate the instance pool of all tables related to people     * by a foreign key with ON DELETE CASCADE
     */
    public static function clearRelatedInstancePool()
    {
        // Invalidate objects in related instance pools,
        // since one or more of them may be deleted by ON DELETE CASCADE/SETNULL rule.
        UserTableMap::clearInstancePool();
    }

    /**
     * Retrieves a string version of the primary key from the DB resultset row that can be used to uniquely identify a row in this table.
     *
     * For tables with a single-column primary key, that simple pkey value will be returned.  For tables with
     * a multi-column primary key, a serialize()d version of the primary key will be returned.
     *
     * @param array  $row       resultset row.
     * @param int    $offset    The 0-based offset for reading from the resultset row.
     * @param string $indexType One of the class type constants TableMap::TYPE_PHPNAME, TableMap::TYPE_CAMELNAME
     *                           TableMap::TYPE_COLNAME, TableMap::TYPE_FIELDNAME, TableMap::TYPE_NUM
     *
     * @return string The primary key hash of the row
     */
    public static function getPrimaryKeyHashFromRow($row, $offset = 0, $indexType = TableMap::TYPE_NUM)
    {
        // If the PK cannot be derived from the row, return NULL.
        if ($row[TableMap::TYPE_NUM == $indexType ? 0 + $offset : static::translateFieldName('Id', TableMap::TYPE_PHPNAME, $indexType)] === null) {
            return null;
        }

        return (string) $row[TableMap::TYPE_NUM == $indexType ? 0 + $offset : static::translateFieldName('Id', TableMap::TYPE_PHPNAME, $indexType)];
    }

    /**
     * Retrieves the primary key from the DB resultset row
     * For tables with a single-column primary key, that simple pkey value will be returned.  For tables with
     * a multi-column primary key, an array of the primary key columns will be returned.
     *
     * @param array  $row       resultset row.
     * @param int    $offset    The 0-based offset for reading from the resultset row.
     * @param string $indexType One of the class type constants TableMap::TYPE_PHPNAME, TableMap::TYPE_CAMELNAME
     *                           TableMap::TYPE_COLNAME, TableMap::TYPE_FIELDNAME, TableMap::TYPE_NUM
     *
     * @return mixed The primary key of the row
     */
    public static function getPrimaryKeyFromRow($row, $offset = 0, $indexType = TableMap::TYPE_NUM)
    {
        return (int) $row[
            $indexType == TableMap::TYPE_NUM
                ? 0 + $offset
                : self::translateFieldName('Id', TableMap::TYPE_PHPNAME, $indexType)
        ];
    }

    /**
     * The class that the tableMap will make instances of.
     *
     * If $withPrefix is true, the returned path
     * uses a dot-path notation which is translated into a path
     * relative to a location on the PHP include_path.
     * (e.g. path.to.MyClass -> 'path/to/MyClass.php')
     *
     * @param boolean $withPrefix Whether or not to return the path with the class name
     * @return string path.to.ClassName
     */
    public static function getOMClass($withPrefix = true)
    {
        return $withPrefix ? PeopleTableMap::CLASS_DEFAULT : PeopleTableMap::OM_CLASS;
    }

    /**
     * Populates an object of the default type or an object that inherit from the default.
     *
     * @param array  $row       row returned by DataFetcher->fetch().
     * @param int    $offset    The 0-based offset for reading from the resultset row.
     * @param string $indexType The index type of $row. Mostly DataFetcher->getIndexType().
                                 One of the class type constants TableMap::TYPE_PHPNAME, TableMap::TYPE_CAMELNAME
     *                           TableMap::TYPE_COLNAME, TableMap::TYPE_FIELDNAME, TableMap::TYPE_NUM.
     *
     * @throws PropelException Any exceptions caught during processing will be
     *                         rethrown wrapped into a PropelException.
     * @return array           (People object, last column rank)
     */
    public static function populateObject($row, $offset = 0, $indexType = TableMap::TYPE_NUM)
    {
        $key = PeopleTableMap::getPrimaryKeyHashFromRow($row, $offset, $indexType);
        if (null !== ($obj = PeopleTableMap::getInstanceFromPool($key))) {
            // We no longer rehydrate the object, since this can cause data loss.
            // See http://www.propelorm.org/ticket/509
            // $obj->hydrate($row, $offset, true); // rehydrate
            $col = $offset + PeopleTableMap::NUM_HYDRATE_COLUMNS;
        } else {
            $cls = PeopleTableMap::OM_CLASS;
            /** @var People $obj */
            $obj = new $cls();
            $col = $obj->hydrate($row, $offset, false, $indexType);
            PeopleTableMap::addInstanceToPool($obj, $key);
        }

        return array($obj, $col);
    }

    /**
     * The returned array will contain objects of the default type or
     * objects that inherit from the default.
     *
     * @param DataFetcherInterface $dataFetcher
     * @return array
     * @throws PropelException Any exceptions caught during processing will be
     *                         rethrown wrapped into a PropelException.
     */
    public static function populateObjects(DataFetcherInterface $dataFetcher)
    {
        $results = array();

        // set the class once to avoid overhead in the loop
        $cls = static::getOMClass(false);
        // populate the object(s)
        while ($row = $dataFetcher->fetch()) {
            $key = PeopleTableMap::getPrimaryKeyHashFromRow($row, 0, $dataFetcher->getIndexType());
            if (null !== ($obj = PeopleTableMap::getInstanceFromPool($key))) {
                // We no longer rehydrate the object, since this can cause data loss.
                // See http://www.propelorm.org/ticket/509
                // $obj->hydrate($row, 0, true); // rehydrate
                $results[] = $obj;
            } else {
                /** @var People $obj */
                $obj = new $cls();
                $obj->hydrate($row);
                $results[] = $obj;
                PeopleTableMap::addInstanceToPool($obj, $key);
            } // if key exists
        }

        return $results;
    }
    /**
     * Add all the columns needed to create a new object.
     *
     * Note: any columns that were marked with lazyLoad="true" in the
     * XML schema will not be added to the select list and only loaded
     * on demand.
     *
     * @param Criteria $criteria object containing the columns to add.
     * @param string   $alias    optional table alias
     * @throws PropelException Any exceptions caught during processing will be
     *                         rethrown wrapped into a PropelException.
     */
    public static function addSelectColumns(Criteria $criteria, $alias = null)
    {
        if (null === $alias) {
            $criteria->addSelectColumn(PeopleTableMap::COL_ID);
            $criteria->addSelectColumn(PeopleTableMap::COL_CUSERID);
            $criteria->addSelectColumn(PeopleTableMap::COL_MUSERID);
            $criteria->addSelectColumn(PeopleTableMap::COL_TITLE);
            $criteria->addSelectColumn(PeopleTableMap::COL_LASTNAME);
            $criteria->addSelectColumn(PeopleTableMap::COL_FIRSTNAME);
            $criteria->addSelectColumn(PeopleTableMap::COL_EMAIL);
            $criteria->addSelectColumn(PeopleTableMap::COL_ADDRESS);
            $criteria->addSelectColumn(PeopleTableMap::COL_ZIPCODE);
            $criteria->addSelectColumn(PeopleTableMap::COL_CITY);
            $criteria->addSelectColumn(PeopleTableMap::COL_STATE);
            $criteria->addSelectColumn(PeopleTableMap::COL_LATITUDE);
            $criteria->addSelectColumn(PeopleTableMap::COL_LONGITUDE);
            $criteria->addSelectColumn(PeopleTableMap::COL_PHONE);
            $criteria->addSelectColumn(PeopleTableMap::COL_LANG);
            $criteria->addSelectColumn(PeopleTableMap::COL_MAILINGLIST);
        } else {
            $criteria->addSelectColumn($alias . '.id');
            $criteria->addSelectColumn($alias . '.cUserId');
            $criteria->addSelectColumn($alias . '.mUserId');
            $criteria->addSelectColumn($alias . '.title');
            $criteria->addSelectColumn($alias . '.lastName');
            $criteria->addSelectColumn($alias . '.firstName');
            $criteria->addSelectColumn($alias . '.email');
            $criteria->addSelectColumn($alias . '.address');
            $criteria->addSelectColumn($alias . '.zipCode');
            $criteria->addSelectColumn($alias . '.city');
            $criteria->addSelectColumn($alias . '.state');
            $criteria->addSelectColumn($alias . '.latitude');
            $criteria->addSelectColumn($alias . '.longitude');
            $criteria->addSelectColumn($alias . '.phone');
            $criteria->addSelectColumn($alias . '.lang');
            $criteria->addSelectColumn($alias . '.mailingList');
        }
    }

    /**
     * Returns the TableMap related to this object.
     * This method is not needed for general use but a specific application could have a need.
     * @return TableMap
     * @throws PropelException Any exceptions caught during processing will be
     *                         rethrown wrapped into a PropelException.
     */
    public static function getTableMap()
    {
        return Propel::getServiceContainer()->getDatabaseMap(PeopleTableMap::DATABASE_NAME)->getTable(PeopleTableMap::TABLE_NAME);
    }

    /**
     * Add a TableMap instance to the database for this tableMap class.
     */
    public static function buildTableMap()
    {
        $dbMap = Propel::getServiceContainer()->getDatabaseMap(PeopleTableMap::DATABASE_NAME);
        if (!$dbMap->hasTable(PeopleTableMap::TABLE_NAME)) {
            $dbMap->addTableObject(new PeopleTableMap());
        }
    }

    /**
     * Performs a DELETE on the database, given a People or Criteria object OR a primary key value.
     *
     * @param mixed               $values Criteria or People object or primary key or array of primary keys
     *              which is used to create the DELETE statement
     * @param  ConnectionInterface $con the connection to use
     * @return int             The number of affected rows (if supported by underlying database driver).  This includes CASCADE-related rows
     *                         if supported by native driver or if emulated using Propel.
     * @throws PropelException Any exceptions caught during processing will be
     *                         rethrown wrapped into a PropelException.
     */
     public static function doDelete($values, ConnectionInterface $con = null)
     {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(PeopleTableMap::DATABASE_NAME);
        }

        if ($values instanceof Criteria) {
            // rename for clarity
            $criteria = $values;
        } elseif ($values instanceof \People) { // it's a model object
            // create criteria based on pk values
            $criteria = $values->buildPkeyCriteria();
        } else { // it's a primary key, or an array of pks
            $criteria = new Criteria(PeopleTableMap::DATABASE_NAME);
            $criteria->add(PeopleTableMap::COL_ID, (array) $values, Criteria::IN);
        }

        $query = PeopleQuery::create()->mergeWith($criteria);

        if ($values instanceof Criteria) {
            PeopleTableMap::clearInstancePool();
        } elseif (!is_object($values)) { // it's a primary key, or an array of pks
            foreach ((array) $values as $singleval) {
                PeopleTableMap::removeInstanceFromPool($singleval);
            }
        }

        return $query->delete($con);
    }

    /**
     * Deletes all rows from the people table.
     *
     * @param ConnectionInterface $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).
     */
    public static function doDeleteAll(ConnectionInterface $con = null)
    {
        return PeopleQuery::create()->doDeleteAll($con);
    }

    /**
     * Performs an INSERT on the database, given a People or Criteria object.
     *
     * @param mixed               $criteria Criteria or People object containing data that is used to create the INSERT statement.
     * @param ConnectionInterface $con the ConnectionInterface connection to use
     * @return mixed           The new primary key.
     * @throws PropelException Any exceptions caught during processing will be
     *                         rethrown wrapped into a PropelException.
     */
    public static function doInsert($criteria, ConnectionInterface $con = null)
    {
        if (null === $con) {
            $con = Propel::getServiceContainer()->getWriteConnection(PeopleTableMap::DATABASE_NAME);
        }

        if ($criteria instanceof Criteria) {
            $criteria = clone $criteria; // rename for clarity
        } else {
            $criteria = $criteria->buildCriteria(); // build Criteria from People object
        }

        if ($criteria->containsKey(PeopleTableMap::COL_ID) && $criteria->keyContainsValue(PeopleTableMap::COL_ID) ) {
            throw new PropelException('Cannot insert a value for auto-increment primary key ('.PeopleTableMap::COL_ID.')');
        }


        // Set the correct dbName
        $query = PeopleQuery::create()->mergeWith($criteria);

        // use transaction because $criteria could contain info
        // for more than one table (I guess, conceivably)
        return $con->transaction(function () use ($con, $query) {
            return $query->doInsert($con);
        });
    }

} // PeopleTableMap
// This is the static code needed to register the TableMap for this table with the main Propel class.
//
PeopleTableMap::buildTableMap();
