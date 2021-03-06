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
namespace modethirteen\Http;

/**
 * Interface IMutableHeaders
 *
 * @package modethirteen\Http
 */
interface IMutableHeaders extends IHeaders {

    /**
     * Set or add values from an HTTP headers collection
     *
     * @param IHeaders $headers
     * @return void
     */
    function addHeaders(IHeaders $headers) : void;

    /**
     * Set or add value to an HTTP header
     *
     * @param string $name
     * @param mixed $value
     * @return void
     */
    function addHeader(string $name, $value) : void;

    /**
     * Set or replace value on an HTTP header
     *
     * @param string $name
     * @param mixed $value
     * @return void
     */
    function setHeader(string $name, $value) : void;

    /**
     * Set or add header value(s) with a raw HTTP header
     *
     * @param string $header - 'name: value, ...'
     * @return void
     */
    function addRawHeader(string $header) : void;

    /**
     * Set or replace header value(s) with a raw HTTP header
     *
     * @param string $header - 'name: value, ...'
     * @return void
     */
    function setRawHeader(string $header) : void;

    /**
     * Remove an HTTP header and all its values
     *
     * @param string $name
     * @return void
     */
    function removeHeader(string $name) : void;
}
