<?php
/**
 * Created by PhpStorm.
 * User: Briantist
 * Date: 27/07/2015
 * Time: 11:21
 */

namespace brianButterworth\test;



class FccGroundwave
{
    const DEBUG = false;
    const C1 = 0.4613135;
    const C2 = 0.09999216;
    const C3 = 0.002883894;
    const D1 = 0.1901635;
    const D2 = 1.7844927;
    const D3 = 5.5253437;
    const P = 0.3275911;
    const A1 = 0.2548296;
    const A2 = -0.2844967;
    const A3 = 1.4214137;
    const A4 = -1.4531520;
    const A5 = 1.0614054;
    private $cpxOnlyI, $cpxOne;
    private $arrCache = [];

    public function __construct()
    {
        $this->cpxOnlyI = new teComplex(0, 1);
        $this->cpxOne = new teComplex(1, 0);
    }

    function PROGRAM_FCCGW_cached($FREQ,  $DIST)
    {
        $DIST = round($DIST);
        $FREQ1 = $FREQ * 1e9;
        if ($DIST < 1) {
            return 1;
        } else {
            if (!isset($this->arrCache[$DIST][$FREQ1])) {
                $this->arrCache[$DIST][$FREQ1] = $this->PROGRAM_FCCGW(5, 15, $FREQ, $DIST);
            }
        }
        return $this->arrCache[$DIST][$FREQ1];
    }

    function PROGRAM_FCCGW($SIGMA = 5, $EPSILON = 15, $FREQ = .55, $DIST = 80)
    {
        if (self::DEBUG)
            echo PHP_EOL . __CLASS__ . ":" . __FUNCTION__ . "($SIGMA, $EPSILON, $FREQ, $DIST)";
        if (self::DEBUG)
            echo PHP_EOL . "$DIST km  ground conductivity $SIGMA mS/m  dielectric constant $EPSILON  @ $FREQ  MHz:";
        $this->GWCONST($SIGMA, $EPSILON, $FREQ, $DIST, $P, $B, $K, $CHI);
        $FAR = 80 / pow($FREQ, .3333);
        IF ($DIST <= $FAR) {
            $METHOD = 1;
            self::SURFACE($P, $B, $K, $A);
        } ELSE {
            $METHOD = 2;
            $PSI = 0.5 * $B;
            self::RESIDUES($CHI, $K, $PSI, $A);
        }
        $FIELD = $A * 100 / $DIST;
        if (self::DEBUG)
            echo " METHOD=$METHOD  $FIELD FIELD (mV/m)  A=$A";
        return $A;
    }

    function GWCONST($SIGMA, $EPSILON, $FREQ, $DIST, &$P, &$B, &$K, &$CHI)
    {
        if (self::DEBUG)
            echo PHP_EOL . __CLASS__ . ":" . __FUNCTION__;
        $K = 0;
        $PI = pi();
        $EARTHRAD = 6370.;
        $FACTOR = 1.333333;
        $SPEED = 299700;
        $EFFRAD = $FACTOR * $EARTHRAD;
        $WAVELENGTH = $SPEED / (1E6 * $FREQ);
        $X = 17.97 * $SIGMA / $FREQ;
        $B1 = ATAN2($EPSILON - 1, $X);
        $B2 = ATAN2($EPSILON, $X);
        $P = $PI * ($DIST / $WAVELENGTH) * pow(COS($B2), 2) / ($X * COS($B1));
        $B = 2 * $B2 - $B1;
        $K = pow(($WAVELENGTH / (2 * $PI * $EFFRAD)), (1 / 3)) * SQRT($X * COS($B1)) / COS($B2);
        $CHI = $DIST / $EFFRAD * pow((2 * $PI * $EFFRAD / $WAVELENGTH), (1 / 3));
    }

