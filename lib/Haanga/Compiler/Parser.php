<?php
/* Driver template for the PHP_Haanga_rGenerator parser generator. (PHP port of LEMON)
*/

/**
 * This can be used to store both the string representation of
 * a token, and any useful meta-data associated with the token.
 *
 * meta-data should be stored as an array
 */
class Haanga_yyToken implements ArrayAccess
{
    public $string = '';
    public $metadata = array();

    function __construct($s, $m = array())
    {
        if ($s instanceof Haanga_yyToken) {
            $this->string = $s->string;
            $this->metadata = $s->metadata;
        } else {
            $this->string = (string) $s;
            if ($m instanceof Haanga_yyToken) {
                $this->metadata = $m->metadata;
            } elseif (is_array($m)) {
                $this->metadata = $m;
            }
        }
    }

    function __toString()
    {
        return $this->_string;
    }

    function offsetExists($offset)
    {
        return isset($this->metadata[$offset]);
    }

    function offsetGet($offset)
    {
        return $this->metadata[$offset];
    }

    function offsetSet($offset, $value)
    {
        if ($offset === null) {
            if (isset($value[0])) {
                $x = ($value instanceof Haanga_yyToken) ?
                    $value->metadata : $value;
                $this->metadata = array_merge($this->metadata, $x);
                return;
            }
            $offset = count($this->metadata);
        }
        if ($value === null) {
            return;
        }
        if ($value instanceof Haanga_yyToken) {
            if ($value->metadata) {
                $this->metadata[$offset] = $value->metadata;
            }
        } elseif ($value) {
            $this->metadata[$offset] = $value;
        }
    }

    function offsetUnset($offset)
    {
        unset($this->metadata[$offset]);
    }
}

/** The following structure represents a single element of the
 * parser's stack.  Information stored includes:
 *
 *   +  The state number for the parser at this level of the stack.
 *
 *   +  The value of the token stored at this level of the stack.
 *      (In other words, the "major" token.)
 *
 *   +  The semantic value stored at this level of the stack.  This is
 *      the information used by the action routines in the grammar.
 *      It is sometimes called the "minor" token.
 */
class Haanga_yyStackEntry
{
    public $stateno;       /* The state-number */
    public $major;         /* The major token value.  This is the code
                     ** number for the token at this stack level */
    public $minor; /* The user-supplied minor token value.  This
                     ** is the value of the token  */
};

// code external to the class is included here
#line 2 "lib/Haanga/Compiler/Parser.y"

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
#line 136 "lib/Haanga/Compiler/Parser.php"

// declare_class is output here
#line 39 "lib/Haanga/Compiler/Parser.y"
 class Haanga_Compiler_Parser #line 141 "lib/Haanga/Compiler/Parser.php"
{
/* First off, code is included which follows the "include_class" declaration
** in the input file. */
#line 40 "lib/Haanga/Compiler/Parser.y"

    protected $lex;
    protected $file;

    function __construct($lex, $file='')
    {
        $this->lex  = $lex;
        $this->file = $file;
    }

