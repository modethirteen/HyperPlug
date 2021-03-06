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
namespace modethirteen\Http\Tests\Headers;

use modethirteen\Http\Headers;
use modethirteen\Http\Tests\PlugTestCase;

class toRawHeaders_Test extends PlugTestCase {

    /**
     * @test
     */
    public function Can_get_headers() {

        // arrange
        $headers = new Headers();
        $headers->addHeader('X-Foo', 'bar');
        $headers->addRawHeader('X-Foo: qux, baz');
        $headers->addHeader('Deki-Config', '12345');
        $headers->addHeader('Deki-Stats', null);
        $headers->addHeader('Deki-DataBASE', '');
        $headers->addHeader('Deki-Database', '000');
        $headers->addHeader('Deki-Config', '67890');
        $headers->addRawHeader('SET-Cookie: dekisession=765');

        // act
        $results = $headers->toRawHeaders();

        // assert
        $this->assertCount(5, $results);
        $this->assertEquals([
            'X-Foo: bar, qux, baz',
            'Deki-Config: 12345, 67890',
            'Deki-Stats:',
            'Deki-Database: 000',
            'Set-Cookie: dekisession=765'
        ], $results);
    }

    /**
     * @test
     */
    public function Can_get_multiple_set_cookie_headers() {

        // arrange
        $headers = new Headers();
        $headers->addHeader('Set-Cookie', 'foo');
        $headers->addHeader('Set-Cookie', 'bar');
        $headers->addHeader('Set-Cookie', 'baz');

        // act
        $results = $headers->toRawHeaders();

        // assert
        $this->assertCount(3, $results);
        $this->assertEquals([
            'Set-Cookie: foo',
            'Set-Cookie: bar',
            'Set-Cookie: baz'
        ], $results);
    }
}