    function SURFACE($P, $B, $realK, &$A)
    {
        if (self::DEBUG)
            echo PHP_EOL . __CLASS__ . ":" . __FUNCTION__;
        $cpxRHO = new teComplex($P * COS($B), $P * SIN($B));
        $cpxDEL = new teComplex($realK * (COS(3 * PI() / 4 - $B / 2)), $realK * (SIN(3 * PI() / 4 - $B / 2)));
        $this->SOMMERFLD($cpxRHO, $cpxZA);
        IF ($cpxRHO->abs() > 0.5) {
            $cpxZADJ = self::ZADJ2($cpxDEL, $cpxRHO, $cpxZA);
        } ELSE {
            $cpxZ1 = $this->cpxOnlyI->mul($cpxRHO->sqrt());
            $cpxZ3 = $cpxDEL->mul($cpxZ1)->pow(3);
            $cpxZADJ = $cpxZA->sub($cpxZ3->mul(self::SRS1($cpxZ1)))->sub($cpxZ3->mul(self::SRS2($cpxZ1)));
        }
        $A = $cpxZADJ->abs();
        RETURN;
    }

    function SOMMERFLD($cpxRHO, &$ZA)
    {
        if (self::DEBUG)
            echo PHP_EOL . __CLASS__ . ":" . __FUNCTION__;
        IF ($cpxRHO->abs() < 0) {
            die('ERROR: Complex numerical distance in lower half-plane');
        }
        $cpxRHOROOT = $cpxRHO->sqrt();
        IF ($cpxRHOROOT->r > 3.9 OR $cpxRHOROOT->abs() > 3.0) {
            goto LABEL300;
        }
        IF ($cpxRHOROOT->abs() > 1) {
            goto LABEL200;
        }
        $TERM = new teComplex(1, 0);;
        $cpxSUM = new teComplex(1, 0);
        for ($intI = 1; $intI < 33; $intI += 1) {
            $TERM = $cpxRHO->mul(-2)->mul($TERM)->div(2 * $intI - 1);
            $cpxSUM = $cpxSUM->add($TERM);
            IF ($TERM->abs() < $cpxSUM->abs() / 1E5) {
                $cpxXX1 = $cpxRHO->neg()->exp();
                $cpxXX2 = $cpxRHO->mul(PI())->sqrt()->mul($cpxXX1)->mul($this->cpxOnlyI);
                $ZA = $cpxSUM->add($cpxXX2);
                RETURN $ZA;
            }
        }
        LABEL200:
        $cpxERFC = self::SALZER($cpxRHOROOT->mul(new teComplex(0, -1)));
        $cpxJustI = new teComplex(0, 1);
        $ZA = $cpxJustI->add(1)->mul($cpxRHO->mul(pi())->sqrt()->mul($cpxRHO->neg()->exp()->mul($cpxERFC)));
        RETURN $ZA;
        LABEL300:
        $ZA = $this->cpxOne->add($this->cpxOnlyI->mul($cpxRHO->mul(PI())->mul(self::cpxW($cpxRHOROOT))));
        RETURN $ZA;
    }

    function SALZER($cpxZ)
    {
        if (self::DEBUG)
            echo PHP_EOL . __CLASS__ . ":" . __FUNCTION__;
        $realX = $cpxZ->r;
        $realY = $cpxZ->i;
        $SUM = new teComplex(0, 0);
        $cpxTEST = $SUM;
        IF ($realY == 0) {
        } else {
            $N = MIN(ABS(80 / $realY), 50);
            for ($intI = 1; $intI <= $N; $intI++) {
                $Isquared = pow($intI, 2);
                $Xsquared = pow($realX, 2);
                $cpxTemp = new teComplex(self::F($realX, $realY, $intI), self::G($realX, $realY, $intI));
                $cpxTemp = $cpxTemp->div($Isquared + 4.0 * $Xsquared);
                $cpxTemp = $cpxTemp->mul(-.25 * $Isquared);
                $SUM = $SUM->add($cpxTemp->exp());
                IF ($intI > 1 AND $SUM->sub($cpxTEST)->abs() < $cpxTEST->abs() / 1E5) {
                    goto LABEL20;
                }
                $cpxTEST = $SUM;
            }
        }
        echo "Unexpected error: Salzer series failed to converge'";
        LABEL20:
        $SALZER = new teComplex(2 - 2 * exp(pow($realX, 2)), 0);
        $SALZER->mul($SUM)->div(PI());
        IF ($realX !== 0) {
            $SALZER = $SALZER->sub(new teComplex(EXP(-pow($realX, 2)) * (1 - COS(2 * $realX * $realY)), SIN(2 * $realX * $realY) / (2 * PI() * $realX)));
        }
        IF ($realX >= 0) {
            $SALZER = $SALZER->add(self::REALERFC($realX));
        } ELSE {
            $SALZER = $SALZER->add(2)->sub(self::REALERFC(-$realX));
        }
        return $SALZER;
    }

