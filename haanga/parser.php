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
#line 2 "parser.y"

/*
  +---------------------------------------------------------------------------------+
  | Copyright (c) 2010 Haanga                                                       |
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
#line 136 "parser.php"

// declare_class is output here
#line 39 "parser.y"
 class Parser #line 141 "parser.php"
{
/* First off, code is included which follows the "include_class" declaration
** in the input file. */
#line 40 "parser.y"


#line 149 "parser.php"

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
    const T_AND                          =  2;
    const T_OR                           =  3;
    const T_EQ                           =  4;
    const T_NE                           =  5;
    const T_GT                           =  6;
    const T_GE                           =  7;
    const T_LT                           =  8;
    const T_LE                           =  9;
    const T_IN                           = 10;
    const T_PLUS                         = 11;
    const T_MINUS                        = 12;
    const T_TIMES                        = 13;
    const T_DIV                          = 14;
    const T_MOD                          = 15;
    const T_HTML                         = 16;
    const T_COMMENT_OPEN                 = 17;
    const T_COMMENT                      = 18;
    const T_PRINT_OPEN                   = 19;
    const T_PRINT_CLOSE                  = 20;
    const T_EXTENDS                      = 21;
    const T_CLOSE_TAG                    = 22;
    const T_INCLUDE                      = 23;
    const T_FOR                          = 24;
    const T_AS                           = 25;
    const T_WITH                         = 26;
    const T_ENDWITH                      = 27;
    const T_CLOSEFOR                     = 28;
    const T_COMMA                        = 29;
    const T_EMPTY                        = 30;
    const T_IF                           = 31;
    const T_ENDIF                        = 32;
    const T_ELSE                         = 33;
    const T_IFCHANGED                    = 34;
    const T_ENDIFCHANGED                 = 35;
    const T_CUSTOM_END                   = 36;
    const T_BLOCK                        = 37;
    const T_END_BLOCK                    = 38;
    const T_FILTER                       = 39;
    const T_END_FILTER                   = 40;
    const T_REGROUP                      = 41;
    const T_BY                           = 42;
    const T_CYCLE                        = 43;
    const T_FIRST_OF                     = 44;
    const T_PIPE                         = 45;
    const T_COLON                        = 46;
    const T_STRING_SINGLE_INIT           = 47;
    const T_STRING_SINGLE_END            = 48;
    const T_STRING_DOUBLE_INIT           = 49;
    const T_STRING_DOUBLE_END            = 50;
    const T_STRING_CONTENT               = 51;
    const T_LPARENT                      = 52;
    const T_RPARENT                      = 53;
    const T_NUMERIC                      = 54;
    const T_DOT                          = 55;
    const T_ALPHA                        = 56;
    const T_BRACKETS_OPEN                = 57;
    const T_BRACKETS_CLOSE               = 58;
    const YY_NO_ACTION = 269;
    const YY_ACCEPT_ACTION = 268;
    const YY_ERROR_ACTION = 267;

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
    const YY_SZ_ACTTAB = 598;
