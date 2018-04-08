<?php
/**
 * Created by PhpStorm.
 * User: dmtr
 * Date: 03.03.18
 * Time: 17:16
 */

namespace Framework\Router;


use Psr\Http\Message\ServerRequestInterface;

class Route
{
    /**
     * @var string
     */
    protected $name;

    /**
     * @var string
     */
    protected $path;

    /**
     * @var string|callable
     */
    protected $callable;

    /**
     * @var string
     */
    protected $host;

    /**
     * @var string
     */
    protected $scheme;

    /**
     * @var string[]
     */
    protected $methods = [];

    /**
     * @var string[]
     */
    protected $tokens = [];

    /**
     * @var array
     */
    protected $attributes = [];

    public function __construct($name, $path, $callable)
    {
        $this->name = $name;
        $this->path = $path;
        $this->callable = $callable;
    }

    public function match(ServerRequestInterface $request): ?Result
    {
        if ($this->methods && !\in_array($request->getMethod(), $this->methods, true)) {
            return null;
        }

        $pattern = preg_replace_callback('~\{([^\}]+)\}~', function ($matches) {
            $argument = $matches[1];
            $replace = $this->tokens[$argument] ?? '[^}]+';
            return '(?P<' . $argument . '>' . $replace . ')';
        }, $this->path);

        $path = $request->getUri()->getPath();

        if (!preg_match('~^' . $pattern . '$~i', $path, $matches)) {
            return null;
        }

        $arguments = array_filter($matches, '\is_string', ARRAY_FILTER_USE_KEY);

        $arguments = array_merge($arguments, $this->getAttributes());

        return new Result($this->name, $this->callable, $arguments);
    }

    public function generate(string $name, array $params = []): ?string
    {
        $arguments = array_filter($params);

        if ($name !== $this->name) {
            return null;
        }

        $url = preg_replace_callback('~\{([^\}]+)\}~', function ($matches) use (&$arguments) {
            $argument = $matches[1];
            if (!array_key_exists($argument, $arguments)) {
                throw new \InvalidArgumentException('Missing parameter "' . $argument . '"');
            }
            return $arguments[$argument];
        }, $this->path);

        return $url;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param string $name
     * @return Route
     */
    public function setName(string $name): Route
    {
        $this->name = $name;
        return $this;
    }

    /**
     * @return string
     */
    public function getPath(): string
    {
        return $this->path;
    }

    /**
     * @param string $path
     * @return Route
     */
    public function setPath(string $path): Route
    {
        $this->path = $path;
        return $this;
    }

    /**
     * @return callable|string
     */
    public function getCallable()
    {
        return $this->callable;
    }

    /**
     * @param callable|string $callable
     * @return Route
     */
    public function setCallable($callable)
    {
        $this->callable = $callable;
        return $this;
    }

    /**
     * @return string
     */
    public function getHost(): string
    {
        return $this->host;
    }

    /**
     * @param string $host
     * @return Route
     */
    public function setHost(string $host): Route
    {
        $this->host = $host;
        return $this;
    }

    /**
     * @return string
     */
    public function getScheme(): string
    {
        return $this->scheme;
    }

    /**
     * @param string $scheme
     * @return Route
     */
    public function setScheme(string $scheme): Route
    {
        $this->scheme = $scheme;
        return $this;
    }

    /**
     * @return string[]
     */
    public function getMethods(): array
    {
        return $this->methods;
    }

    /**
     * @param string[] $methods
     * @return Route
     */
    public function setMethods(array $methods): Route
    {
        $this->methods = $methods;
        return $this;
    }

    /**
     * @return string[]
     */
    public function getTokens(): array
    {
        return $this->tokens;
    }

    /**
     * @param string[] $tokens
     * @return Route
     */
    public function setTokens(array $tokens): Route
    {
        $this->tokens = $tokens;
        return $this;
    }

    /**
     * @return array
     */
    public function getAttributes(): array
    {
        return $this->attributes;
    }

    /**
     * @param array $attributes
     * @return Route
     */
    public function setAttributes(array $attributes): Route
    {
        $this->attributes = $attributes;
        return $this;
    }

    /**
     * @param string $key
     * @param mixed $value
     * @return Route
     */
    public function addAttribute(string $key, $value): Route
    {
        $this->attributes[$key] = $value;
        return $this;
    }
}