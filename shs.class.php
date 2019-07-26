<?php

require_once 'tinyHttp.class.php';

class shsObject
{
	public $baseuri = 'https://secondhandsongs.com';
	public $entityName;
	public $external_uri;
 
	public function
	__construct(int $id)
	{
		$url = $this -> baseuri . $this -> uri . '/' . $id;
		$q = new shsQuery ($url);
		$this -> map ($q -> data);
	}

	public function
	map (array $props): void
	{
		foreach ($props as $key => $value)
			$this -> $key = $value;
	}
}

class shsArtist extends shsObject
{
	public $uri = '/artist';
}

class shsPerformance extends shsObject
{
	public $uri = '/performance';
}

class shsWork extends shsObject
{
	public $uri = '/work';
}

class shsRelease extends shsObject
{
	public $uri = '/release';
}

class shsLabel extends shsObject
{
	public $uri = '/label';
}

class shsQuery
{
	var $h;
	var $data;

	public function
	__construct(string $url)
	{
		$this -> h = new tinyHttp($url);
		$this -> h -> setHeader ('Accept', 'application/json');
                $r = $this -> h ->send();

                switch ($r -> getStatus() )
                {
                case 200: // ok
                        break;
                default :       // misc errors
                        throw new Exception ('http code ' . $r -> getStatus());
                }

                $str = $r -> getBody();
                if ($str == '')
                        throw new Exception ('empty answer');

                $this -> data = json_decode ($str, true);

		switch ($this -> data['entityType'])
		{
		case 'artist' :
			break;
		default :
			throw new Exception ('Unknown entityType');
		}
	}
}


?>