static public $yy_action = array(
 /*     0 */    17,   16,   20,   20,   20,   20,   20,   20,   20,   22,
 /*    10 */    22,   21,   21,   21,   17,   16,   20,   20,   20,   20,
 /*    20 */    20,   20,   20,   22,   22,   21,   21,   21,   69,   21,
 /*    30 */    21,   21,  154,   44,   82,  115,  187,  189,  176,  162,
 /*    40 */   163,  164,  158,  165,   23,  160,  171,  167,  168,  161,
 /*    50 */    14,  155,   59,   66,   32,   71,   35,   72,   18,   65,
 /*    60 */   150,  135,  192,  134,   19,  156,  114,   24,   36,   42,
 /*    70 */    62,   70,   37,  120,   56,   31,   25,   26,   32,  192,
 /*    80 */    35,   72,  120,   65,   31,  117,   85,  116,   19,  192,
 /*    90 */    45,   24,  129,  120,   62,   31,   37,  120,   56,   31,
 /*   100 */    25,   26,   32,   95,   35,   72,   53,   65,  139,  177,
 /*   110 */   151,   95,   19,  192,  118,   24,  127,  179,   62,  120,
 /*   120 */    37,   31,   56,  147,   25,   26,   68,  268,   48,   32,
 /*   130 */    33,   35,   72,  195,   65,   34,  183,  192,   41,   19,
 /*   140 */   122,  137,   24,  129,  120,   62,   31,   37,   66,   56,
 /*   150 */    71,   25,   26,   32,   95,   35,   72,  192,   65,   94,
 /*   160 */   177,  151,   79,   19,  192,  128,   24,  123,    6,   62,
 /*   170 */    39,   37,   43,   56,   67,   25,   26,   32,   33,   35,
 /*   180 */    72,  186,   65,  156,  114,   38,   36,   19,  192,   47,
 /*   190 */    24,  132,    1,   62,   40,   37,   66,   56,   71,   25,
 /*   200 */    26,  143,   76,  182,   58,  192,   38,  156,  114,  166,
 /*   210 */    36,  181,  192,  180,  183,  140,   16,   20,   20,   20,
 /*   220 */    20,   20,   20,   20,   22,   22,   21,   21,   21,    8,
 /*   230 */    66,  185,   71,   78,  120,  120,   31,   31,   32,  192,
 /*   240 */    35,   72,   55,   65,  156,  114,   77,   36,   19,  170,
 /*   250 */    38,   24,  138,    9,   62,  120,   37,   31,   56,  157,
 /*   260 */    25,   26,   32,   57,   35,   72,  191,   65,  156,  114,
 /*   270 */    81,   36,   19,  192,  193,   24,  113,   28,   62,  148,
 /*   280 */    37,  131,   56,  149,   25,   26,   32,   50,   35,   72,
 /*   290 */   191,   65,  133,  120,  172,   31,   19,  192,  173,   24,
 /*   300 */   113,   29,   62,  120,   37,   31,   56,  149,   25,   26,
 /*   310 */    32,   33,   35,   72,  169,   65,   84,  121,  174,   80,
 /*   320 */    19,  192,  153,   24,  152,    5,   62,  159,   37,   66,
 /*   330 */    56,   71,   25,   26,   32,  192,   35,   72,  192,   65,
 /*   340 */   156,  114,  175,   36,   19,  192,   99,   24,  191,  124,
 /*   350 */    62,   49,   37,  194,   56,   74,   25,   26,  113,   27,
 /*   360 */    12,   32,   33,   35,   72,  149,   65,  142,  141,  192,
 /*   370 */    83,   19,  125,   91,   24,  156,  114,   62,   36,   37,
 /*   380 */    66,   56,   71,   25,   26,   32,  100,   35,   72,  192,
 /*   390 */    65,  111,  130,  107,  184,   19,  192,  145,   24,  214,
 /*   400 */   120,   62,   31,   37,   95,   56,  112,   25,   26,   32,
 /*   410 */   177,   35,   72,   63,   65,   64,   60,  129,   46,   19,
 /*   420 */   192,   13,   24,   52,  106,   62,   54,   37,   95,   56,
 /*   430 */   144,   25,   26,   89,  177,  151,  156,  114,   66,   36,
 /*   440 */    71,  104,   96,  108,  192,  102,  120,  192,   31,   20,
 /*   450 */    20,   20,   20,   20,   20,   20,   22,   22,   21,   21,
 /*   460 */    21,  129,   93,  120,  103,   31,  110,  105,   92,  109,
 /*   470 */    97,   32,   95,   35,   72,  101,   65,   90,  177,  151,
 /*   480 */    95,   19,   98,   51,   24,  129,  177,   62,  191,   37,
 /*   490 */   157,   56,  157,   25,   26,  157,   95,  129,  113,   30,
 /*   500 */   129,   88,  177,  151,   10,  149,  192,   73,   95,  157,
 /*   510 */     4,   95,  157,   86,  177,  151,   87,  177,  151,  156,
 /*   520 */   114,    2,   36,  157,  157,  156,  114,   15,   36,  157,
 /*   530 */    75,  157,   66,  146,   71,  157,  156,  114,    3,   36,
 /*   540 */   119,  192,  156,  114,    7,   36,   61,  157,  157,  157,
 /*   550 */   113,  157,  157,  156,  114,   11,   36,  149,  157,  156,
 /*   560 */   114,  157,   36,  120,  126,   31,  120,  178,   31,  190,
 /*   570 */   156,  114,  136,   36,  113,  157,  120,  113,   31,  113,
 /*   580 */   188,  149,  113,  157,  149,  157,  149,  157,  157,  149,
 /*   590 */   113,  157,  157,  157,  157,  157,  157,  149,
    );
    static public $yy_lookahead = array(
 /*     0 */     2,    3,    4,    5,    6,    7,    8,    9,   10,   11,
 /*    10 */    12,   13,   14,   15,    2,    3,    4,    5,    6,    7,
 /*    20 */     8,    9,   10,   11,   12,   13,   14,   15,   10,   13,
 /*    30 */    14,   15,   63,   61,   22,   66,   67,   68,   69,   70,
 /*    40 */    71,   72,   73,   74,   75,   22,   77,   78,   79,   22,
 /*    50 */     1,   53,   10,   47,   21,   49,   23,   24,   52,   26,
 /*    60 */    54,   28,   56,   30,   31,   16,   17,   34,   19,   61,
 /*    70 */    37,   29,   39,   55,   41,   57,   43,   44,   21,   56,
 /*    80 */    23,   24,   55,   26,   57,   28,   22,   30,   31,   56,
 /*    90 */    61,   34,   64,   55,   37,   57,   39,   55,   41,   57,
 /*   100 */    43,   44,   21,   75,   23,   24,   61,   26,   80,   81,
 /*   110 */    82,   75,   31,   56,   33,   34,   35,   81,   37,   55,
 /*   120 */    39,   57,   41,   22,   43,   44,   25,   60,   61,   21,
 /*   130 */    29,   23,   24,   48,   26,   46,   51,   56,   61,   31,
 /*   140 */    32,   33,   34,   64,   55,   37,   57,   39,   47,   41,
 /*   150 */    49,   43,   44,   21,   75,   23,   24,   56,   26,   80,
 /*   160 */    81,   82,   22,   31,   56,   33,   34,   35,    1,   37,
 /*   170 */    61,   39,   61,   41,   25,   43,   44,   21,   29,   23,
 /*   180 */    24,   20,   26,   16,   17,   45,   19,   31,   56,   61,
 /*   190 */    34,   35,    1,   37,   61,   39,   47,   41,   49,   43,
 /*   200 */    44,   22,   22,   22,   25,   56,   45,   16,   17,   22,
 /*   210 */    19,   22,   56,   50,   51,   56,    3,    4,    5,    6,
 /*   220 */     7,    8,    9,   10,   11,   12,   13,   14,   15,    1,
 /*   230 */    47,   58,   49,   22,   55,   55,   57,   57,   21,   56,
 /*   240 */    23,   24,   42,   26,   16,   17,   22,   19,   31,   22,
 /*   250 */    45,   34,   35,    1,   37,   55,   39,   57,   41,   22,
 /*   260 */    43,   44,   21,   25,   23,   24,   65,   26,   16,   17,
 /*   270 */    22,   19,   31,   56,   18,   34,   75,   76,   37,   22,
 /*   280 */    39,   40,   41,   82,   43,   44,   21,   61,   23,   24,
 /*   290 */    65,   26,   27,   55,   22,   57,   31,   56,   22,   34,
 /*   300 */    75,   76,   37,   55,   39,   57,   41,   82,   43,   44,
 /*   310 */    21,   29,   23,   24,   22,   26,   22,   28,   22,   22,
 /*   320 */    31,   56,   22,   34,   22,    1,   37,   22,   39,   47,
 /*   330 */    41,   49,   43,   44,   21,   56,   23,   24,   56,   26,
 /*   340 */    16,   17,   22,   19,   31,   56,   75,   34,   65,   36,
 /*   350 */    37,   61,   39,   22,   41,   22,   43,   44,   75,   76,
 /*   360 */     1,   21,   29,   23,   24,   82,   26,   22,   22,   56,
 /*   370 */    22,   31,   32,   75,   34,   16,   17,   37,   19,   39,
 /*   380 */    47,   41,   49,   43,   44,   21,   75,   23,   24,   56,
 /*   390 */    26,   75,   28,   64,   51,   31,   56,   62,   34,    0,
 /*   400 */    55,   37,   57,   39,   75,   41,   83,   43,   44,   21,
 /*   410 */    81,   23,   24,   22,   26,   24,   25,   64,   61,   31,
 /*   420 */    56,    1,   34,   61,   75,   37,   38,   39,   75,   41,
 /*   430 */    22,   43,   44,   80,   81,   82,   16,   17,   47,   19,
 /*   440 */    49,   75,   75,   75,   56,   75,   55,   56,   57,    4,
 /*   450 */     5,    6,    7,    8,    9,   10,   11,   12,   13,   14,
 /*   460 */    15,   64,   75,   55,   75,   57,   83,   75,   75,   64,
 /*   470 */    75,   21,   75,   23,   24,   75,   26,   80,   81,   82,
 /*   480 */    75,   31,   75,   61,   34,   64,   81,   37,   65,   39,
 /*   490 */    84,   41,   84,   43,   44,   84,   75,   64,   75,   76,
 /*   500 */    64,   80,   81,   82,    1,   82,   56,   22,   75,   84,
 /*   510 */     1,   75,   84,   80,   81,   82,   80,   81,   82,   16,
 /*   520 */    17,    1,   19,   84,   84,   16,   17,    1,   19,   84,
 /*   530 */    22,   84,   47,   22,   49,   84,   16,   17,    1,   19,
 /*   540 */    65,   56,   16,   17,    1,   19,   25,   84,   84,   84,
 /*   550 */    75,   84,   84,   16,   17,    1,   19,   82,   84,   16,
 /*   560 */    17,   84,   19,   55,   65,   57,   55,   65,   57,   65,
 /*   570 */    16,   17,   65,   19,   75,   84,   55,   75,   57,   75,
 /*   580 */    65,   82,   75,   84,   82,   84,   82,   84,   84,   82,
 /*   590 */    75,   84,   84,   84,   84,   84,   84,   82,
);
    const YY_SHIFT_USE_DFLT = -3;
    const YY_SHIFT_MAX = 138;
    static public $yy_shift_ofst = array(
 /*     0 */    -3,   57,   33,   81,  108,  132,  340,  265,  313,  388,
 /*    10 */   241,  364,  289,  156,  217,  450,    6,    6,    6,    6,
 /*    20 */     6,    6,    6,  391,  485,  183,  183,  101,  149,  333,
 /*    30 */   282,  183,  183,  183,  183,  183,  279,  279,  279,  503,
 /*    40 */    49,  359,  509,  543,  520,  554,  537,  420,  526,  228,
 /*    50 */   191,  252,  324,  167,   23,  279,  279,  279,  279,  279,
 /*    60 */   279,  279,  279,  399,  279,  279,  343,  279,  279,  279,
 /*    70 */   279,  343,  279,   -3,   -3,   -3,   -3,   -3,   -3,   -3,
 /*    80 */    -3,   -3,   -3,   -3,   -3,   -3,   12,   -2,  213,  445,
 /*    90 */   445,  179,   42,  238,   16,   89,  200,  511,   18,  521,
 /*   100 */    27,  248,  180,   64,  345,  408,  508,  161,   38,  140,
 /*   110 */   163,   38,   85,   38,  256,  331,  294,  292,  211,  173,
 /*   120 */   159,  227,  276,  187,  257,  272,  237,  189,  224,  205,
 /*   130 */   346,  320,  305,  296,  297,  300,  302,  348,  181,
);
    const YY_REDUCE_USE_DFLT = -32;
    const YY_REDUCE_MAX = 85;
    static public $yy_reduce_ofst = array(
 /*     0 */    67,  -31,  -31,  -31,  -31,  -31,  -31,  -31,  -31,  -31,
 /*    10 */   -31,  -31,  -31,  -31,  -31,  -31,  397,  421,  436,  433,
 /*    20 */   353,   28,   79,  283,  225,  201,  423,  515,  515,  515,
 /*    30 */   515,  475,  507,  504,  502,  499,  329,  405,   36,  335,
 /*    40 */   335,  335,  335,  335,  335,  335,  335,  335,  335,  335,
 /*    50 */   335,  335,  335,  335,  311,  387,  367,  368,  366,  370,
 /*    60 */   392,  389,  349,  290,  298,  271,  323,  316,  395,  400,
 /*    70 */   407,  383,  393,  362,  357,  422,  226,  128,  133,  109,
 /*    80 */    29,  -28,    8,   45,   77,  111,
);
    static public $yyExpectedTokens = array(
        /* 0 */ array(),
        /* 1 */ array(21, 23, 24, 26, 28, 30, 31, 34, 37, 39, 41, 43, 44, 56, ),
        /* 2 */ array(21, 23, 24, 26, 28, 30, 31, 34, 37, 39, 41, 43, 44, 56, ),
        /* 3 */ array(21, 23, 24, 26, 31, 33, 34, 35, 37, 39, 41, 43, 44, 56, ),
        /* 4 */ array(21, 23, 24, 26, 31, 32, 33, 34, 37, 39, 41, 43, 44, 56, ),
        /* 5 */ array(21, 23, 24, 26, 31, 33, 34, 35, 37, 39, 41, 43, 44, 56, ),
        /* 6 */ array(21, 23, 24, 26, 31, 32, 34, 37, 39, 41, 43, 44, 56, ),
        /* 7 */ array(21, 23, 24, 26, 27, 31, 34, 37, 39, 41, 43, 44, 56, ),
        /* 8 */ array(21, 23, 24, 26, 31, 34, 36, 37, 39, 41, 43, 44, 56, ),
        /* 9 */ array(21, 23, 24, 26, 31, 34, 37, 38, 39, 41, 43, 44, 56, ),
        /* 10 */ array(21, 23, 24, 26, 31, 34, 37, 39, 40, 41, 43, 44, 56, ),
        /* 11 */ array(21, 23, 24, 26, 28, 31, 34, 37, 39, 41, 43, 44, 56, ),
        /* 12 */ array(21, 23, 24, 26, 28, 31, 34, 37, 39, 41, 43, 44, 56, ),
        /* 13 */ array(21, 23, 24, 26, 31, 34, 35, 37, 39, 41, 43, 44, 56, ),
        /* 14 */ array(21, 23, 24, 26, 31, 34, 35, 37, 39, 41, 43, 44, 56, ),
        /* 15 */ array(21, 23, 24, 26, 31, 34, 37, 39, 41, 43, 44, 56, ),
        /* 16 */ array(47, 49, 52, 54, 56, ),
        /* 17 */ array(47, 49, 52, 54, 56, ),
        /* 18 */ array(47, 49, 52, 54, 56, ),
        /* 19 */ array(47, 49, 52, 54, 56, ),
        /* 20 */ array(47, 49, 52, 54, 56, ),
        /* 21 */ array(47, 49, 52, 54, 56, ),
        /* 22 */ array(47, 49, 52, 54, 56, ),
        /* 23 */ array(22, 24, 25, 47, 49, 55, 56, 57, ),
        /* 24 */ array(22, 47, 49, 56, ),
        /* 25 */ array(47, 49, 56, ),
        /* 26 */ array(47, 49, 56, ),
        /* 27 */ array(22, 25, 29, 47, 49, 56, ),
        /* 28 */ array(25, 29, 47, 49, 56, ),
        /* 29 */ array(22, 29, 47, 49, 56, ),
        /* 30 */ array(29, 47, 49, 56, ),
        /* 31 */ array(47, 49, 56, ),
        /* 32 */ array(47, 49, 56, ),
        /* 33 */ array(47, 49, 56, ),
        /* 34 */ array(47, 49, 56, ),
        /* 35 */ array(47, 49, 56, ),
        /* 36 */ array(56, ),
        /* 37 */ array(56, ),
        /* 38 */ array(56, ),
        /* 39 */ array(1, 16, 17, 19, ),
        /* 40 */ array(1, 16, 17, 19, ),
        /* 41 */ array(1, 16, 17, 19, ),
        /* 42 */ array(1, 16, 17, 19, ),
        /* 43 */ array(1, 16, 17, 19, ),
        /* 44 */ array(1, 16, 17, 19, ),
        /* 45 */ array(1, 16, 17, 19, ),
        /* 46 */ array(1, 16, 17, 19, ),
        /* 47 */ array(1, 16, 17, 19, ),
        /* 48 */ array(1, 16, 17, 19, ),
        /* 49 */ array(1, 16, 17, 19, ),
        /* 50 */ array(1, 16, 17, 19, ),
        /* 51 */ array(1, 16, 17, 19, ),
        /* 52 */ array(1, 16, 17, 19, ),
        /* 53 */ array(1, 16, 17, 19, ),
        /* 54 */ array(22, 56, ),
        /* 55 */ array(56, ),
        /* 56 */ array(56, ),
        /* 57 */ array(56, ),
        /* 58 */ array(56, ),
        /* 59 */ array(56, ),
        /* 60 */ array(56, ),
        /* 61 */ array(56, ),
        /* 62 */ array(56, ),
        /* 63 */ array(0, ),
        /* 64 */ array(56, ),
        /* 65 */ array(56, ),
        /* 66 */ array(51, ),
        /* 67 */ array(56, ),
        /* 68 */ array(56, ),
        /* 69 */ array(56, ),
        /* 70 */ array(56, ),
        /* 71 */ array(51, ),
        /* 72 */ array(56, ),
        /* 73 */ array(),
        /* 74 */ array(),
        /* 75 */ array(),
        /* 76 */ array(),
        /* 77 */ array(),
        /* 78 */ array(),
        /* 79 */ array(),
        /* 80 */ array(),
        /* 81 */ array(),
        /* 82 */ array(),
        /* 83 */ array(),
        /* 84 */ array(),
        /* 85 */ array(),
        /* 86 */ array(2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 22, ),
        /* 87 */ array(2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 53, ),
        /* 88 */ array(3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, ),
        /* 89 */ array(4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, ),
        /* 90 */ array(4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, ),
        /* 91 */ array(22, 25, 55, 57, ),
        /* 92 */ array(10, 29, 55, 57, ),
        /* 93 */ array(25, 55, 57, ),
        /* 94 */ array(13, 14, 15, ),
        /* 95 */ array(46, 55, 57, ),
        /* 96 */ array(42, 55, 57, ),
        /* 97 */ array(22, 55, 57, ),
        /* 98 */ array(10, 55, 57, ),
        /* 99 */ array(25, 55, 57, ),
        /* 100 */ array(22, 55, 57, ),
        /* 101 */ array(22, 55, 57, ),
        /* 102 */ array(22, 55, 57, ),
        /* 103 */ array(22, 55, 57, ),
        /* 104 */ array(22, 55, 57, ),
        /* 105 */ array(22, 55, 57, ),
        /* 106 */ array(22, 55, 57, ),
        /* 107 */ array(20, 45, ),
        /* 108 */ array(55, 57, ),
        /* 109 */ array(22, 45, ),
        /* 110 */ array(50, 51, ),
        /* 111 */ array(55, 57, ),
        /* 112 */ array(48, 51, ),
        /* 113 */ array(55, 57, ),
        /* 114 */ array(18, ),
        /* 115 */ array(22, ),
        /* 116 */ array(22, ),
        /* 117 */ array(22, ),
        /* 118 */ array(22, ),
        /* 119 */ array(58, ),
        /* 120 */ array(56, ),
        /* 121 */ array(22, ),
        /* 122 */ array(22, ),
        /* 123 */ array(22, ),
        /* 124 */ array(22, ),
        /* 125 */ array(22, ),
        /* 126 */ array(22, ),
        /* 127 */ array(22, ),
        /* 128 */ array(22, ),
        /* 129 */ array(45, ),
        /* 130 */ array(22, ),
        /* 131 */ array(22, ),
        /* 132 */ array(22, ),
        /* 133 */ array(22, ),
        /* 134 */ array(22, ),
        /* 135 */ array(22, ),
        /* 136 */ array(22, ),
        /* 137 */ array(22, ),
        /* 138 */ array(22, ),
        /* 139 */ array(),
        /* 140 */ array(),
        /* 141 */ array(),
        /* 142 */ array(),
        /* 143 */ array(),
        /* 144 */ array(),
        /* 145 */ array(),
        /* 146 */ array(),
        /* 147 */ array(),
        /* 148 */ array(),
        /* 149 */ array(),
        /* 150 */ array(),
        /* 151 */ array(),
        /* 152 */ array(),
        /* 153 */ array(),
        /* 154 */ array(),
        /* 155 */ array(),
        /* 156 */ array(),
        /* 157 */ array(),
        /* 158 */ array(),
        /* 159 */ array(),
        /* 160 */ array(),
        /* 161 */ array(),
        /* 162 */ array(),
        /* 163 */ array(),
        /* 164 */ array(),
        /* 165 */ array(),
        /* 166 */ array(),
        /* 167 */ array(),
        /* 168 */ array(),
        /* 169 */ array(),
        /* 170 */ array(),
        /* 171 */ array(),
        /* 172 */ array(),
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
);
    static public $yy_default = array(
 /*     0 */   198,  267,  267,  267,  267,  267,  267,  267,  267,  267,
 /*    10 */   267,  267,  267,  267,  267,  267,  267,  267,  267,  267,
 /*    20 */   267,  267,  267,  267,  267,  267,  267,  267,  239,  267,
 /*    30 */   241,  267,  267,  267,  267,  267,  267,  267,  267,  267,
 /*    40 */   267,  267,  267,  267,  267,  267,  267,  267,  196,  267,
 /*    50 */   267,  267,  267,  267,  267,  267,  267,  267,  267,  267,
 /*    60 */   267,  267,  267,  198,  267,  267,  267,  267,  267,  267,
 /*    70 */   267,  267,  267,  198,  198,  198,  198,  198,  198,  198,
 /*    80 */   198,  198,  198,  198,  198,  198,  267,  267,  255,  258,
 /*    90 */   256,  267,  267,  267,  257,  245,  267,  267,  267,  267,
 /*   100 */   267,  267,  267,  267,  267,  267,  267,  267,  238,  267,
 /*   110 */   267,  240,  267,  249,  267,  267,  267,  267,  267,  267,
 /*   120 */   267,  267,  267,  267,  267,  267,  267,  267,  267,  260,
 /*   130 */   267,  267,  267,  267,  267,  267,  267,  267,  267,  259,
 /*   140 */   264,  227,  216,  215,  217,  197,  219,  218,  234,  250,
 /*   150 */   263,  262,  203,  225,  199,  261,  200,  211,  212,  232,
 /*   160 */   235,  236,  208,  209,  210,  213,  230,  222,  223,  224,
 /*   170 */   226,  221,  229,  228,  220,  237,  207,  243,  244,  242,
 /*   180 */   252,  231,  233,  253,  254,  265,  202,  205,  246,  206,
 /*   190 */   247,  248,  266,  201,  204,  251,
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
    const YYNOCODE = 85;
    const YYSTACKDEPTH = 100;
    const YYNSTATE = 196;
    const YYNRULE = 71;
    const YYERRORSYMBOL = 59;
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
  '$',             'T_OPEN_TAG',    'T_AND',         'T_OR',        
  'T_EQ',          'T_NE',          'T_GT',          'T_GE',        
  'T_LT',          'T_LE',          'T_IN',          'T_PLUS',      
  'T_MINUS',       'T_TIMES',       'T_DIV',         'T_MOD',       
  'T_HTML',        'T_COMMENT_OPEN',  'T_COMMENT',     'T_PRINT_OPEN',
  'T_PRINT_CLOSE',  'T_EXTENDS',     'T_CLOSE_TAG',   'T_INCLUDE',   
  'T_FOR',         'T_AS',          'T_WITH',        'T_ENDWITH',   
  'T_CLOSEFOR',    'T_COMMA',       'T_EMPTY',       'T_IF',        
  'T_ENDIF',       'T_ELSE',        'T_IFCHANGED',   'T_ENDIFCHANGED',
  'T_CUSTOM_END',  'T_BLOCK',       'T_END_BLOCK',   'T_FILTER',    
  'T_END_FILTER',  'T_REGROUP',     'T_BY',          'T_CYCLE',     
  'T_FIRST_OF',    'T_PIPE',        'T_COLON',       'T_STRING_SINGLE_INIT',
  'T_STRING_SINGLE_END',  'T_STRING_DOUBLE_INIT',  'T_STRING_DOUBLE_END',  'T_STRING_CONTENT',
  'T_LPARENT',     'T_RPARENT',     'T_NUMERIC',     'T_DOT',       
  'T_ALPHA',       'T_BRACKETS_OPEN',  'T_BRACKETS_CLOSE',  'error',       
  'start',         'body',          'code',          'stmts',       
  'piped_list',    'var_or_string',  'stmt',          'for_stmt',    
  'ifchanged_stmt',  'block_stmt',    'filter_stmt',   'custom_stmt', 
  'if_stmt',       'fnc_call_stmt',  'alias',         'varname',     
  'list',          'cycle',         'regroup',       'first_of',    
  'expr',          'varname_args',  'string',        's_content',   
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
 /*   6 */ "code ::= T_PRINT_OPEN piped_list T_PRINT_CLOSE",
 /*   7 */ "stmts ::= T_EXTENDS var_or_string T_CLOSE_TAG",
 /*   8 */ "stmts ::= stmt T_CLOSE_TAG",
 /*   9 */ "stmts ::= for_stmt",
 /*  10 */ "stmts ::= ifchanged_stmt",
 /*  11 */ "stmts ::= block_stmt",
 /*  12 */ "stmts ::= filter_stmt",
 /*  13 */ "stmts ::= custom_stmt",
 /*  14 */ "stmts ::= if_stmt",
 /*  15 */ "stmts ::= T_INCLUDE var_or_string T_CLOSE_TAG",
 /*  16 */ "stmts ::= fnc_call_stmt",
 /*  17 */ "stmts ::= alias",
 /*  18 */ "fnc_call_stmt ::= varname T_CLOSE_TAG",
 /*  19 */ "fnc_call_stmt ::= varname T_FOR varname T_CLOSE_TAG",
 /*  20 */ "fnc_call_stmt ::= varname T_FOR varname T_AS varname T_CLOSE_TAG",
 /*  21 */ "fnc_call_stmt ::= varname T_AS varname T_CLOSE_TAG",
 /*  22 */ "fnc_call_stmt ::= varname list T_CLOSE_TAG",
 /*  23 */ "fnc_call_stmt ::= varname list T_AS varname T_CLOSE_TAG",
 /*  24 */ "alias ::= T_WITH varname T_AS varname T_CLOSE_TAG body T_OPEN_TAG T_ENDWITH T_CLOSE_TAG",
 /*  25 */ "stmt ::= cycle",
 /*  26 */ "stmt ::= regroup",
 /*  27 */ "stmt ::= first_of",
 /*  28 */ "for_stmt ::= T_FOR varname T_IN varname T_CLOSE_TAG body T_OPEN_TAG T_CLOSEFOR T_CLOSE_TAG",
 /*  29 */ "for_stmt ::= T_FOR varname T_COMMA varname T_IN varname T_CLOSE_TAG body T_OPEN_TAG T_CLOSEFOR T_CLOSE_TAG",
 /*  30 */ "for_stmt ::= T_FOR varname T_IN varname T_CLOSE_TAG body T_OPEN_TAG T_EMPTY T_CLOSE_TAG body T_OPEN_TAG T_CLOSEFOR T_CLOSE_TAG",
 /*  31 */ "for_stmt ::= T_FOR varname T_COMMA varname T_IN varname T_CLOSE_TAG body T_OPEN_TAG T_EMPTY T_CLOSE_TAG body T_OPEN_TAG T_CLOSEFOR T_CLOSE_TAG",
 /*  32 */ "if_stmt ::= T_IF expr T_CLOSE_TAG body T_OPEN_TAG T_ENDIF T_CLOSE_TAG",
 /*  33 */ "if_stmt ::= T_IF expr T_CLOSE_TAG body T_OPEN_TAG T_ELSE T_CLOSE_TAG body T_OPEN_TAG T_ENDIF T_CLOSE_TAG",
 /*  34 */ "ifchanged_stmt ::= T_IFCHANGED T_CLOSE_TAG body T_OPEN_TAG T_ENDIFCHANGED T_CLOSE_TAG",
 /*  35 */ "ifchanged_stmt ::= T_IFCHANGED list T_CLOSE_TAG body T_OPEN_TAG T_ENDIFCHANGED T_CLOSE_TAG",
 /*  36 */ "ifchanged_stmt ::= T_IFCHANGED T_CLOSE_TAG body T_OPEN_TAG T_ELSE T_CLOSE_TAG body T_OPEN_TAG T_ENDIFCHANGED T_CLOSE_TAG",
 /*  37 */ "ifchanged_stmt ::= T_IFCHANGED list T_CLOSE_TAG body T_OPEN_TAG T_ELSE T_CLOSE_TAG body T_OPEN_TAG T_ENDIFCHANGED T_CLOSE_TAG",
 /*  38 */ "custom_stmt ::= varname T_CLOSE_TAG body T_OPEN_TAG T_CUSTOM_END T_CLOSE_TAG",
 /*  39 */ "block_stmt ::= T_BLOCK varname T_CLOSE_TAG body T_OPEN_TAG T_END_BLOCK T_CLOSE_TAG",
 /*  40 */ "block_stmt ::= T_BLOCK varname T_CLOSE_TAG body T_OPEN_TAG T_END_BLOCK varname T_CLOSE_TAG",
 /*  41 */ "filter_stmt ::= T_FILTER piped_list T_CLOSE_TAG body T_OPEN_TAG T_END_FILTER T_CLOSE_TAG",
 /*  42 */ "regroup ::= T_REGROUP varname T_BY varname T_AS varname",
 /*  43 */ "cycle ::= T_CYCLE list",
 /*  44 */ "cycle ::= T_CYCLE list T_AS varname",
 /*  45 */ "first_of ::= T_FIRST_OF list",
 /*  46 */ "piped_list ::= piped_list T_PIPE varname_args",
 /*  47 */ "piped_list ::= varname_args",
 /*  48 */ "varname_args ::= varname T_COLON var_or_string",
 /*  49 */ "varname_args ::= varname",
 /*  50 */ "list ::= list var_or_string",
 /*  51 */ "list ::= list T_COMMA var_or_string",
 /*  52 */ "list ::= var_or_string",
 /*  53 */ "var_or_string ::= varname",
 /*  54 */ "var_or_string ::= string",
 /*  55 */ "string ::= T_STRING_SINGLE_INIT s_content T_STRING_SINGLE_END",
 /*  56 */ "string ::= T_STRING_DOUBLE_INIT s_content T_STRING_DOUBLE_END",
 /*  57 */ "s_content ::= s_content T_STRING_CONTENT",
 /*  58 */ "s_content ::= T_STRING_CONTENT",
 /*  59 */ "expr ::= expr T_AND expr",
 /*  60 */ "expr ::= expr T_OR expr",
 /*  61 */ "expr ::= expr T_PLUS|T_MINUS expr",
 /*  62 */ "expr ::= expr T_EQ|T_NE|T_GT|T_GE|T_LT|T_LE|T_IN expr",
 /*  63 */ "expr ::= expr T_TIMES|T_DIV|T_MOD expr",
 /*  64 */ "expr ::= piped_list",
 /*  65 */ "expr ::= T_LPARENT expr T_RPARENT",
 /*  66 */ "expr ::= string",
 /*  67 */ "expr ::= T_NUMERIC",
 /*  68 */ "varname ::= varname T_DOT T_ALPHA",
 /*  69 */ "varname ::= varname T_BRACKETS_OPEN var_or_string T_BRACKETS_CLOSE",
 /*  70 */ "varname ::= T_ALPHA",
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
  array( 'lhs' => 60, 'rhs' => 1 ),
  array( 'lhs' => 61, 'rhs' => 2 ),
  array( 'lhs' => 61, 'rhs' => 0 ),
  array( 'lhs' => 62, 'rhs' => 2 ),
  array( 'lhs' => 62, 'rhs' => 1 ),
  array( 'lhs' => 62, 'rhs' => 2 ),
  array( 'lhs' => 62, 'rhs' => 3 ),
  array( 'lhs' => 63, 'rhs' => 3 ),
  array( 'lhs' => 63, 'rhs' => 2 ),
  array( 'lhs' => 63, 'rhs' => 1 ),
  array( 'lhs' => 63, 'rhs' => 1 ),
  array( 'lhs' => 63, 'rhs' => 1 ),
  array( 'lhs' => 63, 'rhs' => 1 ),
  array( 'lhs' => 63, 'rhs' => 1 ),
  array( 'lhs' => 63, 'rhs' => 1 ),
  array( 'lhs' => 63, 'rhs' => 3 ),
  array( 'lhs' => 63, 'rhs' => 1 ),
  array( 'lhs' => 63, 'rhs' => 1 ),
  array( 'lhs' => 73, 'rhs' => 2 ),
  array( 'lhs' => 73, 'rhs' => 4 ),
  array( 'lhs' => 73, 'rhs' => 6 ),
  array( 'lhs' => 73, 'rhs' => 4 ),
  array( 'lhs' => 73, 'rhs' => 3 ),
  array( 'lhs' => 73, 'rhs' => 5 ),
  array( 'lhs' => 74, 'rhs' => 9 ),
  array( 'lhs' => 66, 'rhs' => 1 ),
  array( 'lhs' => 66, 'rhs' => 1 ),
  array( 'lhs' => 66, 'rhs' => 1 ),
  array( 'lhs' => 67, 'rhs' => 9 ),
  array( 'lhs' => 67, 'rhs' => 11 ),
  array( 'lhs' => 67, 'rhs' => 13 ),
  array( 'lhs' => 67, 'rhs' => 15 ),
  array( 'lhs' => 72, 'rhs' => 7 ),
  array( 'lhs' => 72, 'rhs' => 11 ),
  array( 'lhs' => 68, 'rhs' => 6 ),
  array( 'lhs' => 68, 'rhs' => 7 ),
  array( 'lhs' => 68, 'rhs' => 10 ),
  array( 'lhs' => 68, 'rhs' => 11 ),
  array( 'lhs' => 71, 'rhs' => 6 ),
  array( 'lhs' => 69, 'rhs' => 7 ),
  array( 'lhs' => 69, 'rhs' => 8 ),
  array( 'lhs' => 70, 'rhs' => 7 ),
  array( 'lhs' => 78, 'rhs' => 6 ),
  array( 'lhs' => 77, 'rhs' => 2 ),
  array( 'lhs' => 77, 'rhs' => 4 ),
  array( 'lhs' => 79, 'rhs' => 2 ),
  array( 'lhs' => 64, 'rhs' => 3 ),
  array( 'lhs' => 64, 'rhs' => 1 ),
  array( 'lhs' => 81, 'rhs' => 3 ),
  array( 'lhs' => 81, 'rhs' => 1 ),
  array( 'lhs' => 76, 'rhs' => 2 ),
  array( 'lhs' => 76, 'rhs' => 3 ),
  array( 'lhs' => 76, 'rhs' => 1 ),
  array( 'lhs' => 65, 'rhs' => 1 ),
  array( 'lhs' => 65, 'rhs' => 1 ),
  array( 'lhs' => 82, 'rhs' => 3 ),
  array( 'lhs' => 82, 'rhs' => 3 ),
  array( 'lhs' => 83, 'rhs' => 2 ),
  array( 'lhs' => 83, 'rhs' => 1 ),
  array( 'lhs' => 80, 'rhs' => 3 ),
  array( 'lhs' => 80, 'rhs' => 3 ),
  array( 'lhs' => 80, 'rhs' => 3 ),
  array( 'lhs' => 80, 'rhs' => 3 ),
  array( 'lhs' => 80, 'rhs' => 3 ),
  array( 'lhs' => 80, 'rhs' => 1 ),
  array( 'lhs' => 80, 'rhs' => 3 ),
  array( 'lhs' => 80, 'rhs' => 1 ),
  array( 'lhs' => 80, 'rhs' => 1 ),
  array( 'lhs' => 75, 'rhs' => 3 ),
  array( 'lhs' => 75, 'rhs' => 4 ),
  array( 'lhs' => 75, 'rhs' => 1 ),
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
        9 => 3,
        10 => 3,
        11 => 3,
        12 => 3,
        13 => 3,
        14 => 3,
        16 => 3,
        17 => 3,
        25 => 3,
        26 => 3,
        27 => 3,
        49 => 3,
        58 => 3,
        67 => 3,
        70 => 3,
        4 => 4,
        5 => 5,
        6 => 6,
        7 => 7,
        8 => 8,
        15 => 15,
        18 => 18,
        19 => 19,
        20 => 20,
        21 => 21,
        22 => 22,
        23 => 23,
        24 => 24,
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
        45 => 45,
        46 => 46,
        51 => 46,
        47 => 47,
        52 => 47,
        48 => 48,
        50 => 50,
        53 => 53,
        54 => 54,
        66 => 54,
        55 => 55,
        56 => 55,
        57 => 57,
        59 => 59,
        60 => 59,
        61 => 59,
        63 => 59,
        62 => 62,
        64 => 64,
        65 => 65,
        68 => 68,
        69 => 69,
    );
    /* Beginning here are the reduction cases.  A typical example
    ** follows:
    **  #line <lineno> <grammarfile>
    **   function yy_r0($yymsp){ ... }           // User supplied code
    **  #line <lineno> <thisfile>
    */
