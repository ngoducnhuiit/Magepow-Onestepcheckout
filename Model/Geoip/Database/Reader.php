<?php
namespace Magepow\OnestepCheckout\Model\Geoip\Database;

use Magepow\OnestepCheckout\Model\Geoip\Maxmind\Db\Reader as DbReader;
use Magepow\OnestepCheckout\Model\Geoip\ProviderInterface;

class Reader implements ProviderInterface
{
    /**
     * @type \Magepow\OnestepCheckout\Model\Geoip\Maxmind\Db\Reader
     */
    private $_dbReader;

    /**
     * @type array
     */
    private $locales;


    /**
     * @param \Magepow\OnestepCheckout\Model\Geoip\Maxmind\Db\Reader $dbreader
     */
    public function __construct(
        DbReader $dbreader
    )
    {
        $this->_dbReader = $dbreader;
        $this->locales   = array('en');
    }

    /**
     * This method returns a GeoIP2 City model.
     * @param string $ipAddress IPv4 or IPv6 address as a string.
     * @return array
     */
    public function city($ipAddress)
    {
        return $this->modelFor('City', 'City', $ipAddress);
    }

    /**
     * This method returns a GeoIP2 Country model.
     * @param string $ipAddress IPv4 or IPv6 address as a string.
     * @return array
     */
    public function country($ipAddress)
    {
        return $this->modelFor('Country', 'Country', $ipAddress);
    }


    /**
     * @param $class
     * @param $type
     * @param $ipAddress
     * @return array
     */
    private function modelFor($class, $type, $ipAddress)
    {
        $record = $this->getRecord($class, $type, $ipAddress);

        $record['traits']['ip_address'] = $ipAddress;
        $this->close();

        return $record;
    }

    /**
     * @param $class
     * @param $type
     * @param $ipAddress
     * @return array
     * @throws \Exception
     */
    private function getRecord($class, $type, $ipAddress)
    {
        if (strpos($this->metadata()->databaseType, $type) === false) {
            $method = lcfirst($class);
            throw new \Exception(
                "The $method method cannot be used to open a "
                . $this->metadata()->databaseType . " database"
            );
        }
        $record = $this->_dbReader->get($ipAddress);
        if ($record === null) {
            throw new \Exception(
                "The address $ipAddress is not in the database."
            );
        }
        if (!is_array($record)) {
            // This can happen on corrupt databases. Generally,
            // MaxMind\Db\Reader will throw a
            // MaxMind\Db\Reader\InvalidDatabaseException, but occasionally
            // the lookup may result in a record that looks valid but is not
            // an array. This mostly happens when the user is ignoring all
            // exceptions and the more frequent InvalidDatabaseException
            // exceptions go unnoticed.
            throw new \Exception(
                "Expected an array when looking up $ipAddress but received: "
                . gettype($record)
            );
        }

        return $record;
    }

    /**
     * @throws \InvalidArgumentException if arguments are passed to the method.
     * @throws \BadMethodCallException if the database has been closed.
     * @return \Magepow\OnestepCheckout\Model\Geoip\Maxmind\Db\Reader\Metadata object for the database.
     */
    public function metadata()
    {
        return $this->_dbReader->metadata();
    }

    /**
     * Closes the GeoIP2 database and returns the resources to the system.
     */
    public function close()
    {
        $this->_dbReader->close();
    }
}
