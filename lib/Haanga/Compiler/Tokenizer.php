<?php
/*
  +---------------------------------------------------------------------------------+
  | Copyright (c) 2010 César Rodas and Menéame Comunicacions S.L.                   |
  +---------------------------------------------------------------------------------+
  | Redistribution and use in source and binary forms, with or without              |
  | modification, are permitted provided that the following conditions are met:     |
  | 1. Redistributions of source code must retain the above copyright               |
  |    notice, this list of conditions and the following disclaimer.                |
  |                                                                                 |
  | 2. Redistributions in binary form must reproduce the above copyright            |
  |    notice, this list of conditions and the following disclaimer in the          |
  |    documentation and/or other materials provided with the distribution.         |
  |                                                                                 |
  | 3. All advertising materials mentioning features or use of this software        |
  |    must display the following acknowledgement:                                  |
  |    This product includes software developed by César D. Rodas.                  |
  |                                                                                 |
  | 4. Neither the name of the César D. Rodas nor the                               |
  |    names of its contributors may be used to endorse or promote products         |
  |    derived from this software without specific prior written permission.        |
  |                                                                                 |
  | THIS SOFTWARE IS PROVIDED BY CÉSAR D. RODAS ''AS IS'' AND ANY                   |
  | EXPRESS OR IMPLIED WARRANTIES, INCLUDING, BUT NOT LIMITED TO, THE IMPLIED       |
  | WARRANTIES OF MERCHANTABILITY AND FITNESS FOR A PARTICULAR PURPOSE ARE          |
  | DISCLAIMED. IN NO EVENT SHALL CÉSAR D. RODAS BE LIABLE FOR ANY                  |
  | DIRECT, INDIRECT, INCIDENTAL, SPECIAL, EXEMPLARY, OR CONSEQUENTIAL DAMAGES      |
  | (INCLUDING, BUT NOT LIMITED TO, PROCUREMENT OF SUBSTITUTE GOODS OR SERVICES;    |
  | LOSS OF USE, DATA, OR PROFITS; OR BUSINESS INTERRUPTION) HOWEVER CAUSED AND     |
  | ON ANY THEORY OF LIABILITY, WHETHER IN CONTRACT, STRICT LIABILITY, OR TORT      |
  | (INCLUDING NEGLIGENCE OR OTHERWISE) ARISING IN ANY WAY OUT OF THE USE OF THIS   |
  | SOFTWARE, EVEN IF ADVISED OF THE POSSIBILITY OF SUCH DAMAGE                     |
  +---------------------------------------------------------------------------------+
  | Authors: César Rodas <crodas@php.net>                                           |
  +---------------------------------------------------------------------------------+
*/


require dirname(__FILE__)."/Parser.php";

class HG_Parser Extends Haanga_Compiler_Parser
{
    /* subclass to made easier references to constants */
}

$foo = Haanga_Compiler_Tokenizer::init("<foo>{if} block{% if\n\n\nblock ".'"foob\tar \" '."\n".' \n:-)"'."    \n! 5 != 66.9\n endfoobar \nTRUE\n\nTRUE_oo", NULL);


while ($foo->yylex()) {
    var_dump(array($foo->token, $foo->value, $foo->line));
}

class Haanga_Compiler_Tokenizer
{
    /* they are case sensitive */
    static $tags = array(
        'block'         => HG_Parser::T_BLOCK,
        'load'          => HG_Parser::T_LOAD,
        'for'           => HG_Parser::T_FOR,
        'empty'         => HG_Parser::T_EMPTY,
        'TRUE'          => HG_Parser::T_TRUE,
        'FALSE'         => HG_Parser::T_FALSE,
        'AND'           => HG_Parser::T_AND,
        'OR'            => HG_Parser::T_OR,
        'not'           => HG_Parser::T_NOT,
        'NOT'           => HG_Parser::T_NOT,
        'if'            => HG_Parser::T_IF,
        'else'          => HG_Parser::T_ELSE,
        'ifequal'       => HG_Parser::T_IFEQUAL,
        'spacefull'     => HG_Parser::T_SPACEFULL,
        'autoescape'    => HG_Parser::T_AUTOESCAPE,
        'filter'        => HG_Parser::T_FILTER,
    );

