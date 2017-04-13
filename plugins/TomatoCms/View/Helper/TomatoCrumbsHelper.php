<?php
class TomatoCrumbsHelper extends AppHelper {

    private $crumbs = array();

    public function addCrumbs($name, $link = null, $options = null){
        $this->crumbs[] = array($name, $link, $options);
        return $this;
    }

    public function getCrumbs(){
        $html="<ul id=\"nav-info\" class=\"clearfix\">".'<li><a href="'.Router::url('/admin').'"><i class="icon-home"></i></a></li>';
        foreach($this->crumbs as $crumb){
            $i="";
            if(isset($crumb[2]['i'])){
                $class=($crumb[2]['i']['class']);
                $i="<i class=\"{$class}\"></i>";
            }

            $html.="<li>{$i}<a href=\"{$crumb[1]}\">&nbsp;&nbsp;{$crumb[0]}</a></li>";
        }
        return $html.="</ul>";
    }
}
?>