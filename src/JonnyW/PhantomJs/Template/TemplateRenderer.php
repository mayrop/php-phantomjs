<?php

/*
 * This file is part of the php-phantomjs.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace JonnyW\PhantomJs\Template;

use JonnyW\PhantomJs\Cache\CacheInterface;

/**
 * PHP PhantomJs
 *
 * @author Jon Wenmoth <contact@jonnyw.me>
 */
class TemplateRenderer implements TemplateRendererInterface
{
    /**
     * Twig environment instance.
     *
     * @var \Twig_Environment
     * @access protected
     */
    protected $twig;

    /**
     * Cache handler.
     *
     * @var \JonnyW\PhantomJs\Cache\CacheInterface
     * @access protected
     */
    protected $cacheHandler;

    /**
     * Internal constructor.
     *
     * @access public
     * @param \Twig_Environment $twig
     */
    public function __construct(\Twig_Environment $twig, CacheInterface $cacheHandler)
    {
        $this->twig = $twig;
        $this->cacheHandler = $cacheHandler;
    }

    /**
     * Render template.
     *
     * @access public
     * @param  string $template
     * @param  array  $context  (default: array())
     * @return string
     */
    public function render($template, array $context = array())
    {
        $hash = hash('md5', $template);
        $file = $hash . '.twig';

        if (!$this->cacheHandler->exists($file)) {
            $this->cacheHandler->save($file, $template);
        }

        return $this->twig->render($file, $context);
    }
}