    private static function F($X, $Y, $N)
    {
        return 2 * $X - 2 * $X * COS($N * $Y) * COS(2 * $X * $Y) + $N * SINH($N * $Y) * SIN(2 * $X * $Y);
    }

    private static function G($X, $Y, $N)
    {
        return 2 * $X * COSH($N * $Y) * SIN(2 * $X * $Y) + $N * SINH($N * $Y) * COS(2 * $X * $Y);
    }

    private static function REALERFC($X)
    {
        return self::T($X) * (self::A1 + self::T($X) * (self::A2 + self::T($X) * (self::A3 + self::T($X) * (self::A4 + self::T($X) * (self::A5))))) * EXP(pow(-$X, 2));
    }

    private static function T($X)
    {
        return 1 / (1 + self::P * $X);
    }

    private function cpxW($cpxZ)
    {
        if (self::DEBUG)
            echo PHP_EOL . __CLASS__ . ":" . __FUNCTION__;
        $cpxOnlyI = new teComplex(0, 1);
        $cpxOne = new teComplex(1, 0);
        $cpx1 = $cpxOne->mul(self::C1)->div($cpxZ->pow(2)->sub(self::D1));
        $cpx2 = $cpxOne->mul(self::C2)->div($cpxZ->pow(2)->sub(self::D2));
        $cpx3 = $cpxOne->mul(self::C2)->div($cpxZ->pow(2)->sub(self::D3));
        return $cpxOnlyI->mul($cpxZ)->mul($cpx1->add($cpx2)->add($cpx3));
    }

    private static function ZADJ2($cpxDEL, $cpxRHO, $ZA)
    {
        if (self::DEBUG)
            echo PHP_EOL . __CLASS__ . ":" . __FUNCTION__;
        $cpxNumberOne = new teComplex(1, 0);
        $cpxJustI = new teComplex(0, 1);
        $PI = PI();
        $cpxBottom = $cpxRHO->pow(2)->mul(5 / 6)->add($cpxRHO->mul(-2));
        $cpxTop = $cpxRHO->pow(2);
        $cpxTop = $cpxTop->mul(0.5);
        $cpxTop = $cpxTop->sub(1);
        $cpxTop = $cpxTop->mul($ZA);
        $cpxMiddle = $cpxJustI->mul($cpxRHO->mul($PI)->sqrt())->mul($cpxNumberOne->sub($cpxRHO));
        $cpxTemp = $cpxTop->add($cpxMiddle)->add($cpxBottom);
        return self::ZADJ1($cpxDEL, $cpxRHO, $ZA)->add($cpxTemp->mul($cpxDEL->pow(6)));
    }

    private static function ZADJ1($cpxDEL, $cpxRHO, $ZA)
    {
        if (self::DEBUG)
            echo PHP_EOL . __CLASS__ . ":" . __FUNCTION__;
        $cpxTemp2 = $cpxRHO->mul(PI())->mul(new teComplex(0, 1));
        $cpxTemp = $cpxRHO->mul(2)->add(1)->mul($ZA)->sub(1)->sub($cpxTemp2);
        return $cpxDEL->pow(3)->mul(0.5)->mul($cpxTemp);
    }

    function SRS1($cpxZ)
    {
        if (self::DEBUG)
            echo PHP_EOL . __CLASS__ . ":" . __FUNCTION__;
        $cpxODDTERM = $cpxZ->mul(4)->div(3 * SQRT(PI()));
        $cpxEVENTERM = new teComplex(1, 0);
        $SUM = $cpxODDTERM->mul(2)->add(1);
        $TEST = $SUM;
        for ($intI = 2; $intI < 50; $intI += 1) {
            IF ($intI % 2 == 0) {
                $cpxEVENTERM = $cpxEVENTERM->mul(2)->mul($cpxZ->pow(2))->div($intI + 2);
                $TERM = $cpxEVENTERM;
            } ELSE {
                $cpxODDTERM = $cpxODDTERM->mul(2)->mul($cpxZ->pow(2))->div($intI + 2);
                $TERM = $cpxODDTERM;
            }
            $SUM = $TERM->mul($intI + 1)->add($SUM);
            if (($intI > 2 AND $SUM->sub($TEST)->abs()) < $TEST->abs() / 1E6) {
                goto LABEL110;
            }
            $TEST = $SUM;
        }
        echo PHP_EOL . 'Slow convergence in series l';
        LABEL110:
        return $SUM->mul(SQRT(pi()) / 2);
    }