#line 65 "parser.y"
    function yy_r0(){ $this->body = $this->yystack[$this->yyidx + 0]->minor;     }
#line 1374 "parser.php"
#line 67 "parser.y"
    function yy_r1(){ $this->_retvalue=$this->yystack[$this->yyidx + -1]->minor; $this->_retvalue[] = $this->yystack[$this->yyidx + 0]->minor;     }
#line 1377 "parser.php"
#line 68 "parser.y"
    function yy_r2(){ $this->_retvalue = array();     }
#line 1380 "parser.php"
#line 71 "parser.y"
    function yy_r3(){ $this->_retvalue = $this->yystack[$this->yyidx + 0]->minor;     }
#line 1383 "parser.php"
#line 72 "parser.y"
    function yy_r4(){ $this->_retvalue = array('operation' => 'html', 'html' => $this->yystack[$this->yyidx + 0]->minor);     }
#line 1386 "parser.php"
#line 73 "parser.y"
    function yy_r5(){ $this->yystack[$this->yyidx + 0]->minor=rtrim($this->yystack[$this->yyidx + 0]->minor); $this->_retvalue = array('operation' => 'comment', 'comment' => substr($this->yystack[$this->yyidx + 0]->minor, 0, strlen($this->yystack[$this->yyidx + 0]->minor)-2));     }
