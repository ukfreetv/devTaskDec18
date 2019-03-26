<?php
/**
 * Created by PhpStorm.
 * User: Briantist
 * Date: 07/08/2015
 * Time: 01:09
 */

namespace brianButterworth\test;

use Exception;

class teComplex
{
    public $r;
    public $i;

    public function __construct($r, $i)
    {
        $this->r = $r;
        $this->i = $i;
    }

    function exp()
    {
        $rho = exp($this->r);
        $theta = $this->i;
        $r = $rho * cos($theta);
        $i = $rho * sin($theta);

        return new teComplex($r, $i);
    }

    public function __toString()
    {
        $strString = $this->toString();
        if (!is_string($strString)) {
            $strString = "$strString ...";
        }

        return $strString;
    }

    public function toString()
    {
        if ($this->i == 0.0) {
            if (isset($this->r)) {

//                var_dump($this->r);

                return (($this->r) + 0) . " (*)";
            } else {
                return "?";
            }


        } elseif ($this->i < 0.0) {
            return $this->r . ' - ' . abs($this->i) . 'i';
        } else {
            return $this->r . ' + ' . $this->i . 'i';
        }
    }

    public function equals($num)
    {
        if (is_a($num, 'admin\predictBackend\teComplex')) {
            return ($num->r == $this->r && $num->i == $this->i);
        } else {
            return (floatval($num) == $this->r && $this->i == 0.0);
        }
    }

    public function neg()
    {
        return new teComplex(-$this->r, -$this->i);
    }

    public function conj()
    {
        return new teComplex($this->r, -$this->i);
    }

    public function inverse()
    {
        $denom = $this->r * $this->r + $this->i * $this->i;
        if ($denom == 0.0) {
            throw new Exception('Division by zero while inverting zero.');
        } else {
            return new teComplex($this->r / $denom, -$this->i / $denom);
        }
    }

    public function add($num)
    {
        if (is_a($num, 'admin\predictBackend\teComplex'))
            return new teComplex($this->r + $num->r, $this->i + $num->i);
        else
            return new teComplex($this->r + floatval($num), $this->i);
    }

    public function sub($num)
    {
        if (is_a($num, 'admin\predictBackend\teComplex'))
            return new teComplex($this->r - $num->r, $this->i - $num->i);
        else
            return new teComplex($this->r - floatval($num), $this->i);
    }

    public function mul($num)
    {
        if (is_a($num, 'admin\predictBackend\teComplex')) {
            return new teComplex($this->r * $num->r - $this->i * $num->i, $this->i * $num->r + $this->r * $num->i);
        } else {
            $real = floatval($num);

            return new teComplex($this->r * $real, $this->i * $real);
        }
    }

    public function div($num)
    {
        if (is_a($num, 'admin\predictBackend\teComplex')) {
            $denom = $num->r * $num->r + $num->i * $num->i;
            if ($denom == 0.0) {
                throw new Exception('Division by zero');
            } else {
                return new teComplex(($this->r * $num->r + $this->i * $num->i) / $denom, ($this->i * $num->r - $this->r * $num->i) / $denom);
            }
        } else {
            $real = floatval($num);
            if ($real == 0.0) {
                throw new Exception('Division by zero');
            } else {
                return new teComplex($this->r / $real, $this->i / $real);
            }
        }
    }

    public function pow($num)
    {
        $logabs = log($this->abs());
        $arg = $this->arg();
        if (is_a($num, 'admin\predictBackend\teComplex')) {
            $pabs = exp($num->r * $logabs - $num->i * $arg);
            $parg = $num->i * $logabs + $num->r * $arg;
        } else {
            $real = floatval($num);
            $pabs = exp($real * $logabs);
            $parg = $real * $arg;
        }

        return new teComplex($pabs * cos($parg), $pabs * sin($parg));
    }

    public function abs()
    {
        return sqrt($this->r * $this->r + $this->i * $this->i);
    }

    public function arg()
    {
        return atan2($this->i, $this->r);
    }

    public function sqrt()
    {
        if ($this->r == 0.0 && $this->i == 0.0) {
            return new teComplex(0.0, 0.0);
        } else {
            $abs = $this->abs();
            if ($this->i < 0.0) {
                return new teComplex(sqrt(($abs + $this->r) / 2), -sqrt(($abs - $this->r) / 2));
            } else {
                return new teComplex(sqrt(($abs + $this->r) / 2), sqrt(($abs - $this->r) / 2));
            }
        }
    }
}

function sqrtExt($real, $forceComplex = false)
{
    if ($real < 0.0) {
        return new teComplex(0.0, sqrt(-$real));
    } else {
        if ($forceComplex) {
            return new teComplex(sqrt($real), 0.0);
        } else {
            return sqrt($real);
        }
    }
}

function complex($r, $i = 0.0)
{
    return new teComplex($r, $i);
}