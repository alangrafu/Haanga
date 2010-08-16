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

//var_dump(Haanga_Compiler_Tokenizer::$tags);

$foo = Haanga_Compiler_Tokenizer::init("if\n\n\nblock ".'"foob\tar \" '."\n".' \n:-)"'."    \n5 != 66.9\nTRUE", NULL);


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
        '=='            => HG_Parser::T_EQ,
        '==='           => HG_Parser::T_EQ,
        'AND'           => HG_Parser::T_AND,
        '&&'            => HG_Parser::T_AND,
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

    public $value;
    public $token;

    function __construct($data, $compiler)
    {
        $this->data     = $data;
        $this->compiler = $compiler;
        $this->line     = 1;
        $this->N        = 0;
        $this->length   = strlen($data);
    }

    function getTag()
    {
        $i    = &$this->N;
        $data = substr($this->data, $i);
        foreach (self::$tags as $value => $token) {
            $len = strlen($value);
            if (strncmp($data, $value, $len) == 0) {
                if (isset($data[$len+1]) && $data[$len+1] != ' ') {
                    //continue;
                }
                $this->token = $token;
                $this->value = $value;
                $this->N    += $len;
                return TRUE;
            }
        }
        return FALSE;
    }

    function yylex()
    {
        $data        = &$this->data;
        $this->token = NULL;
        for ($i=&$this->N; is_null($this->token) && $i < $this->length; ++$i) {
            switch ($data[$i]) {
            case '[':
                $this->token = HG_Parser::T_BRACKETS_OPEN;
                $this->value = $data[$i];
                break;
            case ']':
                $this->token = HG_Parser::T_BRACKETS_CLOSE;
                $this->value = $data[$i];
                break;
            case '|':
                if ($data[$i+1] == '|') {
                    $this->token = HG_Parser::T_OR;
                    $this->value = "||";
                    ++$i;
                    break;
                }
                $this->token = HG_Parser::T_PIPE;
                $this->value = $data[$i];
                break;
            case '!':
                if ($data[$i+1] == '=') {
                    $this->token = HG_Parser::T_NE;
                    $this->value = "!=";
                    ++$i;
                    break;
                }
                $this->token = HG_Parser::T_NOT;
                $this->value = $data[$i];
                break;
            case '+':
                $this->token = HG_Parser::T_PLUS;
                $this->value = $data[$i];
                break;
            case '-':
                $this->token = HG_Parser::T_MINUS;
                $this->value = $data[$i];
                break;
            case '*':
                $this->token = HG_Parser::T_TIMES;
                $this->value = $data[$i];
                break;
            case '/':
                $this->token = HG_Parser::T_DIV;
                $this->value = $data[$i];
                break;
            case '>':
                if ($data[$i+1] == '=') {
                    $this->token = HG_Parser::T_GE;
                    $this->value = ">=";
                    ++$i;
                    break;
                }
                $this->token = HG_Parser::T_GT;
                $this->value = $data[$i];
                break;
            case '<':
                if ($data[$i+1] == '=') {
                    $this->token = HG_Parser::T_LE;
                    $this->value = "<=";
                    ++$i;
                    break;
                }
                $this->token = HG_Parser::T_LT;
                $this->value = $data[$i];
                break;
            case "_":
                if ($data[$i+1] == '(') {
                    $this->value = "_(";
                    $this->token = HG_Parser::T_INTL;
                    ++$i;
                    break;
                }
                $this->Error("Unexpected _");
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
                if (!$this->getTag()) {
                    die("error: unexpected ".substr($data, $i));
                }
                break;
            }
        }

        return isset($this->token);
    }

    static function init($template, $compiler, $file='')
    {
        $lexer  = new Haanga_Compiler_Tokenizer($template, $compiler);
        //$parser = new Haanga_Compiler_Parser($lexer, $file);

        return $lexer;

    }
}
