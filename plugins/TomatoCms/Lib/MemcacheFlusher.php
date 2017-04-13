<?PHP
class MemcacheFlusher{
    protected $server = "";
    protected $port = "";

    public function __construct($server,$port){
        $this->server = $server;
        $this->port = $port;
    }

    function flush($rule){
        $string = $this->sendMemcacheCommand("stats items");

        $lines = explode("\r\n", $string);

        $slabs = array();

        foreach($lines as $line) {
            if (preg_match("/STAT items:([\d]+):number ([\d]+)/", $line, $matches)) {

                if (isset($matches[1])) {
                    if (!in_array($matches[1], $slabs)) {
                        $slabs[] = $matches[1];

                        $string = $this->sendMemcacheCommand("stats cachedump " . $matches[1] . " " . $matches[2]);

                        preg_match_all("/ITEM (.*?) /", $string, $matches);
                        foreach($matches[1] as $idx => $key){
                            if( preg_match($rule, $key) ){
                                $ret = $this->sendMemcacheCommand("delete {$key}");
                            }
                        }
                    }
                }
            }
        }
    }

    private function sendMemcacheCommand($command){

        $s = @fsockopen($this->server,$this->port);
        if (!$s){
            return false;
        }

        fwrite($s, $command."\r\n");

        $buf='';
        while ((!feof($s))) {
            $buf .= fgets($s, 256);
            if (strpos($buf,"END\r\n")!==false){ // stat says end
                break;
            }
            if (strpos($buf,"DELETED\r\n")!==false || strpos($buf,"NOT_FOUND\r\n")!==false){ // delete says these
                break;
            }
            if (strpos($buf,"OK\r\n")!==false){ // flush_all says ok
                break;
            }
        }
        fclose($s);

        return ($buf);
    }
}