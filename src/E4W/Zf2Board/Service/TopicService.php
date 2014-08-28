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

namespace E4W\Zf2Board\Service;

use E4W\Zf2Board\Entity\BoardInterface;
use E4W\Zf2Board\Entity\TopicInterface;
use E4W\Zf2Board\Entity\UserInterface;
use E4W\Zf2Board\Mapper\TopicMapperInterface;
use Zend\EventManager\EventManagerAwareInterface;
use Zend\EventManager\EventManagerAwareTrait;

class TopicService implements EventManagerAwareInterface
{
    use EventManagerAwareTrait;
    
    /** @var TopicMapperInterface */
    protected $boardMapper;

    protected $topicCreateForm;

    public function __construct(TopicMapperInterface $topicMapper, $topicCreateForm)
    {
        $this->topicMapper = $topicMapper;
        $this->topicCreateForm = $topicCreateForm;
    }

    /**
     * @param int $id
     * @return TopicInterface
     */
    public function find($id)
    {
        return $this->boardMapper->find($id);
    }

    /**
     * @return TopicInterface[]
     */
    public function findAll()
    {
        return $this->boardMapper->findAll();
    }

    /**
     * @param $id
     * @return boolean
     */
    public function delete($id)
    {
        return $this->boardMapper->delete($id);
    }

    /**
     * @param array $data
     * @param BoardInterface $board
     * @param UserInterface $user
     * @return \E4W\Zf2Board\Entity\TopicInterface|null
     */
    public function create(array $data, BoardInterface $board, UserInterface $user)
    {
        $form = $this->topicCreateForm;
        $form->setData($data);

        return $this->boardMapper->create($form, $board, $user);
    }
}
