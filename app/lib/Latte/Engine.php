<?php

/**
 * This file is part of the Latte (https://latte.nette.org)
 * Copyright (c) 2008 David Grudl (https://davidgrudl.com)
 */

namespace Latte;


/**
 * Templating engine Latte.
 */
class Engine extends Object
{
	const VERSION = '2.3.7';
public $publicvars = array();
    private $tags = array('a', 'img', 'link', 'script', 'input', 'object', 'embed');
public $tpl_dir = "";
public $baseurl = "";
public $pathreplace = true;
	/** Content types */
	const CONTENT_HTML = 'html',
		CONTENT_XHTML = 'xhtml',
		CONTENT_XML = 'xml',
		CONTENT_JS = 'js',
		CONTENT_CSS = 'css',
		CONTENT_URL = 'url',
		CONTENT_ICAL = 'ical',
		CONTENT_TEXT = 'text';

	/** @var callable[] */
	public $onCompile = array();

	/** @var Parser */
	private $parser;
	/** @var Compiler */
	private $compiler;

	/** @var ILoader */
	private $loader;

	/** @var string */
	private $contentType = self::CONTENT_HTML;

	/** @var string */
	private $tempDirectory;

	/** @var bool */
	private $autoRefresh = TRUE;

	/** @var array run-time filters */
	private $filters = array(
		NULL => array(), // dynamic
		'bytes' => 'Latte\Runtime\Filters::bytes',
		'capitalize' => 'Latte\Runtime\Filters::capitalize',
		'datastream' => 'Latte\Runtime\Filters::dataStream',
		'date' => 'Latte\Runtime\Filters::date',
		'escapecss' => 'Latte\Runtime\Filters::escapeCss',
		'escapehtml' => 'Latte\Runtime\Filters::escapeHtml',
		'escapehtmlcomment' => 'Latte\Runtime\Filters::escapeHtmlComment',
		'escapeical' => 'Latte\Runtime\Filters::escapeICal',
		'escapejs' => 'Latte\Runtime\Filters::escapeJs',
		'escapeurl' => 'rawurlencode',
		'escapexml' => 'Latte\Runtime\Filters::escapeXML',
		'firstupper' => 'Latte\Runtime\Filters::firstUpper',
		'implode' => 'implode',
		'indent' => 'Latte\Runtime\Filters::indent',
		'lower' => 'Latte\Runtime\Filters::lower',
		'nl2br' => 'Latte\Runtime\Filters::nl2br',
		'number' => 'number_format',
		'repeat' => 'str_repeat',
		'replace' => 'Latte\Runtime\Filters::replace',
		'replacere' => 'Latte\Runtime\Filters::replaceRe',
		'safeurl' => 'Latte\Runtime\Filters::safeUrl',
		'strip' => 'Latte\Runtime\Filters::strip',
		'striptags' => 'strip_tags',
		'substr' => 'Latte\Runtime\Filters::substring',
		'trim' => 'Latte\Runtime\Filters::trim',
		'truncate' => 'Latte\Runtime\Filters::truncate',
		'indentindent' => 'Latte\Engine::PathReplace',
		'upper' => 'Latte\Runtime\Filters::upper',
	);


	/**
	 * Renders template to output.
	 * @return void
	 */
	public function render($name, array $params = array())
	{
	$params = array_merge($this->publicvars,$params );
		$class = $this->getTemplateClass($name);
		if (!class_exists($class, FALSE)) {
			if ($this->tempDirectory) {
				$this->loadTemplateFromCache($name);
			} else {
				$this->loadTemplate($name);
			}
		}

		$template = new $class($params, $this, $name);
		$template->render();
	}


	/**
	 * Renders template to string.
	 * @return string
	 */
	public function renderToString($name, array $params = array())
	{
	$params = array_merge($this->publicvars,$params );
		ob_start();
		try {
			$this->render($name, $params);
		} catch (\Exception $e) {
			ob_end_clean();
			throw $e;
		}
		return ob_get_clean();
	}


