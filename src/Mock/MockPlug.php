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
namespace modethirteen\Http\Mock;

use modethirteen\Http\Result;

/**
 * Class MockPlug
 *
 * A global HyperPlug interceptor for testing
 *
 * @package modethirteen\Http\Mock
 */
class MockPlug {

    /**
     * @var bool
     */
    public static bool $isRegistered = false;

    /**
     * @var Mock[]
     */
    private static array $mocks = [];

    /**
     * @var array<string, MockRequestMatcher>
     * @structure [ [id] => MockRequestMatcher, ... ]
     */
    private static array $calls = [];

    /**
     * @var int
     */
    private static int $callCount = 0;

    /**
     * @var string[]
     * @structure [ id, ... ]
     */
    private static array $matches = [];

    /**
     * Assert that call to URI has been made
     *
     * @param MockRequestMatcher $request
     * @return bool
     */
    public static function verify(MockRequestMatcher $request) : bool {
        return isset(self::$calls[$request->getMatcherId()]);
    }

    /**
     * Assert that all registered URI's have been called
     *
     * @return bool
     */
    public static function verifyAll() : bool {
        foreach(self::$mocks as $id => $mock) {
            if($mock->verify && !isset(self::$calls[$id])) {
                return false;
            }
        }
        return true;
    }

    /**
     * Assert that at least one call attempt was made
     *
     * @return bool
     */
    public static function verifyCalled() : bool {
        return !empty(self::$calls);
    }

    /**
     * New request and result to mock
     *
     * @param MockRequestMatcher $request
     * @param Result $result
     * @param bool $verify - verify when all registered uri calls are checked
     * @return void
     */
    public static function register(MockRequestMatcher $request, Result $result, bool $verify = true) : void {

        // ensure content type header is set in the same manner as curl will set it
        if($result->getVal('type') === null && $result->getHeaders()->hasHeader('Content-Type')) {
            $result->setVal('type', $result->getHeaders()->getHeaderLine('Content-Type'));
        }
        $mock = new Mock();
        $mock->request = $request;
        $mock->result = $result;
        $mock->verify = $verify;
        self::$mocks[$request->getMatcherId()] = $mock;
        self::$isRegistered = true;
    }

    /**
     * Get mocked response data
     *
     * @param MockRequestMatcher $request
     * @return Result|null
     */
    public static function getResult(MockRequestMatcher $request) : ?Result {
        $id = $request->getMatcherId();

        // log the call
        self::$calls[$id] = $request;
        self::$callCount++;

        // match the mock
        $result = isset(self::$mocks[$id]) ? self::$mocks[$id]->result : null;
        if($result !== null) {

            // log the match
            self::$matches[] = $id;
        }
        return $result;
    }

    /**
     * Get collection of attempted http calls
     *
     * @return MockRequestMatcher[]
     */
    public static function getCalls() : array {
        return self::$calls;
    }

    /**
     * Get a count of how many calls were invoked
     *
     * @return int
     */
    public static function getCallCount() : int {
        return self::$callCount;
    }

    /**
     * Get a collection of registered mocks
     *
     * @return object[]
     */
    public static function getMocks() : array {
        return self::$mocks;
    }

    /**
     * Get collection of attempted http calls with normalized data for reporting
     *
     * @return array
     */
    public static function getNormalizedCallData() : array {
        $calls = [];
        foreach(self::$calls as $id => $request) {
            $call = $request->toNormalizedArray();
            $call['matched'] = in_array($id, self::$matches);
            $calls[$id] = $call;
        }
        return $calls;
    }

    /**
     * Get a collection of mocked http requests with normalized data for reporting
     *
     * @return array
     */
    public static function getNormalizedMockData() : array {
        $mocks = [];
        foreach(self::$mocks as $id => $mock) {
            $request = $mock->request;
            $result = $mock->result;
            $mocks[$id] = [
                'request' => array_merge($request->toNormalizedArray(), [
                    'optional' => !$mock->verify
                ]),
                'result' => $result->toArray()
            ];
        }
        return $mocks;
    }

    /**
     * Reset MockPlug
     *
     * @return void
     */
    public static function deregisterAll() : void {
        self::$mocks = [];
        self::$calls = [];
        self::$callCount = 0;
        self::$matches = [];
        self::$isRegistered = false;
    }
}