    function Error($text)
    {
        throw new Haanga_Compiler_Exception($text.' in '.$this->file.':'.$this->lex->getLine());
    }

#line 162 "lib/Haanga/Compiler/Parser.php"

/* Next is all token values, as class constants
*/
/* 
** These constants (all generated automatically by the parser generator)
** specify the various kinds of tokens (terminals) that the parser
** understands. 
**
** Each symbol here is a terminal symbol in the grammar.
*/
    const T_OPEN_TAG                     =  1;
    const T_NOT                          =  2;
    const T_AND                          =  3;
    const T_OR                           =  4;
    const T_EQ                           =  5;
    const T_NE                           =  6;
    const T_GT                           =  7;
    const T_GE                           =  8;
    const T_LT                           =  9;
    const T_LE                           = 10;
    const T_IN                           = 11;
    const T_PLUS                         = 12;
    const T_MINUS                        = 13;
    const T_TIMES                        = 14;
    const T_DIV                          = 15;
    const T_MOD                          = 16;
    const T_HTML                         = 17;
    const T_COMMENT_OPEN                 = 18;
    const T_COMMENT                      = 19;
    const T_PRINT_OPEN                   = 20;
    const T_PRINT_CLOSE                  = 21;
    const T_EXTENDS                      = 22;
    const T_CLOSE_TAG                    = 23;
    const T_INCLUDE                      = 24;
    const T_AUTOESCAPE                   = 25;
    const T_OFF                          = 26;
    const T_ON                           = 27;
    const T_END_AUTOESCAPE               = 28;
    const T_CUSTOM_TAG                   = 29;
    const T_AS                           = 30;
    const T_CUSTOM_BLOCK                 = 31;
    const T_CUSTOM_END                   = 32;
    const T_SPACEFULL                    = 33;
    const T_WITH                         = 34;
    const T_ENDWITH                      = 35;
    const T_LOAD                         = 36;
    const T_FOR                          = 37;
    const T_COMMA                        = 38;
    const T_CLOSEFOR                     = 39;
    const T_EMPTY                        = 40;
    const T_IF                           = 41;
    const T_ENDIF                        = 42;
    const T_ELSE                         = 43;
    const T_IFCHANGED                    = 44;
    const T_ENDIFCHANGED                 = 45;
    const T_IFEQUAL                      = 46;
    const T_END_IFEQUAL                  = 47;
    const T_IFNOTEQUAL                   = 48;
    const T_END_IFNOTEQUAL               = 49;
    const T_BLOCK                        = 50;
    const T_END_BLOCK                    = 51;
    const T_NUMERIC                      = 52;
    const T_FILTER                       = 53;
    const T_END_FILTER                   = 54;
    const T_REGROUP                      = 55;
    const T_BY                           = 56;
    const T_PIPE                         = 57;
    const T_COLON                        = 58;
    const T_TRUE                         = 59;
    const T_FALSE                        = 60;
    const T_STRING                       = 61;
    const T_INTL                         = 62;
    const T_RPARENT                      = 63;
    const T_STRING_SINGLE_INIT           = 64;
    const T_STRING_SINGLE_END            = 65;
    const T_STRING_DOUBLE_INIT           = 66;
    const T_STRING_DOUBLE_END            = 67;
    const T_STRING_CONTENT               = 68;
    const T_LPARENT                      = 69;
    const T_OBJ                          = 70;
    const T_ALPHA                        = 71;
    const T_DOT                          = 72;
    const T_BRACKETS_OPEN                = 73;
    const T_BRACKETS_CLOSE               = 74;
    const YY_NO_ACTION = 334;
    const YY_ACCEPT_ACTION = 333;
    const YY_ERROR_ACTION = 332;

/* Next are that tables used to determine what action to take based on the
** current state and lookahead token.  These tables are used to implement
** functions that take a state number and lookahead value and return an
** action integer.  
**
** Suppose the action integer is N.  Then the action is determined as
** follows
**
**   0 <= N < self::YYNSTATE                              Shift N.  That is,
**                                                        push the lookahead
**                                                        token onto the stack
**                                                        and goto state N.
**
**   self::YYNSTATE <= N < self::YYNSTATE+self::YYNRULE   Reduce by rule N-YYNSTATE.
**
**   N == self::YYNSTATE+self::YYNRULE                    A syntax error has occurred.
**
**   N == self::YYNSTATE+self::YYNRULE+1                  The parser accepts its
**                                                        input. (and concludes parsing)
**
**   N == self::YYNSTATE+self::YYNRULE+2                  No such action.  Denotes unused
**                                                        slots in the yy_action[] table.
**
** The action table is constructed as a single large static array $yy_action.
** Given state S and lookahead X, the action is computed as
**
**      self::$yy_action[self::$yy_shift_ofst[S] + X ]
**
** If the index value self::$yy_shift_ofst[S]+X is out of range or if the value
** self::$yy_lookahead[self::$yy_shift_ofst[S]+X] is not equal to X or if
** self::$yy_shift_ofst[S] is equal to self::YY_SHIFT_USE_DFLT, it means that
** the action is not in the table and that self::$yy_default[S] should be used instead.  
**
** The formula above is for computing the action when the lookahead is
** a terminal symbol.  If the lookahead is a non-terminal (as occurs after
** a reduce action) then the static $yy_reduce_ofst array is used in place of
** the static $yy_shift_ofst array and self::YY_REDUCE_USE_DFLT is used in place of
** self::YY_SHIFT_USE_DFLT.
**
** The following are the tables generated in this section:
**
**  self::$yy_action        A single table containing all actions.
**  self::$yy_lookahead     A table containing the lookahead for each entry in
**                          yy_action.  Used to detect hash collisions.
**  self::$yy_shift_ofst    For each state, the offset into self::$yy_action for
**                          shifting terminals.
**  self::$yy_reduce_ofst   For each state, the offset into self::$yy_action for
**                          shifting non-terminals after a reduce.
**  self::$yy_default       Default action for each state.
*/
    const YY_SZ_ACTTAB = 1129;
static public $yy_action = array(
 /*     0 */    42,    1,   41,  126,  208,  177,   74,   34,   85,   36,
 /*    10 */    84,  149,   80,  180,   54,   78,  233,  246,  135,   22,
 /*    20 */    49,  171,   35,  152,   31,  199,   33,  212,   63,   83,
 /*    30 */    50,   47,   42,   48,   41,  126,   13,  124,   38,   34,
 /*    40 */   192,   36,  231,  149,   80,  232,   54,   78,  178,  161,
 /*    50 */   163,   22,  246,  135,   35,   49,   31,  183,   33,  162,
 /*    60 */    63,  165,   44,   47,   42,   48,   41,  126,  223,  232,
 /*    70 */   235,   34,  235,   36,  170,  149,   80,  175,   54,   78,
 /*    80 */    24,   24,   24,   22,  124,  138,   35,  192,   31,  169,
 /*    90 */    33,   88,   63,  146,  116,   47,   42,   48,   41,  126,
 /*   100 */   200,  210,  235,   34,  235,   36,  166,  149,   80,  187,
 /*   110 */    54,   78,  234,   50,  129,   22,  124,  143,   35,  192,
 /*   120 */    31,  207,   33,  136,   63,  116,  222,   47,   42,   48,
 /*   130 */    41,  126,  202,  206,   50,   34,  217,   36,  144,  149,
 /*   140 */    80,  100,   54,   78,  234,  211,   94,   22,  159,  154,
 /*   150 */    35,   46,   31,  204,   33,  124,   63,  181,  192,   47,
 /*   160 */    42,   48,   41,  126,  333,   67,   97,   34,  237,   36,
 /*   170 */    50,  149,   80,  238,   54,   78,   51,  220,   81,   22,
 /*   180 */    50,  157,   35,  158,   31,   73,   33,  124,   63,  245,
 /*   190 */   192,   47,   42,   48,   41,  126,  196,  153,  153,   34,
 /*   200 */    86,   36,  186,  149,   80,   98,   54,   78,   89,  148,
 /*   210 */   162,   22,  165,   44,   35,  172,   31,  182,   33,  124,
 /*   220 */    63,  194,  192,   47,   42,   48,   41,  126,   18,   99,
 /*   230 */   197,   34,  242,   36,   82,  149,   80,   53,   54,   78,
 /*   240 */   224,  233,  133,   22,  246,  135,   35,   49,   31,  189,
 /*   250 */    33,  147,   63,  116,   50,   47,   42,   48,   41,  126,
 /*   260 */   202,  214,  227,   34,  190,   36,  213,  149,   80,  230,
 /*   270 */    54,   78,  184,  209,  162,   22,  165,   44,   35,  103,
 /*   280 */    31,   96,   33,  124,   63,  127,  192,   47,   42,   48,
 /*   290 */    41,  126,  226,  128,   93,   34,  225,   36,   95,  149,
 /*   300 */    80,  215,   54,   78,  116,  119,   64,   22,  155,    7,
 /*   310 */    35,  202,   31,   75,   33,  125,   63,   69,   62,   47,
 /*   320 */    42,   48,   41,  126,   19,  246,  135,   34,   49,   36,
 /*   330 */   130,  149,   80,  122,   54,   78,   57,   56,  115,   22,
 /*   340 */   246,  135,   35,   49,   31,  114,   33,   68,   63,  212,
 /*   350 */   187,   47,  151,   48,   42,   17,   41,  126,  117,  124,
 /*   360 */    39,   34,  192,   36,   61,  149,   80,  113,   54,   78,
 /*   370 */    66,  246,  135,   22,   49,   16,   35,   72,   31,  140,
 /*   380 */    33,   65,   63,  219,  139,   47,   42,   48,   41,  126,
 /*   390 */     6,  246,  135,   34,   49,   36,  121,  149,   80,   70,
 /*   400 */    54,   78,   52,  118,   60,   22,  246,  135,   35,   49,
 /*   410 */    31,   71,   33,   55,   63,   58,   59,   47,   42,   48,
 /*   420 */    41,  126,    4,  187,  160,   34,  120,   36,  112,  149,
 /*   430 */    80,  187,   54,   78,  187,  187,  187,   22,  246,  135,
 /*   440 */    35,   49,   31,  187,   33,  187,   63,  187,  187,   47,
 /*   450 */    42,   48,   41,  126,   15,  187,  187,   34,  187,   36,
 /*   460 */   141,  149,   80,  187,   54,   78,  187,  187,  187,   22,
 /*   470 */   246,  135,   35,   49,   31,  187,   33,  187,   63,  187,
 /*   480 */   187,   47,   42,   48,   41,  126,    5,  187,  187,   34,
 /*   490 */   187,   36,  187,  149,   80,  156,   54,   78,  187,  187,
 /*   500 */   187,   22,  246,  135,   35,   49,   31,  187,   33,  187,
 /*   510 */    63,  187,  187,   47,   42,   48,   41,  126,    9,  187,
 /*   520 */   187,   34,  187,   36,  187,  149,   80,  187,   54,   78,
 /*   530 */   187,  164,  187,   22,  246,  135,   35,   49,   31,  187,
 /*   540 */    33,  131,   63,  187,  187,   47,   42,   48,   41,  126,
 /*   550 */     3,  187,  116,   34,  187,   36,  145,  149,   80,  202,
 /*   560 */    54,   78,  187,  187,  132,   22,  246,  135,   35,   49,
 /*   570 */    31,  187,   33,  187,   63,  116,  187,   47,   42,   48,
 /*   580 */    41,  126,  202,  187,  187,   34,  187,   36,  187,  149,
 /*   590 */    80,  187,   54,   78,  187,  187,  187,   22,  187,   12,
 /*   600 */    35,  167,   31,  187,   33,  187,   63,  187,  187,   47,
 /*   610 */    42,   48,   41,  126,   11,  246,  135,   34,   49,   36,
 /*   620 */   150,  149,   80,  187,   54,   78,  187,  187,  187,   22,
 /*   630 */   246,  135,   35,   49,   31,  187,   33,  187,   63,  187,
 /*   640 */   187,   47,   42,   48,   41,  126,  229,  187,   40,   34,
 /*   650 */   187,   36,  187,  149,   80,   14,   54,   78,  187,  187,
 /*   660 */   162,   22,  165,   44,   35,  187,   31,  187,   33,  187,
 /*   670 */    63,  246,  135,   47,   49,   48,  187,   29,   27,   23,
 /*   680 */    23,   23,   23,   23,   23,   23,   26,   26,   24,   24,
 /*   690 */    24,  187,  228,  162,  187,  165,   44,   87,  235,  187,
 /*   700 */   235,   29,   27,   23,   23,   23,   23,   23,   23,   23,
 /*   710 */    26,   26,   24,   24,   24,   29,   27,   23,   23,   23,
 /*   720 */    23,   23,   23,   23,   26,   26,   24,   24,   24,  201,
 /*   730 */   187,   92,  187,   79,  187,  235,   77,  235,   45,  187,
 /*   740 */   234,  187,  187,  187,   43,  187,  179,  187,  187,  137,
 /*   750 */   243,  244,  241,  240,  236,  239,  221,  205,  191,  187,
 /*   760 */   216,  174,   90,  187,  187,  188,  188,  177,   74,  187,
 /*   770 */    85,  187,   84,  162,  187,  165,   44,  234,  162,  102,
 /*   780 */   165,   44,   27,   23,   23,   23,   23,   23,   23,   23,
 /*   790 */    26,   26,   24,   24,   24,   28,   91,  162,  142,  165,
 /*   800 */    44,   20,  235,  187,  235,  187,  187,  187,  187,  116,
 /*   810 */   187,   43,  173,  187,  176,  193,  202,  246,  135,  187,
 /*   820 */    49,  187,  235,  187,  235,  191,  162,  187,  165,   44,
 /*   830 */     8,  187,  188,  188,  177,   74,  187,   85,  187,   84,
 /*   840 */   187,  187,  187,  187,  234,  185,  246,  135,  187,   49,
 /*   850 */   212,  187,  195,  195,  177,   74,  187,   85,  187,   84,
 /*   860 */   124,   37,   25,  192,  234,   23,   23,   23,   23,   23,
 /*   870 */    23,   23,   26,   26,   24,   24,   24,  105,  187,  187,
 /*   880 */   187,  187,  187,  235,  187,  235,  187,  187,  187,  187,
 /*   890 */   203,  187,   43,  142,  187,  187,  235,   76,  235,  187,
 /*   900 */   187,  187,  187,  187,  116,  187,  191,  173,  187,  111,
 /*   910 */   193,  202,  187,  188,  188,  177,   74,  187,   85,  191,
 /*   920 */    84,  187,  187,  187,  187,  234,  188,  188,  177,   74,
 /*   930 */   187,   85,  187,   84,  198,  142,  187,  104,  234,  187,
 /*   940 */   187,  187,  187,  235,  187,  235,  116,  187,  187,  173,
 /*   950 */   101,  106,  193,  202,  142,  187,  235,  187,  235,  187,
 /*   960 */   187,  187,  218,  187,  187,  116,  191,  187,  173,  187,
 /*   970 */   107,  193,  202,  188,  188,  177,   74,  187,   85,  191,
 /*   980 */    84,  162,  187,  165,   44,  234,  188,  188,  177,   74,
 /*   990 */   142,   85,  187,   84,  187,  187,  187,  187,  234,  187,
 /*  1000 */   187,  116,  187,  235,  173,  235,  108,  193,  202,  162,
 /*  1010 */   187,  165,   44,  187,  142,  187,  235,  187,  235,  187,
 /*  1020 */   187,  187,  187,  187,  187,  116,  191,  187,  173,  187,
 /*  1030 */   109,  193,  202,  188,  188,  177,   74,  187,   85,  185,
 /*  1040 */    84,  187,  187,  187,  187,  234,  195,  195,  177,   74,
 /*  1050 */   187,   85,  142,   84,  187,  187,  187,  187,  234,  187,
 /*  1060 */   142,  187,  187,  116,  187,  187,  173,  187,  110,  193,
 /*  1070 */   202,  116,  142,  187,  173,  187,  123,  193,  202,  187,
 /*  1080 */   187,  187,  142,  116,  142,  187,  173,  187,   21,  168,
 /*  1090 */   202,  187,  187,  116,  187,  116,  173,  142,  173,   32,
 /*  1100 */   202,  134,  202,    2,  246,  135,  187,   49,  116,   10,
 /*  1110 */   187,  173,  187,  187,   30,  202,  187,  187,  187,  246,
 /*  1120 */   135,  187,   49,  187,  187,  246,  135,  187,   49,
    );
    static public $yy_lookahead = array(
 /*     0 */    22,    1,   24,   25,   23,   61,   62,   29,   64,   31,
 /*    10 */    66,   33,   34,   65,   36,   37,   68,   17,   18,   41,
 /*    20 */    20,   43,   44,   45,   46,   23,   48,   81,   50,   56,
 /*    30 */    57,   53,   22,   55,   24,   25,    1,   91,   92,   29,
 /*    40 */    94,   31,   65,   33,   34,   68,   36,   37,   78,   39,
 /*    50 */    40,   41,   17,   18,   44,   20,   46,   71,   48,   70,
 /*    60 */    50,   72,   73,   53,   22,   55,   24,   25,   67,   68,
 /*    70 */    29,   29,   31,   31,   81,   33,   34,   21,   36,   37,
 /*    80 */    14,   15,   16,   41,   91,   43,   44,   94,   46,   47,
 /*    90 */    48,   23,   50,   52,   91,   53,   22,   55,   24,   25,
 /*   100 */    23,   98,   29,   29,   31,   31,   81,   33,   34,   23,
 /*   110 */    36,   37,   71,   57,   80,   41,   91,   43,   44,   94,
 /*   120 */    46,   23,   48,   49,   50,   91,   23,   53,   22,   55,
 /*   130 */    24,   25,   98,   23,   57,   29,   23,   31,   52,   33,
 /*   140 */    34,   23,   36,   37,   71,   81,   23,   41,   42,   43,
 /*   150 */    44,   11,   46,   23,   48,   91,   50,   23,   94,   53,
 /*   160 */    22,   55,   24,   25,   76,   77,   23,   29,   23,   31,
 /*   170 */    57,   33,   34,   23,   36,   37,   77,   81,   38,   41,
 /*   180 */    57,   43,   44,   45,   46,   77,   48,   91,   50,   23,
 /*   190 */    94,   53,   22,   55,   24,   25,   71,   26,   27,   29,
 /*   200 */    23,   31,   23,   33,   34,   23,   36,   37,   23,   81,
 /*   210 */    70,   41,   72,   73,   44,   45,   46,   23,   48,   91,
 /*   220 */    50,   63,   94,   53,   22,   55,   24,   25,    1,   23,
 /*   230 */    23,   29,   23,   31,   30,   33,   34,   77,   36,   37,
 /*   240 */    67,   68,   80,   41,   17,   18,   44,   20,   46,   23,
 /*   250 */    48,   49,   50,   91,   57,   53,   22,   55,   24,   25,
 /*   260 */    98,   23,   23,   29,   19,   31,   23,   33,   34,   23,
 /*   270 */    36,   37,   23,   81,   70,   41,   72,   73,   44,   23,
 /*   280 */    46,   23,   48,   91,   50,   51,   94,   53,   22,   55,
 /*   290 */    24,   25,   74,   80,   23,   29,   23,   31,   23,   33,
 /*   300 */    34,   23,   36,   37,   91,   91,   77,   41,   42,    1,
 /*   310 */    44,   98,   46,   77,   48,   99,   50,   77,   77,   53,
 /*   320 */    22,   55,   24,   25,    1,   17,   18,   29,   20,   31,
 /*   330 */    99,   33,   34,   91,   36,   37,   77,   77,   91,   41,
 /*   340 */    17,   18,   44,   20,   46,   91,   48,   77,   50,   81,
 /*   350 */   100,   53,   54,   55,   22,    1,   24,   25,   91,   91,
 /*   360 */    92,   29,   94,   31,   77,   33,   34,   91,   36,   37,
 /*   370 */    77,   17,   18,   41,   20,    1,   44,   77,   46,   47,
 /*   380 */    48,   77,   50,   94,   94,   53,   22,   55,   24,   25,
 /*   390 */     1,   17,   18,   29,   20,   31,   91,   33,   34,   77,
 /*   400 */    36,   37,   77,   91,   77,   41,   17,   18,   44,   20,
 /*   410 */    46,   77,   48,   77,   50,   51,   77,   53,   22,   55,
 /*   420 */    24,   25,    1,  100,   28,   29,   91,   31,   91,   33,
 /*   430 */    34,  100,   36,   37,  100,  100,  100,   41,   17,   18,
 /*   440 */    44,   20,   46,  100,   48,  100,   50,  100,  100,   53,
 /*   450 */    22,   55,   24,   25,    1,  100,  100,   29,  100,   31,
 /*   460 */    32,   33,   34,  100,   36,   37,  100,  100,  100,   41,
 /*   470 */    17,   18,   44,   20,   46,  100,   48,  100,   50,  100,
 /*   480 */   100,   53,   22,   55,   24,   25,    1,  100,  100,   29,
 /*   490 */   100,   31,  100,   33,   34,   35,   36,   37,  100,  100,
 /*   500 */   100,   41,   17,   18,   44,   20,   46,  100,   48,  100,
 /*   510 */    50,  100,  100,   53,   22,   55,   24,   25,    1,  100,
 /*   520 */   100,   29,  100,   31,  100,   33,   34,  100,   36,   37,
 /*   530 */   100,   39,  100,   41,   17,   18,   44,   20,   46,  100,
 /*   540 */    48,   80,   50,  100,  100,   53,   22,   55,   24,   25,
 /*   550 */     1,  100,   91,   29,  100,   31,   32,   33,   34,   98,
 /*   560 */    36,   37,  100,  100,   80,   41,   17,   18,   44,   20,
 /*   570 */    46,  100,   48,  100,   50,   91,  100,   53,   22,   55,
 /*   580 */    24,   25,   98,  100,  100,   29,  100,   31,  100,   33,
 /*   590 */    34,  100,   36,   37,  100,  100,  100,   41,  100,    1,
 /*   600 */    44,   45,   46,  100,   48,  100,   50,  100,  100,   53,
 /*   610 */    22,   55,   24,   25,    1,   17,   18,   29,   20,   31,
 /*   620 */    32,   33,   34,  100,   36,   37,  100,  100,  100,   41,
 /*   630 */    17,   18,   44,   20,   46,  100,   48,  100,   50,  100,
 /*   640 */   100,   53,   22,   55,   24,   25,   23,  100,   58,   29,
 /*   650 */   100,   31,  100,   33,   34,    1,   36,   37,  100,  100,
 /*   660 */    70,   41,   72,   73,   44,  100,   46,  100,   48,  100,
 /*   670 */    50,   17,   18,   53,   20,   55,  100,    3,    4,    5,
 /*   680 */     6,    7,    8,    9,   10,   11,   12,   13,   14,   15,
 /*   690 */    16,  100,   23,   70,  100,   72,   73,   23,   29,  100,
 /*   700 */    31,    3,    4,    5,    6,    7,    8,    9,   10,   11,
 /*   710 */    12,   13,   14,   15,   16,    3,    4,    5,    6,    7,
 /*   720 */     8,    9,   10,   11,   12,   13,   14,   15,   16,   23,
 /*   730 */   100,   23,  100,   30,  100,   29,   30,   31,   11,  100,
 /*   740 */    71,  100,  100,  100,   38,  100,   79,  100,  100,   82,
 /*   750 */    83,   84,   85,   86,   87,   88,   89,   90,   52,  100,
 /*   760 */    93,   63,   95,  100,  100,   59,   60,   61,   62,  100,
 /*   770 */    64,  100,   66,   70,  100,   72,   73,   71,   70,   23,
 /*   780 */    72,   73,    4,    5,    6,    7,    8,    9,   10,   11,
 /*   790 */    12,   13,   14,   15,   16,    2,   23,   70,   80,   72,
 /*   800 */    73,    1,   29,  100,   31,  100,  100,  100,  100,   91,
 /*   810 */   100,   38,   94,  100,   96,   97,   98,   17,   18,  100,
 /*   820 */    20,  100,   29,  100,   31,   52,   70,  100,   72,   73,
 /*   830 */     1,  100,   59,   60,   61,   62,  100,   64,  100,   66,
 /*   840 */   100,  100,  100,  100,   71,   52,   17,   18,  100,   20,
 /*   850 */    81,  100,   59,   60,   61,   62,  100,   64,  100,   66,
 /*   860 */    91,   92,   69,   94,   71,    5,    6,    7,    8,    9,
 /*   870 */    10,   11,   12,   13,   14,   15,   16,   23,  100,  100,
 /*   880 */   100,  100,  100,   29,  100,   31,  100,  100,  100,  100,
 /*   890 */    23,  100,   38,   80,  100,  100,   29,   30,   31,  100,
 /*   900 */   100,  100,  100,  100,   91,  100,   52,   94,  100,   96,
 /*   910 */    97,   98,  100,   59,   60,   61,   62,  100,   64,   52,
 /*   920 */    66,  100,  100,  100,  100,   71,   59,   60,   61,   62,
 /*   930 */   100,   64,  100,   66,   23,   80,  100,   23,   71,  100,
 /*   940 */   100,  100,  100,   29,  100,   31,   91,  100,  100,   94,
 /*   950 */    23,   96,   97,   98,   80,  100,   29,  100,   31,  100,
 /*   960 */   100,  100,   23,  100,  100,   91,   52,  100,   94,  100,
 /*   970 */    96,   97,   98,   59,   60,   61,   62,  100,   64,   52,
 /*   980 */    66,   70,  100,   72,   73,   71,   59,   60,   61,   62,
 /*   990 */    80,   64,  100,   66,  100,  100,  100,  100,   71,  100,
 /*  1000 */   100,   91,  100,   29,   94,   31,   96,   97,   98,   70,
 /*  1010 */   100,   72,   73,  100,   80,  100,   29,  100,   31,  100,
 /*  1020 */   100,  100,  100,  100,  100,   91,   52,  100,   94,  100,
 /*  1030 */    96,   97,   98,   59,   60,   61,   62,  100,   64,   52,
 /*  1040 */    66,  100,  100,  100,  100,   71,   59,   60,   61,   62,
 /*  1050 */   100,   64,   80,   66,  100,  100,  100,  100,   71,  100,
 /*  1060 */    80,  100,  100,   91,  100,  100,   94,  100,   96,   97,
 /*  1070 */    98,   91,   80,  100,   94,  100,   96,   97,   98,  100,
 /*  1080 */   100,  100,   80,   91,   80,  100,   94,  100,    1,   97,
 /*  1090 */    98,  100,  100,   91,  100,   91,   94,   80,   94,   97,
 /*  1100 */    98,   97,   98,    1,   17,   18,  100,   20,   91,    1,
 /*  1110 */   100,   94,  100,  100,   97,   98,  100,  100,  100,   17,
 /*  1120 */    18,  100,   20,  100,  100,   17,   18,  100,   20,
);
    const YY_SHIFT_USE_DFLT = -57;
    const YY_SHIFT_MAX = 172;
    static public $yy_shift_ofst = array(
 /*     0 */   -57,  138,   74,  -22,  106,   10,   42,  588,  556,  396,
 /*    10 */   524,  266,  234,  202,  170,  332,  428,  364,  460,  492,
 /*    20 */   298,  620,  793,  793,  793,  793,  793,  793,  793,  793,
 /*    30 */   987,  987,  987,  987,  867,  927,  914,  706,  854,  773,
 /*    40 */   974,  974,  974,  974,  974,   73,   73,   73,   73,   73,
 /*    50 */    73, 1108,  227,  308,  -56,  323,  485,  549,  669,  389,
 /*    60 */   453,  354,   35,   41,  800,  654, 1102, 1087,  613,  598,
 /*    70 */     0,  829,  421,  374,  -56,  517,   73,   73,   73,   73,
 /*    80 */    73,   73,   73,   73,  173,  -52,  -57,  -57,  -57,  -57,
 /*    90 */   -57,  -57,  -57,  -57,  -57,  -57,  -57,  -57,  -57,  -57,
 /*   100 */   -57,  -57,  -57,  -57,  -57,  -57,  674,  698,  712,  778,
 /*   110 */   860,  860,  140,  703,  727,  623,  590,  708,  911,  204,
 /*   120 */   756,  939,  -11,   66,  -11,    1,  171,   86,  123,   56,
 /*   130 */   -23,   77,  113,  -27,  258,  245,  239,  207,  206,  158,
 /*   140 */   209,  238,  197,  275,  226,  194,  271,  273,  218,  256,
 /*   150 */   243,  246,  249,  185,  177,  110,  278,  118,  103,   98,
 /*   160 */   -19,    2,  -14,   68,  130,  125,  134,  179,  182,  166,
 /*   170 */   150,  143,  145,
);
    const YY_REDUCE_USE_DFLT = -55;
    const YY_REDUCE_MAX = 105;
    static public $yy_reduce_ofst = array(
 /*     0 */    88,  667,  667,  667,  667,  667,  667,  667,  667,  667,
 /*    10 */   667,  667,  667,  667,  667,  667,  667,  667,  667,  667,
 /*    20 */   667,  667,  855,  813,  718,  874,  980,  972,  910,  934,
 /*    30 */  1004, 1002,  992, 1017,  769,  268,  -54,   96,   96,   96,
 /*    40 */   192,   -7,   25,   64,  128,  461,  484,  213,  162,   34,
 /*    50 */     3,  -30,  -30,  -30,  289,  -30,  -30,  -30,  247,  -30,
 /*    60 */   -30,  -30,  -30,  267,  -30,  -30,  -30,  -30,  -30,  -30,
 /*    70 */   -30,  -30,  -30,  -30,  290,  -30,  312,  305,  337,  335,
 /*    80 */   276,  254,  242,  214,  216,  231,  270,  300,  336,  236,
 /*    90 */   260,  259,  287,  240,  229,  241,  293,  334,  339,  327,
 /*   100 */   304,  322,  325,  160,  108,   99,
);
    static public $yyExpectedTokens = array(
        /* 0 */ array(),
        /* 1 */ array(22, 24, 25, 29, 31, 33, 34, 36, 37, 41, 43, 44, 45, 46, 48, 50, 53, 55, ),
        /* 2 */ array(22, 24, 25, 29, 31, 33, 34, 36, 37, 41, 43, 44, 46, 48, 49, 50, 53, 55, ),
        /* 3 */ array(22, 24, 25, 29, 31, 33, 34, 36, 37, 41, 43, 44, 45, 46, 48, 50, 53, 55, ),
        /* 4 */ array(22, 24, 25, 29, 31, 33, 34, 36, 37, 41, 42, 43, 44, 46, 48, 50, 53, 55, ),
        /* 5 */ array(22, 24, 25, 29, 31, 33, 34, 36, 37, 39, 40, 41, 44, 46, 48, 50, 53, 55, ),
        /* 6 */ array(22, 24, 25, 29, 31, 33, 34, 36, 37, 41, 43, 44, 46, 47, 48, 50, 53, 55, ),
        /* 7 */ array(22, 24, 25, 29, 31, 32, 33, 34, 36, 37, 41, 44, 46, 48, 50, 53, 55, ),
        /* 8 */ array(22, 24, 25, 29, 31, 33, 34, 36, 37, 41, 44, 45, 46, 48, 50, 53, 55, ),
        /* 9 */ array(22, 24, 25, 28, 29, 31, 33, 34, 36, 37, 41, 44, 46, 48, 50, 53, 55, ),
        /* 10 */ array(22, 24, 25, 29, 31, 32, 33, 34, 36, 37, 41, 44, 46, 48, 50, 53, 55, ),
        /* 11 */ array(22, 24, 25, 29, 31, 33, 34, 36, 37, 41, 42, 44, 46, 48, 50, 53, 55, ),
        /* 12 */ array(22, 24, 25, 29, 31, 33, 34, 36, 37, 41, 44, 46, 48, 50, 51, 53, 55, ),
        /* 13 */ array(22, 24, 25, 29, 31, 33, 34, 36, 37, 41, 44, 46, 48, 49, 50, 53, 55, ),
        /* 14 */ array(22, 24, 25, 29, 31, 33, 34, 36, 37, 41, 44, 45, 46, 48, 50, 53, 55, ),
        /* 15 */ array(22, 24, 25, 29, 31, 33, 34, 36, 37, 41, 44, 46, 47, 48, 50, 53, 55, ),
        /* 16 */ array(22, 24, 25, 29, 31, 32, 33, 34, 36, 37, 41, 44, 46, 48, 50, 53, 55, ),
        /* 17 */ array(22, 24, 25, 29, 31, 33, 34, 36, 37, 41, 44, 46, 48, 50, 51, 53, 55, ),
        /* 18 */ array(22, 24, 25, 29, 31, 33, 34, 35, 36, 37, 41, 44, 46, 48, 50, 53, 55, ),
        /* 19 */ array(22, 24, 25, 29, 31, 33, 34, 36, 37, 39, 41, 44, 46, 48, 50, 53, 55, ),
        /* 20 */ array(22, 24, 25, 29, 31, 33, 34, 36, 37, 41, 44, 46, 48, 50, 53, 54, 55, ),
        /* 21 */ array(22, 24, 25, 29, 31, 33, 34, 36, 37, 41, 44, 46, 48, 50, 53, 55, ),
        /* 22 */ array(2, 29, 31, 52, 59, 60, 61, 62, 64, 66, 69, 71, ),
        /* 23 */ array(2, 29, 31, 52, 59, 60, 61, 62, 64, 66, 69, 71, ),
        /* 24 */ array(2, 29, 31, 52, 59, 60, 61, 62, 64, 66, 69, 71, ),
        /* 25 */ array(2, 29, 31, 52, 59, 60, 61, 62, 64, 66, 69, 71, ),
        /* 26 */ array(2, 29, 31, 52, 59, 60, 61, 62, 64, 66, 69, 71, ),
        /* 27 */ array(2, 29, 31, 52, 59, 60, 61, 62, 64, 66, 69, 71, ),
        /* 28 */ array(2, 29, 31, 52, 59, 60, 61, 62, 64, 66, 69, 71, ),
        /* 29 */ array(2, 29, 31, 52, 59, 60, 61, 62, 64, 66, 69, 71, ),
        /* 30 */ array(29, 31, 52, 59, 60, 61, 62, 64, 66, 71, ),
        /* 31 */ array(29, 31, 52, 59, 60, 61, 62, 64, 66, 71, ),
        /* 32 */ array(29, 31, 52, 59, 60, 61, 62, 64, 66, 71, ),
        /* 33 */ array(29, 31, 52, 59, 60, 61, 62, 64, 66, 71, ),
        /* 34 */ array(23, 29, 30, 31, 52, 59, 60, 61, 62, 64, 66, 71, ),
        /* 35 */ array(23, 29, 31, 52, 59, 60, 61, 62, 64, 66, 71, ),
        /* 36 */ array(23, 29, 31, 52, 59, 60, 61, 62, 64, 66, 71, ),
        /* 37 */ array(23, 29, 30, 31, 38, 52, 59, 60, 61, 62, 64, 66, 71, ),
        /* 38 */ array(23, 29, 31, 38, 52, 59, 60, 61, 62, 64, 66, 71, ),
        /* 39 */ array(23, 29, 31, 38, 52, 59, 60, 61, 62, 64, 66, 71, ),
        /* 40 */ array(29, 31, 52, 59, 60, 61, 62, 64, 66, 71, ),
        /* 41 */ array(29, 31, 52, 59, 60, 61, 62, 64, 66, 71, ),
        /* 42 */ array(29, 31, 52, 59, 60, 61, 62, 64, 66, 71, ),
        /* 43 */ array(29, 31, 52, 59, 60, 61, 62, 64, 66, 71, ),
        /* 44 */ array(29, 31, 52, 59, 60, 61, 62, 64, 66, 71, ),
        /* 45 */ array(29, 31, 71, ),
        /* 46 */ array(29, 31, 71, ),
        /* 47 */ array(29, 31, 71, ),
        /* 48 */ array(29, 31, 71, ),
        /* 49 */ array(29, 31, 71, ),
        /* 50 */ array(29, 31, 71, ),
        /* 51 */ array(1, 17, 18, 20, ),
        /* 52 */ array(1, 17, 18, 20, ),
        /* 53 */ array(1, 17, 18, 20, ),
        /* 54 */ array(61, 62, 64, 66, ),
        /* 55 */ array(1, 17, 18, 20, ),
        /* 56 */ array(1, 17, 18, 20, ),
        /* 57 */ array(1, 17, 18, 20, ),
        /* 58 */ array(23, 29, 31, 71, ),
        /* 59 */ array(1, 17, 18, 20, ),
        /* 60 */ array(1, 17, 18, 20, ),
        /* 61 */ array(1, 17, 18, 20, ),
        /* 62 */ array(1, 17, 18, 20, ),
        /* 63 */ array(29, 31, 52, 71, ),
        /* 64 */ array(1, 17, 18, 20, ),
        /* 65 */ array(1, 17, 18, 20, ),
        /* 66 */ array(1, 17, 18, 20, ),
        /* 67 */ array(1, 17, 18, 20, ),
        /* 68 */ array(1, 17, 18, 20, ),
        /* 69 */ array(1, 17, 18, 20, ),
        /* 70 */ array(1, 17, 18, 20, ),
        /* 71 */ array(1, 17, 18, 20, ),
        /* 72 */ array(1, 17, 18, 20, ),
        /* 73 */ array(1, 17, 18, 20, ),
        /* 74 */ array(61, 62, 64, 66, ),
        /* 75 */ array(1, 17, 18, 20, ),
        /* 76 */ array(29, 31, 71, ),
        /* 77 */ array(29, 31, 71, ),
        /* 78 */ array(29, 31, 71, ),
        /* 79 */ array(29, 31, 71, ),
        /* 80 */ array(29, 31, 71, ),
        /* 81 */ array(29, 31, 71, ),
        /* 82 */ array(29, 31, 71, ),
        /* 83 */ array(29, 31, 71, ),
        /* 84 */ array(67, 68, ),
        /* 85 */ array(65, 68, ),
        /* 86 */ array(),
        /* 87 */ array(),
        /* 88 */ array(),
        /* 89 */ array(),
        /* 90 */ array(),
        /* 91 */ array(),
        /* 92 */ array(),
        /* 93 */ array(),
        /* 94 */ array(),
        /* 95 */ array(),
        /* 96 */ array(),
        /* 97 */ array(),
        /* 98 */ array(),
        /* 99 */ array(),
        /* 100 */ array(),
        /* 101 */ array(),
        /* 102 */ array(),
        /* 103 */ array(),
        /* 104 */ array(),
        /* 105 */ array(),
        /* 106 */ array(3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 23, ),
        /* 107 */ array(3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 63, ),
        /* 108 */ array(3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, ),
        /* 109 */ array(4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, ),
        /* 110 */ array(5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, ),
        /* 111 */ array(5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, ),
        /* 112 */ array(11, 38, 70, 72, 73, ),
        /* 113 */ array(30, 70, 72, 73, ),
        /* 114 */ array(11, 70, 72, 73, ),
        /* 115 */ array(23, 70, 72, 73, ),
        /* 116 */ array(58, 70, 72, 73, ),
        /* 117 */ array(23, 70, 72, 73, ),
        /* 118 */ array(23, 70, 72, 73, ),
        /* 119 */ array(30, 70, 72, 73, ),
        /* 120 */ array(23, 70, 72, 73, ),
        /* 121 */ array(23, 70, 72, 73, ),
        /* 122 */ array(70, 72, 73, ),
        /* 123 */ array(14, 15, 16, ),
        /* 124 */ array(70, 72, 73, ),
        /* 125 */ array(67, 68, ),
        /* 126 */ array(26, 27, ),
        /* 127 */ array(23, 52, ),
        /* 128 */ array(23, 57, ),
        /* 129 */ array(21, 57, ),
        /* 130 */ array(65, 68, ),
        /* 131 */ array(23, 57, ),
        /* 132 */ array(23, 57, ),
        /* 133 */ array(56, 57, ),
        /* 134 */ array(23, ),
        /* 135 */ array(19, ),
        /* 136 */ array(23, ),
        /* 137 */ array(23, ),
        /* 138 */ array(23, ),
        /* 139 */ array(63, ),
        /* 140 */ array(23, ),
        /* 141 */ array(23, ),
        /* 142 */ array(57, ),
        /* 143 */ array(23, ),
        /* 144 */ array(23, ),
        /* 145 */ array(23, ),
        /* 146 */ array(23, ),
        /* 147 */ array(23, ),
        /* 148 */ array(74, ),
        /* 149 */ array(23, ),
        /* 150 */ array(23, ),
        /* 151 */ array(23, ),
        /* 152 */ array(23, ),
        /* 153 */ array(23, ),
        /* 154 */ array(23, ),
        /* 155 */ array(23, ),
        /* 156 */ array(23, ),
        /* 157 */ array(23, ),
        /* 158 */ array(23, ),
        /* 159 */ array(23, ),
        /* 160 */ array(23, ),
        /* 161 */ array(23, ),
        /* 162 */ array(71, ),
        /* 163 */ array(23, ),
        /* 164 */ array(23, ),
        /* 165 */ array(71, ),
        /* 166 */ array(23, ),
        /* 167 */ array(23, ),
        /* 168 */ array(23, ),
        /* 169 */ array(23, ),
        /* 170 */ array(23, ),
        /* 171 */ array(23, ),
        /* 172 */ array(23, ),
        /* 173 */ array(),
        /* 174 */ array(),
        /* 175 */ array(),
        /* 176 */ array(),
        /* 177 */ array(),
        /* 178 */ array(),
        /* 179 */ array(),
        /* 180 */ array(),
        /* 181 */ array(),
        /* 182 */ array(),
        /* 183 */ array(),
        /* 184 */ array(),
        /* 185 */ array(),
        /* 186 */ array(),
        /* 187 */ array(),
        /* 188 */ array(),
        /* 189 */ array(),
        /* 190 */ array(),
        /* 191 */ array(),
        /* 192 */ array(),
        /* 193 */ array(),
        /* 194 */ array(),
        /* 195 */ array(),
        /* 196 */ array(),
        /* 197 */ array(),
        /* 198 */ array(),
        /* 199 */ array(),
        /* 200 */ array(),
        /* 201 */ array(),
        /* 202 */ array(),
        /* 203 */ array(),
        /* 204 */ array(),
        /* 205 */ array(),
        /* 206 */ array(),
        /* 207 */ array(),
        /* 208 */ array(),
        /* 209 */ array(),
        /* 210 */ array(),
        /* 211 */ array(),
        /* 212 */ array(),
        /* 213 */ array(),
        /* 214 */ array(),
        /* 215 */ array(),
        /* 216 */ array(),
        /* 217 */ array(),
        /* 218 */ array(),
        /* 219 */ array(),
        /* 220 */ array(),
        /* 221 */ array(),
        /* 222 */ array(),
        /* 223 */ array(),
        /* 224 */ array(),
        /* 225 */ array(),
        /* 226 */ array(),
        /* 227 */ array(),
        /* 228 */ array(),
        /* 229 */ array(),
        /* 230 */ array(),
        /* 231 */ array(),
        /* 232 */ array(),
        /* 233 */ array(),
        /* 234 */ array(),
        /* 235 */ array(),
        /* 236 */ array(),
        /* 237 */ array(),
        /* 238 */ array(),
        /* 239 */ array(),
        /* 240 */ array(),
        /* 241 */ array(),
        /* 242 */ array(),
        /* 243 */ array(),
        /* 244 */ array(),
        /* 245 */ array(),
        /* 246 */ array(),
);
    static public $yy_default = array(
 /*     0 */   249,  332,  332,  332,  332,  332,  332,  332,  332,  332,
 /*    10 */   332,  332,  332,  332,  332,  332,  332,  332,  332,  332,
 /*    20 */   332,  332,  332,  332,  332,  332,  332,  332,  332,  332,
 /*    30 */   332,  332,  332,  332,  332,  332,  332,  332,  332,  332,
 /*    40 */   332,  332,  332,  332,  332,  332,  332,  332,  332,  332,
 /*    50 */   332,  332,  332,  332,  332,  332,  332,  332,  332,  332,
 /*    60 */   332,  332,  332,  332,  332,  332,  332,  247,  332,  332,
 /*    70 */   332,  332,  332,  332,  332,  332,  332,  332,  332,  332,
 /*    80 */   332,  332,  332,  332,  332,  332,  249,  249,  249,  249,
 /*    90 */   249,  249,  249,  249,  249,  249,  249,  249,  249,  249,
 /*   100 */   249,  249,  249,  249,  249,  249,  332,  332,  319,  320,
 /*   110 */   321,  323,  332,  332,  332,  332,  299,  332,  332,  332,
 /*   120 */   332,  332,  295,  322,  303,  332,  332,  332,  332,  332,
 /*   130 */   332,  332,  332,  332,  332,  332,  332,  332,  332,  332,
 /*   140 */   332,  332,  307,  332,  332,  332,  332,  332,  332,  332,
 /*   150 */   332,  332,  332,  332,  332,  332,  332,  332,  332,  332,
 /*   160 */   332,  332,  332,  332,  332,  332,  332,  332,  332,  332,
 /*   170 */   332,  332,  332,  310,  325,  253,  324,  311,  248,  250,
 /*   180 */   313,  254,  271,  327,  283,  308,  285,  292,  305,  293,
 /*   190 */   252,  304,  306,  326,  312,  309,  328,  255,  267,  278,
 /*   200 */   277,  268,  297,  266,  279,  264,  281,  280,  265,  298,
 /*   210 */   296,  301,  302,  272,  270,  273,  274,  276,  269,  275,
 /*   220 */   300,  263,  282,  316,  314,  289,  329,  288,  290,  291,
 /*   230 */   294,  315,  317,  318,  330,  331,  260,  284,  261,  262,
 /*   240 */   259,  258,  287,  256,  257,  286,  251,
);
/* The next thing included is series of defines which control
** various aspects of the generated parser.
**    self::YYNOCODE      is a number which corresponds
**                        to no legal terminal or nonterminal number.  This
**                        number is used to fill in empty slots of the hash 
**                        table.
**    self::YYFALLBACK    If defined, this indicates that one or more tokens
**                        have fall-back values which should be used if the
**                        original value of the token will not parse.
**    self::YYSTACKDEPTH  is the maximum depth of the parser's stack.
**    self::YYNSTATE      the combined number of states.
**    self::YYNRULE       the number of rules in the grammar
**    self::YYERRORSYMBOL is the code number of the error symbol.  If not
**                        defined, then do no error processing.
*/
    const YYNOCODE = 101;
    const YYSTACKDEPTH = 100;
    const YYNSTATE = 247;
    const YYNRULE = 85;
    const YYERRORSYMBOL = 75;
    const YYERRSYMDT = 'yy0';
    const YYFALLBACK = 0;
    /** The next table maps tokens into fallback tokens.  If a construct
     * like the following:
     * 
     *      %fallback ID X Y Z.
     *
     * appears in the grammer, then ID becomes a fallback token for X, Y,
     * and Z.  Whenever one of the tokens X, Y, or Z is input to the parser
     * but it does not parse, the type of the token is changed to ID and
     * the parse is retried before an error is thrown.
     */
    static public $yyFallback = array(
    );
    /**
     * Turn parser tracing on by giving a stream to which to write the trace
     * and a prompt to preface each trace message.  Tracing is turned off
     * by making either argument NULL 
     *
     * Inputs:
     * 
     * - A stream resource to which trace output should be written.
     *   If NULL, then tracing is turned off.
     * - A prefix string written at the beginning of every
     *   line of trace output.  If NULL, then tracing is
     *   turned off.
     *
     * Outputs:
     * 
     * - None.
     * @param resource
     * @param string
     */
    static function Trace($TraceFILE, $zTracePrompt)
    {
        if (!$TraceFILE) {
            $zTracePrompt = 0;
        } elseif (!$zTracePrompt) {
            $TraceFILE = 0;
        }
        self::$yyTraceFILE = $TraceFILE;
        self::$yyTracePrompt = $zTracePrompt;
    }