    function SRS2($cpxZ)
    {
        if (self::DEBUG)
            echo PHP_EOL . __CLASS__ . ":" . __FUNCTION__;
        $cpxEVENTERM = new teComplex(8 / (15 * SQRT(PI())), 0);
        $cpxODDTERM = $cpxZ->div(6);
        $SUM = $cpxEVENTERM->mul(7)->add(2)->add($cpxODDTERM->mul(8));
        $TEST = $SUM;
        for ($intI = 2; $intI < 50; $intI += 1) {
            if ($intI % 2 == 0) {
                $cpxEVENTERM = $cpxEVENTERM->mul(2)->mul($cpxEVENTERM->pow(2))->div($intI + 5);
                $TERM = $cpxEVENTERM;
            } ELSE {
                $cpxODDTERM = $cpxODDTERM->mul(2)->mul($cpxEVENTERM->pow(2))->div($intI + 5);
                $TERM = $cpxODDTERM;
            }
            $SUM = $TERM->mul($intI + 1)->mul($intI + 7)->add($SUM);
            if ($intI > 2 and $SUM->sub($TEST)->abs() < $TEST->abs() / 1E6) {
                goto LABEL210;
            }
            $TEST = $SUM;
        }
        echo PHP_EOL . 'Slow convergence in series 2';
        LABEL210:
        $SBS2 = $SUM->mul(SQRT(PI()) / 8);
        return $SBS2;
    }

    function RESIDUES($realCHI, $realK, $realPSI, &$ATTENUATION)
    {
        if (self::DEBUG)
            echo PHP_EOL . __CLASS__ . ":" . __FUNCTION__;
        $intMAXTERMS = 30;
        $realPRECISION = 1E-4;
        $realFINENESS = 0.05;
        $cpxTemp = $this->cpxOnlyI->mul((3 * PI() / 4 - $realPSI));
        $cpxDELNEW = $cpxTemp->exp()->mul($realK);
        $cpxDEL = $cpxDELNEW;
        $QSQR = $this->cpxOne->div($cpxDEL)->pow(2);
        $cpxZS = new teComplex(0, 0);
        $cpxTEST = new teComplex(0, 0);
        for ($intS = 1; $intS <= $intMAXTERMS; $intS += 1) {
            $cpxTAU0 = self::TFN(self::AIRY0($intS));
            $cpxTAU1 = self::TFN(self::AIRY1($intS));
            $realKsquared = pow($realK, 2);
            if ($cpxTAU0->mul($realKsquared)->abs() < .25) {
                $TAU[$intS] = self::TAUFN0($cpxTAU0, $cpxDEL);
                if (self::DEBUG)
                    echo "a";
            } ELSE {
                IF ($cpxTAU1->mul(pow($realK, 2))->abs() > 1) {
                    $TAU[$intS] = self::TAUFNl($cpxTAU1, $this->cpxOne->div($cpxDEL));
                    if (self::DEBUG)
                        echo "b";
                } ELSE {
                    if (self::DEBUG)
                        echo "c";
                    $cpxT = $cpxTAU0;
                    $intN = MAX($cpxDEL->abs() / $realFINENESS, 2.0);
                    $cpxDELDEL = $cpxDEL->div($intN);
                    $cpxDEL1 = new teComplex(0, 0);
                    for ($intI = 1; $intI <= $intN; $intI += 1) {
                        $cpxTK1 = self::DELTAU($cpxT, $cpxDEL1, $cpxDELDEL);
                        $cpxDEL1 = $cpxDEL1->add($cpxDELDEL->div(2));
                        $cpxTK2 = self::DELTAU($cpxT->add($cpxTK1->div(2)), $cpxDEL1, $cpxDELDEL);
                        $cpxTK3 = self::DELTAU($cpxT->add($cpxTK2->div(2)), $cpxDEL1, $cpxDELDEL);
                        $cpxDEL1 = $cpxDEL1->add($cpxDELDEL->div(2));
                        $cpxTK4 = self::DELTAU($cpxT->add($cpxTK3), $cpxDEL1, $cpxDELDEL);
                        $cpxT = $cpxT->add($cpxTK1->add($cpxTK2->mul(2))->add($cpxTK3->mul(2))->add($cpxTK4)->div(6));
                    }
                    $TAU[$intS] = $cpxT;
                }
            }
            LABEL80:
            LABEL90:
            $Z = $this->cpxOnlyI->mul($TAU[$intS])->mul($realCHI)->exp()->div($TAU[$intS]->mul(2)->add($QSQR));
            $cpxZS = $cpxZS->add($Z);
            IF ($cpxZS->sub($cpxTEST)->abs() < ($realPRECISION * $cpxTEST->abs())) {
                if (self::DEBUG)
                    echo "**";
                goto LABEL200;
            }
            $cpxTEST = $cpxZS;
        }
        LABEL200:
        $ATTENUATION = $cpxZS->abs() * SQRT(2 * PI() * $realCHI);
        return $ATTENUATION;
    }

