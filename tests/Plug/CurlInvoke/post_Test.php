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
namespace modethirteen\Http\Tests\Plug\CurlInvoke;

use modethirteen\Http\Content\ContentType;
use modethirteen\Http\Content\FileContent;
use modethirteen\Http\Content\JsonContent;
use modethirteen\Http\Content\MultiPartFormDataContent;
use modethirteen\Http\Content\TextContent;
use modethirteen\Http\Content\UrlEncodedFormDataContent;
use modethirteen\Http\Content\XmlContent;
use modethirteen\Http\Plug;
use modethirteen\Http\Tests\PlugTestCase;

class post_Test extends PlugTestCase  {

    /**
     * @test
     */
    public function Can_invoke_post() {

        // arrange
        $plug = $this->newHttpBinPlug()->at('anything');

        // act
        $result = $plug->post();

        // assert
        $this->assertEquals(200, $result->getStatus());
        $this->assertEquals(Plug::METHOD_POST, $result->getBody()->getVal('method'));
    }

    /**
     * @test
     */
    public function Can_invoke_post_with_text_contet() {

        // arrange
        $plug = $this->newHttpBinPlug()->at('anything');

        // act
        $result = $plug->post(new TextContent('foo'));

        // assert
        $this->assertEquals(200, $result->getStatus());
        $body = $result->getBody();
        $this->assertEquals(ContentType::TEXT, $body->getVal('headers/Content-Type'));
        $this->assertEquals('3', $body->getVal('headers/Content-Length'));
        $this->assertEquals('foo', $body->getVal('data'));
    }

    /**
     * @test
     */
    public function Can_invoke_post_with_empty_content() {

        // arrange
        $plug = $this->newHttpBinPlug()->at('anything');

        // act
        $result = $plug->post(new TextContent(''));

        // assert
        $this->assertEquals(200, $result->getStatus());
        $body = $result->getBody();
        $this->assertEquals(ContentType::TEXT, $body->getVal('headers/Content-Type'));
        $this->assertEquals('0', $body->getVal('headers/Content-Length'));
        $this->assertEquals('', $body->getVal('data'));
    }

    /**
     * @test
     */
    public function Can_invoke_post_with_file_content() {

        // arrange
        $plug = $this->newHttpBinPlug()->at('anything');
        $filePath = dirname(__FILE__) . '/file.png';

        // act
        $result = $plug->post(new FileContent($filePath));

        // assert
        $this->assertEquals(200, $result->getStatus());
        $body = $result->getBody();
        $this->assertEquals('image/png; charset=binary', $body->getVal('headers/Content-Type'));
        $this->assertEquals(<<<TEXT
data:application/octet-stream;base64,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
TEXT
, $body->getVal('data'));
        $this->assertEquals('100-continue', $body->getVal('headers/Expect'));
        $this->assertEquals('1642', $body->getVal('headers/Content-Length'));
    }

    /**
     * @test
     */
    public function Can_invoke_post_with_urlencoded_form_data_content() {

        // arrange
        $plug = $this->newHttpBinPlug()->at('anything');

        // act
        $result = $plug->post(new UrlEncodedFormDataContent([
            'foo' => 'bar',
            'baz' => 'qux'
        ]));

        // assert
        $this->assertEquals(200, $result->getStatus());
        $body = $result->getBody();
        $this->assertStringStartsWith('application/x-www-form-urlencoded', $body->getString('headers/Content-Type'));
        $this->assertEquals('15', $body->getVal('headers/Content-Length'));
        $this->assertEquals(['foo' => 'bar', 'baz' => 'qux'], $body->getVal('form'));
    }

    /**
     * @test
     */
    public function Can_invoke_post_with_multipart_form_data_content() {

        // arrange
        $plug = $this->newHttpBinPlug()->at('anything');

        // act
        $result = $plug->post(new MultiPartFormDataContent([
            'foo' => 'bar',
            'baz' => 'qux'
        ]));

        // assert
        $this->assertEquals(200, $result->getStatus());
        $body = $result->getBody();
        $this->assertStringStartsWith('multipart/form-data', $body->getString('headers/Content-Type'));
        $this->assertEquals('236', $body->getVal('headers/Content-Length'));

        // NOTE (modethirteen, 20201213): this header appears not to be returned from httpbin any longer
        //$this->assertEquals('100-continue', $body->getVal('headers/Expect'));
        $this->assertEquals(['foo' => 'bar', 'baz' => 'qux'], $body->getVal('form'));
    }

    /**
     * @test
     */
    public function Can_invoke_post_with_multipart_form_data_content_with_file_content() {

        // arrange
        $plug = $this->newHttpBinPlug()->at('anything');
        $filePath1 = dirname(__FILE__) . '/file.png';
        $filePath2 = dirname(__FILE__) . '/file.txt';

        // act
        $content = new MultiPartFormDataContent([
            'foo' => 'bar',
            'baz' => 'qux'
        ]);
        $result = $plug->post($content
            ->withFileContent(new FileContent($filePath1))
            ->withFileContent(new FileContent($filePath2))
        );

        // assert
        $this->assertEquals(200, $result->getStatus());
        $body = $result->getBody();
        $this->assertStringStartsWith('multipart/form-data', $body->getString('headers/Content-Type'));
        $this->assertEquals('100-continue', $body->getVal('headers/Expect'));
        $this->assertEquals(['foo' => 'bar', 'baz' => 'qux'], $body->getVal('form'));
        $this->assertStringStartsWith('data:image/png; charset=binary;base64,', $body->getString('files/file[0]'));
        $this->assertEquals('foo bar baz', $body->getVal('files/file[1]'));
    }

    /**
     * @test
     */
    public function Can_invoke_post_with_json_content() {

        // arrange
        $plug = $this->newHttpBinPlug()->at('anything');

        // act
        $result = $plug->post(JsonContent::newFromArray([
            'foo' => 'bar',
            'baz' => [
                'qux',
                'quxx',
                'fred'
            ]
        ]));

        // assert
        $this->assertEquals(200, $result->getStatus());
        $body = $result->getBody();
        $this->assertEquals(ContentType::JSON, $body->getVal('headers/Content-Type'));
        $this->assertEquals('41', $body->getVal('headers/Content-Length'));
        $this->assertEquals('{"foo":"bar","baz":["qux","quxx","fred"]}', $body->getVal('data'));
    }

    /**
     * @test
     */
    public function Can_invoke_post_with_xml_content() {

        // arrange
        $plug = $this->newHttpBinPlug()->at('anything');

        // act
        $result = $plug->post(XmlContent::newFromArray([
            'foo' => [
                '@id' => '123',
                '@baz' => 'qux',
                'baz' => [
                    '#text' => 'fred',
                    '@foo' => 'abc'
                ]
            ]
        ]));

        // assert
        $this->assertEquals(200, $result->getStatus());
        $body = $result->getBody();
        $this->assertEquals(ContentType::XML, $body->getVal('headers/Content-Type'));
        $this->assertEquals('55', $body->getVal('headers/Content-Length'));
        $this->assertEquals('<foo id="123" baz="qux"><baz foo="abc">fred</baz></foo>', $body->getVal('data'));
    }
}
