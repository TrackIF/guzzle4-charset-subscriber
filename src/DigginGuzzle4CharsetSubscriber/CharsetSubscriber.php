<?php
namespace DigginGuzzle4CharsetSubscriber;

use GuzzleHttp\Event\SubscriberInterface;
use GuzzleHttp\Event\CompleteEvent;

use Diggin\Http\Charset\Filter;
use Diggin\Http\Charset\Front\UrlRegex;
use Diggin\Http\Charset\Front\DocumentConverter;

class CharsetSubscriber implements SubscriberInterface
{
    /**
     * @var DocumentConverter
     */
    protected $charsetFront;

    /**
     * {@inheritdoc}
     */
    public function getEvents()
    {
        return [
            'complete' => ['onComplete', 255],
        ];
    }

    public function onComplete(CompleteEvent $event)
    {
        $res = $event->getResponse();
        $contentType = $res->getHeader('content-type');
        $redirect = $res->getHeader('Location');
        if (!empty($redirect) || !preg_match('#^text/html#i', $contentType)) {
            return;
        }
        /** @var GuzzleHttp\Stream\StreamInterface */
        $body = $res->getBody();
        $bodyContent = $this->getCharsetFront()->convert((string)$body, [
            'content-type' => $contentType,
            'url' => $event->getRequest()->getUrl()
        ]);
        $res->setHeader('content-type', Filter::replaceHeaderCharset($contentType));
        $body->seek(0, SEEK_SET);
        $body->write($bodyContent);
    }

    /**
     * @return DocumentConverter
     */
    public function getCharsetFront()
    {
        if (!$this->charsetFront) {
            $this->charsetFront = new UrlRegex;
        }

        return $this->charsetFront;
    }

    public function setCharsetFront(DocumentConverter $charsetFront)
    {
        $this->charsetFront = $charsetFront;
        return $this;
    }
}

