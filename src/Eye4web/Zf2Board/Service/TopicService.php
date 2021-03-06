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

namespace Eye4web\Zf2Board\Service;

use Eye4web\Zf2Board\Entity\BoardInterface;
use Eye4web\Zf2Board\Entity\TopicInterface;
use Eye4web\Zf2Board\Entity\UserInterface;
use Eye4web\Zf2Board\Mapper\TopicMapperInterface;
use Zend\EventManager\EventManagerAwareInterface;
use Zend\EventManager\EventManagerAwareTrait;

class TopicService implements EventManagerAwareInterface
{
    use EventManagerAwareTrait;
    
    /** @var TopicMapperInterface */
    protected $topicMapper;

    /** @var \Zend\Form\Form */
    protected $topicCreateForm;

    /**
     * @var PostService
     */
    private $postService;

    /**
     * @param TopicMapperInterface $topicMapper
     * @param $topicCreateForm
     * @param PostService $postService
     */
    public function __construct(TopicMapperInterface $topicMapper, $topicCreateForm, PostService $postService)
    {
        $this->topicMapper = $topicMapper;
        $this->topicCreateForm = $topicCreateForm;
        $this->postService = $postService;
    }

    /**
     * @param int $id
     * @return TopicInterface
     */
    public function find($id)
    {
        return $this->topicMapper->find($id);
    }

    /**
     * @return TopicInterface[]
     */
    public function findAll()
    {
        return $this->topicMapper->findAll();
    }

    /**
     * @param int $id
     * @return \Eye4web\Zf2Board\Entity\TopicInterface[]
     */
    public function findByBoard($id)
    {
        return $this->topicMapper->findByBoard($id);
    }

    /**
     * @param $id
     */
    public function delete($id)
    {
        $this->getEventManager()->trigger('create.pre', $this, [
            'topic' => $id
        ]);

        $this->topicMapper->delete($id);

        $this->getEventManager()->trigger('create.post', $this, [
            'topic' => $id
        ]);
    }

    /**
     * @param $id
     */
    public function lock($id)
    {
        $this->getEventManager()->trigger('lock.pre', $this, [
            'topic' => $id
        ]);

        $this->topicMapper->lock($id);

        $this->getEventManager()->trigger('lock.post', $this, [
            'topic' => $id
        ]);
    }

    /**
     * @param $id
     */
    public function unlock($id)
    {
        $this->getEventManager()->trigger('unlock.pre', $this, [
            'topic' => $id
        ]);

        $this->topicMapper->unlock($id);

        $this->getEventManager()->trigger('unlock.post', $this, [
            'topic' => $id
        ]);
    }

    /**
     * @param $id
     */
    public function pin($id)
    {
        $this->getEventManager()->trigger('pin.pre', $this, [
            'topic' => $id
        ]);

        $this->topicMapper->unlock($id);

        $this->getEventManager()->trigger('pin.post', $this, [
            'topic' => $id
        ]);
    }

    /**
     * @param $id
     */
    public function unpin($id)
    {
        $this->getEventManager()->trigger('unpin.pre', $this, [
            'topic' => $id
        ]);

        $this->topicMapper->unpin($id);

        $this->getEventManager()->trigger('unpin.post', $this, [
            'topic' => $id
        ]);
    }

    /**
     * @param array $data
     * @param BoardInterface $board
     * @param UserInterface $user
     * @return \Eye4web\Zf2Board\Entity\TopicInterface|null
     */
    public function create(array $data, BoardInterface $board, UserInterface $user)
    {
        $form = $this->topicCreateForm;
        $form->setData($data);

        $this->getEventManager()->trigger('create.pre', $this, [
            'data' => $data,
            'board' => $board,
            'user' => $user,
        ]);

        $topic = $this->topicMapper->create($form, $board, $user);

        if (!$topic) {
            return false;
        }

        $post = $this->postService->create($data, $topic, $user);

        $this->getEventManager()->trigger('create.post', $this, [
            'data' => $data,
            'board' => $board,
            'user' => $user,
            'topic' => $topic,
            'post' => $post,
        ]);

        return $topic;
    }

    /**
     * @param array $data
     * @param TopicInterface $topic
     * @return bool|TopicInterface
     */
    public function edit(array $data, TopicInterface $topic)
    {
        $form = $this->topicCreateForm;
        $form->bind($topic);

        $form->setData($data);

        $form->remove('csrf');
        $form->getInputFilter()->remove('csrf');

        return $this->topicMapper->edit($form);
    }
}
