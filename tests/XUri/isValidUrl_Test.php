<?php declare(strict_types=1);
/**
 * HyperPlug
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 *     http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 */
namespace modethirteen\Http\Tests\XUri;

use modethirteen\Http\Tests\PlugTestCase;
use modethirteen\Http\XUri;

class isValidUrl_Test extends PlugTestCase {

    /**
     * @return array
     */
    public static function valid_dataProvider() : array {
        return [
            ['https://google.com?q=foo'],
            ['http://localhost:8080'],
            ['https://localhost'],
            ['ftp://example.com/files'],
            ['https://baz.example.com?qux=baz&a=b#fragment']
        ];
    }

    /**
     * @return array
     */
    public static function invalid_dataProvider() : array {
        return [
            ['localhost'],
            ['foo/bar/baz'],
            ['foo/bar?qux=baz']
        ];
    }

    /**
     * @dataProvider valid_dataProvider
     * @param string $string
     * @test
     */
    public function Is_valid_url(string $string) {

        // act
        $result = XUri::isValidUrl($string);

        // assert
        $this->assertTrue($result);
    }

    /**
     * @dataProvider invalid_dataProvider
     * @param string $string
     * @test
     */
    public function Is_not_valid_url(string $string) {

        // act
        $result = XUri::isValidUrl($string);

        // assert
        $this->assertFalse($result);
    }
}
