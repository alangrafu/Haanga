<?php

class Haanga_CodeGenerator
{
    protected $ident;
    protected $tab = "    ";

    function __construct()
    {
    }

    function getCode($op_code)
    {
        $this->ident = 1;
        $code = "";
        foreach ($op_code as $op) {
            $method = "php_{$op[0]}";

            if (!is_callable(array($this, $method))) {
                throw new Exception("CodeGenerator: Missing method $method");
            }
            $code .= $this->ident();
            $code .= $this->$method($op);
        }
        return $code;
    }

    protected function php_else()
    {
        return "else";
    }

    protected function ident()
    {
        $code  = "\n";
        $code .= str_repeat($this->tab, $this->ident);

        return $code;
    }

    protected function php_ident($op)
    {
        $this->ident++;
        return "{";
    }

    protected function php_ident_end($op)
    {
        $this->ident--;
        
        return $this->ident()."}";
    }

    protected function php_print($op)
    {
        $code = "echo \"";
        $max  = count($op);
        for ($i=1; $i < $max; $i++) {
            if (is_string($op[$i])) {
                $code .= $op[$i];
            } else {
                $code .= '{$'.$op[$i]['var'].'}';
            }
        }
        return "$code\";";
    }

    protected function php_if($op)
    {
        unset($op[0]);
        $code  = "if (".implode(" ", $op).")";
        return $code;
    }


    protected function php_foreach($op)
    {
        $code = "foreach (\${$op[1]} as ";
        if (count($op) == 3) {
            $code .= " \${$op[2]}";
        } else {
            $code .= " \${$op[2]} => \${$op[3]}";
        }

        $code .= ")";
        return $code;
    }

    protected function php_declare($op)
    {
        $code = "\${$op[1]} = ";
        switch ($op[2]) {
        case 'array':
            $code .= "Array(";
            foreach ($op[3] as $value) {
                if (isset($value['string'])) {
                    $code .= $value['string'];
                } else if (isset($value['var'])) {
                    $code .= "\${$value['var']}";
                }
                $code .= ",";
            }
            $code .= ")";
            break;
        case 'php':
            $code .= $op[3];
            break;
        default:
            throw new Exception("Don't know how to declare {$op[2]}");
        }
        return $code.";";
    }
}