<?php if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
    if(!class_exists('QLockColors')){
        /**
         *@package Lock
         *@name QLockColors
         *@author Quintet.Developers
         */
        class QLockColors{

            private $_relative_colors;
            /**
             *constructor function
             */
            public function __construct(){
                $this->_set_relative_colors();
            }

            /**
             *@name _set_relative_colors
             *function will set relative colors to the relative color variable
             *@access private
             */
            private function _set_relative_colors(){
                $this->_relative_colors = array(
                    '#008299' => $this->_get_shades('#008299'),
                    '#8C0095' => $this->_get_shades('#8C0095'),
                    '#5133AB' => $this->_get_shades('#5133AB'),
                    '#AC193D' => $this->_get_shades('#AC193D'),
                    '#D24726' => $this->_get_shades('#D24726'),
                    '#008A00' => $this->_get_shades('#008A00'),
                    '#094AB2' => $this->_get_shades('#094AB2'),
                    '#C35D15' => $this->_get_shades('#C35D15'),
                    '#57169A' => $this->_get_shades('#57169A'),
                    '#00ac62' => $this->_get_shades('#00ac62'),
                    '#00c4c3' => $this->_get_shades('#00c4c3'),
                    '#009bee' => $this->_get_shades('#009bee')
                );
            }

            /**
             *@name get_colors
             *function to get predfined colors
             *@access public
             *@return array two dimensional array with main_color and pallete
             */
            public function get_colors(){
                $colors = array();
                foreach($this->_relative_colors as $main_color => $relatives){
                    $temp = array(
                        'main_color' => $main_color,
                        'pallete'=> $relatives
                    );
                    $colors[] = $temp;
                }
                return $colors;
            }
            
            
            private function _get_shades($start_color){
                
                $return             = array();
                $end_color          = "#000000";
                $limit_of_colors    = 24;
                
                $rgb_start          = $this->_hex_to_rgb($start_color);
                $rgb_end            = $this->_hex_to_rgb($end_color);
                
                $step_R = round(($rgb_end[0] - $rgb_start[0]) / $limit_of_colors);
                $step_G = round(($rgb_end[1] - $rgb_start[1]) / $limit_of_colors);
                $step_B = round(($rgb_end[2] - $rgb_start[2]) / $limit_of_colors);
                
                $count = 0;
                for ($o = 0, $u = $limit_of_colors, $a = $rgb_start[0], $f = $rgb_start[1], $l = $rgb_start[2]; $o < $u; $o++) {
                    if($count > 17) break;
                    $count++;
                    if ($o == $u - 1) {
                        $a = $rgb_end[0];
                        $f = $rgb_end[1];
                        $l = $rgb_end[2];
                    }
                    if ($a > 255) {
                        $a = 255;
                    } else {
                        if ($a < 0) {
                            $a = 0;
                        }
                    } if ($f > 255) {
                        $f = 255;
                    } else {
                        if ($f < 0) {
                            $f = 0;
                        }
                    } if ($l > 255) {
                        $l = 255;
                    } else {
                        if ($l < 0) {
                            $l = 0;
                        }
                    }
                    $return[] = $this->_rgb_to_hex(array($a, $f, $l));
                    $a += $step_R;
                    $f += $step_G;
                    $l += $step_B;
                }
                
                return $return;
            }

            /**
             *@name _get_light_colors
             *function to retrieve light colors of a dark color
             *@access private
             *@return array
             */
            private function _get_light_colors($color_hexcode){
                return (isset($this->_relative_colors[$color_hexcode])) ? $this->_relative_colors[$color_hexcode] : array();
            }

            /**
             *@name _hex_to_rgb
             *function to retreive rgb of a hex code
             *@access private
             *@param string $hexcode hex code of a color
             *@return array will return array of r,g,b
             */
            private function _hex_to_rgb($hexcode){
                $hexcode = str_replace("#", "", $hexcode);

                if(strlen($hexcode) == 3) {
                   $r = hexdec(substr($hexcode,0,1).substr($hexcode,0,1));
                   $g = hexdec(substr($hexcode,1,1).substr($hexcode,1,1));
                   $b = hexdec(substr($hexcode,2,1).substr($hexcode,2,1));
                } else {
                   $r = hexdec(substr($hexcode,0,2));
                   $g = hexdec(substr($hexcode,2,2));
                   $b = hexdec(substr($hexcode,4,2));
                }
                return array($r, $g, $b);
            }

            /**
             *@name _rgb_to_hex
             *function to retrieve hex code of rgb
             *@access private
             *@param array $rgb an array with r,g,b
             *@return string hex code of passed rgb
             */
            private function _rgb_to_hex($rgb){
                $hex = "#";
                $hex .= str_pad(dechex($rgb[0]), 2, "0", STR_PAD_LEFT);
                $hex .= str_pad(dechex($rgb[1]), 2, "0", STR_PAD_LEFT);
                $hex .= str_pad(dechex($rgb[2]), 2, "0", STR_PAD_LEFT);

                return $hex; // returns the hex value including the number sign (#)
            }
        }
    }
