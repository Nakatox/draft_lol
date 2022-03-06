<?php

namespace Draftcli;

class CliPrinter
{
    public function out($message)
    {
        echo $message;
    }

    public function newSpace()
    {
        $this->out("\n");
    }


    public function newline()
    {
        $this->out("=======================================\n");
    }

    public function display($message)
    {   
        $this->newline();
        $this->newSpace();
        $this->newSpace();
        $this->out($message);
        $this->newSpace();
        $this->newSpace();
        $this->newSpace();
        $this->newline();
    }
}