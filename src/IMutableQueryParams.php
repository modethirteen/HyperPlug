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

interface IMutableQueryParams extends IQueryParams {

    /**
     * Add or set query parameters from an instance
     *
     * @param IQueryParams $params
     */
    function addQueryParams(IQueryParams $params) : void;

    /**
     * Set a query parameter value in the collection
     *
     * @param string $param
     * @param mixed|null $value - null will remove param from collection
     */
    function set(string $param, $value) : void;
}
