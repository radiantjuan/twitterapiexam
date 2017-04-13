<?PHP
App::uses('View', 'View');
class TomatoCmsView extends View {
    public function renderCacheFromString($path, $out, $timeStart) {
        $response = $this->response;

        $tmpName = tempnam( sys_get_temp_dir() , 'cache_view_'.md5($path) . '.php' );
        $fp = fopen($tmpName, 'a+');
        if(!$fp){
            return false;
        }
        ftruncate($fp, 0);
        fwrite($fp, $out);
        fclose($fp);

        ob_start();
        require_once $tmpName;

        @unlink($tmpName);

        $type = $response->mapType($response->type());
        if (Configure::read('debug') > 0 && $type === 'html') {
            echo "<!-- Cached Render Time: " . round(microtime(true) - $timeStart, 4) . "s -->";
        }
        $out = ob_get_clean();

        if (preg_match('/^<!--cachetime:(\\d+)-->/', $out, $match)) {
            if (time() >= $match['1']) {
                return false;
            } else {
                if ($this->layout === 'xml') {
                    header('Content-type: text/xml');
                }
                return substr($out, strlen($match[0]));
            }
        }
    }
}