#line 1389 "parser.php"
#line 74 "parser.y"
    function yy_r6(){ $this->_retvalue = array('operation' => 'print_var', 'variable' => $this->yystack[$this->yyidx + -1]->minor);     }
#line 1392 "parser.php"
#line 76 "parser.y"
    function yy_r7(){ $this->_retvalue = array('operation' => 'base', $this->yystack[$this->yyidx + -1]->minor);     }
#line 1395 "parser.php"
#line 77 "parser.y"
    function yy_r8(){ $this->_retvalue = $this->yystack[$this->yyidx + -1]->minor;     }
#line 1398 "parser.php"
#line 84 "parser.y"
    function yy_r15(){ $this->_retvalue = array('operation' => 'include', $this->yystack[$this->yyidx + -1]->minor);     }
#line 1401 "parser.php"
#line 91 "parser.y"
    function yy_r18(){ $this->_retvalue = array('operation' => 'function', 'name' => $this->yystack[$this->yyidx + -1]->minor, 'list'=>array());     }
#line 1404 "parser.php"
#line 92 "parser.y"
    function yy_r19(){ $this->_retvalue = array('operation' => 'function', 'name' => $this->yystack[$this->yyidx + -3]->minor, 'for' => $this->yystack[$this->yyidx + -1]->minor, 'list' => array());     }
