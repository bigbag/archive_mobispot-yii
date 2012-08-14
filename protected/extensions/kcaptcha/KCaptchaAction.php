<?php
/**
 * KCaptchaAction class file.
 *
 * @author     Andrey Nilov <nilov@glavweb.ru>
 * @copyright  Copyright (c) 2010-2012 Glavweb.Soft, Russia. (http://glavweb.ru)
 * @license
 *
 * THIS SOFTWARE IS PROVIDED BY THE COPYRIGHT HOLDERS AND CONTRIBUTORS "AS IS"
 * AND ANY EXPRESS OR IMPLIED WARRANTIES, INCLUDING, BUT NOT LIMITED TO, THE
 * IMPLIED WARRANTIES OF MERCHANTABILITY AND FITNESS FOR A PARTICULAR PURPOSE
 * ARE DISCLAIMED. IN NO EVENT SHALL THE COPYRIGHT OWNER OR CONTRIBUTORS BE
 * LIABLE FOR ANY DIRECT, INDIRECT, INCIDENTAL, SPECIAL, EXEMPLARY, OR
 * CONSEQUENTIAL DAMAGES (INCLUDING, BUT NOT LIMITED TO, PROCUREMENT OF SUBSTITUTE
 * GOODS OR SERVICES; LOSS OF USE, DATA, OR PROFITS; OR BUSINESS INTERRUPTION) HOWEVER
 * CAUSED AND ON ANY THEORY OF LIABILITY, WHETHER IN CONTRACT, STRICT LIABILITY, OR TORT
 * (INCLUDING NEGLIGENCE OR OTHERWISE) ARISING IN ANY WAY OUT OF THE USE OF THIS SOFTWARE,
 * EVEN IF ADVISED OF THE POSSIBILITY OF SUCH DAMAGE.
 */

/**
 * KCaptchaAction renders a CAPTCHA image.
 *
 * KCaptchaAction is used together with {@link CCaptcha} and {@link CCaptchaValidator}.
 *
 * You must configure properties of KCaptchaAction to customize the appearance of
 * the generated image.
 *
 * Note, KCaptchaAction requires PHP GD2 extension.
 *
 * @author     Andrey Nilov <nilov@glavweb.ru>
 * @author     Kruglov Sergei
 * @author     Qiang Xue <qiang.xue@gmail.com>
 * @copyright  Copyright (c) 2010-2012 Glavweb.Soft, Russia. (http://glavweb.ru)
 * @package    application.extensions.kcaptcha
 */
class KCaptchaAction extends CAction
{
    /**
     * The name of the GET parameter indicating whether the CAPTCHA image should be regenerated.
     */
    const REFRESH_GET_VAR = 'refresh';

    /**
     * Prefix to the session variable name used by the action.
     */
    const SESSION_KEY = 'Yii_Captcha';

    /**
     * The alphabet. Do not change without changing the font files!
     * @var string
     */
    public $alphabet = '0123456789abcdefghijklmnopqrstuvwxyz';

    /**
     * The allowed symbols. No similar characters (o => 0, 1 => l, i => j, t => f).
     * @var string
     */
    public $allowedSymbols = '23456789abcdeghkmnpqsuvxyz';

    /**
     * The width of the generated CAPTCHA image. Defaults to 120.
     * @var integer
     */
    public $width = 120;

    /**
     * The height of the generated CAPTCHA image. Defaults to 60.
     * @var integer
     */
    public $height = 60;

    /**
     * The minimum length for randomly generated word. Defaults to 6.
     * @var integer
     */
    public $minLength = 6;

    /**
     * The maximum length for randomly generated word. Defaults to 7.
     * @var integer
     */
    public $maxLength = 7;

    /**
     * The vertical amplitude of the oscillation character, divided into 2.
     * @var int
     */
    public $fluctuationAmplitude = 5;

    /**
     * Prohibit  spaces between chars.
     * @var boolean
     */
    public $noSpaces = true;

    /**
     * The foreground color (RGB, 0-255).
     * @var string|array
     */
    public $foreColor = '32,64,160';

