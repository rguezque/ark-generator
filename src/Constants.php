<?php declare(strict_types = 1);

namespace rguezque\ArkGenerator;

class Constants {
    /** @var string ARK scheme */
    const ARK_SCHEME = 'ark';
    /** @var string DOI scheme */
    const DOI_SCHEME = 'doi';
    /** @var string URN scheme */
    const URN_SCHEME = 'urn';
    /** @var string Handle scheme */
    const HDL_SCHEME = 'hdl';

    /** @var string Integer digits */
    const DIGITS = '0123456789';
    /** @var string Lowercase alphabet */
    const LCASE_ALPHA = 'abcdefghijklmnopqrstuvwxyz';
    /** @var string Uppercase alphabet */
    const UCASE_ALPHA = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
    /** @var string Alphanumeric digits (0-9, a-z) */
    const ALPHA_NUMERIC = self::DIGITS . self::LCASE_ALPHA;
    /** @var string Extended alphanumeric digits (0-9, a-z, A-Z) */
    const EXTENDED = self::ALPHA_NUMERIC . self::UCASE_ALPHA;
    /** @var string Extended alphanumeric digits with special chars (0-9, a-z, A-Z, '=~*+@_$') */
    const SPECIAL_CHARS = self::EXTENDED . '=~*+@_$';
}

?>