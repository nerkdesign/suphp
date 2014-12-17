<?php
class ServerPing {
    private $output=array();
    private $avg=0;
    private $min=0;
    private $max=0;
    public function send($server, $repeat) {
        if ($repeat==0) {
            throw new Exception("repeat cant be 0 !!!");
        }
        $cmd='ping -c '.$repeat.' '.$server;
        exec($cmd, $this->output);
        if (count($this->output)>2) {
            $toparse=$this->output[count($this->output)-1];
            if (strpos($toparse, 'rtt min/avg/max/mdev =')!==false) {
                $str=trim(substr($toparse, 23));
                $vals=explode("/",$str);

                if (count($vals)>=4) {
                    $this->min=$vals[0];
                    $this->max=$vals[2];
                    $this->avg=$vals[1];
                }
            }
        }
    }
    public function getOutput() {
        return implode("\\n", $this->output);
    }
    public function isAlive() {
        if ($this->avg==0) {
            return false;
        }  else {
            return true;
        }
    }
    public function getMin() {
        return $this->min;
    }
    public function getMax() {
        return $this->max;
    }
    public function getAverage() {
        return $this->avg;
    }
}
?>