    /**
     * Output debug information to output (php://output stream)
     */
    static function PrintTrace()
    {
        self::$yyTraceFILE = fopen('php://output', 'w');
        self::$yyTracePrompt = '';
    }

    /**
     * @var resource|0
     */
    static public $yyTraceFILE;
    /**
     * String to prepend to debug output
     * @var string|0
     */
    static public $yyTracePrompt;
    /**
     * @var int
     */
    public $yyidx;                    /* Index of top element in stack */
    /**
     * @var int
     */
    public $yyerrcnt;                 /* Shifts left before out of the error */
    /**
     * @var array
     */
    public $yystack = array();  /* The parser's stack */

    /**
     * For tracing shifts, the names of all terminals and nonterminals
     * are required.  The following table supplies these names
     * @var array
     */
    static public $yyTokenName = array( 
  '$',             'T_OPEN_TAG',    'T_NOT',         'T_AND',       
  'T_OR',          'T_EQ',          'T_NE',          'T_GT',        
  'T_GE',          'T_LT',          'T_LE',          'T_IN',        
  'T_PLUS',        'T_MINUS',       'T_TIMES',       'T_DIV',       
  'T_MOD',         'T_HTML',        'T_COMMENT_OPEN',  'T_COMMENT',   
  'T_PRINT_OPEN',  'T_PRINT_CLOSE',  'T_EXTENDS',     'T_CLOSE_TAG', 
  'T_INCLUDE',     'T_AUTOESCAPE',  'T_OFF',         'T_ON',        
  'T_END_AUTOESCAPE',  'T_CUSTOM_TAG',  'T_AS',          'T_CUSTOM_BLOCK',
  'T_CUSTOM_END',  'T_SPACEFULL',   'T_WITH',        'T_ENDWITH',   
  'T_LOAD',        'T_FOR',         'T_COMMA',       'T_CLOSEFOR',  
  'T_EMPTY',       'T_IF',          'T_ENDIF',       'T_ELSE',      
  'T_IFCHANGED',   'T_ENDIFCHANGED',  'T_IFEQUAL',     'T_END_IFEQUAL',
  'T_IFNOTEQUAL',  'T_END_IFNOTEQUAL',  'T_BLOCK',       'T_END_BLOCK', 
  'T_NUMERIC',     'T_FILTER',      'T_END_FILTER',  'T_REGROUP',   
  'T_BY',          'T_PIPE',        'T_COLON',       'T_TRUE',      
  'T_FALSE',       'T_STRING',      'T_INTL',        'T_RPARENT',   
  'T_STRING_SINGLE_INIT',  'T_STRING_SINGLE_END',  'T_STRING_DOUBLE_INIT',  'T_STRING_DOUBLE_END',
  'T_STRING_CONTENT',  'T_LPARENT',     'T_OBJ',         'T_ALPHA',     
  'T_DOT',         'T_BRACKETS_OPEN',  'T_BRACKETS_CLOSE',  'error',       
  'start',         'body',          'code',          'stmts',       
  'filtered_var',  'var_or_string',  'stmt',          'for_stmt',    
  'ifchanged_stmt',  'block_stmt',    'filter_stmt',   'if_stmt',     
  'custom_tag',    'alias',         'ifequal',       'varname',     
  'params',        'regroup',       'string',        'for_def',     
  'expr',          'fvar_or_string',  'varname_args',  's_content',   
    );