    private static function TFN($AIRY)
    {
        if (self::DEBUG)
            echo PHP_EOL . __CLASS__ . ":" . __FUNCTION__;
        $cpxOnlyI = new teComplex(0, 1);
        return $cpxOnlyI->mul(PI() / 3)->exp()->mul(($AIRY / pow(2, 1 / 3)));
    }

    function AIRY0($S)
    {
        $A0 = [
            1 => 2.3381074,
            4.0879494,
            5.5205598,
            6.7867081,
            7.9441336,
            9.0226508,
            10.0401743,
            11.0085243,
            11.9360156,
            12.8287767
        ];
        IF ($S < 10) {
            return $A0[$S];
        } ELSE {
            return self::F_AIRY0(self::X($S));
        }
    }

    private static function F_AIRY0($X)
    {
        return pow($X, (2. / 3)) * (1 + 5.148 * pow((1 / $X), 2));
    }

    private static function X($S)
    {
        return 3 * PI() * (4 * $S - 1) / 8;
    }

    function AIRY1($S)
    {
        $A0 = [
            1 => 1.0187930,
            3.2481976,
            4.8200992,
            6.1633074,
            7.3721773,
            8.4884867,
            9.5354491,
            10.5276604,
            11.4750566,
            12.3847884
        ];
        IF ($S <= 10) {
            return $A0[$S];
        } ELSE {
            return self::G_AIRYl(self::Y($S));
        }
    }

    private static function G_AIRYl($Y)
    {
        return pow($Y, (2. / 3)) * (1 - 7.148 * pow((1 / $Y), 2));
    }

    private static function Y($S)
    {
        return (3 * PI()) * (4 * $S - 3) / 8;
    }

    private static function TAUFN0($TAU, $DEL)
    {
        if (self::DEBUG)
            echo PHP_EOL . __CLASS__ . ":" . __FUNCTION__;
        $C1 = new teComplex(-1, 0);
        $C2 = new teComplex(0, 0);
        $C3 = self::C3($TAU);
        $C4 = new teComplex(1 / 2, 0);
        $C5 = self::C5($TAU);
        $C6 = self::C6($TAU);
        $C7 = self::C7($TAU);
        $C8 = self::C8($TAU);
        $C9 = self::C9($TAU);
        $C10 = self::C10($TAU);
        return $TAU->add($DEL->mul($C1->add($DEL->mul($C2->add($DEL->mul($C3->add($DEL->mul($C4->add($DEL->mul($C4->add($DEL->mul($C5->add($DEL->mul($C6->add($DEL->mul($C7->add($DEL->mul($C8->add($DEL->mul($C9->add($DEL->mul($C10))))))))))))))))))))));
    }

    private static function C3($TAU)
    {
        return $TAU->mul(-2 / 3);
    }

    private static function C5($TAU)
    {
        return $TAU->pow(2)->mul(-4 / 5);
    }

    private static function C6($TAU)
    {
        return $TAU->mul(14 / 9);
    }

    private static function C7($TAU)
    {
        return $TAU->pow(3)->mul(8)->add(5)->div(7)->neg();
    }

    private static function C8($TAU)
    {
        return $TAU->pow(2)->mul(58 / 15);
    }