#line 1407 "parser.php"
#line 93 "parser.y"
    function yy_r20(){ $this->_retvalue = array('operation' => 'function', 'name' => $this->yystack[$this->yyidx + -5]->minor, 'for' => $this->yystack[$this->yyidx + -3]->minor, 'list' => array(),'as' => $this->yystack[$this->yyidx + -1]->minor);     }
#line 1410 "parser.php"
#line 94 "parser.y"
    function yy_r21(){ $this->_retvalue = array('operation' => 'function', 'name' => $this->yystack[$this->yyidx + -3]->minor, 'as' => $this->yystack[$this->yyidx + -1]->minor);     }
#line 1413 "parser.php"
#line 95 "parser.y"
    function yy_r22(){ $this->_retvalue = array('operation' => 'function', 'name' => $this->yystack[$this->yyidx + -2]->minor, 'list' => $this->yystack[$this->yyidx + -1]->minor);     }
#line 1416 "parser.php"
#line 96 "parser.y"
    function yy_r23(){ $this->_retvalue = array('operation' => 'function', 'name' => $this->yystack[$this->yyidx + -4]->minor, 'as' => $this->yystack[$this->yyidx + -1]->minor, 'list' => $this->yystack[$this->yyidx + -3]->minor);     }
#line 1419 "parser.php"
#line 99 "parser.y"
    function yy_r24(){ $this->_retvalue = array('operation' => 'alias', 'var' => $this->yystack[$this->yyidx + -7]->minor, 'as' => $this->yystack[$this->yyidx + -5]->minor, 'body' => $this->yystack[$this->yyidx + -3]->minor);     }
