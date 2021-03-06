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

class toFlattenedArray_Test extends PlugTestCase {

    /**
     * @test
     */
    public function Can_get_array() {

        // arrange
        $headers = new Headers();
        $headers->addHeader('X-Foo', 'bar');
        $headers->addRawHeader('X-Foo: qux, baz');
        $headers->addHeader('Deki-Config', '12345');
        $headers->addHeader('Deki-Stats', null);
        $headers->addHeader('Deki-Database', '');
        $headers->addHeader('Deki-Database', '000');
        $headers->addHeader('Deki-Config', '67890');
        $headers->addHeader('Set-Cookie', 'authtoken=foo');
        $headers->addRawHeader('Set-Cookie: dekisession=765');
        $headers->addRawHeader('Set-Cookie: dekisettings=abc');


        // act
        $results = $headers->toFlattenedArray();

        // assert
        $this->assertCount(5, $results);
        $this->assertArrayHasKeyValue('X-Foo', 'bar, qux, baz', $results);
        $this->assertArrayHasKeyValue('Deki-Config', '12345, 67890', $results);
        $this->assertArrayHasKeyValue('Deki-Stats', '', $results);
        $this->assertArrayHasKeyValue('Deki-Database', '000', $results);
        $this->assertArrayHasKeyValue('Set-Cookie', 'authtoken=foo, dekisession=765, dekisettings=abc', $results);
    }
}