    static $operations = array(
        '&&'    => HG_Parser::T_AND,
        '=='    => HG_Parser::T_EQ,
        '==='   => HG_Parser::T_EQ,
        '->'    => HG_Parser::T_OBJ,
        '||'    => HG_Parser::T_OR,
        '['     => HG_Parser::T_BRACKETS_OPEN,
        ']'     => HG_Parser::T_BRACKETS_CLOSE,
        '-'     => HG_Parser::T_MINUS,
        '+'     => HG_Parser::T_PLUS,
        '*'     => HG_Parser::T_TIMES,
        '/'     => HG_Parser::T_DIV, 
        '.'     => HG_Parser::T_DOT,
        '>='    => HG_Parser::T_GE,
        '>'     => HG_Parser::T_GT,
        '<='    => HG_Parser::T_LE,
        '<'     => HG_Parser::T_LT,
        '|'     => HG_Parser::T_PIPE,
        '!='    => HG_Parser::T_NE,
        '!'     => HG_Parser::T_NOT,
        '('     => HG_Parser::T_LPARENT,
        ')'     => HG_Parser::T_RPARENT,
        '_('    => HG_Parser::T_INTL,
        ','     => HG_Parser::T_COMMA,
    );

    public $value;
    public $token;
    public $status = self::IN_HTML;

    const IN_HTML   = 1;
    const IN_TAG    = 2;
    const IN_ECHO   = 3;

    function __construct($data, $compiler)
    {
        $this->data     = $data;
        $this->compiler = $compiler;
        $this->line     = 1;
        $this->N        = 0;
        $this->length   = strlen($data);
    }

    function yylex()
    {
        $this->token = NULL;
    
        switch ($this->status)
        {
            case self::IN_TAG:
            case self::IN_ECHO:
                $this->yylex_main();
                break;
            default:
                $this->yylex_html();
        }

        return !empty($this->token);
    }

    function yylex_html()
    {
        $data  = &$this->data;
        $value = "";
        for ($i=&$this->N; is_null($this->token) && $i < $this->length; ++$i) {
            switch ($data[$i]) {
            case '{':
                switch ($data[$i+1]) {
                case '%':
                    $this->status = self::IN_TAG;
                    $i += 2;
                    break 3;
                case '{':
                    $this->status = self::IN_ECHO;
                    $i += 2;
                    break 3;
                case '#':
                    $this->status = self::IN_COMMENT;
                    $i += 2;
                    break 3;
                default:
                    $value .= $data[$i];
                    break;
                }
                break;
            default:
                $value .= $data[$i];
            }
        }
        $this->token = HG_Parser::T_HTML;
        $this->value = $value;
    }

