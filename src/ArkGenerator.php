<?php

declare(strict_types=1);

namespace rguezque\ArkGenerator;

class ArkGenerator
{
    /** @var string The current scheme for identifier */
    private string $scheme;

    /** @var string The indentifier prefix */
    private string $naan;

    /** @var string A custom _shoulder suffix_ */
    private ?string $shoulder_suffix = null;

    /**
     * Setup the generator
     * 
     * @param string Main identifier as prefix
     * @param string Identifier scheme (ARK, DOI, URN, HDL (Handle))
     */
    public function __construct(string $naan, string $scheme = Constants::ARK_SCHEME) {
        $this->naan = $naan;
        $this->scheme = $scheme;
    }

    /**
     * Set a custom _shoulder suffix_ to create the suffix
     * 
     * @param string $shoulder_suffix The string suffix
     * @return ArkGenerator
     */
    public function setShoulderSuffix(string $shoulder_suffix): ArkGenerator {
        $this->shoulder_suffix = pipe('clean_hyphens', 'trim')($shoulder_suffix);
        return $this;
    }

    /**
     * Reset the _shoulder suffix_ to `null`
     * 
     * @return ArkGenerator
     */
    public function resetShoulderSuffix(): ArkGenerator {
        $this->shoulder_suffix = null;
        return $this;
    }

    /**
     * Generate the suffix and return a data array about the identifier
     * 
     * @param string $shoulder_prefix The _shoulder prefix_ for join to _shoulder_suffix_
     * @param string $mask A string mask to define how to generate the _shoulder_suffix_
     * @return array
     */
    function generate(string $shoulder_prefix, string $mask): array {
        $shoulder_prefix = pipe('clean_hyphens', 'trim', 'strtolower')($shoulder_prefix);
        $shoulder_suffix = $this->shoulder_suffix ?? $this->generateShoulderSuffix($mask);

        $suffix = $shoulder_prefix . $shoulder_suffix;
        $full = $this->naan . '/' . $suffix;

        return [
            'scheme' => $this->scheme,
            'prefix' => $this->naan,
            'shoulder_prefix' => $shoulder_prefix,
            'shoulder_suffix' => $shoulder_suffix,
            'suffix' => $suffix,
            'identifier' => $full,
            'identifier_length' => strlen($full),
            'full_scheme' => $this->scheme . ':' . $full,
            'created_at' => time()
        ];
    }

    /**
     * Generate and return the _shoulder suffix_
     * 
     * @param string $mask A string mask to define how to generate the _shoulder_suffix_
     * @return string
     */
    public function generateShoulderSuffix(string $mask): string {
        if(0 === pipe('trim', 'strlen')($mask)) {return '';}

        // Charsets availables
        $digits = Constants::DIGITS;
        $lcase_alpha = Constants::LCASE_ALPHA;
        $ucase_alpha = Constants::UCASE_ALPHA;
        $alpha_numeric = Constants::ALPHA_NUMERIC;
        $extended = Constants::EXTENDED;
        $special_chars = Constants::SPECIAL_CHARS;
        
        $d_count = strlen($digits);
        $l_count = strlen($lcase_alpha);
        $u_count = strlen($ucase_alpha);
        $a_count = strlen($alpha_numeric);
        $e_count = strlen($extended);
        $s_count = strlen($special_chars);
        
        $mask = pipe('trim', 'str_split')($mask);
        $shoulder_suffix = '';

        // Recorre cada carácter de la máscara
        foreach ($mask as $mask_char) {
            switch ($mask_char) {
                case 'd':
                    // 'd': Generate a digit (0-9)
                    $shoulder_suffix .= $digits[random_int(0, $d_count - 1)];
                    break;
                case 'l':
                    // 'l': Generate an alphabetic char in lowercase (a-z)
                    $shoulder_suffix .= $lcase_alpha[random_int(0, $l_count - 1)];
                    break;
                case 'u':
                    // 'u': Generate an alphabetic char in uppercase (A-Z)
                    $shoulder_suffix .= $ucase_alpha[random_int(0, $u_count - 1)];
                    break;
                case 'a':
                    // 'a': Generate an alphanumeric char (0-9, a-z)
                    $shoulder_suffix .= $alpha_numeric[random_int(0, $a_count - 1)];
                    break;
                case 'e':
                    // 'e': Generate an alphanumeric char extended (0-9, a-z, A-Z)
                    $shoulder_suffix .= $extended[random_int(0, $e_count - 1)];
                    break;
                case 's':
                    // 's': Generate an alphanumeric char extended including special chars (0-9, a-z, A-Z, '=~*+@_$')
                    $shoulder_suffix .= $special_chars[random_int(0, $s_count - 1)];
                    break;
                default:
                    // Any other char is directly added
                    $shoulder_suffix .= $mask_char;
                    break;
            }
        }

        return $shoulder_suffix;
    }
}
