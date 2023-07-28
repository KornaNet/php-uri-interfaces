<?php

/**
 * League.Uri (https://uri.thephpleague.com)
 *
 * (c) Ignace Nyamagana Butera <nyamsprod@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace League\Uri\Idna;

use PHPUnit\Framework\TestCase;

final class IdnaInfoTest extends TestCase
{
    public function testItCanBeInstantiatedFromArray(): void
    {
        $infos = ['result' => '', 'isTransitionalDifferent' => false, 'errors' => 0];
        $result = IdnaInfo::fromIntl($infos);

        self::assertSame('', $result->result());
        self::assertFalse($result->isTransitionalDifferent());
        self::assertSame(0, $result->errors());
        self::assertNull($result->error(Idna::ERROR_BIDI));
        self::assertSame([Idna::ERROR_NONE => 'No error has occurred'], $result->errorList());
    }

    public function testInvalidSyntaxAfterIDNConversion(): void
    {
        $result = Idna::toAscii('％００.com', Idna::IDNA2008_ASCII);

        self::assertSame(Idna::ERROR_DISALLOWED, $result->errors());
        self::assertIsString($result->error(Idna::ERROR_DISALLOWED));
        self::assertCount(1, $result->errorList());
    }
}