    /**
     * For tracing reduce actions, the names of all rules are required.
     * @var array
     */
    static public $yyRuleName = array(
 /*   0 */ "start ::= body",
 /*   1 */ "body ::= body code",
 /*   2 */ "body ::=",
 /*   3 */ "code ::= T_OPEN_TAG stmts",
 /*   4 */ "code ::= T_HTML",
 /*   5 */ "code ::= T_COMMENT_OPEN T_COMMENT",
 /*   6 */ "code ::= T_PRINT_OPEN filtered_var T_PRINT_CLOSE",
 /*   7 */ "stmts ::= T_EXTENDS var_or_string T_CLOSE_TAG",
 /*   8 */ "stmts ::= stmt T_CLOSE_TAG",
 /*   9 */ "stmts ::= for_stmt",
 /*  10 */ "stmts ::= ifchanged_stmt",
 /*  11 */ "stmts ::= block_stmt",
 /*  12 */ "stmts ::= filter_stmt",
 /*  13 */ "stmts ::= if_stmt",
 /*  14 */ "stmts ::= T_INCLUDE var_or_string T_CLOSE_TAG",
 /*  15 */ "stmts ::= custom_tag",
 /*  16 */ "stmts ::= alias",
 /*  17 */ "stmts ::= ifequal",
 /*  18 */ "stmts ::= T_AUTOESCAPE T_OFF|T_ON T_CLOSE_TAG body T_OPEN_TAG T_END_AUTOESCAPE T_CLOSE_TAG",
 /*  19 */ "custom_tag ::= T_CUSTOM_TAG T_CLOSE_TAG",
 /*  20 */ "custom_tag ::= T_CUSTOM_TAG T_AS varname T_CLOSE_TAG",
 /*  21 */ "custom_tag ::= T_CUSTOM_TAG params T_CLOSE_TAG",
 /*  22 */ "custom_tag ::= T_CUSTOM_TAG params T_AS varname T_CLOSE_TAG",
 /*  23 */ "custom_tag ::= T_CUSTOM_BLOCK T_CLOSE_TAG body T_OPEN_TAG T_CUSTOM_END T_CLOSE_TAG",
 /*  24 */ "custom_tag ::= T_CUSTOM_BLOCK params T_CLOSE_TAG body T_OPEN_TAG T_CUSTOM_END T_CLOSE_TAG",
 /*  25 */ "custom_tag ::= T_SPACEFULL T_CLOSE_TAG body T_OPEN_TAG T_CUSTOM_END T_CLOSE_TAG",
 /*  26 */ "alias ::= T_WITH varname T_AS varname T_CLOSE_TAG body T_OPEN_TAG T_ENDWITH T_CLOSE_TAG",
 /*  27 */ "stmt ::= regroup",
 /*  28 */ "stmt ::= T_LOAD string",
 /*  29 */ "for_def ::= T_FOR varname T_IN filtered_var T_CLOSE_TAG",
 /*  30 */ "for_def ::= T_FOR varname T_COMMA varname T_IN filtered_var T_CLOSE_TAG",
 /*  31 */ "for_stmt ::= for_def body T_OPEN_TAG T_CLOSEFOR T_CLOSE_TAG",
 /*  32 */ "for_stmt ::= for_def body T_OPEN_TAG T_EMPTY T_CLOSE_TAG body T_OPEN_TAG T_CLOSEFOR T_CLOSE_TAG",
 /*  33 */ "if_stmt ::= T_IF expr T_CLOSE_TAG body T_OPEN_TAG T_ENDIF T_CLOSE_TAG",
 /*  34 */ "if_stmt ::= T_IF expr T_CLOSE_TAG body T_OPEN_TAG T_ELSE T_CLOSE_TAG body T_OPEN_TAG T_ENDIF T_CLOSE_TAG",
 /*  35 */ "ifchanged_stmt ::= T_IFCHANGED T_CLOSE_TAG body T_OPEN_TAG T_ENDIFCHANGED T_CLOSE_TAG",
 /*  36 */ "ifchanged_stmt ::= T_IFCHANGED params T_CLOSE_TAG body T_OPEN_TAG T_ENDIFCHANGED T_CLOSE_TAG",
 /*  37 */ "ifchanged_stmt ::= T_IFCHANGED T_CLOSE_TAG body T_OPEN_TAG T_ELSE T_CLOSE_TAG body T_OPEN_TAG T_ENDIFCHANGED T_CLOSE_TAG",
 /*  38 */ "ifchanged_stmt ::= T_IFCHANGED params T_CLOSE_TAG body T_OPEN_TAG T_ELSE T_CLOSE_TAG body T_OPEN_TAG T_ENDIFCHANGED T_CLOSE_TAG",
 /*  39 */ "ifequal ::= T_IFEQUAL fvar_or_string fvar_or_string T_CLOSE_TAG body T_OPEN_TAG T_END_IFEQUAL T_CLOSE_TAG",
 /*  40 */ "ifequal ::= T_IFEQUAL fvar_or_string fvar_or_string T_CLOSE_TAG body T_OPEN_TAG T_ELSE T_CLOSE_TAG body T_OPEN_TAG T_END_IFEQUAL T_CLOSE_TAG",
 /*  41 */ "ifequal ::= T_IFNOTEQUAL fvar_or_string fvar_or_string T_CLOSE_TAG body T_OPEN_TAG T_END_IFNOTEQUAL T_CLOSE_TAG",
 /*  42 */ "ifequal ::= T_IFNOTEQUAL fvar_or_string fvar_or_string T_CLOSE_TAG body T_OPEN_TAG T_ELSE T_CLOSE_TAG body T_OPEN_TAG T_END_IFNOTEQUAL T_CLOSE_TAG",
 /*  43 */ "block_stmt ::= T_BLOCK varname T_CLOSE_TAG body T_OPEN_TAG T_END_BLOCK T_CLOSE_TAG",
 /*  44 */ "block_stmt ::= T_BLOCK varname T_CLOSE_TAG body T_OPEN_TAG T_END_BLOCK varname T_CLOSE_TAG",
 /*  45 */ "block_stmt ::= T_BLOCK T_NUMERIC T_CLOSE_TAG body T_OPEN_TAG T_END_BLOCK T_CLOSE_TAG",
 /*  46 */ "block_stmt ::= T_BLOCK T_NUMERIC T_CLOSE_TAG body T_OPEN_TAG T_END_BLOCK T_NUMERIC T_CLOSE_TAG",
 /*  47 */ "filter_stmt ::= T_FILTER filtered_var T_CLOSE_TAG body T_OPEN_TAG T_END_FILTER T_CLOSE_TAG",
 /*  48 */ "regroup ::= T_REGROUP filtered_var T_BY varname T_AS varname",
 /*  49 */ "filtered_var ::= filtered_var T_PIPE varname_args",
 /*  50 */ "filtered_var ::= varname_args",
 /*  51 */ "varname_args ::= varname T_COLON var_or_string",
 /*  52 */ "varname_args ::= varname",
 /*  53 */ "params ::= params var_or_string",
 /*  54 */ "params ::= params T_COMMA var_or_string",
 /*  55 */ "params ::= var_or_string",
 /*  56 */ "var_or_string ::= varname",
 /*  57 */ "var_or_string ::= T_NUMERIC",
 /*  58 */ "var_or_string ::= T_TRUE|T_FALSE",
 /*  59 */ "var_or_string ::= string",
 /*  60 */ "fvar_or_string ::= filtered_var",
 /*  61 */ "fvar_or_string ::= T_NUMERIC",
 /*  62 */ "fvar_or_string ::= T_TRUE|T_FALSE",
 /*  63 */ "fvar_or_string ::= string",
 /*  64 */ "string ::= T_STRING",
 /*  65 */ "string ::= T_INTL string T_RPARENT",
 /*  66 */ "string ::= T_STRING_SINGLE_INIT T_STRING_SINGLE_END",
 /*  67 */ "string ::= T_STRING_DOUBLE_INIT T_STRING_DOUBLE_END",
 /*  68 */ "string ::= T_STRING_SINGLE_INIT s_content T_STRING_SINGLE_END",
 /*  69 */ "string ::= T_STRING_DOUBLE_INIT s_content T_STRING_DOUBLE_END",
 /*  70 */ "s_content ::= s_content T_STRING_CONTENT",
 /*  71 */ "s_content ::= T_STRING_CONTENT",
 /*  72 */ "expr ::= T_NOT expr",
 /*  73 */ "expr ::= expr T_AND expr",
 /*  74 */ "expr ::= expr T_OR expr",
 /*  75 */ "expr ::= expr T_PLUS|T_MINUS expr",
 /*  76 */ "expr ::= expr T_EQ|T_NE|T_GT|T_GE|T_LT|T_LE|T_IN expr",
 /*  77 */ "expr ::= expr T_TIMES|T_DIV|T_MOD expr",
 /*  78 */ "expr ::= T_LPARENT expr T_RPARENT",
 /*  79 */ "expr ::= fvar_or_string",
 /*  80 */ "varname ::= varname T_OBJ T_ALPHA",
 /*  81 */ "varname ::= varname T_DOT T_ALPHA",
 /*  82 */ "varname ::= varname T_BRACKETS_OPEN var_or_string T_BRACKETS_CLOSE",
 /*  83 */ "varname ::= T_ALPHA",
 /*  84 */ "varname ::= T_CUSTOM_TAG|T_CUSTOM_BLOCK",
    );

