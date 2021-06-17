<?php
namespace App\Services;

use Psr\Log\LoggerInterface;
use Knp\Bundle\MarkdownBundle\MarkdownParserInterface;
use Symfony\Contracts\Cache\CacheInterface;

class MarkdownHelper
{
    private $markdownParser;
    private $cache;
    private $logger;
    private $isDebug;
    public function __construct(MarkdownParserInterface $markdownParser, CacheInterface $cache, bool $isDebug, LoggerInterface $mdLogger)
    {
        $this->markdownParser = $markdownParser;
        $this->cache = $cache;
        $this->isDebug = $isDebug;
        $this->logger = $mdLogger;
        dump($isDebug . ' Services');
    }

    public function parse(string $source): string
    {

        if (stripos($source, 'cat') !== false) {
            $this->logger->info('Meow! '. stripos($source, 'cat'));
        }
        if ($this->isDebug) {
            return $this->markdownParser->transformMarkdown($source);
            $this->logger->info("Hello parse");
        }

         return $this->cache->get('markdown_'.md5($source), function() use ($source) {
          return $this->markdownParser->transformMarkdown($source);
          });
    }
}