	/**
	 * Compiles template to PHP code.
	 * @return string
	 */
	public function compile($name)
	{
		foreach ($this->onCompile ?: array() as $cb) {
			call_user_func(Helpers::checkCallback($cb), $this);
		}
		$this->onCompile = array();

		$source = $this->getLoader()->getContent($name);

		try {
			$tokens = $this->getParser()->setContentType($this->contentType)
				->parse($source);

			$code = $this->getCompiler()->setContentType($this->contentType)
				->compile($tokens, $this->getTemplateClass($name));

		} catch (\Exception $e) {
			if (!$e instanceof CompileException) {
				$e = new CompileException("Thrown exception '{$e->getMessage()}'", NULL, $e);
			}
			$line = isset($tokens) ? $this->getCompiler()->getLine() : $this->getParser()->getLine();
			throw $e->setSource($source, $line, $name);
		}

		if (!preg_match('#\n|\?#', $name)) {
			$code = "<?php\n// source: $name\n?>" . $code;
		}
		if($this->pathreplace === true) $code = $this->PathReplace($code);
		$code = Helpers::optimizePhp($code);
		return $code;
	}

    public function PathReplace($code){
        $tpl_dir = $this->tpl_dir;
        $template_basedir = "";
        $basecode = $this->baseurl;
        
        // set variables
        $html = $code;
        $tags = $this->tags;


        // get the template base directory
        $template_directory = $basecode . $tpl_dir ;

        // reduce the path
        $path = str_replace( "://", "@not_replace@", $template_directory );
        $path = preg_replace( "#(/+)#", "/", $path );
        $path = preg_replace( "#(/\./+)#", "/", $path );
        $path = str_replace( "@not_replace@", "://", $path );

        while( preg_match( '#\.\./#', $path ) ){
            $path = preg_replace('#\w+/\.\./#', '', $path );
        }


        $exp = $sub = array();

        if( in_array( "img", $tags ) ){
            $exp = array( '/<img(.*?)src=(?:")(http|https)\:\/\/([^"]+?)(?:")/i', '/<img(.*?)src=(?:")([^"]+?)#(?:")/i', '/<img(.*?)src="(.*?)"/', '/<img(.*?)src=(?:\@)([^"]+?)(?:\@)/i' );
            $sub = array( '<img$1src=@$2://$3@', '<img$1src=@$2@', '<img$1src="' . $path . '$2"', '<img$1src="$2"' );
        }

        if( in_array( "script", $tags ) ){
            $exp = array_merge( $exp , array( '/<script(.*?)src=(?:")(http|https)\:\/\/([^"]+?)(?:")/i', '/<script(.*?)src=(?:")([^"]+?)#(?:")/i', '/<script(.*?)src="(.*?)"/', '/<script(.*?)src=(?:\@)([^"]+?)(?:\@)/i' ) );
            $sub = array_merge( $sub , array( '<script$1src=@$2://$3@', '<script$1src=@$2@', '<script$1src="' . $path . '$2"', '<script$1src="$2"' ) );
        }

        if( in_array( "link", $tags ) ){
            $exp = array_merge( $exp , array( '/<link(.*?)href=(?:")(http|https)\:\/\/([^"]+?)(?:")/i', '/<link(.*?)href=(?:")([^"]+?)#(?:")/i', '/<link(.*?)href="(.*?)"/', '/<link(.*?)href=(?:\@)([^"]+?)(?:\@)/i' ) );
            $sub = array_merge( $sub , array( '<link$1href=@$2://$3@', '<link$1href=@$2@' , '<link$1href="' . $path . '$2"', '<link$1href="$2"' ) );
        }

        if( in_array( "a", $tags ) ){
            $exp = array_merge( $exp , array( '/<a(.*?)href=(?:")(http:\/\/|https:\/\/|javascript:|mailto:|\/|{)([^"]+?)(?:")/i','/<a(.*?)href="(.*?)"/', '/<a(.*?)href=(?:\@)([^"]+?)(?:\@)/i'));
            $sub = array_merge( $sub , array( '<a$1href=@$2$3@', '<a$1href="' . $basecode . '$2"', '<a$1href="$2"' ) );
        }

        if( in_array( "input", $tags ) ){
            $exp = array_merge( $exp , array( '/<input(.*?)src=(?:")(http|https)\:\/\/([^"]+?)(?:")/i', '/<input(.*?)src=(?:")([^"]+?)#(?:")/i', '/<input(.*?)src="(.*?)"/', '/<input(.*?)src=(?:\@)([^"]+?)(?:\@)/i' ) );
            $sub = array_merge( $sub , array( '<input$1src=@$2://$3@', '<input$1src=@$2@', '<input$1src="' . $path . '$2"', '<input$1src="$2"' ) );
        }

        if( in_array( "object", $tags ) ){
            $exp = array_merge( $exp , array( '/<object(.*?)data=(?:")(http|https)\:\/\/([^"]+?)(?:")/i', '/<object(.*?)data=(?:")([^"]+?)#(?:")/i', '/<object(.*?)data="(.*?)"/', '/<object(.*?)data=(?:\@)([^"]+?)(?:\@)/i' ) );
            $sub = array_merge( $sub , array( '<object$1data=@$2://$3@', '<object$1data=@$2@' , '<object$1data="' . $path . '$2"', '<object$1data="$2"' ) );
        }

        if( in_array( "embed", $tags ) ){
            $exp = array_merge( $exp , array( '/<embed(.*?)src=(?:")(http|https)\:\/\/([^"]+?)(?:")/i', '/<embed(.*?)src=(?:")([^"]+?)#(?:")/i', '/<embed(.*?)src="(.*?)"/', '/<embed(.*?)src=(?:\@)([^"]+?)(?:\@)/i' ) );
            $sub = array_merge( $sub , array( '<embed$1src=@$2://$3@', '<embed$1src=@$2@', '<embed$1src="' . $path . '$2"', '<embed$1src="$2"' ) );
        }

        
        return preg_replace( $exp, $sub, $html );
    }