    private static function C9($TAU)
    {
        $cpxTemp = $TAU->pow(3)->mul(16 / 9)->add(2296. / 567);
        return $TAU->neg()->mul($cpxTemp);
    }

    private static function C10($TAU)
    {
        return $TAU->pow(3)->mul(4656 / 525)->add(47 / 35);
    }

    private static function TAUFNl($TAU, $Q)
    {
        if (self::DEBUG)
            echo PHP_EOL . __CLASS__ . ":" . __FUNCTION__;
        $cpxTemp = self::D8($TAU);
        $cpxTemp = $cpxTemp->mul($Q)->add(self::D7($TAU));
        $cpxTemp = $cpxTemp->mul($Q)->add(self::D6($TAU));
        $cpxTemp = $cpxTemp->mul($Q)->add(self::D5($TAU));
        $cpxTemp = $cpxTemp->mul($Q)->add(self::D4($TAU));
        $cpxTemp = $cpxTemp->mul($Q)->add(self::D3($TAU));
        $cpxTemp = $cpxTemp->mul($Q)->add(self::D2($TAU));
        $cpxTemp = $cpxTemp->mul($Q)->add(self::D1($TAU));
        $cpxTemp = $cpxTemp->mul($Q)->add($TAU);
        return $cpxTemp;
    }

    private static function D8($TAU)
    {
        return self::Dmaker($TAU, 6, 1)->mul(self::DmakerPos($TAU, 3, 1)->mul(1)->add(97 / 4480)->mul(self::DmakerPos($TAU, 3, 1)->mul(1)->add(163 / 2560)->mul(self::DmakerPos($TAU, 3, 1)->mul(1)->add(29. / 8192)->mul(self::DmakerPos($TAU, 3, 32768)->mul(429)->add(429 / 8192)))));
    }

    private static function Dmaker($TAU, $fpPower = 1, $fpMultipler = 1)
    {
        $cpxOne = new teComplex(1, 0);
        return $cpxOne->neg()->div($TAU->pow(3)->mul(8));
    }

    private static function DmakerPos($TAU, $fpPower = 1, $fpMultipler = 1)
    {
        $cpxOne = new teComplex(1, 0);
        return $cpxOne->div($TAU->pow(3)->mul(8));
    }

    private static function D7($TAU)
    {
        return self::Dmaker($TAU, 4, 1)->mul(self::DmakerPos($TAU, 3, 1)->mul(1)->add(1 / 112)->mul(self::DmakerPos($TAU, 3, 1)->mul(1)->add(19 / 360)->mul(self::DmakerPos($TAU, 3, 2048)->mul(33)->add(143 / 2560))));
    }

    private static function D6($TAU)
    {
        return self::Dmaker($TAU, 5, 1)->mul(self::DmakerPos($TAU, 3, 1)->mul(1)->add(29. / 720)->mul(self::DmakerPos($TAU, 3, 1024)->mul(21)->add(77 / 1280)));
    }

    private static function D5($TAU)
    {
        return self::Dmaker($TAU, 3, 1)->mul(self::DmakerPos($TAU, 3, 256)->mul(7)->add(21 / 320)->mul(self::DmakerPos($TAU, 3, 1)->add(1 / 40)));
    }

    private static function D4($TAU)
    {
        return self::Dmaker($TAU, 4, 1)->mul(self::DmakerPos($TAU, 3, 128)->mul(5)->add(7 / 96));
    }

    private static function D3($TAU)
    {
        return self::Dmaker($TAU, 2, 1)->mul(self::DmakerPos($TAU, 3, 16)->add(1 / 12));
    }

    private static function D2($TAU)
    {
        return self::Dmaker($TAU, 3, 8);
    }

    private static function D1($TAU)
    {
        return self::Dmaker($TAU, 1, 8);
    }

    private static function DELTAU($cpxTAU, $cpxDEL, $cpxDELDEL)
    {
        if ($cpxDEL == "")
            die("w t f DEL is null!");
        if (self::DEBUG)
            echo PHP_EOL . __CLASS__ . ":" . __FUNCTION__ . "($cpxTAU,
            $cpxDEL, (*)
            $cpxDELDEL
            )";
        return $cpxDELDEL->div($cpxTAU->mul(2)->mul($cpxDEL->pow(2)->sub(1)));
    }
}