#line 1422 "parser.php"
#line 107 "parser.y"
    function yy_r28(){ 
    $this->_retvalue = array('operation' => 'loop', 'variable' => $this->yystack[$this->yyidx + -7]->minor, 'array' => $this->yystack[$this->yyidx + -5]->minor, 'body' => $this->yystack[$this->yyidx + -3]->minor); 
    }
#line 1427 "parser.php"
#line 110 "parser.y"
    function yy_r29(){ 
    $this->_retvalue = array('operation' => 'loop', 'variable' => $this->yystack[$this->yyidx + -7]->minor, 'array' => $this->yystack[$this->yyidx + -5]->minor, 'body' => $this->yystack[$this->yyidx + -3]->minor, 'index' => $this->yystack[$this->yyidx + -9]->minor); 
    }
#line 1432 "parser.php"
#line 113 "parser.y"
    function yy_r30(){ 
    $this->_retvalue = array('operation' => 'loop', 'variable' => $this->yystack[$this->yyidx + -11]->minor, 'array' => $this->yystack[$this->yyidx + -9]->minor, 'body' => $this->yystack[$this->yyidx + -7]->minor, 'empty' => $this->yystack[$this->yyidx + -3]->minor); 
    }
#line 1437 "parser.php"
#line 116 "parser.y"
    function yy_r31(){ 
    $this->_retvalue = array('operation' => 'loop', 'variable' => $this->yystack[$this->yyidx + -11]->minor, 'array' => $this->yystack[$this->yyidx + -9]->minor, 'body' => $this->yystack[$this->yyidx + -7]->minor, 'empty' => $this->yystack[$this->yyidx + -3]->minor, 'index' => $this->yystack[$this->yyidx + -13]->minor); 
    }
