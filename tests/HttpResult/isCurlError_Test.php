<?php declare(strict_types=1);
/**
 * HttpPlug
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
namespace modethirteen\Http\Tests\HttpResult;

use modethirteen\Http\HttpResult;
use modethirteen\Http\Tests\HttpPlugTestCase;

class isCurlError_Test extends HttpPlugTestCase  {

    /**
     * @test
     */
    public function Is_curl_error() {

        // arrange
        $data = [
            'status' => 302,
            'errno' => 47
        ];
        $result = new HttpResult($data);

        // act
        $isCurlError = $result->isCurlError();

        // assert
        $this->assertTrue($isCurlError);
    }

    /**
     * @test
     */
    public function Is_not_curl_error() {

        // arrange
        $data = [
            'status' => 302,
            'errno' => 0
        ];
        $result = new HttpResult($data);

        // act
        $isCurlError = $result->isRequestError();

        // assert
        $this->assertFalse($isCurlError);
    }
}