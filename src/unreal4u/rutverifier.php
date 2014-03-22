<?php
/**
 * Main class that defines the rutverifier class
 *
 * @author unreal4u
 * @link https://github.com/unreal4u/rutverifier
 */

namespace unreal4u;

/**
 * Chilean RUT or RUN verifier
 *
 * <p>A chilean RUT/RUN is any number between 1.000.000 and 99.999.999, where the first 50 million are reserved for
 * normal persons (RUN - Rol único nacional), and the last 50 millions are reserved for enterprise usage (RUT - Rol
 * único tributario). This number has also a basic verifier that is the last digit in the following secuence:<br />
 * 12.345.678-9<br />
 * So, the above example corresponds to a natural person, with run number 12.345.678 and verifier 9.</p>
 *
 * <p>This class can be used to check whether a RUT or RUN is a valid one, filtering some common invalid RUTs/RUNs out
 * and with the option to add more to this blacklist. Additionally, it is also capable of delivering a basic JavaScript
 * version which will return true or false depending on the RUT/RUN being valid or not. However, this JavaScript version
 * does not check blacklist and other more advanced stuff.</p>
 *
 * @author Camilo Sperberg
 * @copyright 2010 - 2013 Camilo Sperberg
 * @version 2.2.1
 * @license BSD License
 * @package rutverifier
 */
class rutverifier extends javascriptLoader {

    /**
     * The version of this class
     * @var string
     */
    private $classVersion = '2.2.1';

    /**
     * Stores errors of the class
     * @var array
     */
    public $errors = array();

    /**
     * Indicates whether we have errors or not
     * @var boolean
     */
    private $error = false;

    /**
     * Blacklist of all those invalid RUTs
     * @var array
     */
    private $blacklist = array(
        '111111111',
        '222222222',
        '333333333',
        '444444444',
        '555555555',
        '666666666',
        '777777777',
        '888888888',
        '999999999',
    );

    /**
     * Prints version information of this class
     * @return string
     */
    public function __toString() {
        return basename(__FILE__).' v'.$this->classVersion.' by Camilo Sperberg - http://unreal4u.com/';
    }

    /**
     * This function logs all errors the object generates
     *
     * @param int $type Type of error
     * @param string $msg Error message
     * @return boolean Returns always true
     */
    private function _logError($type, $msg='') {
        if (!empty($type)) {
            $typeString = '';
            switch ($type) {
                case 1:
                    $typeString = 'ERR';
                    $this->error = true;
                break;
                case 2:
                    $typeString = 'WAR';
                break;
            }

            $this->errors[] = array(
                'type' => $typeString,
                'msg' => $msg,
            );
        }

        return true;
    }

    /**
     * Allows to add some RUT/RUNs to the blacklist in runtime
     *
     * @param mixed $add List of blacklisted RUT, as an array or a string
     * @return int Returns the number of entries in the blacklist
     */
    public function addToBlacklist($add) {
        if (!empty($add)) {
            if (!is_array($add)) {
                $add = array($add);
            }
            foreach ($add AS $a) {
                $this->blacklist[] = $a;
            }
        }

        return count($this->blacklist);
    }

    /**
     * Returns the RUT type: whether it is a person or a juridic entity (companies)
     *
     * This class will return the information in spanish: "empresa" means company, "natural" means regular person. These
     * names are the correct ones to refer to in Chili.
     * Important: This function doesn't verify that the RUT/RUN is valid! For that, check $this->isValidRUT
     * @see $this->isValidRUT()
     *
     * @param string $rut The RUT for which we want to know
     * @return array Returns empty array in case of invalid RUT, filled in array with data otherwise
     */
    public function RUTType($rut='') {
        $output = array();
        if (!empty($rut) && is_string($rut)) {
            $rut = $this->formatRUT($rut);
            if (!empty($rut)) {
                $rut = substr($rut, 0, -1);
                $output = array(
                    'n',
                    'natural',
                );
                if ($rut < 100000000 && $rut > 50000000) {
                    $output = array(
                        'e',
                        'empresa',
                    );
                }
            }
        }

        return $output;
    }