#line 1442 "parser.php"
#line 120 "parser.y"
    function yy_r32(){ $this->_retvalue = array('operation' => 'if', 'expr' => $this->yystack[$this->yyidx + -5]->minor, 'body' => $this->yystack[$this->yyidx + -3]->minor);     }
#line 1445 "parser.php"
#line 121 "parser.y"
    function yy_r33(){ $this->_retvalue = array('operation' => 'if', 'expr' => $this->yystack[$this->yyidx + -9]->minor, 'body' => $this->yystack[$this->yyidx + -7]->minor, 'else' => $this->yystack[$this->yyidx + -3]->minor);     }
#line 1448 "parser.php"
#line 124 "parser.y"
    function yy_r34(){ 
    $this->_retvalue = array('operation' => 'ifchanged', 'body' => $this->yystack[$this->yyidx + -3]->minor); 
    }
#line 1453 "parser.php"
#line 128 "parser.y"
    function yy_r35(){ 
    $this->_retvalue = array('operation' => 'ifchanged', 'body' => $this->yystack[$this->yyidx + -3]->minor, 'check' => $this->yystack[$this->yyidx + -5]->minor);
    }
#line 1458 "parser.php"
#line 131 "parser.y"
    function yy_r36(){ 
    $this->_retvalue = array('operation' => 'ifchanged', 'body' => $this->yystack[$this->yyidx + -7]->minor, 'else' => $this->yystack[$this->yyidx + -3]->minor); 
    }
