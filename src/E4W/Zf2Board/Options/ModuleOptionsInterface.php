<?php

/**
 * THIS SOFTWARE IS PROVIDED BY THE COPYRIGHT HOLDERS AND CONTRIBUTORS
 * "AS IS" AND ANY EXPRESS OR IMPLIED WARRANTIES, INCLUDING, BUT NOT
 * LIMITED TO, THE IMPLIED WARRANTIES OF MERCHANTABILITY AND FITNESS FOR
 * A PARTICULAR PURPOSE ARE DISCLAIMED. IN NO EVENT SHALL THE COPYRIGHT
 * OWNER OR CONTRIBUTORS BE LIABLE FOR ANY DIRECT, INDIRECT, INCIDENTAL,
 * SPECIAL, EXEMPLARY, OR CONSEQUENTIAL DAMAGES (INCLUDING, BUT NOT
 * LIMITED TO, PROCUREMENT OF SUBSTITUTE GOODS OR SERVICES; LOSS OF USE,
 * DATA, OR PROFITS; OR BUSINESS INTERRUPTION) HOWEVER CAUSED AND ON ANY
 * THEORY OF LIABILITY, WHETHER IN CONTRACT, STRICT LIABILITY, OR TORT
 * (INCLUDING NEGLIGENCE OR OTHERWISE) ARISING IN ANY WAY OUT OF THE USE
 * OF THIS SOFTWARE, EVEN IF ADVISED OF THE POSSIBILITY OF SUCH DAMAGE.
 *
 * This software consists of voluntary contributions made by many individuals
 * and is licensed under the MIT license.
 */

namespace E4W\Zf2Board\Options;

use Zend\Stdlib\AbstractOptions;

interface ModuleOptionsInterface
{
    /**
     * @return string
     */
    public function getBoardEntity();

    /**
     * @return \E4W\Zf2Board\Mapper\BoardMapperInterface
     */
    public function getBoardMapper();

    /**
     * @return string
     */
    public function getTopicEntity();

    /**
     * @return \E4W\Zf2Board\Mapper\TopicMapperInterface
     */
    public function getTopicMapper();

    /**
     * @return string
     */
    public function getPostEntity();

    /**
     * @return \E4W\Zf2Board\Mapper\PostMapperInterface
     */
    public function getPostMapper();

    /**
     * @return string
     */
    public function getAuthorEntity();

    /**
     * @return \E4W\Zf2Board\Mapper\AuthorMapperInterface
     */
    public function getAuthorMapper();
}
