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
namespace modethirteen\Http\Tests\Plug;

use modethirteen\Http\Plug;
use modethirteen\Http\Tests\PlugTestCase;
use modethirteen\Http\XUri;

class withUri_Test extends PlugTestCase  {

    /**
     * @test
     */
    public function Can_get_instance_with_new_uri() {

        // arrange
        $plug1 = new Plug(XUri::tryParse('http://foo.com/bar/baz?a=b&c=d'));
        $plug2 = $plug1->withUri(XUri::tryParse('http://bar.com/qux'));

        // act
        $result1 = $plug1->getUri();
        $result2 = $plug2->getUri();

        // assert
        $this->assertEquals('http://foo.com/bar/baz?a=b&c=d', $result1);
        $this->assertEquals('http://bar.com/qux', $result2);
    }

    /**
     * @test
     */
    public function Can_get_instance_with_new_uri_with_preserved_host() {

        // arrange
        $plug1 = new Plug(XUri::tryParse('http://foo.com/bar/baz?a=b&c=d'));
        $plug2 = $plug1->withUri(XUri::tryParse('http://bar.com/qux'), true);

        // act
        $result1 = $plug1->getUri();
        $result2 = $plug2->getUri();

        // assert
        $this->assertEquals('http://foo.com/bar/baz?a=b&c=d', $result1);
        $this->assertEquals('http://foo.com/qux', $result2);
    }
}