    /**
     * The backgroung color (RGB, 0-255).
     * @var string|array
     */
    public $backColor = '255,255,255';

    /**
     * How many times should the same CAPTCHA be displayed. Defaults to 3.
     * @var integer
     */
    public $testLimit = 3;

    /**
     * String the fixed verification code.
     *
     * When this is property is set, {@link getVerifyCode} will always return this value.
     * This is mainly used in automated tests where we want to be able to reproduce
     * the same verification code each time we run the tests.
     * Defaults to null, meaning the verification code will be randomly generated.
     *
     * @var string
     */
    public $fixedVerifyCode = null;

    /**
     * The absolute path to fonts dir.
     * @var string
     */
    public $fontsDir = null;

    /**
     * The default fonts dir name.
     * @var string
     */
    protected $_defaultFontsDirName = 'fonts';


    /**
     * Runs the action.
     *
     * @return void
     */
    public function run()
    {
        // AJAX request for regenerating code
        if (isset($_GET[self::REFRESH_GET_VAR])) {
            $code = $this->getVerifyCode(true);

            echo CJSON::encode(array(
                'hash1' => $this->generateValidationHash($code),
                'hash2' => $this->generateValidationHash(strtolower($code)),
                'url' => $this->getController()->createUrl($this->getId(), array('v' => uniqid())),
            ));

        } else {
            $this->renderImage($this->getVerifyCode());
        }

        Yii::app()->end();
    }

    /**
     * Generates a hash code that can be used for client side validation.
     *
     * @param string $code the CAPTCHA code
     * @return string a hash code generated from the CAPTCHA code
     */
    public function generateValidationHash($code)
    {
        for ($hash = 0, $i = strlen($code) - 1; $i >= 0; --$i) {
            $hash += ord($code[$i]);
        }

        return $hash;
    }

    /**
     * Gets the verification code.
     *
     * @param boolean $regenerate whether the verification code should be regenerated.
     * @return string the verification code.
     */
    public function getVerifyCode($regenerate = false)
    {
        if ($this->fixedVerifyCode !== null) {
            return $this->fixedVerifyCode;
        }

        $session = Yii::app()->session;
        $session->open();
        $sessionKey = $this->getSessionKey();

        if ($session[$sessionKey] === null || $regenerate) {
            $session[$sessionKey] = $this->generateVerifyCode();
            $session[$sessionKey . 'count'] = 1;
        }

        return $session[$sessionKey];
    }

    /**
     * Returns the session variable name used to store verification code.
     *
     * @return string the session variable name
     */
    protected function getSessionKey()
    {
        return self::SESSION_KEY;
    }

    /**
     * Generates a new verification code.
     *
     * @return string the generated verification code
     */
    protected function generateVerifyCode()
    {
        $length = mt_rand($this->minLength, $this->maxLength);

        while (true) {
            $verifyCode = '';

            for ($i = 0; $i < $length; $i++) {
                $verifyCode .= $this->allowedSymbols[mt_rand(0, strlen($this->allowedSymbols) - 1)];
            }

            if (!preg_match('/cp|cb|ck|c6|c9|rn|rm|mm|co|do|cl|db|qp|qb|dp|ww/', $verifyCode)) {
                break;
            }
        }

        return $verifyCode;
    }

    /**
     * Validates the input to see if it matches the generated code.
     *
     * @param string  $input         user input
     * @param boolean $caseSensitive whether the comparison should be case-sensitive
     * @return boolean whether the input is valid
     */
    public function validate($input, $caseSensitive)
    {
        $code = $this->getVerifyCode();
        $valid = $caseSensitive ? ($input === $code) : !strcasecmp($input, $code);

        $session = Yii::app()->session;
        $session->open();
        $sessionKey = $this->getSessionKey() . 'count';
        $session[$sessionKey] = $session[$sessionKey] + 1;

        if ($session[$sessionKey] > $this->testLimit && $this->testLimit > 0) {
            $this->getVerifyCode(true);
        }

        return $valid;
    }