    /**
     * This function returns the symbolic name associated with a token
     * value.
     * @param int
     * @return string
     */
    function tokenName($tokenType)
    {
        if ($tokenType === 0) {
            return 'End of Input';
        }
        if ($tokenType > 0 && $tokenType < count(self::$yyTokenName)) {
            return self::$yyTokenName[$tokenType];
        } else {
            return "Unknown";
        }
    }

    /**
     * The following function deletes the value associated with a
     * symbol.  The symbol can be either a terminal or nonterminal.
     * @param int the symbol code
     * @param mixed the symbol's value
     */
    static function yy_destructor($yymajor, $yypminor)
    {
        switch ($yymajor) {
        /* Here is inserted the actions which take place when a
        ** terminal or non-terminal is destroyed.  This can happen
        ** when the symbol is popped from the stack during a
        ** reduce or during error processing or when a parser is 
        ** being destroyed before it is finished parsing.
        **
        ** Note: during a reduce, the only symbols destroyed are those
        ** which appear on the RHS of the rule, but which are not used
        ** inside the C code.
        */
            default:  break;   /* If no destructor action specified: do nothing */
        }
    }

    /**
     * Pop the parser's stack once.
     *
     * If there is a destructor routine associated with the token which
     * is popped from the stack, then call it.
     *
     * Return the major token number for the symbol popped.
     * @param Haanga_yyParser
     * @return int
     */
    function yy_pop_parser_stack()
    {
        if (!count($this->yystack)) {
            return;
        }
        $yytos = array_pop($this->yystack);
        if (self::$yyTraceFILE && $this->yyidx >= 0) {
            fwrite(self::$yyTraceFILE,
                self::$yyTracePrompt . 'Popping ' . self::$yyTokenName[$yytos->major] .
                    "\n");
        }
        $yymajor = $yytos->major;
        self::yy_destructor($yymajor, $yytos->minor);
        $this->yyidx--;
        return $yymajor;
    }

    /**
     * Deallocate and destroy a parser.  Destructors are all called for
     * all stack elements before shutting the parser down.
     */
    function __destruct()
    {
        while ($this->yyidx >= 0) {
            $this->yy_pop_parser_stack();
        }
        if (is_resource(self::$yyTraceFILE)) {
            fclose(self::$yyTraceFILE);
        }
    }

    /**
     * Based on the current state and parser stack, get a list of all
     * possible lookahead tokens
     * @param int
     * @return array
     */
    function yy_get_expected_tokens($token)
    {
        $state = $this->yystack[$this->yyidx]->stateno;
        $expected = self::$yyExpectedTokens[$state];
        if (in_array($token, self::$yyExpectedTokens[$state], true)) {
            return $expected;
        }
        $stack = $this->yystack;
        $yyidx = $this->yyidx;
        do {
            $yyact = $this->yy_find_shift_action($token);
            if ($yyact >= self::YYNSTATE && $yyact < self::YYNSTATE + self::YYNRULE) {
                // reduce action
                $done = 0;
                do {
                    if ($done++ == 100) {
                        $this->yyidx = $yyidx;
                        $this->yystack = $stack;
                        // too much recursion prevents proper detection
                        // so give up
                        return array_unique($expected);
                    }
                    $yyruleno = $yyact - self::YYNSTATE;
                    $this->yyidx -= self::$yyRuleInfo[$yyruleno]['rhs'];
                    $nextstate = $this->yy_find_reduce_action(
                        $this->yystack[$this->yyidx]->stateno,
                        self::$yyRuleInfo[$yyruleno]['lhs']);
                    if (isset(self::$yyExpectedTokens[$nextstate])) {
                        $expected += self::$yyExpectedTokens[$nextstate];
                            if (in_array($token,
                                  self::$yyExpectedTokens[$nextstate], true)) {
                            $this->yyidx = $yyidx;
                            $this->yystack = $stack;
                            return array_unique($expected);
                        }
                    }
                    if ($nextstate < self::YYNSTATE) {
                        // we need to shift a non-terminal
                        $this->yyidx++;
                        $x = new Haanga_yyStackEntry;
                        $x->stateno = $nextstate;
                        $x->major = self::$yyRuleInfo[$yyruleno]['lhs'];
                        $this->yystack[$this->yyidx] = $x;
                        continue 2;
                    } elseif ($nextstate == self::YYNSTATE + self::YYNRULE + 1) {
                        $this->yyidx = $yyidx;
                        $this->yystack = $stack;
                        // the last token was just ignored, we can't accept
                        // by ignoring input, this is in essence ignoring a
                        // syntax error!
                        return array_unique($expected);
                    } elseif ($nextstate === self::YY_NO_ACTION) {
                        $this->yyidx = $yyidx;
                        $this->yystack = $stack;
                        // input accepted, but not shifted (I guess)
                        return $expected;
                    } else {
                        $yyact = $nextstate;
                    }
                } while (true);
            }
            break;
        } while (true);
        return array_unique($expected);
    }

    /**
     * Based on the parser state and current parser stack, determine whether
     * the lookahead token is possible.
     * 
     * The parser will convert the token value to an error token if not.  This
     * catches some unusual edge cases where the parser would fail.
     * @param int
     * @return bool
     */
    function yy_is_expected_token($token)
    {
        if ($token === 0) {
            return true; // 0 is not part of this
        }
        $state = $this->yystack[$this->yyidx]->stateno;
        if (in_array($token, self::$yyExpectedTokens[$state], true)) {
            return true;
        }
        $stack = $this->yystack;
        $yyidx = $this->yyidx;
        do {
            $yyact = $this->yy_find_shift_action($token);
            if ($yyact >= self::YYNSTATE && $yyact < self::YYNSTATE + self::YYNRULE) {
                // reduce action
                $done = 0;
                do {
                    if ($done++ == 100) {
                        $this->yyidx = $yyidx;
                        $this->yystack = $stack;
                        // too much recursion prevents proper detection
                        // so give up
                        return true;
                    }
                    $yyruleno = $yyact - self::YYNSTATE;
                    $this->yyidx -= self::$yyRuleInfo[$yyruleno]['rhs'];
                    $nextstate = $this->yy_find_reduce_action(
                        $this->yystack[$this->yyidx]->stateno,
                        self::$yyRuleInfo[$yyruleno]['lhs']);
                    if (isset(self::$yyExpectedTokens[$nextstate]) &&
                          in_array($token, self::$yyExpectedTokens[$nextstate], true)) {
                        $this->yyidx = $yyidx;
                        $this->yystack = $stack;
                        return true;
                    }
                    if ($nextstate < self::YYNSTATE) {
                        // we need to shift a non-terminal
                        $this->yyidx++;
                        $x = new Haanga_yyStackEntry;
                        $x->stateno = $nextstate;
                        $x->major = self::$yyRuleInfo[$yyruleno]['lhs'];
                        $this->yystack[$this->yyidx] = $x;
                        continue 2;
                    } elseif ($nextstate == self::YYNSTATE + self::YYNRULE + 1) {
                        $this->yyidx = $yyidx;
                        $this->yystack = $stack;
                        if (!$token) {
                            // end of input: this is valid
                            return true;
                        }
                        // the last token was just ignored, we can't accept
                        // by ignoring input, this is in essence ignoring a
                        // syntax error!
                        return false;
                    } elseif ($nextstate === self::YY_NO_ACTION) {
                        $this->yyidx = $yyidx;
                        $this->yystack = $stack;
                        // input accepted, but not shifted (I guess)
                        return true;
                    } else {
                        $yyact = $nextstate;
                    }
                } while (true);
            }
            break;
        } while (true);
        $this->yyidx = $yyidx;
        $this->yystack = $stack;
        return true;
    }

