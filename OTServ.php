<?php

class Cache {

    /**
     * Store the cache folder path
     *
     * @var string
     */
    public static $folder;

    /**
     * Store the cache filename
     *
     * @var string
     */
    public $file;

    /**
     * Store the cache time in seconds
     *
     * @var integer
     */
    public static $seconds = 5 * 60;

    /**
     * Get the servers cache
     *
     * @return array
     */
    public function getServerInfo()
    {
        return json_decode(file_get_contents($this->getCacheFile()));
    }

    /**
     * Write to the servers cache
     *
     * @return void
     */
    public function writeServerInfo($info)
    {
        return file_put_contents($this->getCacheFile(), json_encode($info));
    }

    /**
     * Determinate if the cache file is old or not even exists
     *
     * @return boolean
     */
    public function isOld()
    {
        return ! (file_exists($this->getCacheFile()) && filemtime($this->getCacheFile()) + static::$seconds >= time());
    }

    /**
     * Retrive the cache folder path
     *
     * @return string
     */
    public function getCacheFolder()
    {
        return static::$folder;
    }

    /**
     * Retrive the cache file path
     *
     * @return string
     */
    public function getCacheFile()
    {
        return $this->file;
    }

}

class Attributes extends Cache {

    /**
     * Store the attributes
     *
     * @var array
     */
    public $attributes;

    /**
     * Store the server attributes to check for 
     *
     * @var array
     */
    public $serverAttributes = ['serverinfo', 'owner', 'players', 'monsters', 'map', 'rates', 'npcs'];

    public function value($attribute)
    {
        return (isset($attribute)) ? $attribute : null;
    }

    /**
     * Get the uptime
     *
     * @return integer|null
     */
    public function uptime()
    {
        return $this->value(@$this->attributes->serverinfo->uptime);
    }

    /**
     * Get the ip
     *
     * @return string|null
     */
    public function ip()
    {
        return $this->value(@$this->attributes->serverinfo->ip);
    }

    /**
     * Get the servername
     *
     * @return string|null
     */
    public function servername()
    {
        return $this->value(@$this->attributes->serverinfo->servername);
    }

    /**
     * Get the port
     *
     * @return integer|null
     */
    public function port()
    {
        return $this->value(@$this->attributes->serverinfo->port);
    }

    /**
     * Get the location
     *
     * @return string|null
     */
    public function location()
    {
        return $this->value(@$this->attributes->serverinfo->location);
    }

    /**
     * Get the url
     *
     * @return string|null
     */
    public function url()
    {
        return $this->value(@$this->attributes->serverinfo->url);
    }

    /**
     * Get the server
     *
     * @return string|null
     */
    public function server()
    {
        return $this->value(@$this->attributes->serverinfo->server);
    }

    /**
     * Get the version
     *
     * @return string|null
     */
    public function version()
    {
        return $this->value(@$this->attributes->serverinfo->version);
    }

    /**
     * Get the client
     *
     * @return string|null
     */
    public function client()
    {
        return $this->value(@$this->attributes->serverinfo->client);
    }

    /**
     * Get the owner name
     *
     * @return string|null
     */
    public function ownerName()
    {
        return $this->value(@$this->attributes->owner->name);
    }

    /**
     * Get the owner email
     *
     * @return string|null
     */
    public function ownerEmail()
    {
        return $this->value(@$this->attributes->owner->email);
    }

    /**
     * Get the players online
     *
     * @return integer|null
     */
    public function playersOnline()
    {
        return $this->value(@$this->attributes->players->online);
    }

    /**
     * Get the players max
     *
     * @return integer|null
     */
    public function playersMax()
    {
        return $this->value(@$this->attributes->players->max);
    }

    /**
     * Get the players peak
     *
     * @return integer|null
     */
    public function playersPeak()
    {
        return $this->value(@$this->attributes->players->peak);
    }

    /**
     * Get the monsters total
     *
     * @return integer|null
     */
    public function monstersTotal()
    {
        return $this->value(@$this->attributes->monsters->total);
    }

    /**
     * Get the map name
     *
     * @return string|null
     */
    public function mapName()
    {
        return $this->value(@$this->attributes->map->name);
    }

    /**
     * Get the map author
     *
     * @return string|null
     */
    public function mapAuthor()
    {
        return $this->value(@$this->attributes->map->author);
    }

    /**
     * Get the map width
     *
     * @return integer|null
     */
    public function mapWidth()
    {
        return $this->value(@$this->attributes->map->width);
    }

    /**
     * Get the map height
     *
     * @return integer|null
     */
    public function mapHeight()
    {
        return $this->value(@$this->attributes->map->height);
    }

    /**
     * Get the rates experience
     *
     * @return integer|null
     */
    public function ratesExperience()
    {
        return $this->value(@$this->attributes->rates->experience);
    }

    /**
     * Get the rates magic
     *
     * @return integer|null
     */
    public function ratesMagic()
    {
        return $this->value(@$this->attributes->rates->magic);
    }

    /**
     * Get the rates skill
     *
     * @return integer|null
     */
    public function ratesSkill()
    {
        return $this->value(@$this->attributes->rates->skill);
    }

    /**
     * Get the rates loot
     *
     * @return integer|null
     */
    public function ratesLoot()
    {
        return $this->value(@$this->attributes->rates->loot);
    }

    /**
     * Get the rates spawn
     *
     * @return integer|null
     */
    public function ratesSpawn()
    {
        return $this->value(@$this->attributes->rates->spawn);
    }

    /**
     * Get the moetd
     *
     * @return string|null
     */
    public function motd()
    {
        return $this->value(@$this->attributes->motd);
    }

}

class OTServ extends Attributes {

    /**
     * Store the magic message
     *
     * @var null
     */
    private static $message;

    /**
     * Create a new OTServ instance
     *
     * @return void
     */
    public function __construct($ip, $port = 7171)
    {
        $this->ip = $ip;
        $this->port = $port;

        static::$folder = __DIR__.'/cache/';
        $this->file = static::$folder."${ip}.json";
        static::$message = chr(6).chr(0).chr(255).chr(255).'info';
    }

    /**
     * Get the server info
     *
     * @return Cache
     */
    public function get()
    {
        if ($this->isOld()) {
            return $this->sendPacket();
        }

        return $this->attributes = $this->getServerInfo();
    }

    /**
     * Send a magic message to the server and store response in cache
     *
     * @return void
     */
    private function sendPacket()
    {   
        if ($socket = @fsockopen($this->ip, $this->port, $errno, $errstr, 5)) {
            $data = '';
            fwrite($socket, static::$message);
            while(!feof($socket)) {
                $data .= fread($socket, 1024);
            }
            fclose($socket);

            if (empty($data)) {
                $this->writeServerInfo($this->getServerInfo());

                return $this->attributes = $this->getServerInfo();
            }

            $this->writeServerInfo($data = $this->parseData($data));

            return $this->attributes = $this->getServerInfo();
        }

        return false;
    }

    /**
     * Parse the XML data we get from the server
     *
     * @return this
     */
    public function parseData($xml)
    {
        $array = simplexml_load_string($xml);

        foreach ($this->serverAttributes as $attribute) {
            if (isset($array->$attribute)) {
                foreach ($array->$attribute->attributes() as $index => $value) {
                    $this->attributes[$attribute][$index] = (string)$value;
                }
            }
        }

        // Determinate if the server has a motd set
        if (isset($array->motd)) {
            $this->attributes['motd'] = (string)$array->motd;
        }

        return $this->attributes;
    }

}