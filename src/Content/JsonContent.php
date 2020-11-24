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
namespace modethirteen\Http\Content;

/**
 * Class JsonContent
 *
 * @package modethirteen\Http\Content
 */
class JsonContent implements IContent {

    /**
     * Return an instance from a JSON encoded array
     *
     * @param array $json
     * @return static
     */
    public static function newFromArray(array $json) : object {
        return new static(json_encode($json));
    }

    /**
     * @var ContentType|null
     */
    private $contentType;

    /**
     * @var string
     */
    private $json;

    /**
     * @param string $json
     */
    public function __construct(string $json) {
        $this->contentType = ContentType::newFromString(ContentType::JSON);
        $this->json = $json;
    }

    public function __clone() {

        // deep copy internal data objects and arrays
        $this->contentType = unserialize(serialize($this->contentType));
    }

    public function getContentType() : ?ContentType {
        return $this->contentType;
    }

    public function toRaw() : string {
        return $this->json;
    }

    public function toString() : string {
        return $this->json;
    }

    public function __toString() : string {
        return $this->toString();
    }
}