    function yylex_main()
    {
        $data = &$this->data;

        for ($i=&$this->N; is_null($this->token) && $i < $this->length; ++$i) {
            switch ($data[$i]) {
            case '}':
                switch ($data[$i+1]) {
                case '%':
                case '}':
                case '#':
                    $this->status = self::IN_HTML;
                    $i += 2;
                    break 3;
                }
                break;

            /* strings {{{ */
            case '"':
            case "'":
                $end   = $data[$i];
                $value = "";
                while ($data[++$i] != $end) {
                    switch ($data[$i]) {
                    case "\\":
                        switch ($data[++$i]) {
                        case "n":
                            $value .= "\n";
                            break;
                        case "t":
                            $value .= "\t";
                            break;
                        default:
                            $value .= $data[$i];
                        }
                        break;
                    case $end:
                        --$i;
                        break 2;
                    default:
                        if ($data[$i] == "\n") {
                            $this->line++;
                        }
                        $value .= $data[$i];
                    }
                    if (!isset($data[$i+1])) {
                        $this->Error("unclosed string");
                    }
                }
                $this->value = $value;
                $this->token = HG_Parser::T_STRING;
                break;
            /* }}} */

            /* number {{{ */
            case '0': case '1': case '2': case '3': case '4':
            case '5': case '6': case '7': case '8': case '9': 
                $value = "";
                $dot   = FALSE;
                for (; $i < $this->length; ++$i) {
                    switch ($data[$i]) {
                    case '0': case '1': case '2': case '3': case '4': 
                    case '5': case '6': case '7': case '8': case '9': 
                        $value .= $data[$i];
                        break;
                    case '.':
                        if (!$dot) {
                            $value .= ".";
                            $dot    = TRUE;
                        } else {
                            $this->error("Invalid number");
                        }
                        break;
                    default: 
                        $this->value = $value;
                        $this->token = HG_Parser::T_NUMERIC;
                        break 2;
                    }
                }
                break;
            /* }}} */

            case "\n":
                $this->line++;
            case " ": case "\t": case "\r": case "\f":
                break; /* whitespaces are ignored */
            default: 
                if (!$this->getTag() && !$this->getOperator()) {
                    $alpha = $this->getAlpha();
                    if ($alpha === FALSE) {
                        die("error: unexpected ".substr($data, $i));
                    }
                    static $tag=NULL;
                    if (!$tag) {
                        $tag = Haanga_Extension::getInstance('Tag');
                    }
                    $value = $tag->isValid($alpha);
                    $this->token = $value ? $value : HG_Parser::T_ALPHA;
                    $this->value = $alpha;

                }
                break;
            }
        }
    }

    function getTag()
    {
        $data = substr($this->data, $this->N);
        foreach (self::$tags as $value => $token) {
            $len = strlen($value);
            if (strncmp($data, $value, $len) == 0) {
                if (isset($data[$len]) && !$this->is_token_end($data[$len])) {
                    /* probably a variable name TRUEfoo (and not TRUE) */
                    continue;
                }
                $this->token = $token;
                $this->value = $value;
                $this->N    += $len;
                return TRUE;
            }
        }

        /* /end([a-zA-Z][a-zA-Z0-9]*)/ */
        if (strncmp($data, "end", 3) == 0) {
            $this->value = $this->getAlpha();
            $this->token = HG_Parser::T_CUSTOM_END;
            return TRUE;
        }
        
        return FALSE;
    }

    function getOperator()
    {
        $data = substr($this->data, $this->N);
        foreach (self::$operations as $value => $token) {
            $len = strlen($value);
            if (strncmp($data, $value, $len) == 0) {
                $this->token = $token;
                $this->value = $value;
                $this->N    += $len;
                return TRUE;
            }
        }

        return FALSE;
    }


    /**
     *  Return TRUE if $letter is a valid "token_end". We use token_end
     *  to avoid confuse T_ALPHA TRUEfoo with TRUE and foo (T_ALPHA)
     *
     *  @param string $letter
     *
     *  @return bool
     */
    protected function is_token_end($letter)
    {
        /* [^a-zA-Z0-9_] */
        return !(
            ('a' <= $letter && 'z' >= $letter) ||
            ('A' <= $letter && 'Z' >= $letter) || 
            ('0' <= $letter && '9' >= $letter) || 
            $letter == "_" 
        );
    }

    function getAlpha()
    {
        /* [a-zA-Z_][a-zA-Z0-9_]* */
        $i    = &$this->N;
        $data = &$this->data;

        if (  !('a' <= $data[$i] && 'z' >= $data[$i]) &&
            !('A' <= $data[$i] && 'Z' >= $data[$i]) && $data[$i] != '_') {
            return FALSE;
        }

        $value  = "";
        for (; $i < $this->length; ++$i) {
            if (
                ('a' <= $data[$i] && 'z' >= $data[$i]) ||
                ('A' <= $data[$i] && 'Z' >= $data[$i]) || 
                ('0' <= $data[$i] && '9' >= $data[$i]) || 
                $data[$i] == "_"
            ) {
                $value .= $data[$i];
            } else {
                break;
            }
        }

        return $value;
    }


    static function init($template, $compiler, $file='')
    {
        $lexer  = new Haanga_Compiler_Tokenizer($template, $compiler);
        //$parser = new Haanga_Compiler_Parser($lexer, $file);

        return $lexer;

    }
}