#line 1463 "parser.php"
#line 135 "parser.y"
    function yy_r37(){ 
    $this->_retvalue = array('operation' => 'ifchanged', 'body' => $this->yystack[$this->yyidx + -7]->minor, 'check' => $this->yystack[$this->yyidx + -9]->minor, 'else' => $this->yystack[$this->yyidx + -3]->minor);
    }
#line 1468 "parser.php"
#line 140 "parser.y"
    function yy_r38(){ if ('end'.$this->yystack[$this->yyidx + -5]->minor != $this->yystack[$this->yyidx + -1]->minor) { throw new Exception("Unexpected ".$this->yystack[$this->yyidx + -1]->minor); } $this->_retvalue = array('operation' => 'filter', 'functions' =>array($this->yystack[$this->yyidx + -5]->minor), 'body' => $this->yystack[$this->yyidx + -3]->minor);    }
#line 1471 "parser.php"
#line 143 "parser.y"
    function yy_r39(){ $this->_retvalue = array('operation' => 'block', 'name' => $this->yystack[$this->yyidx + -5]->minor, 'body' => $this->yystack[$this->yyidx + -3]->minor);     }
#line 1474 "parser.php"
#line 145 "parser.y"
    function yy_r40(){ $this->_retvalue = array('operation' => 'block', 'name' => $this->yystack[$this->yyidx + -6]->minor, 'body' => $this->yystack[$this->yyidx + -4]->minor);     }
#line 1477 "parser.php"
#line 148 "parser.y"
    function yy_r41(){ $this->_retvalue = array('operation' => 'filter', 'functions' => $this->yystack[$this->yyidx + -5]->minor, 'body' => $this->yystack[$this->yyidx + -3]->minor);     }
#line 1480 "parser.php"
#line 151 "parser.y"
    function yy_r42(){ $this->_retvalue=array('operation' => 'regroup', 'array' => $this->yystack[$this->yyidx + -4]->minor, 'row' => $this->yystack[$this->yyidx + -2]->minor, 'as' => $this->yystack[$this->yyidx + 0]->minor);     }
#line 1483 "parser.php"
#line 154 "parser.y"
    function yy_r43(){ $this->_retvalue = array('operation' => 'cycle', 'vars' => $this->yystack[$this->yyidx + 0]->minor);     }
#line 1486 "parser.php"
#line 155 "parser.y"
    function yy_r44(){ $this->_retvalue = array('operation' => 'cycle', 'vars' => $this->yystack[$this->yyidx + -2]->minor, 'as' => $this->yystack[$this->yyidx + 0]->minor);     }
#line 1489 "parser.php"
#line 158 "parser.y"
    function yy_r45(){ $this->_retvalue = array('operation' => 'first_of', 'vars' => $this->yystack[$this->yyidx + 0]->minor);     }
#line 1492 "parser.php"
#line 162 "parser.y"
    function yy_r46(){ $this->_retvalue = $this->yystack[$this->yyidx + -2]->minor; $this->_retvalue[] = $this->yystack[$this->yyidx + 0]->minor;     }
#line 1495 "parser.php"
#line 163 "parser.y"
    function yy_r47(){ $this->_retvalue = array($this->yystack[$this->yyidx + 0]->minor);     }
#line 1498 "parser.php"
#line 165 "parser.y"
    function yy_r48(){ $this->_retvalue = array($this->yystack[$this->yyidx + -2]->minor, 'args'=>array($this->yystack[$this->yyidx + 0]->minor));     }
#line 1501 "parser.php"
#line 169 "parser.y"
    function yy_r50(){ $this->_retvalue = $this->yystack[$this->yyidx + -1]->minor; $this->_retvalue[] = $this->yystack[$this->yyidx + 0]->minor;     }
#line 1504 "parser.php"
#line 173 "parser.y"
    function yy_r53(){ $this->_retvalue = array('var' => $this->yystack[$this->yyidx + 0]->minor);     }
#line 1507 "parser.php"
#line 174 "parser.y"
    function yy_r54(){ $this->_retvalue = array('string' => $this->yystack[$this->yyidx + 0]->minor);     }
#line 1510 "parser.php"
#line 176 "parser.y"
    function yy_r55(){  $this->_retvalue = $this->yystack[$this->yyidx + -1]->minor;     }
#line 1513 "parser.php"
#line 178 "parser.y"
    function yy_r57(){ $this->_retvalue = $this->yystack[$this->yyidx + -1]->minor.$this->yystack[$this->yyidx + 0]->minor;     }
#line 1516 "parser.php"
#line 182 "parser.y"
    function yy_r59(){ $this->_retvalue = array('op' => @$this->yystack[$this->yyidx + -1]->minor, $this->yystack[$this->yyidx + -2]->minor, $this->yystack[$this->yyidx + 0]->minor);     }
#line 1519 "parser.php"
#line 185 "parser.y"
    function yy_r62(){ $this->_retvalue = array('op' => trim(@$this->yystack[$this->yyidx + -1]->minor), $this->yystack[$this->yyidx + -2]->minor, $this->yystack[$this->yyidx + 0]->minor);     }
#line 1522 "parser.php"
#line 187 "parser.y"
    function yy_r64(){$this->_retvalue = array('var_filter' => $this->yystack[$this->yyidx + 0]->minor);    }
#line 1525 "parser.php"
#line 188 "parser.y"
    function yy_r65(){ $this->_retvalue = array('op' => 'expr', $this->yystack[$this->yyidx + -1]->minor);     }
#line 1528 "parser.php"
#line 195 "parser.y"
    function yy_r68(){ if (!is_array($this->yystack[$this->yyidx + -2]->minor)) { $this->_retvalue = array($this->yystack[$this->yyidx + -2]->minor); } else { $this->_retvalue = $this->yystack[$this->yyidx + -2]->minor; }  $this->_retvalue[]=$this->yystack[$this->yyidx + 0]->minor;    }
#line 1531 "parser.php"
#line 196 "parser.y"
    function yy_r69(){ if (!is_array($this->yystack[$this->yyidx + -3]->minor)) { $this->_retvalue = array($this->yystack[$this->yyidx + -3]->minor); } else { $this->_retvalue = $this->yystack[$this->yyidx + -3]->minor; }  $this->_retvalue[]=$this->yystack[$this->yyidx + -1]->minor;    }
#line 1534 "parser.php"

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
#line 56 "parser.y"

    $expect = array();
    foreach ($this->yy_get_expected_tokens($yymajor) as $token) {
        $expect[] = self::$yyTokenName[$token];
    }
    throw new Exception('Unexpected ' . $this->tokenName($yymajor) . '(' . $TOKEN. '), expected one of: ' . implode(',', $expect));
#line 1654 "parser.php"
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
#line 44 "parser.y"

#line 1675 "parser.php"
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