    /**
     * Find the appropriate action for a parser given the terminal
     * look-ahead token iLookAhead.
     *
     * If the look-ahead token is YYNOCODE, then check to see if the action is
     * independent of the look-ahead.  If it is, return the action, otherwise
     * return YY_NO_ACTION.
     * @param int The look-ahead token
     */
    function yy_find_shift_action($iLookAhead)
    {
        $stateno = $this->yystack[$this->yyidx]->stateno;
     
        /* if ($this->yyidx < 0) return self::YY_NO_ACTION;  */
        if (!isset(self::$yy_shift_ofst[$stateno])) {
            // no shift actions
            return self::$yy_default[$stateno];
        }
        $i = self::$yy_shift_ofst[$stateno];
        if ($i === self::YY_SHIFT_USE_DFLT) {
            return self::$yy_default[$stateno];
        }
        if ($iLookAhead == self::YYNOCODE) {
            return self::YY_NO_ACTION;
        }
        $i += $iLookAhead;
        if ($i < 0 || $i >= self::YY_SZ_ACTTAB ||
              self::$yy_lookahead[$i] != $iLookAhead) {
            if (count(self::$yyFallback) && $iLookAhead < count(self::$yyFallback)
                   && ($iFallback = self::$yyFallback[$iLookAhead]) != 0) {
                if (self::$yyTraceFILE) {
                    fwrite(self::$yyTraceFILE, self::$yyTracePrompt . "FALLBACK " .
                        self::$yyTokenName[$iLookAhead] . " => " .
                        self::$yyTokenName[$iFallback] . "\n");
                }
                return $this->yy_find_shift_action($iFallback);
            }
            return self::$yy_default[$stateno];
        } else {
            return self::$yy_action[$i];
        }
    }

    /**
     * Find the appropriate action for a parser given the non-terminal
     * look-ahead token $iLookAhead.
     *
     * If the look-ahead token is self::YYNOCODE, then check to see if the action is
     * independent of the look-ahead.  If it is, return the action, otherwise
     * return self::YY_NO_ACTION.
     * @param int Current state number
     * @param int The look-ahead token
     */
    function yy_find_reduce_action($stateno, $iLookAhead)
    {
        /* $stateno = $this->yystack[$this->yyidx]->stateno; */

        if (!isset(self::$yy_reduce_ofst[$stateno])) {
            return self::$yy_default[$stateno];
        }
        $i = self::$yy_reduce_ofst[$stateno];
        if ($i == self::YY_REDUCE_USE_DFLT) {
            return self::$yy_default[$stateno];
        }
        if ($iLookAhead == self::YYNOCODE) {
            return self::YY_NO_ACTION;
        }
        $i += $iLookAhead;
        if ($i < 0 || $i >= self::YY_SZ_ACTTAB ||
              self::$yy_lookahead[$i] != $iLookAhead) {
            return self::$yy_default[$stateno];
        } else {
            return self::$yy_action[$i];
        }
    }

    /**
     * Perform a shift action.
     * @param int The new state to shift in
     * @param int The major token to shift in
     * @param mixed the minor token to shift in
     */
    function yy_shift($yyNewState, $yyMajor, $yypMinor)
    {
        $this->yyidx++;
        if ($this->yyidx >= self::YYSTACKDEPTH) {
            $this->yyidx--;
            if (self::$yyTraceFILE) {
                fprintf(self::$yyTraceFILE, "%sStack Overflow!\n", self::$yyTracePrompt);
            }
            while ($this->yyidx >= 0) {
                $this->yy_pop_parser_stack();
            }
            /* Here code is inserted which will execute if the parser
            ** stack ever overflows */
            return;
        }
        $yytos = new Haanga_yyStackEntry;
        $yytos->stateno = $yyNewState;
        $yytos->major = $yyMajor;
        $yytos->minor = $yypMinor;
        array_push($this->yystack, $yytos);
        if (self::$yyTraceFILE && $this->yyidx > 0) {
            fprintf(self::$yyTraceFILE, "%sShift %d\n", self::$yyTracePrompt,
                $yyNewState);
            fprintf(self::$yyTraceFILE, "%sStack:", self::$yyTracePrompt);
            for($i = 1; $i <= $this->yyidx; $i++) {
                fprintf(self::$yyTraceFILE, " %s",
                    self::$yyTokenName[$this->yystack[$i]->major]);
            }
            fwrite(self::$yyTraceFILE,"\n");
        }
    }

    /**
     * The following table contains information about every rule that
     * is used during the reduce.
     *
     * <pre>
     * array(
     *  array(
     *   int $lhs;         Symbol on the left-hand side of the rule
     *   int $nrhs;     Number of right-hand side symbols in the rule
     *  ),...
     * );
     * </pre>
     */
    static public $yyRuleInfo = array(
  array( 'lhs' => 76, 'rhs' => 1 ),
  array( 'lhs' => 77, 'rhs' => 2 ),
  array( 'lhs' => 77, 'rhs' => 0 ),
  array( 'lhs' => 78, 'rhs' => 2 ),
  array( 'lhs' => 78, 'rhs' => 1 ),
  array( 'lhs' => 78, 'rhs' => 2 ),
  array( 'lhs' => 78, 'rhs' => 3 ),
  array( 'lhs' => 79, 'rhs' => 3 ),
  array( 'lhs' => 79, 'rhs' => 2 ),
  array( 'lhs' => 79, 'rhs' => 1 ),
  array( 'lhs' => 79, 'rhs' => 1 ),
  array( 'lhs' => 79, 'rhs' => 1 ),
  array( 'lhs' => 79, 'rhs' => 1 ),
  array( 'lhs' => 79, 'rhs' => 1 ),
  array( 'lhs' => 79, 'rhs' => 3 ),
  array( 'lhs' => 79, 'rhs' => 1 ),
  array( 'lhs' => 79, 'rhs' => 1 ),
  array( 'lhs' => 79, 'rhs' => 1 ),
  array( 'lhs' => 79, 'rhs' => 7 ),
  array( 'lhs' => 88, 'rhs' => 2 ),
  array( 'lhs' => 88, 'rhs' => 4 ),
  array( 'lhs' => 88, 'rhs' => 3 ),
  array( 'lhs' => 88, 'rhs' => 5 ),
  array( 'lhs' => 88, 'rhs' => 6 ),
  array( 'lhs' => 88, 'rhs' => 7 ),
  array( 'lhs' => 88, 'rhs' => 6 ),
  array( 'lhs' => 89, 'rhs' => 9 ),
  array( 'lhs' => 82, 'rhs' => 1 ),
  array( 'lhs' => 82, 'rhs' => 2 ),
  array( 'lhs' => 95, 'rhs' => 5 ),
  array( 'lhs' => 95, 'rhs' => 7 ),
  array( 'lhs' => 83, 'rhs' => 5 ),
  array( 'lhs' => 83, 'rhs' => 9 ),
  array( 'lhs' => 87, 'rhs' => 7 ),
  array( 'lhs' => 87, 'rhs' => 11 ),
  array( 'lhs' => 84, 'rhs' => 6 ),
  array( 'lhs' => 84, 'rhs' => 7 ),
  array( 'lhs' => 84, 'rhs' => 10 ),
  array( 'lhs' => 84, 'rhs' => 11 ),
  array( 'lhs' => 90, 'rhs' => 8 ),
  array( 'lhs' => 90, 'rhs' => 12 ),
  array( 'lhs' => 90, 'rhs' => 8 ),
  array( 'lhs' => 90, 'rhs' => 12 ),
  array( 'lhs' => 85, 'rhs' => 7 ),
  array( 'lhs' => 85, 'rhs' => 8 ),
  array( 'lhs' => 85, 'rhs' => 7 ),
  array( 'lhs' => 85, 'rhs' => 8 ),
  array( 'lhs' => 86, 'rhs' => 7 ),
  array( 'lhs' => 93, 'rhs' => 6 ),
  array( 'lhs' => 80, 'rhs' => 3 ),
  array( 'lhs' => 80, 'rhs' => 1 ),
  array( 'lhs' => 98, 'rhs' => 3 ),
  array( 'lhs' => 98, 'rhs' => 1 ),
  array( 'lhs' => 92, 'rhs' => 2 ),
  array( 'lhs' => 92, 'rhs' => 3 ),
  array( 'lhs' => 92, 'rhs' => 1 ),
  array( 'lhs' => 81, 'rhs' => 1 ),
  array( 'lhs' => 81, 'rhs' => 1 ),
  array( 'lhs' => 81, 'rhs' => 1 ),
  array( 'lhs' => 81, 'rhs' => 1 ),
  array( 'lhs' => 97, 'rhs' => 1 ),
  array( 'lhs' => 97, 'rhs' => 1 ),
  array( 'lhs' => 97, 'rhs' => 1 ),
  array( 'lhs' => 97, 'rhs' => 1 ),
  array( 'lhs' => 94, 'rhs' => 1 ),
  array( 'lhs' => 94, 'rhs' => 3 ),
  array( 'lhs' => 94, 'rhs' => 2 ),
  array( 'lhs' => 94, 'rhs' => 2 ),
  array( 'lhs' => 94, 'rhs' => 3 ),
  array( 'lhs' => 94, 'rhs' => 3 ),
  array( 'lhs' => 99, 'rhs' => 2 ),
  array( 'lhs' => 99, 'rhs' => 1 ),
  array( 'lhs' => 96, 'rhs' => 2 ),
  array( 'lhs' => 96, 'rhs' => 3 ),
  array( 'lhs' => 96, 'rhs' => 3 ),
  array( 'lhs' => 96, 'rhs' => 3 ),
  array( 'lhs' => 96, 'rhs' => 3 ),
  array( 'lhs' => 96, 'rhs' => 3 ),
  array( 'lhs' => 96, 'rhs' => 3 ),
  array( 'lhs' => 96, 'rhs' => 1 ),
  array( 'lhs' => 91, 'rhs' => 3 ),
  array( 'lhs' => 91, 'rhs' => 3 ),
  array( 'lhs' => 91, 'rhs' => 4 ),
  array( 'lhs' => 91, 'rhs' => 1 ),
  array( 'lhs' => 91, 'rhs' => 1 ),
    );