	/**
	 * Compiles template to cache.
	 * @param  string
	 * @return void
	 * @throws \LogicException
	 */
	public function warmupCache($name)
	{
		if (!$this->tempDirectory) {
			throw new \LogicException('Path to temporary directory is not set.');
		}

		$class = $this->getTemplateClass($name);
		if (!class_exists($class, FALSE)) {
			$this->loadTemplateFromCache($name);
		}
	}


	/**
	 * @return void
	 */
	private function loadTemplateFromCache($name)
	{
		$file = $this->getCacheFile($name);

		if (!$this->isExpired($file, $name) && (@include $file) !== FALSE) { // @ - file may not exist
			return;
		}

		if (!is_dir($this->tempDirectory)) {
			@mkdir($this->tempDirectory); // @ - directory may already exist
		}

		$handle = fopen("$file.lock", 'c+');
		if (!$handle || !flock($handle, LOCK_EX)) {
			throw new \RuntimeException("Unable to acquire exclusive lock '$file.lock'.");
		}

		if (!is_file($file) || $this->isExpired($file, $name)) {
			$code = $this->loadTemplate($name);
			if (file_put_contents("$file.tmp", $code) !== strlen($code) || !rename("$file.tmp", $file)) {
				@unlink("$file.tmp"); // @ - file may not exist
				throw new \RuntimeException("Unable to create '$file'.");
			}

		} elseif ((include $file) === FALSE) {
			throw new \RuntimeException("Unable to load '$file'.");
		}

		flock($handle, LOCK_UN);
	}


	/**
	 * @return string
	 */
	private function loadTemplate($name)
	{
		$code = $this->compile($name);
		try {
			if (@eval('?>' . $code) === FALSE) { // @ is escalated to exception
				$error = error_get_last();
				$e = new CompileException('Error in template: ' . $error['message']);
				throw $e->setSource(NULL, NULL, $name);
			}
		} catch (\ParseError $e) {
			$e = new CompileException('Error in template: ' . $e->getMessage(), 0, $e);
			throw $e->setSource(NULL, NULL, $name);
		}
		return $code;
	}


