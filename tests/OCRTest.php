<?php
/**
 * This file is part of ledgr/billing.
 *
 * Copyright (c) 2012-14 Hannes Forsgård
 *
 * ledgr/billing is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * ledgr/billing is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with ledgr/billing.  If not, see <http://www.gnu.org/licenses/>.
 */

namespace ledgr\billing;

class OCRTest extends \PHPUnit_Framework_TestCase
{
    public function testCreate()
    {
        $this->assertEquals('12345682', (string)OCR::create('123456'));
    }

    /**
     * @expectedException ledgr\billing\Exception\InvalidStructureException
     */
    public function testCreateInvalidLength()
    {
        OCR::create('123456789012345678901234');
    }

    /**
     * @expectedException ledgr\billing\Exception\InvalidStructureException
     */
    public function testCreateNotNumeric()
    {
        OCR::create('123L');
    }

    public function testSetGet()
    {
        $o = new OCR('12345682');
        $this->assertSame('12345682', $o->getOCR());
        $this->assertSame('12345682', (string)$o);

        $o = new OCR('12345682');
        $this->assertSame('12345682', $o->getOCR());
        $this->assertSame('12345682', (string)$o);
    }

    public function invalidStructuresProvider()
    {
        return array(
            array(123),
            array('a'),
            array('1'),
            array('12345678901234567890123456'),
        );
    }

    /**
     * @expectedException ledgr\billing\Exception\InvalidStructureException
     * @dataProvider invalidStructuresProvider
     */
    public function testSetInvalidStructure($ocr)
    {
        new OCR($ocr);
    }

    /**
     * @expectedException ledgr\billing\Exception\InvalidLengthDigitException
     */
    public function testSetInvalidLengthDigit()
    {
        new OCR('12345602');
    }

    /**
     * @expectedException ledgr\billing\Exception\InvalidCheckDigitException
     */
    public function testSetInvalidCheckDigit()
    {
        new OCR('12345680');
    }
}
