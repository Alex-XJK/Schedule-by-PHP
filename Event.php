<?php
    class Event {
        private $timestamp;
        private $code;
        private $name;
        private $type;
        private $msgEN;
        private $msgCH;

        public static $color = array(
            "free"          =>  "#F6F5EE;",
            "class"         =>  "#8DB4E2;",
            "holiday"       =>  "#D8E4BC;",
            "activities"    =>  "#FABF8F;",
            "lecture"       =>  "#B1A0C7;",
            "discussion"    =>  "#B7DEE8;",
            "exam"          =>  "#DA9694;",
            "other"         =>  "#C4BD97;",
            "subother"      =>  "#c2c2c2;",
            "placement"     =>  "#e5bbf8;"
        );

        public function __construct($D, $T, $C, $N, $P, $M=NULL) {
            $this->timestamp = ($D*24)+$T;
            $this->code = $C;
            $this->name = $N;
            $this->type = $P;
            if($M!=NULL) {
                $this->msgEN = $M["EN"];
                $this->msgCH = $M["CH"];
            }
        }

        public function display($id) {
            if(!empty($this->msgEN) || !empty($this->msgCH)) {
                $mouseHover = "ddrivetip('".$this->msgEN."<br>".$this->msgCH."','yellow', 300)";
                $innerHTML = "<td id=\"c$id\" class=\"$this->type\" style=\"background: ".Event::$color[$this->type]."\" onMouseover=\"$mouseHover\" onMouseout=\"hideddrivetip()\">$this->code <br> $this->name</td>";
            }
            else {
                $innerHTML = "<td id=\"c$id\" class=\"$this->type\" style=\"background: ".Event::$color[$this->type]."\">$this->code <br> $this->name</td>";
            }
            return $innerHTML;
        }

        public function getnum() {
            return $this->timestamp;
        }
    }
?>