	/**
	 * @param  string
	 * @param  string
	 * @return bool
	 */
	private function isExpired($file, $name)
	{
		return $this->autoRefresh && $this->getLoader()->isExpired($name, (int) @filemtime($file)); // @ - file may not exist
	}


	/**
	 * @return string
	 */
	public function getCacheFile($name)
	{
		$file = $this->getTemplateClass($name);
		if (preg_match('#\b\w.{10,50}$#', $name, $m)) {
			$file = trim(preg_replace('#\W+#', '-', $m[0]), '-') . '-' . $file;
		}
		return $this->tempDirectory . '/' . $file . '.php';
	}


	/**
	 * @return string
	 */
	public function getTemplateClass($name)
	{
		return 'Template' . md5("$this->tempDirectory\00$name");
	}


	/**
	 * Registers run-time filter.
	 * @param  string|NULL
	 * @param  callable
	 * @return self
	 */
	public function addFilter($name, $callback)
	{
		if ($name == NULL) { // intentionally ==
			array_unshift($this->filters[NULL], $callback);
		} else {
			$this->filters[strtolower($name)] = $callback;
		}
		return $this;
	}


	/**
	 * Returns all run-time filters.
	 * @return callable[]
	 */
	public function getFilters()
	{
		return $this->filters;
	}


	/**
	 * Call a run-time filter.
	 * @param  string  filter name
	 * @param  array   arguments
	 * @return mixed
	 */
	public function invokeFilter($name, array $args)
	{
		$lname = strtolower($name);
		if (!isset($this->filters[$lname])) {
			$args2 = $args;
			array_unshift($args2, $lname);
			foreach ($this->filters[NULL] as $filter) {
				$res = call_user_func_array(Helpers::checkCallback($filter), $args2);
				if ($res !== NULL) {
					return $res;
				} elseif (isset($this->filters[$lname])) {
					return call_user_func_array(Helpers::checkCallback($this->filters[$lname]), $args);
				}
			}
			$hint = ($t = Helpers::getSuggestion(array_keys($this->filters), $name)) ? ", did you mean '$t'?" : '.';
			throw new \LogicException("Filter '$name' is not defined$hint");
		}
		return call_user_func_array(Helpers::checkCallback($this->filters[$lname]), $args);
	}


	/**
	 * Adds new macro.
	 * @return self
	 */
	public function addMacro($name, IMacro $macro)
	{
		$this->getCompiler()->addMacro($name, $macro);
		return $this;
	}


	/**
	 * @return self
	 */
	public function setContentType($type)
	{
		$this->contentType = $type;
		return $this;
	}


	/**
	 * Sets path to temporary directory.
	 * @return self
	 */
	public function setTempDirectory($path)
	{
		$this->tempDirectory = $path;
		return $this;
	}


	/**
	 * Sets auto-refresh mode.
	 * @return self
	 */
	public function setAutoRefresh($on = TRUE)
	{
		$this->autoRefresh = (bool) $on;
		return $this;
	}


	/**
	 * @return Parser
	 */
	public function getParser()
	{
		if (!$this->parser) {
			$this->parser = new Parser;
		}
		return $this->parser;
	}


	/**
	 * @return Compiler
	 */
	public function getCompiler()
	{
		if (!$this->compiler) {
			$this->compiler = new Compiler;
			Macros\CoreMacros::install($this->compiler);
			Macros\BlockMacros::install($this->compiler);
		}
		return $this->compiler;
	}


	/**
	 * @return self
	 */
	public function setLoader(ILoader $loader)
	{
		$this->loader = $loader;
		return $this;
	}


	/**
	 * @return ILoader
	 */
	public function getLoader()
	{
		if (!$this->loader) {
			$this->loader = new Loaders\FileLoader;
		}
		return $this->loader;
	}

}