    /**
     * The following table contains a mapping of reduce action to method name
     * that handles the reduction.
     * 
     * If a rule is not set, it has no handler.
     */
    static public $yyReduceMap = array(
        0 => 0,
        1 => 1,
        2 => 2,
        3 => 3,
        4 => 4,
        5 => 5,
        6 => 6,
        7 => 7,
        8 => 8,
        65 => 8,
        9 => 9,
        10 => 9,
        11 => 9,
        12 => 9,
        13 => 9,
        15 => 9,
        16 => 9,
        17 => 9,
        27 => 9,
        52 => 9,
        64 => 9,
        71 => 9,
        79 => 9,
        83 => 9,
        84 => 9,
        14 => 14,
        18 => 18,
        19 => 19,
        20 => 20,
        21 => 21,
        22 => 22,
        23 => 23,
        24 => 24,
        25 => 25,
        26 => 26,
        28 => 28,
        29 => 29,
        30 => 30,
        31 => 31,
        32 => 32,
        33 => 33,
        34 => 34,
        35 => 35,
        36 => 36,
        37 => 37,
        38 => 38,
        39 => 39,
        40 => 40,
        41 => 41,
        42 => 42,
        43 => 43,
        44 => 44,
        46 => 44,
        45 => 45,
        47 => 47,
        48 => 48,
        49 => 49,
        54 => 49,
        50 => 50,
        55 => 50,
        51 => 51,
        53 => 53,
        56 => 56,
        57 => 57,
        61 => 57,
        58 => 58,
        62 => 58,
        59 => 59,
        63 => 59,
        60 => 60,
        66 => 66,
        67 => 66,
        68 => 68,
        69 => 68,
        70 => 70,
        72 => 72,
        73 => 73,
        74 => 73,
        75 => 73,
        77 => 73,
        76 => 76,
        78 => 78,
        80 => 80,
        81 => 81,
        82 => 82,
    );
    /* Beginning here are the reduction cases.  A typical example
    ** follows:
    **  #line <lineno> <grammarfile>
    **   function yy_r0($yymsp){ ... }           // User supplied code
    **  #line <lineno> <thisfile>
    */
#line 79 "lib/Haanga/Compiler/Parser.y"
    function yy_r0(){ $this->body = $this->yystack[$this->yyidx + 0]->minor;     }
#line 1617 "lib/Haanga/Compiler/Parser.php"
#line 81 "lib/Haanga/Compiler/Parser.y"
    function yy_r1(){ $this->_retvalue=$this->yystack[$this->yyidx + -1]->minor; $this->_retvalue[] = $this->yystack[$this->yyidx + 0]->minor;     }
#line 1620 "lib/Haanga/Compiler/Parser.php"
#line 82 "lib/Haanga/Compiler/Parser.y"
    function yy_r2(){ $this->_retvalue = array();     }
#line 1623 "lib/Haanga/Compiler/Parser.php"
#line 85 "lib/Haanga/Compiler/Parser.y"
    function yy_r3(){ if (count($this->yystack[$this->yyidx + 0]->minor)) $this->yystack[$this->yyidx + 0]->minor['line'] = $this->lex->getLine();  $this->_retvalue = $this->yystack[$this->yyidx + 0]->minor;     }
#line 1626 "lib/Haanga/Compiler/Parser.php"
#line 86 "lib/Haanga/Compiler/Parser.y"
    function yy_r4(){ $this->_retvalue = array('operation' => 'html', 'html' => $this->yystack[$this->yyidx + 0]->minor, 'line' => $this->lex->getLine() );     }
#line 1629 "lib/Haanga/Compiler/Parser.php"
#line 87 "lib/Haanga/Compiler/Parser.y"
    function yy_r5(){ $this->yystack[$this->yyidx + 0]->minor=rtrim($this->yystack[$this->yyidx + 0]->minor); $this->_retvalue = array('operation' => 'comment', 'comment' => substr($this->yystack[$this->yyidx + 0]->minor, 0, strlen($this->yystack[$this->yyidx + 0]->minor)-2));     }
#line 1632 "lib/Haanga/Compiler/Parser.php"
#line 88 "lib/Haanga/Compiler/Parser.y"
    function yy_r6(){ $this->_retvalue = array('operation' => 'print_var', 'variable' => $this->yystack[$this->yyidx + -1]->minor, 'line' => $this->lex->getLine() );     }
#line 1635 "lib/Haanga/Compiler/Parser.php"
#line 90 "lib/Haanga/Compiler/Parser.y"
    function yy_r7(){ $this->_retvalue = array('operation' => 'base', $this->yystack[$this->yyidx + -1]->minor);     }
#line 1638 "lib/Haanga/Compiler/Parser.php"
#line 91 "lib/Haanga/Compiler/Parser.y"
    function yy_r8(){ $this->_retvalue = $this->yystack[$this->yyidx + -1]->minor;     }
#line 1641 "lib/Haanga/Compiler/Parser.php"
#line 92 "lib/Haanga/Compiler/Parser.y"
    function yy_r9(){ $this->_retvalue = $this->yystack[$this->yyidx + 0]->minor;     }
#line 1644 "lib/Haanga/Compiler/Parser.php"
#line 97 "lib/Haanga/Compiler/Parser.y"
    function yy_r14(){ $this->_retvalue = array('operation' => 'include', $this->yystack[$this->yyidx + -1]->minor);     }
#line 1647 "lib/Haanga/Compiler/Parser.php"
#line 101 "lib/Haanga/Compiler/Parser.y"
    function yy_r18(){ $this->_retvalue = array('operation' => 'autoescape', 'value' => strtolower(@$this->yystack[$this->yyidx + -5]->minor), 'body' => $this->yystack[$this->yyidx + -3]->minor);     }
#line 1650 "lib/Haanga/Compiler/Parser.php"
#line 106 "lib/Haanga/Compiler/Parser.y"
    function yy_r19(){
    $this->_retvalue = array('operation' => 'custom_tag', 'name' => $this->yystack[$this->yyidx + -1]->minor, 'list'=>array()); 
    }
#line 1655 "lib/Haanga/Compiler/Parser.php"
#line 109 "lib/Haanga/Compiler/Parser.y"
    function yy_r20(){
    $this->_retvalue = array('operation' => 'custom_tag', 'name' => $this->yystack[$this->yyidx + -3]->minor, 'as' => $this->yystack[$this->yyidx + -1]->minor, 'list'=>array()); 
    }
#line 1660 "lib/Haanga/Compiler/Parser.php"
#line 112 "lib/Haanga/Compiler/Parser.y"
    function yy_r21(){ 
    $this->_retvalue = array('operation' => 'custom_tag', 'name' => $this->yystack[$this->yyidx + -2]->minor, 'list' => $this->yystack[$this->yyidx + -1]->minor); 
    }
#line 1665 "lib/Haanga/Compiler/Parser.php"
#line 115 "lib/Haanga/Compiler/Parser.y"
    function yy_r22(){
    $this->_retvalue = array('operation' => 'custom_tag', 'name' => $this->yystack[$this->yyidx + -4]->minor, 'as' => $this->yystack[$this->yyidx + -1]->minor, 'list' => $this->yystack[$this->yyidx + -3]->minor);
    }
#line 1670 "lib/Haanga/Compiler/Parser.php"
#line 120 "lib/Haanga/Compiler/Parser.y"
    function yy_r23(){
    if ('end'.$this->yystack[$this->yyidx + -5]->minor != $this->yystack[$this->yyidx + -1]->minor) { 
        $this->error("Unexpected ".$this->yystack[$this->yyidx + -1]->minor); 
    } 
    $this->_retvalue = array('operation' => 'custom_tag', 'name' => $this->yystack[$this->yyidx + -5]->minor, 'body' => $this->yystack[$this->yyidx + -3]->minor, 'list' => array());
    }
#line 1678 "lib/Haanga/Compiler/Parser.php"
#line 126 "lib/Haanga/Compiler/Parser.y"
    function yy_r24(){
    if ('end'.$this->yystack[$this->yyidx + -6]->minor != $this->yystack[$this->yyidx + -1]->minor) { 
        $this->error("Unexpected ".$this->yystack[$this->yyidx + -1]->minor); 
    } 
    $this->_retvalue = array('operation' => 'custom_tag', 'name' => $this->yystack[$this->yyidx + -6]->minor, 'body' => $this->yystack[$this->yyidx + -3]->minor, 'list' => $this->yystack[$this->yyidx + -5]->minor);
    }
#line 1686 "lib/Haanga/Compiler/Parser.php"
#line 134 "lib/Haanga/Compiler/Parser.y"
    function yy_r25(){
    if ('endspacefull' != $this->yystack[$this->yyidx + -1]->minor) {
        $this->error("Unexpected ".$this->yystack[$this->yyidx + -1]->minor);
    } 
    $this->_retvalue = array('operation' => 'spacefull', 'body' => $this->yystack[$this->yyidx + -3]->minor);
    }
#line 1694 "lib/Haanga/Compiler/Parser.php"
#line 142 "lib/Haanga/Compiler/Parser.y"
    function yy_r26(){
    $this->_retvalue = array('operation' => 'alias', 'var' => $this->yystack[$this->yyidx + -7]->minor, 'as' => $this->yystack[$this->yyidx + -5]->minor, 'body' => $this->yystack[$this->yyidx + -3]->minor); 
    }
#line 1699 "lib/Haanga/Compiler/Parser.php"
#line 148 "lib/Haanga/Compiler/Parser.y"
    function yy_r28(){
    if (!is_file($this->yystack[$this->yyidx + 0]->minor) || !Haanga_Compiler::getOption('enable_load')) {
        $this->error($this->yystack[$this->yyidx + 0]->minor." is not a valid file"); 
    } 
    require_once $this->yystack[$this->yyidx + 0]->minor;
    }
#line 1707 "lib/Haanga/Compiler/Parser.php"
#line 156 "lib/Haanga/Compiler/Parser.y"
    function yy_r29(){
    /* Try to get the variable */
    $var = $this->compiler->get_context(is_array($this->yystack[$this->yyidx + -1]->minor[0]) ? $this->yystack[$this->yyidx + -1]->minor[0] : array($this->yystack[$this->yyidx + -1]->minor[0]));
    if (is_array($var)) {
        /* let's check if it is an object or array */
        $this->compiler->set_context($this->yystack[$this->yyidx + -3]->minor, current($var));
    }

    $this->_retvalue = array('operation' => 'loop', 'variable' => $this->yystack[$this->yyidx + -3]->minor, 'index' => NULL, 'array' => $this->yystack[$this->yyidx + -1]->minor);
    }
#line 1719 "lib/Haanga/Compiler/Parser.php"
#line 165 "lib/Haanga/Compiler/Parser.y"
    function yy_r30(){
    /* Try to get the variable */
    $var = $this->compiler->get_context(is_array($this->yystack[$this->yyidx + -1]->minor[0]) ? $this->yystack[$this->yyidx + -1]->minor[0] : array($this->yystack[$this->yyidx + -1]->minor[0]));
    if (is_array($var)) {
        /* let's check if it is an object or array */
        $this->compiler->set_context($this->yystack[$this->yyidx + -3]->minor, current($var));
    }
    $this->_retvalue = array('operation' => 'loop', 'variable' => $this->yystack[$this->yyidx + -3]->minor, 'index' => $this->yystack[$this->yyidx + -5]->minor, 'array' => $this->yystack[$this->yyidx + -1]->minor);
    }
#line 1730 "lib/Haanga/Compiler/Parser.php"
#line 174 "lib/Haanga/Compiler/Parser.y"
    function yy_r31(){ 
    $this->_retvalue = $this->yystack[$this->yyidx + -4]->minor;
    $this->_retvalue['body'] = $this->yystack[$this->yyidx + -3]->minor;
    }
#line 1736 "lib/Haanga/Compiler/Parser.php"
#line 179 "lib/Haanga/Compiler/Parser.y"
    function yy_r32(){ 
    $this->_retvalue = $this->yystack[$this->yyidx + -8]->minor;
    $this->_retvalue['body']  = $this->yystack[$this->yyidx + -7]->minor;
    $this->_retvalue['empty'] = $this->yystack[$this->yyidx + -3]->minor;
    }
#line 1743 "lib/Haanga/Compiler/Parser.php"
#line 185 "lib/Haanga/Compiler/Parser.y"
    function yy_r33(){ $this->_retvalue = array('operation' => 'if', 'expr' => $this->yystack[$this->yyidx + -5]->minor, 'body' => $this->yystack[$this->yyidx + -3]->minor);     }
#line 1746 "lib/Haanga/Compiler/Parser.php"
#line 186 "lib/Haanga/Compiler/Parser.y"
    function yy_r34(){ $this->_retvalue = array('operation' => 'if', 'expr' => $this->yystack[$this->yyidx + -9]->minor, 'body' => $this->yystack[$this->yyidx + -7]->minor, 'else' => $this->yystack[$this->yyidx + -3]->minor);     }
#line 1749 "lib/Haanga/Compiler/Parser.php"
#line 189 "lib/Haanga/Compiler/Parser.y"
    function yy_r35(){ 
    $this->_retvalue = array('operation' => 'ifchanged', 'body' => $this->yystack[$this->yyidx + -3]->minor); 
    }
#line 1754 "lib/Haanga/Compiler/Parser.php"
#line 193 "lib/Haanga/Compiler/Parser.y"
    function yy_r36(){ 
    $this->_retvalue = array('operation' => 'ifchanged', 'body' => $this->yystack[$this->yyidx + -3]->minor, 'check' => $this->yystack[$this->yyidx + -5]->minor);
    }
#line 1759 "lib/Haanga/Compiler/Parser.php"
#line 196 "lib/Haanga/Compiler/Parser.y"
    function yy_r37(){ 
    $this->_retvalue = array('operation' => 'ifchanged', 'body' => $this->yystack[$this->yyidx + -7]->minor, 'else' => $this->yystack[$this->yyidx + -3]->minor); 
    }
#line 1764 "lib/Haanga/Compiler/Parser.php"
#line 200 "lib/Haanga/Compiler/Parser.y"
    function yy_r38(){ 
    $this->_retvalue = array('operation' => 'ifchanged', 'body' => $this->yystack[$this->yyidx + -7]->minor, 'check' => $this->yystack[$this->yyidx + -9]->minor, 'else' => $this->yystack[$this->yyidx + -3]->minor);
    }
#line 1769 "lib/Haanga/Compiler/Parser.php"
#line 205 "lib/Haanga/Compiler/Parser.y"
    function yy_r39(){
    $this->_retvalue = array('operation' => 'ifequal', 'cmp' => '==', 1 => $this->yystack[$this->yyidx + -6]->minor, 2 => $this->yystack[$this->yyidx + -5]->minor, 'body' => $this->yystack[$this->yyidx + -3]->minor); 
    }
#line 1774 "lib/Haanga/Compiler/Parser.php"
#line 208 "lib/Haanga/Compiler/Parser.y"
    function yy_r40(){
    $this->_retvalue = array('operation' => 'ifequal', 'cmp' => '==', 1 => $this->yystack[$this->yyidx + -10]->minor, 2 => $this->yystack[$this->yyidx + -9]->minor, 'body' => $this->yystack[$this->yyidx + -7]->minor, 'else' => $this->yystack[$this->yyidx + -3]->minor); 
    }
#line 1779 "lib/Haanga/Compiler/Parser.php"
#line 211 "lib/Haanga/Compiler/Parser.y"
    function yy_r41(){
    $this->_retvalue = array('operation' => 'ifequal', 'cmp' => '!=', 1 => $this->yystack[$this->yyidx + -6]->minor, 2 => $this->yystack[$this->yyidx + -5]->minor, 'body' => $this->yystack[$this->yyidx + -3]->minor);
    }
#line 1784 "lib/Haanga/Compiler/Parser.php"
#line 214 "lib/Haanga/Compiler/Parser.y"
    function yy_r42(){
    $this->_retvalue = array('operation' => 'ifequal', 'cmp' => '!=', 1 => $this->yystack[$this->yyidx + -10]->minor, 2 => $this->yystack[$this->yyidx + -9]->minor, 'body' => $this->yystack[$this->yyidx + -7]->minor, 'else' => $this->yystack[$this->yyidx + -3]->minor); 
    }
#line 1789 "lib/Haanga/Compiler/Parser.php"
#line 219 "lib/Haanga/Compiler/Parser.y"
    function yy_r43(){ 
    $this->_retvalue = array('operation' => 'block', 'name' => $this->yystack[$this->yyidx + -5]->minor, 'body' => $this->yystack[$this->yyidx + -3]->minor); 
    }
#line 1794 "lib/Haanga/Compiler/Parser.php"
#line 223 "lib/Haanga/Compiler/Parser.y"
    function yy_r44(){
    $this->_retvalue = array('operation' => 'block', 'name' => $this->yystack[$this->yyidx + -6]->minor, 'body' => $this->yystack[$this->yyidx + -4]->minor); 
    }
#line 1799 "lib/Haanga/Compiler/Parser.php"
#line 227 "lib/Haanga/Compiler/Parser.y"
    function yy_r45(){
    $this->_retvalue = array('operation' => 'block', 'name' => $this->yystack[$this->yyidx + -5]->minor, 'body' => $this->yystack[$this->yyidx + -3]->minor); 
    }
#line 1804 "lib/Haanga/Compiler/Parser.php"
#line 236 "lib/Haanga/Compiler/Parser.y"
    function yy_r47(){ $this->_retvalue = array('operation' => 'filter', 'functions' => $this->yystack[$this->yyidx + -5]->minor, 'body' => $this->yystack[$this->yyidx + -3]->minor);     }
#line 1807 "lib/Haanga/Compiler/Parser.php"
#line 239 "lib/Haanga/Compiler/Parser.y"
    function yy_r48(){ $this->_retvalue=array('operation' => 'regroup', 'array' => $this->yystack[$this->yyidx + -4]->minor, 'row' => $this->yystack[$this->yyidx + -2]->minor, 'as' => $this->yystack[$this->yyidx + 0]->minor);     }
#line 1810 "lib/Haanga/Compiler/Parser.php"
#line 242 "lib/Haanga/Compiler/Parser.y"
    function yy_r49(){ $this->_retvalue = $this->yystack[$this->yyidx + -2]->minor; $this->_retvalue[] = $this->yystack[$this->yyidx + 0]->minor;     }
#line 1813 "lib/Haanga/Compiler/Parser.php"
#line 243 "lib/Haanga/Compiler/Parser.y"
    function yy_r50(){ $this->_retvalue = array($this->yystack[$this->yyidx + 0]->minor);     }
#line 1816 "lib/Haanga/Compiler/Parser.php"
#line 245 "lib/Haanga/Compiler/Parser.y"
    function yy_r51(){ $this->_retvalue = array($this->yystack[$this->yyidx + -2]->minor, 'args'=>array($this->yystack[$this->yyidx + 0]->minor));     }
#line 1819 "lib/Haanga/Compiler/Parser.php"
#line 249 "lib/Haanga/Compiler/Parser.y"
    function yy_r53(){ $this->_retvalue = $this->yystack[$this->yyidx + -1]->minor; $this->_retvalue[] = $this->yystack[$this->yyidx + 0]->minor;     }
#line 1822 "lib/Haanga/Compiler/Parser.php"
#line 255 "lib/Haanga/Compiler/Parser.y"
    function yy_r56(){ $this->_retvalue = array('var' => $this->yystack[$this->yyidx + 0]->minor);     }
#line 1825 "lib/Haanga/Compiler/Parser.php"
#line 256 "lib/Haanga/Compiler/Parser.y"
    function yy_r57(){ $this->_retvalue = array('number' => $this->yystack[$this->yyidx + 0]->minor);     }
#line 1828 "lib/Haanga/Compiler/Parser.php"
#line 257 "lib/Haanga/Compiler/Parser.y"
    function yy_r58(){ $this->_retvalue = trim(@$this->yystack[$this->yyidx + 0]->minor);     }
#line 1831 "lib/Haanga/Compiler/Parser.php"
#line 258 "lib/Haanga/Compiler/Parser.y"
    function yy_r59(){ $this->_retvalue = array('string' => $this->yystack[$this->yyidx + 0]->minor);     }
#line 1834 "lib/Haanga/Compiler/Parser.php"
#line 261 "lib/Haanga/Compiler/Parser.y"
    function yy_r60(){ $this->_retvalue = array('var_filter' => $this->yystack[$this->yyidx + 0]->minor);     }
#line 1837 "lib/Haanga/Compiler/Parser.php"
#line 269 "lib/Haanga/Compiler/Parser.y"
    function yy_r66(){  $this->_retvalue = "";     }
#line 1840 "lib/Haanga/Compiler/Parser.php"
#line 271 "lib/Haanga/Compiler/Parser.y"
    function yy_r68(){  $this->_retvalue = $this->yystack[$this->yyidx + -1]->minor;     }
#line 1843 "lib/Haanga/Compiler/Parser.php"
#line 273 "lib/Haanga/Compiler/Parser.y"
    function yy_r70(){ $this->_retvalue = $this->yystack[$this->yyidx + -1]->minor.$this->yystack[$this->yyidx + 0]->minor;     }
#line 1846 "lib/Haanga/Compiler/Parser.php"
#line 277 "lib/Haanga/Compiler/Parser.y"
    function yy_r72(){ $this->_retvalue = array('op_expr' => 'not', $this->yystack[$this->yyidx + 0]->minor);     }
#line 1849 "lib/Haanga/Compiler/Parser.php"
#line 278 "lib/Haanga/Compiler/Parser.y"
    function yy_r73(){ $this->_retvalue = array('op_expr' => @$this->yystack[$this->yyidx + -1]->minor, $this->yystack[$this->yyidx + -2]->minor, $this->yystack[$this->yyidx + 0]->minor);     }
#line 1852 "lib/Haanga/Compiler/Parser.php"
#line 281 "lib/Haanga/Compiler/Parser.y"
    function yy_r76(){ $this->_retvalue = array('op_expr' => trim(@$this->yystack[$this->yyidx + -1]->minor), $this->yystack[$this->yyidx + -2]->minor, $this->yystack[$this->yyidx + 0]->minor);     }
#line 1855 "lib/Haanga/Compiler/Parser.php"
#line 283 "lib/Haanga/Compiler/Parser.y"
    function yy_r78(){ $this->_retvalue = array('op_expr' => 'expr', $this->yystack[$this->yyidx + -1]->minor);     }
#line 1858 "lib/Haanga/Compiler/Parser.php"
#line 287 "lib/Haanga/Compiler/Parser.y"
    function yy_r80(){ if (!is_array($this->yystack[$this->yyidx + -2]->minor)) { $this->_retvalue = array($this->yystack[$this->yyidx + -2]->minor); } else { $this->_retvalue = $this->yystack[$this->yyidx + -2]->minor; }  $this->_retvalue[]=array('object' => $this->yystack[$this->yyidx + 0]->minor);    }
#line 1861 "lib/Haanga/Compiler/Parser.php"
#line 288 "lib/Haanga/Compiler/Parser.y"
    function yy_r81(){ if (!is_array($this->yystack[$this->yyidx + -2]->minor)) { $this->_retvalue = array($this->yystack[$this->yyidx + -2]->minor); } else { $this->_retvalue = $this->yystack[$this->yyidx + -2]->minor; } $this->_retvalue[] = ($this->compiler->var_is_object($this->_retvalue)) ? array('object' => $this->yystack[$this->yyidx + 0]->minor) : $this->yystack[$this->yyidx + 0]->minor;    }
#line 1864 "lib/Haanga/Compiler/Parser.php"
#line 289 "lib/Haanga/Compiler/Parser.y"
    function yy_r82(){ if (!is_array($this->yystack[$this->yyidx + -3]->minor)) { $this->_retvalue = array($this->yystack[$this->yyidx + -3]->minor); } else { $this->_retvalue = $this->yystack[$this->yyidx + -3]->minor; }  $this->_retvalue[]=$this->yystack[$this->yyidx + -1]->minor;    }
#line 1867 "lib/Haanga/Compiler/Parser.php"

