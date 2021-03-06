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
namespace modethirteen\Http\Tests\Content\ContentType;

use modethirteen\Http\Content\ContentType;
use modethirteen\Http\Tests\PlugTestCase;

class isPlainText_Test extends PlugTestCase {

    /**
     * @return array
     */
    public static function headerLine_expected_dataProvider() : array {
        return [
            ['application/x-latex', false],
            ['image/x-cmu-raster', false],
            ['application/base64', false],
            ['application/vnd.hp-hpgl', false],
            ['text/xml', false],
            ['application/wordperfect', false],
            ['image/pjpeg', false],
            ['application/json', false],
            ['audio/make', false],
            ['image/naplps', false],
            ['application/freeloader', false],
            ['application/octet-stream', false],
            ['text/json', false],
            ['application/xml', false],
            ['text/plain', true]
        ];
    }


    /**
     * @dataProvider headerLine_expected_dataProvider
     * @param string $headerLine
     * @param bool $expected
     * @test
     */
    public function Can_check_if_content_type_is_plain_text(string $headerLine, bool $expected) {

        // arrange
        $contentType = ContentType::newFromString($headerLine);

        // act
        $result = $contentType->isPlainText();

        // assert
        $this->assertEquals($expected, $result);
    }
}