    /**
     * Applies a filter to the RUT/RUN and formats it for internal class usage
     *
     * @param string $rut The RUT/RUN we want to format
     * @param boolean $withVerifier Whether we want to print the verifier also. Defaults to true
     * @return string Returns empty string when RUT/RUN is invalid or a non-empty string with the RUT/RUN otherwise
     */
    public function formatRUT($rut='', $withVerifier=true) {
        $output = '';
        if (!empty($rut)) {
            $tmpRUT = preg_replace('/[^0-9K]/i', '', $rut);

            if (strlen($tmpRUT) > 7) {
                $output = str_pad(str_replace('k', 'K', $tmpRUT), 9, '0', STR_PAD_LEFT);
            }

            if (strlen($output) !== 9) {
                $this->_logError(1, sprintf('RUT/RUN doesn\'t have the required size'));
            } elseif ($withVerifier === false) {
                $output = substr($output, 0, -1);
            }
        }

        return $output;
    }

    /**
     * Calculates the verifier for a given RUT/RUN which must be provided without verifier
     *
     * @param string $rut RUT/RUN without verifier
     * @return string Returns empty string RUT/RUN is empty, or the verifier otherwise
     */
    public function getVerifier($rut='') {
        $return = '';
        if (!empty($rut) && is_string($rut)) {
            $multi = 2;
            $sum = 0;
            $strlenRut = strlen($rut);
            for ($i = $strlenRut - 1; $i >= 0; $i--) {
                $sum += ($rut[$i] * $multi);
                $multi++;
                if ($multi == $strlenRut) {
                    $multi = 2;
                }
            }

            $return = (string)(11 - ($sum % 11));
            if ($sum % 11 < 2) {
                $return = str_replace(array(0, 1), array('0', 'K'), $sum % 11);
            }
        }

        return $return;
    }

    /**
     * This function will check whether the RUT/RUN is effectively valid or not
     *
     * @param string $rut RUT/RUN that will be checked
     * @param boolean $extensiveCheck Whether to also check on blacklist. Defaults to true
     * @param boolean $returnBoolean Whether to return true or false or array with data
     * @return mixed Returns boolean true if RUT/RUN is valid, false otherwise. Returns array with data if selected so
     */
    public function isValidRUT($rut, $extensiveCheck=true, $returnBoolean=true) {
        $isValid = false;
        $output = false;

        if (!empty($rut)) {
            $rut = $this->formatRUT($rut, true);
            $sep = array(
                'rut' => substr($rut, 0, -1),
                'dv'  => substr($rut, -1),
            );
            $rutType = $this->RUTType($rut);

            if ($rutType !== array()) {
                $isValid = true;
                if ($this->getVerifier($sep['rut']) != $sep['dv']) {
                    $this->_logError(2, sprintf('RUT/RUN (%s) and verifier (%s) don\'t match', $sep['rut'], $sep['dv']));
                    $isValid = false;
                }

                if ($isValid === true && $extensiveCheck === true) {
                    if (in_array($sep['rut'] . $sep['dv'], $this->blacklist)) {
                        $isValid = false;
                        $this->_logError(2, sprintf('The entered RUT/RUN "%s%s" is in blacklist', $sep['rut'], $sep['dv']));
                    }
                }
            } else {
                $this->_logError(2, sprintf('RUT/RUN isn\'t within range of natural person or enterprise'));
            }

            $output[$rut] = array(
                'isValid'  => $isValid,
                'rut'      => $sep['rut'],
                'verifier' => $sep['dv'],
                'type'     => $rutType,
            );
        }

        if ($returnBoolean === true) {
            return $isValid;
        }
        return $output;
    }
}