    /**
     * placeholder for the left hand side in a reduce operation.
     * 
     * For a parser with a rule like this:
     * <pre>
     * rule(A) ::= B. { A = 1; }
     * </pre>
     * 
     * The parser will translate to something like:
     * 
     * <code>
     * function yy_r0(){$this->_retvalue = 1;}
     * </code>
     */
    private $_retvalue;

    /**
     * Perform a reduce action and the shift that must immediately
     * follow the reduce.
     * 
     * For a rule such as:
     * 
     * <pre>
     * A ::= B blah C. { dosomething(); }
     * </pre>
     * 
     * This function will first call the action, if any, ("dosomething();" in our
     * example), and then it will pop three states from the stack,
     * one for each entry on the right-hand side of the expression
     * (B, blah, and C in our example rule), and then push the result of the action
     * back on to the stack with the resulting state reduced to (as described in the .out
     * file)
     * @param int Number of the rule by which to reduce
     */
    function yy_reduce($yyruleno)
    {
        //int $yygoto;                     /* The next state */
        //int $yyact;                      /* The next action */
        //mixed $yygotominor;        /* The LHS of the rule reduced */
        //Haanga_yyStackEntry $yymsp;            /* The top of the parser's stack */
        //int $yysize;                     /* Amount to pop the stack */
        $yymsp = $this->yystack[$this->yyidx];
        if (self::$yyTraceFILE && $yyruleno >= 0 
              && $yyruleno < count(self::$yyRuleName)) {
            fprintf(self::$yyTraceFILE, "%sReduce (%d) [%s].\n",
                self::$yyTracePrompt, $yyruleno,
                self::$yyRuleName[$yyruleno]);
        }

        $this->_retvalue = $yy_lefthand_side = null;
        if (array_key_exists($yyruleno, self::$yyReduceMap)) {
            // call the action
            $this->_retvalue = null;
            $this->{'yy_r' . self::$yyReduceMap[$yyruleno]}();
            $yy_lefthand_side = $this->_retvalue;
        }
        $yygoto = self::$yyRuleInfo[$yyruleno]['lhs'];
        $yysize = self::$yyRuleInfo[$yyruleno]['rhs'];
        $this->yyidx -= $yysize;
        for($i = $yysize; $i; $i--) {
            // pop all of the right-hand side parameters
            array_pop($this->yystack);
        }
        $yyact = $this->yy_find_reduce_action($this->yystack[$this->yyidx]->stateno, $yygoto);
        if ($yyact < self::YYNSTATE) {
            /* If we are not debugging and the reduce action popped at least
            ** one element off the stack, then we can push the new element back
            ** onto the stack here, and skip the stack overflow test in yy_shift().
            ** That gives a significant speed improvement. */
            if (!self::$yyTraceFILE && $yysize) {
                $this->yyidx++;
                $x = new Haanga_yyStackEntry;
                $x->stateno = $yyact;
                $x->major = $yygoto;
                $x->minor = $yy_lefthand_side;
                $this->yystack[$this->yyidx] = $x;
            } else {
                $this->yy_shift($yyact, $yygoto, $yy_lefthand_side);
            }
        } elseif ($yyact == self::YYNSTATE + self::YYNRULE + 1) {
            $this->yy_accept();
        }
    }

    /**
     * The following code executes when the parse fails
     * 
     * Code from %parse_fail is inserted here
     */
    function yy_parse_failed()
    {
        if (self::$yyTraceFILE) {
            fprintf(self::$yyTraceFILE, "%sFail!\n", self::$yyTracePrompt);
        }
        while ($this->yyidx >= 0) {
            $this->yy_pop_parser_stack();
        }
        /* Here code is inserted which will be executed whenever the
        ** parser fails */
    }

    /**
     * The following code executes when a syntax error first occurs.
     * 
     * %syntax_error code is inserted here
     * @param int The major type of the error token
     * @param mixed The minor type of the error token
     */
    function yy_syntax_error($yymajor, $TOKEN)
    {
#line 70 "lib/Haanga/Compiler/Parser.y"

    $expect = array();
    foreach ($this->yy_get_expected_tokens($yymajor) as $token) {
        $expect[] = self::$yyTokenName[$token];
    }
    $this->Error('Unexpected ' . $this->tokenName($yymajor) . '(' . $TOKEN. '), expected one of: ' . implode(',', $expect));
#line 1987 "lib/Haanga/Compiler/Parser.php"
    }

    /**
     * The following is executed when the parser accepts
     * 
     * %parse_accept code is inserted here
     */
    function yy_accept()
    {
        if (self::$yyTraceFILE) {
            fprintf(self::$yyTraceFILE, "%sAccept!\n", self::$yyTracePrompt);
        }
        while ($this->yyidx >= 0) {
            $stack = $this->yy_pop_parser_stack();
        }
        /* Here code is inserted which will be executed whenever the
        ** parser accepts */
#line 57 "lib/Haanga/Compiler/Parser.y"

#line 2008 "lib/Haanga/Compiler/Parser.php"
    }

    /**
     * The main parser program.
     * 
     * The first argument is the major token number.  The second is
     * the token value string as scanned from the input.
     *
     * @param int the token number
     * @param mixed the token value
     * @param mixed any extra arguments that should be passed to handlers
     */
    function doParse($yymajor, $yytokenvalue)
    {
//        $yyact;            /* The parser action. */
//        $yyendofinput;     /* True if we are at the end of input */
        $yyerrorhit = 0;   /* True if yymajor has invoked an error */
        
        /* (re)initialize the parser, if necessary */
        if ($this->yyidx === null || $this->yyidx < 0) {
            /* if ($yymajor == 0) return; // not sure why this was here... */
            $this->yyidx = 0;
            $this->yyerrcnt = -1;
            $x = new Haanga_yyStackEntry;
            $x->stateno = 0;
            $x->major = 0;
            $this->yystack = array();
            array_push($this->yystack, $x);
        }
        $yyendofinput = ($yymajor==0);
        
        if (self::$yyTraceFILE) {
            fprintf(self::$yyTraceFILE, "%sInput %s\n",
                self::$yyTracePrompt, self::$yyTokenName[$yymajor]);
        }
        
        do {
            $yyact = $this->yy_find_shift_action($yymajor);
            if ($yymajor < self::YYERRORSYMBOL &&
                  !$this->yy_is_expected_token($yymajor)) {
                // force a syntax error
                $yyact = self::YY_ERROR_ACTION;
            }
            if ($yyact < self::YYNSTATE) {
                $this->yy_shift($yyact, $yymajor, $yytokenvalue);
                $this->yyerrcnt--;
                if ($yyendofinput && $this->yyidx >= 0) {
                    $yymajor = 0;
                } else {
                    $yymajor = self::YYNOCODE;
                }
            } elseif ($yyact < self::YYNSTATE + self::YYNRULE) {
                $this->yy_reduce($yyact - self::YYNSTATE);
            } elseif ($yyact == self::YY_ERROR_ACTION) {
                if (self::$yyTraceFILE) {
                    fprintf(self::$yyTraceFILE, "%sSyntax Error!\n",
                        self::$yyTracePrompt);
                }
                if (self::YYERRORSYMBOL) {
                    /* A syntax error has occurred.
                    ** The response to an error depends upon whether or not the
                    ** grammar defines an error token "ERROR".  
                    **
                    ** This is what we do if the grammar does define ERROR:
                    **
                    **  * Call the %syntax_error function.
                    **
                    **  * Begin popping the stack until we enter a state where
                    **    it is legal to shift the error symbol, then shift
                    **    the error symbol.
                    **
                    **  * Set the error count to three.
                    **
                    **  * Begin accepting and shifting new tokens.  No new error
                    **    processing will occur until three tokens have been
                    **    shifted successfully.
                    **
                    */
                    if ($this->yyerrcnt < 0) {
                        $this->yy_syntax_error($yymajor, $yytokenvalue);
                    }
                    $yymx = $this->yystack[$this->yyidx]->major;
                    if ($yymx == self::YYERRORSYMBOL || $yyerrorhit ){
                        if (self::$yyTraceFILE) {
                            fprintf(self::$yyTraceFILE, "%sDiscard input token %s\n",
                                self::$yyTracePrompt, self::$yyTokenName[$yymajor]);
                        }
                        $this->yy_destructor($yymajor, $yytokenvalue);
                        $yymajor = self::YYNOCODE;
                    } else {
                        while ($this->yyidx >= 0 &&
                                 $yymx != self::YYERRORSYMBOL &&
        ($yyact = $this->yy_find_shift_action(self::YYERRORSYMBOL)) >= self::YYNSTATE
                              ){
                            $this->yy_pop_parser_stack();
                        }
                        if ($this->yyidx < 0 || $yymajor==0) {
                            $this->yy_destructor($yymajor, $yytokenvalue);
                            $this->yy_parse_failed();
                            $yymajor = self::YYNOCODE;
                        } elseif ($yymx != self::YYERRORSYMBOL) {
                            $u2 = 0;
                            $this->yy_shift($yyact, self::YYERRORSYMBOL, $u2);
                        }
                    }
                    $this->yyerrcnt = 3;
                    $yyerrorhit = 1;
                } else {
                    /* YYERRORSYMBOL is not defined */
                    /* This is what we do if the grammar does not define ERROR:
                    **
                    **  * Report an error message, and throw away the input token.
                    **
                    **  * If the input token is $, then fail the parse.
                    **
                    ** As before, subsequent error messages are suppressed until
                    ** three input tokens have been successfully shifted.
                    */
                    if ($this->yyerrcnt <= 0) {
                        $this->yy_syntax_error($yymajor, $yytokenvalue);
                    }
                    $this->yyerrcnt = 3;
                    $this->yy_destructor($yymajor, $yytokenvalue);
                    if ($yyendofinput) {
                        $this->yy_parse_failed();
                    }
                    $yymajor = self::YYNOCODE;
                }
            } else {
                $this->yy_accept();
                $yymajor = self::YYNOCODE;
            }            
        } while ($yymajor != self::YYNOCODE && $this->yyidx >= 0);
    }
}