    /**
     * Renders the CAPTCHA image based on the code.
     *
     * @param string $code the verification code
     * @return string image content
     */
    protected function renderImage($code)
    {
        $fonts = array();

        $fontsDir = $this->fontsDir === null ?
            dirname(__FILE__) . DIRECTORY_SEPARATOR . $this->_defaultFontsDirName :
            $this->fontsDir;

        if (($handle = opendir($fontsDir))) {
            while (false !== ($file = readdir($handle))) {
                if (preg_match('/\.png$/i', $file)) {
                    $fonts[] = $fontsDir . '/' . $file;
                }
            }
            closedir($handle);
        }

        $alphabetLength = strlen($this->alphabet);
        $codeLength = strlen($code);

        do {
            $fontFile = $fonts[mt_rand(0, count($fonts) - 1)];
            $font = imagecreatefrompng($fontFile);
            imagealphablending($font, true);

            $fontFileWidth = imagesx($font);
            $fontFileHeight = imagesy($font) - 1;
            $fontMetrics = array();
            $symbol = 0;
            $readingSymbol = false;

            // Load fonts
            for ($i = 0; $i < $fontFileWidth && $symbol < $alphabetLength; $i++) {
                $transparent = (imagecolorat($font, $i, 0) >> 24) == 127;

                if (!$readingSymbol && !$transparent) {
                    $fontMetrics[$this->alphabet[$symbol]] = array('start' => $i);
                    $readingSymbol = true;
                    continue;
                }

                if ($readingSymbol && $transparent) {
                    $fontMetrics[$this->alphabet[$symbol]]['end'] = $i;
                    $readingSymbol = false;
                    $symbol++;
                    continue;
                }
            }

            $width = $this->width;
            $height = $this->height;

            $foreColor = is_string($this->foreColor) ? explode(',', $this->foreColor) : $this->foreColor;
            $foreColor = array_map('trim', $foreColor);

            $backColor = is_string($this->backColor) ? explode(',', $this->backColor) : $this->backColor;
            $backColor = array_map('trim', $backColor);

            $img = imagecreatetruecolor($width, $height);
            imagealphablending($img, true);
            $white = imagecolorallocate($img, 255, 255, 255);
            $black = imagecolorallocate($img, 0, 0, 0);

            imagefilledrectangle($img, 0, 0, $width - 1, $height - 1, $white);

            // draw text
            $x = 1;
            for ($i = 0; $i < $codeLength; $i++) {
                $m = $fontMetrics[$code{$i}];
                $y = mt_rand(-$this->fluctuationAmplitude, $this->fluctuationAmplitude) + ($height - $fontFileHeight) / 2 + 2;

                if ($this->noSpaces) {
                    $shift = 0;
                    if ($i > 0) {
                        $shift = 10000;
                        for ($sy = 7; $sy < $fontFileHeight - 20; $sy++) {
                            for ($sx = $m['start'] - 1; $sx < $m['end']; $sx++) {
                                $rgb = imagecolorat($font, $sx, $sy);
                                $opacity = $rgb >> 24;

                                if ($opacity < 127) {
                                    $left = $sx - $m['start'] + $x;
                                    $py = $sy + $y;

                                    if ($py > $height) {
                                        break;
                                    }

                                    for ($px = min($left, $width - 1); $px > $left - 12 && $px >= 0; $px--) {
                                        $color = imagecolorat($img, $px, $py) & 0xff;
                                        if ($color + $opacity < 190) {
                                            if ($shift > $left - $px) {
                                                $shift = $left - $px;
                                            }
                                            break;
                                        }
                                    }
                                    break;
                                }
                            }
                        }
                        if ($shift == 10000) {
                            $shift = mt_rand(4, 6);
                        }
                    }

                } else {
                    $shift = 1;
                }

                imagecopy($img, $font, $x - $shift, $y, $m['start'], 1, $m['end'] - $m['start'], $fontFileHeight);
                $x += $m['end'] - $m['start'] - $shift;
            }
        } while ($x >= $width - 10); // while not fit in canvas

        $center = $x / 2;

        $img2 = imagecreatetruecolor($width, $height);
        $foreground = imagecolorallocate($img2, $foreColor[0], $foreColor[1], $foreColor[2]);
        $background = imagecolorallocate($img2, $backColor[0], $backColor[1], $backColor[2]);
        imagefilledrectangle($img2, 0, 0, $width - 1, $height - 1, $background);
        imagefilledrectangle($img2, 0, $height, $width - 1, $height + 12, $foreground);

        // periods
        $rand1 = mt_rand(750000, 1200000) / 10000000;
        $rand2 = mt_rand(750000, 1200000) / 10000000;
        $rand3 = mt_rand(750000, 1200000) / 10000000;
        $rand4 = mt_rand(750000, 1200000) / 10000000;

        // phases
        $rand5 = mt_rand(0, 31415926) / 10000000;
        $rand6 = mt_rand(0, 31415926) / 10000000;
        $rand7 = mt_rand(0, 31415926) / 10000000;
        $rand8 = mt_rand(0, 31415926) / 10000000;

        // amplitudes
        $rand9 = mt_rand(330, 420) / 110;
        $rand10 = mt_rand(330, 450) / 110;

        //wave distortion
        for ($x = 0; $x < $width; $x++) {
            for ($y = 0; $y < $height; $y++) {
                $sx = $x + (sin($x * $rand1 + $rand5) + sin($y * $rand3 + $rand6)) * $rand9 - $width / 2 + $center + 1;
                $sy = $y + (sin($x * $rand2 + $rand7) + sin($y * $rand4 + $rand8)) * $rand10;

                if ($sx < 0 || $sy < 0 || $sx >= $width - 1 || $sy >= $height - 1) {
                    continue;

                } else {
                    $color = imagecolorat($img, $sx, $sy) & 0xFF;
                    $color_x = imagecolorat($img, $sx + 1, $sy) & 0xFF;
                    $color_y = imagecolorat($img, $sx, $sy + 1) & 0xFF;
                    $color_xy = imagecolorat($img, $sx + 1, $sy + 1) & 0xFF;
                }

                if ($color == 255 && $color_x == 255 && $color_y == 255 && $color_xy == 255) {
                    continue;

                } elseif ($color == 0 && $color_x == 0 && $color_y == 0 && $color_xy == 0) {
                    $newred = $foreColor[0];
                    $newgreen = $foreColor[1];
                    $newblue = $foreColor[2];

                } else {
                    $frsx = $sx - floor($sx);
                    $frsy = $sy - floor($sy);
                    $frsx1 = 1 - $frsx;
                    $frsy1 = 1 - $frsy;

                    $newcolor = (
                        $color * $frsx1 * $frsy1 +
                            $color_x * $frsx * $frsy1 +
                            $color_y * $frsx1 * $frsy +
                            $color_xy * $frsx * $frsy
                    );

                    if ($newcolor > 255) $newcolor = 255;
                    $newcolor = $newcolor / 255;
                    $newcolor0 = 1 - $newcolor;

                    $newred = $newcolor0 * $foreColor[0] + $newcolor * $backColor[0];
                    $newgreen = $newcolor0 * $foreColor[1] + $newcolor * $backColor[1];
                    $newblue = $newcolor0 * $foreColor[2] + $newcolor * $backColor[2];
                }

                imagesetpixel($img2, $x, $y, imagecolorallocate($img2, $newred, $newgreen, $newblue));
            }
        }

        header('Expires: Mon, 26 Jul 1997 05:00:00 GMT');
        header('Cache-Control: no-store, no-cache, must-revalidate');
        header('Cache-Control: post-check=0, pre-check=0', FALSE);
        header('Pragma: no-cache');

        if (function_exists("imagejpeg")) {
            header("Content-Type: image/jpeg");
            imagejpeg($img2, null, 90);

        } elseif (function_exists("imagegif")) {
            header("Content-Type: image/gif");
            imagegif($img2);

        } elseif (function_exists("imagepng")) {
            header("Content-Type: image/x-png");
            imagepng($img2);
        }
    }
}